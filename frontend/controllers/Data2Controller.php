<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\Income;
use common\models\iGllueClient;
use common\models\GllueUser;
use common\tool\DBList;

class Data2Controller extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionClients()
    {
        $dateStart = date('Y-m-d', time()-60*60*24*90); // 以这个时间点开始到现在的客户相关数据
        $dateEnd = date('Y-m-d', time());
        $userArray = [22, 34, 42, 45];
        foreach ($userArray as $userId)
        {
            $temp[$userId] = 0;
        }

//         $searchKeyWord = Yii::$app->getRequest()->get('s');

//         if ($searchKeyWord['income']['date_start'])
//         {
//             $dateStart = $searchKeyWord['income']['date_start'];
//             $model->andWhere(['>=', 'income_date', $searchKeyWord['income']['date_start']]);
//         }

//         if ($searchKeyWord['income']['date_end'])
//         {
//             $dateEnd = $searchKeyWord['income']['date_end'];
//             $model->andWhere(['<=', 'income_date', $searchKeyWord['income']['date_end']]);
//         }

        for ($i=strtotime($dateEnd);$i>=strtotime($dateStart);$i-=60*60*24)
        {
            $data['date'][date('Y-m-d', $i)] = $temp;
        }

        $models = iGllueClient::find()
        ->where(['in', 'addedBy_id', $userArray])
        ->andWhere(['>=', 'dateAdded', $dateStart])
        ->andWhere(['<=', 'dateAdded', $dateEnd])
        ->all();

        foreach ($models as $model)
        {
            $data['date'][substr($model->dateAdded, 0, 10)][$model->addedBy_id] += 1;
        }

        //print_r($data);exit;

        // 绑定用户名
        $model = GllueUser::find()->all();
        foreach ($model as $user)
        {
            if (in_array($user->id, $userArray))
            {
                $data['name'][$user->id] = $user->englishName;
            }
        }

        return $this->render('clients', ['data'=>$data]);
    }

}
