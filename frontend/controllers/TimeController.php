<?php

namespace frontend\controllers;

use Yii;
use common\models\Time;
use common\models\Project;
use common\models\iProject;
use common\models\common\models;
use yii\widgets\ListView;
use common\tool\DBList;
use common\tool\Family;

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
            $defaultValue = Time::find()->asArray()->where(['id' => $id])->one();
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
// Array ( [project] => 105 [user_id] => 2 [date] => 2016-01 [percent] => 11 )
    	if (isset($data['id']) && $data['id'])
    	{
    	    $model = Time::find()->where(['id' => $data['id']])->one();
    	}
    	else
    	{
    	    $model = new Time();
    	}

    	$model->user_id = $data['user_id'];
        $model->month = $data['month'];;
        $model->project_id = $data['project'];
        $model->percent = $data['percent'];;
    	$model->save();

    	return $this->redirect(['time/edit']);
    }

    public function actionDelete()
    {
        $id = Yii::$app->getRequest()->get('id');

        $model = Time::find()->where(['id' => $id])->one();
        $model->delete();

        return $this->redirect(['time/index']);
    }

    public function actionTable()
    {
        $models = Project::find()
        ->joinWith('times', true, 'LEFT JOIN')
        ->joinWith('times.user', true, 'LEFT JOIN')
        ->all();

        $ids = [];
        foreach ($models as $model)
        {
            $ids[] = $model->client_id;
        }

        $data = [];

        foreach ($models as $model) {
            foreach ($model->times as $time) {
                $month = $time->month;
                // 数组结构初始化
                $data[$month]['userIds'] = isset($data[$month]['userIds']) ? $data[$month]['userIds'] : [];
                $data[$month]['userNames'] = isset($data[$month]['userNames']) ? $data[$month]['userNames'] : [];
                $data[$month]['projects'] = isset($data[$month]['projects']) ? $data[$month]['projects'] : [];
            }


            // 设置数组中的 userIds 和 userNames
            foreach ($model->times as $time) {
                $month = $time->month;
                if (!in_array($time->user_id, $data[$month]['userIds'])) {
                    array_push($data[$month]['userIds'], $time->user_id);
                    array_push($data[$month]['userNames'], $time->user->english);
                }
            }
        }

        foreach ($models as $model) {
            foreach ($model->times as $time) {
                $month = $time->month;
                // 设置数组中的 projects，下面的这个 foreach 是为了获取 $percent 的值，对于一个跳空的 userId 填空（0值），否则会在循环的时候打乱Table的显示次序
                foreach ($data[$month]['userIds'] as $userId)
                {
                    $percent = 0;
                    foreach ($model->times as $time)
                    {
                        if ($time->user_id == $userId && $time->month == $month)
                        {
                            $percent = $time->percent;
                        }
                    }

                    $data[$month]['projects'][Family::getProjectName($model, $ids)][$userId] = $percent;
                }
            }
        }
        krsort($data);

        return $this->render('table', ['data' => $data]);
    }
}





