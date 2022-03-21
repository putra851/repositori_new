<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kesehatan_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kesehatan_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('kesehatan_period_id', $params['period_id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kesehatan_date', $params['date']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('kesehatan_student_id', $params['student_id']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }
		
		if(isset($params['order_by'])){
		    $this->db->order_by($params['order_by'], 'desc');
		}else{
		    $this->db->order_by('kesehatan_id', 'desc');
		}
        $this->db->where('majors_status', '1');

		$this->db->select('kesehatan_id, kesehatan_period_id, kesehatan_date, kesehatan_ill, kesehatan_cure, kesehatan_note');
		
		$this->db->join('student', 'student.student_id = kesehatan.kesehatan_student_id', 'left');
		
		$this->db->join('period', 'period.period_id = kesehatan.kesehatan_period_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
		
        $this->db->join('users', 'users.user_id = kesehatan.kesehatan_user_id', 'left');

		$res = $this->db->get('kesehatan');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

	function get_report($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kesehatan_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('kesehatan_period_id', $params['period_id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kesehatan_date', $params['date']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('kesehatan_student_id', $params['student_id']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }
		
		if(isset($params['order_by'])){
		    $this->db->order_by($params['order_by'], 'desc');
		}else{
		    $this->db->order_by('kesehatan_id', 'desc');
		}
        $this->db->where('majors_status', '1');

		$this->db->select('*');
		
		$this->db->join('student', 'student.student_id = kesehatan.kesehatan_student_id', 'left');
		
		$this->db->join('class', 'class.class_id = student.class_class_id', 'left');
		
		$this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
		
		$this->db->join('period', 'period.period_id = kesehatan.kesehatan_period_id', 'left');
		
        $this->db->join('users', 'users.user_id = kesehatan.kesehatan_user_id', 'left');

		$res = $this->db->get('kesehatan');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}
	
	function get_detail($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('kesehatan_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('kesehatan_period_id', $params['period_id']);
		}

		if (isset($params['date'])) {
			$this->db->where('kesehatan_date', $params['date']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('kesehatan_student_id', $params['student_id']);
		}

		if (isset($params['kesehatan_id'])) {
			$this->db->where('kesehatan_id', $params['kesehatan_id']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }
		
		if(isset($params['order_by'])){
		    $this->db->order_by($params['order_by'], 'desc');
		}else{
		    $this->db->order_by('kesehatan_id', 'asc');
		}
        $this->db->where('majors_status', '1');

		$this->db->select('kesehatan_id, kesehatan_period_id, kesehatan_date, kesehatan_ill, kesehatan_cure, kesehatan_note');
		
		

		$this->db->select('kesehatan_id, kesehatan_period_id, kesehatan_date, kesehatan_ill, kesehatan_cure, kesehatan_note');
		$this->db->select('student.*, class.*, majors.*, madin.*');
		
		$this->db->join('student', 'student.student_id = kesehatan.kesehatan_student_id', 'left');
		
		$this->db->join('class', 'class.class_id = student.class_class_id', 'left');
		
		$this->db->join('madin', 'madin.madin_id = student.student_madin', 'left');
		
		$this->db->join('period', 'period.period_id = kesehatan.kesehatan_period_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
		
        $this->db->join('users', 'users.user_id = kesehatan.kesehatan_user_id', 'left');

		$res = $this->db->get('kesehatan');

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

		if(isset($data['kesehatan_id'])) {
			$this->db->set('kesehatan_id', $data['kesehatan_id']);
		}

		if(isset($data['kesehatan_date'])) {
			$this->db->set('kesehatan_date', $data['kesehatan_date']);
		}

		if(isset($data['kesehatan_period_id'])) {
			$this->db->set('kesehatan_period_id', $data['kesehatan_period_id']);
		}

		if(isset($data['kesehatan_ill'])) {
			$this->db->set('kesehatan_ill', $data['kesehatan_ill']);
		}

		if(isset($data['kesehatan_cure'])) {
			$this->db->set('kesehatan_cure', $data['kesehatan_cure']);
		}

		if(isset($data['kesehatan_note'])) {
			$this->db->set('kesehatan_note', $data['kesehatan_note']);
		}

		if(isset($data['kesehatan_student_id'])) {
			$this->db->set('kesehatan_student_id', $data['kesehatan_student_id']);
		}

		if(isset($data['kesehatan_user_id'])) {
			$this->db->set('kesehatan_user_id', $data['kesehatan_user_id']);
		}

		if (isset($data['kesehatan_id'])) {
			$this->db->where('kesehatan_id', $data['kesehatan_id']);
			$this->db->update('kesehatan');
			$id = $data['kesehatan_id'];
		} else {
			$this->db->insert('kesehatan');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Delete kesehatan to database
	function delete($id) {
		$this->db->where('kesehatan_id', $id);
		$this->db->delete('kesehatan');
	}
	
	function get_sum($params = array()){
	    if(isset($params['id']))
		{
			$this->db->where('kesehatan_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('kesehatan_period_id', $params['period_id']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('kesehatan_student_id', $params['student_id']);
		}
        
        $this->db->group_by('kesehatan_student_id');
		
        $this->db->where('majors_status', '1');
        
        $this->db->select('student_id, student_full_name, student_nis');
        $this->db->select('class_id, class_name');
        $this->db->select('majors_id, majors_short_name, majors_name');
		$this->db->select('SUM(kesehatan_ill) AS kesehatanSum');
		
		$this->db->join('student', 'student.student_id = kesehatan.kesehatan_student_id', 'left');
		
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');

		$res = $this->db->get('kesehatan');

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
