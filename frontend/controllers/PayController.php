<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\Pay;
use common\tool\DBList;

class PayController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $pays = Pay::find()
        ->joinWith('type', true, 'LEFT JOIN')
        ->joinWith('project', true, 'LEFT JOIN')
        ->joinWith('project.type', true, 'LEFT JOIN')
        ->joinWith('project.teacher', true, 'LEFT JOIN')
        ->joinWith('project.city', true, 'LEFT JOIN')
        ->all();

        return $this->render('index', ['pays'=>$pays]);
    }

    public function actionEdit()
    {
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = Pay::find()->asArray()->where(['id' => $id])->one();
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

        $payTypes = DBList::getPayType();

        return $this->render('edit', array('defaultValue' => $defaultValue, 'projects' => $projects, 'payTypes'=>$payTypes));
    }

    public function actionSubmit()
    {

        $data = Yii::$app->getRequest()->post('pay');
        //print_r($data);exit;
        if (isset($data['id']) && $data['id'])
        {
            $model = Pay::find()->where(['id' => $data['id']])->one();
        }
        else
        {
            $model = new Pay();
        }

        $model->type_id = $data['type'];
        $model->project_id = $data['project'];
        $model->number = str_replace(',', '', $data['money']);
        $model->pay_date = $data['date'];
        $model->comment = $data['comment'];

        $model->save();

        return $this->redirect(['pay/index']);
    }
}
