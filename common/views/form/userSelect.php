<?php
use common\models\User;
use common\tool\Family;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\Html;


?>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" style="text-align: right;font-size:14px"><?php echo $label ?></label>
  <div class="col-md-4">
    <?php
    $options = $attrs = [];
    if ($defaultValue)
    {
      $options = [$defaultValue=> Family::getBdNameById(['client_id'])];
    }
    else {
      $options = [];
    }
    echo HTML::dropDownList($page.'[user]', $defaultValue, $options, ['id' => 'userSelect', 'class' => 'form-control']);

    ?>
  </div>
</div>

