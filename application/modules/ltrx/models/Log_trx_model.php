<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_trx_model extends CI_Model {

	function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('log_trx.log_trx_id', $params['id']);
        }

        if (isset($params['bulan_id'])) {
            $this->db->where('bulan_bulan_id', $params['bulan_id']);
        }
        
        if (isset($params['payment_noref'])) {
            /*$this->db->where('kasMonth.kas_noref !=', $params['payment_noref']);
            $this->db->or_where('kasBebas.kas_noref !=', $params['payment_noref']);*/
            $this->db->where('bulan_noref !=', '');
            $this->db->where('bulan_noref !=', $params['payment_noref']);
            $this->db->or_where('bebas_pay_noref !=', $params['payment_noref']);
        }
        
        if (isset($params['bebas_pay_id'])) {
            $this->db->where('bebas_pay_bebas_pay_id', $params['bebas_pay_id']);
        }

        if (isset($params['payment_id'])) {
            $this->db->where('payment_payment_id', $params['payment_id']);
        }

        if (isset($params['student_id'])) {
            $this->db->where('log_trx.student_student_id', $params['student_id']);
        }

        if (isset($params['student_nis'])) {
            $this->db->where('student_nis', $params['student_nis']);
        }


        if (isset($params['log_trx_input_date'])) {
            $this->db->where('log_trx_input_date', $params['log_trx_input_date']);
        }

        if (isset($params['log_trx_last_update'])) {
            $this->db->where('log_trx_last_update', $params['log_trx_last_update']);
        }

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('log_trx_id', 'desc');
        }
        
        $this->db->select('log_trx.log_trx_id, log_trx_input_date, log_trx_last_update');
        $this->db->select('bulan_bulan_id, log_trx.student_student_id, student_nis, bulan_bill, bulan_account_id, bulan_noref, month_name, bebas_pay_bill, bebas_pay_account_id, bebas_pay_noref');

        $this->db->select('posMonth.pos_name AS posmonth_name, posBebas.pos_name AS posbebas_name, periodMonth.period_start AS period_start_month, periodMonth.period_end AS period_end_month');
        $this->db->select('periodBebas.period_start AS period_start_bebas, periodBebas.period_end AS period_end_bebas');

        $this->db->join('bulan', 'bulan.bulan_id = log_trx.bulan_bulan_id', 'left');
        $this->db->join('month', 'month.month_id = bulan.month_month_id', 'left');
        $this->db->join('bebas_pay', 'bebas_pay.bebas_pay_id = log_trx.bebas_pay_bebas_pay_id', 'left');
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = log_trx.student_student_id', 'left');
        $this->db->join('payment AS payMonth', 'payMonth.payment_id = bulan.payment_payment_id', 'left');
        $this->db->join('payment AS payBebas', 'payBebas.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('pos AS posMonth', 'posMonth.pos_id = payMonth.pos_pos_id', 'left');
        $this->db->join('pos AS posBebas', 'posBebas.pos_id = payBebas.pos_pos_id', 'left');
        $this->db->join('period AS periodMonth', 'periodMonth.period_id = payMonth.period_period_id', 'left');
        $this->db->join('period AS periodBebas', 'periodBebas.period_id = payBebas.period_period_id', 'left');
        $this->db->join('account AS accountMonth', 'accountMonth.account_id = bulan.bulan_account_id', 'left');
        $this->db->join('account AS accountBebas', 'accountBebas.account_id = bebas_pay.bebas_pay_account_id', 'left');
        $this->db->join('kas AS kasMonth', 'kasMonth.kas_noref = bulan.bulan_noref', 'left');
        $this->db->join('kas AS kasBebas', 'kasBebas.kas_noref = bebas_pay.bebas_pay_noref', 'left');

        $res = $this->db->get('log_trx');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
        
    }
    
    function get_history($params = array()){
        
        if (isset($params['payment_noref'])) {
            $noref = $params['payment_noref'];
        } else {
            $noref = NULL;
        }

        if (isset($params['student_id'])) {
            $student_id = $params['student_id'];
        } else {
            $student_id = NULL;
        }

        if (isset($params['student_nis'])) {
            $student_nis = $params['student_nis'];
        } else {
            $student_nis = NULL;
        }
        
        $res = $this->db->query("SELECT `log_trx`.`log_trx_id`, `log_trx_input_date`, `log_trx_last_update`, `bulan_bulan_id`, 
        `log_trx`.`student_student_id`, `student_nis`, `bulan_bill`, `bulan_account_id`, `bulan_noref`, `month_name`, `bebas_pay_bill`, 
        `bebas_pay_account_id`, `bebas_pay_noref`, `accountMonth`.`account_description` AS accMonth, `accountBebas`.`account_description` AS accBebas, `posMonth`.`pos_name` AS `posmonth_name`, `posBebas`.`pos_name` AS `posbebas_name`, 
        `periodMonth`.`period_start` AS `period_start_month`, `periodMonth`.`period_end` AS `period_end_month`, 
        `periodBebas`.`period_start` AS `period_start_bebas`, `periodBebas`.`period_end` AS `period_end_bebas` 
        FROM `log_trx`
        LEFT JOIN `bulan` ON `bulan`.`bulan_id` = `log_trx`.`bulan_bulan_id` 
        LEFT JOIN `month` ON `month`.`month_id` = `bulan`.`month_month_id` 
        LEFT JOIN `bebas_pay` ON `bebas_pay`.`bebas_pay_id` = `log_trx`.`bebas_pay_bebas_pay_id` 
        LEFT JOIN `bebas` ON `bebas`.`bebas_id` = `bebas_pay`.`bebas_bebas_id` 
        LEFT JOIN `student` ON `student`.`student_id` = `log_trx`.`student_student_id` 
        LEFT JOIN `payment` AS `payMonth` ON `payMonth`.`payment_id` = `bulan`.`payment_payment_id` 
        LEFT JOIN `payment` AS `payBebas` ON `payBebas`.`payment_id` = `bebas`.`payment_payment_id` 
        LEFT JOIN `pos` AS `posMonth` ON `posMonth`.`pos_id` = `payMonth`.`pos_pos_id` 
        LEFT JOIN `pos` AS `posBebas` ON `posBebas`.`pos_id` = `payBebas`.`pos_pos_id` 
        LEFT JOIN `period` AS `periodMonth` ON `periodMonth`.`period_id` = `payMonth`.`period_period_id` 
        LEFT JOIN `period` AS `periodBebas` ON `periodBebas`.`period_id` = `payBebas`.`period_period_id` 
        LEFT JOIN `account` AS `accountMonth` ON `accountMonth`.`account_id` = `bulan`.`bulan_account_id` 
        LEFT JOIN `account` AS `accountBebas` ON `accountBebas`.`account_id` = `bebas_pay`.`bebas_pay_account_id` 
        LEFT JOIN `kas` AS `kasMonth` ON `kasMonth`.`kas_noref` = `bulan`.`bulan_noref` 
        LEFT JOIN `kas` AS `kasBebas` ON `kasBebas`.`kas_noref` = `bebas_pay`.`bebas_pay_noref` 
        WHERE (`log_trx`.`student_student_id` = '$student_id' AND `student_nis` = '$student_nis' AND `bulan_noref` != '' AND `bulan_noref` != '$noref') 
        OR (`bebas_pay_noref` != '$noref' AND `log_trx`.`student_student_id` = '$student_id' AND `student_nis` = '$student_nis') 
        ORDER BY `log_trx_id` DESC");
        
        return $res->result_array();
            
    }
    
    function get_trx($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('log_trx.log_trx_id', $params['id']);
        }

        if (isset($params['bulan_id'])) {
            $this->db->where('bulan_bulan_id', $params['bulan_id']);
        }
        
        if (isset($params['payment_noref'])) {
            $this->db->where('bulan_noref =', $params['payment_noref']);
            $this->db->or_where('bebas_pay_noref =', $params['payment_noref']);
        }

        if (isset($params['bebas_pay_id'])) {
            $this->db->where('bebas_pay_bebas_pay_id', $params['bebas_pay_id']);
        }

        if (isset($params['payment_id'])) {
            $this->db->where('payment_payment_id', $params['payment_id']);
        }

        if (isset($params['student_id'])) {
            $this->db->where('log_trx.student_student_id', $params['student_id']);
        }

        if (isset($params['student_nis'])) {
            $this->db->where('student_nis', $params['student_nis']);
        }


        if (isset($params['log_trx_input_date'])) {
            $this->db->where('log_trx_input_date', $params['log_trx_input_date']);
        }

        if (isset($params['log_trx_last_update'])) {
            $this->db->where('log_trx_last_update', $params['log_trx_last_update']);
        }

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('log_trx_id', 'desc');
        }
        $this->db->select('log_trx.log_trx_id, log_trx_input_date, log_trx_last_update');
        $this->db->select('bulan_bulan_id, log_trx.student_student_id, student_nis, bulan_bill, bulan_account_id, bulan_noref, month_name, bebas_pay_bill, bebas_pay_account_id, bebas_pay_noref');

        $this->db->select('posMonth.pos_name AS posmonth_name, posBebas.pos_name AS posbebas_name, periodMonth.period_start AS period_start_month, periodMonth.period_end AS period_end_month');
        $this->db->select('periodBebas.period_start AS period_start_bebas, periodBebas.period_end AS period_end_bebas');

        $this->db->join('bulan', 'bulan.bulan_id = log_trx.bulan_bulan_id', 'left');
        $this->db->join('month', 'month.month_id = bulan.month_month_id', 'left');
        $this->db->join('bebas_pay', 'bebas_pay.bebas_pay_id = log_trx.bebas_pay_bebas_pay_id', 'left');
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('student', 'student.student_id = log_trx.student_student_id', 'left');
        $this->db->join('payment AS payMonth', 'payMonth.payment_id = bulan.payment_payment_id', 'left');
        $this->db->join('payment AS payBebas', 'payBebas.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('pos AS posMonth', 'posMonth.pos_id = payMonth.pos_pos_id', 'left');
        $this->db->join('pos AS posBebas', 'posBebas.pos_id = payBebas.pos_pos_id', 'left');
        $this->db->join('period AS periodMonth', 'periodMonth.period_id = payMonth.period_period_id', 'left');
        $this->db->join('period AS periodBebas', 'periodBebas.period_id = payBebas.period_period_id', 'left');
        $this->db->join('account AS accountMonth', 'accountMonth.account_id = bulan.bulan_account_id', 'left');
        $this->db->join('account AS accountBebas', 'accountBebas.account_id = bebas_pay.bebas_pay_account_id', 'left');
        $this->db->join('kas AS kasMonth', 'kasMonth.kas_noref = bulan.bulan_noref', 'left');
        $this->db->join('kas AS kasBebas', 'kasBebas.kas_noref = bebas_pay.bebas_pay_noref', 'left');

        $res = $this->db->get('log_trx');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function add($data = array()) {

        if (isset($data['log_trx_id'])) {
            $this->db->set('log_trx_id', $data['log_trx_id']);
        }

        if (isset($data['bulan_bulan_id'])) {
            $this->db->set('bulan_bulan_id', $data['bulan_bulan_id']);
        }

        if (isset($data['bebas_pay_bebas_pay_id'])) {
            $this->db->set('bebas_pay_bebas_pay_id', $data['bebas_pay_bebas_pay_id']);
        }

        if (isset($data['student_student_id'])) {
            $this->db->set('student_student_id', $data['student_student_id']);
        }

        if (isset($data['log_trx_input_date'])) {
            $this->db->set('log_trx_input_date', $data['log_trx_input_date']);
        }

        if (isset($data['log_trx_last_update'])) {
            $this->db->set('log_trx_last_update', $data['log_trx_last_update']);
        }


        if (isset($data['log_trx_id'])) {
            $this->db->where('log_trx_id', $data['log_trx_id']);
            $this->db->update('log_trx');
            $id = $data['log_trx_id'];
        } else {
            $this->db->insert('log_trx');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

      // Delete log_trx to database
    function delete($id) {
        $this->db->where('log_trx_id', $id);
        $this->db->delete('log_trx');
    }

      // Delete log_trx to database
    function delete_log($params = array()) {
        
        if (isset($params['bulan_id'])) {
            $this->db->where('bulan_bulan_id', $params['bulan_id']);
        }

        if (isset($params['bebas_pay_id'])) {
            $this->db->where('bebas_pay_bebas_pay_id', $params['bebas_pay_id']);
        }

        if (isset($params['student_id'])) {
            $this->db->where('log_trx.student_student_id', $params['student_id']);
        }

        $this->db->delete('log_trx');
    }
    
    function trx_finish($data = array()) {

        if (isset($data['kas_id'])) {
            $this->db->set('kas_id', $data['kas_id']);
        }

        if (isset($data['kas_noref'])) {
            $this->db->set('kas_noref', $data['kas_noref']);
        }

        if (isset($data['kas_period'])) {
            $this->db->set('kas_period', $data['kas_period']);
        }

        if (isset($data['kas_date'])) {
            $this->db->set('kas_date', $data['kas_date']);
        }

        if (isset($data['kas_month_id'])) {
            $this->db->set('kas_month_id', $data['kas_month_id']);
        }

        if (isset($data['kas_account_id'])) {
            $this->db->set('kas_account_id', $data['kas_account_id']);
        }

        if (isset($data['kas_majors_id'])) {
            $this->db->set('kas_majors_id', $data['kas_majors_id']);
        }
        
        if (isset($data['kas_debit'])) {
            $this->db->set('kas_debit', $data['kas_debit']);
        }
        
        if (isset($data['kas_note'])) {
            $this->db->set('kas_note', $data['kas_note']);
        }

        if (isset($data['kas_category'])) {
            $this->db->set('kas_category', $data['kas_category']);
        }

        if (isset($data['kas_user_id'])) {
            $this->db->set('kas_user_id', $data['kas_user_id']);
        }

        if (isset($data['kas_input_date'])) {
            $this->db->set('kas_input_date', $data['kas_input_date']);
        }

        if (isset($data['kas_last_update'])) {
            $this->db->set('kas_last_update', $data['kas_last_update']);
        }
        
        $this->db->insert('kas');
        $id = $this->db->insert_id();

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function send_pesan($data = array()) {

        if (isset($data['pesan'])) {
            $this->db->set('pesan', $data['pesan']);
        }

        if (isset($data['no_wa'])) {
            $this->db->set('no_wa', $data['no_wa']);
        }

        if (isset($data['status_kirim'])) {
            $this->db->set('status_kirim', $data['status_kirim']);
        }

        if (isset($data['id_funding'])) {
            $this->db->set('id_funding', $data['id_funding']);
        }

        if (isset($data['created_by'])) {
            $this->db->set('created_by', $data['created_by']);
        }

        if (isset($data['created_date'])) {
            $this->db->set('created_date', $data['created_date']);
        }
        
       
        $this->db->insert('pesan');
        $id = $this->db->insert_id();

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

}

/* End of file Log_trx_model.php */
/* Location: ./application/modules/ltrx/models/Log_trx_model.php */