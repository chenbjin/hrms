<?php
class User  extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('staff_model');  
        $this->load->model('salary_model');
    }

    public function index()
    {
        $this->staff_model->isLogged(TRUE);
        $hrms = $this->session->userdata('hrms');

        $data['title'] ="HOME";
        $pic = "/static/img/background/1.jpg";
        $data['style'] ='
        body {
            background:url('.$pic.');
            background-size: cover;
        }
        .container{
            background:url(/static/img/res/w-bg.png) repeat;
            border-radius: 6px;
            box-shadow: 0px 0px 25px #888888;
        }
        .navbar-inverse {
            background-color: rgba(34, 34, 34, 0.87);
            border-color: rgba(8, 8, 8, 0.86);
        }
        @media screen and (max-width: 700px) {
            body {background:none}
            .container{border:none}
        }
        ';
        $this->load->view('template/header',$data);
        $this->load->view('home');
        $this->load->view('template/footer');
    }

    public function personal()
    {
        $this->staff_model->isLogged(TRUE);         
        $hrms = $this->session->userdata('hrms');
        $data['salaryInfo'] = $this->salary_model->getSalaryInfo($hrms['id']);
        $data['title'] ="HOME";
        $this->load->view('template/header',$data);
        $this->load->view('personal');
        $this->load->view('template/footer');
    }

    public function contacts()
    {
        $this->staff_model->isLogged(TRUE);  
        $hrms = $this->session->userdata('hrms');
        $data['staffList'] = $this->staff_model->getStaffList();
        $data['title'] ="通讯录";
        $this->load->view('template/header',$data);
        $this->load->view('contacts');
        $this->load->view('template/footer');

    }
    
    public function security()
    {
        $this->staff_model->isLogged(TRUE);
        $hrms = $this->session->userdata('hrms');
    
        $data['title'] ="个人信息";
        $new = array();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', '邮件', 'trim|required|valid_email');
        $this->form_validation->set_rules('tel', '电话', 'trim|required|integer');
        $this->form_validation->set_rules('addr', '地址', 'trim|required');
        if($this->input->post('password'))
        {
            $this->form_validation->set_rules('password', '密码', 'required|matches[passconf]');
            $this->form_validation->set_rules('passconf', '密码确认', 'required');
            $new['password'] = sha1($this->input->post('password'));
        }
        if ($this->form_validation->run() == TRUE)
        {
            $postdata = $this->input->post();
            $new['email'] = $postdata['email'];
            $new['tel']   = $postdata['tel'];
            $new['addr']  = $postdata['addr'];
            $result = $this->staff_model->updateStaff($hrms['id'],$new);
            if ($result)
            {
              $data['success']='资料更改成功！';
            }
            else
            {
                $data['error']='资料更改失败，请重试';
            }
        }
        $data['info'] = $this->staff_model->getStaffInfo($hrms['id']);
        $this->load->view('template/header',$data);
        $this->load->view('security');
        $this->load->view('template/footer');
    }

    public function login($ajax = false)
    {
        //try autologin
        $sso = $this->input->cookie('sso');
        if($sso)
        {
            $this->staff_model->autoLogin($sso);
        }

        //find out if they're already logged in, if they are redirect them
        $isLogged   = $this->staff_model->isLogged();
        if ($isLogged)
        {
            $this->session->set_flashdata('success', '您已经登录！');
            redirect('/home');
        }
        $data['title'] = '登录'; 
        $this->load->helper('form');
        $submitted      = $this->input->post('submitted');
        if ($submitted)
        {
            $name      = $this->input->post('name');
            $password   = $this->input->post('password');
            $remember   = $this->input->post('remember');
            $login      = $this->staff_model->login($name, $password, $remember);
            if ($login)
            {
                //to login via ajax
                if($ajax)
                {
                    die(json_encode(array('result'=>true)));
                }
                else
                {
                    redirect('/home');
                }
            }
            else
            {
                //to login via ajax
                if($ajax)
                {
                    die(json_encode(array('result'=>false)));
                }
                else
                {
                    $this->session->set_flashdata('error', '登录失败！请检查用户名与密码！');
                    redirect('user/login');
                }
            }
        }
        $data['noNavbar'] = TRUE;   
        $this->load->view('template/header',$data);
        $this->load->view('login');
        $this->load->view('template/footer');
    }
    
    public function logout()
    {
        $hrms = $this->session->userdata('hrms');
        $this->staff_model->logout($hrms['id']);
        redirect('user/login');
    }
    
    
}
