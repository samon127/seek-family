<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_bonus".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $user_id
 * @property string $part
 *
 * @property Project $project
 * @property User $user
 */
class ProjectBonus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_bonus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id', 'part'], 'required'],
            [['project_id', 'user_id'], 'integer'],
            [['part'], 'string', 'max' => 255]
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
            'part' => 'Part',
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
