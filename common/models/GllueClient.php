<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property string $type
 * @property integer $parent_id
 * @property string $name
 * @property string $name1
 * @property string $name2
 * @property integer $city_id
 * @property integer $city1_id
 * @property integer $city2_id
 * @property integer $bd_id
 * @property integer $industry_id
 * @property integer $industry1_id
 * @property integer $industry2_id
 * @property string $verifystatus
 * @property string $ext1
 * @property string $ext2
 * @property string $ext3
 * @property string $ext4
 * @property string $ext5
 * @property string $ext6
 * @property integer $addedBy_id
 * @property string $dateAdded
 * @property string $lastUpdateDate
 * @property integer $lastUpdateBy_id
 * @property string $ext7
 * @property string $ext8
 * @property string $ext9
 * @property string $ext10
 * @property string $ext11
 * @property string $ext12
 * @property string $ext13
 * @property string $ext14
 * @property string $ext15
 * @property string $ext16
 * @property string $ext17
 * @property string $ext18
 * @property string $ext19
 * @property string $ext20
 * @property integer $is_parent
 *
 * @property Candidate[] $candidates
 * @property Candidateexperience[] $candidateexperiences
 * @property Candidatetargetcompany[] $candidatetargetcompanies
 * @property City $city1
 * @property City $city2
 * @property City $city
 * @property Industry $industry1
 * @property Industry $industry2
 * @property Industry $industry
 * @property User $addedBy
 * @property User $bd
 * @property User $lastUpdateBy
 * @property Clientalias[] $clientaliases
 * @property Clientbilling[] $clientbillings
 * @property Clientcontract[] $clientcontracts
 * @property Clientshare[] $clientshares
 * @property Invoice[] $invoices
 * @property Jobgroup[] $jobgroups
 * @property Joborder[] $joborders
 * @property Message[] $messages
 * @property Targetcompany[] $targetcompanies
 */
class GllueClient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
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
            [['type', 'name', 'addedBy_id', 'dateAdded', 'lastUpdateDate'], 'required'],
            [['parent_id', 'city_id', 'city1_id', 'city2_id', 'bd_id', 'industry_id', 'industry1_id', 'industry2_id', 'addedBy_id', 'lastUpdateBy_id', 'is_parent'], 'integer'],
            [['ext1', 'ext2', 'ext3', 'ext4', 'ext5', 'ext6', 'ext7', 'ext8', 'ext9', 'ext10', 'ext11', 'ext12', 'ext13', 'ext14', 'ext15', 'ext16', 'ext17', 'ext18', 'ext19', 'ext20'], 'string'],
            [['dateAdded', 'lastUpdateDate'], 'safe'],
            [['type', 'verifystatus'], 'string', 'max' => 20],
            [['name', 'name1', 'name2'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'name1' => 'Name1',
            'name2' => 'Name2',
            'city_id' => 'City ID',
            'city1_id' => 'City1 ID',
            'city2_id' => 'City2 ID',
            'bd_id' => 'Bd ID',
            'industry_id' => 'Industry ID',
            'industry1_id' => 'Industry1 ID',
            'industry2_id' => 'Industry2 ID',
            'verifystatus' => 'Verifystatus',
            'ext1' => 'Ext1',
            'ext2' => 'Ext2',
            'ext3' => 'Ext3',
            'ext4' => 'Ext4',
            'ext5' => 'Ext5',
            'ext6' => 'Ext6',
            'addedBy_id' => 'Added By ID',
            'dateAdded' => 'Date Added',
            'lastUpdateDate' => 'Last Update Date',
            'lastUpdateBy_id' => 'Last Update By ID',
            'ext7' => 'Ext7',
            'ext8' => 'Ext8',
            'ext9' => 'Ext9',
            'ext10' => 'Ext10',
            'ext11' => 'Ext11',
            'ext12' => 'Ext12',
            'ext13' => 'Ext13',
            'ext14' => 'Ext14',
            'ext15' => 'Ext15',
            'ext16' => 'Ext16',
            'ext17' => 'Ext17',
            'ext18' => 'Ext18',
            'ext19' => 'Ext19',
            'ext20' => 'Ext20',
            'is_parent' => 'Is Parent',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidates()
    {
        return $this->hasMany(Candidate::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidateexperiences()
    {
        return $this->hasMany(Candidateexperience::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidatetargetcompanies()
    {
        return $this->hasMany(Candidatetargetcompany::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity1()
    {
        return $this->hasOne(City::className(), ['id' => 'city1_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity2()
    {
        return $this->hasOne(City::className(), ['id' => 'city2_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustry1()
    {
        return $this->hasOne(Industry::className(), ['id' => 'industry1_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustry2()
    {
        return $this->hasOne(Industry::className(), ['id' => 'industry2_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustry()
    {
        return $this->hasOne(Industry::className(), ['id' => 'industry_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'addedBy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBd()
    {
        return $this->hasOne(User::className(), ['id' => 'bd_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdateBy()
    {
        return $this->hasOne(User::className(), ['id' => 'lastUpdateBy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientaliases()
    {
        return $this->hasMany(Clientalias::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientbillings()
    {
        return $this->hasMany(Clientbilling::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientcontracts()
    {
        return $this->hasMany(Clientcontract::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientshares()
    {
        return $this->hasMany(Clientshare::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobgroups()
    {
        return $this->hasMany(Jobgroup::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJoborders()
    {
        return $this->hasMany(Joborder::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTargetcompanies()
    {
        return $this->hasMany(Targetcompany::className(), ['client_id' => 'id']);
    }
}
