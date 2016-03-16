<?php
use common\tool\Family;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>


<form class="form-horizontal" action="<?php echo Url::to(['time/submit']) ?>" method="post">
<?php if ($defaultValue) : ?>
<input type="hidden" name="time[id]" value="<?php echo $defaultValue['id'] ?>" />
<?php endif; ?>
<fieldset>


<?php
$defaultMonth = $defaultValue ? $defaultValue['month'] : '';
echo $this->render('@common/views/form/monthInput', ['page' => 'time', 'defaultMonth' => $defaultMonth, 'label'=>"月份", 'help'=>""]);
?>

<?php
$selections = [];

if ($defaultValue)
{
    $selections[] = $defaultValue['project_id'];
}

echo $this->render('@common/views/form/projectSelect', ['page' => 'time', 'selections' => $selections, 'label'=> '项目']);
?>



<?php
$defaultUser = $defaultValue ? $defaultValue['user_id'] : '';
echo $this->render('@common/views/form/userSelect', ['page' => 'time', 'defaultValue' => $defaultUser]);
?>




<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">百分比</label>
  <div class="col-md-4">
  <?php
  $defaultPercent = $defaultValue ? $defaultValue['percent'] : '';
  echo HTML::input('text', 'time[percent]', $defaultPercent, ['id' => 'partInput', 'class'=>'form-control input-md', 'helper'=>'123'] )
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
    <a href="<?php echo Url::to(['time/delete', 'id'=>$defaultValue['id']]) ?>" class="btn btn-primary btn-danger" style="float:right"><span class="glyphicon glyphicon-trash"></span> 删除</a>
    <?php endif; ?>
  </div>
</div>

</fieldset>
</form>


