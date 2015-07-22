<?php 
use common\models\User;
use common\models\Income;
use yii\helpers\Html;

$incomes = Income::find()
->all();
?>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" style="text-align: right;font-size:14px">查看应收账款</label>
  <div class="col-md-4">
    <?php
    $options = [''=>'', '1'=>'查看应收账款'];
    echo HTML::dropDownList($page.'[money]', $defaultMoney, $options, ['id' => 'moneySelect', 'class' => 'form-control']);

    ?>
  </div>
</div>