<?php

use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

?>


<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>




<table id="table_id" class="display">
    <thead>
        <tr>
            <th>日期</th>
            <th>收入</th>
            <th>支出</th>
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
    <?php for($i=strtotime($date_end);$i>=strtotime($date_start);$i-=(60*60*24)): ?>
        <?php if (Family::financeInfoExist(date('Y-m-d', $i), $incomes, $pays)) :?>
        <tr>
            <td><?php echo date('Y-m-d', $i) ?></td>
            <td><?php echo Family::getDailyIncome(date('Y-m-d', $i), $incomes) ?></td>
            <td><?php echo Family::getDailyPay(date('Y-m-d', $i), $pays) ?></td>
            <td><?php echo Html::a('编辑', Url::to(['pay/edit'])) ?></td>
        </tr>
        <?php endif;?>
        <?php endfor; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#table_id').DataTable({
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