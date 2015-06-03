<?php
namespace common\tool;

use common\models\Project;
use common\models\ProjectType;
use common\models\Teacher;
use common\models\ProjectCity;
use common\models\PayType;

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

	public static function getCity()
	{
	    return ProjectCity::find()->asArray()->indexBy('id')->where([])->all();
	}

	public static function getPayType()
	{
	    return PayType::find()->asArray()->indexBy('id')->where([])->all();
	}

}
