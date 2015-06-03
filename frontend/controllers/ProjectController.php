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
    	$projects = Project::find()
				->joinWith('type', true, 'LEFT JOIN')
				->joinWith('teacher', true, 'LEFT JOIN')
				->joinWith('city', true, 'LEFT JOIN')
    	        ->all();

        return $this->render('index', array('projects' => $projects));
    }

    public function actionSubmit()
    {

        $data = Yii::$app->getRequest()->post('project');

        if (isset($data['id']) && $data['id'])
        {
            $model = Project::find()->where(['id' => $data['id']])->one();
        }
        else
        {
            $model = new Project();
        }

        $model->type_id = $data['type'];
        $model->city_id = $data['city'];

        if (isset($data['teacher']))
        {
            $model->teacher_id = $data['teacher'];
        }
        else {
            $model->teacher_id = '';
        }

        if (isset($data['client']))
        {
            $model->client_id = $data['client'];
        }
        else {
            $model->client_id = '';
        }

        $model->save();

        return $this->redirect(['project/index']);
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
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = Project::find()->asArray()->where(['id' => $id])->one();
        }
        else
        {
            $defaultValue = [];
        }

    	$projectTypes = DBList::getProjectType();
    	$teachers = DBList::getTeacher();
    	$city = DBList::getCity();

        return $this->render('edit', ['projectTypes' => $projectTypes, 'teachers' => $teachers, 'city' => $city, 'defaultValue' => $defaultValue]);
    }

}
