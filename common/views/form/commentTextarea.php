<?php
use yii\helpers\Html;
?>

<!-- Text input-->
<div class="form-group">
	<label class="col-md-4 control-label">备注查询</label>
	<div class="col-md-4">
  <?php
		echo HTML::textarea ( $page . '[comment]', $defaultComment, [
				'id' => 'commentInput',
				'class' => 'form-control input-md' 
		] )?>
  </div>
</div>

 