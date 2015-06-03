<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

?>
<!-- DataTables CSS -->

<link rel="stylesheet" type="text/css" href="/vendor/dataTables/jquery.dataTables.css">

<!-- DataTables -->
<?php $this->registerJsFile('/vendor/dataTables/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>项目编号</th>
            <th>项目名称</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pays as $pay): ?>
        <tr>
            <td><?php echo $pay->id ?></td>
            <td><?php echo Family::getProjectName($pay->project)?></td>
            <td><?php echo Html::a('编辑', Url::to(['pay/edit', 'id' => $pay->id])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>