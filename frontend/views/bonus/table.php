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
    <tbody>
    	<?php foreach ($content['projects'] as $projectName => $userPercent): ?>
		<tr>
			<td><?php echo $projectName ?></td>
			<?php $count = 0;?>
			<?php foreach ($userPercent as $percent): ?>
            <td width="100px"><?php echo $percent ? $percent.'%' : '' ?></td>
            <?php $count += $percent; ?>
			<?php endforeach; ?>
			<td><?php echo $count ?>%</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
	$('#table<?php echo $month ?>').DataTable({
		"dom": '&gt;"clear"&lt;lfrtip',
		paging: false,
		"info": false,
		"searching": false,
	});
} );


</script>
<?php endif;?>
<?php endforeach;?>

