<?php
use common\tool\Family;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>


<form class="form-horizontal" action="<?php echo Url::to(['bonus/submit']) ?>" method="post">
<?php if ($defaultValue) : ?>
<input type="hidden" name="bonus[id]" value="<?php echo $defaultValue['id'] ?>" />
<?php endif; ?>
<fieldset>




<?php
$selections = [];

if ($defaultValue)
{
    $selections[] = $defaultValue['project_id'];
}

echo $this->render('@common/views/form/projectSelect', ['page' => 'bonus', 'selections' => $selections, 'label'=> '项目']);
?>



<?php
$defaultUser = $defaultValue ? $defaultValue['user_id'] : '';
echo $this->render('@common/views/form/userSelect', ['page' => 'bonus', 'defaultValue' => $defaultUser]);
?>



<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">百分比</label>
  <div class="col-md-4">
  <?php
  $defaultPart = $defaultValue ? $defaultValue['part'] : '';
  echo HTML::input('text', 'bonus[part]', $defaultPart, ['id' => 'partInput', 'class'=>'form-control input-md'] )
  ?>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="提交" />
    <?php if ($defaultValue) : ?>
    <a href="<?php echo Url::to(['bonus/delete', 'id'=>$defaultValue['id']]) ?>" class="btn btn-primary btn-danger" style="float:right"><span class="glyphicon glyphicon-trash"></span> 删除</a>
    <?php endif; ?>
  </div>
</div>

</fieldset>
</form>


