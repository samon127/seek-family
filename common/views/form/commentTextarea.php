<?php
use yii\helpers\Html;
?>

<!-- Text input-->
<div class="form-group">
	<label class="col-md-4 control-label">备注</label>
	<div class="col-md-4">
  <?php
		echo HTML::textarea ( $page . '[comment]', $defaultValue, [ 
				'id' => 'commentInput',
				'class' => 'form-control input-md' 
		] )?>
  </div>
</div>

 