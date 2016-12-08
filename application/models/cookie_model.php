<?php
class Cookie_model extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

    function addCookie($sso,$staff_id,$expire)
    {
    	$data = array(
    		'staff_id'=>$staff_id,
    		'sso'=>$sso,
    		'ip'=>$this->input->ip_address(),
    		'user_agent'=>$this->input->user_agent(),
    		'expire'=>time()+$expire,
    		);
    	$this->db->insert('cookies', $data); 
    }

    function deleteCookie($staff_id)
    {
    	$this->db->delete('cookies', array('staff_id' => $staff_id)); 
    }

    function getCookie($sso)
    {
    	$query = $this->db->get_where('cookies', array('sso' => $sso));
    	return $query->row_array();
    }

}
/* End of file cookie_model.php */