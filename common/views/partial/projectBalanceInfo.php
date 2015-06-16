<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

use common\models\Income;
use common\models\Time;
use common\models\iPay;

$pid = $project->id;

$incomes = Income::find()
->where(['project_id'=>$pid])
->joinWith('project', true, 'LEFT JOIN')
->joinWith('project.type', true, 'LEFT JOIN')
->joinWith('project.teacher', true, 'LEFT JOIN')
->joinWith('project.city', true, 'LEFT JOIN')
->orderBy('income.income_date')
->all();

$pays = iPay::find()
->where(['project_id'=>$pid])
->joinWith('type', true, 'LEFT JOIN')
->joinWith('projects', true, 'LEFT JOIN')
->joinWith('projects.type', true, 'LEFT JOIN')
->joinWith('projects.teacher', true, 'LEFT JOIN')
->joinWith('projects.city', true, 'LEFT JOIN')
->orderBy('pay.pay_date')
->all();

$times = Time::find()
->where(['project_id'=>$pid])
->joinWith('user', true, 'LEFT JOIN')
->all();


$random = rand(1,1000000);

?>

<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<!-- DataTables -->
<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<table id="income_table<?php echo $random ?>" class="display">
    <thead>
        <tr>
            <th>项目编号</th>
            <th>项目名称</th>
            <th>客户名称</th>
            <th>到账时间</th>
            <th>发票</th>
            <th style="text-align:right">收入</th>
            <th>操作</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th colspan="6" style="text-align:right"></th>
            <th></th>
        </tr>
    </tfoot>
    <tbody>
    <?php foreach ($incomes as $income): ?>
        <tr>
            <td><?php echo $income->id ?></td>
            <td><?php echo Family::getProjectName($income->project) ?></td>
            <td><?php echo Gllue::getClientById($income->client_id)['name'] ?></td>
            <td><?php echo $income->income_date ? $income->income_date : '应收账款' ?></td>
            <td><?php echo $income->invoice == 1 ? "开" : '不开' ?></td>
            <td style="text-align:right"><?php echo number_format($income->number, 2) ?></td>
            <td><?php echo Html::a('编辑', Url::to(['income/edit', 'id' => $income->id])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#income_table<?php echo $random ?>').DataTable({
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
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );



            // Update footer
            $( api.column( 5 ).footer() ).html(
            	'合计：<span id="total">'+Math.round(pageTotal*100)/100+'</span>'
            );

            $('#total').autoNumeric('init');
        }
    });
} );
</script>



<table id="pay_table<?php echo $random ?>" class="display">
    <thead>
        <tr>
            <th>项目编号</th>
            <th>项目名称</th>
            <th>分类</th>
            <th>支出时间</th>
            <th>备注</th>
            <th style="text-align:right">支出</th>
            <th>操作</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th colspan="6" style="text-align:right"></th>
            <th></th>
        </tr>
    </tfoot>
    <tbody>
    <?php foreach ($pays as $pay): ?>
        <tr>
            <td><?php echo $pay->id ?></td>
            <td><?php echo Family::getProjectName($project)?></td>
            <td><?php echo $pay->type->name ?></td>
            <td><?php echo $pay->pay_date ? $pay->pay_date : '应付账款' ?></td>
            <td><?php echo $pay->comment.Family::getSeperateByWeight($project->id, $pay->projects, $pay->number) ?></td>
            <td style="text-align:right"><?php echo number_format(Family::getNumberByWeight($project->id, $pay->projects, $pay->number), 2) ?></td>
            <td><?php echo Html::a('编辑', Url::to(['pay/edit', 'id' => $pay->id])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#pay_table<?php echo $random ?>').DataTable({
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
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 5 ).footer() ).html(
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
            <th>分配编号</th>
            <th>项目名称</th>
            <th>分配人</th>
            <th>分配月份</th>
            <th>分配比例</th>
            <th style="text-align:right">结算费用</th>
            <th>操作</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th colspan="6" style="text-align:right"></th>
            <th></th>
        </tr>
    </tfoot>
    <tbody>
    <?php foreach ($times as $time): ?>
        <tr>
            <td><?php echo $time->id ?></td>
            <td><?php echo Family::getProjectName($time->project)?></td>
            <td><?php echo $time->user->english ?></td>
            <td><?php echo $time->month ?></td>
            <td><?php echo $time->percent ?>%</td>
            <td style="text-align:right"><?php echo number_format($time->percent*$time->user->balance_base/100, 2) ?></td>
            <td><?php echo Html::a('编辑', Url::to(['pay/edit', 'id' => $time->id])) ?></td>
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
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b) ;
                }, 0 );

            // Update footer
            $( api.column( 5 ).footer() ).html(
            	'合计：<span id="total">'+Math.round(pageTotal*100)/100+'</span>'
            );

            //alert(pageTotal);

            $('#total').autoNumeric('init');
        }
    });
} );
</script>

<?php
$allIncome = 0;
foreach ($incomes as $income)
{
    $allIncome += $income->number;
}

$allInvoice = 0;
foreach ($incomes as $income)
{
    if ($income->invoice == 1)
    {
        $allInvoice += $income->number*0.0506;
    }
}

$allPay = 0;
foreach ($pays as $pay)
{
    $allPay += Family::getNumberByWeight($project->id, $pay->projects, $pay->number);
}

$timeValue = 0;
foreach ($times as $time)
{
    $timeValue += $time->percent*$time->user->balance_base/100;
}

$allProfit = $allIncome-$allInvoice-$allPay-$timeValue;
$allPartnerProfit = $allProfit*0.5;
$allOwnerProfit = ($allProfit-$allPartnerProfit)*0.2;

?>

<?php
if ($parentProject)
{
    echo $this->render('@common/views/partial/parentProjectBalanceInfo', ['parentProject'=>$parentProject]);
}
?>


<table id="balance_table<?php echo $random ?>" class="display">
    <thead>
        <tr>
            <th>名目</th>
            <th>金额</th>
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
            <td>项目收入</td>
            <td><?php echo number_format($allIncome, 2) ?></td>
        </tr>
        <tr>
            <td>发票支出</td>
            <td>-<?php echo number_format($allInvoice, 2) ?></td>
        </tr>
        <tr>
            <td>项目支出</td>
            <td>-<?php echo number_format($allPay, 2) ?></td>
        </tr>
        <tr>
            <td>人员支出</td>
            <td>-<?php echo number_format($timeValue, 2) ?></td>
        </tr>
        <tr>
            <td>项目收益</td>
            <td><?php echo number_format($allProfit, 2) ?></td>
        </tr>
        <tr>
            <td>合作伙伴收益</td>
            <td><?php echo number_format($allPartnerProfit, 2) ?></td>
        </tr>
        <tr>
            <td>项目组收益</td>
            <td><?php echo number_format($allOwnerProfit, 2) ?></td>
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