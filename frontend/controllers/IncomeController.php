<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\Income;
use common\models\iGllueClient;
use common\tool\Family;
use common\models\User;
use yii\db\ActiveQuery;


class IncomeController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionSearch()
    {
        $searchKeyWord = Yii::$app->getRequest()->get('s');
        if ($searchKeyWord)
        {
            $model = Income::find();

            if ($searchKeyWord['income']['date_start']){
                $model->andWhere(['>=', 'income_date', $searchKeyWord['income']['date_start']]);
   			 }

            if ($searchKeyWord['income']['date_end'])
            {
                $model->andWhere(['<=', 'income_date', $searchKeyWord['income']['date_end']]);
            }

//             if ($searchKeyWord['project']['date_start']){
//                 $model->andWhere(['>=', 'project.date_start', $searchKeyWord['project']['date_start']]);
//             }

//             if ($searchKeyWord['project']['date_end'])
//             {
//                 $model->andWhere(['<=', 'project.date_end', $searchKeyWord['project']['date_end']]);
//             }

            if (isset($searchKeyWord['client']) && $searchKeyWord['client'])
            {
                $model->andWhere(['income.client_id' => $searchKeyWord['client']]);
            }

            //print_r($searchKeyWord);exit;

            if (isset($searchKeyWord['project']) && $searchKeyWord['project'])
            {
                $model->andWhere(['in','project_id',$searchKeyWord['project']]);
            }

            if(Isset ($searchKeyWord['invoice']) && $searchKeyWord['invoice'])
            {
            	$model->andWhere(['invoice' => $searchKeyWord['invoice']]);
            }

            if(Isset ($searchKeyWord['card']) && $searchKeyWord['card'])
            {
            	$model->andWhere(['card' => $searchKeyWord['card']]);
            }

            if(Isset ($searchKeyWord['money']) && $searchKeyWord['money'])
            {
            	if( $searchKeyWord['money'] == 1) {
            		// money=1是应收账款
            		$model->andWhere(['income_date' => null])->andWhere(['card' => 1]);
            	}
            }

            if(Isset ($searchKeyWord['comment']) && $searchKeyWord['comment'])
            {   $comment = trim($searchKeyWord['comment']);
                $model->andwhere(array('LIKE','income.comment',$comment));
            }


            $incomes = $model
            ->joinWith('bd', true, 'LEFT JOIN')
            ->joinWith('project', true, 'LEFT JOIN')
            ->joinWith('project.type', true, 'LEFT JOIN')
            ->joinWith('project.teacher', true, 'LEFT JOIN')
            ->joinWith('project.city', true, 'LEFT JOIN')
            ->orderBy('project.date_start DESC')
            ->all();
        }
        else
        {
            $incomes = [];
        }

        return $this->render('search', ['incomes'=>$incomes, 'defaultValue'=>$searchKeyWord]);
    }

    public function actionEdit()
    {
        if ($id = Yii::$app->getRequest()->get('id'))
        {
            $defaultValue = Income::find()->asArray()->where(['id' => $id])->one();
        }
        else
        {
            $defaultValue = [];
        }



        return $this->render('edit', array('defaultValue' => $defaultValue));
    }

    public function actionSubmit()
    {

        $data = Yii::$app->getRequest()->post('income');
        $pid = Yii::$app->getRequest()->post('pid');
  //print_r($data);exit;
        if (isset($data['id']) && $data['id'])
        {
            $model = Income::find()->where(['id' => $data['id']])->one();
        }
        else
        {
            $model = new Income();
        }

        $model->type = $data['type'];
        $model->project_id = (isset($data['project']) && $data['project'] ) ? $data['project'] : '';
        $model->client_id = (isset($data['client']) && $data['client'] ) ? $data['client'] : '';

        // 需要通过Gllue的系统去查询得到这个客户当前的bd归属人，然后查询user表得到值
        if (isset($data['client']) && $data['client'])
        {
            $bdModel = iGllueClient::find()->where(['=', 'id', $data['client']])->one();

            if ($bdModel->bd_id)
            {
                $userModel = User::find()->where(['=','gllue_id', $bdModel->bd_id])->one();
                $model->bd_id = $userModel->id;
            }
        }

        $model->number = str_replace(',', '', $data['money']);
        $model->card = $data['card'];
        $model->income_date = $data['date'];
        //$model->invoice = $data['invoice'];
        $model->invoice_code = $data['invoice_code'];
        $model->comment = $data['comment'];

        $model->save();

        $from = Yii::$app->getRequest()->post('from', array('income/search'));

        return $this->redirect($from);
    }

    public function actionDelete()
    {
        $id = Yii::$app->getRequest()->get('id');
        $pid = Yii::$app->getRequest()->get('pid');


        $model = Income::find()->where(['id' => $id])->one();
        $model->delete();

        $from = Yii::$app->getRequest()->post('from', array('income/search'));

        return $this->redirect($from);

    }

}
