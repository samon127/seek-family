<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Tool;
use common\models\Income;



?>




<form class="form-horizontal" action="<?php echo Url::to(['income/search']) ?>" method="get">
<input type="hidden" name="r" value="income/search" />


<fieldset>

<!-- Form Name -->
<legend>收入查询</legend>

<?php
$defaultProjects = isset($defaultValue['project']) ? $defaultValue['project'] : '';
echo $this->render('@common/views/form/multipleProjectSelect', ['page' => 's', 'defaultProjects'=>$defaultProjects, 'label'=>'项目']);
?>

<?php
$defaultDates['date_start'] = isset($defaultValue['date_start']) ? $defaultValue['date_start'] : '';
$defaultDates['date_end'] = isset($defaultValue['date_end']) ? $defaultValue['date_end'] : '';
echo $this->render('@common/views/form/dateAreaInput', ['page' => 's', 'defaultDates' => $defaultDates, 'label'=>'进账时间']);
?>


<?php
$defaultClient = isset($defaultValue['client']) ? $defaultValue['client'] : '';
echo $this->render('@common/views/form/clientSelect', ['page' => 's', 'defaultValue' => $defaultClient]);
?>






<div class="form-group" style="padding-top:10px">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="搜索" />
  </div>
</div>

</fieldset>
</form>





<ul class="nav nav-pills" style="float:right;padding:20px">
  <li role="presentation" class="active"><?php echo Html::a('新建收入', Url::to(['income/edit', 'from' => Tool::getCurrentUrl()])) ?></li>
</ul>

<?php
echo $this->render('@common/views/partial/incomeTable', ['incomes'=>$incomes]);
?>