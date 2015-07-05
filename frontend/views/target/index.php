<?php
use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;


$pid = Yii::$app->getRequest()->get('pid');
?>

<style>
.container-page{
  width:100%;
}
</style>


<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>成员</th>
            <th>人数目标</th>
            <th>财务目标</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($targets as $target): ?>
        <tr>
            <td><?php echo $target->user->english ?></td>
            <td><?php echo $target->people_target ?></td>
            <td><?php echo $target->revenue_target ?></td>
            <td>
            <?php echo Html::a('编辑', Url::to(['target/edit', 'pid' => $pid])) ?>

            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
    $('#table_id').DataTable({

    });
} );
</script>