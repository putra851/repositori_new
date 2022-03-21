<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bayarhutang_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('banking_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('banking_period_id', $params['period_id']);
		}

		if (isset($params['date'])) {
			$this->db->where('banking_date', $params['date']);
		}

		if (isset($params['code'])) {
			$this->db->where('banking_code', $params['code']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('banking_student_id', $params['student_id']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }
		
		if(isset($params['order_by'])){
		    $this->db->order_by('banking_id', $params['order_by']);
		}else{
		    $this->db->order_by('banking_id', 'asc');
		}
		
        $this->db->where('majors_status', '1');

		$this->db->select('banking_id, banking_period_id, banking_date, banking_debit, banking_kredit, banking_code, banking_note');
		
		$this->db->join('student', 'student.student_id = banking.banking_student_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');

		$res = $this->db->get('banking');

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

		if(isset($data['banking_id'])) {
			$this->db->set('banking_id', $data['banking_id']);
		}

		if(isset($data['banking_date'])) {
			$this->db->set('banking_date', $data['banking_date']);
		}

		if(isset($data['banking_period_id'])) {
			$this->db->set('banking_period_id', $data['banking_period_id']);
		}

		if(isset($data['banking_debit'])) {
			$this->db->set('banking_debit', $data['banking_debit']);
		}

		if(isset($data['banking_kredit'])) {
			$this->db->set('banking_kredit', $data['banking_kredit']);
		}

		if(isset($data['banking_code'])) {
			$this->db->set('banking_code', $data['banking_code']);
		}

		if(isset($data['banking_note'])) {
			$this->db->set('banking_note', $data['banking_note']);
		}

		if(isset($data['banking_student_id'])) {
			$this->db->set('banking_student_id', $data['banking_student_id']);
		}

		if(isset($data['user_user_id'])) {
			$this->db->set('user_user_id', $data['user_user_id']);
		}

		if (isset($data['banking_id'])) {
			$this->db->where('banking_id', $data['banking_id']);
			$this->db->update('banking');
			$id = $data['banking_id'];
		} else {
			$this->db->insert('banking');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Delete banking to database
	function delete($id) {
		$this->db->where('banking_id', $id);
		$this->db->delete('banking');
	}
	
	function get_sum(){
	    if(isset($params['id']))
		{
			$this->db->where('banking_id', $params['id']);
		}

		if (isset($params['date'])) {
			$this->db->where('banking_date', $params['date']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('banking_period', $params['period_id']);
		}

		if (isset($params['code'])) {
			$this->db->where('banking_code', $params['code']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('banking_student_id', $params['student_id']);
		}

		if (isset($params['class_id'])) {
			$this->db->where('class_class_id', $params['class_id']);
		}

		if (isset($params['majors_id'])) {
			$this->db->where('majors_majors_id', $params['majors_id']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }
        
        $this->db->group_by('banking_student_id');
		
		if(isset($params['order_by'])){
		    $this->db->order_by('banking_id', $params['order_by']);
		}else{
		    $this->db->order_by('banking_id', 'asc');
		}
		
        $this->db->where('majors_status', '1');
        
        $this->db->select('student_id, student_full_name, student_nis');
        $this->db->select('class_id, class_name');
        $this->db->select('majors_id, majors_short_name, majors_name');
		$this->db->select('SUM(banking_debit) AS debit, SUM(banking_kredit) AS kredit, (SUM(banking_debit)-SUM(banking_kredit)) AS saldo');
		
		$this->db->join('student', 'student.student_id = banking.banking_student_id', 'left');
		
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');

		$res = $this->db->get('banking');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

}
