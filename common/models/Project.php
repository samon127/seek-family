<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property integer $style
 * @property string $name
 * @property string $date_start
 * @property string $date_end
 * @property integer $city_id
 * @property integer $teacher_id
 * @property integer $type_id
 * @property integer $client_id
 * @property integer $parent_id
 * @property string $area_start
 * @property string $area_end
 * @property string $comment
 * @property string $weight
 * @property string $partner_profit
 * @property string $team_profit
 * @property integer $gllue_project_id
 *
 * @property Income[] $incomes
 * @property PayProject[] $payProjects
 * @property ProjectCity $city
 * @property Teacher $teacher
 * @property ProjectType $type
 * @property Project $parent
 * @property Project[] $projects
 * @property ProjectBonus[] $projectBonuses
 * @property ProjectOwner[] $projectOwners
 * @property ProjectTarget[] $projectTargets
 * @property Time[] $times
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['style', 'area_start', 'area_end'], 'required'],
            [['style', 'city_id', 'teacher_id', 'type_id', 'client_id', 'parent_id', 'gllue_project_id'], 'integer'],
            [['date_start', 'date_end'], 'safe'],
            [['name', 'area_start', 'area_end', 'comment', 'weight', 'partner_profit', 'team_profit'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'style' => 'Style',
            'name' => 'Name',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'city_id' => 'City ID',
            'teacher_id' => 'Teacher ID',
            'type_id' => 'Type ID',
            'client_id' => 'Client ID',
            'parent_id' => 'Parent ID',
            'area_start' => 'Area Start',
            'area_end' => 'Area End',
            'comment' => 'Comment',
            'weight' => 'Weight',
            'partner_profit' => 'Partner Profit',
            'team_profit' => 'Team Profit',
            'gllue_project_id' => 'Gllue Project ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomes()
    {
        return $this->hasMany(Income::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayProjects()
    {
        return $this->hasMany(PayProject::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(ProjectCity::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Teacher::className(), ['id' => 'teacher_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ProjectType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Project::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectBonuses()
    {
        return $this->hasMany(ProjectBonus::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectOwners()
    {
        return $this->hasMany(ProjectOwner::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectTargets()
    {
        return $this->hasMany(ProjectTarget::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimes()
    {
        return $this->hasMany(Time::className(), ['project_id' => 'id']);
    }
}
