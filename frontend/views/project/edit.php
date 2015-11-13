<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
?>

<?php $this->registerCssFile("/vendor/select2/select2.min.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/select2/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<?php $this->registerCssFile("/vendor/bootstrap-datepicker/datepicker3.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('vendor/bootstrap-datepicker/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>



<div id="myTabs">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active" ><a href="#home" aria-controls="home" role="tab" data-toggle="tab">一般项目</a></li>
    <li role="presentation" ><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">母项目</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
        <?php echo $this->render('_commonProject', ['defaultValue' => $defaultValue]) ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">
        <?php echo $this->render('_parentProject', ['defaultValue' => $defaultValue]) ?>
    </div>
  </div>

</div>

<?php if (isset($defaultValue) && isset($defaultValue['parentName']) && $defaultValue['parentName']) : ?>
<script>
$(document).ready(function(){
	$('#myTabs a[href="#profile"]').tab('show');
});
</script>
<?php endif; ?>



