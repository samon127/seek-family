<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\Income;
use common\models\iPay;
use common\models\Pay;
use common\tool\DBList;

class RevinueController extends \yii\web\Controller
{

    public function actionDaily()
    {
        $incomes = Income::find()
        //->select('number')
        ->joinWith('project', true, 'LEFT JOIN')
        ->joinWith('project.type', true, 'LEFT JOIN')
        ->joinWith('project.teacher', true, 'LEFT JOIN')
        ->joinWith('project.city', true, 'LEFT JOIN')
        ->orderBy('income.income_date')
        ->groupBy(['income_date'])
        ->all()->sum('number'); // 怎么用SUM？
print_r($incomes);exit;
        $pays = iPay::find()
        ->joinWith('type', true, 'LEFT JOIN')
        ->joinWith('projects', true, 'LEFT JOIN')
        ->joinWith('projects.type', true, 'LEFT JOIN')
        ->joinWith('projects.teacher', true, 'LEFT JOIN')
        ->joinWith('projects.city', true, 'LEFT JOIN')
        ->orderBy('pay.pay_date')
        ->groupBy(['pay_date'])
        ->all();

        return $this->render('daily', ['incomes'=>$incomes, 'pays'=>$pays]);
    }

}
