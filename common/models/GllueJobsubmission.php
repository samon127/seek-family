<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jobsubmission".
 *
 * @property integer $id
 * @property integer $joborder_id
 * @property integer $candidate_id
 * @property string $currentStatus
 * @property integer $active
 * @property integer $user_id
 * @property string $dateAdded
 * @property string $lastUpdateDate
 * @property string $signDate
 * @property string $estimate_onboardDate
 * @property string $onboardDate
 * @property string $probationDate
 * @property string $mark
 * @property string $source
 * @property integer $account_id
 * @property string $apply_id
 * @property integer $position_id
 * @property string $apply_time
 * @property integer $is_feedback
 * @property integer $siteresume_id
 * @property integer $is_read
 *
 * @property Clientinterview[] $clientinterviews
 * @property Cvsent[] $cvsents
 * @property Email[] $emails
 * @property Interview[] $interviews
 * @property Invoice[] $invoices
 * @property Candidate $candidate
 * @property Joborder $joborder
 * @property PtAccount $account
 * @property PtPosition $position
 * @property PtSiteresume $siteresume
 * @property User $user
 * @property Jobsubmissionstatuslog[] $jobsubmissionstatuslogs
 * @property Note[] $notes
 * @property Offersign[] $offersigns
 * @property Onboard[] $onboards
 * @property Review[] $reviews
 */
class GllueJobsubmission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jobsubmission';
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
            [['joborder_id', 'candidate_id', 'active', 'user_id', 'account_id', 'position_id', 'is_feedback', 'siteresume_id', 'is_read'], 'integer'],
            [['dateAdded', 'lastUpdateDate', 'source'], 'required'],
            [['dateAdded', 'lastUpdateDate', 'signDate', 'estimate_onboardDate', 'onboardDate', 'probationDate', 'apply_time'], 'safe'],
            [['currentStatus', 'mark'], 'string', 'max' => 50],
            [['source', 'apply_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'joborder_id' => 'Joborder ID',
            'candidate_id' => 'Candidate ID',
            'currentStatus' => 'Current Status',
            'active' => 'Active',
            'user_id' => 'User ID',
            'dateAdded' => 'Date Added',
            'lastUpdateDate' => 'Last Update Date',
            'signDate' => 'Sign Date',
            'estimate_onboardDate' => 'Estimate Onboard Date',
            'onboardDate' => 'Onboard Date',
            'probationDate' => 'Probation Date',
            'mark' => 'Mark',
            'source' => 'Source',
            'account_id' => 'Account ID',
            'apply_id' => 'Apply ID',
            'position_id' => 'Position ID',
            'apply_time' => 'Apply Time',
            'is_feedback' => 'Is Feedback',
            'siteresume_id' => 'Siteresume ID',
            'is_read' => 'Is Read',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientinterviews()
    {
        return $this->hasMany(Clientinterview::className(), ['jobsubmission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCvsents()
    {
        return $this->hasMany(Cvsent::className(), ['jobsubmission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmails()
    {
        return $this->hasMany(Email::className(), ['jobsubmission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviews()
    {
        return $this->hasMany(Interview::className(), ['jobsubmission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['jobsubmission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidate()
    {
        return $this->hasOne(GllueCandidate::className(), ['id' => 'candidate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJoborder()
    {
        return $this->hasOne(Joborder::className(), ['id' => 'joborder_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(PtAccount::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(PtPosition::className(), ['id' => 'position_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiteresume()
    {
        return $this->hasOne(PtSiteresume::className(), ['id' => 'siteresume_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobsubmissionstatuslogs()
    {
        return $this->hasMany(Jobsubmissionstatuslog::className(), ['jobsubmission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotes()
    {
        return $this->hasMany(Note::className(), ['jobsubmission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffersigns()
    {
        return $this->hasMany(Offersign::className(), ['jobsubmission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnboards()
    {
        return $this->hasMany(Onboard::className(), ['jobsubmission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['jobsubmission_id' => 'id']);
    }
}
