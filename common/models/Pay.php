<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pay".
 *
 * @property integer $id
 * @property integer $type_id
 * @property double $number
 * @property string $pay_date
 * @property string $comment
 *
 * @property PayType $type
 * @property PayProject[] $payProjects
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
            [['type_id', 'number'], 'required'],
            [['type_id'], 'integer'],
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
            'number' => 'Number',
            'pay_date' => 'Pay Date',
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(PayType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayProjects()
    {
        return $this->hasMany(PayProject::className(), ['pay_id' => 'id']);
    }
}
