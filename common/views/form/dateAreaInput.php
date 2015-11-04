<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;


?>


<?php $this->registerCssFile("/vendor/bootstrap-datepicker/datepicker3.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('vendor/bootstrap-datepicker/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<?php
$rand = rand(0,100000);
?>



<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios"><?php echo $label ?></label>
  <div class="col-md-4">
          <div class="input-daterange input-group" id="dateAreaPicker<?php echo $rand ?>">
            <?php
            $dateStart = isset($defaultDates['date_start']) ? $defaultDates['date_start'] : '';
            echo HTML::input('text', $page.'[date_start]', $dateStart, ['id' => 'dateStartInput', 'class'=>'form-control input-md'] )
            ?>
            <span class="input-group-addon">to</span>
            <?php
            $dateEnd = isset($defaultDates['date_end']) ? $defaultDates['date_end'] : '';
            echo HTML::input('text', $page.'[date_end]', $dateEnd, ['id' => 'dateEndInput', 'class'=>'form-control input-md'] )
            ?>
        </div>
  </div>
</div>
<script>
$('#dateAreaPicker<?php echo $rand ?>').datepicker({
	format: "yyyy-mm-dd",
});
</script>