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
 * @property string $comment
 *
 * @property GllueClient $client
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
            [['type', 'project_id', 'client_id', 'number', 'card', 'invoice'], 'required'],
            [['type', 'project_id', 'client_id', 'card', 'invoice'], 'integer'],
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
            'number' => 'Number',
            'card' => 'Card',
            'income_date' => 'Income Date',
            'invoice' => 'Invoice',
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(GllueClient::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
}
