<?php

namespace frontend\controllers;

use Yii;
use common\models\Time;
use common\models\Project;
use common\models\iProject;
use common\models\common\models;

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
    	$times = Time::find()->asArray()->indexBy('id')->where(['user_id' => $user_id])->all();
    	
    	$projects = iProject::getProject();

    	
//     	foreach ($projects as $project)
//     	{
    		
//     	}
    	
    	
    	foreach ($projects as $project)
    	{
    	    foreach ($project->times as $time)
    	    {
    	        $touchedArea[$time->project_id.'-'.$time->month] = $time->project_id.'-'.$time->month;
    	    }
    	}

    	foreach (array(2,5,6) as $project_id)
    	{
	    	foreach (range(1,12) as $month)
	    	{
	    		$month = $month>9 ? '2015-'.$month : '2015-0'.$month;
	    		
	    		if (isset($touchedArea[$project_id.'-'.$month]))
	    		{
	    			
	    		}
	    		else 
	    		{
	    			$time = new Time();
	    			$time->project_id = $project_id;
	    			$time->month = $month;
	    			$time->percent = '';
	    			$time->user_id = $user_id;
	    			
	    			$project = new iProject();
	    			$project->times = $time;
	    			$project->id = $project_id;
	    			$projects[] = $project;
	    			
	    			// 扩充一个object的路走不通
	    		}
	    		
	    		
	    		
// 	    		if ($month>9)
// 	    		{
// 	    			$tableRange[$project_id]['2015-'.$month] = '2015-'.$month;
// 	    		}
// 	    		else {
// 	    			$tableRange[$project_id]['2015-0'.$month] = '2015-0'.$month;
// 	    		}
	    		
	    		
	    		
	    	}
    	}

    	
    	print_r($projects);exit;
    	
    	
//     	foreach ($times as $time)
//     	{
//     		$data[$time['user_id']][$time['project_id']][$time['month']] = $time['percent'];
//     	}
    	
        return $this->render('edit', ['user_id'=>$user_id, 'projects'=>$projects]);
    }
    
	public function actionSubmit()
    {
    	$data = Yii::$app->getRequest()->post('time');
    	
    	foreach ($data as $user=>$subData)
    	{
    		foreach ($subData as $project=>$subsubData)
    		{
    			foreach ($subsubData as $month=>$time_percent)
    			{
    				$model = Time::find()->where(['user_id'=>$user, 'month'=>$month, 'project_id'=>$project])->one();
    			
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
