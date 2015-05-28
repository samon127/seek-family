<?php
namespace common\tool;

use common\models\Project;
use common\models\ProjectType;
use common\models\Teacher;

class DBList
{
	public static function getProjectType()
	{
		return ProjectType::find()->asArray()->indexBy('id')->where([])->all();
	}
	
	public static function getTeacher()
	{
		return Teacher::find()->asArray()->indexBy('id')->where([])->all();
	}
}
