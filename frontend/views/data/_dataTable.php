<?php

use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

?>

<?php
$rand = rand(1000000, 9999999);
?>


<table id="table_<?php echo $rand ?>" class="display">
            <thead>
                <tr>
                    <th>客户名</th>

                </tr>
            </thead>
            <tbody>
        <?php foreach ($model as $client) : ?>
        <tr>
            <td><?php echo HTML::a($client['name'], 'http://112.124.26.22:8080/company#add!id=' . $client['id'], ['target' => '_blank']) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
</table>

<script>
$(document).ready( function () {
    $('#table_<?php echo $rand ?>').DataTable({
    	paging: false,
    	"info": false,
    	"searching": false,
    	"order": []
    });
} );
</script>