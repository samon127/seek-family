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

class MessageController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {


        return $this->render('index');
    }



}
