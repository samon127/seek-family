<?php
use common\models\User;
use common\models\Income;
use yii\helpers\Html;

$incomes = Income::find()
    ->all();
?>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" style="text-align: right;font-size:14px"><?php echo $label ?></label>
  <div class="col-md-4">
    <?php
    $options = [''=>'', '2'=>'需要','1'=>'不需要'];
    echo HTML::dropDownList($page.'[card]', $defaultCard, $options, ['id' => 'cardSelect', 'class' => 'form-control']);
    ?>
  </div>
</div>
