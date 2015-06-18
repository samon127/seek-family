<?php

use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;


?>

<?php $this->registerCssFile("/vendor/bootstrap-datepicker/datepicker3.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('vendor/bootstrap-datepicker/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>



<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>



<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<form class="form-horizontal" action="index.php" method="get">
<input type="hidden" name="r" value="revenue/pay-detail" />
<fieldset>

<!-- Form Name -->
<legend>支出查询</legend>

<div class="form-group">
  <label class="col-md-4 control-label" for="radios">时间段</label>
  <div class="col-md-4">
          <div class="input-daterange input-group" id="dateAreaPicker">
            <?php
            echo HTML::input('text', 'date_start', date('Y-m-d', strtotime($date_start)), ['id' => 'dateStartInput', 'class'=>'form-control input-md'] )
            ?>
            <span class="input-group-addon">to</span>
            <?php
            echo HTML::input('text', 'date_end', date('Y-m-d', strtotime($date_end)), ['id' => 'dateEndInput', 'class'=>'form-control input-md'] )
            ?>
        </div>
  </div>
</div>
<script>
$('#dateAreaPicker').datepicker({
	format: "yyyy-mm-dd",
});
</script>


<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="提交" />
    </div>
</div>




</fieldset>
</form>

<?php if ($date_start == $date_end) : ?>
<ul class="nav nav-pills" style="float:right;padding:20px">
    <li role="presentation" class="active"><a href="<?php echo Url::to(['pay/edit', 'pay_date'=>$date_start, 'category'=>1]) ?>" class="btn btn-primary btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> 新建支出</a></li>
</ul>
<?php endif; ?>



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
            <td><?php echo $pay->comment ?></td>
            <td style="text-align:right"><?php echo number_format($pay->number, 2) ?></td>
            <td><?php echo Html::a('编辑', Url::to(['pay/edit', 'id' => $pay->id])) ?></td>
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