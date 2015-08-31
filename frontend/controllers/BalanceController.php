<?php
namespace frontend\controllers;

use common\models\UserBalance;
use common\models\iUserBalance;
use yii\web\controller;

class BalanceController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}