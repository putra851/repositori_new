<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lesson_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('lesson_id', $params['id']);
        }

        if(isset($params['lesson_code']))
        {
            $this->db->where('lesson_code', $params['lesson_code']);
        }

        if(isset($params['lesson_name']))
        {
            $this->db->where('lesson_name', $params['lesson_name']);
        }

        if(isset($params['lesson_teacher']))
        {
            $this->db->where('lesson_teacher', $params['lesson_teacher']);
        }

        if(isset($params['majors_id']))
        {
            $this->db->where('lesson_majors_id', $params['majors_id']);
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
            $this->db->order_by('lesson.lesson_name', 'asc');
        }
        
        $this->db->select('lesson_id, lesson_name, lesson_code, lesson_teacher, lesson_majors_id, employee_name, majors_short_name, majors_name');
        
        $this->db->join('employee', 'employee.employee_id = lesson.lesson_teacher', 'left');
        $this->db->join('majors', 'majors.majors_id = lesson.lesson_majors_id', 'left');
        
        $res = $this->db->get('lesson');

        if(isset($params['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }

    function add($data = array()) {

        if (isset($data['lesson_id'])) {
            $this->db->set('lesson_id', $data['lesson_id']);
        }

        if (isset($data['lesson_code'])) {
            $this->db->set('lesson_code', $data['lesson_code']);
        }

        if (isset($data['lesson_name'])) {
            $this->db->set('lesson_name', $data['lesson_name']);
        }

        if (isset($data['lesson_teacher'])) {
            $this->db->set('lesson_teacher', $data['lesson_teacher']);
        }

        if (isset($data['lesson_majors_id'])) {
            $this->db->set('lesson_majors_id', $data['lesson_majors_id']);
        }

        if (isset($data['lesson_id'])) {
            $this->db->where('lesson_id', $data['lesson_id']);
            $this->db->update('lesson');
            $id = $data['lesson_id'];
        } else {
            $this->db->insert('lesson');
            $id = $this->db->insert_id(); 
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function delete($id) {
        $this->db->where('lesson_id', $id);
        $this->db->delete('lesson');
    }
    
}    