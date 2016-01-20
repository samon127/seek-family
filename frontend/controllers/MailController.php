<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\Income;
use common\models\iGllueClient;
use common\models\GllueUser;
use common\tool\DBList;
use common\models\GllueJoborder;
use common\models\GllueJobsubmission;
use common\models\GllueCandidate;

class MailController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {

        exit;
        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, "http://api.sendcloud.net/apiv2/mail/send");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'apiUser' => 'marvin',
            'apiKey' => '2ZlvbaUOXDbEqUU6',
            'from' => 'marvin.ma@www.seek-training.com',
            'subject' => '【斯程国际】2016年度猎头峰会，硅谷猎头行，2015年中国猎头行业分析报告',
            'html' => file_get_contents('../views/test/test.php'),
            'fromName' => '斯程国际',
            'replyTo' => 'marvin.ma@seek-training.com',
            'useAddressList' => 'true',
            'to' => 'ls-list4-1@maillist.sendcloud.org',
            //'xsmtpapi'=> json_encode(array('to'=>array('')))
        ]));


        // grab URL and pass it to the browser
        curl_exec($ch);

        // close cURL resource, and free up system resources
        curl_close($ch);
        exit;


        return $this->render('index');
    }



}
