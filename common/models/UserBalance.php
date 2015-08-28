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
class UserBalance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_balance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'month', 'balance'], 'required'],
            [['user_id'], 'integer'],
            [['balance'], 'number'],
            [['month'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'month' => 'Month',
            'balance' => 'Balance',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
