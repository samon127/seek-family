<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pay".
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $project_id
 * @property double $number
 * @property string $pay_date
 * @property string $comment
 *
 * @property Project $project
 * @property PayType $type
 */
class Pay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'project_id', 'number', 'pay_date', 'comment'], 'required'],
            [['type_id', 'project_id'], 'integer'],
            [['number'], 'number'],
            [['pay_date'], 'safe'],
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
            'type_id' => 'Type ID',
            'project_id' => 'Project ID',
            'number' => 'Number',
            'pay_date' => 'Pay Date',
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
    public function getType()
    {
        return $this->hasOne(PayType::className(), ['id' => 'type_id']);
    }
}
