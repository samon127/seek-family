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


<table id="table_id" class="display">
    <thead>
        <tr>
            <th>用户</th>
            <th>CRM中总客户</th>
            <th>CRM中已签约客户</th>
            <th>CRM中未签约客户</th>
            <th>成交客户</th>
            <th>半年内成交客户</th>
            <th>需要升级的客户</th>
            <th>需要降级的客户</th>

        </tr>
    </thead>
    <tfoot>
        <tr>
            <th colspan="7" style="text-align:right"></th>
            <th></th>
        </tr>
    </tfoot>
    <tbody>
    <?php foreach ($data as $id => $user): ?>

        <tr>
            <td><?php echo HTML::a($user['name'], Url::to(['data/user', 'uid'=>$id])) ?></td>
            <td><?php echo @$user['allClientCount'] ?></td>
            <td><?php echo @$user['allDealClientCount'] ?></td>
            <td><?php echo @$user['allNodealClientCount'] ?></td>
            <td><?php echo @$user['allFinanceClientCount'] ?></td>
            <td><?php echo @$user['recentFinanceClientCount'] ?></td>
            <td><?php echo @$user['upgradeClientCount'] ?></td>
            <td><?php echo @$user['degradeClientCount'] ?></td>
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