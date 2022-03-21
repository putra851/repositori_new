<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kredit_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

    // Get kredit from database
	function get($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kredit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kredit_date', $params['date']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($params['kredit_desc'])) {
			$this->db->like('kredit_desc', $params['kredit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('acc.account_majors_id', $params['account_majors_id']);
        }

		if(isset($params['kredit_input_date']))
		{
			$this->db->where('kredit_input_date', $params['kredit_input_date']);
		}

		if(isset($params['kredit_last_update']))
		{
			$this->db->where('kredit_last_update', $params['kredit_last_update']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
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
			$this->db->order_by('kredit_date', 'desc');
		}
		
		if(isset($params['order_by']))
		{
			$this->db->order_by($params['order_by'], 'desc');
		}
		else
		{   
		    $this->db->order_by('kredit_date', 'desc');
			//$this->db->order_by('kredit_id', 'desc');
		}
		
		$this->db->where('majors_status', '1');

		$this->db->select("kredit_id, kredit_gaji_id, kredit_kas_noref, kredit_date, kredit_value, IF(kredit_tax_id != 0, tax_number, 0) AS kredit_tax, IF(kredit_item_id != 0, item_name, 'Tidak Ada') as kredit_item, kredit_desc, kredit_account_id, account.account_id, account.account_code, account.account_description, tax_id, item_id, kredit_input_date, kredit_last_update");
		$this->db->select('user_user_id, user_full_name');
		$this->db->select('acc.account_id AS accID, acc.account_code AS accCode, acc.account_description AS accDesc');

		$this->db->join('users', 'users.user_id = kredit.user_user_id', 'left');
		$this->db->join('kas', 'kas.kas_noref = kredit.kredit_kas_noref', 'left');
		$this->db->join('account', 'account.account_id = kredit.kredit_account_id', 'left');
		$this->db->join('account AS acc', 'acc.account_id = kas.kas_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');
        $this->db->join('tax', 'tax.tax_id = kredit.kredit_tax_id', 'left');
        $this->db->join('item', 'item.item_id = kredit.kredit_item_id', 'left');

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
	
	function get_last($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('kredit_id', $param['id']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($param['date'])) {
			$this->db->where('kredit_date', $param['date']);
		}

		if (isset($param['kredit_desc'])) {
			$this->db->like('kredit_desc', $param['kredit_desc']);
		}
        
        if(isset($param['account_majors_id']))
        {
            $this->db->where('account_majors_id', $param['account_majors_id']);
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

        $this->db->where('majors_status', '1');

		$this->db->select("kredit_id, kredit_kas_noref, kredit_date, kredit_value, IF(kredit_tax_id != 0, tax_number, 0) AS kredit_tax, IF(kredit_item_id != 0, item_name, 'Tidak Ada') as kredit_item, kredit_desc, kredit_account_id, account_id, account_code, account_description, tax_id, item_id, kredit_input_date, kredit_last_update");
		$this->db->select('user_user_id, user_full_name');

		$this->db->join('users', 'users.user_id = kredit.user_user_id', 'left');
		$this->db->join('account', 'account.account_id = kredit.kredit_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');
        $this->db->join('tax', 'tax.tax_id = kredit.kredit_tax_id', 'left');
        $this->db->join('item', 'item.item_id = kredit.kredit_item_id', 'left');

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
	
	function get_jurnal($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kredit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kredit_date', $params['date']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($params['kredit_desc'])) {
			$this->db->like('kredit_desc', $params['kredit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $params['account_majors_id']);             
            $this->db->like('kas_noref', 'JK', 'after');
        }
            
        if(isset($params['kas_noref']))
		{            
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
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
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
		    $this->db->order_by('acc.account_id', 'asc');
			$this->db->order_by('kredit_id', 'desc');
		}
		
        $this->db->where('majors_status', '1');

		$this->db->select('kredit_id, kredit_kas_noref, kredit_date, kredit_value, kredit_desc, kredit_account_id, account.account_id, account.account_code, account.account_description, kredit_input_date, kredit_last_update');
		$this->db->select('user_user_id, user_full_name');
		$this->db->select('acc.account_id, acc.account_code, acc.account_description AS accDesc');

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
	
	function get_last_jurnal($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('kredit_id', $param['id']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($param['date'])) {
			$this->db->where('kredit_date', $param['date']);
		}

		if (isset($param['kredit_desc'])) {
			$this->db->like('kredit_desc', $param['kredit_desc']);
		}
		
        if(isset($param['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $param['account_majors_id']);             
            $this->db->like('kas_noref', 'JK', 'after');
        }
            
        if(isset($param['kas_noref']))
		{          
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
			$this->db->where('kredit_date <', $param['date_start'] . ' 00:00:00');
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

        $this->db->where('majors_status', '1');

		$this->db->select('kredit_id, kredit_kas_noref, kredit_date, kredit_value, kredit_desc, kredit_account_id, account.account_id, account.account_code, account.account_description, kredit_input_date, kredit_last_update');
		$this->db->select('user_user_id, user_full_name');

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
	
	function gaji_jurnal($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kredit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kredit_date', $params['date']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($params['kredit_desc'])) {
			$this->db->like('kredit_desc', $params['kredit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $params['account_majors_id']);
            $this->db->like('kas_noref', 'GK', 'after');
        }
            
        if(isset($params['kas_noref']))
		{           
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
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
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
		    $this->db->order_by('acc.account_id', 'asc');
			$this->db->order_by('kredit_id', 'desc');
		}
		
        $this->db->where('majors_status', '1');

		$this->db->select('kredit_id, kredit_kas_noref, kredit_date, kredit_value, kredit_desc, kredit_account_id, account.account_id, account.account_code, account.account_description, kredit_input_date, kredit_last_update');
		$this->db->select('user_user_id, user_full_name');
		$this->db->select('acc.account_id, acc.account_code, acc.account_description AS accDesc');

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
	
	function gaji_last_jurnal($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('kredit_id', $param['id']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($param['date'])) {
			$this->db->where('kredit_date', $param['date']);
		}

		if (isset($param['kredit_desc'])) {
			$this->db->like('kredit_desc', $param['kredit_desc']);
		}
		
        if(isset($param['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $param['account_majors_id']);            
            $this->db->like('kas_noref', 'GK', 'after');
        }
            
        if(isset($param['kas_noref']))
		{             
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
			$this->db->where('kredit_date <', $param['date_start'] . ' 00:00:00');
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

        $this->db->where('majors_status', '1');

		$this->db->select('kredit_id, kredit_kas_noref, kredit_date, kredit_value, kredit_desc, kredit_account_id, account.account_id, account.account_code, account.account_description, kredit_input_date, kredit_last_update');
		$this->db->select('user_user_id, user_full_name');

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
	
	function get_kas($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kredit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kredit_date', $params['date']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($params['kredit_desc'])) {
			$this->db->like('kredit_desc', $params['kredit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $params['account_majors_id']);             
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
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
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
		    $this->db->order_by('account_id', 'asc');
			$this->db->order_by('kredit_id', 'desc');
		}
		
        $this->db->where('majors_status', '1');

		$this->db->select('kredit_id, kredit_kas_noref, kredit_date, kredit_value, kredit_desc, kredit_account_id, account.account_id, account.account_code, account.account_description, kredit_input_date, kredit_last_update');
		$this->db->select('user_user_id, user_full_name');

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
	
	function get_last_kas($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('kredit_id', $param['id']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($param['date'])) {
			$this->db->where('kredit_date', $param['date']);
		}

		if (isset($param['kredit_desc'])) {
			$this->db->like('kredit_desc', $param['kredit_desc']);
		}
		
        if(isset($param['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $param['account_majors_id']);             
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

        $this->db->where('majors_status', '1');

		$this->db->select('kredit_id, kredit_kas_noref, kredit_date, kredit_value, kredit_desc, kredit_account_id, account.account_id, account.account_code, account.account_description, kredit_input_date, kredit_last_update');
		$this->db->select('user_user_id, user_full_name');

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
	
	function gaji_kas($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kredit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kredit_date', $params['date']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($params['kredit_desc'])) {
			$this->db->like('kredit_desc', $params['kredit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $params['account_majors_id']);
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
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
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
		    $this->db->order_by('account_id', 'asc');
			$this->db->order_by('kredit_id', 'desc');
		}
		
        $this->db->where('majors_status', '1');

		$this->db->select('kredit_id, kredit_kas_noref, kredit_date, kredit_value, kredit_desc, kredit_account_id, account.account_id, account.account_code, account.account_description, kredit_input_date, kredit_last_update');
		$this->db->select('user_user_id, user_full_name');

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
	
	function gaji_last_kas($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('kredit_id', $param['id']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($param['date'])) {
			$this->db->where('kredit_date', $param['date']);
		}

		if (isset($param['kredit_desc'])) {
			$this->db->like('kredit_desc', $param['kredit_desc']);
		}
		
        if(isset($param['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $param['account_majors_id']);            
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

        $this->db->where('majors_status', '1');

		$this->db->select('kredit_id, kredit_kas_noref, kredit_date, kredit_value, kredit_desc, kredit_account_id, account.account_id, account.account_code, account.account_description, kredit_input_date, kredit_last_update');
		$this->db->select('user_user_id, user_full_name');

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
	
	function get_bank($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kredit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kredit_date', $params['date']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($params['kredit_desc'])) {
			$this->db->like('kredit_desc', $params['kredit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $params['account_majors_id']);             
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
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
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
		    $this->db->order_by('account_id', 'asc');
			$this->db->order_by('kredit_id', 'desc');
		}
		
        $this->db->where('majors_status', '1');

		$this->db->select('kredit_id, kredit_kas_noref, kredit_date, kredit_value, kredit_desc, kredit_account_id, account.account_id, account.account_code, account.account_description, kredit_input_date, kredit_last_update');
		$this->db->select('user_user_id, user_full_name');
        
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
	
	function get_last_bank($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('kredit_id', $param['id']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($param['date'])) {
			$this->db->where('kredit_date', $param['date']);
		}

		if (isset($param['kredit_desc'])) {
			$this->db->like('kredit_desc', $param['kredit_desc']);
		}
		
        if(isset($param['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $param['account_majors_id']);             
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

        $this->db->where('majors_status', '1');

		$this->db->select('kredit_id, kredit_kas_noref, kredit_date, kredit_value, kredit_desc, kredit_account_id, account.account_id, account.account_code, account.account_description, kredit_input_date, kredit_last_update');
		$this->db->select('user_user_id, user_full_name');
        
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
	
	function gaji_bank($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kredit_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kredit_date', $params['date']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($params['kredit_desc'])) {
			$this->db->like('kredit_desc', $params['kredit_desc']);
		}
        
        if(isset($params['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $params['account_majors_id']);             
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
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
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
		    $this->db->order_by('account_id', 'asc');
			$this->db->order_by('kredit_id', 'desc');
		}
		
        $this->db->where('majors_status', '1');

		$this->db->select('kredit_id, kredit_kas_noref, kredit_date, kredit_value, kredit_desc, kredit_account_id, account.account_id, account.account_code, account.account_description, kredit_input_date, kredit_last_update');
		$this->db->select('user_user_id, user_full_name');
        
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
	
	function gaji_last_bank($param = array())
	{
		if(isset($param['id']))
		{
			$this->db->where('kredit_id', $param['id']);
		}

		if (isset($params['noref'])) {
			$this->db->where('kredit_kas_noref', $params['noref']);
		}

		if (isset($param['date'])) {
			$this->db->where('kredit_date', $param['date']);
		}

		if (isset($param['kredit_desc'])) {
			$this->db->like('kredit_desc', $param['kredit_desc']);
		}
		
        if(isset($param['account_majors_id']))
        {
            $this->db->like('acc.account_majors_id', $param['account_majors_id']);             
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

        $this->db->where('majors_status', '1');

		$this->db->select('kredit_id, kredit_kas_noref, kredit_date, kredit_value, kredit_desc, kredit_account_id, account.account_id, account.account_code, account.account_description, kredit_input_date, kredit_last_update');
		$this->db->select('user_user_id, user_full_name');
        
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

    // Add and update to database
	function add($data = array()) {

		if(isset($data['kredit_id'])) {
			$this->db->set('kredit_id', $data['kredit_id']);
		}

		if(isset($data['kredit_date'])) {
			$this->db->set('kredit_date', $data['kredit_date']);
		}

		if(isset($data['kredit_value'])) {
			$this->db->set('kredit_value', $data['kredit_value']);
		}

		if(isset($data['kredit_kas_account_id'])) {
			$this->db->set('kredit_kas_account_id', $data['kredit_kas_account_id']);
		}

		if(isset($data['kredit_kas_noref'])) {
			$this->db->set('kredit_kas_noref', $data['kredit_kas_noref']);
		}

		if(isset($data['kredit_desc'])) {
			$this->db->set('kredit_desc', $data['kredit_desc']);
		}

		if(isset($data['kredit_account_id'])) {
			$this->db->set('kredit_account_id', $data['kredit_account_id']);
		}

		if(isset($data['kredit_tax_id'])) {
			$this->db->set('kredit_tax_id', $data['kredit_tax_id']);
		}

		if(isset($data['kredit_item_id'])) {
			$this->db->set('kredit_item_id', $data['kredit_item_id']);
		}

		if(isset($data['kredit_gaji_id'])) {
			$this->db->set('kredit_gaji_id', $data['kredit_gaji_id']);
		}

		if(isset($data['user_user_id'])) {
			$this->db->set('user_user_id', $data['user_user_id']);
		}

		if(isset($data['kredit_input_date'])) {
			$this->db->set('kredit_input_date', $data['kredit_input_date']);
		}

		if(isset($data['kredit_last_update'])) {
			$this->db->set('kredit_last_update', $data['kredit_last_update']);
		}

		if (isset($data['kredit_id'])) {
			$this->db->where('kredit_id', $data['kredit_id']);
			$this->db->update('kredit');
			$id = $data['kredit_id'];
		} else {
			$this->db->insert('kredit');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Delete kredit to database
	function delete($id) {
		$this->db->where('kredit_id', $id);
		$this->db->delete('kredit');
	}
	
	
	function get_bcode($kas=array()){
        
        if(isset($kas['noref'])){
            $this->db->where('kas_noref', $kas['noref']);
        }
        
        $this->db->select('kas_noref, kas_date, account_code, account_description');

        $this->db->join('account', 'account.account_id = kas.kas_account_id');

        $res = $this->db->get('kas');
        
        return $res->row_array();
        
    }
    
    function get_sum($params=array()){
        
        if(isset($params['noref'])){
            $this->db->where('kredit_kas_noref', $params['noref']);
        }
        
        $this->db->select('kredit_kas_noref, kredit_date, SUM(kredit_value) AS total, account_code, account_description, majors_name, majors_short_name');

        $this->db->join('account', 'account.account_id = kredit.kredit_account_id');
        $this->db->join('majors', 'account.account_majors_id = majors.majors_id');

        $res = $this->db->get('kredit');
        
        return $res->row_array();
        
    }

}

/* End of file kredit_model.php */
/* Location: ./application/modules/jurnal/models/kredit_model.php */