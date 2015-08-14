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
    $options = [''=>'', '1'=>'需要','2'=>'不需要'];
    echo HTML::dropDownList($page.'[invoice]', $defaultInvoice, $options, ['id' => 'invoiceSelect', 'class' => 'form-control']);

    ?>
  </div>
</div>

