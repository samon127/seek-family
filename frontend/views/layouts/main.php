<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\web\View;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$this->registerJsFile('/vendor/jquery/jquery-2.1.4.min.js', ['position' => View::POS_HEAD]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => '斯程项目管理系统',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
//                 ['label' => 'Home', 'url' => ['/site/index']],
//                 ['label' => 'About', 'url' => ['/site/about']],
//                 ['label' => 'Contact', 'url' => ['/site/contact']],
            ];
             if (Yii::$app->user->isGuest) {
                 $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
                 $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
             } else {
                 $menuItems[] = [
                     'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                     'url' => ['/site/logout'],
                     'linkOptions' => ['data-method' => 'post']
                 ];
             }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);

            ?>
<ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">项目设置 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><?php echo Html::a('新建项目', Url::to(['project/edit'])) ?></li>
            <li class="divider"></li>
            <li><?php echo Html::a('项目信息表', Url::to(['project/index'])) ?></li>
            <li><?php echo Html::a('项目财务表', Url::to(['project/finance'])) ?></li>

          </ul>
        </li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">收支统计 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><?php echo Html::a('日收支核对', Url::to(['revenue/daily'])) ?></li>
            <li><?php echo Html::a('应付账款', Url::to(['revenue/daily'])) ?></li>
            <li class="divider"></li>
            <li><?php echo Html::a('收入查询', Url::to(['income/search'])) ?></li>
            <li><?php echo Html::a('支出查询', Url::to(['pay/search'])) ?></li>
            <li class="divider"></li>
            <li><?php echo Html::a('新建收入', Url::to(['income/edit'])) ?></li>
            <li><?php echo Html::a('新建支出', Url::to(['pay/edit'])) ?></li>
          </ul>
        </li>
      </ul>

<ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">时间分配 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><?php echo Html::a('时间分配设置', Url::to(['time/edit'])) ?></li>
          </ul>
        </li>
      </ul>

            <?php
            NavBar::end();
        ?>



        <div class="container container-page">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
