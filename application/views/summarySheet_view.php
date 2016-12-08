<!-- Show summary sheet -->
<script type="text/javascript">
function checkSubmit(){
    if ( confirm("确认删除该薪酬表吗？操作需谨慎！"))
    	return true;
    else
        return false;
}
</script>
<h1>薪酬表</h1>

<table class="table table-hover">
<tr>
<th>年</th>
<th>月</th>
<th>生成时间</th>
<th>生成用户</th>
<th>状态</th>
<th>选项</th>
</tr>
<?php foreach($summarySheet as $summary): ?>
<tr class="staff_row">
<td><?= $summary['year'] ?></td>
<td><?= $summary['month'] ?></td>
<td><?= date("Y-m-d H:i",$summary['createTime'])?></td>
<td>
<?php $info=$this->staff_model->getStaffInfo($summary['createUser']);
echo $info['name'] ?>
</td>
<td><?= $this->salary_model->chnStatus($summary['status']) ?></td>
<td>
<a class="btn btn-primary pull-left" href="/salary_controller/getSalaryList/<?=$summary['year']?>/<?=$summary['month']?>">查看</a>
	<?php
	if ($summary['status'] == 0)
	{
		$attr = array("class"=>'form-inline col-sm-2');
		$hidden = array('year'=>$summary['year'], 'month'=>$summary['month'] );
		$attrb = array(
			'type'	=> 'submit',
			'class' => 'btn btn-danger ',
			'value'	=> '删除',
			'onclick'=> 'return checkSubmit()',
			);
		echo form_open('salary_controller/deleteSalaryList',$attr,$hidden);
		echo form_input($attrb);
		echo form_close();

		$attr = array("class"=>'form-inline col-sm-3');
		$hidden = array('year'=>$summary['year'], 'month'=>$summary['month'] );
		$attrb = array(
			'type'	=> 'submit',
			'class' => 'btn btn-success ',
			'value'	=> '提交财务处'
			);
		echo form_open('salary_controller/setSalaryListStatus',$attr,$hidden);
		echo form_input($attrb);
		echo form_close();
	}
	?>
</td>
</tr>
<?php endforeach; ?>

</table>

