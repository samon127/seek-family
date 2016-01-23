<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;
use common\tool\Tool;
use common\models\Income;

$ids = [];
foreach ($incomes as $income)
{
    $ids[] = $income->client_id;
}

$random = rand(1,1000000);


$totalIncome = $totalIncomeCount = 0;
foreach ($incomes as $income)
{
    $totalIncome += $income->number;
}

$totalIncomeCount = count($incomes);
?>

<style>
.container-page{
  width:100%;
}
</style>

<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>
<?php $this->registerCssFile("/vendor/dataTables/extensions/ColVis/css/dataTables.colVis.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/extensions/ColVis/js/dataTables.colVis.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>






<table id="income_table<?php echo $random ?>" class="display">
    <thead>
        <tr>
            <th><?php echo Yii::t('app', 'Client Name') ?></th>
            <th><?php echo Yii::t('app', 'Project Name') ?></th>
            <th><?php echo Yii::t('app', 'Payment Date') ?></th>
            <th><?php echo Yii::t('app', 'Year Card') ?></th>
            <th><?php echo Yii::t('app', 'Invoice') ?></th>
            <th>BD</th>
            <th><?php echo Yii::t('app', 'Comment') ?></th>
            <th style="text-align:right"><?php echo Yii::t('app', 'Income') ?></th>
            <th><?php echo Yii::t('app', 'Operate') ?></th>
        </tr>
    </thead>
    <tfoot>
            <tr>
                <th colspan="8" style="text-align:right"></th>
                <th></th>
            </tr>
        </tfoot>
    <tbody>
    <?php foreach ($incomes as $income): ?>
        <tr>
            <td><?php echo Family::getClinetNameById($income->client_id, $ids)  ?></td>
            <td><?php echo Family::getProjectName($income->project, $ids) ?></td>
            <td>
            <?php
            if ($income->card == 2)
            {
                echo Yii::t('app', 'Year Card');
            }
            else if ($income->income_date)
            {
                echo HTML::a($income->income_date, Url::to(['revenue/income-detail', 'date_start'=>$income->income_date, 'date_end'=>$income->income_date]));
            }
            else {
                echo Yii::t('app', 'Accounts Receivable');
            }

             ?></td>
            <td><?php echo $income->card == 1 ? Yii::t('app', 'No'): Yii::t('app', 'Yes') ?></td>
            <td><?php echo $income->invoice_code ? $income->invoice_code : '无发票' ?></td>
            <td><?php echo isset($income->bd) ? $income->bd->english : '-' //Family::getBdNameById($income->client_id, $ids) ?></td>
            <td><?php echo $income->comment ?></td>
            <td style="text-align:right"><?php echo number_format($income->number, 2) ?></td>
            <td><?php echo Html::a(Yii::t('app', 'Edit'), Url::to(['income/edit', 'id' => $income->id, 'from' => Tool::getCurrentUrl()])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#income_table<?php echo $random ?>').DataTable({
    	"dom": 'C&gt;"clear"&lt;lfrtip',
    	"columnDefs": [
//                { "visible": false, "targets": 2 },
//                { "visible": false, "targets": 3 },
//                { "visible": false, "targets": 4 }
           ],
    	paging: false,
    	"info": false,
    	"searching": false,
    	"order": [2],
    	"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over this page
            pageTotal = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 7 ).footer() ).html(
            	'总收入：<span class="number">'+<?php echo $totalIncome ?>+'</span>&nbsp;&nbsp;&nbsp;收入笔数：<span>'+<?php echo $totalIncomeCount ?>+'</span>'
            );

            $('.number').autoNumeric('init');
        }
    });
} );
</script>