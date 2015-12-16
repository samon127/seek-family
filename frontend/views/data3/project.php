<?php

use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

?>


<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<style>
.container-page{
  width:100%;
}
</style>


<form class="form-horizontal" action="<?php echo Url::to(['data3/project']) ?>" method="get"
      xmlns="http://www.w3.org/1999/html">
<input type="hidden" name="r" value="data3/project" />

<?php
$defaultProject = isset($defaultValue['gllue_project']) ? $defaultValue['gllue_project'] : '';
echo $this->render('@common/views/form/gllueProjectSelect', ['page' => 's', 'defaultValue' => $defaultProject, 'label'=>'项目选择']);
?>

<?php
$defaultDates['date_start'] = isset($defaultValue['date_start']) ? $defaultValue['date_start'] : '';
$defaultDates['date_end'] = isset($defaultValue['date_end']) ? $defaultValue['date_end'] : '';
echo $this->render('@common/views/form/dateAreaInput', ['page' => 's', 'defaultDates' => $defaultDates, 'label'=>'时间区间']);
?>


<div class="form-group" style="padding-top:10px">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <input type="submit" id="singlebutton" class="btn btn-primary" value="搜索"/>
  </div>
</div>

</form>




<table id="table_id" class="display">
    <thead>
        <tr>
        <th>日期</th>
        <?php foreach ($data['name'] as $id => $name) : ?>
			<th><?php echo $name ?></th>
        <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
    	<?php foreach ($data['date'] as $date => $user): ?>
		<tr>
			<td><?php echo $date ?></td>
			<?php foreach ($user as $key => $count): ?>
            <td><?php echo $count ?></td>
        	<?php endforeach; ?>
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
} );
</script>