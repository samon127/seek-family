<?php

namespace common\models;

use Yii;


class iGllueClient extends GllueClient
{


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBd()
    {
        return $this->hasOne(GllueUser::className(), ['id' => 'bd_id']);
    }
}
