<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;


use common\tool\FamilyFinance;
$finance = new FamilyFinance;

$clientIds = [];
foreach ($projects as $project)
{
    if ($project['client_id'])
    {
        $clientIds[] = $project['client_id'];
    }
}

function hasProjectBonusesUser($projectBonuses, $userId)
{
    foreach ($projectBonuses as $index => $bonus)
    {
        if ($bonus['user_id'] == $userId)
        {
            return $index;
        }
    }
    return false;
}

$userBonuses = array();

?>

<style>
.container-page{
  width:120%;
}
</style>

<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<!-- DataTables -->
<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>



<table id="table_id" class="display">
    <thead>
        <tr>
            <th>月份</th>
            <th>执行时间</th>
             <th>项目名称</th>
            <?php foreach ($users as $userId => $user) : ?>
                <th><?php echo $user ?></th>
            <?php endforeach; ?>
            <th>合计</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($projects as $key => $project): ?>
    <?php $teamProfit = $finance->getTotalTeamProfit($project->id) ?>
        <tr>
            <td><?php echo date('Y年m月', strtotime($project->date_start))  ?></td>
            <td><?php echo Family::displayDateArea($project->date_start, $project->date_end)  ?></td>
            <!-- <td><?php //echo Family::getProjectStyle($project) ?></td> -->
            <td><?php echo Family::getProjectName($project, $clientIds) ?></td>
            <?php $total=0; ?>
            <?php foreach ($users as $userId => $user) : ?>
                <?php $index = hasProjectBonusesUser($project->projectBonuses, $userId); ?>
                <?php if ($index !== false) : ?>
                    <?php $total += $project->projectBonuses[$index]['part']; ?>
                    <th class="money"><?php

                    $temp = $project->projectBonuses[$index]['part']*$teamProfit/100;

                    echo $temp;

                    @$userBonuses[$userId] += $temp;
                    ?></th>
                <?php else : ?>
                    <th></th>
                <?php endif; ?>
            <?php endforeach; ?>
            <th><?php echo $total.'%'; ?></th>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
foreach ($userBonuses as $userId => $bonuses)
{
    echo $users[$userId] . ' <span class="money">'.$bonuses.'</span><br />';
}

?>

<script>
$(document).ready( function () {
    $('#table_id').DataTable({
    	paging: false,
    	"info": false,
    	"searching": true,
    });

    $('.money').autoNumeric('init');
} );
</script>