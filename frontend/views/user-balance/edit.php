<?php
use common\tool\Family;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
?>

<form class="form-horizontal" action="<?php echo Url::to(['user-balance/submit']) ?>" method="post">
<?php if ($defaultValue) : ?>
<input type="hidden" name="user-balance[id]" value="<?php echo $defaultValue['id'] ?>" />
<?php endif; ?>
<fieldset>

<?php
$defaultMonth = $defaultValue ? $defaultValue['month'] : '';
echo $this->render('@common/views/form/monthInput', ['page' => 'user-balance', 'defaultMonth' => $defaultMonth, 'label'=>"月份", 'help'=>""]);
?>

<?php
$defaultUser = $defaultValue ? $defaultValue['user_id'] : '';
echo $this->render('@common/views/form/userSelect', ['page' => 'user-balance', 'defaultValue' => $defaultUser]);
?>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">成本基准</label>
  <div class="col-md-4">
  <?php
  $defaultPercent = $defaultValue ? $defaultValue['balance'] : '';
  echo HTML::input('text', 'user-balance[balance]', $defaultPercent, ['id' => 'balanceInput', 'class'=>'form-control input-md', 'helper'=>'123'] )
  ?>
  <span class="help-block">请不要填写“%”</span>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="提交" />
    <?php if ($defaultValue) : ?>
    <a href="<?php echo Url::to(['user-balance/delete', 'id'=>$defaultValue['id']]) ?>" class="btn btn-primary btn-danger" style="float:right"><span class="glyphicon glyphicon-trash"></span> 删除</a>
    <?php endif; ?>
  </div>
</div>

</fieldset>
</form>


