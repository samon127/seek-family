<?php

use yii\web\View;
use common\tool\Gllue;
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Family;

?>

<?php $this->registerCssFile("/vendor/dataTables/css/jquery.dataTables.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]); ?>
<?php $this->registerJsFile('/vendor/dataTables/js/jquery.dataTables.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]); ?>

<h2><?php echo $user->englishName ?>用户详情</h2>

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">所有客户（<?php echo count($data['allClient']) ?>）</a></li>
    <li role="presentation"><a href="#tab2" aria-controls="profile" role="tab" data-toggle="tab">CRM签约客户数（<?php echo count($data['allDealClient'])?>）</a></li>
    <li role="presentation"><a href="#tab3" aria-controls="messages" role="tab" data-toggle="tab">所有成交客户（<?php echo count($data['allFinanceClient'])?>）</a></li>
    <li role="presentation"><a href="#tab4" aria-controls="settings" role="tab" data-toggle="tab">半年内成交客户（<?php echo count($data['recentFinanceClient'])?>）</a></li>
    <li role="presentation"><a href="#tab5" aria-controls="settings" role="tab" data-toggle="tab">需要升级客户（<?php echo count($data['upgradeClient'])?>）</a></li>
    <li role="presentation"><a href="#tab6" aria-controls="settings" role="tab" data-toggle="tab">需要降级客户（<?php echo count($data['degradeClient'])?>）</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="tab1">
        <?php echo $this->render('_dataTable', ['model' => $data['allClient']]) ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab2">
        <?php echo $this->render('_dataTable', ['model' => $data['allDealClient']]) ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab3">
        <?php echo $this->render('_dataTable', ['model' => $data['allFinanceClient']]) ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab4">
        <?php echo $this->render('_dataTable', ['model' => $data['recentFinanceClient']]) ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab5">
        <?php echo $this->render('_dataTable', ['model' => $data['upgradeClient']]) ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab6">
        <?php echo $this->render('_dataTable', ['model' => $data['degradeClient']]) ?>
    </div>
  </div>

</div>