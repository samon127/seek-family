<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\tool\Family;
?>

<form class="form-horizontal" action="<?php echo Url::to(['time/submit']) ?>" method="post">
<fieldset>

<!-- Form Name -->
<legend>Form Name</legend>



<div class="table-responsive">
<table class="table table-bordered">

<tr>
<th style="width:300px">项目</th>
<?php foreach($monthArray as $month) : ?>
<th style="width:100px"><?php echo $month ?></th>
<?php endforeach;?>
</tr>


<?php foreach ($projectArray as $project) : ?>
<tr>
<td><?php echo Family::getProjectName($project) ?></td>
<?php foreach($monthArray as $month) : ?>
<td>
<?php if ($percent = Family::percentExist($month, $project, $userProjectTimes)) :?>
<input type="text" style="width:40px" class="count_<?php echo $month ?>" name="time[<?php echo $user_id ?>][<?php echo $month ?>][<?php echo $project->id ?>]" value="<?php echo $percent ?>" onchange="inputChange()" />%
<?php else : ?>
<input type="text" style="width:40px" class="count_<?php echo $month ?>" name="time[<?php echo $user_id ?>][<?php echo $month ?>][<?php echo $project->id ?>]" value="" onchange="inputChange()" />%
<?php endif; ?>

</td>
<?php endforeach; ?>
</tr>
<?php endforeach; ?>


<tr>
<th style="width:300px">合计</th>
<?php foreach($monthArray as $month) : ?>
<th style="width:100px" id="count_<?php echo $month ?>">0%</th>
<?php endforeach;?>
</tr>

</table>
</div>

<script>
$(document).ready(function () {

	inputChange = function(){

	<?php foreach ($monthArray as $month) :?>

	var sum = 0;
	$('.count_<?php echo $month; ?>').each(function(){
	    if ($(this).val())
	    {
	    	sum += parseInt($(this).val());
	    }
	});
	$('#count_<?php echo $month; ?>').html(sum+"%")

	<?php endforeach;?>

	}

	inputChange();
});


</script>


<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">提交</button>
  </div>
</div>


</fieldset>
</form>
