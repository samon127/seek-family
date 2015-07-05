<?php

use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

$pid = Yii::$app->getRequest()->get('pid');

?>
<style>
.container-page{
  width:95%;
}
</style>

<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>



<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<ul class="nav nav-pills" style="float:right;padding:20px">
  <li role="presentation" class="active"><?php echo Html::a('新建支出', Url::to(['pay/edit', 'pid' => $pid])) ?></li>
</ul>



<table id="table_id" class="display">
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
            <td><?php echo Family::getProjectNames($pay->projects)?></td>
            <td><?php echo $pay->type->name ?></td>
            <td><?php echo $pay->pay_date ? $pay->pay_date : '应付账款' ?></td>
            <td><?php echo $pay->comment.Family::getSeperateByWeight($pid, $pay->projects, $pay->number) ?></td>
            <td style="text-align:right"><?php echo number_format(Family::getNumberByWeight($pid, $pay->projects, $pay->number), 2) ?></td>
            <td><?php echo Html::a('编辑', Url::to(['pay/edit', 'id' => $pay->id, 'pid' => Yii::$app->getRequest()->get('pid')])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<style>
.toolbar {
    float: left;
}
</style>

<script>
$(document).ready( function () {
    $('#table_id').DataTable({
    	"dom": '<"toolbar">frtip',
    	paging: false,
    	"info": false,
    	//"searching": false,
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

    $("div .toolbar").html('<b><?php echo '某某某项目' ?>支出明细表</b>');
} );
</script>