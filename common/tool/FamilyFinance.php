<?php
namespace common\tool;

use common\models\iProject;
use common\models\UserBalance;

class FamilyFinance
{
    public $allProjectFinance = [];

    public function initProjects($projectIds)
    {
        // 同时初始化多个project
    }

    public function initProject($projectId)
    {
        if (!isset($this->allProjectFinance[$projectId]))
        {
            $this->allProjectFinance[$projectId] = iProject::find()
            ->with('users')
            ->with('incomes')
            ->with('pays')
            ->with('pays.projects')
            ->with('times')
            ->with('times.project')
            ->with('times.user')
            ->orderBy('date_start')
            ->joinWith('type', true, 'LEFT JOIN')
            ->where(['=', 'project.id', $projectId])
            ->one();
        }
    }

    // 项目总收入
    public function getProjectTotleIncomes($projectId)
    {
        $this->initProject($projectId);
        $totle = 0;

        if (isset($this->allProjectFinance[$projectId]->incomes))
        {
            foreach ($this->allProjectFinance[$projectId]->incomes as $income) {
                $totle += $income->number;
            }
        }

        return $totle;
    }

    // 发票支出
    public function getProjectTotleInvoice($projectId)
    {
        $this->initProject($projectId);
        $totle = 0;

        if (isset($this->allProjectFinance[$projectId]->incomes))
        {
            foreach ($this->allProjectFinance[$projectId]->incomes as $income) {
                if ($income->invoice_code)
                {
                    $totle += $income->number*0.0506;
                }
            }
        }

        return $totle;
    }

    // 项目支出
    public function getProjectTotlePay($projectId)
    {
        $this->initProject($projectId);
        $totle = 0;

        if (isset($this->allProjectFinance[$projectId]->incomes))
        {
            foreach ($this->allProjectFinance[$projectId]->pays as $pay) {
                $totle += $this->getNumberByWeight($projectId, $pay->projects, $pay->number);
            }
        }

        return $totle;
    }

    private function getNumberByWeight($projectId, $projects, $number)
    {
        $total = $current = 0;
        foreach ($projects as $p) {
            if ($p->weight) {
                $total += $p->weight;
            } else {
                $total += 1;
            }

            if ($p->id == $projectId) {
                $current = $p->weight ? $p->weight : 1;
            }
        }

        if ($current == 0) {
            return $number;
        } else {
            return $number * $current / $total;
        }
    }

    // 人员支出
    public function getProjectTotleStuffPays($projectId)
    {
        $this->initProject($projectId);
        $totle = 0;

        if (isset($this->allProjectFinance[$projectId]->times))
        {
            $timeValue = 0;
            foreach ($this->allProjectFinance[$projectId]->times as $time)
            {
                $percentNumber = $time->percent;

// 这里不再考虑在一个total的项目组中进行时间设定的机制
//                 if ($time->project->parent_id)
//                 {
//                     $allSubProjects = iProject::find()->where(['parent_id' => $projectId])->all();
//                     $currentProject = iProject::find()->where(['id' => $projectId])->one();
//                     $percentNumber = $this->getTimePercentOfParent($time, $allSubProjects, $currentProject);
//                 }
//                 else
//                 {
//                     $percentNumber = $time->percent;
//                 }
                $timeValue += $percentNumber*$this->getUserBalance($time->user_id, $time->month)/100;
            }
        }

        return $timeValue;
    }

    private function getTimePercentOfParent($currentTime, $allSubProjects, $currentProject)
    {
        $total = $current = $currentWeight = 0;
        foreach ($allSubProjects as $project) {
            if ($project->weight) {
                $total += $project->weight;
            } else {
                $total += 1;
            }

            $currentWeight = $currentProject->weight ? $currentProject->weight : 1;
        }

        if ($total == 0)
        {
            return 0;
        }
        return $currentTime->percent * $currentWeight / $total;
    }

    private function getUserBalance($userId, $month)
    {
        $allBalance = UserBalance::find()
            ->where(['user_id' => $userId])
            ->andWhere(['<=', 'month', $month])
            ->orderBy('month DESC')
            ->all();

        if (!$allBalance) {
            return 0;
        } else {
            return $allBalance[0]->balance;
        }
    }

    public function getProjectTotalProfit($projectId)
    {
        $totalIncomes = $this->getProjectTotleIncomes($projectId);
        $totalInvoice = $this->getProjectTotleInvoice($projectId);
        $totalPays = $this->getProjectTotlePay($projectId);
        $totalStuffPays = $this->getProjectTotleStuffPays($projectId);

        return $totalIncomes - $totalInvoice - $totalPays - $totalStuffPays;
    }

    public function getTotalPartnerProfit($projectId)
    {
        $totalProfit = $this->getProjectTotalProfit($projectId);
        $project = iProject::find()->where(['id' => $projectId])->one();

        if (is_numeric($project->partner_profit)) {
            return $project->partner_profit;
        } else {
            return $totalProfit * $project->partner_profit / 100;
        }
    }

    public function getTotalTeamProfit($projectId)
    {
        $totalProfit = $this->getProjectTotalProfit($projectId);
        $totalPartnerProfit = $this->getTotalPartnerProfit($projectId);
        $project = iProject::find()->where(['id' => $projectId])->one();

        if (is_numeric($project->team_profit)) {
            return $project->team_profit;
        } else {

            $totalTeamProfit = ($totalProfit - $totalPartnerProfit) * $project->team_profit / 100;

            return $totalTeamProfit > 0 ? $totalTeamProfit : 0;
        }
    }

    public function getTotalCompanyProfit($projectId)
    {
        $totalProfit = $this->getProjectTotalProfit($projectId);
        $totalPartnerProfit = $this->getTotalPartnerProfit($projectId);
        $totalTeamProfit = $this->getTotalTeamProfit($projectId);

        return $totalProfit - $totalPartnerProfit - $totalTeamProfit;
    }
}
?>