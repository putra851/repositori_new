<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function get_kredit_noref($like){
        
        $query = $this->db->query("SELECT MAX(RIGHT(kredit_kas_noref,4)) AS no_max FROM kredit WHERE DATE(kredit_input_date)=CURDATE() AND kredit_kas_noref LIKE '$like%'");
        
        $q   = $query->row();
        $noref = "";
        $tmp   = "";
        
        if (count($q)>0){
            $tmp = ((int)$q->no_max)+1;
            $noref = sprintf("%04s", $tmp);
        } else {
            $noref = "0001";
        }
        return date('dmy').$noref;
    }
	
	function get_debit_noref($like){
        
        $query = $this->db->query("SELECT MAX(RIGHT(debit_kas_noref,4)) AS no_max FROM debit WHERE DATE(debit_input_date)=CURDATE() AND debit_kas_noref LIKE '$like%'");
        
        $q   = $query->row();
        $noref = "";
        $tmp   = "";
        
        if (count($q)>0){
            $tmp = ((int)$q->no_max)+1;
            $noref = sprintf("%04s", $tmp);
        } else {
            $noref = "0001";
        }
        return date('dmy').$noref;
    }

	function get($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('log_tf_id', $params['id']);
		}

		if (isset($params['account_id'])) {
			$this->db->where('log_tf_account_id', $params['account_id']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }
		
		$this->db->order_by('log_tf_id', 'desc');
		
        $this->db->where('majors_status', '1');

		$this->db->select('log_tf_id, log_tf_date, log_tf_kredit_id, log_tf_debit_id, log_tf_note');
		$this->db->select('majors_id, majors_short_name, majors_name');
		$this->db->select('kredit_id, kredit_desc, kredit_kas_noref, kredit_value, kredit_date');
		$this->db->select('debit_id, debit_desc, debit_kas_noref, debit_value, debit_date');
		$this->db->select('user_id, user_full_name');
		
		$this->db->join('kredit', 'kredit.kredit_id = log_tf.log_tf_kredit_id', 'left');
		$this->db->join('debit', 'debit.debit_id = log_tf.log_tf_debit_id', 'left');
        $this->db->join('majors', 'majors.majors_id = log_tf.log_tf_majors_id', 'left');
        $this->db->join('users', 'users.user_id = log_tf.log_tf_user_id', 'left');

		$res = $this->db->get('log_tf');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

    // Delete log_tf to database
	function delete($id) {
		$this->db->where('log_tf_id', $id);
		$this->db->delete('log_tf');
	}
    
    function save_kas($params){
	    
		$this->db->insert('kas', $params);
		
	}
    
    function save_log_tf($params){
	    
		$this->db->insert('log_tf', $params);
		
	}

}
