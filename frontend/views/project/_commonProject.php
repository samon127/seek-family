<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use common\tool\DBList;

$projectTypes = DBList::getProjectType();
$teachers = DBList::getTeacher();
$city = DBList::getCity();
$parentProject = DBList::getParentProject();
$users = DBList::getUser();
?>

<form class="form-horizontal" action="<?php echo Url::to(['project/submit']) ?>" method="post">
<?php if ($defaultValue) : ?>
<input type="hidden" name="project[id]" value="<?php echo $defaultValue['id'] ?>" />
<?php endif; ?>
<fieldset>


<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">项目类型</label>
  <div class="col-md-4">
  <?php
    $defaultStyle = $defaultValue ? $defaultValue['style'] : '';
    echo HTML::radioList('project[style]', $defaultStyle,
            [ 1 => '独立项目', 3 => '子项目'],
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
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">负责人</label>
  <div class="col-md-4">
    <?php
    $options = $attrs = $selections = [];
    foreach ($users as $user)
    {
        $options[$user['id']] = $user['english'];
    }

    if ($defaultValue) // 同时带有 pid 和 id 两个参数的话，表示在编辑，编辑完跳转到 pid 下面的 list 页面
    {
        foreach ($defaultValue['projectOwners'] as $user)
        {
            $selections[] = $user['user_id'];
        }
    }

    echo HTML::dropDownList('project[user]', $selections, $options, ['options' => $attrs, 'class' => 'form-control', 'id' => 'multipleUserSelect', 'multiple'=>'multiple']);
    //echo HTML::dropDownList($page.'[client]', $defaultValue, $options, ['id' => 'clientSelect', 'class' => 'js-example-basic-multiple', 'multiple'=>'multiple']);

    ?>
  </div>
</div>
<script>
$("#multipleUserSelect").select2();
</script>


<?php
$defaultDates['date_start'] = $defaultValue ? $defaultValue['date_start'] : '';
$defaultDates['date_end'] = $defaultValue ? $defaultValue['date_end'] : '';
echo $this->render('@common/views/form/dateAreaInput', ['page' => 'project', 'defaultDates' => $defaultDates, 'label'=>'项目执行日期']);
?>


<!-- Select Basic -->
<div class="form-group" id="teacherSelectDiv">
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
<!-- <div class="form-group"> -->
<!--   <label class="col-md-4 control-label" for="radios">项目开放期</label> -->
<!--   <div class="col-md-4"> -->
<!--           <div class="input-daterange input-group" id="monthAreaPicker"> -->
            <?php
//             //$defaultAreaStart = $defaultValue ? $defaultValue['area_start'] : '';
//             //echo HTML::input('text', 'project[area_start]', $defaultAreaStart, ['id' => 'monthAreaStartInput', 'class'=>'form-control input-md'] )
//             ?>
<!--             <span class="input-group-addon">to</span> -->
            <?php
//             //$defaultAreaEnd = $defaultValue ? $defaultValue['area_end'] : '';
//             //echo HTML::input('text', 'project[area_end]', $defaultAreaEnd, ['id' => 'monthAreaEndInput', 'class'=>'form-control input-md'] )
//             ?>
<!--         </div> -->
<!--   </div> -->
<!-- </div> -->

<script>
// $('#monthAreaPicker').datepicker({
// 	format: "yyyy-mm",
// 	startView: "months",
//     minViewMode: "months"
// });
</script>



<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">合作伙伴收益</label>
  <div class="col-md-4">
  <?php
  $defaultComment = $defaultValue ? $defaultValue['partner_profit'] : '';
  echo HTML::input('text', 'project[partner_profit]', $defaultComment, ['id' => 'partnerProfitInput', 'class'=>'form-control input-md'] )
  ?>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">项目组收益</label>
  <div class="col-md-4">
  <?php
  $defaultComment = $defaultValue ? $defaultValue['team_profit'] : '';
  echo HTML::input('text', 'project[team_profit]', $defaultComment, ['id' => 'teamProfitInput', 'class'=>'form-control input-md'] )
  ?>
  </div>
</div>


<?php
$defaultComment = $defaultValue ? $defaultValue['comment'] : '';
echo $this->render('@common/views/form/commentTextarea', ['page' => 'project', 'defaultComment' => $defaultComment]);
?>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">权重</label>
  <div class="col-md-4">
  <?php
  $defaultComment = $defaultValue ? $defaultValue['weight'] : '';
  echo HTML::input('text', 'project[weight]', $defaultComment, ['id' => 'weightInput', 'class'=>'form-control input-md'] )
  ?>
  </div>
</div>



<?php
//$defaultGllueProject = $defaultValue ? $defaultValue['gllue_project_id'] : '';
//echo $this->render('@common/views/form/gllueProjectSelect', ['page' => 'project', 'defaultValue' => $defaultGllueProject]);
?>



<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="提交" />
    <?php if ($defaultValue) : ?>
    <a href="<?php echo Url::to(['project/delete', 'id'=>$defaultValue['id']]) ?>" class="btn btn-primary btn-danger" style="float:right"><span class="glyphicon glyphicon-trash"></span> 删除</a>
    <?php endif; ?>
    </div>
</div>

</fieldset>
</form>

<script type="text/javascript">
if ($('#pay_type_2').attr('checked') == 'checked')
{
	$('#parentProjectInputDiv').show();
}
</script>

<script>
//子项目
$('#pay_type_1').change(function(){
	if (this.checked)
	{
		$('#parentProjectInputDiv').hide();
	}
});
$('#pay_type_2').change(function(){
	if (this.checked)
	{
		$('#parentProjectInputDiv').show();
	}
});
</script>