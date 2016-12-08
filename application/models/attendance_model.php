<?php
class Attendance_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    /**
     * get one attendance record,target specified by $id (the unique primary key of db attendance table)
     * @param int $id
     * @return array()
     */
    function getAttendanceInfo($id)
    {
        $query = $this->db->get_where('attendance',
            array('id'=>$id));
        return  $query->result_array();
    }

    /**
     * get attendance list of particular year & month [&day]
     * @param int $year
     * @param int $month
     * @param int $day -optional
     * @return array()
     */
    function getAttendanceList($year,$month,$day=NULL)
    {
        $this->db->select('attendance.id,staff_id,name,year,month,day,type,remark,position');
        $this->db->from('attendance');
        $this->db->join('staff','staff.id = attendance.staff_id');
        $this->db->order_by("year","desc");
        $this->db->order_by("month","desc");
        $this->db->order_by("day","desc");
        if ($day == NULL)
        {
            $this->db->where(array('year'=>$year,'month'=>$month));
        }
        else
        {
            $this->db->where( array('year'=>$year,'month'=>$month,'day'=>$day));
        }
        $query = $this->db->get();
        return $query->result_array();

    }

    /**
     * add a new attendance record into db
     * @param array() $data
     *  - staff_id :int
     *  - year:int
     *  - month:int
     *  - day:int
     *  - type:string late|absent|leave for 迟到|缺勤|请假
     *  - remark:string  some more infomaiton about this addendence record
     * @return int $id
     */
    function addAttendanceInfo($data)
    {
        $this->db->insert('attendance',$data);
        return $this->db->insert_id();
    }

    /**
     * check if the attendance info exist
     * @param array() $data
     *  - staff_id :int
     *  - year:int
     *  - month:int
     *  - day:int
     * @return bool ,TRUE when it exist
     */
    function checkAttendanceInfo($data)
    {
        unset($data['type']);
        unset($data['remark']);
        $query = $this->db->get_where('attendance',$data);
        if ($query->num_rows>0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    /**
     * delete a attendance record from db
     * @param int $id
     * @return bool
     */
    function deleteAttendanceInfo($id)
    {
        return $this->db->delete('attendance',array('id'=>$id));
    }
    
    function getCoefficient()
    {
        $config = $this->db->get_where('config',array('type'=>'coefficient'))->result_array();
        $co = array();
        foreach ($config as $row)
        {
            $co[$row['name']] = $row['value'];
        }
        return $co;
    }
}
/* End of file attendance_model.php */
