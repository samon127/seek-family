<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "candidate".
 *
 * @property integer $id
 * @property string $type
 * @property integer $is_mpc
 * @property string $mpcDate
 * @property integer $mpcAddedBy_id
 * @property integer $is_locked
 * @property integer $owner_id
 * @property integer $addedBy_id
 * @property integer $current_id
 * @property integer $company_id
 * @property string $title
 * @property string $englishName
 * @property string $chineseName
 * @property integer $gender
 * @property string $dateOfBirth
 * @property integer $monthNull
 * @property integer $dayNull
 * @property integer $location_id
 * @property integer $location1_id
 * @property integer $location2_id
 * @property integer $city_id
 * @property integer $city1_id
 * @property integer $city2_id
 * @property string $address
 * @property string $mobile
 * @property string $mobile1
 * @property string $mobile2
 * @property string $email
 * @property string $email1
 * @property string $email2
 * @property string $linkedin
 * @property string $dateAdded
 * @property string $lastUpdateDate
 * @property integer $lastUpdateBy_id
 * @property string $updated_date
 * @property string $school
 * @property string $education
 * @property string $english_level
 * @property string $nationality
 * @property string $status
 * @property integer $annualSalary
 * @property integer $salaryEstimate
 * @property integer $is_deleted
 * @property string $ext1
 * @property string $ext2
 * @property string $ext3
 * @property string $ext4
 * @property string $ext5
 * @property string $ext6
 * @property string $work_start
 * @property string $last_work_start
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
 * @property integer $industry_id
 * @property integer $industry1_id
 * @property integer $industry2_id
 * @property integer $function_id
 * @property integer $function1_id
 * @property integer $function2_id
 * @property string $source
 *
 * @property Calllog[] $calllogs
 * @property City $city1
 * @property City $city2
 * @property City $city
 * @property City $location1
 * @property City $location2
 * @property Client $company
 * @property Function $function1
 * @property Function $function2
 * @property Function $function
 * @property Industry $industry1
 * @property Industry $industry2
 * @property Industry $industry
 * @property City $location
 * @property User $addedBy
 * @property User $lastUpdateBy
 * @property User $mpcAddedBy
 * @property User $owner
 * @property Candidateeducation[] $candidateeducations
 * @property Candidateexperience[] $candidateexperiences
 * @property Candidatelanguage[] $candidatelanguages
 * @property Candidateproject[] $candidateprojects
 * @property Candidateshare[] $candidateshares
 * @property Candidatesharerequest[] $candidatesharerequests
 * @property Candidatetag[] $candidatetags
 * @property Candidatetargetcompany[] $candidatetargetcompanies
 * @property Floating[] $floatings
 * @property Floating[] $floatings0
 * @property Invoice[] $invoices
 * @property Invoice[] $invoices0
 * @property Jobordercontact[] $jobordercontacts
 * @property Jobsubmission[] $jobsubmissions
 * @property Message[] $messages
 * @property PtSiteresume[] $ptSiteresumes
 * @property RecommendationItem[] $recommendationItems
 * @property Sms[] $sms
 */
