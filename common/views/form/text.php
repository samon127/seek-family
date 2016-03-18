<?php
use yii\helpers\Html;

$defaultValue = isset($defaultValue) ? $defaultValue : '';
$help = isset($help) ? $help : '';
$id = isset($id) ? $id : '';

if (isset($name)) {
    $inputName = $name;
}
else if (isset($page)) {
    $inputName = $page.'[text]';
}

?>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput"><?php echo $label ?></label>
  <div class="col-md-4">
  <?php
  echo HTML::input('text', $inputName, $defaultValue, ['id' => $id, 'class'=>'form-control input-md'] )
  ?>
  <span class="help-block"><?php echo $help ?></span>
  </div>
</div>