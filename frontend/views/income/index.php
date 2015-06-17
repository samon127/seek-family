<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

$pid = Yii::$app->getRequest()->get('pid');

?>

<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>



<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<ul class="nav nav-pills" style="float:right;padding:20px">
  <li role="presentation" class="active"><?php echo Html::a('新建收入', Url::to(['income/edit', 'pid' => $pid])) ?></li>
</ul>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>客户名称</th>
            <th>项目名称</th>
            <th>到账时间</th>
            <th>年卡</th>
            <th>发票</th>
            <th>备注</th>
            <th style="text-align:right">收入</th>
            <th>操作</th>
        </tr>
    </thead>
    <tfoot>
            <tr>
                <th colspan="7" style="text-align:right"></th>
                <th></th>
            </tr>
        </tfoot>
    <tbody>
    <?php foreach ($incomes as $income): ?>
        <tr>
            <td><?php echo Family::getClinetNameById($income->client_id, $clients)  ?></td>
            <td><?php echo Family::getProjectName($income->project) ?></td>
            <td>
            <?php
            if ($income->card == 2)
            {
                echo '年卡';
            }
            else if ($income->income_date)
            {
                echo $income->income_date;
            }
            else {
                echo '应收账款';
            }

             ?></td>
            <td><?php echo $income->card == 1 ? '否' : '是' ?></td>
            <td><?php echo $income->invoice == 2 ? '否' : '是' ?></td>
            <td><?php echo $income->comment ?></td>
            <td style="text-align:right"><?php echo number_format($income->number, 2) ?></td>
            <td><?php echo Html::a('编辑', Url::to(['income/edit', 'id' => $income->id, 'pid' => $pid])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#table_id').DataTable({
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
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 6 ).footer() ).html(
            	'合计：<span id="total">'+pageTotal+'</span>'
            );

            $('#total').autoNumeric('init');
        }
    });
} );
</script>