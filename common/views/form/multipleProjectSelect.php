<?php
use common\tool\Family;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\models\Project;

$projects = Project::find()
->joinWith('type', true, 'LEFT JOIN')
->joinWith('teacher', true, 'LEFT JOIN')
->joinWith('city', true, 'LEFT JOIN')
->orderBy('date_start DESC')
->all();

$ids = $options = [];

foreach ($projects as $project)
{
    if ($project['client_id'])
    {
        $ids[] = $project['client_id'];
    }
}

foreach ($projects as $project)
{
    $options[$project['id']] = Family::getProjectName($project, $ids);
}

?>

<?php $this->registerCssFile("/vendor/select2/select2.min.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/select2/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic"><?php echo $label ?></label>
  <div class="col-md-4">
    <?php
    echo HTML::dropDownList($page.'[project]', $defaultProjects, $options, ['class' => 'form-control', 'id' => 'projectSelect', 'multiple'=>'multiple']);
    ?>
  </div>
</div>

<script>
$("#projectSelect").select2();
</script>