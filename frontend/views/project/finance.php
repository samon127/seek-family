<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;
use common\tool\FamilyFinance;

use common\tool\DBList;

$projectTypes = DBList::getProjectType();

$clientIds = [];
foreach ($projects as $project)
{
    if ($project['client_id'])
    {
        $clientIds[] = $project['client_id'];
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


<?php $this->registerJsFile('/vendor/dataTables/extensions/buttons/js/buttons.html5.min.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>
<?php $this->registerJsFile('/vendor/dataTables/extensions/buttons/js/dataTables.buttons.min.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>
<?php $this->registerJsFile('/vendor/dataTables/jszip.min.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>
<?php $this->registerCssFile("/vendor/dataTables/extensions/buttons/css/buttons.dataTables.min.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>



<!-- DataTables -->
<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>



<form class="form-horizontal" action="<?php echo Url::to(['project/finance']) ?>" method="get"
      xmlns="http://www.w3.org/1999/html">
<input type="hidden" name="r" value="project/finance" />


<fieldset>

<!-- Form Name -->
<legend>项目查询</legend>


<div class="form-group" style="padding-top:10px">
  <label class="col-md-4 control-label" for="singlebutton">项目类型</label>
  <div class="col-md-4">
    <?php
    $options = ['1'=>'普通项目', '3'=>'子项目', '2'=>'母项目'];
    echo HTML::checkboxList('s[style]', $defaultValue['style'], $options);
    ?>
  </div>
</div>




<?php
$defaultProjects = isset($defaultValue['project']) ? $defaultValue['project'] : '';
echo $this->render('@common/views/form/multipleProjectSelect', ['page' => 's', 'defaultProjects'=>$defaultProjects, 'label'=>'项目']);
?>

<?php
$defaultDates['date_start'] = isset($defaultValue['date_start']) ? $defaultValue['date_start'] : '';
$defaultDates['date_end'] = isset($defaultValue['date_end']) ? $defaultValue['date_end'] : '';
echo $this->render('@common/views/form/dateAreaInput', ['page' => 's', 'defaultDates' => $defaultDates, 'label'=>'项目时间']);
?>

<?php
$defaultClient = isset($defaultValue['client']) ? $defaultValue['client'] : '';
echo $this->render('@common/views/form/clientSelect', ['page' => 's', 'defaultValue' => $defaultClient]);
?>

<!-- Select Basic -->
<div class="form-group" id="typeSelectDiv">
  <label class="col-md-4 control-label" for="typeSelect">项目类型</label>
  <div class="col-md-4">
    <?php
    $options = $attrs = [];
    $options[''] = '';
    foreach ($projectTypes as $id => $type)
    {
        $options[$id] = $type['name'];
        $attrs[$id] = ['key' => $type['key']];
    }
    $defaultType = isset($defaultValue['type_id']) ? $defaultValue['type_id'] : '';
    echo HTML::dropDownList('s[type_id]', $defaultType, $options, ['options' => $attrs, 'id' => 'typeSelect', 'class' => 'form-control']);
    ?>
  </div>
</div>



<div class="form-group" style="padding-top:10px">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="搜索"/>
  </div>
</div>

</fieldset>
</form>




<table id="table_id" class="display">
    <thead>
        <tr>
            <th>月份</th>
            <th>执行时间</th>
             <th width="300px">项目名称</th>
            <th>负责人</th>
            <th>总收入</th>
            <th>未到账</th>
            <th>年卡收入</th>
            <th>项目支出</th>
            <th>发票支出</th>
            <th>人员支出</th>
            <th>总支出</th>
            <th>总收益</th>
            <th>收益率</th>
            <th>合作伙伴收益</th>
            <th>项目组收益</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($projects as $key => $project): ?>
        <?php $finance = new FamilyFinance; ?>
        <tr>
            <td><?php echo date('Y年m月', strtotime($project->date_start))  ?></td>
            <td><?php echo Family::displayDateArea($project->date_start, $project->date_end)  ?></td>
            <td><?php echo Family::getProjectName($project, $clientIds) ?></td>
            <td><?php echo Family::getUserNames($project->users) ?></td>
            <td class="money"><?php echo $totleIncome = $finance->getProjectTotleIncomes($project->id); ?></td>
            <td class="money"><?php echo $finance->getProjectIncomesNeed($project->id); ?></td>
            <td class="money"><?php echo $finance->getProjectIncomesCard($project->id); ?></td>
            <td class="money"><?php echo $totlePay = $finance->getProjectTotlePay($project->id); ?></td>
            <td class="money"><?php echo $totleInvoice = $finance->getProjectTotleInvoice($project->id); ?></td>
            <td class="money"><?php echo $totleStuffPays = $finance->getProjectTotleStuffPays($project->id); ?></td>
			<td class="money"><?php echo $totlePays = $totlePay + $totleInvoice + $totleStuffPays; ?></td>
            <td class="money"><?php echo $finance->getProjectTotalProfit($project->id); ?></td>
            <td class="percent"><?php
                if(!$totleIncome)
                {
                    echo 0;
                }
                else {
                    echo ($totleIncome - $totlePays) / $totleIncome * 100;

                }
            ?></td>
            <td class="money"><?php echo $finance->getTotalPartnerProfit($project->id);  ?></td>
            <td class="money"><?php echo $finance->getTotalTeamProfit($project->id);  ?></td>



            <td>
            <?php echo Html::a('编辑', Url::to(['project/edit', 'id' => $project->id])) ?>
            <?php echo Html::a('收入', Url::to(['income/index', 'pid' => $project->id])) ?>
            <?php echo Html::a('支出', Url::to(['pay/index', 'pid' => $project->id])) ?>
            <?php echo Html::a('结算', Url::to(['project/balance', 'pid' => $project->id])) ?>
            <?php //echo Html::a('分配', Url::to(['project/share', 'pid' => $project->id])) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th style="text-align:right">合计：</th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
            <th style="text-align:right"></th>
        </tr>
    </tfoot>
</table>



<script>
$('.money').autoNumeric('init');
$('.percent').autoNumeric('init', {aSign:'%', pSign:'s'});

$(document).ready( function () {
    $('#table_id').DataTable({
    	"dom": 'BC&gt;"clear"&lt;lfrtip',
    	"columnDefs": [
           { "visible": false, "targets": 0 },
           { "visible": false, "targets": 1 },
           { "visible": false, "targets": 3 },
           { "visible": false, "targets": 5 },
           { "visible": false, "targets": 6 },
           { "visible": false, "targets": 7 },
           { "visible": false, "targets": 8 },
           { "visible": false, "targets": 9 },
           { "visible": false, "targets": 13 },
           { "visible": false, "targets": 14 }
       ],
    	paging: false,
    	buttons: [{
			extend: 'excelHtml5',
			text: '保存为Excel',
    	}],
    	"info": false,
    	"searching": false,
    	"order": [],
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
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            $([4,10]).each(function(i, j){
            	pageTotal = api
                    .column( j, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                $( api.column( j ).footer() ).html(
                	'<span class="money">'+Math.round(pageTotal*100)/100+'</span>'
                );
            })
        }
    });


} );
</script>