<?php
use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

?>

<style>
.container-page{
  width:100%;
}
</style>


<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<?php foreach ($data as $month => $content) : ?>
<?php if ($content['userIds']) :?>
<?php
$columnNumber = count($content['userIds']);
?>
<table id="table<?php echo $month ?>" class="display">
    <thead>
        <tr>
            <th><?php echo $month ?> 项目</th>
            <?php foreach ($content['userNames'] as $userName) : ?>
			<th><?php echo $userName; ?></th>
            <?php endforeach;?>
            <th>合计</th>
        </tr>
    </thead>
    <tfoot>
            <tr>
            	<th style="text-align:right">合计：</th>
            	<?php foreach (range(1, $columnNumber + 1) as $column) :?>
				<th></th>
            	<?php endforeach;?>
            </tr>
        </tfoot>
    <tbody>
    	<?php foreach ($content['projects'] as $projectName => $userPercent): ?>
		<tr>
			<td><?php echo $projectName ?></td>
			<?php $count = 0;?>
			<?php foreach ($userPercent as $percent): ?>
            <td width="100px" class="money"><?php echo $percent ? $percent : '' ?></td>
            <?php $count += $percent; ?>
			<?php endforeach; ?>
			<td width="100px" class="money"><?php echo $count ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$('.money').autoNumeric('init');

$(document).ready( function () {
	$('#table<?php echo $month ?>').DataTable({
		"dom": '&gt;"clear"&lt;lfrtip',
		paging: false,
		"info": false,
		"searching": false,

		"footerCallback": function ( row, data, start, end, display ) {
	        var api = this.api(), data;

	     	// Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            <?php
            $jsString = '';
            foreach (range(1, $columnNumber + 1) as $column){
                $jsString .= $column . ',';
            }
            ?>
            $([<?php echo $jsString; ?>]).each(function(i, j){
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
<?php endif;?>
<?php endforeach;?>

