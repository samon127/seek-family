<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Form Name</legend>

<!-- Select Basic -->
<div class="form-group" id="typeSelectDiv">
  <label class="col-md-4 control-label" for="typeSelect">项目类型</label>
  <div class="col-md-4">
    <select id="typeSelect" name="typeSelect" class="form-control">
      <option value="0"></option>
      <?php foreach ($projectTypes as $id => $type) : ?>
      <option value="<?php echo $id ?>" key="<?php echo $type['key'] ?>"><?php echo $type['name'] ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>



<!-- Select Basic -->
<div class="form-group" style="display:none" id="teacherSelectDiv">
  <label class="col-md-4 control-label" for="teacherSelect">老师</label>
  <div class="col-md-4">
    <select id="teacherSelect" name="teacherSelect" class="form-control">
      <?php foreach ($teachers as $id => $type) : ?>
      <option value="<?php echo $id ?>" key="<?php echo $type['key'] ?>"><?php echo $type['name'] ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>


<!-- Select Basic -->
<div class="form-group" style="display:none" id="clientSelectDiv">
  <label class="col-md-4 control-label" for="clientSelect">客户</label>
  <div class="col-md-4">
    <select id="clientSelect" name="clientSelect" class="form-control">
      <option value="1">Option one</option>
      <option value="2">Option two</option>
    </select>
  </div>
</div>


<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="citySelect">城市</label>
  <div class="col-md-4">
    <select id="citySelect" name="citySelect" class="form-control">
      <option value="1">Option one</option>
      <option value="2">Option two</option>
    </select>
  </div>
</div>


</fieldset>
</form>

<script>
var data;
$('#typeSelect').change(function(){
	//恢复默认
	$('#teacherSelectDiv').hide();
	$('#clientSelectDiv').hide();
	
	//处理
	key = $( "#typeSelect option:selected" ).attr('key');
	if(key == 'openclass' || key == 'internalclass' || key == 'consulting')
	{
		$('#teacherSelectDiv').show();
	}

	if (key == 'internalclass' || key == 'consulting')
	{
		$('#clientSelectDiv').show();
	}

});

</script>
