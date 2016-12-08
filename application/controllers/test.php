<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

    /**
     * 用于测试 
     */
    public function index()
    {
        $this->load->model('salary_model');
        $this->load->model('staff_model');
        echo "<pre>";
        echo bing_pic();
        print_r($_SESSION);
        print_r($this->session->all_userdata());
        echo "</pre>";
  
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
