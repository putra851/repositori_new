<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahfidz_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('tahfidz_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('tahfidz_period_id', $params['period_id']);
		}

		if (isset($params['date'])) {
			$this->db->where('tahfidz_date', $params['date']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('tahfidz_student_id', $params['student_id']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }
		
		if(isset($params['order_by'])){
		    $this->db->order_by($params['order_by'], 'desc');
		}else{
		    $this->db->order_by('tahfidz_id', 'desc');
		}
        $this->db->where('majors_status', '1');

		$this->db->select('tahfidz_id, tahfidz_period_id, tahfidz_date, tahfidz_new, tahfidz_new_note, tahfidz_murojaah, tahfidz_murojaah_note');
		
		$this->db->join('student', 'student.student_id = tahfidz.tahfidz_student_id', 'left');
		
		$this->db->join('period', 'period.period_id = tahfidz.tahfidz_period_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
		
        $this->db->join('users', 'users.user_id = tahfidz.tahfidz_user_id', 'left');

		$res = $this->db->get('tahfidz');

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

		if(isset($data['tahfidz_id'])) {
			$this->db->set('tahfidz_id', $data['tahfidz_id']);
		}

		if(isset($data['tahfidz_date'])) {
			$this->db->set('tahfidz_date', $data['tahfidz_date']);
		}

		if(isset($data['tahfidz_period_id'])) {
			$this->db->set('tahfidz_period_id', $data['tahfidz_period_id']);
		}

		if(isset($data['tahfidz_new'])) {
			$this->db->set('tahfidz_new', $data['tahfidz_new']);
		}

		if(isset($data['tahfidz_new_note'])) {
			$this->db->set('tahfidz_new_note', $data['tahfidz_new_note']);
		}

		if(isset($data['tahfidz_murojaah'])) {
			$this->db->set('tahfidz_murojaah', $data['tahfidz_murojaah']);
		}

		if(isset($data['tahfidz_murojaah_note'])) {
			$this->db->set('tahfidz_murojaah_note', $data['tahfidz_murojaah_note']);
		}

		if(isset($data['tahfidz_student_id'])) {
			$this->db->set('tahfidz_student_id', $data['tahfidz_student_id']);
		}

		if(isset($data['tahfidz_user_id'])) {
			$this->db->set('tahfidz_user_id', $data['tahfidz_user_id']);
		}

		if (isset($data['tahfidz_id'])) {
			$this->db->where('tahfidz_id', $data['tahfidz_id']);
			$this->db->update('tahfidz');
			$id = $data['tahfidz_id'];
		} else {
			$this->db->insert('tahfidz');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Delete tahfidz to database
	function delete($id) {
		$this->db->where('tahfidz_id', $id);
		$this->db->delete('tahfidz');
	}
	
	function get_sum($params = array()){
	    if(isset($params['id']))
		{
			$this->db->where('tahfidz_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('tahfidz_period_id', $params['period_id']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('tahfidz_student_id', $params['student_id']);
		}
        
        $this->db->group_by('tahfidz_student_id');
		
        $this->db->where('majors_status', '1');
        
        $this->db->select('student_id, student_full_name, student_nis');
        $this->db->select('class_id, class_name');
        $this->db->select('period_id');
        $this->db->select('majors_id, majors_short_name, majors_name');
		$this->db->select('SUM(tahfidz_new) AS tahfidzSum');
		
		$this->db->join('student', 'student.student_id = tahfidz.tahfidz_student_id', 'left');
		
		$this->db->join('period', 'period.period_id = tahfidz.tahfidz_period_id', 'left');
		
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');

		$res = $this->db->get('tahfidz');

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
