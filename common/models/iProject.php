<?php

namespace common\models;

use Yii;
use common\models\Project;


class iProject extends Project
{
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
            ->orderBy('date_start')
            ->all();
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
        ->via('projectOwners');
    }

    public function getPays()
    {
        return $this->hasMany(iPay::className(), ['id' => 'pay_id'])
        ->via('payProjects');
    }

}
