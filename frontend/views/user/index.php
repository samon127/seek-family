<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
?>


<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<p><a class="btn btn-primary btn-lg" href="<?php echo Url::to(['user/edit']); ?>" role="button">新建</a></p>

<table id="table_id" class="display">
    <thead>
        <tr>
        	<th>id</th>
        	<th>gllue id</th>
            <th>Key</th>
            <th>姓名</th>
            <th>英文名</th>
            <th>登陆用户名</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($models as $key => $model): ?>
        <tr>
        	<td><?php echo $model->id; ?></td>
        	<td><?php echo $model->gllue_id; ?></td>
            <td><?php echo $model->key; ?></td>
            <td><?php echo $model->name; ?></td>
            <td><?php echo $model->english; ?></td>
            <td><?php echo $model->username; ?></td>

            <td>
            <?php echo Html::a('编辑', Url::to(['user/edit', 'id' => $model->id])) ?>
            </td>
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
    });
} );
</script>
