<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debit_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

    // Get debit from database
	function get($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('debit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('debit_date', $params['date']);
		}

		if (isset($params['noref'])) {
			$this->db->where('debit_kas_noref', $params['noref']);
		}

		if (isset($params['debit_desc'])) {
			$this->db->like('debit_desc', $params['debit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $params['account_majors_id']);
        }

		if(isset($params['debit_input_date']))
		{
			$this->db->where('debit_input_date', $params['debit_input_date']);
		}

		if(isset($params['debit_last_update']))
		{
			$this->db->where('debit_last_update', $params['debit_last_update']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
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
			$this->db->order_by('debit_date', 'desc');
		}
		
		if(isset($params['order_by']))
		{
			$this->db->order_by($params['order_by'], 'desc');
		}
		else
		{   
		    $this->db->order_by('debit_date', 'desc');
			//$this->db->order_by('debit_id', 'desc');
		}
		
		$this->db->where('majors_status', '1');

		$this->db->select("debit_id, debit_kas_noref, debit_date, debit_value, IF(debit_tax_id != 0, tax_number, 0) AS debit_tax, IF(debit_item_id != 0, item_name, 'Tidak Ada') as debit_item, debit_desc, debit_account_id, account.account_id, account.account_code, account.account_description, tax_id, item_id, debit_input_date, debit_last_update");
		$this->db->select('user_user_id, user_full_name');
		$this->db->select('acc.account_id AS accID, acc.account_code AS accCode, acc.account_description AS accDesc');

		$this->db->join('users', 'users.user_id = debit.user_user_id', 'left');
		$this->db->join('kas', 'kas.kas_noref = debit.debit_kas_noref', 'left');
		$this->db->join('account', 'account.account_id = debit.debit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');
        $this->db->join('tax', 'tax.tax_id = debit.debit_tax_id', 'left');
        $this->db->join('item', 'item.item_id = debit.debit_item_id', 'left');

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
	
	function get_last($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('debit_id', $param['id']);
		}

		if (isset($params['noref'])) {
			$this->db->where('debit_kas_noref', $params['noref']);
		}

		if (isset($param['date'])) {
			$this->db->where('debit_date', $param['date']);
		}

		if (isset($param['debit_desc'])) {
			$this->db->like('debit_desc', $param['debit_desc']);
		}
        
        if(isset($param['account_majors_id']))
        {
            $this->db->where('account_majors_id', $param['account_majors_id']);
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

        $this->db->where('majors_status', '1');

		$this->db->select("debit_id, debit_kas_noref, debit_date, debit_value, IF(debit_tax_id != 0, tax_number, 0) AS debit_tax, IF(debit_item_id != 0, item_name, 'Tidak Ada') as debit_item, debit_desc, debit_account_id, account_id, account_code, account_description, tax_id, item_id, debit_input_date, debit_last_update");
		$this->db->select('user_user_id, user_full_name');

		$this->db->join('users', 'users.user_id = debit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = debit.debit_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');
        $this->db->join('tax', 'tax.tax_id = debit.debit_tax_id', 'left');
        $this->db->join('item', 'item.item_id = debit.debit_item_id', 'left');

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
	
	function get_jurnal($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('debit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('debit_date', $params['date']);
		}

		if (isset($params['noref'])) {
			$this->db->where('debit_kas_noref', $params['noref']);
		}

		if (isset($params['debit_desc'])) {
			$this->db->like('debit_desc', $params['debit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $params['account_majors_id']);             
            $this->db->like('kas_noref', 'JM', 'after');
        }
            
        if(isset($params['kas_noref']))
		{            
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
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
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
		    $this->db->order_by('account_id', 'asc');
			$this->db->order_by('debit_id', 'desc');
		}
		
        $this->db->where('majors_status', '1');

		$this->db->select('debit_id, debit_kas_noref, debit_date, debit_value, debit_desc, debit_account_id, account.account_id, account.account_code, account.account_description, debit_input_date, debit_last_update');
		$this->db->select('user_user_id, user_full_name');

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
	
	function get_last_jurnal($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('debit_id', $param['id']);
		}

		if (isset($params['noref'])) {
			$this->db->where('debit_kas_noref', $params['noref']);
		}

		if (isset($param['date'])) {
			$this->db->where('debit_date', $param['date']);
		}

		if (isset($param['debit_desc'])) {
			$this->db->like('debit_desc', $param['debit_desc']);
		}
		
        if(isset($param['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $param['account_majors_id']);             
            $this->db->like('kas_noref', 'JM', 'after');
        }
            
        if(isset($param['kas_noref']))
		{          
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
			$this->db->where('debit_date <', $param['date_start'] . ' 00:00:00');
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

        $this->db->where('majors_status', '1');

		$this->db->select('debit_id, debit_kas_noref, debit_date, debit_value, debit_desc, debit_account_id, account.account_id, account.account_code, account.account_description, debit_input_date, debit_last_update');
		$this->db->select('user_user_id, user_full_name');

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
	
	function get_kas($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('debit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('debit_date', $params['date']);
		}

		if (isset($params['noref'])) {
			$this->db->where('debit_kas_noref', $params['noref']);
		}

		if (isset($params['debit_desc'])) {
			$this->db->like('debit_desc', $params['debit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $params['account_majors_id']);             
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
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
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
		    $this->db->order_by('account_id', 'asc');
			$this->db->order_by('debit_id', 'desc');
		}
		
        $this->db->where('majors_status', '1');

		$this->db->select('debit_id, debit_kas_noref, debit_date, debit_value, debit_desc, debit_account_id, account.account_id, account.account_code, account.account_description, debit_input_date, debit_last_update');
		$this->db->select('user_user_id, user_full_name');

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
	
	function get_last_kas($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('debit_id', $param['id']);
		}

		if (isset($params['noref'])) {
			$this->db->where('debit_kas_noref', $params['noref']);
		}

		if (isset($param['date'])) {
			$this->db->where('debit_date', $param['date']);
		}

		if (isset($param['debit_desc'])) {
			$this->db->like('debit_desc', $param['debit_desc']);
		}
		
        if(isset($param['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $param['account_majors_id']);             
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

        $this->db->where('majors_status', '1');

		$this->db->select('debit_id, debit_kas_noref, debit_date, debit_value, debit_desc, debit_account_id, account.account_id, account.account_code, account.account_description, debit_input_date, debit_last_update');
		$this->db->select('user_user_id, user_full_name');

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
	
	function get_bank($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('debit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('debit_date', $params['date']);
		}

		if (isset($params['noref'])) {
			$this->db->where('debit_kas_noref', $params['noref']);
		}

		if (isset($params['debit_desc'])) {
			$this->db->like('debit_desc', $params['debit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $params['account_majors_id']);             
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
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
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
		    $this->db->order_by('account_id', 'asc');
			$this->db->order_by('debit_id', 'desc');
		}
		
        $this->db->where('majors_status', '1');

		$this->db->select('debit_id, debit_kas_noref, debit_date, debit_value, debit_desc, debit_account_id, account.account_id, account.account_code, account.account_description, debit_input_date, debit_last_update');
		$this->db->select('user_user_id, user_full_name');
        
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
	
	function get_last_bank($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('debit_id', $param['id']);
		}

		if (isset($params['noref'])) {
			$this->db->where('debit_kas_noref', $params['noref']);
		}

		if (isset($param['date'])) {
			$this->db->where('debit_date', $param['date']);
		}

		if (isset($param['debit_desc'])) {
			$this->db->like('debit_desc', $param['debit_desc']);
		}
		
        if(isset($param['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $param['account_majors_id']);             
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

        $this->db->where('majors_status', '1');

		$this->db->select('debit_id, debit_kas_noref, debit_date, debit_value, debit_desc, debit_account_id, account.account_id, account.account_code, account.account_description, debit_input_date, debit_last_update');
		$this->db->select('user_user_id, user_full_name');
        
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

    // Add and update to database
	function add($data = array()) {

		if(isset($data['debit_id'])) {
			$this->db->set('debit_id', $data['debit_id']);
		}

		if(isset($data['debit_date'])) {
			$this->db->set('debit_date', $data['debit_date']);
		}

		if(isset($data['debit_value'])) {
			$this->db->set('debit_value', $data['debit_value']);
		}

		if(isset($data['debit_kas_account_id'])) {
			$this->db->set('debit_kas_account_id', $data['debit_kas_account_id']);
		}

		if(isset($data['debit_kas_noref'])) {
			$this->db->set('debit_kas_noref', $data['debit_kas_noref']);
		}

		if(isset($data['debit_desc'])) {
			$this->db->set('debit_desc', $data['debit_desc']);
		}

		if(isset($data['debit_account_id'])) {
			$this->db->set('debit_account_id', $data['debit_account_id']);
		}

		if(isset($data['debit_tax_id'])) {
			$this->db->set('debit_tax_id', $data['debit_tax_id']);
		}

		if(isset($data['debit_item_id'])) {
			$this->db->set('debit_item_id', $data['debit_item_id']);
		}

		if(isset($data['user_user_id'])) {
			$this->db->set('user_user_id', $data['user_user_id']);
		}

		if(isset($data['debit_input_date'])) {
			$this->db->set('debit_input_date', $data['debit_input_date']);
		}

		if(isset($data['debit_last_update'])) {
			$this->db->set('debit_last_update', $data['debit_last_update']);
		}

		if (isset($data['debit_id'])) {
			$this->db->where('debit_id', $data['debit_id']);
			$this->db->update('debit');
			$id = $data['debit_id'];
		} else {
			$this->db->insert('debit');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Delete debit to database
	function delete($id) {
		$this->db->where('debit_id', $id);
		$this->db->delete('debit');
	}
	
	function get_bcode($kas=array()){
        
        if(isset($kas['noref'])){
            $this->db->where('kas_noref', $kas['noref']);
        }
        
        $this->db->select('kas_noref, kas_date, account_code, account_description');

        $this->db->join('account', 'account.account_id = kas.kas_account_id', 'left');

        $res = $this->db->get('kas');
        
        return $res->row_array();
        
    }
    
    function get_sum($params=array()){
        
        if(isset($params['noref'])){
            $this->db->where('debit_kas_noref', $params['noref']);
        }
        
        $this->db->select('debit_kas_noref, debit_date, SUM(debit_value) AS total, account_code, account_description, majors_name, majors_short_name');

        $this->db->join('account', 'account.account_id = debit.debit_account_id', 'left');
        $this->db->join('majors', 'account.account_majors_id = majors.majors_id', 'left');

        $res = $this->db->get('debit');
        
        return $res->row_array();
        
    }
	

}

/* End of file debit_model.php */
/* Location: ./application/modules/jurnal/models/debit_model.php */