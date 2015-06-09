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
class iPay extends Pay
{
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])
        ->via('payProjects');
    }


}
