<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Schedule_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('schedule_id', $params['id']);
        }

        if(isset($params['schedule_class_id']))
        {
            $this->db->where('schedule_class_id', $params['schedule_class_id']);
        }

        if(isset($params['schedule_lesson_id']))
        {
            $this->db->where('schedule_lesson_id', $params['schedule_lesson_id']);
        }

        if(isset($params['schedule_day']))
        {
            $this->db->where('schedule_day', $params['schedule_day']);
        }

        if(isset($params['schedule_time']))
        {
            $this->db->where('schedule_time', $params['schedule_time']);
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
            $this->db->order_by('schedule.schedule_class_id', 'asc');
            $this->db->order_by('schedule.schedule_day', 'asc');
            $this->db->order_by('schedule.schedule_time', 'asc');
        }
        
        $this->db->select('schedule_id, schedule_class_id,  schedule_lesson_id, schedule_day,  schedule_time');
        $this->db->select('class_name');
        $this->db->select('lesson_name');
        $this->db->select('majors_name, majors_short_name, majors_id');
        
        $this->db->join('class', 'class.class_id = schedule.schedule_class_id');
        $this->db->join('lesson', 'lesson.lesson_id = schedule.schedule_lesson_id');
        $this->db->join('majors', 'majors.majors_id = class.majors_majors_id');
        
        $res = $this->db->get('schedule');

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

        if (isset($data['schedule_id'])) {
            $this->db->set('schedule_id', $data['schedule_id']);
        }

        if (isset($data['schedule_class_id'])) {
            $this->db->set('schedule_class_id', $data['schedule_class_id']);
        }

        if (isset($data['schedule_lesson_id'])) {
            $this->db->set('schedule_lesson_id', $data['schedule_lesson_id']);
        }

        if (isset($data['schedule_day'])) {
            $this->db->set('schedule_day', $data['schedule_day']);
        }

        if (isset($data['schedule_time'])) {
            $this->db->set('schedule_time', $data['schedule_time']);
        }

        if (isset($data['schedule_id'])) {
            $this->db->where('schedule_id', $data['schedule_id']);
            $this->db->update('schedule');
            $id = $data['schedule_id'];
        } else {
            $this->db->insert('schedule');
            $id = $this->db->insert_id(); 
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function delete($id) {
        $this->db->where('schedule_id', $id);
        $this->db->delete('schedule');
    }
    
}    