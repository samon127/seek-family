<?php

namespace frontend\controllers;

use Yii;
use common\models\Time;
use common\models\Project;
use common\models\iProject;
use common\models\common\models;
use yii\widgets\ListView;
use common\tool\DBList;
use common\models\ProjectBonus;

class TimeController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $models = Time::find()
        ->joinWith('project', true, 'LEFT JOIN')
        ->joinWith('user', true, 'LEFT JOIN')
        ->orderBy('month DESC')
        ->all();


        return $this->render('index', ['models' => $models]);
    }

    public function actionEdit()
    {
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = ProjectBonus::find()->asArray()->where(['id' => $id])->one();
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

    	$userProjectTimes = iProject::getProject();

        foreach (range(1,12) as $month)
    	{
    		$month = $month>9 ? '2015-'.$month : '2015-0'.$month;

    		$monthArray[] = $month;
    	}

    	$projectArray = iProject::getAreaProject();


        return $this->render('show', ['user_id'=>$user_id, 'userProjectTimes'=>$userProjectTimes, 'monthArray'=>$monthArray, 'projectArray'=>$projectArray]);
    }

	public function actionSubmit()
    {
    	$data = Yii::$app->getRequest()->post('time');

    	foreach ($data as $user=>$subData)
    	{
    		foreach ($subData as $month=>$subsubData)
    		{
    		    $model = Time::deleteAll(['user_id'=>$user, 'month'=>$month]);

    			foreach ($subsubData as $project=>$time_percent)
    			{
			        $model = new Time;

			        $model->user_id = $user;
			        $model->month = $month;
			        $model->project_id = $project;
			        $model->percent = $time_percent;

			        $model->save();
    			}
    		}
    	}

    	return $this->redirect(['time/edit', 'user_id'=>$user]);
    }
}





