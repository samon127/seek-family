<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "income".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $project_id
 * @property integer $client_id
 * @property integer $bd_id
 * @property double $number
 * @property integer $card
 * @property integer $account_id
 * @property string $income_date
 * @property integer $invoice
 * @property integer $invoice_code
 * @property string $comment
 *
 * @property Project $project
 * @property IncomeAccount $account
 * @property User $bd
 */
class Income extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'income';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'number', 'card'], 'required'],
            [['type', 'project_id', 'client_id', 'bd_id', 'card', 'account_id', 'invoice', 'invoice_code'], 'integer'],
            [['number'], 'number'],
            [['income_date'], 'safe'],
            [['comment'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'project_id' => 'Project ID',
            'client_id' => 'Client ID',
            'bd_id' => 'Bd ID',
            'number' => 'Number',
            'card' => 'Card',
            'account_id' => 'Account ID',
            'income_date' => 'Income Date',
            'invoice' => 'Invoice',
            'invoice_code' => 'Invoice Code',
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(IncomeAccount::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBd()
    {
        return $this->hasOne(User::className(), ['id' => 'bd_id']);
    }
}
