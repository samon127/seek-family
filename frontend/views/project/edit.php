<?php
use yii\helpers\Url;

?>

<link href="vendor/select2.min.css" rel="stylesheet" />
<script src="vendor/select2.min.js"></script>



<form class="form-horizontal" action="<?php echo Url::to(['project/submit']) ?>" method="post">
<fieldset>

<!-- Form Name -->
<legend>Form Name</legend>

<!-- Select Basic -->
<div class="form-group" id="typeSelectDiv">
  <label class="col-md-4 control-label" for="typeSelect">项目类型</label>
  <div class="col-md-4">
    <select id="typeSelect" name="project[type]" class="form-control">
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
    <select id="teacherSelect" name="project[teacher]" class="form-control">
      <?php foreach ($teachers as $id => $type) : ?>
      <option value="<?php echo $id ?>" key="<?php echo $type['key'] ?>"><?php echo $type['name'] ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>


<!-- Select Basic -->
<div class="form-group" style="display:1none" id="clientSelectDiv">
  <label class="col-md-4 control-label" for="clientSelect">客户</label>
  <div class="col-md-4">
    <select id="clientSelect" name="project[client]" class="form-control">
    </select>
  </div>
</div>


<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="citySelect">城市</label>
  <div class="col-md-4">
    <select id="citySelect" name="project[city]" class="form-control">
      <option value="1">Option one</option>
      <option value="2">Option two</option>
    </select>
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
function formatRepo (repo) {
    if (repo.loading) return repo.text;

    var markup = '<div class="clearfix">' +
    '<div clas="col-sm-10">';


    if (repo.description) {
      markup += '<div>' + repo.description + '</div>';
    }

    markup += '</div></div>';

    return markup;
  }

  function formatRepoSelection (repo) {
    return repo.full_name || repo.text;
  }

$('#clientSelect').select2({
	  ajax: {
		    //url: "https://api.github.com/search/repositories",
		    url: "<?php echo Url::to(['project/get-company']) ?>",
		    dataType: 'json',
		    delay: 250,
		    data: function (params) {
		      return {
		        q: params.term, // search term
		        page: params.page
		      };
		    },
		    processResults: function (data, page) {
		      // parse the results into the format expected by Select2.
		      // since we are using custom formatting functions we do not need to
		      // alter the remote JSON data
		      return {
		        results: data.items
		      };
		    },
		    cache: true
		  },
		  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
		  minimumInputLength: 1,
		  templateResult: formatRepo, // 这里会循环运行
		  templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
	  });
</script>

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
