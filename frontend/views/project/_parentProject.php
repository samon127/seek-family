<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

?>

<form class="form-horizontal" action="<?php echo Url::to(['project/submit-parent']) ?>" method="post">

<?php if ($defaultValue) : ?>
<input type="hidden" name="project[id]" value="<?php echo $defaultValue['id'] ?>" />
<?php endif; ?>

<!-- Text input-->
<div class="form-group" id="nameInputDiv">
  <label class="col-md-4 control-label">项目名称</label>
  <div class="col-md-4">
  <?php
  $defaultParentName = $defaultValue ? $defaultValue['parentName'] : '';
  echo HTML::input('text', 'project[parentName]', $defaultParentName, ['id' => 'nameInput', 'class'=>'form-control input-md'] )
  ?>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="提交" />
    <?php if ($defaultValue) : ?>
    <a href="<?php echo Url::to(['project/delete-parent', 'id'=>$defaultValue['id']]) ?>" class="btn btn-primary btn-danger" style="float:right"><span class="glyphicon glyphicon-trash"></span> 删除</a>
    <?php endif; ?>
    </div>
</div>

</form>