<?php
use yii\helpers\HTMl;
use yii\web\View;
?>

<link href="vendor/bootstrap-datepicker/datepicker3.css" rel="stylesheet" />

<?php $this->registerJsFile('vendor/bootstrap-datepicker/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="dateInput"><?php echo $label ?></label>
  <div class="col-md-4">
  <?php
  echo HTML::input('text', $page.'[date]', $defaultDate, ['id' => 'dateInput', 'class'=>'form-control input-md'] )
  ?>
  <span class="help-block"><?php echo $help ?></span>
  </div>
</div>

<script>
$('#dateInput').datepicker({
	format: "yyyy-mm-dd"
});
</script>