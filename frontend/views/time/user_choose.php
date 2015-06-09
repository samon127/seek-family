<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-1 control-label" style="text-align: right;font-size:25px">成员</label>
  <div class="col-md-4">
    <select id="userSelect" name="selectbasic" class="form-control" onchange="changeUser()">
      <option value=""></option>
      <?php foreach ($users as $id => $user ) :?>
      <option value="<?php echo $id ?>"><?php echo $user['english'] ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<script>
changeUser = function()
{
	value = $( "#userSelect" ).val();

	top.location.href += '&user_id=' + value;
}
</script>