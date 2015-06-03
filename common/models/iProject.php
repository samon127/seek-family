<?php

namespace common\models;

use Yii;
use common\models\Project;


class iProject extends Project
{
	public $times;
	
    public static function getProject()
    {
        return Project::find()
				->joinWith('type', true, 'LEFT JOIN')
				->joinWith('teacher', true, 'LEFT JOIN')
				->joinWith('city', true, 'LEFT JOIN')
				->joinWith('times', true, 'LEFT JOIN')
    	        ->all();
    }

}
