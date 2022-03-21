<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visit_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('guest_list_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('guest_list_period_id', $params['period_id']);
		}

		if (isset($params['date'])) {
			$this->db->where('guest_list_date', $params['date']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('guest_list_student_id', $params['student_id']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }
		
		if(isset($params['order_by'])){
		    $this->db->order_by($params['order_by'], 'desc');
		}else{
		    $this->db->order_by('guest_list_id', 'desc');
		}
        $this->db->where('majors_status', '1');

		$this->db->select('guest_list_id, guest_list_code, guest_list_period_id, guest_list_date, guest_list_time');
		
		$this->db->join('student', 'student.student_id = guest_list.guest_list_student_id', 'left');
		
		$this->db->join('period', 'period.period_id = guest_list.guest_list_period_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
		
        $this->db->join('users', 'users.user_id = guest_list.guest_list_user_id', 'left');

		$res = $this->db->get('guest_list');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

	function get_tamu($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('list_tamu_id', $params['id']);
		}

		if (isset($params['list_tamu_kode'])) {
			$this->db->where('list_tamu_kode', $params['list_tamu_kode']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }
		
		if(isset($params['order_by'])){
		    $this->db->order_by($params['order_by'], 'desc');
		}else{
		    $this->db->order_by('list_tamu_id', 'ASC');
		}
        $this->db->where('majors_status', '1');

		$this->db->select('list_tamu_id, list_tamu_kode, guest_id, guest_name, mahram_id, mahram_note');
		
		$this->db->join('guest_list', 'guest_list.guest_list_code = list_tamu.list_tamu_kode', 'left');
		
		$this->db->join('guest', 'guest.guest_id = list_tamu.list_tamu_guest_id', 'left');
		
		$this->db->join('mahram', 'mahram.mahram_id = guest.guest_mahram_id', 'left');
		
		$this->db->join('student', 'student.student_id = guest_list.guest_list_student_id', 'left');
		
		$this->db->join('period', 'period.period_id = guest_list.guest_list_period_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
		
        $this->db->join('users', 'users.user_id = guest_list.guest_list_user_id', 'left');

		$res = $this->db->get('list_tamu');

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

		if(isset($data['guest_list_id'])) {
			$this->db->set('guest_list_id', $data['guest_list_id']);
		}

		if(isset($data['guest_list_date'])) {
			$this->db->set('guest_list_date', $data['guest_list_date']);
		}

		if(isset($data['guest_list_code'])) {
			$this->db->set('guest_list_code', $data['guest_list_code']);
		}

		if(isset($data['guest_list_period_id'])) {
			$this->db->set('guest_list_period_id', $data['guest_list_period_id']);
		}

		if(isset($data['guest_list_time'])) {
			$this->db->set('guest_list_time', $data['guest_list_time']);
		}

		if(isset($data['guest_list_student_id'])) {
			$this->db->set('guest_list_student_id', $data['guest_list_student_id']);
		}

		if(isset($data['guest_list_user_id'])) {
			$this->db->set('guest_list_user_id', $data['guest_list_user_id']);
		}

		if (isset($data['guest_list_id'])) {
			$this->db->where('guest_list_id', $data['guest_list_id']);
			$this->db->update('guest_list');
			$id = $data['guest_list_id'];
		} else {
			$this->db->insert('guest_list');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Add and update to database
	function add_tamu($data = array()) {

		if(isset($data['list_tamu_id'])) {
			$this->db->set('list_tamu_id', $data['list_tamu_id']);
		}

		if(isset($data['list_tamu_kode'])) {
			$this->db->set('list_tamu_kode', $data['list_tamu_kode']);
		}

		if(isset($data['list_tamu_guest_id'])) {
			$this->db->set('list_tamu_guest_id', $data['list_tamu_guest_id']);
		}

		if (isset($data['list_tamu_id'])) {
			$this->db->where('list_tamu_id', $data['list_tamu_id']);
			$this->db->update('list_tamu');
			$id = $data['list_tamu_id'];
		} else {
			$this->db->insert('list_tamu');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Delete guest_list to database
	function delete($id) {
		$this->db->where('guest_list_id', $id);
		$this->db->delete('guest_list');
	}
	
	function get_sum($params = array()){
	    if(isset($params['id']))
		{
			$this->db->where('guest_list_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('guest_list_period_id', $params['period_id']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('guest_list_student_id', $params['student_id']);
		}
        
        $this->db->group_by('guest_list_student_id');
		
        $this->db->where('majors_status', '1');
        
        $this->db->select('student_id, student_full_name, student_nis');
        $this->db->select('class_id, class_name');
        $this->db->select('majors_id, majors_short_name, majors_name');
        $this->db->select('period_id');
		$this->db->select('COUNT(guest_list_id) AS guestlistSum');
		
		$this->db->join('student', 'student.student_id = guest_list.guest_list_student_id', 'left');
		
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
		
        $this->db->join('period', 'period.period_id = guest_list.guest_list_period_id', 'left');

		$res = $this->db->get('guest_list');

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
