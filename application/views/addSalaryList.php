<div class="row">
<h1>新建薪酬表</h1>
<div class="col-md-5">
    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
<?php
	$attr = array("class"=>'form-horizontal');
	echo form_open("salary_controller/addSalaryList",$attr);
?>
  <div class="form-group">
    <label for="year" class="col-sm-2 control-label">年</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="year" name="year" placeholder="请输入合法的年份，eg：2013">
    </div>
  </div>
  <div class="form-group">
    <label for="month" class="col-sm-2 control-label">月</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="month" name="month" placeholder="请输入合法的月份，eg：12">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">创建！</button>
    </div>
  </div>
</form>
</div>
</div>
