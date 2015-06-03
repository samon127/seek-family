<?php
use yii\helpers\Html;
use yii\web\View;
?>

<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="moneyInput">金额</label>
  <div class="col-md-4">

  <div class="input-group">
  <span class="input-group-addon">¥</span>
  <?php
  echo HTML::input('text', $page.'[money]', $defaultNumber, ['id' => 'moneyInput', 'class'=>'form-control', 'data-a-dec'=>'.', 'data-a-sep'=>',', 'aria-label'=>'Amount (to the nearest dollar)'] )
  ?>
</div>
  </div>
</div>

<script>
$('#moneyInput').autoNumeric('init');
</script>