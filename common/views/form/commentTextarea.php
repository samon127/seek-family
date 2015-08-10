<?php
use yii\helpers\Html;
?>

<!-- Text input-->
<div class="form-group">
	<label class="col-md-4 control-label">备注</label>
	<div class="col-md-4">
  <?php
  		$defaultComment = isset($defaultValue['comment']) ? $defaultValue['comment'] : '';
		echo HTML::input( 'string',$page . '[comment]', $defaultComment, [
				'id' => 'commentInput',
				'class' => 'form-control input-md' 
		] )?>
  </div>
</div>

 