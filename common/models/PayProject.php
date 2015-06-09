<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pay_project".
 *
 * @property integer $id
 * @property integer $pay_id
 * @property integer $project_id
 *
 * @property Pay $pay
 * @property Project $project
 */
class PayProject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_id', 'project_id'], 'required'],
            [['pay_id', 'project_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_id' => 'Pay ID',
            'project_id' => 'Project ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPay()
    {
        return $this->hasOne(Pay::className(), ['id' => 'pay_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
}
