<h2><?=$title?></h2>
<div class="row">
    <div class="col-md-10">
    <table class="table">
    <thead>
    <tr>
        <td>职工号</td>
        <td>姓名</td>
        <td>电话</td>
        <td>邮箱</td>
        <td>地址</td>
    </tr>
    </thead>
    <tbody>
    <?php $i=1;foreach ($staffList as $row):?> 
    <tr>
        <td><?=$row['id']?></td>
        <td><?=$row['name']?></td>
        <td><?=$row['tel']?></td>
        <td><?=$row['email']?></td>
        <td><?=$row['addr']?></td>
    </tr>
    <?php endforeach;?>
    </tbody>
    </table>
  </div>
</div>
