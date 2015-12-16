<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\iPay;
use common\models\Pay;
use common\tool\DBList;

class PayController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $pid = Yii::$app->getRequest()->get('pid');

        $pays = iPay::find()
        ->where(['project_id'=>$pid])
        ->orderBy('pay.pay_date')
        ->joinWith('type', true, 'LEFT JOIN')
        ->joinWith('projects', true, 'LEFT JOIN')
        ->joinWith('projects.type', true, 'LEFT JOIN')
        ->joinWith('projects.teacher', true, 'LEFT JOIN')
        ->joinWith('projects.city', true, 'LEFT JOIN')
        ->all();

        return $this->render('index', ['pays'=>$pays]);
    }

    public function actionEdit()
    {
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = iPay::find()->with('projects')->asArray()->where(['id' => $id])->one();
        }
        else {
            $defaultValue = [];
        }



        $payTypes = DBList::getPayType();

        return $this->render('edit', array('defaultValue' => $defaultValue, 'payTypes'=>$payTypes));
    }
    public function actionSearch()
    {
        $searchKeyWord = Yii::$app->getRequest()->get('s');
        if ($searchKeyWord) {
            $model = iPay::find();

            if ($searchKeyWord['date_start']) {
                $model->andWhere(['>=', 'pay_date', $searchKeyWord['date_start']]);
            }

            if ($searchKeyWord['date_end']) {
                $model->andWhere(['<=', 'pay_date', $searchKeyWord['date_end']]);
            }

            if(Isset ($searchKeyWord['comment']) && $searchKeyWord['comment'])
            {
                $model->andwhere(array('LIKE','pay.comment',$searchKeyWord['comment']));
            }

            $pays = $model
                ->joinWith('type', true, 'LEFT JOIN')
                ->joinWith('projects', true, 'LEFT JOIN')
                ->joinWith('projects.type', true, 'LEFT JOIN')
                ->joinWith('projects.teacher', true, 'LEFT JOIN')
                ->joinWith('projects.city', true, 'LEFT JOIN')
                ->orderBy('pay.pay_date')
                ->all();
        }
        else{
            $pays = [];
        }

        return $this->render('search', ['pays'=>$pays,'defaultValue'=>$searchKeyWord]);

    }
    public function actionSubmit()
    {

        $data = Yii::$app->getRequest()->post('pay');
        $pid = Yii::$app->getRequest()->post('pid');

        if (isset($data['id']) && $data['id'])
        {
            $model = iPay::find()->with('projects')->where(['id'=>$data['id']])->one(); // one的话是否会只删除第一条，有时间看看这个问题

            if ($data['category'] == 2) // 项目支出
            {
                $model->unlinkAll('projects', true);
            }

        }
        else
        {
            $model = new iPay();
        }

        $model->category = $data['category'];
        $model->type_id = $data['type'];
        $model->number = str_replace(',', '', $data['money']);
        $model->pay_date = $data['date'];
        $model->comment = $data['comment'];

        $model->save();


        if ($data['category'] == 2) // 项目支出
        {
            foreach ($data['project'] as $projectId)
            {
                $project = Project::findOne($projectId);

                $model->link('projects', $project);

                //print_r($model);exit;
            }
        }

        if ($pid)
        {
            return $this->redirect(['pay/index', 'pid'=>$pid]);
        }
        else {
            return $this->redirect(['pay/edit']);
        }

    }



    public function actionDelete()
    {
        $id = Yii::$app->getRequest()->get('id');
        $pid = Yii::$app->getRequest()->get('pid');


        $model = Pay::find()->where(['id' => $id])->one();
        $model->delete();

        return $this->redirect(['pay/index', 'pid'=>$pid]);

    }
}
