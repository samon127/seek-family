<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\ProjectType;

class ProjectTypeController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $types = ProjectType::find()->all();

        return $this->render('index', ['types'=>$types]);
    }

    public function actionEdit()
    {
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = ProjectType::find()->asArray()->where(['id' => $id])->one();
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
            $model = ProjectType::find()->where(['id' => $data['id']])->one();
        }
        else
        {
            $model = new ProjectType();
        }

        $model->key = $data['key'];
        $model->name = $data['name'];

        $model->save();

        return $this->redirect(['index']);
    }

    public function actionDelete()
    {
        $id = Yii::$app->getRequest()->get('id');

        $model = ProjectType::find()->where(['id' => $id])->one();

        if (Project::find()->where(['type_id' => $id])->one())
        {
            echo '对不起，有在使用中的项目类型数据，所以无法被删除！';
            exit;
        }
        else {
            $model->delete();
        }

        return $this->redirect(['index']);

    }

}
