<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;
use common\tool\FamilyFinance;

use common\models\Income;
use common\models\Time;
use common\models\iPay;
use common\models\iUserBalance;

$pid = $currentProject->id;

$pays = iPay::find()
->where(['project_id'=>$pid])
->joinWith('type', true, 'LEFT JOIN')
->joinWith('projects', true, 'LEFT JOIN')
->joinWith('projects.type', true, 'LEFT JOIN')
->joinWith('projects.teacher', true, 'LEFT JOIN')
->joinWith('projects.city', true, 'LEFT JOIN')
->orderBy('pay.pay_date')
->all();

$times = Time::find()->where(['project_id'=>$pid]);
if ($currentProject->parent_id)
{
    $times = $times->orWhere(['project_id'=>$currentProject->parent_id]);
}
$times = $times->joinWith('user', true, 'LEFT JOIN')->all();


$random = rand(1,1000000);

?>

<?php

$incomes = Income::find()
->where(['project_id'=>$pid])
->joinWith('project', true, 'LEFT JOIN')
->joinWith('project.type', true, 'LEFT JOIN')
->joinWith('project.teacher', true, 'LEFT JOIN')
->joinWith('project.city', true, 'LEFT JOIN')
->orderBy('income.income_date')
->all();

echo $this->render('@common/views/partial/incomeTable', ['incomes'=>$incomes]);
?>


<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<!-- DataTables -->
<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<?php $this->registerJsFile('/vendor/dataTables/extensions/buttons/js/buttons.html5.min.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>
<?php $this->registerJsFile('/vendor/dataTables/extensions/buttons/js/dataTables.buttons.min.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>
<?php $this->registerJsFile('/vendor/dataTables/jszip.min.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>
<?php $this->registerCssFile("/vendor/dataTables/extensions/buttons/css/buttons.dataTables.min.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>



<table id="pay_table<?php echo $random ?>" class="display">
    <thead>
        <tr>
            <th><?php echo Yii::t('app', 'Project Name') ?></th>
            <th><?php echo Yii::t('app', 'Category') ?></th>
            <th><?php echo Yii::t('app', 'Pay Time') ?></th>
            <th><?php echo Yii::t('app', 'Comment') ?></th>
            <th style="text-align:right"><?php echo Yii::t('app', 'Pay') ?></th>
            <th><?php echo Yii::t('app', 'Operate') ?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th colspan="5" style="text-align:right"></th>
            <th></th>
        </tr>
    </tfoot>
    <tbody>
    <?php foreach ($pays as $pay): ?>
        <tr>
            <td><?php //echo Family::getProjectName($currentProject)?></td>
            <td><?php echo Yii::t('app', $pay->type->key) ?></td>
            <td><?php echo $pay->pay_date ? $pay->pay_date : Yii::t('app', 'Need to Pay') ?></td>
            <td><?php echo $pay->comment.Family::getSeperateByWeight($currentProject->id, $pay->projects, $pay->number) ?></td>
            <td style="text-align:right"><?php echo number_format(Family::getNumberByWeight($currentProject->id, $pay->projects, $pay->number), 2) ?></td>
            <td><?php echo Html::a(Yii::t('app', 'Edit'), Url::to(['pay/edit', 'id' => $pay->id])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#pay_table<?php echo $random ?>').DataTable({
    	"dom": 'BC&gt;"clear"&lt;lfrtip',
    	paging: false,
    	"info": false,
    	"searching": false,
    	"order": [],
    	buttons: [{
			extend: 'excelHtml5',
			text: '保存为Excel',
    	}],
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
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 4 ).footer() ).html(
            	'合计：<span id="total">'+Math.round(pageTotal*100)/100+'</span>'
            );

            $('#total').autoNumeric('init');
        }
    });
} );
</script>


<table id="time_table<?php echo $random ?>" class="display">
    <thead>
        <tr>
            <th><?php echo Yii::t('app', 'Project Name') ?></th>
            <th><?php echo Yii::t('app', 'Stuff') ?></th>
            <th><?php echo Yii::t('app', 'Month') ?></th>
            <th><?php echo Yii::t('app', 'Percent') ?></th>
            <th style="text-align:right"><?php echo Yii::t('app', 'Closing Cost') ?></th>
            <th><?php echo Yii::t('app', 'Operate') ?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th colspan="5" style="text-align:right"></th>
            <th></th>
        </tr>
    </tfoot>
    <tbody>
    <?php foreach ($times as $time): ?>
        <tr>
            <td><?php //echo Family::getProjectName($time->project) ?></td>
            <td><?php echo $time->user->english ?></td>
            <td><?php echo $time->month ?></td>
            <?php if ($time->project->style==2): ?>
                <td><?php echo $percentNumber = Family::getTimePercentOfParent($time, $allSubProjects, $currentProject); ?>% <?php echo Family::getTimePercentOfParentInfo($time, $allSubProjects, $currentProject); ?></td>
            <?php else: ?>
                <td><?php echo $percentNumber = $time->percent ?>%</td>
            <?php endif; ?>
            <td style="text-align:right"><?php echo number_format($percentNumber*iUserBalance::getUserBalance($time->user_id, $time->month)/100, 2) ?></td>
            <td><?php echo Html::a(Yii::t('app', 'Edit'), Url::to(['time/edit', 'id' => $time->id])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#time_table<?php echo $random ?>').DataTable({
    	paging: false,
    	"info": false,
    	"searching": false,
    	"order": [],
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
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b) ;
                }, 0 );

            // Update footer
            $( api.column( 4 ).footer() ).html(
            	'合计：<span id="total">'+Math.round(pageTotal*100)/100+'</span>'
            );

            //alert(pageTotal);

            $('#total').autoNumeric('init');
        }
    });
} );
</script>


<?php $finance = new FamilyFinance; ?>

<table id="balance_table<?php echo $random ?>" class="display">
    <thead>
        <tr>
            <th><?php echo Yii::t('app', 'Name') ?></th>
            <th><?php echo Yii::t('app', 'Number') ?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th colspan="1" style="text-align:right"></th>
            <th></th>
        </tr>
    </tfoot>
    <tbody>
        <tr>
            <td><?php echo Yii::t('app', 'Project Income') ?></td>
            <td><?php echo number_format($finance->getProjectTotleIncomes($pid), 2) ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('app', 'Invoice Expense') ?></td>
            <td>-<?php echo number_format($finance->getProjectTotleInvoice($pid), 2) ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('app', 'Project Pay') ?></td>
            <td>-<?php echo number_format($finance->getProjectTotlePay($pid), 2) ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('app', 'Stuff Pay') ?></td>
            <td>-<?php echo number_format($finance->getProjectTotleStuffPays($pid), 2) ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('app', 'Project Profit') ?></td>
            <td><?php echo number_format($finance->getProjectTotalProfit($pid), 2) ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('app', 'Cooperative Partner Profit') ?></td>
            <td><?php echo number_format($finance->getTotalPartnerProfit($pid), 2) ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('app', 'Team Profit') ?></td>
            <td><?php echo number_format($finance->getTotalTeamProfit($pid), 2) ?></td>
        </tr>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#balance_table<?php echo $random ?>').DataTable({
    	paging: false,
    	"info": false,
    	"searching": false,
    	"order": [],
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
                .column( 1, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b) ;
                }, 0 );

            // Update footer
            $( api.column( 1 ).footer() ).html(
            	//'项目收益：<span id="total">'+Math.round(pageTotal*100)/100+'</span>'
            );

            //alert(pageTotal);

            $('#total').autoNumeric('init');
        }
    });
} );
</script>