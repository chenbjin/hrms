

<?php $this->load->helper('form'); ?>

<?=form_open("attendance_controller/attendanceList");?>

<p><?=form_input("year",date("Y"));?></p>
<p><?=form_input("month",date("m"));?></p>
<p><?=form_input("day",date("d"));?></p>

<p><?=form_submit("submit_date","Submit!");?></p>

</form>
	
</div>