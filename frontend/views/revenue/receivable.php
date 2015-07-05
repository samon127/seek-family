<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Tool;
use common\models\Income;

$incomes = Income::find()
->where(['income_date'=>NULL])
->andWhere(['card'=>1])
->joinWith('project', true, 'LEFT JOIN')
->joinWith('project.type', true, 'LEFT JOIN')
->joinWith('project.teacher', true, 'LEFT JOIN')
->joinWith('project.city', true, 'LEFT JOIN')
->orderBy('project.date_start')
->all();

echo $this->render('@common/views/partial/incomeTable', ['incomes'=>$incomes]);
?>