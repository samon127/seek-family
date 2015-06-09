<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\Income;

class IncomeController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $pid = Yii::$app->getRequest()->get('pid');

        $incomes = Income::find()
        ->where(['project_id'=>$pid])
        ->joinWith('project', true, 'LEFT JOIN')
        ->joinWith('project.type', true, 'LEFT JOIN')
        ->joinWith('project.teacher', true, 'LEFT JOIN')
        ->joinWith('project.city', true, 'LEFT JOIN')
        ->orderBy('income.income_date')
        ->all();

        return $this->render('index', array('defaultValue' => '', 'incomes' => $incomes));
    }

    public function actionEdit()
    {
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = Income::find()->asArray()->where(['id' => $id])->one();
        }
        else
        {
            $defaultValue = [];
        }

        $projects = Project::find()
            ->joinWith('type', true, 'LEFT JOIN')
            ->joinWith('teacher', true, 'LEFT JOIN')
            ->joinWith('city', true, 'LEFT JOIN')
            ->all();

        return $this->render('edit', array('defaultValue' => $defaultValue, 'projects' => $projects));
    }

    public function actionSubmit()
    {

        $data = Yii::$app->getRequest()->post('income');
//print_r($data);exit;
        if (isset($data['id']) && $data['id'])
        {
            $model = Income::find()->where(['id' => $data['id']])->one();
        }
        else
        {
            $model = new Income();
        }

        $model->type = $data['type'];
        $model->project_id = $data['project'];
        $model->client_id = $data['client'];
        $model->number = str_replace(',', '', $data['money']);
        $model->card = $data['card'];
        $model->income_date = $data['date'];
        $model->invoice = $data['invoice'];

        $model->save();

        //print_r($model);exit;

        return $this->redirect(['income/index']);
    }

}
