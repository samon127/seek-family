<?php
namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\iProject;
use common\models\ProjectBonus;

class BonusController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionList()
    {
        $projects = iProject::find()
        ->with('projectBonuses')
        ->orderBy('date_start DESC')
        ->where(['>=', 'date_start', '2015-08-01'])
        ->all();

        $users = array(
            1 => 'Ivy',
            2 => 'Michael',
            3=> 'Caroline',
            4=> 'Helen',
            5=> 'Scarlet',
            6=> 'Lynn',
            9=> 'Dyson',
            10=> 'Aaron',
            11=> 'Jamie',
            12=> 'Chris',
        );

        return $this->render('list', ['projects'=>$projects, 'users'=>$users]);
    }

    public function actionIndex()
    {
        $models = ProjectBonus::find()
        ->joinWith('project', true, 'LEFT JOIN')
        ->joinWith('user', true, 'LEFT JOIN')
        ->orderBy('project.date_start DESC')
        ->all();


        return $this->render('index', ['models' => $models]);
    }

    public function actionEdit()
    {
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = ProjectBonus::find()->asArray()->where(['id' => $id])->one();
        }
        else
        {
            $defaultValue = [];
        }


        return $this->render('edit', ['defaultValue' => $defaultValue]);
    }

    public function actionSubmit()
    {
        $data = Yii::$app->getRequest()->post('bonus');

        if (isset($data['id']) && $data['id'])
        {
            $model = ProjectBonus::find()->where(['id' => $data['id']])->one();
        }
        else
        {
            $model = new ProjectBonus();
        }

        $model->project_id = $data['project'];
        $model->user_id = $data['user_id'];
        $model->part = $data['part'];
        $model->save();

        return $this->redirect(['bonus/edit']);
    }

    public function actionDelete()
    {
        $id = Yii::$app->getRequest()->get('id');

        $model = ProjectBonus::find()->where(['id' => $id])->one();
        $model->delete();

        return $this->redirect(['bonus/index']);
    }

}