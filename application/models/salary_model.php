<?php
class Salary_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    /**
     * get salary list of particular year month
     * @param int $year
     * @param int month
     * @return array()
     */
    function getSalaryList($year,$month)
    {
        $query = $this->db->get_where('salary', array('year'=>$year,'month'=>$month));
        $result =  $query->result_array();
        foreach ($result as &$row)
        {
            $row['othersSum'] = 0;
            $row['others'] = unserialize($row['others']);
            if (!empty($row['others']))
            {
                foreach ($row['others'] as $one)
                {
                    $row['othersSum'] += $one['quantity'];
                }
            }
        }
        return $result;
    }

    /**
     * get salary info of $stuff_id [in $year [$month]]
     * @param int $staff_id
     * @param int $year
     * @param int $month
     * @return array()
     */
    function getSalaryInfo($staff_id,$year=NULL,$month=NULL)
    {
        $this->db->order_by("year","desc");
        $this->db->order_by("month","desc");
        if ($month == NULL )
        {
            if ($year == NULL)
            {
                $query = $this->db->get_where('salary',
                    array('staff_id'=>$staff_id));
            }
            else 
            {
                $query = $this->db->get_where('salary',
                    array('staff_id'=>$staff_id,'year'=>$year));
            }
        }
        else
        {
            $query = $this->db->get_where('salary',
               array('staff_id'=>$staff_id,'year'=>$year,'month'=>$month)); 
        }
        $result =  $query->result_array();
        foreach ($result as &$row)
        {
            $row['others'] = unserialize($row['others']);
        }
        return $result;

    }

    /**
     * get salary summary sheet 
     * @return array()
     */
    function getSummarySheet()
    {
        $query = $this->db->get('salarySummary');
        return $query->result_array();
    }

    /**
     * check if the summary sheet exist
     * @param int $year
     * @param int $month
     * @return bool ,TRUE when it exist
     */
    
    function checkSummarySheet($year,$month)
    {
        $query = $this->db->get_where('salarySummary',array( 'year' => $year,'month' => $month));
        if($query->result_array())
            return TRUE;
        else
            return FALSE;
    }

    /**
    * get the $year-$month salary sheet status
    */
    function getSummaryStatus($year,$month)
    {
        $query = $this->db->get_where('salarySummary',array('year'=>$year,'month'=>$month));
        $row =$query->row_array();
        return $row['status'];
    }

    /**
    * get the salary sheet status by $id
    * @param int $id, the primary key of table `salary`
    */
    function checkSalaryInfo($id)
    {
        $query = $this->db->get_where('salary',array('id'=>$id));
        $row = $query->row_array();
        return $this->getSummaryStatus($row['year'],$row['month']);
    }

    function chnStatus($status)
    {
        $statusConfig = array(
            '0'=>'已生成',
            '1'=>'已提交财务处',
            '2'=>'财务处已确认',
            );
        return $statusConfig[$status];
    }
    
    /**
     * update salary info ,target specified by $id
     * @param int $id ,the unique id of db salary table,not staff_id
     * @param array() $data, the [others] salary info of  $id,the $data should be an array like:
     *     Array ( [0] => Array ( [reason] => xxoo [quantity] => -200 ) [1] => Array ( [reason] => dota [quantity] => -500 )... )
     * return bool
     */
    function updateSalaryInfo($id,$data)
    {
        $others = serialize($data);
        $this->db->where('id',$id);
        $this->db->update('salary',array('others'=>$others));

        $coefficient = $this->getCoefficient();
        $othersSum = 0;
        foreach ($data as $row)
        {
            $othersSum += $row['quantity'];
        }

        $nowSalryInfo = array_shift($this->db->get_where('salary',array('id'=>$id))->result_array());
        $newFinal = $nowSalryInfo['basic'] + $nowSalryInfo['fullAttendance'] * $coefficient['fullAttendance']
                + $nowSalryInfo['leave'] * $coefficient['leave'] + $nowSalryInfo['absent'] * $coefficient['absent']
                + $nowSalryInfo['late'] * $coefficient['late'] +$othersSum;
        $this->db->where('id',$id);
        return $this->db->update('salary',array('final'=>$newFinal));
    }

    /**
     * create a new salary list
     * ATTENTION: check the existence of salary table before create! Or SQL will throw an error.
     * @param int $year
     * @param int $month
     * @param int $createUser ,the staff_id of operator
     * @return bool
     */
    function createSalaryList($year,$month,$createUser = 0)
    {
        $summary = array(
            'year' => $year,
            'month' => $month,
            'createUser' => $createUser,
            'createTime' => time(),
        );
         $result =  $this->db->insert('salarySummary',$summary);
        if($result)
        {
            $coefficient = $this->getCoefficient();
            $query = $this->db->query("
                SELECT * ,$year as year,$month as month ,
                    late+absent+`leave`=0 as fullAttendance,
                    basic + (late * {$coefficient['late']} +
                         absent * {$coefficient['absent']} +
                        `leave` *{$coefficient['leave']}) +
                         {$coefficient['fullAttendance']} * (late+absent+`leave`=0) as final
                FROM
                (
                    SELECT staff_id, basic,
                    IFNULL(late,0) as late,
                    IFNULL(absent,0) as absent,
                    IFNULL(`leave`,0) as `leave`
                    FROM
                    (
                        SELECT id as staff_id,baseSalary as basic from staff
                    )as D
                    NATURAL LEFT OUTER JOIN
                    (
                        SELECT staff_id, COUNT( * ) AS late
                        FROM (
                            SELECT *
                            FROM attendance
                            WHERE TYPE =  'late'
                            AND year = $year
                            AND month = $month
                        ) AS lateTable
                        GROUP BY staff_id
                    ) AS A
                    NATURAL left OUTER JOIN
                    (
                        SELECT staff_id, COUNT( * ) AS absent
                        FROM (
                            SELECT *
                            FROM attendance
                            WHERE TYPE =  'absent'
                            AND year = $year
                            AND month = $month
                        ) AS absentTable
                        GROUP BY staff_id
                    ) AS B
                    NATURAL left outer JOIN
                    (
                        SELECT staff_id, COUNT( * ) AS `leave`
                        FROM (
                            SELECT *
                            FROM attendance
                            WHERE TYPE =  'leave'
                            AND year = $year
                            AND month = $month
                        ) AS leaveTable
                        GROUP BY staff_id
                    ) AS C
                ) as ORZ;
            ");

            $salaryTable = $query->result_array();
            $result = $this->db->insert_batch('salary',$salaryTable);
            return $result;
        }
    }

    /**
     * delete all salary info in $year-$month
     * @param int $year
     * @param int $month
     * @return bool
     */
    function deleteSalaryList($year,$month)
    {
        $this->db->delete('salarySummary',array('year'=>$year,'month'=>$month));
        return $this->db->delete('salary',array('year'=>$year,'month'=>$month));
    }

    function setSalaryListStatus($year,$month)
    {
        $this->db->where('year',$year);
        $this->db->where('month',$month);
        return $this->db->update('salarySummary',array('status'=>1));
    }

    /**
     * return coefficient array()
     */
    function getCoefficient()
    {
        $config = $this->db->get_where('config',array('type'=>'coefficient'))->result_array();
        $coefficient = array();
        foreach ($config as $row)
        {
            $coefficient[$row['name']] = $row['value'];
        }
        return $coefficient;
    }

}
/* End of file salary_model.php */
