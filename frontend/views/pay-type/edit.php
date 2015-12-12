<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>

<form class="form-horizontal" action="<?php echo Url::to(['pay-type/submit']) ?>" method="post">

<?php if ($defaultValue) : ?>
<input type="hidden" name="type[id]" value="<?php echo $defaultValue['id'] ?>" />
<?php endif; ?>

<fieldset>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Key</label>
  <div class="col-md-4">
  <?php
  $defaultKey = $defaultValue ? $defaultValue['key'] : '';
  echo HTML::input('text', 'type[key]', $defaultKey, ['id' => 'keyInput', 'class'=>'form-control input-md'] )
  ?>
  <span class="help-block"></span>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">名称</label>
  <div class="col-md-4">
  <?php
  $defaultName = $defaultValue ? $defaultValue['name'] : '';
  echo HTML::input('text', 'type[name]', $defaultName, ['id' => 'nameInput', 'class'=>'form-control input-md'] )
  ?>
  <span class="help-block"></span>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="提交" />
    <?php if ($defaultValue) : ?>
    <a href="#" data-href="<?php echo Url::to(['pay-type/delete', 'id'=>$defaultValue['id']]) ?>" class="btn btn-primary btn-danger" style="float:right" data-toggle="modal" data-target="#confirm-delete"><span class="glyphicon glyphicon-trash"></span> 删除</a>
    <?php endif; ?>
  </div>
</div>

</fieldset>
</form>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                确定需要删除？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <a class="btn btn-danger btn-ok">删除</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
	$('#confirm-delete').on('show.bs.modal', function(e) {
	    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
	});
});


</script>


