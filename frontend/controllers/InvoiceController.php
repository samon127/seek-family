<?php

namespace frontend\controllers;

use Yii;
use common\models\Income;


class InvoiceController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $searchKeyWord = Yii::$app->getRequest()->get('invoice');

        $incomes = [];

        if (isset($searchKeyWord['start_number']) && $searchKeyWord['start_number'])
        {
            if (isset($searchKeyWord['end_number']) && $searchKeyWord['end_number'])
            {
                $model = Income::find();
                $model->andWhere(['>=','invoice_code',$searchKeyWord['start_number']]);
                $model->andWhere(['<=','invoice_code',$searchKeyWord['end_number']]);
                $incomes = $model
                    ->joinWith('bd', true, 'LEFT JOIN')
                    ->joinWith('project', true, 'LEFT JOIN')
                    ->joinWith('project.type', true, 'LEFT JOIN')
                    ->joinWith('project.teacher', true, 'LEFT JOIN')
                    ->joinWith('project.city', true, 'LEFT JOIN')
                    ->joinWith('account', true, 'LEFT JOIN')
                    ->orderBy('income.invoice_code')
                    ->all();
            }
        }

        return $this->render('index', ['defaultValue'=>$searchKeyWord, 'incomes'=>$incomes]);
    }

}
