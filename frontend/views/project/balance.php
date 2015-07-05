<?php
use common\tool\Family;
?>



<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <?php foreach ($projects as $key => $project) :?>
    <li role="presentation" <?php echo $project->id == $activeId ? 'class="active"' : '' ?>><a href="#project<?php echo $project->id ?>" aria-controls="home" role="tab" data-toggle="tab"><?php //echo Family::getProjectName($project)?></a></li>
    <?php endforeach; ?>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <?php foreach ($projects as $key => $project) :?>
    <div role="tabpanel" class="tab-pane <?php echo $project->id == $activeId ? 'active' : '' ?>" id="project<?php echo $project->id ?>">
        <?php
        echo $this->render('@common/views/partial/projectBalanceInfo', ['currentProject'=>$project, 'parentProject'=>$parentProject, 'allSubProjects'=>$projects]);

        if ($parentProject)
        {
            //print_r($parentProject);exit;
            //echo $this->render('@common/views/partial/projectBalanceInfo', ['project'=>$parentProject]);
        }

        ?>
    </div>
    <?php endforeach; ?>
  </div>

</div>







