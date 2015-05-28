<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_type".
 *
 * @property integer $id
 * @property string $key
 * @property string $name
 */
class ProjectType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'name'], 'required'],
            [['key', 'name'], 'string', 'max' => 255]
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
        ];
    }
}
