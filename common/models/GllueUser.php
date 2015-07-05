<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $uid
 * @property string $user_type
 * @property integer $team_id
 * @property string $email
 * @property string $login_name
 * @property string $password
 * @property string $email_login_name
 * @property string $emailpassword
 * @property integer $twostepenable
 * @property string $twostepsecretkey
 * @property string $status
 * @property string $englishName
 * @property string $chineseName
 * @property integer $gender
 * @property integer $title_id
 * @property string $dateOfBirth
 * @property string $mobile
 * @property string $officeTel
 * @property string $fax
 * @property string $joinInDate
 * @property string $leaveDate
 * @property string $lang
 * @property integer $isleader
 * @property integer $emailReplyWithSignature
 * @property integer $emailForwardWithSignature
 * @property string $role
 * @property string $kpiReportView
 * @property string $revenueReportView
 * @property integer $kpiHide
 * @property integer $revenueHide
 * @property integer $annualTarget
 * @property integer $firstLogin
 * @property integer $enablePop
 * @property integer $email_error
 * @property string $public_key
 * @property string $listview
 * @property string $token
 * @property integer $datagroup_id
 * @property integer $accessgroup_id
 * @property integer $lastNews_id
 *
 * @property Attachment[] $attachments
 * @property Billinginfo[] $billinginfos
 * @property Billinginfo[] $billinginfos0
 * @property Calllog[] $calllogs
 * @property Canddiatesharerequest[] $canddiatesharerequests
 * @property Candidate[] $candidates
 * @property Candidate[] $candidates0
 * @property Candidate[] $candidates1
 * @property Candidate[] $candidates2
 * @property Candidatetargetcompany[] $candidatetargetcompanies
 * @property Client[] $clients
 * @property Client[] $clients0
 * @property Client[] $clients1
 * @property Clientcontract[] $clientcontracts
 * @property Clientcontract[] $clientcontracts0
 * @property Clientinterview[] $clientinterviews
 * @property Cvsent[] $cvsents
 * @property Email[] $emails
 * @property Emailtemplate[] $emailtemplates
 * @property Floating[] $floatings
 * @property Folder[] $folders
 * @property Folderitem[] $folderitems
 * @property Foldershare[] $foldershares
 * @property Interview[] $interviews
 * @property Interview[] $interviews0
 * @property Interview[] $interviews1
 * @property Invoice[] $invoices
 * @property Invoice[] $invoices0
 * @property Invoiceassignment[] $invoiceassignments
 * @property Invoicepaymentinfo[] $invoicepaymentinfos
 * @property Jobgroup[] $jobgroups
 * @property Jobgroup[] $jobgroups0
 * @property Joborder[] $joborders
 * @property Joborderuser[] $joborderusers
 * @property JobpubJob[] $jobpubJobs
 * @property Jobsubmission[] $jobsubmissions
 * @property Jobsubmissionstatuslog[] $jobsubmissionstatuslogs
 * @property Kpiuserconfig[] $kpiuserconfigs
 * @property LinkedinConnection[] $linkedinConnections
 * @property Loginlog[] $loginlogs
 * @property Message[] $messages
 * @property Message[] $messages0
 * @property News[] $news
 * @property Note[] $notes
 * @property Noteuser[] $noteusers
 * @property Offersign[] $offersigns
 * @property Onboard[] $onboards
 * @property Operationlog[] $operationlogs
 * @property PtAccount[] $ptAccounts
 * @property PtApply[] $ptApplies
 * @property PtPosting[] $ptPostings
 * @property PtPosting[] $ptPostings0
 * @property PtPostingCompanyinfo[] $ptPostingCompanyinfos
 * @property PtSession[] $ptSessions
 * @property Queryfilter[] $queryfilters
 * @property RecommendationItem[] $recommendationItems
 * @property Review[] $reviews
 * @property Review[] $reviews0
 * @property Rowupdatelog[] $rowupdatelogs
 * @property Sms[] $sms
 * @property Smstemplate[] $smstemplates
 * @property Targetcompany[] $targetcompanies
 * @property Todo[] $todos
 * @property Todouser[] $todousers
 * @property Updatelog[] $updatelogs
 * @property Accessgroup $accessgroup
 * @property Datagroup $datagroup
 * @property Team $team
 * @property Title $title
 * @property Userconfig[] $userconfigs
 * @property Userkey[] $userkeys
 */
class GllueUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
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
            [['team_id', 'email', 'status', 'title_id', 'kpiReportView', 'revenueReportView'], 'required'],
            [['team_id', 'twostepenable', 'gender', 'title_id', 'isleader', 'emailReplyWithSignature', 'emailForwardWithSignature', 'kpiHide', 'revenueHide', 'annualTarget', 'firstLogin', 'enablePop', 'email_error', 'datagroup_id', 'accessgroup_id', 'lastNews_id'], 'integer'],
            [['dateOfBirth', 'joinInDate', 'leaveDate'], 'safe'],
            [['listview'], 'string'],
            [['uid', 'user_type', 'email', 'login_name', 'password', 'email_login_name', 'twostepsecretkey'], 'string', 'max' => 50],
            [['emailpassword', 'englishName', 'role', 'kpiReportView', 'revenueReportView', 'public_key', 'token'], 'string', 'max' => 255],
            [['status', 'chineseName', 'mobile', 'officeTel', 'fax', 'lang'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'user_type' => 'User Type',
            'team_id' => 'Team ID',
            'email' => 'Email',
            'login_name' => 'Login Name',
            'password' => 'Password',
            'email_login_name' => 'Email Login Name',
            'emailpassword' => 'Emailpassword',
            'twostepenable' => 'Twostepenable',
            'twostepsecretkey' => 'Twostepsecretkey',
            'status' => 'Status',
            'englishName' => 'English Name',
            'chineseName' => 'Chinese Name',
            'gender' => 'Gender',
            'title_id' => 'Title ID',
            'dateOfBirth' => 'Date Of Birth',
            'mobile' => 'Mobile',
            'officeTel' => 'Office Tel',
            'fax' => 'Fax',
            'joinInDate' => 'Join In Date',
            'leaveDate' => 'Leave Date',
            'lang' => 'Lang',
            'isleader' => 'Isleader',
            'emailReplyWithSignature' => 'Email Reply With Signature',
            'emailForwardWithSignature' => 'Email Forward With Signature',
            'role' => 'Role',
            'kpiReportView' => 'Kpi Report View',
            'revenueReportView' => 'Revenue Report View',
            'kpiHide' => 'Kpi Hide',
            'revenueHide' => 'Revenue Hide',
            'annualTarget' => 'Annual Target',
            'firstLogin' => 'First Login',
            'enablePop' => 'Enable Pop',
            'email_error' => 'Email Error',
            'public_key' => 'Public Key',
            'listview' => 'Listview',
            'token' => 'Token',
            'datagroup_id' => 'Datagroup ID',
            'accessgroup_id' => 'Accessgroup ID',
            'lastNews_id' => 'Last News ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['addedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillinginfos()
    {
        return $this->hasMany(Billinginfo::className(), ['addedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillinginfos0()
    {
        return $this->hasMany(Billinginfo::className(), ['lastUpdateBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalllogs()
    {
        return $this->hasMany(Calllog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCanddiatesharerequests()
    {
        return $this->hasMany(Canddiatesharerequest::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidates()
    {
        return $this->hasMany(Candidate::className(), ['addedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidates0()
    {
        return $this->hasMany(Candidate::className(), ['lastUpdateBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidates1()
    {
        return $this->hasMany(Candidate::className(), ['mpcAddedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidates2()
    {
        return $this->hasMany(Candidate::className(), ['owner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidatetargetcompanies()
    {
        return $this->hasMany(Candidatetargetcompany::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Client::className(), ['addedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients0()
    {
        return $this->hasMany(Client::className(), ['bd_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients1()
    {
        return $this->hasMany(Client::className(), ['lastUpdateBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientcontracts()
    {
        return $this->hasMany(Clientcontract::className(), ['addedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientcontracts0()
    {
        return $this->hasMany(Clientcontract::className(), ['lastUpdateBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientinterviews()
    {
        return $this->hasMany(Clientinterview::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCvsents()
    {
        return $this->hasMany(Cvsent::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmails()
    {
        return $this->hasMany(Email::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailtemplates()
    {
        return $this->hasMany(Emailtemplate::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloatings()
    {
        return $this->hasMany(Floating::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolders()
    {
        return $this->hasMany(Folder::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolderitems()
    {
        return $this->hasMany(Folderitem::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoldershares()
    {
        return $this->hasMany(Foldershare::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviews()
    {
        return $this->hasMany(Interview::className(), ['contact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviews0()
    {
        return $this->hasMany(Interview::className(), ['interviewer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviews1()
    {
        return $this->hasMany(Interview::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['finance_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices0()
    {
        return $this->hasMany(Invoice::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceassignments()
    {
        return $this->hasMany(Invoiceassignment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoicepaymentinfos()
    {
        return $this->hasMany(Invoicepaymentinfo::className(), ['addedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobgroups()
    {
        return $this->hasMany(Jobgroup::className(), ['addedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobgroups0()
    {
        return $this->hasMany(Jobgroup::className(), ['owner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJoborders()
    {
        return $this->hasMany(Joborder::className(), ['addedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJoborderusers()
    {
        return $this->hasMany(Joborderuser::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobpubJobs()
    {
        return $this->hasMany(JobpubJob::className(), ['owner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobsubmissions()
    {
        return $this->hasMany(Jobsubmission::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobsubmissionstatuslogs()
    {
        return $this->hasMany(Jobsubmissionstatuslog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKpiuserconfigs()
    {
        return $this->hasMany(Kpiuserconfig::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinkedinConnections()
    {
        return $this->hasMany(LinkedinConnection::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoginlogs()
    {
        return $this->hasMany(Loginlog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['fromuser_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Message::className(), ['touser_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['addedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotes()
    {
        return $this->hasMany(Note::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoteusers()
    {
        return $this->hasMany(Noteuser::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffersigns()
    {
        return $this->hasMany(Offersign::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnboards()
    {
        return $this->hasMany(Onboard::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperationlogs()
    {
        return $this->hasMany(Operationlog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtAccounts()
    {
        return $this->hasMany(PtAccount::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtApplies()
    {
        return $this->hasMany(PtApply::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtPostings()
    {
        return $this->hasMany(PtPosting::className(), ['addedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtPostings0()
    {
        return $this->hasMany(PtPosting::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtPostingCompanyinfos()
    {
        return $this->hasMany(PtPostingCompanyinfo::className(), ['addedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtSessions()
    {
        return $this->hasMany(PtSession::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQueryfilters()
    {
        return $this->hasMany(Queryfilter::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecommendationItems()
    {
        return $this->hasMany(RecommendationItem::className(), ['addedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['reviewer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews0()
    {
        return $this->hasMany(Review::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRowupdatelogs()
    {
        return $this->hasMany(Rowupdatelog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSms()
    {
        return $this->hasMany(Sms::className(), ['sender_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSmstemplates()
    {
        return $this->hasMany(Smstemplate::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTargetcompanies()
    {
        return $this->hasMany(Targetcompany::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTodos()
    {
        return $this->hasMany(Todo::className(), ['addedBy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTodousers()
    {
        return $this->hasMany(Todouser::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatelogs()
    {
        return $this->hasMany(Updatelog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessgroup()
    {
        return $this->hasOne(Accessgroup::className(), ['id' => 'accessgroup_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDatagroup()
    {
        return $this->hasOne(Datagroup::className(), ['id' => 'datagroup_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitle()
    {
        return $this->hasOne(Title::className(), ['id' => 'title_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserconfigs()
    {
        return $this->hasMany(Userconfig::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserkeys()
    {
        return $this->hasMany(Userkey::className(), ['user_id' => 'id']);
    }
}
