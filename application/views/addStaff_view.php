
<div class="row">
  <div class="col-sm-3"></div>
	<div class="col-sm-6" >
		<h1 class="col-sm-offset-1">新员工</h1>
		<br />
		<form id="addStaff_form" class="form-horizontal" role="form" action="/position_controller/addStaff">
		  <div class="form-group">
		    <label class="col-sm-3 control-label">姓&#12288;&#12288;名</label>
		    <div class="col-sm-9"> 
		      <input type="text" class="form-control" name='add_name' placeholder='Name'/>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-3 control-label">性&#12288;&#12288;别</label>
		    <div class="col-sm-9 radio-inline"> 
		    	<label class="radio-inline">
		    		<input type="radio" name='add_sex' value='0' />男
		      </label>
		      <label class="radio-inline">	
		      	<input type="radio" name='add_sex' value='1' />女
		    	</label>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-3 control-label">电子邮件</label>
		    <div class="col-sm-9"> 
		      <input type="text" class="form-control" name='add_email' placeholder='E-Mail'/>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-3 control-label">岗&#12288;&#12288;位</label>
		    <div class="col-sm-9"> 
		      <input type="text" class="form-control" name='add_position' placeholder='Position'/>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-3 control-label">基本工资</label>
		    <div class="col-sm-9"> 
		      <input type="text" class="form-control" name='add_salary' placeholder='Base Salary'/>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-3 control-label">手&#12288;&#12288;机</label>
		    <div class="col-sm-9"> 
		      <input type="text" class="form-control" name='add_tel' placeholder='Telephone'/>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-3 control-label">地&#12288;&#12288;址</label>
		    <div class="col-sm-9"> 
		      <input type="text" class="form-control" name='add_addr' placeholder='Address'/>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-3 control-label">录用时间</label>
		    <div class="col-sm-9"> 
		      <input type="date" class="form-control" name='add_date' value="<?=date("Y-m-d");?>" placeholder='Employed Date'/>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-3 control-label">状&#12288;&#12288;态</label>
		    <div class="col-sm-9"> 
		      <input type="text" class="form-control" name='add_status' placeholder='Status'/>
		    </div>
		  </div>
		  
		  <div class="form-group">
		    <label class="col-sm-3 control-label">初始密码</label>
		    <div class="col-sm-9"> 
		      <input type="text" class="form-control" placeholder='000000' disabled/>
		    </div>
		  </div>
		  <!-- password -->

		  <div class="form-group">
		  	<div class="col-sm-offset-2 col-sm-8">
		  		<div class="alert hidden"></div>
		  	</div>
    		<div class=" col-sm-2">
      		<button type="button" class="btn btn-default" onclick="submitAddStaff()">保&#12288;存</button>
    		</div>
  		  </div>
		</form>
	</div><!-- form -->
	<div class="col-sm-3"></div><!-- end col-sm-3 -->
</div>
