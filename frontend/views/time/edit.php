<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\tool\Family;
?>

<form class="form-horizontal" action="<?php echo Url::to(['time/submit']) ?>" method="post">
<fieldset>

<!-- Form Name -->
<legend>Form Name</legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">成员</label>
  <div class="col-md-4">
    <select id="selectbasic" name="selectbasic" class="form-control">
      <option value="1">Option one</option>
      <option value="2">Option two</option>
    </select>
  </div>
</div>

<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th style="width:100px">项目</th>
<?php foreach($projects[0] as $month=>$percent) : ?>
<th style="width:100px"><?php echo $month ?></th>
<?php endforeach;?>
</tr>


<?php foreach($projects as $project) : ?>
<tr>
<td><?php echo Family::getProjectName($project) ?></td>
<?php foreach($project->times as $time) : ?>

<td><input type="text" style="width:50px" name="time[<?php echo $user_id ?>][<?php echo $project->id ?>][<?php echo $time->month ?>]" value="<?php echo $time->percent ?>" />%</td>
<?php endforeach;?>
</tr>
<?php endforeach;?>
</table>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">提交</button>
  </div>
</div>


</fieldset>
</form>
