<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Report_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_bulan($paymentID, $id_kelas, $ds, $de)
    {
        if($id_kelas != '0'){
            $data = $this->db->query("SELECT DISTINCT `bulan`.`bulan_id`, `bulan_bill`, `bulan_date_pay`, `bulan_number_pay`, `bulan_status`, `bulan_input_date`, `bulan_last_update`, `student_student_id`, `student_img`, `student_nis`, `student_full_name`, `student_name_of_mother`, `student_parent_phone`, `student`.`class_class_id`, `student`.`majors_majors_id`, `majors_name`, `majors_short_name`, `class_name`, `payment_payment_id`, `period_period_id`, `period_status`, `period_start`, `period_end`, `pos_name`, `account_account_id`, `payment_type`, `user_user_id`, `user_full_name`, `account_id`, `account_code`, `month_month_id`, `month_name`, `bulan`.`student_student_id`, `bulan`.`student_student_id` FROM `bulan` LEFT JOIN `month` ON `month`.`month_id` = `bulan`.`month_month_id` LEFT JOIN `student` ON `student`.`student_id` = `bulan`.`student_student_id` LEFT JOIN `payment` ON `payment`.`payment_id` = `bulan`.`payment_payment_id` LEFT JOIN `pos` ON `pos`.`pos_id` = `payment`.`pos_pos_id` LEFT JOIN `period` ON `period`.`period_id` = `payment`.`period_period_id` LEFT JOIN `class` ON `class`.`class_id` = `student`.`class_class_id` LEFT JOIN `majors` ON `majors`.`majors_id` = `student`.`majors_majors_id` LEFT JOIN `users` ON `users`.`user_id` = `bulan`.`user_user_id` LEFT JOIN `account` ON `account`.`account_id` = `pos`.`account_account_id` WHERE `bulan`.`bulan_status` = 1 AND `bulan`.`bulan_date_pay` BETWEEN '$ds' AND '$de' AND payment.payment_id = '$paymentID' AND class.class_id = '$id_kelas' AND majors.majors_status = '1' ORDER BY `student_nis` ASC, `month_month_id` ASC")->result_array();
        } else {
            $data = $this->db->query("SELECT DISTINCT `bulan`.`bulan_id`, `bulan_bill`, `bulan_date_pay`, `bulan_number_pay`, `bulan_status`, `bulan_input_date`, `bulan_last_update`, `student_student_id`, `student_img`, `student_nis`, `student_full_name`, `student_name_of_mother`, `student_parent_phone`, `student`.`class_class_id`, `student`.`majors_majors_id`, `majors_name`, `majors_short_name`, `class_name`, `payment_payment_id`, `period_period_id`, `period_status`, `period_start`, `period_end`, `pos_name`, `account_account_id`, `payment_type`, `user_user_id`, `user_full_name`, `account_id`, `account_code`, `month_month_id`, `month_name`, `bulan`.`student_student_id`, `bulan`.`student_student_id` FROM `bulan` LEFT JOIN `month` ON `month`.`month_id` = `bulan`.`month_month_id` LEFT JOIN `student` ON `student`.`student_id` = `bulan`.`student_student_id` LEFT JOIN `payment` ON `payment`.`payment_id` = `bulan`.`payment_payment_id` LEFT JOIN `pos` ON `pos`.`pos_id` = `payment`.`pos_pos_id` LEFT JOIN `period` ON `period`.`period_id` = `payment`.`period_period_id` LEFT JOIN `class` ON `class`.`class_id` = `student`.`class_class_id` LEFT JOIN `majors` ON `majors`.`majors_id` = `student`.`majors_majors_id` LEFT JOIN `users` ON `users`.`user_id` = `bulan`.`user_user_id` LEFT JOIN `account` ON `account`.`account_id` = `pos`.`account_account_id` WHERE `bulan`.`bulan_status` = 1 AND `bulan`.`bulan_date_pay` BETWEEN '$ds' AND '$de' AND payment.payment_id = '$paymentID' AND majors.majors_status = '1' ORDER BY `student_nis` ASC, `month_month_id` ASC")->result_array();
        }
     
     return $data;
    }
    
    function get_bebas($paymentID, $id_kelas, $ds, $de)
    {
        if($id_kelas != '0'){
            $data = $this->db->query("SELECT `bebas_pay`.`bebas_pay_id`, `bebas_pay_bill`, `bebas_pay_number`, `bebas_pay_desc`, `bebas_pay_input_date`, `bebas_pay_last_update`, `bebas_pay`.`bebas_bebas_id`, `bebas_bill`, `student_student_id`, `student_nis`, `student`.`class_class_id`, `class_name`, `student_full_name`, `student_name_of_mother`, `student_parent_phone`, `payment_payment_id`, `payment_type`, `period_start`, `period_end`, `payment`.`pos_pos_id`, `pos_name`, `user_user_id`, `user_full_name`, `account_id`, `account_code` FROM `bebas_pay` LEFT JOIN `bebas` ON `bebas`.`bebas_id` = `bebas_pay`.`bebas_bebas_id` LEFT JOIN `student` ON `student`.`student_id` = `bebas`.`student_student_id` LEFT JOIN `payment` ON `payment`.`payment_id` = `bebas`.`payment_payment_id` LEFT JOIN `period` ON `period`.`period_id` = `payment`.`period_period_id` LEFT JOIN `pos` ON `pos`.`pos_id` = `payment`.`pos_pos_id` LEFT JOIN `class` ON `class`.`class_id` = `student`.`class_class_id` LEFT JOIN `users` ON `users`.`user_id` = `bebas_pay`.`user_user_id` LEFT JOIN `account` ON `account`.`account_id` = `pos`.`account_account_id` LEFT JOIN `majors` ON `majors`.`majors_id` = `account`.`account_majors_id` WHERE `bebas_pay`.`bebas_pay_input_date` BETWEEN '$ds' AND '$de' AND `payment`.`payment_id` = '$paymentID' AND `class`.`class_id` = '$id_kelas' AND majors.majors_status = '1' ORDER BY `student_nis`, `bebas_pay_last_update` ASC")->result_array();
        } else {
            $data = $this->db->query("SELECT `bebas_pay`.`bebas_pay_id`, `bebas_pay_bill`, `bebas_pay_number`, `bebas_pay_desc`, `bebas_pay_input_date`, `bebas_pay_last_update`, `bebas_pay`.`bebas_bebas_id`, `bebas_bill`, `student_student_id`, `student_nis`, `student`.`class_class_id`, `class_name`, `student_full_name`, `student_name_of_mother`, `student_parent_phone`, `payment_payment_id`, `payment_type`, `period_start`, `period_end`, `payment`.`pos_pos_id`, `pos_name`, `user_user_id`, `user_full_name`, `account_id`, `account_code` FROM `bebas_pay` LEFT JOIN `bebas` ON `bebas`.`bebas_id` = `bebas_pay`.`bebas_bebas_id` LEFT JOIN `student` ON `student`.`student_id` = `bebas`.`student_student_id` LEFT JOIN `payment` ON `payment`.`payment_id` = `bebas`.`payment_payment_id` LEFT JOIN `period` ON `period`.`period_id` = `payment`.`period_period_id` LEFT JOIN `pos` ON `pos`.`pos_id` = `payment`.`pos_pos_id` LEFT JOIN `class` ON `class`.`class_id` = `student`.`class_class_id` LEFT JOIN `users` ON `users`.`user_id` = `bebas_pay`.`user_user_id` LEFT JOIN `account` ON `account`.`account_id` = `pos`.`account_account_id` LEFT JOIN `majors` ON `majors`.`majors_id` = `account`.`account_majors_id` WHERE `bebas_pay`.`bebas_pay_input_date` BETWEEN '$ds' AND '$de' AND `payment`.`payment_id` = '$paymentID' AND majors.majors_status = '1' ORDER BY `student_nis`, `bebas_pay_last_update` ASC")->result_array();
        }
        
        return $data;
    }
    
    function get_sum_bulan($id_kelas, $ds, $de)
    {
        if($id_kelas != '0'){
            $data = $this->db->query("SELECT DISTINCT SUM(`bulan_bill`) as `total` FROM `bulan` LEFT JOIN `month` ON `month`.`month_id` = `bulan`.`month_month_id` LEFT JOIN `student` ON `student`.`student_id` = `bulan`.`student_student_id` LEFT JOIN `payment` ON `payment`.`payment_id` = `bulan`.`payment_payment_id` LEFT JOIN `pos` ON `pos`.`pos_id` = `payment`.`pos_pos_id` LEFT JOIN `period` ON `period`.`period_id` = `payment`.`period_period_id` LEFT JOIN `class` ON `class`.`class_id` = `student`.`class_class_id` LEFT JOIN `majors` ON `majors`.`majors_id` = `student`.`majors_majors_id` LEFT JOIN `users` ON `users`.`user_id` = `bulan`.`user_user_id` LEFT JOIN `account` ON `account`.`account_id` = `pos`.`account_account_id` WHERE `bulan`.`bulan_status` = 1 AND `bulan`.`bulan_date_pay` BETWEEN '$ds' AND '$de' AND class.class_id = '$id_kelas' AND majors.majors_status = '1' ORDER BY `student_nis` ASC, `month_month_id` ASC")->row_array();
        } else {
            $data = $this->db->query("SELECT DISTINCT SUM(`bulan_bill`) as `total` FROM `bulan` LEFT JOIN `month` ON `month`.`month_id` = `bulan`.`month_month_id` LEFT JOIN `student` ON `student`.`student_id` = `bulan`.`student_student_id` LEFT JOIN `payment` ON `payment`.`payment_id` = `bulan`.`payment_payment_id` LEFT JOIN `pos` ON `pos`.`pos_id` = `payment`.`pos_pos_id` LEFT JOIN `period` ON `period`.`period_id` = `payment`.`period_period_id` LEFT JOIN `class` ON `class`.`class_id` = `student`.`class_class_id` LEFT JOIN `majors` ON `majors`.`majors_id` = `student`.`majors_majors_id` LEFT JOIN `users` ON `users`.`user_id` = `bulan`.`user_user_id` LEFT JOIN `account` ON `account`.`account_id` = `pos`.`account_account_id` WHERE `bulan`.`bulan_status` = 1 AND `bulan`.`bulan_date_pay` BETWEEN '$ds' AND '$de' AND majors.majors_status = '1' ORDER BY `student_nis` ASC, `month_month_id` ASC")->row_array();
        }
     
     return $data;
    }
    
    function get_sum_bebas($id_kelas, $ds, $de)
    {
        if($id_kelas != '0'){
            $data = $this->db->query("SELECT SUM(`bebas_pay_bill`) as `total` FROM `bebas_pay` LEFT JOIN `bebas` ON `bebas`.`bebas_id` = `bebas_pay`.`bebas_bebas_id` LEFT JOIN `student` ON `student`.`student_id` = `bebas`.`student_student_id` LEFT JOIN `payment` ON `payment`.`payment_id` = `bebas`.`payment_payment_id` LEFT JOIN `period` ON `period`.`period_id` = `payment`.`period_period_id` LEFT JOIN `pos` ON `pos`.`pos_id` = `payment`.`pos_pos_id` LEFT JOIN `class` ON `class`.`class_id` = `student`.`class_class_id` LEFT JOIN `users` ON `users`.`user_id` = `bebas_pay`.`user_user_id` LEFT JOIN `account` ON `account`.`account_id` = `pos`.`account_account_id` LEFT JOIN `majors` ON `majors`.`majors_id` = `account`.`account_majors_id` WHERE `bebas_pay`.`bebas_pay_input_date` BETWEEN '$ds' AND '$de' AND `class`.`class_id` = '$id_kelas' AND majors.majors_status = '1' ORDER BY `student_nis`, `bebas_pay_last_update` ASC")->row_array();
        } else {
            $data = $this->db->query("SELECT SUM(`bebas_pay_bill`) as `total` FROM `bebas_pay` LEFT JOIN `bebas` ON `bebas`.`bebas_id` = `bebas_pay`.`bebas_bebas_id` LEFT JOIN `student` ON `student`.`student_id` = `bebas`.`student_student_id` LEFT JOIN `payment` ON `payment`.`payment_id` = `bebas`.`payment_payment_id` LEFT JOIN `period` ON `period`.`period_id` = `payment`.`period_period_id` LEFT JOIN `pos` ON `pos`.`pos_id` = `payment`.`pos_pos_id` LEFT JOIN `class` ON `class`.`class_id` = `student`.`class_class_id` LEFT JOIN `users` ON `users`.`user_id` = `bebas_pay`.`user_user_id` LEFT JOIN `account` ON `account`.`account_id` = `pos`.`account_account_id` LEFT JOIN `majors` ON `majors`.`majors_id` = `account`.`account_majors_id` WHERE `bebas_pay`.`bebas_pay_input_date` BETWEEN '$ds' AND '$de' AND majors.majors_status = '1' ORDER BY `student_nis`, `bebas_pay_last_update` ASC")->row_array();
        }
        
        return $data;
    }
    
    function get_rekap_bulan_kas($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('bulan.bulan_id', $params['id']);
        }

        if(isset($params['student_id']))
        {
            $this->db->where('bulan.student_student_id', $params['student_id']);
        }

        if (isset($params['multiple_id'])) {
            $this->db->where_in('bulan.bulan_id', $params['multiple_id']);
        }

        if (isset($params['date'])) {
            $this->db->where('bulan_date_pay', $params['date']);
        }

        if(isset($params['student_nis']))
        {
            $this->db->where('student_nis', $params['student_nis']);
        }

        if(isset($params['bulan_bill']))
        {
            $this->db->where('bulan_bill', $params['bulan_bill']);
        }

        if(isset($params['payment_id']))
        {
            $this->db->where('bulan.payment_payment_id', $params['payment_id']);
        }

        if(isset($params['month_id']))
        {
            $this->db->where('bulan.month_month_id', $params['month_id']);
        }

        if(isset($params['class_id']))
        {
            $this->db->where('student.class_class_id', $params['class_id']);
        }
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $params['account_majors_id']);             
            $this->db->like('acc.account_description', 'Tunai');
            $this->db->like('bulan_noref', 'SP', 'after');
        }
            
        if(isset($params['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Tunai');
		    $this->db->like('bulan_noref', 'SP', 'after');
		}

        if(isset($params['period_id']))
        {
            $this->db->where('payment.period_period_id', $params['period_id']);
        }

        if(isset($params['status']))
        {
            $this->db->where('bulan.bulan_status', $params['status']);
        }

        if(isset($params['period_status']))
        {
            $this->db->where('period_status', $params['period_status']);
        }

        if(isset($params['bulan_input_date']))
        {
            $this->db->where('bulan_input_date', $params['bulan_input_date']);
        }

        if(isset($params['bulan_last_update']))
        {
            $this->db->where('bulan_last_update', $params['bulan_last_update']);
        }
        
        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('bulan_date_pay >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('bulan_date_pay <=', $params['date_end'] . ' 23:59:59');
        }
        
        if(isset($params['month_start']) AND isset($params['month_end'])){
            $this->db->where('month_month_id >=', $params['month_start']);
            $this->db->where('month_month_id <=', $params['month_end']);
        }
        
        if(isset($params['date']))
        {
            $this->db->where('bulan_date_pay', $params['date']);
        }

        if(isset($params['group']))
        {

        $this->db->group_by('bulan.student_student_id'); 

        }

        if(isset($params['grup']))
        {

        $this->db->group_by('bulan.month_month_id'); 

        }

        if(isset($params['paymentt']))
        {

        $this->db->group_by('bulan.payment_payment_id'); 

        }

        if(isset($params['limit']))
        {
            if(!isset($params['offset']))
            {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }
        
        $this->db->distinct();
        
        $this->db->order_by('payment_payment_id');
        
        if(isset($params['urutan'])) {
            
        $this->db->order_by('bulan_date_pay', 'asc');
            
        } else {
        
        $this->db->order_by('month_month_id', 'asc');
            
        }
        
        $this->db->group_by('account.account_id');
        
        $this->db->where('majors_status', '1');

        $this->db->select('account.account_id, account.account_code, account.account_description, sum(bulan.bulan_bill) as total_bulan_bill, kas.kas_account_id');
        
        $this->db->join('month', 'month.month_id = bulan.month_month_id', 'left');

        $this->db->join('student', 'student.student_id = bulan.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bulan.payment_payment_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');

        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
        $this->db->join('users', 'users.user_id = bulan.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bulan.bulan_noref');
        $this->db->join('account', 'account.account_id = pos.account_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        
        $res = $this->db->get('bulan');

        if(isset($params['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }
    
    function get_rekap_bulan_last_kas($param = array())
    {
        if(isset($param['id']))
        {
            $this->db->where('bulan.bulan_id', $param['id']);
        }

        if(isset($param['student_id']))
        {
            $this->db->where('bulan.student_student_id', $param['student_id']);
        }

        if (isset($param['multiple_id'])) {
            $this->db->where_in('bulan.bulan_id', $param['multiple_id']);
        }

        if (isset($param['date'])) {
            $this->db->where('bulan_date_pay', $param['date']);
        }

        if(isset($param['student_nis']))
        {
            $this->db->where('student_nis', $param['student_nis']);
        }

        if(isset($param['bulan_bill']))
        {
            $this->db->where('bulan_bill', $param['bulan_bill']);
        }

        if(isset($param['payment_id']))
        {
            $this->db->where('bulan.payment_payment_id', $param['payment_id']);
        }

        if(isset($param['month_id']))
        {
            $this->db->where('bulan.month_month_id', $param['month_id']);
        }

        if(isset($param['class_id']))
        {
            $this->db->where('student.class_class_id', $param['class_id']);
        }
        
        if(isset($param['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $param['account_majors_id']);             
            $this->db->like('acc.account_description', 'Tunai');
            $this->db->like('bulan_noref', 'SP', 'after');
        }
            
        if(isset($param['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Tunai');
		    $this->db->like('bulan_noref', 'SP', 'after');
		}

        if(isset($param['period_id']))
        {
            $this->db->where('payment.period_period_id', $param['period_id']);
        }

        if(isset($param['status']))
        {
            $this->db->where('bulan.bulan_status', $param['status']);
        }

        if(isset($param['period_status']))
        {
            $this->db->where('period_status', $param['period_status']);
        }

        if(isset($param['bulan_input_date']))
        {
            $this->db->where('bulan_input_date', $param['bulan_input_date']);
        }

        if(isset($param['bulan_last_update']))
        {
            $this->db->where('bulan_last_update', $param['bulan_last_update']);
        }
        
        if(isset($param['date_start']) AND isset($param['date_end']))
        {
            $this->db->where('bulan_date_pay >=', $param['date_start'] . ' 00:00:00');
            $this->db->where('bulan_date_pay <=', $param['date_end'] . ' 23:59:59');
        }
        
        if(isset($param['month_start']) AND isset($param['month_end'])){
            $this->db->where('month_month_id >=', $param['month_start']);
            $this->db->where('month_month_id <=', $param['month_end']);
        }
        
        if(isset($param['date']))
        {
            $this->db->where('bulan_date_pay', $param['date']);
        }

        if(isset($param['group']))
        {

        $this->db->group_by('bulan.student_student_id'); 

        }

        if(isset($param['grup']))
        {

        $this->db->group_by('bulan.month_month_id'); 

        }

        if(isset($param['paymentt']))
        {

        $this->db->group_by('bulan.payment_payment_id'); 

        }

        if(isset($param['limit']))
        {
            if(!isset($param['offset']))
            {
                $param['offset'] = NULL;
            }

            $this->db->limit($param['limit'], $param['offset']);
        }
        
        $this->db->distinct();
        
        $this->db->order_by('payment_payment_id');

        $this->db->order_by('month_month_id', 'asc');

        $this->db->group_by('account.account_id');
        
        $this->db->where('majors_status', '1');

        $this->db->select('account.account_id, account.account_code, account.account_description, sum(bulan.bulan_bill) as total_bulan_bill, kas.kas_account_id');
        
        $this->db->join('month', 'month.month_id = bulan.month_month_id', 'left');$this->db->join('student', 'student.student_id = bulan.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bulan.payment_payment_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');

        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
        $this->db->join('users', 'users.user_id = bulan.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bulan.bulan_noref');
        $this->db->join('account', 'account.account_id = pos.account_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        
        $res = $this->db->get('bulan');

        if(isset($param['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }
    
    function get_rekap_bebas_kas($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('bebas_pay.bebas_pay_id', $params['id']);
        }

        if(isset($params['student_id']))
        {
            $this->db->where('bebas.student_student_id', $params['student_id']);
        }
        
        if(isset($params['period_id']))
        {
            $this->db->where('payment.period_period_id', $params['period_id']);
        }

        if(isset($params['student_nis']))
        {
            $this->db->where('student.student_nis', $params['student_nis']);
        }  

        if (isset($params['date'])) {
            $this->db->where('bebas_pay_input_date', $params['date']);
        }      

        if(isset($params['payment_id']))
        {
            $this->db->where('bebas.payment_payment_id', $params['payment_id']);
        }

        if(isset($params['bebas_id']))
        {
            $this->db->where('bebas_pay.bebas_bebas_id', $params['bebas_id']);
        }

        if(isset($params['class_id']))
        {
            $this->db->where('student.class_class_id', $params['class_id']);
        }

        if(isset($params['bebas_pay_input_date']))
        {
            $this->db->where('bebas_pay_input_date', $params['bebas_pay_input_date']);
        }

        if(isset($params['bebas_pay_last_update']))
        {
            $this->db->where('bebas_pay_last_update', $params['bebas_pay_last_update']);
        }
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $params['account_majors_id']);             
            $this->db->like('acc.account_description', 'Tunai');
            $this->db->like('bebas_pay_noref', 'SP', 'after');
        }
            
        if(isset($params['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Tunai');
		    $this->db->like('bebas_pay_noref', 'SP', 'after');
		}
        
        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('bebas_pay_input_date >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('bebas_pay_input_date <=', $params['date_end'] . ' 23:59:59');
        }

        if(isset($params['date']))
        {
            $this->db->where('bebas_pay_input_date', $params['date']);
        }

        if(isset($params['group']))
        {

        $this->db->group_by('bebas_pay.bebas_bebas_id'); 

        }

        if(isset($params['limit']))
        {
            if(!isset($params['offset']))
            {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if(isset($params['order_by']))
        {
            $this->db->order_by($params['order_by'], 'desc');
        }
        else
        {
            $this->db->order_by('bebas_pay_last_update', 'asc');
        }

        $this->db->group_by('account.account_id');
        
        $this->db->where('majors_status', '1');
        
        $this->db->select('account.account_id, account.account_code, account.account_description, sum(bebas_pay_bill) as total_bebas_pay_bill, kas.kas_account_id');
        
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('users', 'users.user_id = bebas_pay.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bebas_pay.bebas_pay_noref');
        $this->db->join('account', 'account.account_id = pos.account_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

        $res = $this->db->get('bebas_pay');

        if(isset($params['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }
    
    function get_rekap_bebas_last_kas($param = array())
    {
        if(isset($param['id']))
        {
            $this->db->where('bebas_pay.bebas_pay_id', $param['id']);
        }

        if(isset($param['student_id']))
        {
            $this->db->where('bebas.student_student_id', $param['student_id']);
        }
        
        if(isset($param['period_id']))
        {
            $this->db->where('payment.period_period_id', $param['period_id']);
        }

        if(isset($param['student_nis']))
        {
            $this->db->where('student.student_nis', $param['student_nis']);
        }  

        if (isset($param['date'])) {
            $this->db->where('bebas_pay_input_date', $param['date']);
        }      

        if(isset($param['payment_id']))
        {
            $this->db->where('bebas.payment_payment_id', $param['payment_id']);
        }

        if(isset($param['bebas_id']))
        {
            $this->db->where('bebas_pay.bebas_bebas_id', $param['bebas_id']);
        }

        if(isset($param['class_id']))
        {
            $this->db->where('student.class_class_id', $param['class_id']);
        }

        if(isset($param['bebas_pay_input_date']))
        {
            $this->db->where('bebas_pay_input_date', $param['bebas_pay_input_date']);
        }

        if(isset($param['bebas_pay_last_update']))
        {
            $this->db->where('bebas_pay_last_update', $param['bebas_pay_last_update']);
        }
        
        if(isset($param['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $param['account_majors_id']);             
            $this->db->like('acc.account_description', 'Tunai');
            $this->db->like('bebas_pay_noref', 'SP', 'after');
        }
            
        if(isset($param['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Tunai');
		    $this->db->like('bebas_pay_noref', 'SP', 'after');
		}
        
        if(isset($param['date_start']) AND isset($param['date_end']))
        {
            $this->db->where('bebas_pay_input_date >=', $param['date_start'] . ' 00:00:00');
            $this->db->where('bebas_pay_input_date <=', $param['date_end'] . ' 23:59:59');
        }

        if(isset($param['date']))
        {
            $this->db->where('bebas_pay_input_date', $param['date']);
        }

        if(isset($param['group']))
        {

        $this->db->group_by('bebas_pay.bebas_bebas_id'); 

        }

        if(isset($param['limit']))
        {
            if(!isset($param['offset']))
            {
                $param['offset'] = NULL;
            }

            $this->db->limit($param['limit'], $param['offset']);
        }

        if(isset($param['order_by']))
        {
            $this->db->order_by($param['order_by'], 'desc');
        }
        else
        {
            $this->db->order_by('bebas_pay_last_update', 'asc');
        }

        $this->db->group_by('account.account_id');
        
        $this->db->where('majors_status', '1');
        
        $this->db->select('account.account_id, account.account_code, account.account_description, sum(bebas_pay_bill) as total_bebas_pay_bill, kas.kas_account_id');
        
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('users', 'users.user_id = bebas_pay.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bebas_pay.bebas_pay_noref');
        $this->db->join('account', 'account.account_id = pos.account_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

        $res = $this->db->get('bebas_pay');

        if(isset($param['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }
    
    function get_rekap_kredit_kas($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kredit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kredit_date', $params['date']);
		}

		if (isset($params['kredit_desc'])) {
			$this->db->like('kredit_desc', $params['kredit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $params['account_majors_id']);             
            $this->db->like('acc.account_description', 'Tunai');
            $this->db->like('kas_noref', 'JK', 'after');
        }
            
        if(isset($params['kas_noref']))
		{             
		    $this->db->like('acc.account_description', 'Tunai');
		    $this->db->like('kas_noref', 'JK', 'after');
		}

		if(isset($params['kredit_input_date']))
		{
			$this->db->where('kredit_input_date', $params['kredit_input_date']);
		}

		if(isset($params['kredit_last_update']))
		{
			$this->db->where('kredit_last_update', $params['kredit_last_update']);
		}
		
		if(isset($params['date_start']) AND isset($params['date_end']))
		{
			$this->db->where('kredit_date >=', $params['date_start'] . ' 00:00:00');
			$this->db->where('kredit_date <=', $params['date_end'] . ' 23:59:59');
		}
		
		if (isset($params['period_id'])) {
			
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}
		
		if(isset($params['urutan']))
		{
			$this->db->order_by('kredit_date', 'asc');
		}
		
		if(isset($params['order_by']))
		{
			$this->db->order_by($params['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('kredit_id', 'desc');
		}
		
		$this->db->group_by('account.account_id');

        $this->db->where('majors_status', '1');
        
		$this->db->select('account.account_id, account.account_code, account.account_description, SUM(kredit_value) as total_kredit_value, kas.kas_account_id');

		$this->db->join('kas', 'kas.kas_noref = kredit.kredit_kas_noref', 'left');
		$this->db->join('users', 'users.user_id = kredit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = kredit.kredit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

		$res = $this->db->get('kredit');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
	
	function get_rekap_gaji_kas($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kredit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kredit_date', $params['date']);
		}

		if (isset($params['kredit_desc'])) {
			$this->db->like('kredit_desc', $params['kredit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $params['account_majors_id']);             
            $this->db->like('acc.account_description', 'Tunai');
            $this->db->like('kas_noref', 'GK', 'after');
        }
            
        if(isset($params['kas_noref']))
		{             
		    $this->db->like('acc.account_description', 'Tunai');
		    $this->db->like('kas_noref', 'GK', 'after');
		}

		if(isset($params['kredit_input_date']))
		{
			$this->db->where('kredit_input_date', $params['kredit_input_date']);
		}

		if(isset($params['kredit_last_update']))
		{
			$this->db->where('kredit_last_update', $params['kredit_last_update']);
		}
		
		if(isset($params['date_start']) AND isset($params['date_end']))
		{
			$this->db->where('kredit_date >=', $params['date_start'] . ' 00:00:00');
			$this->db->where('kredit_date <=', $params['date_end'] . ' 23:59:59');
		}
		
		if (isset($params['period_id'])) {
			
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}
		
		if(isset($params['urutan']))
		{
			$this->db->order_by('kredit_date', 'asc');
		}
		
		if(isset($params['order_by']))
		{
			$this->db->order_by($params['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('kredit_id', 'desc');
		}
		
		$this->db->group_by('account.account_id');

        $this->db->where('majors_status', '1');
        
		$this->db->select('account.account_id, account.account_code, account.account_description, SUM(kredit_value) as total_kredit_value, kas.kas_account_id');

		$this->db->join('kas', 'kas.kas_noref = kredit.kredit_kas_noref', 'left');
		$this->db->join('users', 'users.user_id = kredit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = kredit.kredit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

		$res = $this->db->get('kredit');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
	
	function get_rekap_kredit_last_kas($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('kredit_id', $param['id']);
		}

		if (isset($param['date'])) {
			$this->db->where('kredit_date', $param['date']);
		}

		if (isset($param['kredit_desc'])) {
			$this->db->like('kredit_desc', $param['kredit_desc']);
		}
        
        if(isset($param['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $param['account_majors_id']);             
            $this->db->like('acc.account_description', 'Tunai');
            $this->db->like('kas_noref', 'JK', 'after');
        }
            
        if(isset($param['kas_noref']))
		{             
		    $this->db->like('acc.account_description', 'Tunai');
		    $this->db->like('kas_noref', 'JK', 'after');
		}

		if(isset($param['kredit_input_date']))
		{
			$this->db->where('kredit_input_date', $param['kredit_input_date']);
		}

		if(isset($param['kredit_last_update']))
		{
			$this->db->where('kredit_last_update', $param['kredit_last_update']);
		}
		
		if(isset($param['date_start']) AND isset($param['date_end']))
		{
			$this->db->where('kredit_date >=', $param['date_start'] . ' 00:00:00');
			$this->db->where('kredit_date <=', $param['date_end'] . ' 23:59:59');
		}
		
		if (isset($param['period_id'])) {
			
		}

		if(isset($param['limit']))
		{
			if(!isset($param['offset']))
			{
				$param['offset'] = NULL;
			}

			$this->db->limit($param['limit'], $param['offset']);
		}
		if(isset($param['order_by']))
		{
			$this->db->order_by($param['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('kredit_id', 'desc');
		}
		
		$this->db->group_by('account.account_id');

        $this->db->where('majors_status', '1');
        
		$this->db->select('account.account_id, account.account_code, account.account_description, SUM(kredit_value) as total_kredit_value');

		$this->db->join('kas', 'kas.kas_noref = kredit.kredit_kas_noref', 'left');
		$this->db->join('users', 'users.user_id = kredit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = kredit.kredit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

		$res = $this->db->get('kredit');

		if(isset($param['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
	
	function get_rekap_gaji_last_kas($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('kredit_id', $param['id']);
		}

		if (isset($param['date'])) {
			$this->db->where('kredit_date', $param['date']);
		}

		if (isset($param['kredit_desc'])) {
			$this->db->like('kredit_desc', $param['kredit_desc']);
		}
        
        if(isset($param['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $param['account_majors_id']);             
            $this->db->like('acc.account_description', 'Tunai');
            $this->db->like('kas_noref', 'GK', 'after');
        }
            
        if(isset($param['kas_noref']))
		{             
		    $this->db->like('acc.account_description', 'Tunai');
		    $this->db->like('kas_noref', 'GK', 'after');
		}

		if(isset($param['kredit_input_date']))
		{
			$this->db->where('kredit_input_date', $param['kredit_input_date']);
		}

		if(isset($param['kredit_last_update']))
		{
			$this->db->where('kredit_last_update', $param['kredit_last_update']);
		}
		
		if(isset($param['date_start']) AND isset($param['date_end']))
		{
			$this->db->where('kredit_date >=', $param['date_start'] . ' 00:00:00');
			$this->db->where('kredit_date <=', $param['date_end'] . ' 23:59:59');
		}
		
		if (isset($param['period_id'])) {
			
		}

		if(isset($param['limit']))
		{
			if(!isset($param['offset']))
			{
				$param['offset'] = NULL;
			}

			$this->db->limit($param['limit'], $param['offset']);
		}
		if(isset($param['order_by']))
		{
			$this->db->order_by($param['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('kredit_id', 'desc');
		}
		
		$this->db->group_by('account.account_id');

        $this->db->where('majors_status', '1');
        
		$this->db->select('account.account_id, account.account_code, account.account_description, SUM(kredit_value) as total_kredit_value, kas.kas_account_id');

		$this->db->join('kas', 'kas.kas_noref = kredit.kredit_kas_noref', 'left');
		$this->db->join('users', 'users.user_id = kredit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = kredit.kredit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

		$res = $this->db->get('kredit');

		if(isset($param['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
	
	function get_rekap_debit_kas($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('debit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('debit_date', $params['date']);
		}

		if (isset($params['debit_desc'])) {
			$this->db->like('debit_desc', $params['debit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $params['account_majors_id']);             
            $this->db->like('acc.account_description', 'Tunai');
            $this->db->like('kas_noref', 'JM', 'after');
        }
            
        if(isset($params['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Tunai');
		    $this->db->like('kas_noref', 'JM', 'after');
		}

		if(isset($params['debit_input_date']))
		{
			$this->db->where('debit_input_date', $params['debit_input_date']);
		}

		if(isset($params['debit_last_update']))
		{
			$this->db->where('debit_last_update', $params['debit_last_update']);
		}
		
		if(isset($params['date_start']) AND isset($params['date_end']))
		{
			$this->db->where('debit_date >=', $params['date_start'] . ' 00:00:00');
			$this->db->where('debit_date <=', $params['date_end'] . ' 23:59:59');
		}
		
		if (isset($params['period_id'])) {
			
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}
		
		
		if(isset($params['urutan']))
		{
			$this->db->order_by('debit_date', 'asc');
		}
		
		if(isset($params['order_by']))
		{
			$this->db->order_by($params['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('debit_id', 'desc');
		}
		
		$this->db->group_by('account.account_id');
        
        $this->db->where('majors_status', '1');
        
		$this->db->select('account.account_id, account.account_code, account.account_description, SUM(debit_value) as total_debit_value, kas.kas_account_id');

		$this->db->join('kas', 'kas.kas_noref = debit.debit_kas_noref', 'left');
		$this->db->join('users', 'users.user_id = debit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = debit.debit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

		$res = $this->db->get('debit');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
	
	function get_rekap_debit_last_kas($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('debit_id', $param['id']);
		}

		if (isset($param['date'])) {
			$this->db->where('debit_date', $param['date']);
		}

		if (isset($param['debit_desc'])) {
			$this->db->like('debit_desc', $param['debit_desc']);
		}
        
        if(isset($param['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $param['account_majors_id']);             
            $this->db->like('acc.account_description', 'Tunai');
            $this->db->like('kas_noref', 'JM', 'after');
        }
            
        if(isset($param['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Tunai');
		    $this->db->like('kas_noref', 'JM', 'after');
		}

		if(isset($param['debit_input_date']))
		{
			$this->db->where('debit_input_date', $param['debit_input_date']);
		}

		if(isset($param['debit_last_update']))
		{
			$this->db->where('debit_last_update', $param['debit_last_update']);
		}
		
		if(isset($param['date_start']) AND isset($param['date_end']))
		{
			$this->db->where('debit_date >=', $param['date_start'] . ' 00:00:00');
			$this->db->where('debit_date <=', $param['date_end'] . ' 23:59:59');
		}
		
		if (isset($param['period_id'])) {
			
		}

		if(isset($param['limit']))
		{
			if(!isset($param['offset']))
			{
				$param['offset'] = NULL;
			}

			$this->db->limit($param['limit'], $param['offset']);
		}
		if(isset($param['order_by']))
		{
			$this->db->order_by($param['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('debit_id', 'desc');
		}
		
		$this->db->group_by('account.account_id');
        
        $this->db->where('majors_status', '1');
        
		$this->db->select('account.account_id, account.account_code, account.account_description, SUM(debit_value) as total_debit_value, kas.kas_account_id');

		$this->db->join('kas', 'kas.kas_noref = debit.debit_kas_noref', 'left');
		$this->db->join('users', 'users.user_id = debit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = debit.debit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

		$res = $this->db->get('debit');

		if(isset($param['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
	
	function get_rekap_bulan_bank($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('bulan.bulan_id', $params['id']);
        }

        if(isset($params['student_id']))
        {
            $this->db->where('bulan.student_student_id', $params['student_id']);
        }

        if (isset($params['multiple_id'])) {
            $this->db->where_in('bulan.bulan_id', $params['multiple_id']);
        }

        if (isset($params['date'])) {
            $this->db->where('bulan_date_pay', $params['date']);
        }

        if(isset($params['student_nis']))
        {
            $this->db->where('student_nis', $params['student_nis']);
        }

        if(isset($params['bulan_bill']))
        {
            $this->db->where('bulan_bill', $params['bulan_bill']);
        }

        if(isset($params['payment_id']))
        {
            $this->db->where('bulan.payment_payment_id', $params['payment_id']);
        }

        if(isset($params['month_id']))
        {
            $this->db->where('bulan.month_month_id', $params['month_id']);
        }

        if(isset($params['class_id']))
        {
            $this->db->where('student.class_class_id', $params['class_id']);
        }
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $params['account_majors_id']);             
            $this->db->like('acc.account_description', 'Bank');
            $this->db->like('kas_noref', 'SP', 'after');
        }
            
        if(isset($params['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Bank');
		    $this->db->like('kas_noref', 'SP', 'after');
		}

        if(isset($params['period_id']))
        {
            $this->db->where('payment.period_period_id', $params['period_id']);
        }

        if(isset($params['status']))
        {
            $this->db->where('bulan.bulan_status', $params['status']);
        }

        if(isset($params['period_status']))
        {
            $this->db->where('period_status', $params['period_status']);
        }

        if(isset($params['bulan_input_date']))
        {
            $this->db->where('bulan_input_date', $params['bulan_input_date']);
        }

        if(isset($params['bulan_last_update']))
        {
            $this->db->where('bulan_last_update', $params['bulan_last_update']);
        }
        
        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('bulan_date_pay >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('bulan_date_pay <=', $params['date_end'] . ' 23:59:59');
        }
        
        if(isset($params['month_start']) AND isset($params['month_end'])){
            $this->db->where('month_month_id >=', $params['month_start']);
            $this->db->where('month_month_id <=', $params['month_end']);
        }
        
        if(isset($params['date']))
        {
            $this->db->where('bulan_date_pay', $params['date']);
        }

        if(isset($params['group']))
        {

        $this->db->group_by('bulan.student_student_id'); 

        }

        if(isset($params['grup']))
        {

        $this->db->group_by('bulan.month_month_id'); 

        }

        if(isset($params['paymentt']))
        {

        $this->db->group_by('bulan.payment_payment_id'); 

        }

        if(isset($params['limit']))
        {
            if(!isset($params['offset']))
            {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }
        
        $this->db->distinct();
        
        $this->db->order_by('payment_payment_id');
        
        if(isset($params['urutan'])) {
            
        $this->db->order_by('bulan_date_pay', 'asc');
            
        } else {
        
        $this->db->order_by('month_month_id', 'asc');
            
        }
        
        $this->db->group_by('account.account_id');
        
        $this->db->where('majors_status', '1');

        $this->db->select('account.account_id, account.account_code, account.account_description, sum(bulan.bulan_bill) as total_bulan_bill, kas.kas_account_id');
        
        $this->db->join('month', 'month.month_id = bulan.month_month_id', 'left');

        $this->db->join('student', 'student.student_id = bulan.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bulan.payment_payment_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');

        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
        $this->db->join('users', 'users.user_id = bulan.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bulan.bulan_noref');
        $this->db->join('account', 'account.account_id = pos.account_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        
        $res = $this->db->get('bulan');

        if(isset($params['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }
    
    function get_rekap_bulan_last_bank($param = array())
    {
        if(isset($param['id']))
        {
            $this->db->where('bulan.bulan_id', $param['id']);
        }

        if(isset($param['student_id']))
        {
            $this->db->where('bulan.student_student_id', $param['student_id']);
        }

        if (isset($param['multiple_id'])) {
            $this->db->where_in('bulan.bulan_id', $param['multiple_id']);
        }

        if (isset($param['date'])) {
            $this->db->where('bulan_date_pay', $param['date']);
        }

        if(isset($param['student_nis']))
        {
            $this->db->where('student_nis', $param['student_nis']);
        }

        if(isset($param['bulan_bill']))
        {
            $this->db->where('bulan_bill', $param['bulan_bill']);
        }

        if(isset($param['payment_id']))
        {
            $this->db->where('bulan.payment_payment_id', $param['payment_id']);
        }

        if(isset($param['month_id']))
        {
            $this->db->where('bulan.month_month_id', $param['month_id']);
        }

        if(isset($param['class_id']))
        {
            $this->db->where('student.class_class_id', $param['class_id']);
        }
        
        if(isset($param['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $param['account_majors_id']);             
            $this->db->like('acc.account_description', 'Bank');
            $this->db->like('kas_noref', 'SP', 'after');
        }
            
        if(isset($param['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Bank');
		    $this->db->like('kas_noref', 'SP', 'after');
		}

        if(isset($param['period_id']))
        {
            $this->db->where('payment.period_period_id', $param['period_id']);
        }

        if(isset($param['status']))
        {
            $this->db->where('bulan.bulan_status', $param['status']);
        }

        if(isset($param['period_status']))
        {
            $this->db->where('period_status', $param['period_status']);
        }

        if(isset($param['bulan_input_date']))
        {
            $this->db->where('bulan_input_date', $param['bulan_input_date']);
        }

        if(isset($param['bulan_last_update']))
        {
            $this->db->where('bulan_last_update', $param['bulan_last_update']);
        }
        
        if(isset($param['date_start']) AND isset($param['date_end']))
        {
            $this->db->where('bulan_date_pay >=', $param['date_start'] . ' 00:00:00');
            $this->db->where('bulan_date_pay <=', $param['date_end'] . ' 23:59:59');
        }
        
        if(isset($param['month_start']) AND isset($param['month_end'])){
            $this->db->where('month_month_id >=', $param['month_start']);
            $this->db->where('month_month_id <=', $param['month_end']);
        }
        
        if(isset($param['date']))
        {
            $this->db->where('bulan_date_pay', $param['date']);
        }

        if(isset($param['group']))
        {

        $this->db->group_by('bulan.student_student_id'); 

        }

        if(isset($param['grup']))
        {

        $this->db->group_by('bulan.month_month_id'); 

        }

        if(isset($param['paymentt']))
        {

        $this->db->group_by('bulan.payment_payment_id'); 

        }

        if(isset($param['limit']))
        {
            if(!isset($param['offset']))
            {
                $param['offset'] = NULL;
            }

            $this->db->limit($param['limit'], $param['offset']);
        }
        
        $this->db->distinct();
        
        $this->db->order_by('payment_payment_id');

        $this->db->order_by('month_month_id', 'asc');

        $this->db->group_by('account.account_id');
        
        $this->db->where('majors_status', '1');

        $this->db->select('account.account_id, account.account_code, account.account_description, sum(bulan.bulan_bill) as total_bulan_bill, kas.kas_account_id');
        
        $this->db->join('month', 'month.month_id = bulan.month_month_id', 'left');$this->db->join('student', 'student.student_id = bulan.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bulan.payment_payment_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');

        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
        $this->db->join('users', 'users.user_id = bulan.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bulan.bulan_noref');
        $this->db->join('account', 'account.account_id = pos.account_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        
        $res = $this->db->get('bulan');

        if(isset($param['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }
    
    function get_rekap_bebas_bank($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('bebas_pay.bebas_pay_id', $params['id']);
        }

        if(isset($params['student_id']))
        {
            $this->db->where('bebas.student_student_id', $params['student_id']);
        }
        
        if(isset($params['period_id']))
        {
            $this->db->where('payment.period_period_id', $params['period_id']);
        }

        if(isset($params['student_nis']))
        {
            $this->db->where('student.student_nis', $params['student_nis']);
        }  

        if (isset($params['date'])) {
            $this->db->where('bebas_pay_input_date', $params['date']);
        }      

        if(isset($params['payment_id']))
        {
            $this->db->where('bebas.payment_payment_id', $params['payment_id']);
        }

        if(isset($params['bebas_id']))
        {
            $this->db->where('bebas_pay.bebas_bebas_id', $params['bebas_id']);
        }

        if(isset($params['class_id']))
        {
            $this->db->where('student.class_class_id', $params['class_id']);
        }

        if(isset($params['bebas_pay_input_date']))
        {
            $this->db->where('bebas_pay_input_date', $params['bebas_pay_input_date']);
        }

        if(isset($params['bebas_pay_last_update']))
        {
            $this->db->where('bebas_pay_last_update', $params['bebas_pay_last_update']);
        }
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $params['account_majors_id']);             
            $this->db->like('acc.account_description', 'Bank');
            $this->db->like('kas_noref', 'SP', 'after');
        }
            
        if(isset($params['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Bank');
		    $this->db->like('kas_noref', 'SP', 'after');
		}
        
        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('bebas_pay_input_date >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('bebas_pay_input_date <=', $params['date_end'] . ' 23:59:59');
        }

        if(isset($params['date']))
        {
            $this->db->where('bebas_pay_input_date', $params['date']);
        }

        if(isset($params['group']))
        {

        $this->db->group_by('bebas_pay.bebas_bebas_id'); 

        }

        if(isset($params['limit']))
        {
            if(!isset($params['offset']))
            {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if(isset($params['order_by']))
        {
            $this->db->order_by($params['order_by'], 'desc');
        }
        else
        {
            $this->db->order_by('bebas_pay_last_update', 'asc');
        }

        $this->db->group_by('account.account_id');
        
        $this->db->where('majors_status', '1');
        
        $this->db->select('account.account_id, account.account_code, account.account_description, sum(bebas_pay_bill) as total_bebas_pay_bill, kas.kas_account_id');
        
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('users', 'users.user_id = bebas_pay.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bebas_pay.bebas_pay_noref');
        $this->db->join('account', 'account.account_id = pos.account_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

        $res = $this->db->get('bebas_pay');

        if(isset($params['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }
    
    function get_rekap_bebas_last_bank($param = array())
    {
        if(isset($param['id']))
        {
            $this->db->where('bebas_pay.bebas_pay_id', $param['id']);
        }

        if(isset($param['student_id']))
        {
            $this->db->where('bebas.student_student_id', $param['student_id']);
        }
        
        if(isset($param['period_id']))
        {
            $this->db->where('payment.period_period_id', $param['period_id']);
        }

        if(isset($param['student_nis']))
        {
            $this->db->where('student.student_nis', $param['student_nis']);
        }  

        if (isset($param['date'])) {
            $this->db->where('bebas_pay_input_date', $param['date']);
        }      

        if(isset($param['payment_id']))
        {
            $this->db->where('bebas.payment_payment_id', $param['payment_id']);
        }

        if(isset($param['bebas_id']))
        {
            $this->db->where('bebas_pay.bebas_bebas_id', $param['bebas_id']);
        }

        if(isset($param['class_id']))
        {
            $this->db->where('student.class_class_id', $param['class_id']);
        }

        if(isset($param['bebas_pay_input_date']))
        {
            $this->db->where('bebas_pay_input_date', $param['bebas_pay_input_date']);
        }

        if(isset($param['bebas_pay_last_update']))
        {
            $this->db->where('bebas_pay_last_update', $param['bebas_pay_last_update']);
        }
        
        if(isset($param['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $param['account_majors_id']);             
            $this->db->like('acc.account_description', 'Bank');
            $this->db->like('kas_noref', 'SP', 'after');
        }
            
        if(isset($param['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Bank');
		    $this->db->like('kas_noref', 'SP', 'after');
		}
        
        if(isset($param['date_start']) AND isset($param['date_end']))
        {
            $this->db->where('bebas_pay_input_date >=', $param['date_start'] . ' 00:00:00');
            $this->db->where('bebas_pay_input_date <=', $param['date_end'] . ' 23:59:59');
        }

        if(isset($param['date']))
        {
            $this->db->where('bebas_pay_input_date', $param['date']);
        }

        if(isset($param['group']))
        {

        $this->db->group_by('bebas_pay.bebas_bebas_id'); 

        }

        if(isset($param['limit']))
        {
            if(!isset($param['offset']))
            {
                $param['offset'] = NULL;
            }

            $this->db->limit($param['limit'], $param['offset']);
        }

        if(isset($param['order_by']))
        {
            $this->db->order_by($param['order_by'], 'desc');
        }
        else
        {
            $this->db->order_by('bebas_pay_last_update', 'asc');
        }

        $this->db->group_by('account.account_id');
        
        $this->db->where('majors_status', '1');
        
        $this->db->select('account.account_id, account.account_code, account.account_description, sum(bebas_pay_bill) as total_bebas_pay_bill, kas.kas_account_id');
        
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('users', 'users.user_id = bebas_pay.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bebas_pay.bebas_pay_noref');
        $this->db->join('account', 'account.account_id = pos.account_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

        $res = $this->db->get('bebas_pay');

        if(isset($param['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }
    
    function get_rekap_kredit_bank($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kredit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kredit_date', $params['date']);
		}

		if (isset($params['kredit_desc'])) {
			$this->db->like('kredit_desc', $params['kredit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $params['account_majors_id']);             
            $this->db->like('acc.account_description', 'Bank');
            $this->db->like('kas_noref', 'JK', 'after');
        }
            
        if(isset($params['kas_noref']))
		{             
		    $this->db->like('acc.account_description', 'Bank');
		    $this->db->like('kas_noref', 'JK', 'after');
		}

		if(isset($params['kredit_input_date']))
		{
			$this->db->where('kredit_input_date', $params['kredit_input_date']);
		}

		if(isset($params['kredit_last_update']))
		{
			$this->db->where('kredit_last_update', $params['kredit_last_update']);
		}
		
		if(isset($params['date_start']) AND isset($params['date_end']))
		{
			$this->db->where('kredit_date >=', $params['date_start'] . ' 00:00:00');
			$this->db->where('kredit_date <=', $params['date_end'] . ' 23:59:59');
		}
		
		if (isset($params['period_id'])) {
			
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}
		
		if(isset($params['urutan']))
		{
			$this->db->order_by('kredit_date', 'asc');
		}
		
		if(isset($params['order_by']))
		{
			$this->db->order_by($params['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('kredit_id', 'desc');
		}
		
		$this->db->group_by('account.account_id');

        $this->db->where('majors_status', '1');
        
		$this->db->select('account.account_id, account.account_code, account.account_description, SUM(kredit_value) as total_kredit_value, kas.kas_account_id');

		$this->db->join('kas', 'kas.kas_noref = kredit.kredit_kas_noref', 'left');
		$this->db->join('users', 'users.user_id = kredit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = kredit.kredit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

		$res = $this->db->get('kredit');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
	
	function get_rekap_gaji_bank($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kredit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kredit_date', $params['date']);
		}

		if (isset($params['kredit_desc'])) {
			$this->db->like('kredit_desc', $params['kredit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $params['account_majors_id']);             
            $this->db->like('acc.account_description', 'Bank');
            $this->db->like('kas_noref', 'GK', 'after');
        }
            
        if(isset($params['kas_noref']))
		{             
		    $this->db->like('acc.account_description', 'Bank');
		    $this->db->like('kas_noref', 'GK', 'after');
		}

		if(isset($params['kredit_input_date']))
		{
			$this->db->where('kredit_input_date', $params['kredit_input_date']);
		}

		if(isset($params['kredit_last_update']))
		{
			$this->db->where('kredit_last_update', $params['kredit_last_update']);
		}
		
		if(isset($params['date_start']) AND isset($params['date_end']))
		{
			$this->db->where('kredit_date >=', $params['date_start'] . ' 00:00:00');
			$this->db->where('kredit_date <=', $params['date_end'] . ' 23:59:59');
		}
		
		if (isset($params['period_id'])) {
			
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}
		
		if(isset($params['urutan']))
		{
			$this->db->order_by('kredit_date', 'asc');
		}
		
		if(isset($params['order_by']))
		{
			$this->db->order_by($params['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('kredit_id', 'desc');
		}
		
		$this->db->group_by('account.account_id');

        $this->db->where('majors_status', '1');
        
		$this->db->select('account.account_id, account.account_code, account.account_description, SUM(kredit_value) as total_kredit_value, kas.kas_account_id');

		$this->db->join('kas', 'kas.kas_noref = kredit.kredit_kas_noref', 'left');
		$this->db->join('users', 'users.user_id = kredit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = kredit.kredit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

		$res = $this->db->get('kredit');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
	
	function get_rekap_kredit_last_bank($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('kredit_id', $param['id']);
		}

		if (isset($param['date'])) {
			$this->db->where('kredit_date', $param['date']);
		}

		if (isset($param['kredit_desc'])) {
			$this->db->like('kredit_desc', $param['kredit_desc']);
		}
        
        if(isset($param['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $param['account_majors_id']);             
            $this->db->like('acc.account_description', 'Bank');
            $this->db->like('kas_noref', 'JK', 'after');
        }
            
        if(isset($param['kas_noref']))
		{             
		    $this->db->like('acc.account_description', 'Bank');
		    $this->db->like('kas_noref', 'JK', 'after');
		}

		if(isset($param['kredit_input_date']))
		{
			$this->db->where('kredit_input_date', $param['kredit_input_date']);
		}

		if(isset($param['kredit_last_update']))
		{
			$this->db->where('kredit_last_update', $param['kredit_last_update']);
		}
		
		if(isset($param['date_start']) AND isset($param['date_end']))
		{
			$this->db->where('kredit_date >=', $param['date_start'] . ' 00:00:00');
			$this->db->where('kredit_date <=', $param['date_end'] . ' 23:59:59');
		}
		
		if (isset($param['period_id'])) {
			
		}

		if(isset($param['limit']))
		{
			if(!isset($param['offset']))
			{
				$param['offset'] = NULL;
			}

			$this->db->limit($param['limit'], $param['offset']);
		}
		if(isset($param['order_by']))
		{
			$this->db->order_by($param['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('kredit_id', 'desc');
		}
		
		$this->db->group_by('account.account_id');

        $this->db->where('majors_status', '1');
        
		$this->db->select('account.account_id, account.account_code, account.account_description, SUM(kredit_value) as total_kredit_value, kas.kas_account_id, kas.kas_account_id');

		$this->db->join('kas', 'kas.kas_noref = kredit.kredit_kas_noref', 'left');
		$this->db->join('users', 'users.user_id = kredit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = kredit.kredit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

		$res = $this->db->get('kredit');

		if(isset($param['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
	
	function get_rekap_gaji_last_bank($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('kredit_id', $param['id']);
		}

		if (isset($param['date'])) {
			$this->db->where('kredit_date', $param['date']);
		}

		if (isset($param['kredit_desc'])) {
			$this->db->like('kredit_desc', $param['kredit_desc']);
		}
        
        if(isset($param['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $param['account_majors_id']);             
            $this->db->like('acc.account_description', 'Bank');
            $this->db->like('kas_noref', 'GK', 'after');
        }
            
        if(isset($param['kas_noref']))
		{             
		    $this->db->like('acc.account_description', 'Bank');
		    $this->db->like('kas_noref', 'GK', 'after');
		}

		if(isset($param['kredit_input_date']))
		{
			$this->db->where('kredit_input_date', $param['kredit_input_date']);
		}

		if(isset($param['kredit_last_update']))
		{
			$this->db->where('kredit_last_update', $param['kredit_last_update']);
		}
		
		if(isset($param['date_start']) AND isset($param['date_end']))
		{
			$this->db->where('kredit_date >=', $param['date_start'] . ' 00:00:00');
			$this->db->where('kredit_date <=', $param['date_end'] . ' 23:59:59');
		}
		
		if (isset($param['period_id'])) {
			
		}

		if(isset($param['limit']))
		{
			if(!isset($param['offset']))
			{
				$param['offset'] = NULL;
			}

			$this->db->limit($param['limit'], $param['offset']);
		}
		if(isset($param['order_by']))
		{
			$this->db->order_by($param['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('kredit_id', 'desc');
		}
		
		$this->db->group_by('account.account_id');

        $this->db->where('majors_status', '1');
        
		$this->db->select('account.account_id, account.account_code, account.account_description, SUM(kredit_value) as total_kredit_value, kas.kas_account_id');

		$this->db->join('kas', 'kas.kas_noref = kredit.kredit_kas_noref', 'left');
		$this->db->join('users', 'users.user_id = kredit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = kredit.kredit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

		$res = $this->db->get('kredit');

		if(isset($param['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
	
	function get_rekap_debit_bank($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('debit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('debit_date', $params['date']);
		}

		if (isset($params['debit_desc'])) {
			$this->db->like('debit_desc', $params['debit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $params['account_majors_id']);             
            $this->db->like('acc.account_description', 'Bank');
            $this->db->like('kas_noref', 'JM', 'after');
        }
            
        if(isset($params['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Bank');
		    $this->db->like('kas_noref', 'JM', 'after');
		}

		if(isset($params['debit_input_date']))
		{
			$this->db->where('debit_input_date', $params['debit_input_date']);
		}

		if(isset($params['debit_last_update']))
		{
			$this->db->where('debit_last_update', $params['debit_last_update']);
		}
		
		if(isset($params['date_start']) AND isset($params['date_end']))
		{
			$this->db->where('debit_date >=', $params['date_start'] . ' 00:00:00');
			$this->db->where('debit_date <=', $params['date_end'] . ' 23:59:59');
		}
		
		if (isset($params['period_id'])) {
			
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}
		
		
		if(isset($params['urutan']))
		{
			$this->db->order_by('debit_date', 'asc');
		}
		
		if(isset($params['order_by']))
		{
			$this->db->order_by($params['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('debit_id', 'desc');
		}
		
		$this->db->group_by('account.account_id');
        
        $this->db->where('majors_status', '1');
        
		$this->db->select('account.account_id, account.account_code, account.account_description, SUM(debit_value) as total_debit_value, kas.kas_account_id');

		$this->db->join('kas', 'kas.kas_noref = debit.debit_kas_noref', 'left');
		$this->db->join('users', 'users.user_id = debit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = debit.debit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

		$res = $this->db->get('debit');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
	
	function get_rekap_debit_last_bank($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('debit_id', $param['id']);
		}

		if (isset($param['date'])) {
			$this->db->where('debit_date', $param['date']);
		}

		if (isset($param['debit_desc'])) {
			$this->db->like('debit_desc', $param['debit_desc']);
		}
        
        if(isset($param['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $param['account_majors_id']);             
            $this->db->like('acc.account_description', 'Bank');
            $this->db->like('kas_noref', 'JM', 'after');
        }
            
        if(isset($param['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Bank');
		    $this->db->like('kas_noref', 'JM', 'after');
		}

		if(isset($param['debit_input_date']))
		{
			$this->db->where('debit_input_date', $param['debit_input_date']);
		}

		if(isset($param['debit_last_update']))
		{
			$this->db->where('debit_last_update', $param['debit_last_update']);
		}
		
		if(isset($param['date_start']) AND isset($param['date_end']))
		{
			$this->db->where('debit_date >=', $param['date_start'] . ' 00:00:00');
			$this->db->where('debit_date <=', $param['date_end'] . ' 23:59:59');
		}
		
		if (isset($param['period_id'])) {
			
		}

		if(isset($param['limit']))
		{
			if(!isset($param['offset']))
			{
				$param['offset'] = NULL;
			}

			$this->db->limit($param['limit'], $param['offset']);
		}
		if(isset($param['order_by']))
		{
			$this->db->order_by($param['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('debit_id', 'desc');
		}
		
		$this->db->group_by('account.account_id');
        
        $this->db->where('majors_status', '1');
        
		$this->db->select('account.account_id, account.account_code, account.account_description, SUM(debit_value) as total_debit_value, kas.kas_account_id');

		$this->db->join('kas', 'kas.kas_noref = debit.debit_kas_noref', 'left');
		$this->db->join('users', 'users.user_id = debit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = debit.debit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

		$res = $this->db->get('debit');

		if(isset($param['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
    
}
