<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\Project;
use common\models\iProject;
use common\models\Income;
use common\models\Time;
use common\models\User;
use common\models\Pay;
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
    	        ->orderBy('date_start')
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
            $model = iProject::find()->with('users')->where(['id' => $data['id']])->one();
            $model->unlinkAll('users', true);
        }
        else
        {
            $model = new iProject();
        }

        $model->style = $data['style'];
        $model->area_start = $data['area_start'];
        $model->area_end = $data['area_end'];

        $model->teacher_id = isset($data['teacher']) ? $data['teacher'] : '';
        $model->client_id = isset($data['client']) ? $data['client'] : '';
        $model->city_id = isset($data['city']) ? $data['city'] : '';
        $model->type_id = isset($data['type']) ? $data['type'] : '';
        $model->name = isset($data['name']) ? $data['name'] : '';
        $model->parent_id = isset($data['parent']) ? $data['parent'] : '';
        $model->date_start = isset($data['date_start']) ? $data['date_start'] : '';
        $model->date_end = isset($data['date_end']) ? $data['date_end'] : '';
        $model->comment = isset($data['comment']) ? $data['comment'] : '';
        $model->weight = isset($data['weight']) ? $data['weight'] : '';
        $model->partner_profit = isset($data['partner_profit']) ? $data['partner_profit'] : '';
        $model->team_profit = isset($data['team_profit']) ? $data['team_profit'] : '';

        $model->save();

        if (isset($data['user']) && $data['user'])
        {
            foreach ($data['user'] as $userId)
            {
                $user = User::findOne($userId);
                $model->link('users', $user);
            }
        }


        return $this->redirect(['project/index']);
    }

    // AJAX, used by select2
    public function actionGetCompany()
    {
        $keyWorld = Yii::$app->getRequest()->get('q');

        $all = GllueClient::find()->asArray()->indexBy('id')->where(['like', 'name1', $keyWorld])->orWhere(['like', 'name', $keyWorld])->all();


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
            $defaultValue = Project::find()->with('projectOwners')->asArray()->where(['id' => $id])->one();
        }
        else
        {
            $defaultValue = [];
        }

    	$projectTypes = DBList::getProjectType();
    	$teachers = DBList::getTeacher();
    	$city = DBList::getCity();
    	$parentProject = DBList::getParentProject();
    	$users = DBList::getUser();

        return $this->render('edit', ['projectTypes' => $projectTypes, 'teachers' => $teachers, 'city' => $city, 'defaultValue' => $defaultValue, 'parentProject'=>$parentProject, 'users'=>$users]);
    }


    public function actionBalance()
    {

        $pid = Yii::$app->getRequest()->get('pid');

        $model = Project::find()->where(['id' => $pid])->one();

        if ($model->style==2) // 母项目
        {
            $projects = Project::find()->where(['parent_id' => $pid])->all();
            $activeId = $projects[0]->id;
            $parentProject = Project::find()->where(['id' => $pid])->one();
        }
        else if ($model->style==1){ // 独立项目
            $projects = [$model];
            $activeId = $model->id;
            $parentProject = false;
        }
        else if ($model->style==3){ // 子项目
            $projects = Project::find()->where(['parent_id' => $model->parent_id])->all();
            $activeId = $model->id;
            $parentProject = Project::find()->where(['id' => $model->parent_id])->one();
        }

        return $this->render('balance', ['projects'=>$projects, 'activeId'=>$activeId, 'parentProject'=>$parentProject]);
    }

    public function actionFinance()
    {
        $projects = iProject::find()
        ->with('users')
        ->with('incomes')
        ->with('pays')
        ->with('pays.projects')
        ->with('times')
        ->with('times.user')
        ->orderBy('date_start')
        ->joinWith('type', true, 'LEFT JOIN')
        ->all();

        return $this->render('finance', ['projects'=>$projects]);

    }

    public function actionDelete()
    {
        $pid = Yii::$app->getRequest()->get('id');

        $model = Project::find()->where(['id' => $pid])->one();
        $model->delete();

        return $this->redirect(['project/index']);

    }
}
