<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Settinghutang_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_noref($like){
        
        $query = $this->db->query("SELECT MAX(RIGHT(hutang_noref,2)) AS no_max FROM hutang WHERE DATE(hutang_input_date)=CURDATE() AND hutang_noref LIKE '$like%'")->row();
        
        if (count($query)>0){
            $tmp = ((int)$query->no_max)+1;
            $noref = sprintf("%02s", $tmp);
        } else {
            $noref = "01";
        }
        
        return date('dmy').$noref;
    }
    
    function cari_tagihan($id_periode){
        $query = "SELECT * FROM `settinghutang` JOIN period ON settinghutang.settinghutang_period_id = period.period_id JOIN poshutang ON settinghutang.settinghutang_poshutang_id = poshutang.poshutang_id WHERE settinghutang.settinghutang_period_id = '$id_periode'";
        $q=$this->db->query($query);    
        if ($q->num_rows() > 0){
            foreach($q->result_array() as $row){
                $data[]=$row;
            }
            return $data;   
        }
    }

    function get_tagihan($id_periode, $id_majors){
        $query = "SELECT * FROM `settinghutang` JOIN period ON settinghutang.settinghutang_period_id = period.period_id JOIN poshutang ON settinghutang.settinghutang_poshutang_id = poshutang.poshutang_id JOIN account ON account.account_id = poshutang.poshutang_account_id JOIN majors ON majors.majors_id = account.account_majors_id WHERE settinghutang.settinghutang_period_id = '$id_periode' AND majors.majors_id = '$id_majors' AND majors.majors_status = '1' ";
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
            $this->db->where('settinghutang.settinghutang_id', $params['id']);
        }

        if(isset($params['period_id']))
        {
            $this->db->where('settinghutang.settinghutang_period_id', $params['period_id']);
        }

        if(isset($params['poshutang_id']))
        {
            $this->db->where('settinghutang.settinghutang_poshutang_id', $params['poshutang_id']);
        }

        if(isset($params['search'])) 
        {
            $this->db->like('poshutang_name', $params['search']);
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


        if(isset($params['settinghutang_input_date']))
        {
            $this->db->where('settinghutang_input_date', $params['settinghutang_input_date']);
        }

        if(isset($params['settinghutang_last_update']))
        {
            $this->db->where('settinghutang_last_update', $params['settinghutang_last_update']);
        }
        
        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('settinghutang_input_date >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('settinghutang_input_date <=', $params['date_end'] . ' 23:59:59');
        }
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
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
            $this->db->order_by('settinghutang_last_update', 'desc');
        }
        
        $this->db->select('settinghutang.settinghutang_id, settinghutang_input_date, settinghutang_last_update');
        $this->db->select('majors_id, majors_short_name');
        $this->db->select('settinghutang_poshutang_id, poshutang_name, poshutang_description');
        $this->db->select('settinghutang_period_id, period.period_start, period.period_end, period.period_status');

        $this->db->join('period', 'period.period_id = settinghutang.settinghutang_period_id', 'left');
        $this->db->join('poshutang', 'poshutang.poshutang_id = settinghutang.settinghutang_poshutang_id', 'left');
        $this->db->join('account', 'account.account_id = poshutang.poshutang_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');
        $res = $this->db->get('settinghutang');

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
        
         if(isset($data['settinghutang_id'])) {
            $this->db->set('settinghutang_id', $data['settinghutang_id']);
        }
        
         if(isset($data['period_id'])) {
            $this->db->set('settinghutang_period_id', $data['period_id']);
        }
        
         if(isset($data['poshutang_id'])) {
            $this->db->set('settinghutang_poshutang_id', $data['poshutang_id']);
        }
        
         if(isset($data['settinghutang_input_date'])) {
            $this->db->set('settinghutang_input_date', $data['settinghutang_input_date']);
        }
        
         if(isset($data['settinghutang_last_update'])) {
            $this->db->set('settinghutang_last_update', $data['settinghutang_last_update']);
        }
        
        if (isset($data['settinghutang_id'])) {
            $this->db->where('settinghutang_id', $data['settinghutang_id']);
            $this->db->update('settinghutang');
            $id = $data['settinghutang_id'];
        } else {
            $this->db->insert('settinghutang');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Delete all to database
    function delete_all() {
        $this->db->truncate('settinghutang');
    }
    
    // Delete to database
    function delete($id) {
        $this->db->where('settinghutang_id', $id);
        $this->db->delete('settinghutang');
    }
    
}
