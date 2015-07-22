<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

?>

<style>
.container-page{
  width:100%;
}
</style>

<?php $this->registerCssFile("/vendor/bootstrap-datepicker/datepicker3.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('vendor/bootstrap-datepicker/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>




<form class="form-horizontal" action="index.php" method="get">
<input type="hidden" name="r" value="revenue/income-detail" />
<fieldset>

<!-- Form Name -->
<legend>收入查询</legend>

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

<?php
echo $this->render('@common/views/partial/incomeTable', ['incomes'=>$incomes]);
?>
