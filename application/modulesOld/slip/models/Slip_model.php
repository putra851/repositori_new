<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slip_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function get_noref($like, $id_majors){
        
        $query = $this->db->query("SELECT MAX(RIGHT(kas_noref,2)) AS no_max FROM kas WHERE DATE(kas_input_date)=CURDATE() AND kas_majors_id = '$id_majors' AND kas_noref LIKE '$like%' AND kas_category = '2'")->row();
        
        if (count($query)>0){
            $tmp = ((int)$query->no_max)+1;
            $noref = sprintf("%02s", $tmp);
        } else {
            $noref = "01";
        }
        
        return date('dmy').$noref;
    }
    
    function get_bcode($kas=array()){
        
        if(isset($kas['date'])){
            $this->db->where('kas_date', $kas['date']);
        }
        
        if(isset($kas['noref'])){
            $this->db->where('kas_date', $kas['date']);
        }
        
        $this->db->select('kas_noref, kas_date, account_code, account_description');

        $this->db->join('account', 'account.account_id = kas.kas_account_id', 'left');

        $res = $this->db->get('kas');
        
        return $res->row_array();
        
    }

    function get_print($id){
        
        $this->db->where('gaji.gaji_id', $id);
        
        $this->db->where('majors_status', '1');

        $this->db->select('employee.employee_id, employee_nip, employee_name, employee_strata, employee_category, employee_start, employee_end');
        $this->db->select('position.position_majors_id, majors.majors_id, majors.majors_name, majors_short_name, majors_status');
        $this->db->select('employee.employee_position_id, position.position_id, position.position_code, position_name, majors_status');
        
        $this->db->select('akun.akun_employee_id, akun.akun_id, akun.akun_account_id');
        
		$this->db->select('gaji_id, gaji_period_id, gaji_month_id, gaji_pokok, gaji_potongan, gaji_jumlah, gaji_tanggal');
		
        $this->db->select('subsatu_id, subsatu.subsatu_gaji_id, subsatu_pokok, subsatu_lain');
        $this->db->select('subtiga_id, subtiga.subtiga_gaji_id, subtiga_simpanan, subtiga_bpjstk, subtiga_sumbangan, subtiga_koperasi, subtiga_bpjs, subtiga_pinjaman, subtiga_lain');
        
        $this->db->select('account_description');
        $this->db->select('month_id, month_name');
		$this->db->select('period_id, period_start, period_end');
        $this->db->select('kredit_gaji_id, kredit_kas_noref');
        
        $this->db->join('position', 'position.position_id = employee.employee_position_id', 'left');
        $this->db->join('majors', 'majors.majors_id = employee.employee_majors_id', 'left');
        
        $this->db->join('akun', 'akun.akun_employee_id = employee.employee_id', 'left');
        
        $this->db->join('gaji', 'gaji.gaji_employee_id = employee.employee_id', 'left');
        
        $this->db->join('subsatu', 'subsatu.subsatu_gaji_id = gaji.gaji_id', 'left');
        $this->db->join('subtiga', 'subtiga.subtiga_gaji_id = gaji.gaji_id', 'left');
        
		$this->db->join('month','gaji.gaji_month_id = month.month_id', 'left');
		$this->db->join('period','gaji.gaji_period_id = period.period_id', 'left');
		$this->db->join('kredit','gaji.gaji_id = kredit.kredit_gaji_id', 'left');
		$this->db->join('kas','kredit.kredit_kas_noref = kas.kas_noref', 'left');
		$this->db->join('account','account.account_id = kas.kas_account_id', 'left');

        $res = $this->db->get('employee');
        
        return $res->row_array();
        
    }
    
    
	function get_history($data = array())
	{
		if(isset($data['gaji_month_id'])) {
			$this->db->where('gaji_month_id', $data['gaji_month_id']);
		}

		if(isset($data['gaji_period_id'])) {
			$this->db->where('gaji_period_id', $data['gaji_period_id']);
		}

		if(isset($data['gaji_employee_id'])) {
			$this->db->where('gaji_employee_id', $data['gaji_employee_id']);
		}
		
		$this->db->order_by('period.period_start', 'desc');
		$this->db->order_by('month.month_id', 'desc');
		
		$this->db->select('gaji_id, gaji_period_id, gaji_month_id, gaji_pokok, gaji_potongan, gaji_jumlah, gaji_tanggal');
		$this->db->select('kredit_gaji_id, kredit_kas_noref');
		$this->db->select('month_id, month_name');
		$this->db->select('account_description');
		$this->db->select('period_id, period_start, period_end');
		$this->db->join('month','gaji.gaji_month_id = month.month_id', 'left');
		$this->db->join('period','gaji.gaji_period_id = period.period_id', 'left');
		$this->db->join('kredit','gaji.gaji_id = kredit.kredit_gaji_id', 'left');
		$this->db->join('kas','kredit.kredit_kas_noref = kas.kas_noref', 'left');
		$this->db->join('account','account.account_id = kas.kas_account_id', 'left');
		
		$res = $this->db->get('gaji');

		if(isset($data['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
	
	function delete_history($id, $noref){
		$this->db->where('gaji_id', $id);
		$this->db->delete('gaji');
		$this->db->where('subsatu_gaji_id', $id);
		$this->db->delete('subsatu');
		$this->db->where('subtiga_gaji_id', $id);
		$this->db->delete('subtiga');
		$this->db->where('kredit_gaji_id', $id);
		$this->db->delete('kredit');
		$this->db->where('kas_noref', $noref);
		$this->db->delete('kas');
	}
	
	function add($data = array()) {

		if(isset($data['gaji_id'])) {
			$this->db->set('gaji_id', $data['gaji_id']);
		}

		if(isset($data['gaji_anak'])) {
			$this->db->set('gaji_anak', $data['gaji_anak']);
		}

		if(isset($data['gaji_istri'])) {
			$this->db->set('gaji_istri', $data['gaji_istri']);
		}

		if(isset($data['gaji_mengajar'])) {
			$this->db->set('gaji_mengajar', $data['gaji_mengajar']);
		}

		if(isset($data['gaji_transportasi'])) {
			$this->db->set('gaji_transportasi', $data['gaji_transportasi']);
		}

		if(isset($data['gaji_subpokok'])) {
			$this->db->set('gaji_subpokok', $data['gaji_subpokok']);
		}

		if(isset($data['gaji_persen'])) {
			$this->db->set('gaji_persen', $data['gaji_persen']);
		}

		if(isset($data['gaji_pokok'])) {
			$this->db->set('gaji_pokok', $data['gaji_pokok']);
		}

		if(isset($data['gaji_potongan'])) {
			$this->db->set('gaji_potongan', $data['gaji_potongan']);
		}

		if(isset($data['gaji_jumlah'])) {
			$this->db->set('gaji_jumlah', $data['gaji_jumlah']);
		}

		if(isset($data['gaji_month_id'])) {
			$this->db->set('gaji_month_id', $data['gaji_month_id']);
		}

		if(isset($data['gaji_period_id'])) {
			$this->db->set('gaji_period_id', $data['gaji_period_id']);
		}
		if(isset($data['gaji_employee_id'])) {
			$this->db->set('gaji_employee_id', $data['gaji_employee_id']);
		}

		if(isset($data['gaji_tanggal'])) {
			$this->db->set('gaji_tanggal', $data['gaji_tanggal']);
		}

		if(isset($data['user_user_id'])) {
			$this->db->set('user_user_id', $data['user_user_id']);
		}

		if (isset($data['gaji_id'])) {
			$this->db->where('gaji_id', $data['gaji_id']);
			$this->db->update('gaji');
			$id = $data['gaji_id'];
		} else {
			$this->db->insert('gaji');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}
	
	function set_subsatu($data = array()) {

        if (isset($data['subsatu_gaji_id'])) {
            $this->db->set('subsatu_gaji_id', $data['subsatu_gaji_id']);
        }

        if (isset($data['subsatu_id'])) {
            $this->db->set('subsatu_id', $data['subsatu_id']);
        }

        if (isset($data['subsatu_pokok'])) {
            $this->db->set('subsatu_pokok', $data['subsatu_pokok']);
        }
        
        if (isset($data['subsatu_lain'])) {
            $this->db->set('subsatu_lain', $data['subsatu_lain']);
        }
        
        $this->db->insert('subsatu');
        $id = $this->db->insert_id();

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    function set_subtiga($data = array()) {

        if (isset($data['subtiga_gaji_id'])) {
            $this->db->set('subtiga_gaji_id', $data['subtiga_gaji_id']);
        }

        if (isset($data['subtiga_id'])) {
            $this->db->set('subtiga_id', $data['subtiga_id']);
        }

        if (isset($data['subtiga_simpanan'])) {
            $this->db->set('subtiga_simpanan', $data['subtiga_simpanan']);
        }

        if (isset($data['subtiga_bpjstk'])) {
            $this->db->set('subtiga_bpjstk', $data['subtiga_bpjstk']);
        }
        
        if (isset($data['subtiga_sumbangan'])) {
            $this->db->set('subtiga_sumbangan', $data['subtiga_sumbangan']);
        }
        
        if (isset($data['subtiga_koperasi'])) {
            $this->db->set('subtiga_koperasi', $data['subtiga_koperasi']);
        }

        if (isset($data['subtiga_bpjs'])) {
            $this->db->set('subtiga_bpjs', $data['subtiga_bpjs']);
        }

        if (isset($data['subtiga_pinjaman'])) {
            $this->db->set('subtiga_pinjaman', $data['subtiga_pinjaman']);
        }

        if (isset($data['subtiga_lain'])) {
            $this->db->set('subtiga_lain', $data['subtiga_lain']);
        }
        
        $this->db->insert('subtiga');
        $id = $this->db->insert_id();

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    function save($paramskas){
	    
		$this->db->insert('kas', $paramskas);
		
	}
	
}