<?php
use common\models\Project;
use common\tool\Family;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$options = [];
$options[] = '';



$projects = Project::find()
->joinWith('type', true, 'LEFT JOIN')
->joinWith('teacher', true, 'LEFT JOIN')
->joinWith('city', true, 'LEFT JOIN')
->orderBy('date_start DESC')
->all();

$clientIds = [];
foreach ($projects as $project)
{
    if ($project['client_id'])
    {
        $clientIds[] = $project['client_id'];
    }
}

foreach ($projects as $project)
{
    $options[$project['id']] = Family::getProjectName($project, $clientIds);
}



?>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="projectSelect"><?php echo $label ?></label>
  <div class="col-md-4">
  <?php
    echo HTML::dropDownList($page.'[project]', $selections, $options, ['id' => 'projectSelect', 'class' => 'form-control']);
    ?>
  </div>
</div>