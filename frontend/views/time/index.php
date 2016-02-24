<?php
use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

$ids = [];
foreach ($models as $model)
{
    $ids[] = $model->project->client_id;
}

?>

<style>
.container-page{
  width:100%;
}
</style>


<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>
<?php $this->registerCssFile("/vendor/dataTables/extensions/ColVis/css/dataTables.colVis.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/extensions/ColVis/js/dataTables.colVis.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<table id="table" class="display">
    <thead>
        <tr>
            <th>项目</th>
            <th>月份</th>
            <th>成员</th>
            <th>比例</th>
            <th>操作</th>
        </tr>
    </thead>
    <tfoot>
            <tr>
                <th colspan="5" style="text-align:right"></th>
                <th></th>
            </tr>
        </tfoot>
    <tbody>
    <?php foreach ($models as $model): ?>
        <tr>
            <td><?php echo Family::getProjectName($model->project, $ids) ?></td>
            <td style="text-align:right"><?php echo $model->month ?></td>
			<td style="text-align:right"><?php echo $model->user->english ?></td>
            <td style="text-align:right"><?php echo $model->percent ?>%</td>
            <td><?php echo Html::a('操作', Url::to(['bonus/edit', 'id' => $model->id])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#table').DataTable({
    	"dom": '&gt;"clear"&lt;lfrtip',
    	paging: false,
    	"info": false,
    	"searching": false,
    	"order": [2],
    	"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
        }
    });
} );
</script>