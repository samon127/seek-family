<?php

namespace common\models;

use Yii;
use common\models\Project;


class iProject extends Project
{
	public $times;

    public static function getProject()
    {
        $user_id = Yii::$app->getRequest()->get('user_id');

        return Project::find()
				->joinWith('type', true, 'LEFT JOIN')
				->joinWith('teacher', true, 'LEFT JOIN')
				->joinWith('city', true, 'LEFT JOIN')
				->joinWith(['times'=>function($query){
				    $user_id = Yii::$app->getRequest()->get('user_id');
				    $query->andWhere(['=', 'user_id', $user_id]);
				}])
    	        ->all();
    }

    public static function getAreaProject()
    {
        return Project::find()
            ->joinWith('type', true, 'LEFT JOIN')
            ->joinWith('teacher', true, 'LEFT JOIN')
            ->joinWith('city', true, 'LEFT JOIN')
            ->joinWith('times', true, 'LEFT JOIN')
            ->all();
    }

}
