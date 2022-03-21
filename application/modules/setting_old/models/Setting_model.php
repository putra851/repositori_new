<?php

if (!defined('BASEPATH'))
    exit('No direct script are allowed');

class Setting_model extends CI_Model {

    public function get($param = array()) {

        if (isset($param['id'])) {
            $this->db->where('setting_id', $param['id']);
        }
        
        if (isset($param['setting_school'])) {
            $this->db->where('setting_school', $param['setting_school']);
        }

        if (isset($param['setting_logo'])) {
            $this->db->where('setting_logo', $param['setting_logo']);
        }

        if (isset($param['id']) OR isset($param['setting_school'])) {
            return $this->db->get('setting')->row_array();
        } else {
            return $this->db->get('setting')->result_array();
        }
    }

    public function get_value($params = array()) {
        $setting = $this->get($params);

        if (!empty($setting['setting_value']))
            return $setting['setting_value'];
        else
            return '';
    }

    public function save($param = array()) {
        if (isset($param['setting_school'])) {
            $this->db->set('setting_value', $param['setting_school']);
            $this->db->where('setting_id', 1);
            $this->db->update('setting');
        }
        if (isset($param['setting_address'])) {
            $this->db->set('setting_value', $param['setting_address']);
            $this->db->where('setting_id', 2);
            $this->db->update('setting');
        }
        if (isset($param['setting_phone'])) {
            $this->db->set('setting_value', $param['setting_phone']);
            $this->db->where('setting_id', 3);
            $this->db->update('setting');
        }

        if (isset($param['setting_district'])) {
            $this->db->set('setting_value', $param['setting_district']);
            $this->db->where('setting_id', 4);
            $this->db->update('setting');
        }

        if (isset($param['setting_city'])) {
            $this->db->set('setting_value', $param['setting_city']);
            $this->db->where('setting_id', 5);
            $this->db->update('setting');
        }

        if (isset($param['setting_logo'])) {
            $this->db->set('setting_value', $param['setting_logo']);
            $this->db->where('setting_id', 6);
            $this->db->update('setting');
        }

        if (isset($param['setting_level'])) {
            $this->db->set('setting_value', $param['setting_level']);
            $this->db->where('setting_id', 7);
            $this->db->update('setting');
        }

        if (isset($param['setting_user_sms'])) {
            $this->db->set('setting_value', $param['setting_user_sms']);
            $this->db->where('setting_id', 8);
            $this->db->update('setting');
        }

        if (isset($param['setting_pass_sms'])) {
            $this->db->set('setting_value', $param['setting_pass_sms']);
            $this->db->where('setting_id', 9);
            $this->db->update('setting');
        }

        if (isset($param['setting_sms'])) {
            $this->db->set('setting_value', $param['setting_sms']);
            $this->db->where('setting_id', 10);
            $this->db->update('setting');
        }
        
        if (isset($param['setting_nip_kepsek'])) {
            $this->db->set('setting_value', $param['setting_nip_kepsek']);
            $this->db->where('setting_id', 11);
            $this->db->update('setting');
        }
        
        if (isset($param['setting_nama_kepsek'])) {
            $this->db->set('setting_value', $param['setting_nama_kepsek']);
            $this->db->where('setting_id', 12);
            $this->db->update('setting');
        }
        
        if (isset($param['setting_nip_katu'])) {
            $this->db->set('setting_value', $param['setting_nip_katu']);
            $this->db->where('setting_id', 13);
            $this->db->update('setting');
        }
        
        if (isset($param['setting_nama_katu'])) {
            $this->db->set('setting_value', $param['setting_nama_katu']);
            $this->db->where('setting_id', 14);
            $this->db->update('setting');
        }
        
        if (isset($param['setting_nip_bendahara'])) {
            $this->db->set('setting_value', $param['setting_nip_bendahara']);
            $this->db->where('setting_id', 15);
            $this->db->update('setting');
        }
        
        if (isset($param['setting_nama_bendahara'])) {
            $this->db->set('setting_value', $param['setting_nama_bendahara']);
            $this->db->where('setting_id', 16);
            $this->db->update('setting');
        }

        if (isset($param['setting_aktivasi'])) {
            $this->db->set('setting_value', $param['setting_aktivasi']);
            $this->db->where('setting_id', 33);
            $this->db->update('setting');
        }

    }

}
