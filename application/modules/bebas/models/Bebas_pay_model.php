<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Bebas_pay_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('bebas_pay.bebas_pay_id', $params['id']);
        }
        
        if(isset($params['noref']))
        {
            $this->db->where('bebas_pay.bebas_pay_noref', $params['noref']);
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
            $this->db->where('account_majors_id', $params['account_majors_id']);
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
            $this->db->order_by('account_id', 'asc');
            $this->db->order_by('bebas_pay_last_update', 'asc');
        }
        
        $this->db->where('majors_status', '1');

        $this->db->select('bebas_pay.bebas_pay_id, bebas_pay_bill, bebas_pay_bill, bebas_pay_number, bebas_pay_desc, bebas_pay_input_date, bebas_pay_last_update');
        $this->db->select('bebas_pay.bebas_bebas_id, bebas_bill');
        // $this->db->select_sum('bebas_pay_bill');
        $this->db->select('student_student_id, student_nis, student.class_class_id, class_name, student_full_name, student_name_of_mother, student_parent_phone');
        $this->db->select('payment_payment_id, payment_type, period_start, period_end, payment.pos_pos_id, pos_name');
        $this->db->select('user_user_id, user_full_name');
        $this->db->select('account_id, account_code');
        
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('users', 'users.user_id = bebas_pay.user_user_id', 'left');
        $this->db->join('account', 'account.account_id = pos.account_account_id', 'left');
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
    
    function get_last($param = array())
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
            $this->db->where('account_majors_id', $param['account_majors_id']);
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
        
        $this->db->where('majors_status', '1');

        $this->db->select('bebas_pay.bebas_pay_id, bebas_pay_bill, bebas_pay_bill, bebas_pay_number, bebas_pay_desc, bebas_pay_input_date, bebas_pay_last_update');
        $this->db->select('bebas_pay.bebas_bebas_id, bebas_bill');
        // $this->db->select_sum('bebas_pay_bill');
        $this->db->select('student_student_id, student_nis, student.class_class_id, class_name, student_full_name, student_name_of_mother, student_parent_phone');
        $this->db->select('payment_payment_id, payment_type, period_start, period_end, payment.pos_pos_id, pos_name');
        $this->db->select('user_user_id, user_full_name');
        $this->db->select('account_id, account_code');
        
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('users', 'users.user_id = bebas_pay.user_user_id', 'left');
        $this->db->join('account', 'account.account_id = pos.account_account_id', 'left');
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
    
    function get_jurnal($params = array())
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
            $this->db->like('bebas_pay_noref', 'SP', 'after');
        }
            
        if(isset($params['kas_noref']))
		{            
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
            $this->db->order_by('account.account_id', 'asc');
            $this->db->order_by('bebas_pay_last_update', 'asc');
        }
        
        $this->db->where('majors_status', '1');

        $this->db->select('bebas_pay.bebas_pay_id, bebas_pay_bill, bebas_pay_bill, bebas_pay_number, bebas_pay_desc, bebas_pay_input_date, bebas_pay_last_update');
        $this->db->select('bebas_pay.bebas_bebas_id, bebas_bill');
        // $this->db->select_sum('bebas_pay_bill');
        $this->db->select('student_student_id, student_nis, student.class_class_id, class_name, student_full_name, student_name_of_mother, student_parent_phone');
        $this->db->select('payment_payment_id, payment_type, period_start, period_end, payment.pos_pos_id, pos_name');
        $this->db->select('user_user_id, user_full_name');
        
        $this->db->select('account.account_id, account.account_code');
        $this->db->select('acc.account_id, acc.account_code, acc.account_description');
        
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('users', 'users.user_id = bebas_pay.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bebas_pay.bebas_pay_noref', 'left');
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
    
    function get_last_jurnal($param = array())
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
            $this->db->like('bebas_pay_noref', 'SP', 'after');
        }
            
        if(isset($param['kas_noref']))
		{            
		    $this->db->like('bebas_pay_noref', 'SP', 'after');
		}
        
        if(isset($param['date_start']) AND isset($param['date_end']))
        {
            $this->db->where('bebas_pay_input_date <', $param['date_start'] . ' 00:00:00');
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
        
        $this->db->where('majors_status', '1');

        $this->db->select('bebas_pay.bebas_pay_id, bebas_pay_bill, bebas_pay_bill, bebas_pay_number, bebas_pay_desc, bebas_pay_input_date, bebas_pay_last_update');
        $this->db->select('bebas_pay.bebas_bebas_id, bebas_bill');
        // $this->db->select_sum('bebas_pay_bill');
        $this->db->select('student_student_id, student_nis, student.class_class_id, class_name, student_full_name, student_name_of_mother, student_parent_phone');
        $this->db->select('payment_payment_id, payment_type, period_start, period_end, payment.pos_pos_id, pos_name');
        $this->db->select('user_user_id, user_full_name');
        
        $this->db->select('account.account_id, account.account_code');
        
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('users', 'users.user_id = bebas_pay.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bebas_pay.bebas_pay_noref', 'left');
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
    
    function get_kas($params = array())
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
            $this->db->order_by('account_id', 'asc');
            $this->db->order_by('bebas_pay_last_update', 'asc');
        }
        
        $this->db->where('majors_status', '1');

        $this->db->select('bebas_pay.bebas_pay_id, bebas_pay_bill, bebas_pay_bill, bebas_pay_number, bebas_pay_desc, bebas_pay_input_date, bebas_pay_last_update');
        $this->db->select('bebas_pay.bebas_bebas_id, bebas_bill');
        // $this->db->select_sum('bebas_pay_bill');
        $this->db->select('student_student_id, student_nis, student.class_class_id, class_name, student_full_name, student_name_of_mother, student_parent_phone');
        $this->db->select('payment_payment_id, payment_type, period_start, period_end, payment.pos_pos_id, pos_name');
        $this->db->select('user_user_id, user_full_name');
        
        $this->db->select('account.account_id, account.account_code');
        
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('users', 'users.user_id = bebas_pay.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bebas_pay.bebas_pay_noref', 'left');
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
    
    function get_last_kas($param = array())
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
        
        $this->db->where('majors_status', '1');

        $this->db->select('bebas_pay.bebas_pay_id, bebas_pay_bill, bebas_pay_bill, bebas_pay_number, bebas_pay_desc, bebas_pay_input_date, bebas_pay_last_update');
        $this->db->select('bebas_pay.bebas_bebas_id, bebas_bill');
        // $this->db->select_sum('bebas_pay_bill');
        $this->db->select('student_student_id, student_nis, student.class_class_id, class_name, student_full_name, student_name_of_mother, student_parent_phone');
        $this->db->select('payment_payment_id, payment_type, period_start, period_end, payment.pos_pos_id, pos_name');
        $this->db->select('user_user_id, user_full_name');
        
        $this->db->select('account.account_id, account.account_code');
        
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('users', 'users.user_id = bebas_pay.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bebas_pay.bebas_pay_noref', 'left');
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
    
    function get_bank($params = array())
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
            $this->db->like('bebas_pay_noref', 'SP', 'after');
        }
            
        if(isset($params['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Bank');
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
            $this->db->order_by('account_id', 'asc');
            $this->db->order_by('bebas_pay_last_update', 'asc');
        }
        
        $this->db->where('majors_status', '1');

        $this->db->select('bebas_pay.bebas_pay_id, bebas_pay_bill, bebas_pay_bill, bebas_pay_number, bebas_pay_desc, bebas_pay_input_date, bebas_pay_last_update');
        $this->db->select('bebas_pay.bebas_bebas_id, bebas_bill');
        // $this->db->select_sum('bebas_pay_bill');
        $this->db->select('student_student_id, student_nis, student.class_class_id, class_name, student_full_name, student_name_of_mother, student_parent_phone');
        $this->db->select('payment_payment_id, payment_type, period_start, period_end, payment.pos_pos_id, pos_name');
        $this->db->select('user_user_id, user_full_name');
        
        $this->db->select('account.account_id, account.account_code');
        
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('users', 'users.user_id = bebas_pay.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bebas_pay.bebas_pay_noref', 'left');
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
    
    function get_last_bank($param = array())
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
            $this->db->like('bebas_pay_noref', 'SP', 'after');
        }
            
        if(isset($param['kas_noref']))
		{            
		    $this->db->like('acc.account_description', 'Bank');
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
        
        $this->db->where('majors_status', '1');

        $this->db->select('bebas_pay.bebas_pay_id, bebas_pay_bill, bebas_pay_bill, bebas_pay_number, bebas_pay_desc, bebas_pay_input_date, bebas_pay_last_update');
        $this->db->select('bebas_pay.bebas_bebas_id, bebas_bill');
        // $this->db->select_sum('bebas_pay_bill');
        $this->db->select('student_student_id, student_nis, student.class_class_id, class_name, student_full_name, student_name_of_mother, student_parent_phone');
        $this->db->select('payment_payment_id, payment_type, period_start, period_end, payment.pos_pos_id, pos_name');
        $this->db->select('user_user_id, user_full_name');
        
        $this->db->select('account.account_id, account.account_code');
        
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('users', 'users.user_id = bebas_pay.user_user_id', 'left');
        $this->db->join('kas', 'kas.kas_noref = bebas_pay.bebas_pay_noref', 'left');
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

    // Add and update to database
    function add($data = array()) {

       if(isset($data['bebas_pay_id'])) {
        $this->db->set('bebas_pay_id', $data['bebas_pay_id']);
    }

    if(isset($data['bebas_id'])) {
        $this->db->set('bebas_bebas_id', $data['bebas_id']);
    }

    if(isset($data['bebas_pay_bill'])) {
        $this->db->set('bebas_pay_bill', $data['bebas_pay_bill']);
    }

    if(isset($data['bebas_pay_number'])) {
        $this->db->set('bebas_pay_number', $data['bebas_pay_number']);
    }

    if(isset($data['bebas_pay_account_id'])) {
        $this->db->set('bebas_pay_account_id', $data['bebas_pay_account_id']);
    }

    if(isset($data['bebas_pay_noref'])) {
        $this->db->set('bebas_pay_noref', $data['bebas_pay_noref']);
    }

    if(isset($data['bebas_pay_desc'])) {
        $this->db->set('bebas_pay_desc', $data['bebas_pay_desc']);
    }

    if(isset($data['user_user_id'])) {
        $this->db->set('user_user_id', $data['user_user_id']);
    }

    if(isset($data['bebas_pay_input_date'])) {
        $this->db->set('bebas_pay_input_date', $data['bebas_pay_input_date']);
    }

    if(isset($data['bebas_pay_last_update'])) {
        $this->db->set('bebas_pay_last_update', $data['bebas_pay_last_update']);
    }

    if (isset($data['bebas_pay_id'])) {
        $this->db->where('bebas_pay_id', $data['bebas_pay_id']);
        $this->db->update('bebas_pay');
        $id = $data['bebas_pay_id'];
    } else {
        $this->db->insert('bebas_pay');
        $id = $this->db->insert_id();
    }

    $status = $this->db->affected_rows();
    return ($status == 0) ? FALSE : $id;
}


    // Delete to database
function delete($id) {
    $this->db->where('bebas_pay_id', $id);
    $this->db->delete('bebas_pay');
}

}
