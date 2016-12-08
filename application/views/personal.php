<?php 
$hrms = $this->session->userdata('hrms');
?>
<h2><?=$hrms['name']?></h2>
<hr />
<div class="row">
    <div class="col-md-10">
    <table class="table">
    <thead>
    <tr>
        <td>#</td>
        <td>年</td>
        <td>月</td>
        <td>基本工资</td>
        <td>请假</td>
        <td>缺勤</td>
        <td>迟到</td>
        <td>全勤</td>
        <td>其他</td>
        <td>最终工资</td>
    </tr>
    </thead>
    <tbody>
    <?php $i=1;foreach ($salaryInfo as $row):?> 
    <tr>
        <td><?=$i++?></td>
        <td><?=$row['year']?></td>
        <td><?=$row['month']?></td>
        <td><?=$row['basic']?></td>
        <td><?=$row['leave']?></td>
        <td><?=$row['absent']?></td>
        <td><?=$row['late']?></td>
        <td><?=$row['fullAttendance']?></td>
        <td>
            <?php
                $row['othersSum'] = 0;
                $row['str'] = "";
                if (!empty($row['others']))
                {
                    foreach ($row['others'] as $one)
                    {
                        $row['othersSum'] += $one['quantity'];
                        if ($one['quantity'] >= 0)
                            $row['str']  .= $one['reason']."+".$one['quantity']."\n";
                        else
                            $row['str']  .= $one['reason'].$one['quantity']."\n";
                    }
                }
            if ($row['othersSum'] != 0) :?>
            <a class="money" data-placement="right" data-trigger="hover" data-content="<?= $row['str'] ?> " title=""  href="#" data-original-title="详细情况">
            <?php endif;?>
            <?php print($row['othersSum'])?>
            </a>
        </td>
        <td><?=$row['final']?></td>
    </tr>
    <?php endforeach;?>
    </tbody>
    </table>
  </div>
</div>