class GllueCandidate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'candidate';
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
            [['type', 'owner_id', 'addedBy_id', 'dateAdded', 'lastUpdateDate'], 'required'],
            [['is_mpc', 'mpcAddedBy_id', 'is_locked', 'owner_id', 'addedBy_id', 'current_id', 'company_id', 'gender', 'monthNull', 'dayNull', 'location_id', 'location1_id', 'location2_id', 'city_id', 'city1_id', 'city2_id', 'lastUpdateBy_id', 'annualSalary', 'salaryEstimate', 'is_deleted', 'industry_id', 'industry1_id', 'industry2_id', 'function_id', 'function1_id', 'function2_id'], 'integer'],
            [['mpcDate', 'dateOfBirth', 'dateAdded', 'lastUpdateDate', 'updated_date', 'work_start', 'last_work_start'], 'safe'],
            [['ext1', 'ext2', 'ext3', 'ext4', 'ext5', 'ext6', 'ext7', 'ext8', 'ext9', 'ext10', 'ext11', 'ext12', 'ext13', 'ext14', 'ext15', 'ext16', 'ext17', 'ext18', 'ext19', 'ext20'], 'string'],
            [['type', 'chineseName', 'status'], 'string', 'max' => 20],
            [['title', 'englishName', 'address', 'mobile', 'mobile1', 'mobile2', 'email', 'email1', 'email2', 'school'], 'string', 'max' => 100],
            [['linkedin'], 'string', 'max' => 255],
            [['education', 'english_level', 'nationality'], 'string', 'max' => 50],
            [['source'], 'string', 'max' => 64],
            [['mobile'], 'unique'],
            [['email'], 'unique'],
            [['linkedin'], 'unique']
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
            'is_mpc' => 'Is Mpc',
            'mpcDate' => 'Mpc Date',
            'mpcAddedBy_id' => 'Mpc Added By ID',
            'is_locked' => 'Is Locked',
            'owner_id' => 'Owner ID',
            'addedBy_id' => 'Added By ID',
            'current_id' => 'Current ID',
            'company_id' => 'Company ID',
            'title' => 'Title',
            'englishName' => 'English Name',
            'chineseName' => 'Chinese Name',
            'gender' => 'Gender',
            'dateOfBirth' => 'Date Of Birth',
            'monthNull' => 'Month Null',
            'dayNull' => 'Day Null',
            'location_id' => 'Location ID',
            'location1_id' => 'Location1 ID',
            'location2_id' => 'Location2 ID',
            'city_id' => 'City ID',
            'city1_id' => 'City1 ID',
            'city2_id' => 'City2 ID',
            'address' => 'Address',
            'mobile' => 'Mobile',
            'mobile1' => 'Mobile1',
            'mobile2' => 'Mobile2',
            'email' => 'Email',
            'email1' => 'Email1',
            'email2' => 'Email2',
            'linkedin' => 'Linkedin',
            'dateAdded' => 'Date Added',
            'lastUpdateDate' => 'Last Update Date',
            'lastUpdateBy_id' => 'Last Update By ID',
            'updated_date' => 'Updated Date',
            'school' => 'School',
            'education' => 'Education',
            'english_level' => 'English Level',
            'nationality' => 'Nationality',
            'status' => 'Status',
            'annualSalary' => 'Annual Salary',
            'salaryEstimate' => 'Salary Estimate',
            'is_deleted' => 'Is Deleted',
            'ext1' => 'Ext1',
            'ext2' => 'Ext2',
            'ext3' => 'Ext3',
            'ext4' => 'Ext4',
            'ext5' => 'Ext5',
            'ext6' => 'Ext6',
            'work_start' => 'Work Start',
            'last_work_start' => 'Last Work Start',
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
            'industry_id' => 'Industry ID',
            'industry1_id' => 'Industry1 ID',
            'industry2_id' => 'Industry2 ID',
            'function_id' => 'Function ID',
            'function1_id' => 'Function1 ID',
            'function2_id' => 'Function2 ID',
            'source' => 'Source',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalllogs()
    {
        return $this->hasMany(Calllog::className(), ['candidate_id' => 'id']);
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
    public function getLocation1()
    {
        return $this->hasOne(City::className(), ['id' => 'location1_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation2()
    {
        return $this->hasOne(City::className(), ['id' => 'location2_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Client::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunction1()
    {
        return $this->hasOne(GllueFunction::className(), ['id' => 'function1_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunction2()
    {
        return $this->hasOne(GllueFunction::className(), ['id' => 'function2_id']);
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
    public function getLocation()
    {
        return $this->hasOne(City::className(), ['id' => 'location_id']);
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
    public function getLastUpdateBy()
    {
        return $this->hasOne(User::className(), ['id' => 'lastUpdateBy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMpcAddedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'mpcAddedBy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidateeducations()
    {
        return $this->hasMany(Candidateeducation::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidateexperiences()
    {
        return $this->hasMany(Candidateexperience::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidatelanguages()
    {
        return $this->hasMany(Candidatelanguage::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidateprojects()
    {
        return $this->hasMany(Candidateproject::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidateshares()
    {
        return $this->hasMany(Candidateshare::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidatesharerequests()
    {
        return $this->hasMany(Candidatesharerequest::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidatetags()
    {
        return $this->hasMany(Candidatetag::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidatetargetcompanies()
    {
        return $this->hasMany(Candidatetargetcompany::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloatings()
    {
        return $this->hasMany(Floating::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloatings0()
    {
        return $this->hasMany(Floating::className(), ['clientContact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices0()
    {
        return $this->hasMany(Invoice::className(), ['receiver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobordercontacts()
    {
        return $this->hasMany(Jobordercontact::className(), ['clientContact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobsubmissions()
    {
        return $this->hasMany(Jobsubmission::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtSiteresumes()
    {
        return $this->hasMany(PtSiteresume::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecommendationItems()
    {
        return $this->hasMany(RecommendationItem::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSms()
    {
        return $this->hasMany(Sms::className(), ['receiver_id' => 'id']);
    }
}
