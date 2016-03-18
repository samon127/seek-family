<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Project;
use common\models\iProject;
use common\models\common\models;
use yii\widgets\ListView;
use common\tool\DBList;
use common\tool\Family;

class UserController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $models = User::find()

        ->all();


        return $this->render('index', ['models' => $models]);
    }

    public function actionEdit()
    {
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = User::find()->asArray()->where(['id' => $id])->one();
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

    	$userProjectUsers = iProject::getProject();

        foreach (range(1,12) as $month)
    	{
    		$month = $month>9 ? '2015-'.$month : '2015-0'.$month;

    		$monthArray[] = $month;
    	}

    	$projectArray = iProject::getAreaProject();

        return $this->render('show', ['user_id'=>$user_id, 'userProjectUsers'=>$userProjectUsers, 'monthArray'=>$monthArray, 'projectArray'=>$projectArray]);
    }

	public function actionSubmit()
    {
    	$data = Yii::$app->getRequest()->post('user');

    	if (isset($data['id']) && $data['id'])
    	{
    	    $model = User::find()->where(['id' => $data['id']])->one();
    	}
    	else
    	{
    	    $model = new User();
    	}

    	$model->gllue_id = $data['gllue_id'];
        $model->name = $data['name'];
        $model->key = $data['key'];
        $model->english = $data['english'];
        $model->username = $data['username'];
    	$model->save();

    	return $this->redirect(['user/index']);
    }

    public function actionDelete()
    {
        $id = Yii::$app->getRequest()->get('id');

        $model = User::find()->where(['id' => $id])->one();
        $model->delete();

        return $this->redirect(['user-balance/index']);
    }
}





