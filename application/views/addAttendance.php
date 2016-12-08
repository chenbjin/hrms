

<div class="row">
<h1>添加考勤记录</h1>
<div class="col-md-5">
<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
<?php
	$attr = array("class"=>'form-horizontal');
	echo form_open("attendance_controller/addRecord",$attr);
?>
  <div class="form-group">
    <label for="date" class="col-sm-2 control-label">日期</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" value="<?php echo date("Y-m-d")?>" id="date" name="date" placeholder="">
    </div>
  </div>
  <div class="form-group">
    <label for="staff_id" class="col-sm-2 control-label">职工号</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="staff_id" name="staff_id" placeholder="">
    </div>
  </div>

  <div class="form-group">
    <label for="type" class="col-sm-2 control-label">类型</label>
    <div class="col-sm-10">
    <select class="form-control" id="type" name="type">
       <option value="late">迟到</option>
       <option value="absent">缺勤</option>
       <option value="leave">请假</option>
    </select>
    </div>
  </div>

  <div class="form-group">
    <label for="remark" class="col-sm-2 control-label">说明</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="remark" name="remark" placeholder="">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">增加！</button>
    </div>
  </div>
<?php 
  echo form_close();
?>
</div><!-- end col-5 -->
<div class="col-md-1"></div>
<div class='col-md-5'>
  <table class="table table-hover">
  <tr>
  <th>职工号</th>
  <th>姓名</th>
  </tr> 
  
  <?php foreach($staffList as $staff): ?> 

  <tr class="staff_row">
  <td class="staff_id"><?= $staff['id'] ?></td>
  <td class="staff_name"><?= $staff['name'] ?></td>
  </tr> 

  <?php endforeach; ?>  

  </table>
</div>
</div><!-- end row-->
