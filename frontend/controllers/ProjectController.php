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
use common\models\iPay;
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
use common\models\GllueJoborder;

/**
 * Site controllers
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
        $model->gllue_project_id = isset($data['gllue_project']) ? $data['gllue_project'] : '';

        $model->save();

        if (isset($data['user']) && $data['user'])
        {
            foreach ($data['user'] as $userId)
            {
                $user = User::findOne($userId);
                $model->link('users', $user);
            }
        }


        return $this->redirect(['project/finance']);
    }

    public function actionSubmitParent()
    {
        $data = Yii::$app->getRequest()->post('project');

        if (isset($data['id']) && $data['id'])
        {
            $model = iProject::find()->where(['id' => $data['id']])->one();
        }
        else
        {
            $model = new iProject();
        }

        $model->style = 2;
        $model->name = isset($data['parentName']) ? $data['parentName'] : '';

        $model->save();

        return $this->redirect(['project/finance']);
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

    // AJAX, used by project/edit
    public function actionGetGllueProject()
    {
        $keyWorld = Yii::$app->getRequest()->get('q');

        $all = GllueJoborder::find()->asArray()->indexBy('id')
            ->where(['like', 'jobTitle', $keyWorld])
            ->orderby('dateAdded DESC')
            ->all();


        $items = [];
        foreach ($all as $one)
        {
            $items[] =  array('id' => $one['id'], 'description' => $one['jobTitle'], 'full_name' => $one['jobTitle']);
        }

        echo json_encode(array('items' => $items));


        exit;
    }

	public function actionEdit()
    {
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = Project::find()->with('projectOwners')->asArray()->where(['id' => $id])->one();
            if ($defaultValue['style'] == 2)
            {
                $defaultValue['parentName'] = $defaultValue['name'];
                $defaultValue['name'] = '';
            }
            else {
                $defaultValue['parentName'] = '';
            }
        }
        else
        {
            $defaultValue = [];
        }

        return $this->render('edit', ['defaultValue' => $defaultValue]);
    }


    public function actionBalance()
    {

        $pid = Yii::$app->getRequest()->get('pid');

        $model = Project::find()->where(['id' => $pid])->one();

        if ($model->style==2) // 母项目
        {
            $projects = iProject::find()->where(['parent_id' => $pid])->all();
            $parentProject = Project::find()->where(['id' => $pid])->one();
            return $this->render('parentBalance', ['projects'=>$projects, 'parentProject'=>$parentProject]);
        }
        else
        {
            if ($model->style==1){ // 独立项目
                $projects = [$model];
                $activeId = $model->id;
                $parentProject = false;
            }
            else if ($model->style==3){ // 子项目
                $projects = Project::find()->where(['parent_id' => $model->parent_id])->with('parent')->all();
                $activeId = $model->id;
                $parentProject = Project::find()->where(['id' => $model->parent_id])->one();
            }

            return $this->render('balance', ['projects'=>$projects, 'activeId'=>$activeId, 'parentProject'=>$parentProject]);
        }

    }

    public function actionFinance()
    {
        $searchKeyWord = Yii::$app->getRequest()->get('s');

        $model = iProject::find()
        ->with('users')
        ->with('incomes')
        ->with('pays')
        ->with('pays.projects')
        ->with('times')
        ->with('times.user')
        ->orderBy('date_start DESC')
        ->joinWith('type', true, 'LEFT JOIN');

        if (isset($searchKeyWord['style']) && $searchKeyWord['style'][0] == 2)
        {
            $model->andWhere(['in','project.style',$searchKeyWord['style']]);
        }
        else
        {
            if (!isset($searchKeyWord['style']) || !$searchKeyWord['style'])
            {
                $searchKeyWord['style'] = [1, 3];
            }
            $model->andWhere(['in','project.style',$searchKeyWord['style']]);

            if (isset($searchKeyWord['project']) && $searchKeyWord['project'])
            {
                $model->andWhere(['in','project.id',$searchKeyWord['project']]);
            }

            if (!isset($searchKeyWord['date_start']) || !$searchKeyWord['date_start'])
            {
                $model->andWhere(['>=', 'project.date_start', date('Y-m-d', time()-60*60*24*90)]);
            }
            else
            {
                $model->andWhere(['>=', 'project.date_start', $searchKeyWord['date_start']]);
            }

            if (!isset($searchKeyWord['date_end']) || !$searchKeyWord['date_end'])
            {
                $model->andWhere(['<=', 'project.date_start', date('Y-m-d', time()+24*60*60*90)]);
            }
            else
            {
                $model->andWhere(['<=', 'project.date_start', $searchKeyWord['date_end']]);
            }


            if (isset($searchKeyWord['client']) && $searchKeyWord['client'])
            {
                $model->andWhere(['project.client_id' => $searchKeyWord['client']]);
            }
        }

        $projects = $model->all();

        return $this->render('finance', ['projects'=>$projects, 'defaultValue'=>$searchKeyWord]);

    }

    public function actionDelete()
    {
        $pid = Yii::$app->getRequest()->get('id');

        $income = Income::find()->where(['project_id' => $pid])->one();
        if ($income)
        {
            echo '需要先删除项目收入，才能删除项目';
            exit;
        }

        $pay = iPay::find()->joinWith('projects', true, 'LEFT JOIN')->where(['project_id' => $pid])->one();
        if ($pay)
        {
            echo '需要先删除项目支出，才能删除项目';
            exit;
        }

        $model = Project::find()->where(['id' => $pid])->one();
        $model->delete();

        return $this->redirect(['project/index']);

    }

    public function actionDeleteParent()
    {
        $pid = Yii::$app->getRequest()->get('id');

        $project = iProject::find()->where(['parent_id' => $pid])->one();
        if ($project)
        {
            echo '需要先删除所有子项目，才能删除此项目';
            exit;
        }

        $model = Project::find()->where(['id' => $pid])->one();
        $model->delete();

        return $this->redirect(['project/index']);

    }

    public function actionType()
    {
        $tid = Yii::$app->getRequest()->get('tid');

        $projects = iProject::find()
        ->with('users')
        ->with('incomes')
        ->with('pays')
        ->with('pays.projects')
        ->with('times')
        ->with('times.user')
        ->where(['type_id' => $tid])
        ->orderBy('date_start')
        ->joinWith('type', true, 'LEFT JOIN')
        ->all();

        return $this->render('parentBalance', ['projects'=>$projects]);

    }


}
