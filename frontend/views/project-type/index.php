<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
?>


<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>


<p><a class="btn btn-primary btn-lg" href="<?php echo Url::to(['project-type/edit']); ?>" role="button">新建</a></p>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>Key</th>
            <th>姓名</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($types as $key => $type): ?>
        <tr>
            <td><?php echo $type->key;  ?></td>
            <td><?php echo $type->name;  ?></td>

            <td>
            <?php echo Html::a('编辑', Url::to(['project-type/edit', 'id' => $type->id])) ?>
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
