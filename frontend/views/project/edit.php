<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>



<form class="form-horizontal" action="<?php echo Url::to(['project/submit']) ?>" method="post">
<?php if ($defaultValue) : ?>
<input type="hidden" name="project[id]" value="<?php echo $defaultValue['id'] ?>" />
<?php endif; ?>
<fieldset>

<!-- Form Name -->
<legend>项目新建</legend>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">项目类型</label>
  <div class="col-md-4">
  <?php
    $defaultInvoice = $defaultValue ? $defaultValue['type'] : '';
    echo HTML::radioList('pay[type]', $defaultInvoice,
            [ 1 => '独立项目', 2 => '母项目', 3 => '子项目'],
            [
                'item' => function($index, $label, $name, $checked, $value) {

                    $return = '<label class="radio-inline">';
                    $return .= HTML::radio($name, $checked, ['value' => $value, 'id'=>'pay_type_'.($index+1)]);
                    $return .= $label;
                    $return .= '</label>';

                    return $return;
                }
            ]
        );
    ?>
  </div>
</div>


<script>
//母项目
$('#pay_type_2').change(function(){
	if (this.checked)
	{
	    $('#nameInputDiv').show();


	    $('#typeSelect').val('');$('#typeSelectDiv').hide();
	    $('#clientSelect').val('');$('#clientSelectDiv').hide();
	    $('#teacherSelect').val('');$('#teacherSelectDiv').hide();
	}
});

//独立项目或者子项目
$('#pay_type_1,#pay_type_3').change(function(){
	if (this.checked)
	{
		$('#typeSelectDiv').show();
		$('#clientSelectDiv').show();

		$('#nameInput').val('');$('#nameInputDiv').hide();
	}
});

</script>


<!-- Text input-->
<div class="form-group" id="nameInputDiv">
  <label class="col-md-4 control-label">项目名称</label>
  <div class="col-md-4">
  <?php
  $defaultName = $defaultValue ? $defaultValue['name'] : '';
  echo HTML::input('text', 'project[name]', $defaultName, ['id' => 'nameInput', 'class'=>'form-control input-md'] )
  ?>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group" id="typeSelectDiv">
  <label class="col-md-4 control-label" for="typeSelect">项目类型</label>
  <div class="col-md-4">
    <?php
    $options = $attrs = [];
    $options[''] = '';
    foreach ($projectTypes as $id => $type)
    {
        $options[$id] = $type['name'];
        $attrs[$id] = ['key' => $type['key']];
    }
    echo HTML::dropDownList('project[type]', $defaultValue ? $defaultValue['type_id'] : '', $options, ['options' => $attrs, 'id' => 'typeSelect', 'class' => 'form-control']);
    ?>
  </div>
</div>




<!-- Select Basic -->
<div class="form-group" style="display:none" id="teacherSelectDiv">
  <label class="col-md-4 control-label" for="teacherSelect">讲师</label>
  <div class="col-md-4">
  <?php
    $options = $attrs = [];
    $options[''] = '';
    foreach ($teachers as $id => $teacher)
    {
        $options[$id] = $teacher['name'];
        $attrs[$id] = ['key' => $teacher['key']];
    }
    echo HTML::dropDownList('project[teacher]', $defaultValue ? $defaultValue['teacher_id']: '', $options, ['options' => $attrs, 'id' => 'teacherSelect', 'class' => 'form-control']);
    ?>

  </div>
</div>

<?php
$defaultClient = $defaultValue ? $defaultValue['client_id'] : '';
echo $this->render('@common/views/form/clientSelect', ['page' => 'project', 'defaultValue' => $defaultClient]);
?>


<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="citySelect">城市</label>
  <div class="col-md-4">
  <?php
    $options = $attrs = [];
    $options[''] = '';
    foreach ($city as $id => $oneCity)
    {
        $options[$id] = $oneCity['name'];
        $attrs[$id] = ['key' => $oneCity['key']];
    }
    echo HTML::dropDownList('project[city]', $defaultValue ? $defaultValue['city_id'] : '', $options, ['options' => $attrs, 'id' => 'citySelect', 'class' => 'form-control']);
    ?>
  </div>
</div>


<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">活跃期</label>
  <div class="col-md-4">
  <?php
    $defaultInvoice = $defaultValue ? $defaultValue['status'] : '';
    echo HTML::radioList('pay[type]', $defaultInvoice,
            [ 1 => '活跃', 2 => '关闭'],
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
    <span>这里可以放一个月份的开始到结束的选择菜单（两个input）</span>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="提交" />
  </div>
</div>

</fieldset>
</form>

<script type="text/javascript">

$('#nameInputDiv').hide();
$('#typeSelectDiv').hide();
$('#clientSelectDiv').hide();

</script>

<script>
$('#typeSelect').change(function(){
	//恢复默认
	$('#teacherSelectDiv').hide();
	$('#clientSelectDiv').hide();

	//动态显示某些表单
	key = $( "#typeSelect option:selected" ).attr('key');
	if(key == 'openclass' || key == 'internalclass' || key == 'consulting')
	{
		$('#teacherSelectDiv').show();
	}

	if (key == 'internalclass' || key == 'consulting')
	{
		$('#clientSelectDiv').show();
	}

	//选择某些表单的时候，要清除别的
	if (key == 'ceoclub')
	{
		$('#teacherSelect').val('');
		$('#select2-clientSelect-container').remove();
	}

	if (key == 'openclass')
	{
		$('#clientSelect').html('');
	}

});

<?php if ($defaultValue) :?>
$('#typeSelect').change();
<?php endif;?>
</script>
