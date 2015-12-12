<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\ProjectCity;

class CityController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $cities = ProjectCity::find()->all();

        return $this->render('index', ['cities'=>$cities]);
    }

    public function actionEdit()
    {
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = ProjectCity::find()->asArray()->where(['id' => $id])->one();
        }
        else
        {
            $defaultValue = [];
        }

        return $this->render('edit', ['defaultValue' => $defaultValue]);
    }

    public function actionSubmit()
    {
        $data = Yii::$app->getRequest()->post('city');

        if (isset($data['id']) && $data['id'])
        {
            $model = ProjectCity::find()->where(['id' => $data['id']])->one();
        }
        else
        {
            $model = new ProjectCity();
        }

        $model->key = $data['key'];
        $model->name = $data['name'];

        $model->save();

        return $this->redirect(['index']);
    }

    public function actionDelete()
    {
        $id = Yii::$app->getRequest()->get('id');

        $model = ProjectCity::find()->where(['id' => $id])->one();

        if (Project::find()->where(['city_id' => $id])->one())
        {
            echo '对不起，有在使用中的项目城市数据，所以无法被删除！';
            exit;
        }
        else {
            $model->delete();
        }

        return $this->redirect(['index']);

    }

}
