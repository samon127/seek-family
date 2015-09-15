<?php
namespace frontend\controllers;

use common\models\GllueClient;
use common\models\GllueCity;
use yii\web\Controller;


class ClientassignController extends Controller
{
    public function actionIndex()
    {
        $model = GllueClient::find()->asArray()->all();
        $cities = GllueCity::find()->asArray()->all();
        return $this->render('index',array('model' => $model , 'cities' => $cities));
    }
}

