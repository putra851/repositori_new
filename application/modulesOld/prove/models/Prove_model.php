<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prove_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('prove.prove_id', $params['id']);
        }

        if (isset($params['student_id'])) {
            $this->db->where('prove.prove_student_id', $params['student_id']);
        }

        if (isset($params['status'])) {
            $this->db->where('student.student_status', $params['status']);
        } else {
            $this->db->where('student.student_status', '1');
        }

        if (isset($params['class_id'])) {
            $this->db->where('class_class_id', $params['class_id']);
        }

        if (isset($params['majors_id'])) {
            $this->db->where('student.majors_majors_id', $params['majors_id']);
        }
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }

        if(isset($params['group']))
        {

            $this->db->group_by('student.class_class_id'); 

        }


        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('prove_date', 'desc');
        }
        
        $this->db->where('majors_status', '1');

        $this->db->select('prove.prove_id, prove.prove_date, prove.prove_img, prove.prove_note, prove.prove_status');
        $this->db->select('student.student_id, student_nis, student_nisn, student_password, student_gender, student_parent_phone, student_full_name, student_img');
        $this->db->select('class.class_id, student.class_class_id, class.class_name, class.majors_majors_id');
        $this->db->select('student.majors_majors_id, majors_id, majors_name, majors_short_name, majors_school_name, majors_status');
        
        $this->db->join('student', 'student.student_id = prove.prove_student_id');
        $this->db->join('class', 'class.class_id = student.class_class_id');
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id');

        $res = $this->db->get('prove');

        if (isset($params['id'])) {
            return $res->row_array();
        } else if (isset($params['student_nis'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }

    }
    
    
    function get_student($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('prove.prove_id', $params['id']);
        }

        if (isset($params['student_id'])) {
            $this->db->where('prove.prove_student_id', $params['student_id']);
        }

        if (isset($params['status'])) {
            $this->db->where('student.student_status', $params['status']);
        } else {
            $this->db->where('student.student_status', '1');
        }

        if (isset($params['class_id'])) {
            $this->db->where('class_class_id', $params['class_id']);
        }

        if (isset($params['majors_id'])) {
            $this->db->where('student.majors_majors_id', $params['majors_id']);
        }

        if(isset($params['group']))
        {

            $this->db->group_by('student.class_class_id'); 

        }


        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('prove_date', 'desc');
        }
        
        $this->db->where('majors_status', '1');

        $this->db->select('prove.prove_id, prove.prove_date, prove.prove_img, prove.prove_note, prove.prove_status');
        $this->db->select('student.student_id, student_nis, student_nisn, student_password, student_gender, student_parent_phone, student_full_name, student_img');
        $this->db->select('class.class_id, student.class_class_id, class.class_name, class.majors_majors_id');
        $this->db->select('student.majors_majors_id, majors_id, majors_name, majors_short_name, majors_school_name, majors_status');
        
        $this->db->join('student', 'student.student_id = prove.prove_student_id');
        $this->db->join('class', 'class.class_id = student.class_class_id');
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id');

        $res = $this->db->get('prove');

        if (isset($params['id'])) {
            return $res->row_array();
        } else if (isset($params['student_nis'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }

    }

    function add($data = array()) {

        if (isset($data['prove_note'])) {
            $this->db->set('prove_note', $data['prove_note']);
        }

        if (isset($data['prove_date'])) {
            $this->db->set('prove_date', $data['prove_date']);
        }

        if (isset($data['prove_img'])) {
            $this->db->set('prove_img', $data['prove_img']);
        }

        if (isset($data['prove_status'])) {
            $this->db->set('prove_status', $data['prove_status']);
        }

        if (isset($data['prove_student_id'])) {
            $this->db->set('prove_student_id', $data['prove_student_id']);
        }

        if (isset($data['prove_id'])) {
            $this->db->where('prove_id', $data['prove_id']);
            $this->db->update('prove');
            $id = $data['prove_id'];
        } else {
            $this->db->insert('prove');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    public function is_exist($field, $value)
    {
        $this->db->where($field, $value);        

        return $this->db->count_all_results('student') > 0 ? TRUE : FALSE;
    }
}
