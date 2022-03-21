<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Payment_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function cari_tagihan($id_periode){
        $query = "SELECT * FROM `payment` JOIN period ON payment.period_period_id = period.period_id JOIN pos ON payment.pos_pos_id = pos.pos_id WHERE payment.payment_type = 'BULAN' AND payment.period_period_id = '$id_periode'";
        $q=$this->db->query($query);    
        if ($q->num_rows() > 0){
            foreach($q->result_array() as $row){
                $data[]=$row;
            }
            return $data;   
        }
    }

    function get_tagihan($id_periode, $id_majors){
        $query = "SELECT * FROM `payment` JOIN period ON payment.period_period_id = period.period_id JOIN pos ON payment.pos_pos_id = pos.pos_id JOIN account ON account.account_id = pos.account_account_id JOIN majors ON majors.majors_id = account.account_majors_id WHERE payment.period_period_id = '$id_periode' AND majors.majors_id = '$id_majors' AND majors.majors_status = '1' ";
        $q=$this->db->query($query);    
        if ($q->num_rows() > 0){
            foreach($q->result_array() as $row){
                $data[]=$row;
            }
            return $data;   
        }
    }
    
    // Get From Databases
    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('payment.payment_id', $params['id']);
        }

        if(isset($params['period_id']))
        {
            $this->db->where('payment.period_period_id', $params['period_id']);
        }

        if(isset($params['pos_id']))
        {
            $this->db->where('payment.pos_pos_id', $params['pos_id']);
        }

        if(isset($params['search'])) 
        {
            $this->db->like('pos_name', $params['search']);
        }
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('account_majors_id', $params['account_majors_id']);
        }

        if(isset($params['period_start'])) 
        {
            $this->db->where('period_start', $params['period_start']);
        }

        if(isset($params['period_end'])) 
        {
            $this->db->where('period_end', $params['period_end']);
        }


        if(isset($params['payment_input_date']))
        {
            $this->db->where('payment_input_date', $params['payment_input_date']);
        }

        if(isset($params['payment_last_update']))
        {
            $this->db->where('payment_last_update', $params['payment_last_update']);
        }
        
        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('payment_input_date >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('payment_input_date <=', $params['date_end'] . ' 23:59:59');
        }
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }

        if(isset($params['status']))
        {
            $this->db->where('payment_input_date', $params['status']);
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
            $this->db->order_by('payment_last_update', 'desc');
        }

        $this->db->where('majors_status', '1');
        
        $this->db->select('payment.payment_id, payment_type, payment_mode, payment_input_date, payment_last_update');
        $this->db->select('majors_id, majors_short_name');
        $this->db->select('pos_pos_id, pos_name, pos_description');
        $this->db->select('period_period_id, period.period_start, period.period_end, period.period_status');

        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('account', 'account.account_id = pos.account_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');
        $res = $this->db->get('payment');

        if(isset($params['id']))
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
        
         if(isset($data['payment_id'])) {
            $this->db->set('payment_id', $data['payment_id']);
        }
        
         if(isset($data['payment_type'])) {
            $this->db->set('payment_type', $data['payment_type']);
        }
        
         if(isset($data['payment_mode'])) {
            $this->db->set('payment_mode', $data['payment_mode']);
        }
        
         if(isset($data['period_id'])) {
            $this->db->set('period_period_id', $data['period_id']);
        }
        
         if(isset($data['pos_id'])) {
            $this->db->set('pos_pos_id', $data['pos_id']);
        }
        
         if(isset($data['payment_input_date'])) {
            $this->db->set('payment_input_date', $data['payment_input_date']);
        }
        
         if(isset($data['payment_last_update'])) {
            $this->db->set('payment_last_update', $data['payment_last_update']);
        }
        
        if (isset($data['payment_id'])) {
            $this->db->where('payment_id', $data['payment_id']);
            $this->db->update('payment');
            $id = $data['payment_id'];
        } else {
            $this->db->insert('payment');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Delete all to database
    function delete_all() {
        $this->db->truncate('payment');
    }
    
    // Delete to database
    function delete($id) {
        $this->db->where('payment_id', $id);
        $this->db->delete('payment');
    }
    
}
