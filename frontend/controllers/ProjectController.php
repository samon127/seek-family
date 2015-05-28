<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\tool\DBList;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class ProjectController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
    	
    	
    	
        return $this->render('index');
    }
    
	public function actionEdit()
    {
    	$projectTypes = DBList::getProjectType();
    	$teachers = DBList::getTeacher();

        return $this->render('edit', ['projectTypes' => $projectTypes, 'teachers' => $teachers]);
    }

}
