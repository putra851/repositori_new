<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Bebas_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

// Get From Databases
    function get_cari_bebas($id_periode,$id_tagihan,$id_kelas){
        if($id_kelas != '0'){
            $query = "SELECT student.student_nis, student.student_full_name, bebas.bebas_bill, bebas.bebas_diskon, bebas.bebas_total_pay, (bebas.bebas_bill - bebas.bebas_diskon - bebas.bebas_total_pay) as kekurangan FROM `bebas` JOIN student on bebas.student_student_id = student.student_id JOIN class on class.class_id = student.class_class_id JOIN payment ON payment.payment_id = bebas.payment_payment_id WHERE class.class_id='$id_kelas' AND bebas.payment_payment_id = '$id_tagihan' AND payment.period_period_id = '$id_periode' GROUP BY bebas.student_student_id";
        } else {
            $query = "SELECT student.student_nis, student.student_full_name, bebas.bebas_bill, bebas.bebas_diskon, bebas.bebas_total_pay, (bebas.bebas_bill - bebas.bebas_diskon - bebas.bebas_total_pay) as kekurangan FROM `bebas` JOIN student on bebas.student_student_id = student.student_id JOIN class on class.class_id = student.class_class_id JOIN payment ON payment.payment_id = bebas.payment_payment_id WHERE bebas.payment_payment_id = '$id_tagihan' AND payment.period_period_id = '$id_periode' GROUP BY bebas.student_student_id";
        }
        
        $data=$this->db->query($query)->result();
        return $data;
    }

  function get($params = array())
  {
    if(isset($params['id']))
    {
      $this->db->where('bebas.bebas_id', $params['id']);
    }

    if(isset($params['student_id']))
    {
      $this->db->where('bebas.student_student_id', $params['student_id']);
    }

    if(isset($params['student_nis']))
    {
      $this->db->where('student_nis', $params['student_nis']);
    }

    if (isset($params['multiple_id'])) {
      $this->db->where_in('bebas.bebas_id', $params['multiple_id']);
    }

    if(isset($params['payment_id']))
    {
      $this->db->where('bebas.payment_payment_id', $params['payment_id']);
    }

    if(isset($params['period_id']))
    {
      $this->db->where('payment.period_period_id', $params['period_id']);
    }

    if(isset($params['class_id']))
    {
      $this->db->where('student.class_class_id', $params['class_id']);
    }

    if(isset($params['madin_id']))
    {
      $this->db->where('student.student_madin', $params['madin_id']);
    }

    if(isset($params['majors_id']))
    {
      $this->db->where('student.majors_majors_id', $params['majors_id']);
    }

    if(isset($params['bebas_input_date']))
    {
      $this->db->where('bebas_input_date', $params['bebas_input_date']);
    }

    if(isset($params['bebas_last_update']))
    {
      $this->db->where('bebas_last_update', $params['bebas_last_update']);
    }

    if(isset($params['date_start']) AND isset($params['date_end']))
    {
      $this->db->where('bebas_input_date >=', $params['date_start'] . ' 00:00:00');
      $this->db->where('bebas_input_date <=', $params['date_end'] . ' 23:59:59');
    }

    if(isset($params['status']))
    {
      $this->db->where('bebas_input_date', $params['status']);
    }

    if(isset($params['group']))
    {

      $this->db->group_by('bebas.student_student_id'); 

    }

    if(isset($params['grup']))
    {

      $this->db->group_by('bebas.payment_payment_id'); 

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
      $this->db->order_by('payment_payment_id', 'asc');
    }

    $this->db->where('majors_status', '1');
    
    $this->db->select('bebas.bebas_id, bebas_bill, bebas_diskon, bebas_total_pay, bebas_input_date, bebas_last_update');

    $this->db->select('student_student_id,  student.class_class_id, class_name, student_full_name, student_nis, student_name_of_mother, student_parent_phone, student.majors_majors_id, majors_name, majors_short_name');
    $this->db->select('payment_payment_id, pos_name, payment_type, period_period_id, period_start, period_end');
    $this->db->select('madin_id, madin_name');
    
    $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');

    $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
    $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
    $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
    $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
    $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
    $this->db->join('madin', 'madin.madin_id = student.student_madin', 'left');

    $res = $this->db->get('bebas');

    if(isset($params['id']))
    {
      return $res->row_array();
    }
    else
    {
      return $res->result_array();
    }
  }

    function get_last($param = array())
    {
    if(isset($param['id']))
    {
      $this->db->where('bebas.bebas_id', $param['id']);
    }

    if(isset($param['student_id']))
    {
      $this->db->where('bebas.student_student_id', $param['student_id']);
    }

    if(isset($param['student_nis']))
    {
      $this->db->where('student_nis', $param['student_nis']);
    }

    if (isset($param['multiple_id'])) {
      $this->db->where_in('bebas.bebas_id', $param['multiple_id']);
    }

    if(isset($param['payment_id']))
    {
      $this->db->where('bebas.payment_payment_id', $param['payment_id']);
    }

    if(isset($param['period_id']))
    {
      $this->db->where('payment.period_period_id', $param['period_id']);
    }


    if(isset($param['class_id']))
    {
      $this->db->where('student.class_class_id', $param['class_id']);
    }

    if(isset($param['majors_id']))
    {
      $this->db->where('student.majors_majors_id', $param['majors_id']);
    }

    if(isset($param['bebas_input_date']))
    {
      $this->db->where('bebas_input_date', $param['bebas_input_date']);
    }

    if(isset($param['bebas_last_update']))
    {
      $this->db->where('bebas_last_update', $param['bebas_last_update']);
    }

    if(isset($param['date_start']) AND isset($param['date_end']))
    {
      $this->db->where('bebas_input_date >=', $param['date_start'] . ' 00:00:00');
      $this->db->where('bebas_input_date <=', $param['date_end'] . ' 23:59:59');
    }

    if(isset($param['status']))
    {
      $this->db->where('bebas_input_date', $param['status']);
    }

    if(isset($param['group']))
    {

      $this->db->group_by('bebas.student_student_id'); 

    }

    if(isset($param['grup']))
    {

      $this->db->group_by('bebas.payment_payment_id'); 

    }

    if(isset($param['limit']))
    {
      if(!isset($param['offset']))
      {
        $param['offset'] = NULL;
      }

      $this->db->limit($param['limit'], $param['offset']);
    }

    if(isset($param['order_by']))
    {
      $this->db->order_by($param['order_by'], 'desc');
    }
    else
    {
      $this->db->order_by('bebas_last_update', 'desc');
    }

    $this->db->select('bebas.bebas_id, bebas_bill, bebas_diskon, bebas_total_pay, bebas_input_date, bebas_last_update');

    $this->db->select('student_student_id,  student.class_class_id, class_name, student_full_name, student_nis, student_name_of_mother, student_parent_phone, student.majors_majors_id, majors_name, majors_short_name');
    $this->db->select('payment_payment_id, pos_name, payment_type, period_period_id, period_start, period_end');
    
    $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');

    $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
    $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
    $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
    $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
    $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');

    $res = $this->db->get('bebas');

    if(isset($param['id']))
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

    if(isset($data['bebas_id'])) {
      $this->db->set('bebas_id', $data['bebas_id']);
    }

    if(isset($data['student_id'])) {
      $this->db->set('student_student_id', $data['student_id']);
    }


    if(isset($data['payment_id'])) {
      $this->db->set('payment_payment_id', $data['payment_id']);
    }

    if(isset($data['bebas_bill'])) {
      $this->db->set('bebas_bill', $data['bebas_bill']);
    }

    if(isset($data['bebas_diskon'])) {
      $this->db->set('bebas_diskon', $data['bebas_diskon']);
    }

    if(isset($data['bebas_total_pay'])) {
      $this->db->set('bebas_total_pay', $data['bebas_total_pay']);
    }

    if (isset($data['increase_budget'])) {
      $this->db->set('bebas_total_pay', 'bebas_total_pay +' . $data['increase_budget'], FALSE);
    }

    if (isset($data['decrease_budget'])) {
      $this->db->set('bebas_total_pay', 'bebas_total_pay -' . $data['decrease_budget'], FALSE);
    }

    if(isset($data['bebas_input_date'])) {
      $this->db->set('bebas_input_date', $data['bebas_input_date']);
    }

    if(isset($data['bebas_last_update'])) {
      $this->db->set('bebas_last_update', $data['bebas_last_update']);
    }

    if (isset($data['bebas_id'])) {
      $this->db->where('bebas_id', $data['bebas_id']);
      $this->db->update('bebas');
      $id = $data['bebas_id'];
    } else {
      $this->db->insert('bebas');
      $id = $this->db->insert_id();
    }

    $status = $this->db->affected_rows();
    return ($status == 0) ? FALSE : $id;
  }


