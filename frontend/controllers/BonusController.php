<?php
namespace frontend\controllers;


use yii\web\controller;
use common\models\Project;
use common\models\iProject;
use common\models\ProjectBonus;

class BonusController extends Controller
{
    public function actionList()
    {
        $projects = iProject::find()
        ->with('projectBonuses')
        ->orderBy('date_start')
        ->where(['>=', 'date_start', '2015-08-01'])
        ->all();

        $users = array(
            1 => 'Ivy',
            2 => 'Michael',
            3=> 'Caroline',
            4=> 'Helen',
            5=> 'Scarlet',
            6=> 'Lynn',
            9=> 'Dyson',
        );

        return $this->render('list', ['projects'=>$projects, 'users'=>$users]);
    }

}