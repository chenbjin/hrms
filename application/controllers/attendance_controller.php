<?php 

class Attendance_controller extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
			
		$this->load->model('staff_model');	
		$this->load->model('attendance_model');
		$this->staff_model->isLogged(TRUE);
		$this->staff_model->checkPriority(2);
	}

	/**
	* called by default, let user choose date.
	* @param none
	* @return none
	*/
	public function index()
	{
		$data['title'] = "Attendance";
		$this->load->view('template/header',$data);
		$this->load->view('date_choose');
		$this->load->view('template/footer');
	}


	/**
     * show attendance list of particular year & month [&day]
     * @param int $year
     * @param int $month
     * @param int $day -optional
     */
	public function attendanceList($year=NULL,$month=NULL,$day=NULL)
	{

		if ($year == NULL || $month == NULL)
		{
			$year = date('Y');
			$month = date('m');
		}
		$list = $this->attendance_model->getAttendanceList($year,$month,$day);

		if ($day==NULL)
		{
			$data['title'] = "$year/$month 考勤信息";
		}
		else
		{
			$data['title'] = "$year / $month / $day 考勤信息";
		}
		
		$data['attendanceList'] = $list;
		$this->load->view('template/header',$data);
		$this->load->view('attendanceList_view');
		$this->load->view('template/footer');
		
	}

    /**
     * add a new attendance record 
     * @param $this->input-post
     * @return bool
     */
	public function addRecord()
	{
		$data['title'] ="添加考勤记录";
		$hrms = $this->session->userdata('hrms');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('staff_id', '职工号', 'trim|required|integer');
        $this->form_validation->set_rules('type', '考勤类型', 'trim|required|');
        if ($this->form_validation->run() == TRUE)
        {
        
        	$data = array();
        	$timestamp = strtotime($this->input->post('date'));
        	$data['year'] = date("Y",$timestamp);
        	$data['month'] = date("m",$timestamp);
        	$data['day'] = date("d",$timestamp);
        	$data['type'] = $this->input->post('type');
        	$data['remark'] = $this->input->post('remark');
        	$data['staff_id'] = $this->input->post('staff_id');
        	$exist = $this->attendance_model->checkAttendanceInfo($data);
        	if($exist)
        	{
        		$url = anchor("/attendance_controller/attendanceList/{$data['year']}/{$data['month']}/{$data['day']}",
        			"{$data['year']}/{$data['month']}/{$data['day']}考勤记录");
        		$data['error']= '该条记录已经存在，请检查'.$url;
        	}
        	elseif ($timestamp > strtotime("today"))
        	{
        		$data['error'] = "请不要预测未来！";
        	}
        	else
        	{
        		$result = $this->attendance_model->addAttendanceInfo($data);
        		if ($result)
        		{
        			$this->session->set_flashdata('success', '考勤记录添加成功！');
        			redirect("/attendance_controller/attendanceList/{$data['year']}/{$data['month']}/{$data['day']}/");
        		}
        		else
        		{
        			$data['error']='考勤记录失败！';
        		}
        	}
        }

        $id_name = $this->staff_model->getStaffList();
        $pageData['staffList'] = $id_name;

		$this->load->view('template/header',$data);
		$this->load->view('addAttendance',$pageData);
		$this->load->view('template/footer');

		
	}

	/**
	* delete one attendance record
	* @param POST
	* @return none
	*/
	public function deleteRecord()
	{
		$paramId = $this->input->post('delete_id');
		$result = $this->attendance_model->deleteAttendanceInfo($paramId);
		if($result)
		{
			$this->session->set_flashdata('success', "考勤记录#{$paramId}删除成功！");
		}
		else
		{
			$this->session->set_flashdata('success', "考勤记录#{$paramId}删除失败！");
		}
		redirect("/attendance_controller/attendanceList/");
	}
    
    /**
    * get coefficient for attendance punish
    * @param none
    * @return none
    */
    public function getCoefficient()
    {
        $co = $this->attendance_model->getCoefficient();
        $data['title'] = "设置考勤参数";
        $data['coefficient'] = $co;
        $this->load->view('template/header',$data);
        $this->load->view('coefficient');
        $this->load->view('template/footer');
    }
    /**
    * set coefficient for attendance punish
    * @param none
    * @return none
    */
    public function setCoefficient()
    {
        $this->load->helper('form');
        $submitted = $this->input->post('submitted');
        if ($submitted)
        {
            $fullAttendance = $this->input->post('fullAttendance');
            $late = $this->input->post('late');
            $absent = $this->input->post('absent');
            $leave = $this->input->post('leave');
        }
		redirect("/attendance_controller/getCoefficient");
    }
}

