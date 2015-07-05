<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "joborder".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $function_id
 * @property integer $addedBy_id
 * @property string $priority
 * @property string $jobStatus
 * @property integer $totalCount
 * @property integer $annualSalary
 * @property string $jobTitle
 * @property integer $city_id
 * @property string $openDate
 * @property string $closeDate
 * @property integer $contract_id
 * @property string $dateAdded
 * @property string $lastUpdateDate
 * @property string $ext1
 * @property string $ext2
 * @property string $ext3
 * @property string $ext4
 * @property string $ext5
 * @property string $ext6
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
 * @property integer $is_deleted
 * @property integer $jobgroup_id
 *
 * @property Invoice[] $invoices
 * @property City $city
 * @property Client $client
 * @property Clientcontract $contract
 * @property Function $function
 * @property Jobgroup $jobgroup
 * @property User $addedBy
 * @property Jobordercontact[] $jobordercontacts
 * @property Jobordertag[] $jobordertags
 * @property Joborderuser[] $joborderusers
 * @property JobpubJob[] $jobpubJobs
 * @property Jobsubmission[] $jobsubmissions
 * @property Message[] $messages
 * @property PtPosting[] $ptPostings
 * @property Targetcompany[] $targetcompanies
 */
class GllueJoborder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'joborder';
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
            [['client_id', 'addedBy_id', 'jobStatus', 'totalCount', 'jobTitle', 'dateAdded', 'lastUpdateDate'], 'required'],
            [['client_id', 'function_id', 'addedBy_id', 'totalCount', 'annualSalary', 'city_id', 'contract_id', 'is_deleted', 'jobgroup_id'], 'integer'],
            [['openDate', 'closeDate', 'dateAdded', 'lastUpdateDate'], 'safe'],
            [['ext1', 'ext2', 'ext3', 'ext4', 'ext5', 'ext6', 'ext7', 'ext8', 'ext9', 'ext10', 'ext11', 'ext12', 'ext13', 'ext14', 'ext15', 'ext16', 'ext17', 'ext18', 'ext19', 'ext20'], 'string'],
            [['priority', 'jobStatus'], 'string', 'max' => 20],
            [['jobTitle'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'function_id' => 'Function ID',
            'addedBy_id' => 'Added By ID',
            'priority' => 'Priority',
            'jobStatus' => 'Job Status',
            'totalCount' => 'Total Count',
            'annualSalary' => 'Annual Salary',
            'jobTitle' => 'Job Title',
            'city_id' => 'City ID',
            'openDate' => 'Open Date',
            'closeDate' => 'Close Date',
            'contract_id' => 'Contract ID',
            'dateAdded' => 'Date Added',
            'lastUpdateDate' => 'Last Update Date',
            'ext1' => 'Ext1',
            'ext2' => 'Ext2',
            'ext3' => 'Ext3',
            'ext4' => 'Ext4',
            'ext5' => 'Ext5',
            'ext6' => 'Ext6',
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
            'is_deleted' => 'Is Deleted',
            'jobgroup_id' => 'Jobgroup ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['joborder_id' => 'id']);
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
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Clientcontract::className(), ['id' => 'contract_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunction()
    {
        return $this->hasOne(GllueFunction::className(), ['id' => 'function_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobgroup()
    {
        return $this->hasOne(Jobgroup::className(), ['id' => 'jobgroup_id']);
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
    public function getJobordercontacts()
    {
        return $this->hasMany(Jobordercontact::className(), ['joborder_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobordertags()
    {
        return $this->hasMany(Jobordertag::className(), ['joborder_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJoborderusers()
    {
        return $this->hasMany(Joborderuser::className(), ['joborder_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobpubJobs()
    {
        return $this->hasMany(JobpubJob::className(), ['joborder_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobsubmissions()
    {
        return $this->hasMany(Jobsubmission::className(), ['joborder_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['joborder_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtPostings()
    {
        return $this->hasMany(PtPosting::className(), ['joborder_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTargetcompanies()
    {
        return $this->hasMany(Targetcompany::className(), ['joborder_id' => 'id']);
    }
}
