<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $key
 * @property string $name
 * @property string $english
 * @property double $balance_base
 *
 * @property ProjectOwner[] $projectOwners
 * @property ProjectTarget[] $projectTargets
 * @property Time[] $times
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'name', 'english', 'balance_base'], 'required'],
            [['balance_base'], 'number'],
            [['key', 'name', 'english'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'name' => 'Name',
            'english' => 'English',
            'balance_base' => 'Balance Base',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectOwners()
    {
        return $this->hasMany(ProjectOwner::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectTargets()
    {
        return $this->hasMany(ProjectTarget::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimes()
    {
        return $this->hasMany(Time::className(), ['user_id' => 'id']);
    }
}
