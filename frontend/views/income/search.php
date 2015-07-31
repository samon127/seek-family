<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Tool;
use common\models\Income;
use common\models\User;
use common\models\Project;


$users = User::find()
->all();
?>


<form class="form-horizontal" action="<?php echo Url::to(['income/search']) ?>" method="get"
      xmlns="http://www.w3.org/1999/html">
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

<?php
$defaultInvoices = isset($defaultValue['invoice']) ? $defaultValue['invoice'] : '';
echo $this->render('@common/views/form/invoiceSelect', ['page' => 's', 'defaultInvoice' => $defaultInvoices,'label'=>'是否需要发票']);
?>

<?php
$defaultCards = isset($defaultValue['card']) ? $defaultValue['card'] : '';
echo $this->render('@common/views/form/cardSelect', ['page' => 's', 'defaultCard' => $defaultCards,'label'=>'是否年卡']);
?>

<?php
$defaultMoney = isset($defaultValue['money']) ? $defaultValue['money'] : '';
echo $this->render('@common/views/form/moneySelect', ['page' => 's', 'defaultMoney' => $defaultMoney,'label'=>'是否应收账款']);
?>

<?php
$defaultComment = isset($defaultValue['comment']) ? $defaultValue['comment'] : '';
echo $this->render('@common/views/form/commentTextarea', ['page' => 's', 'defaultComment' => $defaultComment]);
?>


<div class="form-group" style="padding-top:10px">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="搜索"/>
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

