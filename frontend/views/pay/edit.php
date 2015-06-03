<?php
use common\tool\Family;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
?>



<form class="form-horizontal" action="<?php echo Url::to(['pay/submit']) ?>" method="post">
<?php if ($defaultValue) : ?>
<input type="hidden" name="pay[id]" value="<?php echo $defaultValue['id'] ?>" />
<?php endif; ?>

<fieldset>

<!-- Form Name -->
<legend>支出</legend>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">支出类型</label>
  <div class="col-md-4">
  <?php
    $defaultInvoice = $defaultValue ? $defaultValue['type_id'] : '';
    echo HTML::radioList('pay[type]', $defaultInvoice,
            [ 1 => '日常支出', 2 => '项目支出'],
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
  <label class="col-md-4 control-label" for="selectbasic">项目</label>
  <div class="col-md-4">
    <?php
    $options = $attrs = [];
    $options[''] = '';
    foreach ($projects as $project)
    {
        $options[$project['id']] = Family::getProjectName($project);
    }
    echo HTML::dropDownList('pay[project]', $defaultValue ? $defaultValue['project_id'] : '', $options, ['options' => $attrs, 'id' => 'projectSelect', 'class' => 'form-control']);
    ?>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">支出类型</label>
  <div class="col-md-4">
    <?php
    $options = $attrs = [];
    $options[''] = '';
    foreach ($payTypes as $type)
    {
        $options[$type['id']] = $type['name'];
        $attrs[$type['id']] = ['key' => $type['key']];
    }
    echo HTML::dropDownList('pay[type]', $defaultValue ? $defaultValue['type_id'] : '', $options, ['options' => $attrs, 'id' => 'typeSelect', 'class' => 'form-control']);
    ?>
  </div>
</div>


<?php
$defaultNumber = $defaultValue ? $defaultValue['number'] : '';
echo $this->render('@common/views/form/moneyInput', ['page' => 'pay', 'defaultNumber' => $defaultNumber]);
?>


<?php
$defaultDate = $defaultValue ? $defaultValue['pay_date'] : '';
echo $this->render('@common/views/form/dateInput', ['page' => 'pay', 'defaultDate' => $defaultDate, 'label'=>"支出时间", 'help'=>"请对应账本确认支出时间"]);
?>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">备注</label>
  <div class="col-md-4">
  <?php
  $defaultComment = $defaultValue ? $defaultValue['comment'] : '';
  echo HTML::input('text', 'pay[comment]', $defaultComment, ['id' => 'commentInput', 'class'=>'form-control input-md'] )
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
