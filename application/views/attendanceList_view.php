<script type="text/javascript">
function checkSubmit(){
    if ( confirm("确认删除该条考勤信息吗？操作需谨慎！"))
    	return true;
    else
        return false;
}

</script>

<h2><?=$title?></h2>
<div class="row">
<div class="form-group col-md-3">
	<div class="input-group date form_date col-md-10" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
		<input id="datepicker" onchange="dateChanged()" class="form-control" size="18"  type="text" placeholder="按日期查看"  readonly>
		
		<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	</div>
</div>

<div class="form-group col-md-3">
	<div class="input-group date form_date2 col-md-10" data-date-format="yyyy-mm" data-link-field="dtp_input2" data-link-format="yyyy-mm">
		<input id="datepicker2" onchange="dateChanged2()" class="form-control" size="18"  type="text" placeholder="按月查看"  readonly>
		
		<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	</div>
</div>

</div>
<br />

<?php if(empty($attendanceList)){?>
<div class="alert alert-danger">所选日期无考勤信息,请重新选择</div>
<?php } else{ ?>
<table class="table">
<tr>
<th>#</th>
<th>职工号</th>
<th>姓名</th>
<th>日期</th>
<th>岗位</th>
<th>类型</th>
<th>说明</th>
<th>操作</th>
</tr>

<?php foreach($attendanceList as $record): ?>

<tr>
<td><?= $record['id'] 			?></td>
<td><?= $record['staff_id']		?></td>
<td><?= $record['name']			?></td>
<td><?= $record['year'].'/'.$record['month'].'/'.$record['day']?>	</td>
<td><?= $record['position'] 	?></td>
<td><?= $record['type'] 		?></td>
<td><?= $record['remark']		?></td>
<td>
	<?php
		$attr = array("class"=>'form form-inline col-sm-6');
		$hidden = array('delete_id'=>$record['id']);
		$attrb = array(
	     	'type'	=> 'submit',
	        'class' => 'btn btn-danger ',
	        'value'	=> '删除',
	        'onclick'=> 'return checkSubmit()',
	    );
		echo form_open('/attendance_controller/deleteRecord',$attr,$hidden);
		echo form_input($attrb);
		echo form_close();
	?>
</td>
</tr>

<?php endforeach; } ?>

</table>
<button class="btn btn-primary" name="add" onclick="location='/attendance_controller/addRecord'">添加新考勤</button>
