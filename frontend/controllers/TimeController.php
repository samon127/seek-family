<?php

namespace frontend\controllers;

use Yii;
use common\models\Time;
use common\models\Project;
use common\models\iProject;
use common\models\common\models;
use yii\widgets\ListView;
use common\tool\DBList;

class TimeController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

	public function actionEdit()
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


        return $this->render('edit', ['user_id'=>$user_id, 'userProjectTimes'=>$userProjectTimes, 'monthArray'=>$monthArray, 'projectArray'=>$projectArray]);
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




INSERT INTO `family`.`time` (`id`, `project_id`, `month`, `user_id`, `percent`) VALUES (NULL, '124', '2016-01', '2', '40');
INSERT INTO `family`.`time` (`id`, `project_id`, `month`, `user_id`, `percent`) VALUES (NULL, '124', '2016-01', '4', '40');
INSERT INTO `family`.`time` (`id`, `project_id`, `month`, `user_id`, `percent`) VALUES (NULL, '124', '2016-01', '11', '40');

