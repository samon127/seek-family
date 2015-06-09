<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "time".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $month
 * @property integer $user_id
 * @property double $percent
 *
 * @property Project $project
 * @property User $user
 */
class Time extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'month', 'user_id', 'percent'], 'required'],
            [['project_id', 'user_id'], 'integer'],
            [['percent'], 'number'],
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
            'project_id' => 'Project ID',
            'month' => 'Month',
            'user_id' => 'User ID',
            'percent' => 'Percent',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
