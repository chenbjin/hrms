<?php 

class Salary_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('salary_model');
		$this->load->model('staff_model');
		$this->staff_model->isLogged(TRUE);
		$this->staff_model->checkPriority(2);
	}
	/**
	* called by default, show summary list.
	* @param none
	* @return none
	*/
	public function index()
	{
		redirect('/salary_controller/getSummarySheet/');
	}

	/**
	* show summary list.
	* @param none
	* @return none
	*/
	public function getSummarySheet()
	{	
		$sheet = $this->salary_model->getSummarySheet();
		
		$data['title'] = "薪酬表";

		$summaryData['summarySheet'] = $sheet;

		$this->load->view('template/header',$data);
		$this->load->view('summarySheet_view',$summaryData);
		$this->load->view('template/footer');
	}

	/**
	* show salary list of particular year & month 
	* @param  int $year,int $month
	* @return none
	*/
	public function getSalaryList($year,$month=NULL)
	{
		$list = $this->salary_model->getSalaryList($year,$month);
		foreach ($list as &$row) 
		{		
			$result = $this->staff_model->getStaffInfo($row['staff_id']);
			$row['name'] =  $result['name'];
		}
		$data['title'] = "{$year}/{$month}薪酬表";
		$salaryData['salaryList'] = $list;

		$this->load->view('template/header',$data);
		$this->load->view('salaryList_view',$salaryData);
		$this->load->view('template/footer');
	}
	//update 
	public function updateSalaryInfo()
	{
		$postdata = $this->input->post('data');
		$data = array();
		$i=0;
		$id = $this->input->post('new_id');
		foreach ($postdata as $key=> $row)
		{
			$data[$i++] = $row;
		}
		if ($this->salary_model->checkSalaryInfo($id)==0)
		{
			$succ = $this->salary_model->updateSalaryInfo($id,$data);

			if($succ)
			{
				echo "SUCCESS";
			}
			else
			{
				echo "Insert Failed";
			}
		}
		else
		{
			echo "该薪酬表已经提交，无法增加新的信息！";
		}
	}
	/**
	* To delete salary list of particular year & month
	* @param  int $year,int $month
	* @return none
	*/
	public function deleteSalaryList()
	{
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		if($this->salary_model->checkSummarySheet($year,$month))
		{
			if ($this->salary_model->getSummaryStatus($year,$month)!=0)
			{
				$this->session->set_flashdata('error', "{$year} / {$month} 已经提交，无法删除！");
			}
			else
			{

				$check = $this->salary_model->deleteSalaryList($year,$month);
				if ($check) 
				{
					$this->session->set_flashdata('success', "{$year} / {$month} 薪酬表删除成功！");
				}
				else
				{
					$this->session->set_flashdata('error', "{$year} / {$month} 删除失败！");
				}
			}
		}
		else
		{
			$this->session->set_flashdata('error', "{$year} / {$month} 薪酬表不存在！");
		}
		redirect('/salary_controller/getSummarySheet');
		
	}


	/**
	* To add new salary list of particular year & month
	* @param  int $year,int $month
	* @return none
	*/
	public function addSalaryList()
	{
		$data['title'] ="新建薪酬表";
		$hrms = $this->session->userdata('hrms');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('year', '年', 'trim|required|greater_than[2000]');
        $this->form_validation->set_rules('month', '月', 'trim|required|greater_than[0]|less_than[13]');
        if ($this->form_validation->run() == TRUE)
        {
            $year = $this->input->post("year");
            $month = $this->input->post("month");
            if (strtotime($year."-".$month) < time()) 
            {
            	$check = $this->salary_model->checkSummarySheet($year,$month);
            	if (!$check) 
            	{
            		$result = $this->salary_model->createSalaryList($year,$month,$hrms['id']);
            		if ($result) 
            		{
            			$this->session->set_flashdata('success', '薪酬表创建成功！');
            			redirect("/salary_controller/getSalaryList/$year/$month/");
            		}
            		else
            		{
            			$data['error']='薪酬表创建失败！';
            		}
            	}
            	else
            	{
            		$data['error']=$year.'年'.$month.'月薪酬表已经存在！';
            	}
            }
            else
            {
            	$data['error']=$year.'年'.$month.'月请在未来某天再添加==！';
            }
        }
		$this->load->view('template/header',$data);
		$this->load->view('addSalaryList');
		$this->load->view('template/footer');
	}


	public function salaryDetail_JSON($id,$year,$month)
	{
		$salary = $this->salary_model->getSalaryInfo($id,$year,$month);
		echo json_encode($salary[0]);
	}


	public function setSalaryListStatus()
	{
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		if($this->salary_model->checkSummarySheet($year,$month))
		{
			if ($this->salary_model->getSummaryStatus($year,$month)!=0)
			{
				$this->session->set_flashdata('error', "{$year} / {$month} 已经提交过了！");
			}
			else
			{

				$check = $this->salary_model->setSalaryListStatus($year,$month);
				if ($check) 
				{
					$this->session->set_flashdata('success', "{$year} / {$month} 薪酬表提交成功！");
				}
				else
				{
					$this->session->set_flashdata('error', "{$year} / {$month} 提交失败！");
				}
			}
		}
		else
		{
			$this->session->set_flashdata('error', "{$year} / {$month} 薪酬表不存在！");
		}
		redirect('/salary_controller/getSummarySheet');
	}
}
