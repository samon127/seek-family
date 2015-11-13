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
 * @property double $number
 * @property integer $card
 * @property string $income_date
 * @property integer $invoice
 * @property string $invoice_code
 * @property string $comment
 *
 * @property Project $project
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
            [['type', 'number', 'card', 'invoice'], 'required'],
            [['type', 'project_id', 'client_id', 'card', 'invoice'], 'integer'],
            [['number'], 'number'],
            [['income_date'], 'safe'],
            [['comment'], 'string'],
            [['invoice_code'], 'string', 'max' => 255]
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
            'number' => 'Number',
            'card' => 'Card',
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
}
