<?php 

class Position_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('staff_model');
		$this->staff_model->isLogged(TRUE);
		$this->staff_model->checkPriority(2);
	}

	/**
	* called by default, show staff list.
	* @param none
	* @return none
	*/
	public function index()
	{	
		$id_name = $this->staff_model->getStaffList();

		$list = array();
		foreach($id_name as $staff)
		{
			$item = $this->staff_model->getStaffInfo($staff['id']);
			$list[] = $item;
		}

		$headData['title'] = "岗位管理";

		$pageData['staffList'] = $list;

		$this->load->view("template/header",$headData);
		$this->load->view("staffList_view",$pageData);
		$this->load->view("template/footer");
	}

	public function addStaffView()
	{
		$headData['title'] = "新员工";
		$this->load->view("template/header",$headData);
		$this->load->view("addStaff_view");
		$this->load->view("template/footer");
	}

	public function updateStaffInfo()
	{
		$data = $this->staff_model->getStaffInfo($this->input->post('new_id'));
		
		$data['position'] = $this->input->post('new_position');
		$data['baseSalary'] = $this->input->post('new_salary');

		if($data['position'] === '') die('Position is empty');
		if($data['baseSalary'] === '') die('BaseSalary is empty');
		
		// input check
		if(preg_match("/^[0-9]+$/", $data['baseSalary']) == 0) die("Salary input error");


		if($data['position'] === '' || $data['baseSalary'] === '')
		{
			die('Input can not be empty');
		}

		$succ = $this->staff_model->updateStaff($this->input->post('new_id'),$data);
		
		if($succ)
		{
			echo "SUCCESS";
		}
		else
		{
			echo "Insert Failed";
		}
	}

	public function addStaff()
	{
		$data['name'] = trim($this->input->post('add_name'));
		$data['sex'] = trim($this->input->post('add_sex'));
		$data['email'] = trim($this->input->post('add_email'));
		$data['position'] = trim($this->input->post('add_position'));
		$data['tel'] = trim($this->input->post('add_tel'));
		$data['addr'] = trim($this->input->post('add_addr'));
		$data['employeDate'] = strtotime(trim($this->input->post('add_date')));
		$data['status'] = trim($this->input->post('add_status'));
		$data['password'] = sha1("000000");
		$data['baseSalary'] = trim($this->input->post('add_salary'));

		
		foreach($data as $key => $value)
		{
			if($data[$key] === '')
			{
				die($key." is empty");
			}
		}
		
		// input check
		if(preg_match("/^[01]$/", $data['sex']) == 0) die("Sex wrong");
		if(preg_match("/^(0|[1-9]([0-9])*)$/", $data['baseSalary']) == 0) die("Base Salary Wrong");
		if(preg_match("/^[0-9]{11}$/",$data['tel']) == 0) die("tel wrong");
		if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/", $data['email']) == 0) die("email wrong");
		

		$succ = $this->staff_model->addStaff($data);

		if($succ)
		{
			echo "SUCCESS";
		}
		else
		{
			echo "Insert Failed";
		}
	}

	public function staffDetail_JSON($id)
	{
		$person = $this->staff_model->getStaffInfo($id);

		echo json_encode($person);
	}

}
