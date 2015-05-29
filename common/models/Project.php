<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property integer $city_id
 * @property integer $teacher_id
 * @property integer $type_id
 * @property integer $client_id
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
            [['city_id', 'teacher_id', 'type_id', 'client_id'], 'required'],
            [['city_id', 'teacher_id', 'type_id', 'client_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'teacher_id' => 'Teacher ID',
            'type_id' => 'Type ID',
            'client_id' => 'Client ID',
        ];
    }
}
