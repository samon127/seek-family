<?php
namespace common\models;

use Yii;

/**
 * This is the model class for table "user_balance".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $month
 * @property double $balance
 *
 * @property User $user
 */
class iUserBalance extends UserBalance
{
    public static function getUserBalance($userId, $month)
    {
        $allBalance = UserBalance::find()
            ->where(['user_id' => $userId])
            ->andWhere(['<=', 'month', $month])
            ->orderBy('month DESC')
            ->all();

        if (!$allBalance) {
            return 0;
        } else {
            return $allBalance[0]->balance;
        }
    }
}
