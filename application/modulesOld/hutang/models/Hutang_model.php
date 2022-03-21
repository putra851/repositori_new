<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Hutang_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get($params = array())
  {
    if(isset($params['id']))
    {
      $this->db->where('hutang.hutang_id', $params['id']);
    }

    if(isset($params['hutang_employee_id']))
    {
      $this->db->where('hutang.hutang_employee_id', $params['hutang_employee_id']);
    }
    
    if(isset($params['hutang_noref'])) {
      $this->db->where('hutang_noref', $params['hutang_noref']);
    }

    if(isset($params['settinghutang_id']))
    {
      $this->db->where('hutang.hutang_settinghutang_id', $params['settinghutang_id']);
    }

    if(isset($params['period_id']))
    {
      $this->db->where('settinghutang.settinghutang_period_id', $params['period_id']);
    }


    if(isset($params['position_id']))
    {
      $this->db->where('employee.employee_position_id', $params['position_id']);
    }

    if(isset($params['majors_id']))
    {
      $this->db->where('account.account_majors_id', $params['majors_id']);
    }

    if(isset($params['hutang_input_date']))
    {
      $this->db->where('hutang_input_date', $params['hutang_input_date']);
    }

    if(isset($params['hutang_last_update']))
    {
      $this->db->where('hutang_last_update', $params['hutang_last_update']);
    }

    if(isset($params['date_start']) AND isset($params['date_end']))
    {
      $this->db->where('hutang_input_date >=', $params['date_start'] . ' 00:00:00');
      $this->db->where('hutang_input_date <=', $params['date_end'] . ' 23:59:59');
    }

    if(isset($params['group']))
    {

      $this->db->group_by('hutang.hutang_employee_id'); 

    }

    if(isset($params['grup']))
    {

      $this->db->group_by('hutang.hutang_settinghutang_id'); 

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
      $this->db->order_by('hutang_last_update', 'desc');
    }
    
    $this->db->select('hutang.hutang_id, hutang_noref, hutang_bill, hutang_input_date, hutang_last_update');

    $this->db->select('hutang_employee_id,  employee.employee_position_id, position_name, employee_id, employee_name, employee_nip, account.account_majors_id, majors_name, majors_short_name');
    $this->db->select('hutang_settinghutang_id, poshutang_name, settinghutang_period_id, period_start, period_end');
    
    $this->db->select('hutang_pay.hutang_pay_id, hutang_pay_bill, hutang_input_date, hutang_last_update');
    
    $this->db->select("COUNT('hutang_pay_id') as hutang_cicil, majors_id");
    
    $this->db->join('employee', 'employee.employee_id = hutang.hutang_employee_id', 'left');
    
    $this->db->join('hutang_pay', 'hutang_pay.hutang_pay_hutang_id = hutang.hutang_id', 'left');

    $this->db->join('settinghutang', 'settinghutang.settinghutang_id = hutang.hutang_settinghutang_id', 'left');
    $this->db->join('poshutang', 'poshutang.poshutang_id = settinghutang.settinghutang_poshutang_id', 'left');
    $this->db->join('position', 'position.position_id = employee.employee_position_id', 'left');
    $this->db->join('period', 'period.period_id = settinghutang.settinghutang_period_id', 'left');
    $this->db->join('account', 'poshutang.poshutang_account_id = account.account_id', 'left');
    $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

    $res = $this->db->get('hutang');

    if(isset($params['id']) || isset($params['hutang_noref']))
    {
      return $res->row_array();
    }
    else
    {
      return $res->result_array();
    }
  }
  
  function get_delete($params = array())
  {
    if(isset($params['id']))
    {
      $this->db->where('hutang.hutang_id', $params['id']);
    }

    if(isset($params['hutang_employee_id']))
    {
      $this->db->where('hutang.hutang_employee_id', $params['hutang_employee_id']);
    }

    if(isset($params['settinghutang_id']))
    {
      $this->db->where('hutang.hutang_settinghutang_id', $params['settinghutang_id']);
    }

    if(isset($params['period_id']))
    {
      $this->db->where('settinghutang.settinghutang_period_id', $params['period_id']);
    }


    if(isset($params['position_id']))
    {
      $this->db->where('employee.employee_position_id', $params['position_id']);
    }

    if(isset($params['majors_id']))
    {
      $this->db->where('account.account_majors_id', $params['majors_id']);
    }

    if(isset($params['hutang_input_date']))
    {
      $this->db->where('hutang_input_date', $params['hutang_input_date']);
    }

    if(isset($params['hutang_last_update']))
    {
      $this->db->where('hutang_last_update', $params['hutang_last_update']);
    }

    if(isset($params['date_start']) AND isset($params['date_end']))
    {
      $this->db->where('hutang_input_date >=', $params['date_start'] . ' 00:00:00');
      $this->db->where('hutang_input_date <=', $params['date_end'] . ' 23:59:59');
    }

    if(isset($params['group']))
    {

      $this->db->group_by('hutang.hutang_employee_id'); 

    }

    if(isset($params['grup']))
    {

      $this->db->group_by('hutang.hutang_settinghutang_id'); 

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
      $this->db->order_by('hutang_last_update', 'desc');
    }
    
    $this->db->select('hutang.hutang_id, hutang_noref, hutang_bill, hutang_input_date, hutang_last_update');

    $this->db->select('hutang_employee_id,  employee.employee_position_id, position_name, employee_name, employee_nip, account.account_majors_id, majors_id, majors_name, majors_short_name');
    $this->db->select('hutang_settinghutang_id, poshutang_name, settinghutang_period_id, period_start, period_end');
    
    $this->db->select('hutang_pay.hutang_pay_id, hutang_pay_bill, hutang_input_date, hutang_last_update');
    
    $this->db->join('employee', 'employee.employee_id = hutang.hutang_employee_id', 'left');
    
    $this->db->join('hutang_pay', 'hutang_pay.hutang_pay_hutang_id = hutang.hutang_id', 'left');

    $this->db->join('settinghutang', 'settinghutang.settinghutang_id = hutang.hutang_settinghutang_id', 'left');
    $this->db->join('poshutang', 'poshutang.poshutang_id = settinghutang.settinghutang_poshutang_id', 'left');
    $this->db->join('position', 'position.position_id = employee.employee_position_id', 'left');
    $this->db->join('period', 'period.period_id = settinghutang.settinghutang_period_id', 'left');
    $this->db->join('account', 'poshutang.poshutang_account_id = account.account_id', 'left');
    $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');

    $res = $this->db->get('hutang');

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

    if(isset($data['hutang_id'])) {
      $this->db->set('hutang_id', $data['hutang_id']);
    }

    if(isset($data['hutang_employee_id'])) {
      $this->db->set('hutang_employee_id', $data['hutang_employee_id']);
    }
    
    if(isset($data['hutang_noref'])) {
      $this->db->set('hutang_noref', $data['hutang_noref']);
    }

    if(isset($data['hutang_settinghutang_id'])) {
      $this->db->set('hutang_settinghutang_id', $data['hutang_settinghutang_id']);
    }

    if(isset($data['hutang_bill'])) {
      $this->db->set('hutang_bill', $data['hutang_bill']);
    }

    if(isset($data['hutang_input_date'])) {
      $this->db->set('hutang_input_date', $data['hutang_input_date']);
    }

    if(isset($data['hutang_last_update'])) {
      $this->db->set('hutang_last_update', $data['hutang_last_update']);
    }

    if (isset($data['hutang_id'])) {
      $this->db->where('hutang_id', $data['hutang_id']);
      $this->db->update('hutang');
      $id = $data['hutang_id'];
    } else {
      $this->db->insert('hutang');
      $id = $this->db->insert_id();
    }

    $status = $this->db->affected_rows();
    return ($status == 0) ? FALSE : $id;
  }


// Delete to database
  function delete($id) {
    $this->db->where('hutang_id', $id);
    $this->db->delete('hutang');
  }

// Delete hutang to database
  function delete_hutang($params = array()) {

    if (isset($params['settinghutang_id'])) {
      $this->db->where('hutang_settinghutang_id', $params['settinghutang_id']);
    }

    if (isset($params['employee_id'])) {
      $this->db->where('hutang_employee_id', $params['employee_id']);
    }

    if (isset($params['id'])) {
      $this->db->where('hutang.hutang_id', $params['id']);
    }

    $this->db->delete('hutang');
  }

}
