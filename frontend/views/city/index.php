<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
?>


<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<p><a class="btn btn-primary btn-lg" href="<?php echo Url::to(['city/edit']); ?>" role="button">新建</a></p>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>Key</th>
            <th>姓名</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($cities as $key => $city): ?>
        <tr>
            <td><?php echo $city->key;  ?></td>
            <td><?php echo $city->name;  ?></td>

            <td>
            <?php echo Html::a('编辑', Url::to(['city/edit', 'id' => $city->id])) ?>
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
