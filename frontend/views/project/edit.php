<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
?>

<link href="vendor/bootstrap-datepicker/datepicker3.css" rel="stylesheet" />

<?php $this->registerJsFile('vendor/bootstrap-datepicker/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


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
    $defaultStyle = $defaultValue ? $defaultValue['style'] : '';
    echo HTML::radioList('project[style]', $defaultStyle,
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

<!-- Text input-->
<div class="form-group" style="display:none" id="parentProjectInputDiv">
  <label class="col-md-4 control-label">母项目</label>
  <div class="col-md-4">
  <?php
    $options = [];
    $options[''] = '';
    foreach ($parentProject as $id => $type)
    {
        $options[$id] = $type['name'];
    }
    echo HTML::dropDownList('project[parent]', $defaultValue ? $defaultValue['parent_id'] : '', $options, ['id' => 'parentProjectSelect', 'class' => 'form-control']);
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


<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">项目执行日期</label>
  <div class="col-md-4">
          <div class="input-daterange input-group" id="dateAreaPicker">
            <?php
            $sateStart = $defaultValue ? $defaultValue['date_start'] : '';
            echo HTML::input('text', 'project[date_start]', $sateStart, ['id' => 'dateStartInput', 'class'=>'form-control input-md'] )
            ?>
            <span class="input-group-addon">to</span>
            <?php
            $dateEnd = $defaultValue ? $defaultValue['date_end'] : '';
            echo HTML::input('text', 'project[date_end]', $dateEnd, ['id' => 'dateEndInput', 'class'=>'form-control input-md'] )
            ?>
        </div>
  </div>
</div>
<script>
$('#dateAreaPicker').datepicker({
	format: "yyyy-mm-dd",
});
    </script>

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
<div class="form-group" id="citySelectDiv">
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
  <label class="col-md-4 control-label" for="radios">项目开放期</label>
  <div class="col-md-4">
          <div class="input-daterange input-group" id="monthAreaPicker">
            <?php
            $defaultAreaStart = $defaultValue ? $defaultValue['area_start'] : '';
            echo HTML::input('text', 'project[area_start]', $defaultAreaStart, ['id' => 'monthAreaStartInput', 'class'=>'form-control input-md'] )
            ?>
            <span class="input-group-addon">to</span>
            <?php
            $defaultAreaEnd = $defaultValue ? $defaultValue['area_end'] : '';
            echo HTML::input('text', 'project[area_end]', $defaultAreaEnd, ['id' => 'monthAreaEndInput', 'class'=>'form-control input-md'] )
            ?>
        </div>
  </div>
</div>

<script>
$('#monthAreaPicker').datepicker({
	format: "yyyy-mm",
	startView: "months", 
    minViewMode: "months"
});
    </script>



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

if($('#pay_type_1').attr('checked') == 'checked')
{
	$('#nameInputDiv').hide();
}
else if ($('#pay_type_2').attr('checked') == 'checked')
{
	$('#typeSelectDiv').hide();
	$('#clientSelectDiv').hide();
	$('#citySelectDiv').hide();
}
else if ($('#pay_type_3').attr('checked') == 'checked')
{
	$('#nameInputDiv').hide();
	$('#parentProjectInputDiv').show();
}


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

<script>

function hideAll()
{
	$('#typeSelectDiv').hide();
	$('#clientSelectDiv').hide();
	$('#teacherSelectDiv').hide();
	$('#citySelectDiv').hide();
	$('#nameInputDiv').hide();
	$('#parentProjectInputDiv').hide();
}

function clearAllHide()
{
	// todo
}

//母项目
$('#pay_type_2').change(function(){
	if (this.checked)
	{
		hideAll();
		
	    $('#nameInputDiv').show();
	}
});

//独立项目
$('#pay_type_1').change(function(){
	if (this.checked)
	{
		hideAll();
		
		$('#typeSelect').val('');$('#typeSelectDiv').show();
		$('#citySelect').val('');$('#citySelectDiv').show();
	}
});

//子项目
$('#pay_type_3').change(function(){
	if (this.checked)
	{
		hideAll();

		$('#parentProjectInputDiv').show();
		$('#typeSelect').val('');$('#typeSelectDiv').show();
		$('#citySelect').val('');$('#citySelectDiv').show();
	}
});

</script>
