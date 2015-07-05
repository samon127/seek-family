<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

use common\models\Income;
use common\models\Time;
use common\models\iPay;

?>

<style>
.container-page{
  width:100%;
}
</style>


<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>
<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>



<?php
$globalIncomes = $globalInvoicePays = $globalPays = $globalStuffPays = $globalProfit = $globalPartnerProfit = $globalTeamProfit = $globalCompanyProfit = 0
?>



<table id="table_id" class="display">
    <thead>
        <tr>
            <th><?php echo Yii::t('app', 'Project Name') ?></th>
            <th><?php echo Yii::t('app', 'Project Time') ?></th>
            <th><?php echo Yii::t('app', 'Project Income') ?></th>
            <th><?php echo Yii::t('app', 'Invoice Expense') ?></th>
            <th><?php echo Yii::t('app', 'Project Pay') ?></th>
            <th><?php echo Yii::t('app', 'Stuff Pay') ?></th>
            <th><?php echo Yii::t('app', 'Project Profit') ?></th>
            <th><?php echo Yii::t('app', 'Cooperative Partner Profit') ?></th>
            <th><?php echo Yii::t('app', 'Team Profit') ?></th>
            <th><?php echo Yii::t('app', 'Seek-Training Profit') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($projects as $project): ?>
        <tr>
            <td><?php echo Family::getProjectName($project)?></td>
            <td><?php echo Family::displayDateArea($project->date_start, $project->date_end)  ?></td>
            <td class="money"><?php echo $totalIncomes = Family::getTotleIncomes($project->incomes); $globalIncomes += $totalIncomes; ?></td>
            <td class="money"><?php echo $totalInvoicePays = Family::getInvoicePays($project->incomes); $globalInvoicePays += $totalInvoicePays; ?></td>
            <td class="money"><?php echo $totalPays = Family::getTotlePays($project); $globalPays += $totalPays; ?></td>
            <td class="money"><?php echo $totalStuffPays = Family::getTotleStuffPays($project->times); $globalStuffPays += $totalStuffPays; ?></td>
            <td class="money"><?php echo $totalProfit = $totalIncomes - $totalInvoicePays - $totalPays - $totalStuffPays; $globalProfit += $totalProfit; ?></td>
            <td class="money"><?php echo $totalPartnerProfit = Family::getPartnerProfit($totalProfit, $project); $globalPartnerProfit += $totalPartnerProfit;  ?></td>
            <td class="money"><?php echo $totalTeamProfit = Family::getTeamProfit($totalProfit - $totalPartnerProfit, $project); $globalTeamProfit += $totalTeamProfit;  ?></td>
            <td class="money"><?php echo $totalCompanyProfit = $totalProfit - $totalPartnerProfit - $totalTeamProfit; $globalCompanyProfit += $totalCompanyProfit; ?></td>
        </tr>
        <?php endforeach; ?>

    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td><b><?php echo Yii::t('app', 'Total') ?></b></td>
            <td class="money"><?php echo $globalIncomes; ?></td>
            <td class="money"><?php echo $globalInvoicePays; ?></td>
            <td class="money"><?php echo $globalPays; ?></td>
            <td class="money"><?php echo $globalStuffPays; ?></td>
            <td class="money"><?php echo $globalProfit; ?></td>
            <td class="money"><?php echo $globalPartnerProfit;  ?></td>
            <td class="money"><?php echo $globalTeamProfit;  ?></td>
            <td class="money"><?php echo $globalCompanyProfit; ?></td>
        </tr>
    </tfoot>
</table>

<script>
$(document).ready( function () {
    $('#table_id').DataTable({
    	paging: false,
    	"info": false,
    	"searching": false,
    	"order": [[1, 'asc']],

    });

    $('.money').autoNumeric('init');
} );
</script>

