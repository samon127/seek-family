<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_target".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $user_id
 * @property integer $people_target
 * @property double $revenue_target
 *
 * @property Project $project
 * @property User $user
 */
class ProjectTarget extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_target';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id', 'people_target', 'revenue_target'], 'required'],
            [['project_id', 'user_id', 'people_target'], 'integer'],
            [['revenue_target'], 'number']
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
            'user_id' => 'User ID',
            'people_target' => 'People Target',
            'revenue_target' => 'Revenue Target',
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
