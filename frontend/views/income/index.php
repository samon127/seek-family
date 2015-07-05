<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\tool\Tool;
use common\models\Income;

$pid = Yii::$app->getRequest()->get('pid');

$incomes = Income::find()
->where(['project_id'=>$pid])
->joinWith('project', true, 'LEFT JOIN')
->joinWith('project.type', true, 'LEFT JOIN')
->joinWith('project.teacher', true, 'LEFT JOIN')
->joinWith('project.city', true, 'LEFT JOIN')
->orderBy('income.income_date')
->all();

?>

<ul class="nav nav-pills" style="float:right;padding:20px">
  <li role="presentation" class="active"><?php echo Html::a('新建收入', Url::to(['income/edit', 'pid'=>$pid, 'from' => Tool::getCurrentUrl()])) ?></li>
</ul>

<?php
echo $this->render('@common/views/partial/incomeTable', ['incomes'=>$incomes]);
?>