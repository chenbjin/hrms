<?php
class Staff_model extends CI_Model {

    var $session_expire= 3600;
    function __construct()
    {
        parent::__construct();
        $this->load->model('cookie_model');
    }

    /**
     * get staff info of $id
     * @param int $id
     * @return array()
     */
    function getStaffInfo($id)
    {
        $query = $this->db->get_where('staff',array('id'=>$id));
        return $query->row_array();
    }

    /**
     * get staff list from db
     * @param none
     * @return array()
     */

    function getStaffList()
    {
        $this->db->select('id,name,email,tel,addr');
        $this->db->order_by('id');
        $query = $this->db->get('staff');
        return $query->result_array();
    }

    /**
     * add new staff to db
     * @param array() $data
     *  - name:string
     *  - sex :bool  0 for boy ,1 for girl
     *  - email:string
     *  - postion:string
     *  - tel :string
     *  - addr:string
     *  - employeDate:int Unix timestamp
     *  - status :string  在职、离职 etc
     *  - password:string ,encrypted by sha1()
     *  @return bool
     *
     */
    function addStaff($data)
    {
       return $this->db->insert('staff',$data);
    }

    /**
     * update staff info 
     * @param int $id
     * @param array() $data   SEE ABOVE addstaff()
     * @return bool
     */
    function updateStaff($id,$data)
    {
        $this->db->where('id',$id);
        return $this->db->update('staff',$data);
    }

    /**
     * check if the user is logged
     * @param bool $redirect, auto redirect to /user/login when $redirect == TRUE
     * @return bool, TRUE when the user is logged
     */
    function isLogged($redirect = FALSE)
    {
        $hrms = $this->session->userdata('hrms');
        if(empty($hrms))
        {
            if($redirect)
            {
                $this->session->set_flashdata('error', '未登录！');
                redirect('/user/login');
            }
            return FALSE;
        }
        else if ($hrms['logged'] == TRUE)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * login the user
     * @param string $name
     * @param string $password
     * @param bool $remember
     * @return bool
     *
     */
    function login($staff_id,$password,$remember=FALSE)
    {
        $this->db->select('*');
        $this->db->where('id',$staff_id);
        $this->db->where('password',sha1($password));
        $this->db->limit(1);
        $result = $this->db->get('staff');

        if ($result->num_rows() > 0)
        {
            $result = $result->row_array();
            $data = array();
            $data['hrms'] = array(
                'name' => $result['name'],
                'id' => $result['id'],
                'priority' => $result['priority'],
                'logged' => TRUE
            );
            if ($remember) 
            {
                $this->cookie_model->deleteCookie($staff_id);
                $seed = "ooxx".time().$staff_id;
                $sso = sha1(md5($seed));
                $expire = 60*60*24*30;
                $cookie = array(
                    'name'=>"sso",
                    'value'=>$sso,
                    'expire'=>$expire,
                    );
                $this->input->set_cookie($cookie);
                $this->cookie_model->addCookie($sso,$staff_id,$expire);
            }
            $this->session->set_userdata($data);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * try to auto login the user using $_COOKIE['sso']
     * @param string $sso
     */
    function autoLogin($sso)
    {
        $info = $this->cookie_model->getCookie($sso);
        if (!empty($info))
        {
            if ($info['expire'] > time())
            {
                $result = $this->getStaffInfo($info['staff_id']);
                $data = array();
                $data['hrms'] = array(
                'name' => $result['name'],
                'id' => $result['id'],
                'priority' => $result['priority'],
                'logged' => TRUE
                );
                $this->session->set_userdata($data);
            }
            else
            {
                $this->cookie_model->deleteCookie($info['staff_id']);
                delete_cookie("sso");
            }
        }
    }

    /*
     * logout the user,clean cookie & session
     * @param int $staff_id
     */
    function logout($staff_id)
    {
        $this->cookie_model->deleteCookie($staff_id);
        delete_cookie("sso");
        $this->session->sess_destroy();
    }

    /*
     * check the user's priority
     * 4,2,1
     */
    function checkPriority($priority=2)
    {
        $hrms = $this->session->userdata('hrms');
        if (!($hrms['priority'] & $priority))
        {
            $this->session->set_flashdata('error', '权限不足！');
            redirect('/home');
        }
    }

}

/* End of file staff_model.php */