<?php

namespace frontend\controllers;

use Yii;
use common\models\Teacher;
use common\models\Project;

class TeacherController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $teachers = Teacher::find()->all();

        return $this->render('index', ['teachers'=>$teachers]);
    }

    public function actionEdit()
    {
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = Teacher::find()->asArray()->where(['id' => $id])->one();
        }
        else
        {
            $defaultValue = [];
        }

        return $this->render('edit', ['defaultValue' => $defaultValue]);
    }

    public function actionSubmit()
    {
        $data = Yii::$app->getRequest()->post('teacher');

        if (isset($data['id']) && $data['id'])
        {
            $model = Teacher::find()->where(['id' => $data['id']])->one();
        }
        else
        {
            $model = new Teacher();
        }

        $model->key = $data['key'];
        $model->name = $data['name'];

        $model->save();

        return $this->redirect(['index']);
    }

    public function actionDelete()
    {
        $id = Yii::$app->getRequest()->get('id');

        $model = Teacher::find()->where(['id' => $id])->one();

        if (Project::find()->where(['teacher_id' => $id])->one())
        {
            echo '对不起，有在使用中的老师数据，所以无法被删除！';
            exit;
        }
        else {
            $model->delete();
        }

        return $this->redirect(['index']);

    }

}
