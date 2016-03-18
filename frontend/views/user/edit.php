<?php
use common\tool\Family;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>


<form class="form-horizontal" action="<?php echo Url::to(['user/submit']) ?>" method="post">
<?php if ($defaultValue) : ?>
<input type="hidden" name="user[id]" value="<?php echo $defaultValue['id'] ?>" />
<?php endif; ?>
<fieldset>



<?php
$value = $defaultValue ? $defaultValue['gllue_id'] : '';
echo $this->render('@common/views/form/text', ['name' => 'user[gllue_id]', 'label'=>'Gllue ID','defaultValue' => $value]);
?>

<?php
$value = $defaultValue ? $defaultValue['key'] : '';
echo $this->render('@common/views/form/text', ['name' => 'user[key]', 'label'=>'Key','defaultValue' => $value]);
?>


<?php
$value = $defaultValue ? $defaultValue['name'] : '';
echo $this->render('@common/views/form/text', ['name' => 'user[name]', 'label'=>'姓名','defaultValue' => $value]);
?>

<?php
$value = $defaultValue ? $defaultValue['english'] : '';
echo $this->render('@common/views/form/text', ['name' => 'user[english]', 'label'=>'英文名','defaultValue' => $value]);
?>

<?php
$value = $defaultValue ? $defaultValue['username'] : '';
echo $this->render('@common/views/form/text', ['name' => 'user[username]', 'label'=>'登陆用户名','defaultValue' => $value]);
?>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="提交" />
    <?php if ($defaultValue) : ?>
    <a href="<?php echo Url::to(['user/delete', 'id'=>$defaultValue['id']]) ?>" class="btn btn-primary btn-danger" style="float:right"><span class="glyphicon glyphicon-trash"></span> 删除</a>
    <?php endif; ?>
  </div>
</div>

</fieldset>
</form>


