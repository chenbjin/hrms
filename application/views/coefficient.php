<h2>考勤奖罚参数</h2></br>
<form class="form-horizontal" role="form" method='post'>
    <div class="form-group">
        <label class="col-sm-1 control-label">全勤奖励</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="fullAttendance" placeholder="<?=$coefficient['fullAttendance'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label">迟到惩罚</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="late" placeholder="<?= $coefficient['late'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label">缺勤惩罚</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="absent" placeholder="<?= $coefficient['absent'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label">请假惩罚</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="leave" placeholder="<?= $coefficient['leave'] ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-2">
            <button type="submit" class="btn btn-default">修改参数</button>
        </div>
    </div>
</form>
