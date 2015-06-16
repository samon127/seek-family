<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;







?>

<style>
.container-page{
  width:95%;
}
</style>

<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<!-- DataTables -->
<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>



<table id="table_id" class="display">
    <thead>
        <tr>
            <th>月份</th>
            <th>执行时间</th>
            <th>分类</th>
            <th>项目名称</th>
            <th>类型</th>
            <th>负责人</th>
            <th>项目收入</th>
            <th>项目支出（不含发票支出）</th>
            <th>人员支出</th>


            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($projects as $key => $project): ?>
        <tr>
            <td><?php echo date('Y年m月', strtotime($project->date_start))  ?></td>
            <td><?php echo Family::displayDateArea($project->date_start, $project->date_end)  ?></td>
            <td><?php echo Family::getProjectStyle($project) ?></td>
            <td><?php echo Family::getProjectName($project) ?></td>
            <td><?php echo $project->type ? $project->type->name : '-' ?></td>
            <td><?php echo Family::getUserNames($project->users) ?></td>
            <td class="money"><?php echo Family::getTotleIncomes($project->incomes) ?></td>
            <td class="money"><?php echo Family::getTotlePays($project) ?></td>
            <td class="money"><?php echo Family::getTotleStuffPays($project) ?></td>



            <td>
            <?php echo Html::a('编辑', Url::to(['project/edit', 'id' => $project->id])) ?>
            <?php echo Html::a('收入', Url::to(['income/index', 'pid' => $project->id])) ?>
            <?php echo Html::a('支出', Url::to(['pay/index', 'pid' => $project->id])) ?>
            <?php echo Html::a('结算', Url::to(['project/balance', 'pid' => $project->id])) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<script>
$(document).ready( function () {
    $('#table_id').DataTable({
    	"columnDefs": [
            { "visible": false, "targets": 0 }
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
                        '<tr class="group"><td colspan="10" style="color:red">'+group+'</td></tr>'
                    );

                    last = group;
                }
            } );
        }
    });

    $('.money').autoNumeric('init');
} );
</script>