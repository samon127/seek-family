<?php
namespace common\tool;

use common\models\GllueClient;
use common\models\ProjectType;
use common\models\Teacher;

class Gllue
{
	public static function getClientById($id)
	{
		return GllueClient::find()->asArray()->where(['id' => $id])->one();
	}
}
