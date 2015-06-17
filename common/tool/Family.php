<?php
namespace common\tool;

use yii\helpers\Html;
use yii\helpers\Url;

class Family
{
	public static function getProjectName($project)
	{

		if ($project->name)
		{
		    return $project->name;
		}

		$name = '';
		if ($project->city)
		{
		    $name = $project->city->name . '-';
		}
	    if ($project->teacher)
	    {
	        $name .= $project->teacher->name . '-';
	    }
	    if ($project->client)
	    {
	        $name .= $project->client->name . '-';
	    }
	    $name .= $project->type->name;

	    if ($project->parent_id)
	    {
	        $name .= '（'.$project->parent->name.'）';
	    }

		return $name;
	}

	public function getProjectNames($projects)
	{
	    $name = '';
	    foreach ($projects as $project)
	    {
	        $name .= self::getProjectName($project) . '<br />';
	    }
        return $name;
	}

	public static function percentExist($month, $project, $userProjectTimes)
	{
	    foreach ($userProjectTimes as $userProjectTime)
	    {
            foreach ($userProjectTime->times as $time)
            {
                if ($time->month == $month && $time->project_id == $project->id)
                {
                    return $time->percent;
                }
            }
	    }

        return false;
	}

	public static function getProjectStyle($project)
	{
	    $styles = [ 1 => '独立项目', 2 => '母项目', 3 => '子项目'];

	    return $styles[$project->style];
	}


	public static function getNumberByWeight($projectId, $projects, $number)
	{
	    $total = $current = 0;
	    foreach ($projects as $p)
	    {
	        if ($p->weight)
	        {
	            $total += $p->weight;
	        }
	        else {
	            $total += 1;
	        }

	        if ($p->id == $projectId)
	        {
	            $current = $p->weight ? $p->weight : 1;
	        }
	    }

	    if ($current == 0)
	    {
	        return $number;
	    }
	    else {
	        return $number*$current/$total;
	    }
	}

	public static function getSeperateByWeight($projectId, $projects, $number)
	{
	    $total = $current = 0;
	    foreach ($projects as $p)
	    {
	        if ($p->weight)
	        {
	            $total += $p->weight;
	        }
	        else {
	            $total += 1;
	        }

	        if ($p->id == $projectId)
	        {
	            $current = $p->weight ? $p->weight : 1;
	        }
	    }

	    if ($total == $current)
	    {
	        return '';
	    }
	    else
	    {
	        return "（总费用".$number."的".$current."/".$total."）";
	    }
	}

	public static function displayDateArea($start, $end)
	{
	    $str = '';

	    $startYear = date('Y', strtotime($start));
	    $startMonth = date('m', strtotime($start));
	    $startDay = date('d', strtotime($start));

	    $endYear = date('Y', strtotime($end));
	    $endMonth = date('m', strtotime($end));
	    $endDay = date('d', strtotime($end));

	    if ($startYear == $endYear)
	    {
	        $str = $startYear.'年';
	    }
	    else
	    {
	        return date('Y年m月d日', strtotime($start)) .'-'. date('Y年m月d日', strtotime($end));
	    }

	    if ($startMonth == $endMonth)
	    {
	        $str .= $startMonth.'月';
	    }
	    else {
	        return date('Y年m月d日', strtotime($start)) .'-'. date('m月d日', strtotime($end));
	    }

	    if ($startDay == $endDay)
	    {
	        $str .= $startDay.'日';
	    }
	    else {
	        return date('Y年m月d日', strtotime($start)) .'-'. date('d日', strtotime($end));
	    }

	    return $str;
	}

	public static function getUserNames($users){
	    $name = '';
	    foreach ($users as $user)
	    {
	        $name .=  $user->english. '<br />';
	    }

	    if (!$name)
	    {
	        $name = '-';
	    }

	    return $name;
	}

	public static function getTotleIncomes($incomes)
	{
        $totle = 0;

        foreach ($incomes as $income)
        {
            $totle += $income->number;
        }

        return $totle;
	}

	public static function getTotlePays($project)
	{
	    $totle = 0;

	    foreach ($project->pays as $pay)
	    {
	        $totle += Family::getNumberByWeight($project->id, $pay->projects, $pay->number);
	    }

	    return $totle;
	}

	public static function getTotleStuffPays($times)
	{
	    $totle = 0;

	    foreach ($times as $time)
	    {
	        $totle += $time->percent*$time->user->balance_base/100;
	    }

	    return $totle;
	}

	public static function getPartnerProfit($totalProfit, $project)
	{
	    if (is_numeric($project->partner_profit))
	    {
	        return $project->partner_profit;
	    }
	    else {
	        return $totalProfit * $project->partner_profit / 100;
	    }
	}

	public static function getTeamProfit($totalProfit, $project)
	{
	    if (is_numeric($project->team_profit))
	    {
	        return $project->team_profit;
	    }
	    else {

	        $totalTeamProfit = $totalProfit * $project->team_profit / 100;

	        return $totalTeamProfit > 0 ? $totalTeamProfit : 0;
	    }
	}

	public static function getClinetNameById($clientId, $clients)
	{
        foreach ($clients as $client)
        {
            if ($client->id == $clientId)
            {
                return $client->name1." （".$client->name."）";
            }
        }

        return '-';
	}

	public static function financeInfoExist($date, $incomes, $pays)
	{
	    foreach ($incomes as $income)
	    {
	        if ($income->income_date == $date)
	        {
	            return true;
	        }
	    }
	}

	public static function getDailyIncome($date, $incomes)
	{
	    foreach ($incomes as $income)
	    {
	        if ($income->income_date == $date)
	        {
	            return Html::a($income->incomeSum, Url::to(['revenue/income-detail', 'date_start'=>$date, 'date_end'=>$date]));
	        }
	    }

	    return '-';
	}

	public static function getDailyPay($date, $pays)
	{
	    foreach ($pays as $pay)
	    {
	        if ($pay->pay_date == $date)
	        {
	            return Html::a($pay->paySum, Url::to(['revenue/pay-detail', 'date_start'=>$date, 'date_end'=>$date]));
	        }
	    }

	    return '-';
	}
}
