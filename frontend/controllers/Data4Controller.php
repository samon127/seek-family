<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\Income;
use common\models\iGllueClient;
use common\models\GllueUser;
use common\tool\DBList;
use common\models\GllueJoborder;
use common\models\GllueJobsubmission;
use common\models\GllueCandidate;

class Data4Controller extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $models = Income::find()
            ->select('SUM(number) as number, client_id')
            ->where(['not', ['client_id' => null]])
            ->groupBy('client_id')
            ->orderBy('number DESC')
            ->all();

            foreach ($models as $model)
            {
                $clientIds[] = $model->client_id;
            }

        return $this->render('index', ['clients' => $models, 'clientIds' => $clientIds]);
    }
}
