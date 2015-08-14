<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

$pid = Yii::$app->getRequest()->get('pid');
?>

<form class="form-inline" action="<?php echo Url::to(['target/submit']) ?>" method="post">
<input type="hidden" name="pid" value="<?php echo $pid ?>" />

<table>
<tr>
    <th>成员</th>
    <th>人数目标</th>
    <th>财务目标</th>
</tr>
<?php foreach ($users as $user) :?>
<tr>
<td>
    <div class="form-group">
        <div style="width:80px"><?php echo $user['english'] ?></div>
    </div>
</td>
<td>
  <div class="form-group">
    <?php
    $defaultName = $defaultValue ? $defaultValue['name'] : '';
    echo HTML::input('text', 'project[name]', $defaultName, ['id' => 'nameInput', 'class'=>'form-control input-md'] )
    ?>
    <input type="text" class="form-control" name="target[<?php echo $user['id'] ?>][people_target]">
  </div>
</td>
<td>
  <div class="form-group">
    <input type="text" class="form-control" name="target[<?php echo $user['id'] ?>][revenue_target]">
  </div>
</td>
</tr>
<?php endforeach;?>
</table>

<div class="form-group" style="padding-top:10px">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="提交" />
    </div>
</div>

</form>