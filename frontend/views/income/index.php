<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

?>
<!-- DataTables CSS -->

<link rel="stylesheet" type="text/css" href="/vendor/dataTables/jquery.dataTables.css">

<!-- DataTables -->
<?php $this->registerJsFile('/vendor/dataTables/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<!-- DataTables -->
<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>项目编号</th>
            <th>项目名称</th>
            <th style="text-align:right">收入</th>
            <th>操作</th>
        </tr>
    </thead>
    <tfoot>
            <tr>
                <th colspan="3" style="text-align:right"></th>
                <th></th>
            </tr>
        </tfoot>
    <tbody>
    <?php foreach ($incomes as $income): ?>
        <tr>
            <td><?php echo $income->id ?></td>
            <td><?php echo Family::getProjectName($income->project) ?></td>
            <td style="text-align:right"><?php echo number_format($income->number, 2) ?></td>
            <td><?php echo Html::a('编辑', Url::to(['income/edit', 'id' => $income->id])) ?></td>
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
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 2 ).footer() ).html(
            	'Total: <span id="total">'+pageTotal+'</span>'
            );

            $('#total').autoNumeric('init');
        }
    });
} );
</script>