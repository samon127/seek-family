<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\iIncome;
use common\models\iPay;
use common\models\Pay;
use common\tool\DBList;
use common\models\GllueClient;

class RevenueController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionDaily()
    {
        $date_start = Yii::$app->getRequest()->get('date_start');
        $date_end = Yii::$app->getRequest()->get('date_end');

        if (!$date_start && !$date_end)
        {
            $date_end = date('Y-m-d 00:00:00', time() + 60*60*24*30*2); // 2个月内
            $date_start = date('Y-m-d 00:00:00', time() - 60*60*24*30*4); // 4个月前
        }

        $incomes = iIncome::find()
        ->select(['SUM(number) AS incomeSum, income_date'])
        ->where(['>=', 'income_date', $date_start])
        ->andWhere(['<=', 'income_date', $date_end])
        ->groupBy(['income_date'])
        ->all();

        $pays = iPay::find()
        ->select(['SUM(number) AS paySum, pay_date'])
        ->where(['>=', 'pay_date', $date_start])
        ->andWhere(['<=', 'pay_date', $date_end])
        ->groupBy(['pay_date'])
        ->all();

        $dateRange = [];


        return $this->render('daily', ['incomes'=>$incomes, 'pays'=>$pays, 'date_end'=>$date_end, 'date_start'=>$date_start]);
    }

    public function actionIncomeDetail()
    {
        $date_start = Yii::$app->getRequest()->get('date_start');
        $date_end = Yii::$app->getRequest()->get('date_end');

        if (!$date_start && !$date_end)
        {
            $date_end = date('Y-m-d 00:00:00', time());
            $date_start = date('Y-m-d 00:00:00', time() - 60*60*24*30); // 30天内
        }

        $incomes = iIncome::find()
        ->where(['>=', 'income_date', $date_start])
        ->andWhere(['<=', 'income_date', $date_end])
        ->joinWith('project', true, 'LEFT JOIN')
        ->joinWith('project.type', true, 'LEFT JOIN')
        ->joinWith('project.teacher', true, 'LEFT JOIN')
        ->joinWith('project.city', true, 'LEFT JOIN')
        ->orderBy('income_date')
        ->all();

        $ids = [];
        foreach ($incomes as $income)
        {
            $ids[] = $income->client_id;
        }

        $clients = GllueClient::find()->where(['in', 'id', $ids])->all();

        return $this->render('incomeDaily', ['incomes'=>$incomes, 'clients'=>$clients, 'date_end'=>$date_end, 'date_start'=>$date_start]);
    }

    public function actionPayDetail()
    {
        $date_start = Yii::$app->getRequest()->get('date_start');
        $date_end = Yii::$app->getRequest()->get('date_end');

        if (!$date_start && !$date_end)
        {
            $date_end = date('Y-m-d 00:00:00', time());
            $date_start = date('Y-m-d 00:00:00', time() - 60*60*24*30); // 30天内
        }

        $pays = iPay::find()
        ->where(['>=', 'pay_date', $date_start])
        ->andWhere(['<=', 'pay_date', $date_end])
        ->joinWith('type', true, 'LEFT JOIN')
        ->joinWith('projects', true, 'LEFT JOIN')
        ->joinWith('projects.type', true, 'LEFT JOIN')
        ->joinWith('projects.teacher', true, 'LEFT JOIN')
        ->joinWith('projects.city', true, 'LEFT JOIN')
        ->orderBy('pay.pay_date')
        ->all();



        return $this->render('payDaily', ['pays'=>$pays, 'date_end'=>$date_end, 'date_start'=>$date_start]);
    }

}
