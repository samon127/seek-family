<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

$ids = [];

foreach ($projects as $project)
{
    if ($project['client_id'])
    {
        $ids[] = $project['client_id'];
    }
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

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>月份</th>
            <th>类型</th>
            <th>分类</th>
            <th>项目名称</th>
            <th>执行时间</th>
            <th>讲师</th>
            <th>城市</th>
            <th>客户</th>
            <th>合作伙伴收益</th>
            <th>项目组收益</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($projects as $project): ?>
        <tr>
            <td><?php echo date('Y年m月', strtotime($project->date_start))  ?></td>
            <td><?php echo $project->type ? Html::a($project->type->name, Url::to(['project/type', 'tid'=>$project->type->id])) : '-' ?></td>
            <td><?php echo Family::getProjectStyle($project) ?></td>
            <td><?php echo Family::getProjectName($project, $ids) ?></td>
            <td><?php echo Family::displayDateArea($project->date_start, $project->date_end)  ?></td>
            <td><?php echo $project->teacher ? $project->teacher->name : '-' ?></td>
            <td><?php echo $project->city ? $project->city->name : '-' ?></td>
            <td><?php echo Gllue::getClientById($project->client_id)['name'] ? Gllue::getClientById($project->client_id)['name'] : '-' ?></td>
            <td><?php echo $project->partner_profit ? $project->partner_profit : '-' ?></td>
            <td><?php echo $project->team_profit ? $project->team_profit : '-' ?></td>
            <td>
            <?php echo Html::a('编辑', Url::to(['project/edit', 'id' => $project->id])) ?>
            <?php echo Html::a('收入', Url::to(['income/index', 'pid' => $project->id])) ?>
            <?php echo Html::a('支出', Url::to(['pay/index', 'pid' => $project->id])) ?>
            <?php echo Html::a('目标', Url::to(['target/index', 'pid' => $project->id])) ?>
            <?php echo Html::a('结算', Url::to(['project/balance', 'pid' => $project->id])) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#table_id').DataTable({
    "dom": 'C&gt;"clear"&lt;lfrtip',
	"columnDefs": [
           { "visible": false, "targets": 0 },
           { "visible": false, "targets": 2 },
           { "visible": false, "targets": 4 },
           { "visible": false, "targets": 5 },
           { "visible": false, "targets": 6 },
           { "visible": false, "targets": 7 },
           { "visible": false, "targets": 8 }
       ],
   	paging: false,
   	"info": false,
   	"searching": true,
   	"order": [[ 0, 'asc' ]],
   	"drawCallback": function ( settings ) {
           var api = this.api();
           var rows = api.rows( {page:'current'} ).nodes();
           var last=null;

           api.column(0, {page:'current'} ).data().each( function ( group, i ) {
               if ( last !== group ) {
                   $(rows).eq( i ).before(
                       '<tr class="group"><td colspan="14" style="color:red">'+group+'</td></tr>'
                   );

                   last = group;
               }
           } );
       }
    });
} );
</script>