// Delete to database
  function delete($id) {
    $this->db->where('bebas_id', $id);
    $this->db->delete('bebas');
  }

// Delete bebas to database
  function delete_bebas($params = array()) {

    if (isset($params['payment_id'])) {
      $this->db->where('payment_payment_id', $params['payment_id']);
    }

    if (isset($params['student_id'])) {
      $this->db->where('student_student_id', $params['student_id']);
    }

    if (isset($params['id'])) {
      $this->db->where('bebas.bebas_id', $params['id']);
    }

    $this->db->delete('bebas');
  }
  
    function update_batch($data = array()) {

    if(isset($data['bebas_bill'])) {
      $this->db->set('bebas_bill', $data['bebas_bill']);
    }

    if(isset($data['bebas_last_update'])) {
      $this->db->set('bebas_last_update', $data['bebas_last_update']);
    }

    if (isset($data['student_id']) AND isset($data['payment_id'])) {
        $this->db->where('student_student_id', $data['student_id']);
        $this->db->where('payment_payment_id', $data['payment_id']);
        $this->db->where('bulan_bill', $data['tarif_lama']);
        $this->db->update('bebas');
    }

    $status = $this->db->affected_rows();
    return $status;
  }
  
    function update_batch_siswa($data = array()) {

    if(isset($data['bebas_bill'])) {
      $this->db->set('bebas_bill', $data['bebas_bill']);
    }

    if(isset($data['bebas_last_update'])) {
      $this->db->set('bebas_last_update', $data['bebas_last_update']);
    }

    if (isset($data['student_id']) AND isset($data['payment_id'])) {
        $this->db->where('student_student_id', $data['student_id']);
        $this->db->where('payment_payment_id', $data['payment_id']);
        $this->db->update('bebas');
    }

    $status = $this->db->affected_rows();
    return $status;
  }

}
