<?php
use common\models\User;
use yii\helpers\Html;

$options = [''=>''];

$users = User::find()->all();

foreach ($users as $id => $user )
{
    if ($user['english'])
    {
        $options[$user->id] = $user->english;
    }
}

?>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton">成员</label>
  <div class="col-md-4">
    <?php
        echo HTML::dropDownList($page.'[user_id]', $defaultValue, $options, ['id' => 'userSelect', 'class' => 'form-control']);
    ?>
  </div>
</div>