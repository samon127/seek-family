<?php
namespace common\tool;

use common\models\GllueClient;
use common\models\ProjectType;
use common\models\Teacher;
use common\models\GllueJoborder;

class Gllue
{
	public static function getClientById($id)
	{
		return GllueClient::find()->asArray()->where(['id' => $id])->one();
	}

	public static function getProjectNameById($id)
	{
	    return GllueJoborder::find()->asArray()->where(['id' => $id])->one();
	}
}
