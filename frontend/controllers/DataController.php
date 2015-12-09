<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\Income;
use common\models\iGllueClient;
use common\models\GllueUser;
use common\tool\DBList;

class DataController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionSales()
    {
        $startDate = date('Y-m-d', time()-60*60*24*180); // 以这个时间点开始到现在的客户相关数据
        $userArray = [2, 5, 22, 25, 34, 42, 45, 40, 41, 30];
        foreach ($userArray as $userId)
        {
            $data[$userId] = [];
        }

        // 绑定用户名
        $model = GllueUser::find()->all();
        foreach ($model as $user)
        {
            if (in_array($user->id, $userArray))
            {
                $data[$user->id]['name'] = $user->englishName;
            }
        }

        // CRM中的总客户数
        $model = iGllueClient::find()
            ->select(['COUNT(*) AS count, client.*'])
            ->andWhere(['!=', 'client.bd_id', 'NULL']) // 有一个叫做“个人”的用户，bd_id是空的
            ->andFilterWhere(['or',
                    ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                    ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                    ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
                    ])
            ->andWhere(['client.parent_id' => null])
            ->groupBy('bd_id')
            ->all();
        foreach ($model as $client)
        {
            if (in_array($client->bd_id, $userArray))
            {
                $data[$client->bd_id]['allClientCount'] = $client->count;
            }
        }

        // CRM中已签约客户
        $model = iGllueClient::find()
            ->select(['COUNT(*) AS count, client.*'])
            ->andWhere(['!=', 'client.bd_id', 'NULL']) // 有一个叫做“个人”的用户，bd_id是空的
            ->andWhere(['=', 'client.type', 'client'])
            ->andFilterWhere(['or',
                    ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                    ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                    ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
            ])
            ->andWhere(['client.parent_id' => null])
            ->groupBy('bd_id')
            ->all();
        foreach ($model as $client)
        {
            if (in_array($client->bd_id, $userArray))
            {
                $data[$client->bd_id]['allDealClientCount'] = $client->count;
            }
        }

        // CRM中未签约客户
        $model = iGllueClient::find()
        ->select(['COUNT(*) AS count, client.*'])
        ->andWhere(['!=', 'client.bd_id', 'NULL']) // 有一个叫做“个人”的用户，bd_id是空的
        ->andWhere(['!=', 'client.type', 'client'])
        ->andFilterWhere(['or',
                ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
        ])
        ->andWhere(['client.parent_id' => null])
        ->groupBy('bd_id')
        ->all();
        foreach ($model as $client)
        {
            if (in_array($client->bd_id, $userArray))
            {
                $data[$client->bd_id]['allNodealClientCount'] = $client->count;
            }
        }

        // CRM中最近的成交客户数
        $clientIds = [];
        $incomeModel = Income::find()
            ->where(['>=', 'income_date', $startDate])
            ->groupBy('client_id')
            ->all();
        foreach ($incomeModel as $income)
        {
            if ($income->client_id)
            {
                $clientIds[] = $income->client_id;
            }
        }
        $model = iGllueClient::find()
            ->select(['COUNT(*) AS count, client.*'])
            ->where(['client.id'=>$clientIds])
            ->andWhere(['!=', 'client.bd_id', 'NULL']) // 有一个叫做“个人”的用户，bd_id是空的
            ->andWhere(['=', 'client.type', 'client'])
            ->andFilterWhere(['or',
                    ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                    ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                    ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
            ])
            ->andWhere(['client.parent_id' => null])
            ->groupBy('bd_id')
            ->all();
        foreach ($model as $client)
        {
            if (in_array($client->bd_id, $userArray))
            {
                $data[$client->bd_id]['recentDealClientCount'] = $client->count;
            }
        }

        // 需要升级的客户数（在财务上最近有成交，但是在系统里面还没有标注为已成交客户）
        $clientIds = [];
        $incomeModel = Income::find()->groupBy('client_id')->all();
        foreach ($incomeModel as $income)
        {
            if ($income->client_id)
            {
                $clientIds[] = $income->client_id;
            }
        }
        $model = iGllueClient::find()
        ->select(['COUNT(*) AS count, client.*'])
        ->where(['client.id'=>$clientIds])
        ->andWhere(['!=', 'client.bd_id', 'NULL']) // 有一个叫做“个人”的用户，bd_id是空的
        ->andWhere(['!=', 'client.type', 'client'])
        ->andFilterWhere(['or',
                ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
        ])
        ->andWhere(['client.parent_id' => null])
        ->groupBy('bd_id')
        ->all();
        foreach ($model as $client)
        {
            if (in_array($client->bd_id, $userArray))
            {
                $data[$client->bd_id]['upgradeClientCount'] = $client->count;
            }
        }

        // 需要降级的客户数（在系统里面标注为已成交客户，但是在一段时间内的财务数据中没有显示）
        $clientIds = [];
        $incomeModel = Income::find()
        ->where(['>=', 'income_date', date('Y-m-d', time()-60*60*24*365)])
            ->groupBy('client_id')
            ->all();
        foreach ($incomeModel as $income)
        {
            if ($income->client_id)
            {
                $clientIds[] = $income->client_id;
            }
        }
        $model = iGllueClient::find()
        ->select(['COUNT(*) AS count, client.*'])
        ->where(['not in', 'client.id', $clientIds])
        ->andWhere(['!=', 'client.bd_id', 'NULL']) // 有一个叫做“个人”的用户，bd_id是空的
        ->andWhere(['=', 'client.type', 'client'])
        ->andFilterWhere(['or',
                ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
        ])
        ->andWhere(['client.parent_id' => null])
        ->groupBy('bd_id')
        ->all();
        foreach ($model as $client)
        {
            if (in_array($client->bd_id, $userArray))
            {
                $data[$client->bd_id]['degradeClientCount'] = $client->count;
            }
        }


        // 在财务表中找到所有有交易记录的客户数据
        $clientIds = [];
        $incomeModel = Income::find()->groupBy('client_id')->all();
        foreach ($incomeModel as $income)
        {
            if ($income->client_id)
            {
                $clientIds[] = $income->client_id;
            }
        }
        $model = iGllueClient::find()
                ->select(['COUNT(*) AS count, client.*'])
                ->where(['client.id'=>$clientIds])
                ->andWhere(['!=', 'client.bd_id', 'NULL']) // 有一个叫做“个人”的用户，bd_id是空的
                ->andFilterWhere(['or',
                        ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                        ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                        ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
                ])
                ->andWhere(['client.parent_id' => null])
                ->groupBy('bd_id')
                ->all();
        foreach ($model as $client)
        {
            if (in_array($client->bd_id, $userArray))
            {
                $data[$client->bd_id]['allFinanceClientCount'] = $client->count;
            }
        }

        // 在财务表中找到过去半年有交易记录的客户数据
        $clientIds = [];
        $incomeModel = Income::find()
            ->where(['>=', 'income_date', $startDate])
            ->groupBy('client_id')
            ->all();
        foreach ($incomeModel as $income)
        {
            if ($income->client_id)
            {
                $clientIds[] = $income->client_id;
            }
        }

        $model = iGllueClient::find()
        ->select(['COUNT(*) AS count, client.*'])
        ->where(['client.id'=>$clientIds])
        ->andWhere(['!=', 'client.bd_id', 'NULL']) // 有一个叫做“个人”的用户，bd_id是空的
        ->andFilterWhere(['or',
                ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
        ])
        ->andWhere(['client.parent_id' => null])
        ->groupBy('bd_id')
        ->all();
        foreach ($model as $client)
        {
            if (in_array($client->bd_id, $userArray))
            {
                $data[$client->bd_id]['recentFinanceClientCount'] = $client->count;
            }
        }

        return $this->render('sales', ['data'=>$data]);
    }

    public function actionUser()
    {
        $uid = Yii::$app->getRequest()->get('uid');
        $startDate = date('Y-m-d', time()-60*60*24*180); // 以这个时间点开始到现在的客户相关数据

        // CRM中的总客户数
        $model = iGllueClient::find()
        ->where(['bd_id'=>$uid])
        ->andFilterWhere(['or',
                ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
        ])
        ->andWhere(['client.parent_id' => null])
        ->all();
        $data['allClient'] = $model;

        // CRM中已签约客户
        $model = iGllueClient::find()
        ->where(['bd_id'=>$uid])
        ->andWhere(['=', 'type', 'client'])
        ->andFilterWhere(['or',
                ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
        ])
        ->andWhere(['client.parent_id' => null])
        ->all();
        $data['allDealClient'] = $model;

        // CRM中未签约客户
        $model = iGllueClient::find()
        ->where(['bd_id'=>$uid])
        ->andWhere(['!=', 'type', 'client'])
        ->andFilterWhere(['or',
                ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
        ])
        ->andWhere(['client.parent_id' => null])
        ->all();
        $data['allNodealClient'] = $model;

        // 在财务表中找到所有有交易记录的客户数据
        $clientIds = [];
        $incomeModel = Income::find()->groupBy('client_id')->all();
        foreach ($incomeModel as $income)
        {
            if ($income->client_id)
            {
                $clientIds[] = $income->client_id;
            }
        }
        $model = iGllueClient::find()
        ->where(['client.id'=>$clientIds])
        ->andWhere(['bd_id'=>$uid])
        ->andFilterWhere(['or',
                ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
        ])
        ->andWhere(['client.parent_id' => null])
        ->all();
        $data['allFinanceClient'] = $model;

        // 在财务表中找到过去半年有交易记录的客户数据
        $clientIds = [];
        $incomeModel = Income::find()
        ->where(['>=', 'income_date', $startDate])
        ->groupBy('client_id')
        ->all();
        foreach ($incomeModel as $income)
        {
            if ($income->client_id)
            {
                $clientIds[] = $income->client_id;
            }
        }
        $model = iGllueClient::find()
        ->where(['client.id'=>$clientIds])
        ->andWhere(['bd_id'=>$uid])
        ->andFilterWhere(['or',
                ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
        ])
        ->andWhere(['client.parent_id' => null])
        ->all();
        $data['recentFinanceClient'] = $model;


        // 需要升级的客户数（在财务上最近有成交，但是在系统里面还没有标注为已成交客户）
        $clientIds = [];
        $incomeModel = Income::find()->groupBy('client_id')->all();
        foreach ($incomeModel as $income)
        {
            if ($income->client_id)
            {
                $clientIds[] = $income->client_id;
            }
        }
        $model = iGllueClient::find()
        ->where(['client.id'=>$clientIds])
        ->andWhere(['bd_id'=>$uid])
        ->andWhere(['!=', 'client.type', 'client'])
        ->andFilterWhere(['or',
                ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
        ])
        ->andWhere(['client.parent_id' => null])
        ->all();
        $data['upgradeClient'] = $model;

        // 需要降级的客户数（在系统里面标注为已成交客户，但是在一段时间内的财务数据中没有显示）
        $clientIds = [];
        $incomeModel = Income::find()
        ->where(['>=', 'income_date', date('Y-m-d', time()-60*60*24*365)])
        ->groupBy('client_id')
        ->all();
        foreach ($incomeModel as $income)
        {
            if ($income->client_id)
            {
                $clientIds[] = $income->client_id;
            }
        }
        $model = iGllueClient::find()
        ->where(['not in', 'client.id', $clientIds])
        ->andWhere(['bd_id'=>$uid])
        ->andWhere(['=', 'client.type', 'client'])
        ->andFilterWhere(['or',
                ['in', 'client.industry_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry1_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]],
                ['in', 'client.industry2_id', [13,18,11,4,10,12,9,20,14,218,24,7,3,219,217]]
        ])
        ->andWhere(['client.parent_id' => null])
        ->all();
        $data['degradeClient'] = $model;

        $user = GllueUser::find()->where(['id'=>$uid])->one();


        return $this->render('user', ['data'=>$data, 'user'=>$user]);
    }
}
