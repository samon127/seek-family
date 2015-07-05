<?php
use common\tool\Gllue;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\Html;
?>


<?php $this->registerCssFile("/vendor/select2/select2.min.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/select2/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<!-- Select Basic -->
<div class="form-group" style="display:1none" id="clientSelectDiv">
  <label class="col-md-4 control-label" for="clientSelect">客户</label>
  <div class="col-md-4">

<?php
$options = $attrs = [];
if ($defaultValue)
{
    $options = [$defaultValue=>Gllue::getClientById($defaultValue)['name']];
}
else {
    $options = [];
}
echo HTML::dropDownList($page.'[client]', $defaultValue, $options, ['id' => 'clientSelect', 'class' => 'form-control']);

?>
  </div>
</div>

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