<!-- Show salary list -->

<h1><?=$title ?></h1>
 
<table class="table table-hover">
<tr>
<th>年</th>
<th>月</th>
<th>职工号</th>
<th>姓名</th>
<th>基本工资</th>
<th>全勤</th>
<th>请假次数</th>
<th>缺勤次数</th>
<th>迟到次数</th>
<th>其他</th>
<th>最终工资</th>
</tr>

<?php foreach($salaryList as $salary): ?>
<tr class="salary_row">
<td class="salary_year"><?= $salary['year'] ?></td>
<td class="salary_month"><?= $salary['month'] ?></td>
<td class="staff_id" ><?= $salary['staff_id'] ?></td>
<td class="staff_name"><?= $salary['name'] ?></td>
<td><?= $salary['basic'] ?></td>
<td><?= $salary['fullAttendance'] ?></td>
<td><?= $salary['leave'] ?></td>
<td><?= $salary['absent'] ?></td>
<td><?= $salary['late'] ?></td>
<td><?= $salary['othersSum'] ?></td>
<td><?= $salary['final'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<!-- Modal -->
<div class="modal fade" id="salary_modal" tabindex="-1" role="dialog" aria-labelledby="modal_salary" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="modal_salary">Modal title</h4>
      </div>
      <div class="modal-body">
      	<p>职工号: <span id="xxoo"></span></p>
      	<p>最终工资: <span id="salary_final"></span></p>
        <h3>其他...</h3>
        <form id='salary_form'>
          <input type="hidden" id="new_id" name="new_id" />
        </form>
        <a href="#" onclick="add_one_others();" class="btn btn-primary" >+</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" id="save_btn" class="btn btn-primary" onclick="submitNewSalary()">保存</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

