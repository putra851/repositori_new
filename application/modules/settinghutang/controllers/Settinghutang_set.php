<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Settinghutang_set extends CI_Controller {

  public function __construct() {
    parent::__construct(TRUE);
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $this->load->model(array('settinghutang/Settinghutang_model', 'student/Student_model', 'employees/Employees_model', 'position/Position_model', 'period/Period_model', 'poshutang/Poshutang_model', 'hutang/Hutang_model', 'hutang/Hutang_pay_model', 'logs/Logs_model'));

  }

    // settinghutang view in list
  public function index($offset = NULL) {
    $this->load->library('pagination');
    
    $f = $this->input->get(NULL, TRUE);
    $s = $this->input->get(NULL, TRUE);
    
    $data['f'] = $f;
    $data['s'] = $s;

    $params = array();
        // Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['search'] = $f['n'];
    }
        
    if (isset($s['m']) && !empty($s['m']) && $s['m'] != 'all') {
        $params['account_majors_id'] = $s['m'];
    } else if (isset($s['m']) && !empty($s['m']) && $s['m'] == 'all') {
        
    }
    
    $data['settinghutang'] = $this->Settinghutang_model->get($params);
    
    $config['base_url'] = site_url('manage/settinghutang/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        
    $data['majors'] = $this->Student_model->get_majors();

    $data['title'] = 'Setting Hutang';
    $data['main'] = 'settinghutang/settinghutang_list';
    $this->load->view('manage/layout', $data);
  }
  
  public function get_pos(){
      
      $majors_id = $this->input->post('id_majors');
      $poshutang = $this->Poshutang_model->get(array('account_majors_id' => $majors_id));
      
      
      echo '<div class="form-group">
				<label>POS Hutang<small data-toggle="tooltip" title="Wajib diisi">*</small></label>
				<select name="poshutang_id" class="form-control">
					<option value="">-Pilih POS Hutang-</option>';
					foreach ($poshutang as $row){
			   echo	'<option value="'.$row['poshutang_id'].'" >'.$row['poshutang_name'].'</option>';
					}
		    echo '</select>
			</div>';
  }

    // Add settinghutang and Update
  public function add($id = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('poshutang_id', 'Jenis POS', 'trim|required|xss_clean');
    $this->form_validation->set_rules('period_id', 'Tahun Ajaran', 'trim|required|xss_clean');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('settinghutang_id')) {
        $params['settinghutang_id'] = $this->input->post('settinghutang_id');
      } else {
        $params['settinghutang_input_date'] = date('Y-m-d H:i:s');
      }

      $params['settinghutang_last_update'] = date('Y-m-d H:i:s');
      $params['period_id'] = $this->input->post('period_id');
      $params['poshutang_id'] = $this->input->post('poshutang_id');

      $status = $this->Settinghutang_model->add($params);
      $paramsupdate['settinghutang_id'] = $status;
      $this->Settinghutang_model->add($paramsupdate);

            // activity log
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('user_id'),
          'log_module' => 'Setting Hutang',
          'log_action' => $data['operation'],
          'log_info' => 'ID:null;Title:'
        )
      );

      $this->session->set_flashdata('success', $data['operation'] . ' Hutang berhasil');
      redirect('manage/settinghutang');
    } else {
      if ($this->input->post('settinghutang_id')) {
        redirect('manage/settinghutang/edit/' . $this->input->post('settinghutang_id'));
      }

            // Edit mode
      if (!is_null($id)) {
          $object = $this->Settinghutang_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/settinghutang');
        } else {
          $data['settinghutang'] = $object;
        }
        $id_unit = $object['majors_id'];
        $data['poshutang'] = $this->Poshutang_model->get(array('account_majors_id' => $id_unit));
      }
      
      $data['majors'] = $this->Student_model->get_majors();
      $data['period'] = $this->Period_model->get();
      $data['title'] = $data['operation'] . ' Setting Hutang';
      $data['main'] = 'settinghutang/settinghutang_add';
      $this->load->view('manage/layout', $data);
    }
  }

  public function view_hutang($id = NULL, $employee_id = NULL, $hutang_id = NULL) {
      
    $pay_id = $this->uri->segment(4);
    $majors = $this->db->query("SELECT account_majors_id FROM settinghutang JOIN poshutang ON poshutang.poshutang_id = settinghutang.settinghutang_poshutang_id JOIN account ON account.account_id = poshutang.poshutang_account_id WHERE settinghutang.settinghutang_id = '$pay_id'")->row();

    if ($id == NULL) {
      redirect('manage/settinghutang');
    }

    // Apply Filter
        // Get $_GET variable
    $q = $this->input->get(NULL, TRUE);

    $data['q'] = $q;
    $params = array();

        // Kelas
    if (isset($q['pr']) && !empty($q['pr']) && $q['pr'] != '') {
      $params['position_id'] = $q['pr'];
    }

    if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
      $params['majors_id'] = $q['k'];
    }

    //$params['majors_id'] = $majors->account_majors_id;
    $params['settinghutang_id'] = $id;
    $params['group'] = TRUE;
    $data['employee_id'] = $employee_id;

    $data['position'] = $this->Position_model->get($params);
    $data['majors'] = $this->Student_model->get_majors($params);
    $data['kreditur'] = $this->Hutang_model->get($params);
    $data['settinghutang'] = $this->Settinghutang_model->get(array('id' => $id));
    $data['title'] = 'Data Hutang';
    $data['main'] = 'settinghutang/settinghutang_view';
    $this->load->view('manage/layout', $data);
  }

  // Delete settinghutang
  public function delete_settinghutang($id = NULL, $employee_id = NULL, $hutang_id = NULL) {

      $hutang = $this->Hutang_pay_model->get(array(
        'hutang_id'=>$hutang_id, 'hutang_pay_status'=>1
      ));

      if (count($hutang) > 0) {
        $this->session->set_flashdata('failed', 'Hutang tidak dapat dihapus');
        redirect('manage/settinghutang/view_hutang/'.$id);
      }

      $this->Hutang_model->delete_hutang(array(
        'settinghutang_id'=>$id,
        'id'=>$hutang_id
      ));
      
      $this->Hutang_pay_model->delete(array(
        'id'=>$hutang_id
      ));
      
      $this->session->set_flashdata('success', 'Hapus Hutang berhasil');
      redirect('manage/settinghutang/view_hutang/'.$id);
  }
  
  public function add_settinghutang($id = NULL) {
    if ($id == NULL) {
      redirect('manage/settinghutang');
    }

    if ($_POST  == TRUE) {

      if (!$this->input->post('settinghutang_id')) {
          
        if($this->input->post('hutang_bill') == '0' && $this->input->post('cicil') == '0' && $this->input->post('hutang_pay_bill') == '0'){
        $this->session->set_flashdata('failed',' Tidak boleh ada data yang 0 (nol)');
        } else {
          
          $noref = $this->input->post('hutang_noref');
          
          $param['hutang_noref']            = $noref;
          $param['hutang_bill']             = $this->input->post('hutang_bill');
          $param['hutang_input_date']       = date('Y-m-d');
          $param['hutang_last_update']      = date('Y-m-d');
          $param['hutang_settinghutang_id'] = $id;
          $param['hutang_employee_id']      = $this->input->post('employee_id');

          $this->Hutang_model->add($param);
          
          $hutang = $this->db->query("SELECT hutang_id FROM hutang WHERE hutang_noref = '$noref'")->row_array();
          
    	  $cpt = $this->input->post('cicil');
            for ($i = 0; $i < $cpt; $i++) {
        		$params['hutang_pay_hutang_id'] = $hutang['hutang_id'];
        		$params['hutang_pay_noref']     = $noref;
        		$params['hutang_pay_bill']      = $this->input->post('hutang_pay_bill');
        		$params['hutang_input_date']    = date('Y-m-d');
        		$params['hutang_last_update']   = date('Y-m-d');
        		$params['user_user_id']         = $this->session->userdata('uid');
        		$this->Hutang_pay_model->add($params);
            }
            
        $this->session->set_flashdata('success',' Setting Data Hutang berhasil');
        }       
    }
    redirect('manage/settinghutang/view_hutang/' . $id);
    } else {
        
      $like = 'HT';
      $tmp  = $this->Settinghutang_model->get_noref($like);
      
      $pay_id = $this->uri->segment(4);
      
      $data['noref'] = 'HT'.$tmp;
      $data['position'] = $this->Position_model->get();
      $data['settinghutang'] = $this->Settinghutang_model->get(array('id' => $id));
      $data['title'] = 'Tambah Data Hutang';
      $data['main'] = 'settinghutang/settinghutang_add_hutang';
      $this->load->view('manage/layout', $data);
    }
  }

  public function edit_settinghutang($id = NULL, $employee_id = NULL, $hutang_id = NULL) {
      
    if ($id == NULL AND $employee_id == NULL OR $hutang_id == NULL) {
      redirect('manage/settinghutang');
    }

    if ($_POST  == TRUE) {
    
        if($this->input->post('hutang_bill') == '0' && $this->input->post('cicil') == '0' && $this->input->post('hutang_pay_bill') == '0'){
            $this->session->set_flashdata('failed',' Tidak boleh ada data yang 0 (nol)');
        } else {
            
            $check = $this->db->query("SELECT COUNT('hutang_pay_id') as nums FROM hutang_pay WHERE hutang_pay_id = '$hutang_id' AND hutang_pay_status = '0'")->row_array();
            
            if($check['nums'] > 0){
                
                $this->session->set_flashdata('failed',' Hutang tidak bisa diedit');
                
                redirect('manage/settinghutang/view_hutang/' . $id);
            }
            
            $param['hutang_id']               = $hutang_id;
            $param['hutang_noref']            = $this->input->post('hutang_noref');
            $param['hutang_bill']             = $this->input->post('hutang_bill');
            $param['hutang_input_date']       = date('Y-m-d');
            $param['hutang_last_update']      = date('Y-m-d');
            $param['hutang_settinghutang_id'] = $id;
            $param['hutang_employee_id']      = $this->input->post('employee_id');
            
            $this->Hutang_model->add($param);
            
            $cpt = $this->input->post('cicil');
            for ($i = 0; $i < $cpt; $i++) {
            	$params['hutang_pay_hutang_id'] = $hutang_id;
            	$params['hutang_pay_noref']     = $this->input->post('hutang_noref');
            	$params['hutang_pay_bill']      = $this->input->post('hutang_pay_bill');
            	$params['hutang_input_date']    = date('Y-m-d');
            	$params['hutang_last_update']   = date('Y-m-d');
            	$params['user_user_id']         = $this->session->userdata('uid');
            	$this->Hutang_pay_model->add($params);
            }
            
            $this->session->set_flashdata('success',' Update Hutang berhasil');
        }
        
        redirect('manage/settinghutang/view_hutang/' . $id);
    
    } else {
        
      $data['settinghutang'] = $this->Settinghutang_model->get(array('id' => $id));
      $data['hutang'] = $this->Hutang_model->get(array('settinghutang_id' => $id, 'hutang_employee_id' => $employee_id));
      $data['title'] = 'Edit Data Hutang';
      $data['main'] = 'settinghutang/settinghutang_edit_hutang';
      $this->load->view('manage/layout', $data);
    }
    
  }

    // Delete to database
  public function delete($id = NULL) {
   if ($this->session->userdata('uroleid')!= SUPERUSER){
    redirect('manage');
  }
  if ($_POST) {

    $hutang = $this->Hutang_model->get_delete(array('settinghutang_id' => $this->input->post('settinghutang_id')));

    if (count($hutang)>0) {
      $this->session->set_flashdata('failed', 'Hutang tidak dapat dihapus');
      redirect('manage/settinghutang');
    }

    $this->Settinghutang_model->delete($this->input->post('settinghutang_id'));
            // activity log
    $this->load->model('logs/Logs_model');
    $this->Logs_model->add(
        array(
            'log_date' => date('Y-m-d H:i:s'),
            'user_id' => $this->session->userdata('uid'),
            'log_module' => 'Setting Hutang',
            'log_action' => 'Hapus',
            'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
        )
    );
    $this->session->set_flashdata('success', 'Hapus Setting Hutang berhasil');
    redirect('manage/settinghutang');
  } elseif (!$_POST) {
    $this->session->set_flashdata('delete', 'Delete');
    redirect('manage/settinghutang/edit/' . $id);
  }
}

function get_people(){
    $params = array();
    $id_position = $this->input->post('id_position');
    $params['employee_position_id'] = $id_position;
    $employees  = $this->Employees_model->get($params);
    
    echo '<select name="employee_id" class="form-control">
			<option value="">-- Pilih Kreditur --</option>';
			foreach($employees as $row){
			echo '<option value="'.$row['employee_id'].'">'.$row['employee_name'].'</option>';
			}
	echo '</select>';
}

}