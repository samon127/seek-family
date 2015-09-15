<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $name
 * @property string $name_en
 * @property integer $parent_id
 * @property integer $order
 *
 * @property Billinginfo[] $billinginfos
 * @property Candidate[] $candidates
 * @property Candidate[] $candidates0
 * @property Candidate[] $candidates1
 * @property Candidate[] $candidates2
 * @property Candidate[] $candidates3
 * @property Candidate[] $candidates4
 * @property GllueCity $parent
 * @property GllueCity[] $gllueCities
 * @property Client[] $clients
 * @property Client[] $clients0
 * @property Client[] $clients1
 * @property Jobgroup[] $jobgroups
 * @property Joborder[] $joborders
 * @property JobpubJob[] $jobpubJobs
 * @property PtMapping[] $ptMappings
 */
class GllueCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }


    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('gllueDB');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id', 'order'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name_en'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'name_en' => 'Name En',
            'parent_id' => 'Parent ID',
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillinginfos()
    {
        return $this->hasMany(Billinginfo::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidates()
    {
        return $this->hasMany(Candidate::className(), ['city1_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidates0()
    {
        return $this->hasMany(Candidate::className(), ['city2_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidates1()
    {
        return $this->hasMany(Candidate::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidates2()
    {
        return $this->hasMany(Candidate::className(), ['location1_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidates3()
    {
        return $this->hasMany(Candidate::className(), ['location2_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidates4()
    {
        return $this->hasMany(Candidate::className(), ['location_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(GllueCity::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGllueCities()
    {
        return $this->hasMany(GllueCity::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Client::className(), ['city1_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients0()
    {
        return $this->hasMany(Client::className(), ['city2_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients1()
    {
        return $this->hasMany(Client::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobgroups()
    {
        return $this->hasMany(Jobgroup::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJoborders()
    {
        return $this->hasMany(Joborder::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobpubJobs()
    {
        return $this->hasMany(JobpubJob::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtMappings()
    {
        return $this->hasMany(PtMapping::className(), ['city_id' => 'id']);
    }

}
