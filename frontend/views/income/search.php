<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Tool;
use common\models\Income;
use common\models\User;
use common\models\Project;


?>

<form class="form-horizontal" action="<?php echo Url::to(['income/search']) ?>" method="get"
      xmlns="http://www.w3.org/1999/html">
<input type="hidden" name="r" value="income/search" />


<fieldset>

<!-- Form Name -->
<legend>收入查询</legend>

<?php
$defaultProjects = isset($defaultValue['project_id']) ? $defaultValue['project_id'] : '';
echo $this->render('@common/views/form/multipleProjectSelect', ['page' => 's', 'defaultProjects'=>$defaultProjects, 'label'=>'项目']);
?>

<?php
$defaultDates['date_start'] = isset($defaultValue['income']['date_start']) ? $defaultValue['income']['date_start'] : '';
$defaultDates['date_end'] = isset($defaultValue['income']['date_end']) ? $defaultValue['income']['date_end'] : '';
echo $this->render('@common/views/form/dateAreaInput', ['page' => 's[income]', 'defaultDates' => $defaultDates, 'label'=>'进账时间']);
?>

<!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="textinput">金额</label>
      <div class="col-md-4">
      <?php
      $defaultNumber = $defaultValue ? $defaultValue['number'] : '';
      echo HTML::input('text', 's[number]', $defaultNumber, ['id' => 'numberInput', 'class'=>'form-control input-md'] )
      ?>
      </div>
    </div>

<?php
//$defaultDates2['date_start'] = isset($defaultValue['project']['date_start']) ? $defaultValue['project']['date_start'] : '';
//$defaultDates2['date_end'] = isset($defaultValue['project']['date_end']) ? $defaultValue['project']['date_end'] : '';
//echo $this->render('@common/views/form/dateAreaInput', ['page' => 's[project]', 'defaultDates' => $defaultDates2, 'label'=>'项目时间']);
?>

<?php
$defaultClient = isset($defaultValue['client']) ? $defaultValue['client'] : '';
echo $this->render('@common/views/form/clientSelect', ['page' => 's', 'defaultValue' => $defaultClient]);
?>

<?php
$defaultUser = isset($defaultValue['user_id']) ? $defaultValue['user_id'] : '';
echo $this->render('@common/views/form/userSelect', ['page' => 's', 'defaultValue' => $defaultUser]);
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

