<?php

namespace frontend\controllers;

use Yii;
use common\models\Income;
use common\models\IncomeAccount;

class IncomeAccountController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $types = IncomeAccount::find()->all();

        return $this->render('index', ['types'=>$types]);
    }

    public function actionEdit()
    {
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = IncomeAccount::find()->asArray()->where(['id' => $id])->one();
        }
        else
        {
            $defaultValue = [];
        }

        return $this->render('edit', ['defaultValue' => $defaultValue]);
    }

    public function actionSubmit()
    {
        $data = Yii::$app->getRequest()->post('type');

        if (isset($data['id']) && $data['id'])
        {
            $model = IncomeAccount::find()->where(['id' => $data['id']])->one();
        }
        else
        {
            $model = new IncomeAccount();
        }

        $model->name = $data['name'];

        $model->save();

        return $this->redirect(['index']);
    }

    public function actionDelete()
    {
        $id = Yii::$app->getRequest()->get('id');

        $model = IncomeAccount::find()->where(['id' => $id])->one();

        if (Income::find()->where(['account_id' => $id])->one())
        {
            echo '对不起，有在使用中的收入来源数据，所以无法被删除！';
            exit;
        }
        else {
            $model->delete();
        }

        return $this->redirect(['index']);

    }

}
