<?php

namespace frontend\controllers;

use Yii;
use common\models\Time;
use common\models\Project;
use common\models\iProject;
use common\models\common\models;
use yii\widgets\ListView;
use common\tool\DBList;
use common\models\User;
use common\models\ProjectTarget;

class TargetController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $pid = Yii::$app->getRequest()->get('pid');

        $targets = ProjectTarget::find()->where(['project_id'=>$pid])->all();

        return $this->render('index', ['targets'=>$targets]);
    }

	public function actionEdit()
    {
        $pid = Yii::$app->getRequest()->get('pid');

        $users = User::find()->all();

        $defaultValue = User::find()
        ->asArray()
        ->joinWith('projectTargets', true, 'LEFT JOIN')
        ->where(['project_id'=>$pid])
        ->all();

        // 这里需要去看Gllue的数据结构，然后把需要的数据查询出来

        // 顶部的另一个地方显示每个人预期的人数（很直观的显示差距）

        // 根据每个人的结果可以看投入产出比

        // 需要在Gllue中加了人以后，有合理的方式可以体现出每个加入项目中的人的“价格”！

        return $this->render('edit', ['users'=>$users, 'defaultValue' => $defaultValue]);

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

    	$data = Yii::$app->getRequest()->post('target');
    	$pid = Yii::$app->getRequest()->post('pid');

    	foreach ($data as $userId=>$userData)
    	{
    	    if ($userData['people_target'])
    	    {
    	        $model = new ProjectTarget();

    	        $model->project_id = $pid;
    	        $model->user_id = $userId;
    	        $model->people_target = $userData['people_target'];
    	        $model->revenue_target = $userData['revenue_target'];

    	        $model->save();
    	    }

    	}

    	return $this->redirect(['target/index', 'pid'=>$pid]);
    }

}
