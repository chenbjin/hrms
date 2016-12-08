<div class="row">
<div class="col-md-4">
    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?php echo form_open('/user/security',array('role'=>'form')); ?>
    <div class="form-group">
       <label for="">邮件</label>
       <input type="text" name="email" class="form-control" value="<?=$info['email']?>" size="50" />
    </div>
    <div class="form-group">
       <label for="">电话</label>
       <input type="text" name="tel" class="form-control" value="<?=$info['tel']?>" size="50" />
    </div>

    <div class="form-group">
       <label for="">地址</label>
        <input type="text" name="addr" class="form-control" value="<?=$info['addr']?>" size="50" />
    </div>

    <div class="form-group">
       <label for="">密码(无需更改请留空)</label>
        <div class="row">
        <div class="col-xs-6">
          <input name="password" class="form-control" placeholder="password" type="password" >
        </div>
        <div class="col-xs-6">
         <input name="passconf" class="form-control" placeholder="password again" type="password" >
        </div>
        </div>
    </div>

    <div class="form-group">
        <input type="submit" value="Submit" class="btn btn-primary" />
    </div>
  </form>
  </div>
</div>