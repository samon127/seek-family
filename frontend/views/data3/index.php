<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
?>

<form class="form-horizontal" action="<?php echo Url::to(['income/search']) ?>" method="get"
      xmlns="http://www.w3.org/1999/html">
<input type="hidden" name="r" value="data3/project" />

<?php
echo $this->render('@common/views/form/gllueProjectSelect', ['page' => 's', 'defaultValue' => '', 'label'=>'项目选择']);
?>


<div class="form-group" style="padding-top:10px">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="提交"/>
  </div>
</div>

</form>