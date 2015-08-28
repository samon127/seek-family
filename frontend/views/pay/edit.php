<?php
use common\tool\Family;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$pid = Yii::$app->getRequest()->get('pid');
?>


<?php $this->registerCssFile("/vendor/select2/select2.min.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/select2/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>



<form class="form-horizontal" action="<?php echo Url::to(['pay/submit']) ?>" method="post">
<?php if ($defaultValue) : ?>
<input type="hidden" name="pay[id]" value="<?php echo $defaultValue['id'] ?>" />
<?php endif; ?>
<input type="hidden" name="pid" value="<?php echo $pid ?>" />
<fieldset>

<!-- Form Name -->
<legend>支出</legend>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">支出类型</label>
  <div class="col-md-4">
  <?php

  $category = Yii::$app->getRequest()->get('category');
  if ($category)
  {
      $defaultCategory = $category;
  }
  else {
      $defaultCategory = $defaultValue ? $defaultValue['category'] : 2;
  }


    echo HTML::radioList('pay[category]', $defaultCategory,
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

<?php
$defaultProjects = [];

if ($pid = Yii::$app->getRequest()->get('pid')) // 带 pid 参数表示在为某个 project 创建支出
{
    $defaultProjects[] = $pid;
}

if ($defaultValue) // 同时带有 pid 和 id 两个参数的话，表示在编辑，编辑完跳转到 pid 下面的 list 页面
{
    foreach ($defaultValue['payProjects'] as $project)
    {
        $defaultProjects[] = $project['project_id'];
    }
}

echo $this->render('@common/views/form/multipleProjectSelect', ['page' => 'pay', 'defaultProjects'=>$defaultProjects, 'label'=>'项目']);
?>





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

$pay_date = Yii::$app->getRequest()->get('pay_date');
if ($pay_date)
{
    $defaultDate = $pay_date;
}
else {
    $defaultDate = $defaultValue ? $defaultValue['pay_date'] : '';
}

echo $this->render('@common/views/form/dateInput', ['page' => 'pay', 'defaultDate' => $defaultDate, 'label'=>"支出时间", 'help'=>"请对应账本确认支出时间"]);
?>


<?php
$defaultComment = $defaultValue ? $defaultValue['comment'] : '';
echo $this->render('@common/views/form/commentTextarea', ['page' => 'pay', 'defaultComment' => $defaultComment]);
?>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="提交" />
    <?php if ($defaultValue) : ?>
    <a href="<?php echo Url::to(['pay/delete', 'id'=>$defaultValue['id'], 'pid'=>$pid]) ?>" class="btn btn-primary btn-danger" style="float:right"><span class="glyphicon glyphicon-trash"></span> 删除</a>
    <?php endif; ?>
  </div>
</div>

</fieldset>
</form>
