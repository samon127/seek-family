<?php
use yii\helpers\Html;
use yii\web\View;
?>

<?php $this->registerCssFile("/vendor/bootstrap-datepicker/datepicker3.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('vendor/bootstrap-datepicker/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="dateInput"><?php echo $label ?></label>
  <div class="col-md-4">
  <?php
  echo HTML::input('text', $page.'[month]', $defaultMonth, ['id' => 'monthInput', 'class'=>'form-control input-md'] )
  ?>
  <span class="help-block"><?php echo $help ?></span>
  </div>
</div>

<script>
$('#monthInput').datepicker({
	format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months"
});
</script>