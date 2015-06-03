<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

?>
<!-- DataTables CSS -->

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">

<!-- DataTables -->
<?php $this->registerJsFile('http://cdn.datatables.net/1.10.7/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>项目编号</th>
            <th>项目名称</th>
            <th>类型</th>
            <th>讲师</th>
            <th>城市</th>
            <th>客户</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($projects as $project): ?>
        <tr>
            <td><?php echo $project->id ?></td>
            <td><?php echo Family::getProjectName($project)?></td>
            <td><?php echo $project->type->name ?></td>
            <td><?php echo $project->teacher ? $project->teacher->name : '-' ?></td>
            <td><?php echo $project->city->name ?></td>
            <td><?php echo Gllue::getClientById($project->client_id)['name'] ? Gllue::getClientById($project->client_id)['name'] : '-' ?></td>
            <td><?php echo Html::a('编辑', Url::to(['project/edit', 'id' => $project->id])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>