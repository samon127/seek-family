<?php
use common\tool\Family;
use yii\web\View;
?>


<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>
<?php $this->registerJsFile('vendor/autoNumeric/autoNumeric-1.9.36.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<style>
.container-page{
  width:100%;
}
</style>




<table id="table_id" class="display">
    <thead>
        <tr>
        <th>公司</th>
        <th>消费额度</th>
    </thead>
    <tbody>
    	<?php foreach ($clients as $client): ?>
		<tr>
			<td><?php echo Family::getClinetNameById($client->client_id, $clientIds) ?></td>
			<td class="number"><?php echo $client->number ?></td>
		</tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#table_id').DataTable({
    	paging: false,
    	"info": false,
    	"searching": false,
    	"order": []
    });

    $('.number').autoNumeric('init');
} );
</script>