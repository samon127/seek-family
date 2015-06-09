<?php
use common\tool\Family;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
?>


<form class="form-horizontal" action="<?php echo Url::to(['income/submit']) ?>" method="post">
<?php if ($defaultValue) : ?>
<input type="hidden" name="income[id]" value="<?php echo $defaultValue['id'] ?>" />
<?php endif; ?>
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
            [ 1 => '项目收入', 2 => '其他收入'],
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


<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="projectSelect">项目</label>
  <div class="col-md-4">
  <?php
    $options = $attrs = [];
    $options[''] = '';
    foreach ($projects as $project)
    {
        $options[$project['id']] = Family::getProjectName($project);
    }
    echo HTML::dropDownList('income[project]', $defaultValue ? $defaultValue['project_id'] : '', $options, ['options' => $attrs, 'id' => 'projectSelect', 'class' => 'form-control']);
    ?>
  </div>
</div>

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
echo $this->render('@common/views/form/dateInput', ['page' => 'income', 'defaultDate' => $defaultDate, 'label'=>"到账时间", 'help'=>"请对应账本确认到账时间"]);
?>



<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">发票</label>
  <div class="col-md-4">
  <?php
    $defaultInvoice = $defaultValue ? $defaultValue['invoice'] : 1;
    echo HTML::radioList('income[invoice]', $defaultInvoice,
            [ 1 => '需要', 2 => '不需要'],
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


<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="提交" />
  </div>
</div>

</fieldset>
</form>


