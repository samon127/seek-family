<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\Project;
use common\models\GllueClient;
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
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSubmit()
    {

        $data = Yii::$app->getRequest()->post('project');
        //print_r($data);exit;

        if (isset($data['id']) && $data['id'])
        {

        }
        else
        {
            $model = new Project();
            $model->type_id = $data['type'];
            $model->teacher_id = $data['teacher'];
            $model->city_id = $data['city'];
            $model->client_id = $data['client'];
            $model->save();
        }


        return $this->render('index');
    }

    // AJAX, used by select2
    public function actionGetCompany()
    {
        $keyWorld = Yii::$app->getRequest()->get('q');

        $all = GllueClient::find()->asArray()->indexBy('id')->where(['like', 'name1', $keyWorld])->all();

        $items = [];
        foreach ($all as $one)
        {
            $items[] =  array('id' => $one['id'], 'description' => $one['name1']." （".$one['name']."）", 'full_name' => $one['name']);
        }

        echo json_encode(array('items' => $items));


        exit;
    }

	public function actionEdit()
    {
    	$projectTypes = DBList::getProjectType();
    	$teachers = DBList::getTeacher();

        return $this->render('edit', ['projectTypes' => $projectTypes, 'teachers' => $teachers]);
    }

}
