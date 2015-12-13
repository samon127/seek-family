<?php
use common\tool\Family;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$pid = Yii::$app->getRequest()->get('pid');
$from = Yii::$app->getRequest()->get('from');
?>


<form class="form-horizontal" action="<?php echo Url::to(['income/submit']) ?>" method="post">
<?php if ($defaultValue) : ?>
<input type="hidden" name="income[id]" value="<?php echo $defaultValue['id'] ?>" />
<?php endif; ?>
<input type="hidden" name="pid" value="<?php echo $pid ?>" />
<input type="hidden" name="from" value="<?php echo $from ?>" />
<fieldset>

<!-- Form Name -->
<legend>收入</legend>


<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">收入类型</label>
  <div class="col-md-4">
  <?php
    $defaultInvoice = $defaultValue ? $defaultValue['type'] : 1;
    echo HTML::radioList('income[type]', $defaultInvoice,
            [ 1 => '项目收入', 2 => '非项目收入'],
            [
                'item' => function($index, $label, $name, $checked, $value) {

                    $return = '<label class="radio-inline">';
                    $return .= HTML::radio($name, $checked, ['value' => $value]);
                    $return .= $label;
                    $return .= '</label>';

                    return $return;
                }
            ]
        );
    ?>
  </div>
</div>


<?php
$selections = [];

if ($pid = Yii::$app->getRequest()->get('pid')) // 带 pid 参数表示在为某个 project 创建支出
{
    $selections[] = $pid;
}

if ($defaultValue) // 同时带有 pid 和 id 两个参数的话，表示在编辑，编辑完跳转到 pid 下面的 list 页面
{
    $selections[] = $defaultValue['project_id'];
}

echo $this->render('@common/views/form/projectSelect', ['page' => 'income', 'selections' => $selections, 'label'=> '项目']);
?>



<?php
$defaultClient = $defaultValue ? $defaultValue['client_id'] : '';
echo $this->render('@common/views/form/clientSelect', ['page' => 'income', 'defaultValue' => $defaultClient]);
?>


<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">是否走年卡费用</label>
  <div class="col-md-4">
  <?php
    $defaultInvoice = $defaultValue ? $defaultValue['card'] : 1;
    echo HTML::radioList('income[card]', $defaultInvoice,
            [ 1 => '否', 2 => '是'],
            [
                'item' => function($index, $label, $name, $checked, $value) {

                    $return = '<label class="radio-inline">';
                    $return .= HTML::radio($name, $checked, ['value' => $value]);
                    $return .= $label;
                    $return .= '</label>';

                    return $return;
                }
            ]
        );
    ?>
  </div>
</div>


<?php
$defaultNumber = $defaultValue ? $defaultValue['number'] : '';
echo $this->render('@common/views/form/moneyInput', ['page' => 'income', 'defaultNumber' => $defaultNumber]);
?>



<?php
$defaultDate = $defaultValue ? $defaultValue['income_date'] : '';
echo $this->render('@common/views/form/dateInput', ['page' => 'income', 'defaultDate' => $defaultDate, 'label'=>"到账时间", 'help'=>"如不填写则表示为“应收账款”"]);
?>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">发票编号</label>
  <div class="col-md-4">
  <?php
  $defaultInvoiceCode = $defaultValue ? $defaultValue['invoice_code'] : '';
  echo HTML::input('text', 'income[invoice_code]', $defaultInvoiceCode, ['id' => 'invoiceCodeInput', 'class'=>'form-control input-md'] )
  ?>
  <span class="help-block">如不填写则表示为 不开具发票</span>
  </div>
</div>


<!-- Multiple Radios (inline)
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">发票</label>
  <div class="col-md-4">
  <?php
//     $defaultInvoice = $defaultValue ? $defaultValue['invoice'] : 1;
//     echo HTML::radioList('income[invoice]', $defaultInvoice,
//             [ 1 => '需要', 2 => '不需要'],
//             [
//                 'item' => function($index, $label, $name, $checked, $value) {

//                     $return = '<label class="radio-inline">';
//                     $return .= HTML::radio($name, $checked, ['value' => $value]);
//                     $return .= $label;
//                     $return .= '</label>';

//                     return $return;
//                 }
//             ]
//         );
    ?>
  </div>
</div>
-->

<?php
$defaultComment = $defaultValue ? $defaultValue['comment'] : '';
echo $this->render('@common/views/form/commentTextarea', ['page' => 'income', 'defaultComment' => $defaultComment]);
?>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="提交" />
    <?php if ($defaultValue) : ?>
    <a href="<?php echo Url::to(['income/delete', 'id'=>$defaultValue['id'], 'pid'=>$pid]) ?>" class="btn btn-primary btn-danger" style="float:right"><span class="glyphicon glyphicon-trash"></span> 删除</a>
    <?php endif; ?>
  </div>
</div>

</fieldset>
</form>


