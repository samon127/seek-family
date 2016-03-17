<?php

namespace frontend\controllers;

use Yii;
use common\models\UserBalance;
use common\models\Project;
use common\models\iProject;
use common\models\common\models;
use yii\widgets\ListView;
use common\tool\DBList;
use common\tool\Family;

class UserBalanceController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $models = UserBalance::find()
        ->joinWith('user', true, 'LEFT JOIN')
        ->orderBy('month DESC')
        ->all();


        return $this->render('index', ['models' => $models]);
    }

    public function actionEdit()
    {
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = UserBalance::find()->asArray()->where(['id' => $id])->one();
        }
        else
        {
            $defaultValue = [];
        }


        return $this->render('edit', ['defaultValue' => $defaultValue]);
    }

	public function actionShow()
    {
    	$user_id = Yii::$app->getRequest()->get('user_id');

    	if (!$user_id)
    	{
    	    $users = DBList::getUser();
    	    return $this->render('user_choose', ['users'=>$users]);
    	}

    	$userProjectUserBalances = iProject::getProject();

        foreach (range(1,12) as $month)
    	{
    		$month = $month>9 ? '2015-'.$month : '2015-0'.$month;

    		$monthArray[] = $month;
    	}

    	$projectArray = iProject::getAreaProject();

        return $this->render('show', ['user_id'=>$user_id, 'userProjectUserBalances'=>$userProjectUserBalances, 'monthArray'=>$monthArray, 'projectArray'=>$projectArray]);
    }

	public function actionSubmit()
    {
    	$data = Yii::$app->getRequest()->post('user-balance');

    	if (isset($data['id']) && $data['id'])
    	{
    	    $model = UserBalance::find()->where(['id' => $data['id']])->one();
    	}
    	else
    	{
    	    $model = new UserBalance();
    	}

    	$model->user_id = $data['user_id'];
        $model->month = $data['month'];;
        $model->balance = $data['balance'];;
    	$model->save();

    	return $this->redirect(['user-balance/index']);
    }

    public function actionDelete()
    {
        $id = Yii::$app->getRequest()->get('id');

        $model = UserBalance::find()->where(['id' => $id])->one();
        $model->delete();

        return $this->redirect(['user-balance/index']);
    }
}





