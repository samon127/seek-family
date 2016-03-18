<?php
namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\iProject;
use common\models\ProjectBonus;
use common\tool\Family;

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

    public function actionTable()
    {
        $models = ProjectBonus::find()
        ->joinWith('project', true, 'LEFT JOIN')
        ->joinWith('user', true, 'LEFT JOIN')
        ->orderBy('project.date_start DESC')
        ->all();

        $ids = [];
        foreach ($models as $model)
        {
            $ids[] = $model->project->client_id;
        }

        $data = [];

        foreach ($models as $model)
        {
            $month = substr($model->project->date_start, 0, 7);
            // 数组结构初始化
            $data[$month]['userIds'] = isset($data[$month]['userIds']) ? $data[$month]['userIds'] : [];
            $data[$month]['userNames'] = isset($data[$month]['userNames']) ? $data[$month]['userNames'] : [];
            $data[$month]['projects'] = isset($data[$month]['projects']) ? $data[$month]['projects'] : [];

            // 设置数组中的 userIds 和 userNames
            if (!in_array($model->user_id, $data[$month]['userIds'])) {
                array_push($data[$month]['userIds'], $model->user_id);
                array_push($data[$month]['userNames'], $model->user->english);
            }
        }

        foreach ($models as $model) {
            $month = substr($model->project->date_start, 0, 7);

            // 设置数组中的 projects，下面的这个 foreach 是为了获取 $percent 的值，对于一个跳空的 userId 填空（0值），否则会在循环的时候打乱Table的显示次序
            foreach ($data[$month]['userIds'] as $userId)
            {
                $data[$month]['projects'][Family::getProjectName($model->project, $ids)][$userId] = 0;
                if ($model->user_id == $userId) {
                    $percent = $model->part;
                    $data[$month]['projects'][Family::getProjectName($model->project, $ids)][$userId] = substr($percent, 0, strlen($percent) - 1);
                }
            }
        }
        krsort($data);

        print_r($data);exit;

        return $this->render('table', ['data' => $data]);
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