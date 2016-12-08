
<h1>职员列表</h1>

<table class="table table-hover">
<tr>
<th>职工号</th>
<th>姓名</th>
<th>性别</th>
<th>岗位</th>
<th>详情</th>
</tr>


<?php foreach($staffList as $staff): ?>

<tr class="staff_row">
<td class="staff_id"><?= $staff['id'] ?></td>
<td class="staff_name"><?= $staff['name'] ?></td>
<td><?php if($staff['sex'] == 0) echo '男';else echo '女'; ?></td>
<td><?= $staff['position'] ?></td>
<td><button type="button" class="btn btn-info btn-xs">查看</button></td>
</tr>

<?php endforeach; ?>

</table>

<button type="button" class="btn btn-primary" onClick="location='position_controller/addStaffView';">增加新员工</button>  

<!--  staff_info_detail Dialog  -->
<div class="modal fade" id="detail_modal" tabindex="-1" role="dialog" aria-labelledby="modal_detail" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="modal_detail">Modal title</h4>
      </div>
      <div class="modal-body">
        <table class='table table-bordered'>
          <tr>
            <td>ID</td>
            <td id='detail_id'></td>
          </tr>
          <tr>
            <td>性别</td>
            <td id='detail_sex'></td>
          </tr>
          <tr>
            <td>E-mail</td>
            <td id='detail_email'></td>
          </tr>
          <tr>
            <td>电话</td>
            <td id='detail_tel'></td>
          </tr>
          <tr>
            <td>地址</td>
            <td id='detail_addr'></td>
          </tr>
          <tr>
            <td>状态</td>
            <td id='detail_status'></td>
          </tr>
          <tr>
            <td>职务</td>
            <td id='detail_position'></td>
          </tr>
          <tr>
            <td>基本工资</td>
            <td id='detail_salary'></td>
          </tr>
        </table>

        <h3>修改</h3>
        <form id='detail_form'>
          <input type="hidden" id="new_id" name="new_id" />
          <p><input type="text" name='new_position' class="form-control " placeholder='新职务'/></p>
          <p><input type="text" name='new_salary' class="form-control" placeholder="基本工资" /></p>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" id="save_btn" class="btn btn-primary" onclick="submitNewDetail()">保存</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

