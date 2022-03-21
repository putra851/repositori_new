<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Payment_set extends CI_Controller {

  public function __construct() {
    parent::__construct(TRUE);
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $this->load->model(array('payment/Payment_model', 'student/Student_model', 'period/Period_model', 'pos/Pos_model', 'bulan/Bulan_model', 'bebas/Bebas_model', 'bebas/Bebas_pay_model', 'logs/Logs_model'));

  }

    // payment view in list
  public function index($offset = NULL) {
    $this->load->library('pagination');
        // Apply Filter
        // Get $_GET variable
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

    //$paramsPage = $params;
    //$params['limit'] = 5;
    //$params['offset'] = $offset;
    $data['payment'] = $this->Payment_model->get($params);

    //$config['per_page'] = 5;
    //$config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/payment/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    //$config['total_rows'] = count($this->Payment_model->get($paramsPage));
    //$this->pagination->initialize($config);
        
    $data['majors'] = $this->Student_model->get_majors();

    $data['title'] = 'Jenis Pembayaran';
    $data['main'] = 'payment/payment_list';
    $this->load->view('manage/layout', $data);
  }
  
  public function get_pos(){
      
      $majors_id = $this->input->post('id_majors');
      $pos = $this->Pos_model->get(array('account_majors_id' => $majors_id));
      
      
      echo '<div class="form-group">
				<label>POS <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
				<select name="pos_id" class="form-control">
					<option value="">-Pilih POS-</option>';
					foreach ($pos as $row){
			   echo	'<option value="'.$row['pos_id'].'" >'.$row['pos_name'].'</option>';
					}
		    echo '</select>
			</div>';
  }
  
  function get_mode(){
        $type   = $this->input->post('type');
        
        //if($type == 'BULAN'){
            echo '<div class="form-group">
				<label>Model Pembayaran <small data-toggle="tooltip" title="Wajib diisi">*</small></label><br>
				<select name="payment_type" class="form-control" required="">
					<option value="">-Pilih Model-</option>
					<option value="TETAP">Tetap</option>
					<option value="TIDAK TETAP">Tidak Tetap</option>
				</select>
			</div>';   
        //}
    }

    // Add payment and Update
  public function add($id = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('pos_id', 'Jenis POS', 'trim|required|xss_clean');
    $this->form_validation->set_rules('period_id', 'Tahun Ajaran', 'trim|required|xss_clean');

    $this->form_validation->set_rules('payment_type', 'Tipe', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('payment_id')) {
        $params['payment_id'] = $this->input->post('payment_id');
      } else {
        $params['payment_input_date'] = date('Y-m-d H:i:s');
      }
      
      $type = $this->input->post('payment_type');
      $params['payment_last_update'] = date('Y-m-d H:i:s');
      $params['payment_type'] = $this->input->post('payment_type');
      //if($type == 'BULAN'){
        $params['payment_mode'] = $this->input->post('payment_mode');
      //} else {
        //$params['payment_mode'] = NULL;
      //}
      $params['period_id'] = $this->input->post('period_id');
      $params['pos_id'] = $this->input->post('pos_id');

      $status = $this->Payment_model->add($params);
      $paramsupdate['payment_id'] = $status;
      $this->Payment_model->add($paramsupdate);

            // activity log
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('user_id'),
          'log_module' => 'Jenis Pembayaran',
          'log_action' => $data['operation'],
          'log_info' => 'ID:null;Title:'
        )
      );

      $this->session->set_flashdata('success', $data['operation'] . ' Pembayaran berhasil');
      redirect('manage/payment');
    } else {
      if ($this->input->post('payment_id')) {
        redirect('manage/payment/edit/' . $this->input->post('payment_id'));
      }

            // Edit mode
      if (!is_null($id)) {
          $object = $this->Payment_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/payment');
        } else {
          $data['payment'] = $object;
        }
        $id_unit = $object['majors_id'];
        $data['pos'] = $this->Pos_model->get(array('account_majors_id' => $id_unit));
      }
      
      $data['majors'] = $this->Student_model->get_majors();
      $data['period'] = $this->Period_model->get();
      $data['title'] = $data['operation'] . ' Jenis Pembayaran';
      $data['main'] = 'payment/payment_add';
      $this->load->view('manage/layout', $data);
    }
  }

  // View data detail
  public function view_bulan($id = NULL, $student_id = NULL) {

    $pay_id = $this->uri->segment(4);
    $majors = $this->db->query("SELECT account_majors_id FROM payment JOIN pos ON pos.pos_id = payment.pos_pos_id JOIN account ON account.account_id = pos.account_account_id WHERE payment.payment_id = '$pay_id'")->row();
    
    if ($id == NULL) {
      redirect('manage/payment');
    }

    // Apply Filter
        // Get $_GET variable
    $q = $this->input->get(NULL, TRUE);

    $data['q'] = $q;
    $params = array();

        // Kelas
    if (isset($q['pr']) && !empty($q['pr']) && $q['pr'] != '') {
      $params['class_id'] = $q['pr'];
    }

    if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
      $params['majors_id'] = $q['k'];
    }

    $params['majors_id'] = $majors->account_majors_id;
    $params['payment_id'] = $id;
    $params['group'] = TRUE;
    $data['student_id'] = $student_id;

    $data['class'] = $this->Student_model->get_class($params);
    $data['majors'] = $this->Student_model->get_majors($params);
    $data['student'] = $this->Bulan_model->get_bulanan($params);
    $data['payment'] = $this->Payment_model->get(array('id' => $id));
    $data['title'] = 'Tarif Pembayaran';
    $data['main'] = 'payment/payment_view_bulan';
    $this->load->view('manage/layout', $data);
  }

// View data detail
  public function view_bebas($id = NULL, $student_id = NULL, $bebas_id = NULL) {
      
    $pay_id = $this->uri->segment(4);
    $majors = $this->db->query("SELECT account_majors_id FROM payment JOIN pos ON pos.pos_id = payment.pos_pos_id JOIN account ON account.account_id = pos.account_account_id WHERE payment.payment_id = '$pay_id'")->row();

    if ($id == NULL) {
      redirect('manage/payment');
    }

    // Apply Filter
        // Get $_GET variable
    $q = $this->input->get(NULL, TRUE);

    $data['q'] = $q;
    $params = array();

        // Kelas
    if (isset($q['pr']) && !empty($q['pr']) && $q['pr'] != '') {
      $params['class_id'] = $q['pr'];
    }

    if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
      $params['majors_id'] = $q['k'];
    }

    $params['majors_id'] = $majors->account_majors_id;
    $params['payment_id'] = $id;
    $params['group'] = TRUE;
    $data['student_id'] = $student_id;

    $data['class'] = $this->Student_model->get_class($params);
    $data['majors'] = $this->Student_model->get_majors($params);
    $data['student'] = $this->Bebas_model->get($params);
    $data['payment'] = $this->Payment_model->get(array('id' => $id));
    $data['title'] = 'Tarif Tagihan';
    $data['main'] = 'payment/payment_view_bebas';
    $this->load->view('manage/layout', $data);
  }

  // Delete payment Bebas
  public function delete_payment_bebas($id = NULL, $student_id = NULL, $bebas_id = NULL) {

      $bebas = $this->Bebas_pay_model->get(array(
        'bebas_id'=>$bebas_id
      ));

      if (count($bebas) > 0) {
        $this->session->set_flashdata('failed', 'Pembayaran Santri tidak dapat dihapus karena sudah ada transaksi');
        redirect('manage/payment/view_bebas/'.$id);
      }

      $this->Bebas_model->delete_bebas(array(
        'payment_id'=>$id,
        'student_id'=>$student_id,
        'id'=>$bebas_id
      ));
      
      $this->session->set_flashdata('success', 'Hapus Pembayaran Santri berhasil');
      redirect('manage/payment/view_bebas/'.$id);
  }

  // Delete payment Bebas
  public function delete_payment_bebas_batch() {
      if ($_POST == TRUE) {
          $student_id   = $_POST['student_id'];
          $payment_id   = $_POST['payment_id'];
          $cpt          = count($_POST['student_id']);
          
        for ($i = 0; $i < $cpt; $i++) {
            
            $bebas = $this->Bebas_model->get(array('student_id' =>$student_id[$i], 'payment_id'=> $payment_id ));
            
                foreach($bebas as $b) {
                    $total_bill = $bebas['bebas_bill'] - $bebas['bebas_bill'];
                    $total_pay  = $bebas['bebas_total_pay'];
                }
                
                if ($total_total > 0 AND $total_pay > 0) {
                    $this->session->set_flashdata('failed', 'Pembayaran Santri tidak dapat dihapus karena sudah ada transaksi');
                   // redirect('manage/payment/view_bebas/'.$payment_id );
                } else {
            
                    $this->Bebas_model->delete_bebas(
                        array(
                            'payment_id'=>$payment_id,
                            'student_id'=>$student_id[$i]
                      )
                    );
                      
                    $this->session->set_flashdata('success', 'Hapus Pembayaran Santri berhasil');
                    
                }
      
            }    
        }
        
    redirect('manage/payment/view_bebas/'.$payment_id );
  }

  public function add_payment_bulan_student($id = NULL) {
    if ($id == NULL) {
      redirect('manage/payment');
    }
    
    $this->load->library('form_validation');

    $this->form_validation->set_rules('student_id', 'Pilih Kelas dan Santri', 'trim|required|xss_clean');
    $this->form_validation->set_rules('bulan_bill[]', 'Tarif Bulanan', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if (!$this->input->post('payment_id')) { 

        $month = $this->Bulan_model->get_month();
        $check = $this->Bulan_model->get(array('student_id' =>$this->input->post('student_id'), 'payment_id'=> $id));
        $title = $_POST['bulan_bill'];
        $cpt = count($_POST['bulan_bill']);
        $month = $_POST['month_id'];
        for ($i = 0; $i < $cpt; $i++) {
          $param['bulan_bill'] = $title[$i];
          $param['month_id'] = $month[$i];
          $param['bulan_input_date'] = date('Y-m-d H:i:s');
          $param['bulan_last_update'] = date('Y-m-d H:i:s');
          $param['payment_id'] = $id;
          $param['student_id'] = $this->input->post('student_id');

          if (count($check) == 0) {

            $this->Bulan_model->add($param);
          } else {
            $this->session->set_flashdata('failed',' Duplikat Data');
            redirect('manage/payment/view_bulan/' . $id);
          }
        }
      }

      $this->session->set_flashdata('success',' Settig Tarif berhasil');
      redirect('manage/payment/view_bulan/' . $id);

    } else {
    $pay_id = $this->uri->segment(4);
    $majors = $this->db->query("SELECT account_majors_id FROM payment JOIN pos ON pos.pos_id = payment.pos_pos_id JOIN account ON account.account_id = pos.account_account_id WHERE payment.payment_id = '$pay_id'")->row();
    
      $params['majors_id'] = $majors->account_majors_id;
      $data['student'] = $this->Student_model->get(array('status'=>1));
      $data['class'] = $this->Student_model->get_class($params);
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['month'] = $this->Bulan_model->get_month();
      $data['title'] = 'Tambah Tarif Pembayaran Santri';
      $data['main'] = 'payment/payment_add_bulan_student';
      $this->load->view('manage/layout', $data);
    }
  }

  public function add_payment_bulan($id = NULL) {
    if ($id == NULL) {
      redirect('manage/payment');
    }
    $this->load->library('form_validation');

    $this->form_validation->set_rules('bulan_bill[]', 'Tarif Bulanan', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if (!$this->input->post('payment_id')) {

        $month = $this->Bulan_model->get_month();
        $student = $this->Student_model->get(array('class_id' => $this->input->post('class_id'),'status'=>1));
        $title = $_POST['bulan_bill'];
        $cpt = count($_POST['bulan_bill']);
        $month = $_POST['month_id'];
        
        foreach ($student as $row) {
            
        $check = $this->db->query("SELECT COUNT(student_student_id) AS num FROM bulan WHERE student_student_id = '".$row['student_id']."' AND payment_payment_id = '$id'")->row_array();
        
          for ($i = 0; $i < $cpt; $i++) {
            $param['bulan_bill'] = $title[$i];
            $param['month_id'] = $month[$i];
            $param['bulan_input_date'] = date('Y-m-d H:i:s');
            $param['bulan_last_update'] = date('Y-m-d H:i:s');
            $param['payment_id'] = $id;
            $param['student_id'] = $row['student_id'];
            
            //$check = $this->Bulan_model->get(array('student_id' =>$row['student_id'], 'payment_id'=> $id));
            
            if ($check['num'] == 0) {
              $this->Bulan_model->add($param);
              $this->session->set_flashdata('success',' Setting Tarif berhasil');
            } else {
              $this->session->set_flashdata('failed',' Duplikat Data');
              //redirect('manage/payment/view_bulan/' . $id);
            }
          }
        }
      }

      redirect('manage/payment/view_bulan/' . $id);

    } else {
      $pay_id = $this->uri->segment(4);
      $majors = $this->db->query("SELECT account_majors_id FROM payment JOIN pos ON pos.pos_id = payment.pos_pos_id JOIN account ON account.account_id = pos.account_account_id WHERE payment.payment_id = '$pay_id'")->row();
    
      $params['majors_id'] = $majors->account_majors_id;
      $data['class'] = $this->Student_model->get_class($params);
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['month'] = $this->Bulan_model->get_month();
      $data['title'] = 'Tambah Tarif Pembayaran';
      $data['main'] = 'payment/payment_add_bulan';
      $this->load->view('manage/layout', $data);
    }
  }

  public function add_payment_bulan_majors($id = NULL) {
    if ($id == NULL) {
      redirect('manage/payment');
    }

    if (majors() != 'senior') {
      redirect('manage/payment/view_bulan/' . $id);
    }
    $this->load->library('form_validation');

    $this->form_validation->set_rules('bulan_bill[]', 'Tarif Bulanan', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if (!$this->input->post('payment_id')) {

        $month = $this->Bulan_model->get_month();
        $student = $this->Student_model->get(array('majors_id' => $this->input->post('majors_id'),'class_id' => $this->input->post('class_id'),'status'=>1));
        $check = $this->Bulan_model->get(array('majors_id' =>$this->input->post('majors_id'), 'class_id' =>$this->input->post('class_id'), 'payment_id'=> $id));
        $title = $_POST['bulan_bill'];
        $cpt = count($_POST['bulan_bill']);
        $month = $_POST['month_id'];
        foreach ($student as $row) {
          for ($i = 0; $i < $cpt; $i++) {
            $param['bulan_bill'] = $title[$i];
            $param['month_id'] = $month[$i];
            $param['bulan_input_date'] = date('Y-m-d H:i:s');
            $param['bulan_last_update'] = date('Y-m-d H:i:s');
            $param['payment_id'] = $id;
            $param['student_id'] = $row['student_id'];
            
            if (count($check) == 0) {

              $this->Bulan_model->add($param);
            } else {
              $this->session->set_flashdata('failed',' Duplikat Data');
              redirect('manage/payment/view_bulan/' . $id);
            }
          }
        }
      }

      $this->session->set_flashdata('success',' Setting Tarif berhasil');
      redirect('manage/payment/view_bulan/' . $id);

    } else {

      $data['majors'] = $this->Student_model->get_majors();
      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['month'] = $this->Bulan_model->get_month();
      $data['title'] = 'Tambah Tarif Pembayaran';
      $data['main'] = 'payment/payment_add_bulan_majors';
      $this->load->view('manage/layout', $data);
    }
  }

  public function edit_payment_bulan($id = NULL, $student_id = NULL) {
    if ($id == NULL AND $student_id == NULL OR $student_id ==NULL) {
      redirect('manage/payment');
    }

    if ($_POST  == TRUE) {

      $title = $_POST['bulan_bill'];
      $bulan_id = $_POST['bulan_id'];
      $cpt = count($_POST['bulan_bill']);

      for ($i = 0; $i < $cpt; $i++) {
        $param['bulan_id'] = $bulan_id[$i];
        $param['bulan_bill'] = $title[$i];
        $param['bulan_last_update'] = date('Y-m-d H:i:s');

        $this->Bulan_model->add($param); 
      }

      $this->session->set_flashdata('success',' Pembayaran berhasil');
      redirect('manage/payment/view_bulan/' . $id);

    } else {

      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['bulan'] = $this->Bulan_model->get(array('payment_id' => $id, 'student_id' => $student_id));
      $data['student'] = $this->Student_model->get(array('id'=> $student_id));
      $data['title'] = 'Edit Tarif Pembayaran';
      $data['main'] = 'payment/payment_edit_bulan';
      $this->load->view('manage/layout', $data);
    }
  }

  public function edit_payment_bulan_batch($id = NULL) {
    if ($id == NULL) {
      redirect('manage/payment');
    }
    
    $this->load->library('form_validation');

    $this->form_validation->set_rules('bulan_bill', 'Tarif Bulanan', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if (!$this->input->post('payment_id')) {

        //$month      = $this->Bulan_model->get_month();
        $student    = $this->Student_model->get(array('class_id' => $this->input->post('class_id'),'status'=>1));
        
        $title      = $_POST['bulan_bill'];
        $tarifLama  = $_POST['tarif_lama'];
        //$month      = $_POST['month_id'];
        $bulan      = $_POST['bln'];
        $cpt        = count($_POST['bln']);
        
        if($cpt > 0){
            
            foreach ($student as $row) {
            
                for ($i = 0; $i < $cpt; $i++) {
                    //set update
                    $param['bulan_bill'] = $title;
                    $param['bulan_last_update'] = date('Y-m-d H:i:s');
                    $param['user_user_id'] = $this->session->userdata('uid');
                    
                    //where
                    $param['month_id']   = $bulan[$i];
                    $param['tarif_lama'] = $tarifLama;
                    $param['payment_id'] = $id;
                    $param['student_id'] = $row['student_id'];
                    $param['bulan_status'] = '0';
                    
                    $this->Bulan_model->update_batch($param);
                }
            
            }
            
        } else {
          $this->session->set_flashdata('failed',' Bulan Belum Dipilih');
          redirect('manage/payment/view_bulan/' . $id);
        }
        
      }

      $this->session->set_flashdata('success',' Update Tarif Per Kelas Berhasil');
      redirect('manage/payment/view_bulan/' . $id);

    } else {
      $pay_id = $this->uri->segment(4);
      $majors = $this->db->query("SELECT account_majors_id FROM payment JOIN pos ON pos.pos_id = payment.pos_pos_id JOIN account ON account.account_id = pos.account_account_id WHERE payment.payment_id = '$pay_id'")->row();
    
      $params['majors_id'] = $majors->account_majors_id;
      $data['class'] = $this->Student_model->get_class($params);
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['month'] = $this->Bulan_model->get_month();
      $data['title'] = 'Edit Tarif Pembayaran Per Kelas';
      $data['main'] = 'payment/payment_edit_bulan_batch';
      $this->load->view('manage/layout', $data);
    }
  }

  public function edit_payment_bebas_batch($id = NULL) {
    if ($id == NULL) {
      redirect('manage/payment');
    }

    if ($_POST  == TRUE) {

      if (!$this->input->post('payment_id')) {

        $student = $this->Student_model->get(array('class_id' => $this->input->post('class_id')));
        //$check = $this->Bebas_model->get(array('class_id' =>$this->input->post('class_id'), 'payment_id'=> $id));
        
        foreach ($student as $row) {
            
          $cek = $this->db->query("SELECT bebas_bill, bebas_diskon, bebas_total_pay FROM bebas WHERE student_student_id = '" . $row['student_id'] . "' AND payment_payment_id = '$id'")->row_array();
            
          //set update
          $param['bebas_bill'] = $this->input->post('bebas_bill');
          $param['bebas_last_update'] = date('Y-m-d H:i:s');
          
          //where
          $param['tarif_lama'] = $this->input->post('tarif_lama');
          $param['payment_id'] = $id;
          $param['student_id'] = $row['student_id'];
          
          $sisa = ($cek['bebas_bill'] - $cek['bebas_diskon']) - $cek['bebas_total_pay'];
          
          if($sisa > 0) {
            $this->Bebas_model->update_batch($param);
          }
          
        }
      }

      $this->session->set_flashdata('success',' Update Tarif Per Kelas berhasil');
      redirect('manage/payment/view_bebas/' . $id);

    } else {
      $pay_id = $this->uri->segment(4);
      $majors = $this->db->query("SELECT account_majors_id FROM payment JOIN pos ON pos.pos_id = payment.pos_pos_id JOIN account ON account.account_id = pos.account_account_id WHERE payment.payment_id = '$pay_id'")->row();
    
      $params['majors_id'] = $majors->account_majors_id;
      $data['class'] = $this->Student_model->get_class($params);
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['title'] = 'Tambah Tarif Pembayaran';
      $data['main'] = 'payment/payment_edit_bebas_batch';
      $this->load->view('manage/layout', $data);
    }
  }

  public function update_payment_bebas_batch() {
      
        $studentID  = $_POST['student_id'];
        $cptstudent = count($_POST['student_id']);
        $id         = $_POST['payment_id'];
        
        if($cptstudent > 0){
            for ($i = 0; $i < $cptstudent; $i++) {
            
            $student = $this->Student_model->get(array('id' => $studentID[$i]));
            
              $cek = $this->db->query("SELECT bebas_bill, bebas_diskon, bebas_total_pay FROM bebas WHERE student_student_id = '" . $student['student_id'] . "' AND payment_payment_id = '$id'")->row_array();
                
              //set update
              $param['bebas_bill'] = $this->input->post('bebas_bill');
              $param['bebas_last_update'] = date('Y-m-d H:i:s');
              $param['payment_id'] = $id;
              $param['student_id'] = $student['student_id'];
              
              $sisa = ($cek['bebas_bill'] - $cek['bebas_diskon']) - $cek['bebas_total_pay'];
              
                  if($sisa > 0) {
                    $this->Bebas_model->update_batch_siswa($param);
                  }
            }
        }              
        
        $this->session->set_flashdata('success',' Update Massal Tarif Santri berhasil');
        redirect('manage/payment/view_bebas/' . $id);
  }
  
  public function update_payment_bulan_batch() {
        
        $studentID  = $_POST['student_id'];
        $title      = $_POST['bulan_bill'];
        $bulan      = $_POST['bln'];
        $cpt        = count($_POST['bln']);
        $cptstudent = count($_POST['student_id']);
        $id         = $_POST['payment_id'];
            
        if($cptstudent > 0){
            for ($j = 0; $j < $cptstudent; $j++) {
                
                $student    = $this->Student_model->get(array('id' => $studentID[$j], 'status'=>1));
                
                if($cpt > 0){
                
                    for ($i = 0; $i < $cpt; $i++) {
                        //set update
                        $param['bulan_bill'] = $title;
                        $param['bulan_last_update'] = date('Y-m-d H:i:s');
                        $param['user_user_id'] = $this->session->userdata('uid');
                        
                        //where
                        $param['month_id']   = $bulan[$i];
                        $param['payment_id'] = $id;
                        $param['student_id'] = $student['student_id'];
                        $param['bulan_status'] = '0';
                        
                        $this->Bulan_model->update_batch_siswa($param);
                    }
                
                }
            
            }
            
        } else {
          $this->session->set_flashdata('failed',' Bulan Belum Dipilih');
          redirect('manage/payment/view_bulan/' . $id);
        }
        
      

      $this->session->set_flashdata('success',' Update Massal Tarif Santri Berhasil');
      redirect('manage/payment/view_bulan/' . $id);
  }
  
  public function delete_payment_bulan($id = NULL, $student_id = NULL) {

      $bulan = $this->Bulan_model->get(array(
        'payment_id' => $id,
        'student_id' => $student_id,
        'status'     => '1',
      ));

      if (count($bulan) > 0) {
        $this->session->set_flashdata('failed', 'Pembayaran Santri tidak dapat dihapus karena sudah ada transaksi');
        redirect('manage/payment/view_bulan/'.$id);
      }
      
      $this->db->query("DELETE FROM bulan WHERE payment_payment_id = '$id' AND student_student_id = '$student_id'");
      
      $this->session->set_flashdata('success', 'Hapus Pembayaran Santri berhasil');
      redirect('manage/payment/view_bulan/'.$id);
  }
  
  public function delete_payment_bulan_batch() {
      
        if ($_POST == TRUE) {
          $student_id   = $_POST['student_id'];
          $payment_id   = $_POST['payment_id'];
          $cpt          = count($_POST['student_id']);
          
          for ($i = 0; $i < $cpt; $i++) {
              $bulan = $this->Bulan_model->get(array(
                'payment_id' => $payment_id,
                'student_id' => $student_id[$i],
                'status'     => '1',
              ));
        
              if (count($bulan) > 0) {
                $this->session->set_flashdata('failed', 'Pembayaran Santri tidak dapat dihapus karena sudah ada transaksi');
                //redirect('manage/payment/view_bulan/'.$id);
              } else {
              
              $this->db->query("DELETE FROM bulan WHERE payment_payment_id = '$payment_id' AND student_student_id = '$student_id[$i]'");
              
              $this->session->set_flashdata('success', 'Hapus Pembayaran Santri berhasil');
                  
              }
      
            }
            
        }
        
      redirect('manage/payment/view_bulan/'.$payment_id);
  }
  
  public function add_payment_bebas_student($id = NULL) {
    if ($id == NULL) {
      redirect('manage/payment');
    }

    if ($_POST  == TRUE) {

      if (!$this->input->post('payment_id')) {

        $student = $this->Student_model->get(array('student_id' => $this->input->post('student_id')));
        $check = $this->Bebas_model->get(array('student_id' =>$this->input->post('student_id'), 'payment_id'=> $id));
        
        foreach ($student as $row) {
          $param['bebas_bill'] = $this->input->post('bebas_bill');
          $param['bebas_input_date'] = date('Y-m-d H:i:s');
          $param['bebas_last_update'] = date('Y-m-d H:i:s');
          $param['payment_id'] = $id;
          $param['student_id'] = $this->input->post('student_id');

          if (count($check) == 0) {

            $this->Bebas_model->add($param);
          } else {
            $this->session->set_flashdata('failed',' Duplikat Data');
            redirect('manage/payment/view_bebas/' . $id);
          }
        }
      }

      $this->session->set_flashdata('success',' Setting Tarif berhasil');
      redirect('manage/payment/view_bebas/' . $id);

    } else {
      $pay_id = $this->uri->segment(4);
      $majors = $this->db->query("SELECT account_majors_id FROM payment JOIN pos ON pos.pos_id = payment.pos_pos_id JOIN account ON account.account_id = pos.account_account_id WHERE payment.payment_id = '$pay_id'")->row();
    
      $params['majors_id'] = $majors->account_majors_id;
      $data['class'] = $this->Student_model->get_class($params);
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['title'] = 'Tambah Tarif Pembayaran';
      $data['main'] = 'payment/payment_add_bebas_student';
      $this->load->view('manage/layout', $data);
    }
  }

  public function add_payment_bebas($id = NULL) {
    if ($id == NULL) {
      redirect('manage/payment');
    }

    if ($_POST  == TRUE) {

      if (!$this->input->post('payment_id')) {

        $student = $this->Student_model->get(array('class_id' => $this->input->post('class_id')));
        //$check = $this->Bebas_model->get(array('class_id' =>$this->input->post('class_id'), 'payment_id'=> $id));
        
        foreach ($student as $row) {
          $param['bebas_bill'] = $this->input->post('bebas_bill');
          $param['bebas_input_date'] = date('Y-m-d H:i:s');
          $param['bebas_last_update'] = date('Y-m-d H:i:s');
          $param['payment_id'] = $id;
          $param['student_id'] = $row['student_id'];

          $check = $this->db->query("SELECT COUNT(student_student_id) AS num FROM bebas 
                                        WHERE student_student_id = '".$row['student_id']."' 
                                        AND payment_payment_id = '$id'")->row_array();
            
            if ($check['num'] == 0) {
              $this->Bebas_model->add($param);
              $this->session->set_flashdata('success',' Setting Tarif berhasil');
            } else {
              $this->session->set_flashdata('failed',' Duplikat Data');
              //redirect('manage/payment/view_bulan/' . $id);
            }
            
            }
        }

      //$this->session->set_flashdata('success',' Setting Tarif berhasil');
      redirect('manage/payment/view_bebas/' . $id);

    } else {
      $pay_id = $this->uri->segment(4);
      $majors = $this->db->query("SELECT account_majors_id FROM payment JOIN pos ON pos.pos_id = payment.pos_pos_id JOIN account ON account.account_id = pos.account_account_id WHERE payment.payment_id = '$pay_id'")->row();
    
      $params['majors_id'] = $majors->account_majors_id;
      $data['class'] = $this->Student_model->get_class($params);
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['title'] = 'Tambah Tarif Pembayaran';
      $data['main'] = 'payment/payment_add_bebas';
      $this->load->view('manage/layout', $data);
    }
  }

  public function add_payment_bebas_majors($id = NULL) {
    if ($id == NULL) {
      redirect('manage/payment');
    }

    if(majors() != 'senior') {
      redirect('manage/payment/view_bebas/' . $id);
    }

    if ($_POST  == TRUE) {

      if (!$this->input->post('payment_id')) {

        $student = $this->Student_model->get(array('majors_id' => $this->input->post('majors_id'),'class_id' => $this->input->post('class_id')));
        $check = $this->Bebas_model->get(array('majors_id' =>$this->input->post('majors_id'),'class_id' => $this->input->post('class_id'), 'payment_id'=> $id));
        
        foreach ($student as $row) {
          $param['bebas_bill'] = $this->input->post('bebas_bill');
          $param['bebas_input_date'] = date('Y-m-d H:i:s');
          $param['bebas_last_update'] = date('Y-m-d H:i:s');
          $param['payment_id'] = $id;
          $param['student_id'] = $row['student_id'];

          if (count($check) == 0) {

            $this->Bebas_model->add($param);
          } else {
            $this->session->set_flashdata('failed',' Duplikat Data');
            redirect('manage/payment/view_bebas/' . $id);
          }
        }
      }

      $this->session->set_flashdata('success',' Setting Tarif berhasil');
      redirect('manage/payment/view_bebas/' . $id);

    } else {

      $data['majors'] = $this->Student_model->get_majors();
      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['title'] = 'Tambah Tarif Pembayaran';
      $data['main'] = 'payment/payment_add_bebas_majors';
      $this->load->view('manage/layout', $data);
    }
  }

  public function edit_payment_bebas($id = NULL, $student_id = NULL, $bebas_id = NULL) {
    if ($id == NULL AND $student_id == NULL OR $bebas_id == NULL) {
      redirect('manage/payment');
    }

    if ($_POST  == TRUE) {

      $param['bebas_id'] = $bebas_id;
      $param['bebas_bill'] = $this->input->post('bebas_bill');
      $param['bulan_last_update'] = date('Y-m-d H:i:s');

      $this->Bebas_model->add($param); 

      $this->session->set_flashdata('success',' Update Tagihan berhasil');
      redirect('manage/payment/view_bebas/' . $id);

    } else {

      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['bebas'] = $this->Bebas_model->get(array('payment_id' => $id, 'student_id' => $student_id));

      $data['student'] = $this->Student_model->get(array('id'=> $student_id));
      $data['title'] = 'Edit Tarif Tagihan';
      $data['main'] = 'payment/payment_edit_bebas';
      $this->load->view('manage/layout', $data);
    }
  }


    // Delete to database
  public function delete($id = NULL) {
   if ($this->session->userdata('uroleid')!= SUPERUSER){
    redirect('manage');
  }
  if ($_POST) {

    $bulan = $this->Bulan_model->get(array('payment_id' => $this->input->post('payment_id')));
    $bebas = $this->Bebas_model->get(array('payment_id' => $this->input->post('payment_id')));

    if (count($bulan)>0) {
      $this->session->set_flashdata('failed', 'Pembayaran tidak dapat dihapus');
      redirect('manage/payment');
    } else if (count($bebas)>0) {
      $this->session->set_flashdata('failed', 'Pembayaran tidak dapat dihapus');
      redirect('manage/payment');
    }

    $this->Payment_model->delete($this->input->post('payment_id'));
            // activity log
    $this->load->model('logs/Logs_model');
    $this->Logs_model->add(
      array(
        'log_date' => date('Y-m-d H:i:s'),
        'user_id' => $this->session->userdata('uid'),
        'log_module' => 'Jenis Pembayaran',
        'log_action' => 'Hapus',
        'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
      )
    );
    $this->session->set_flashdata('success', 'Hapus Jenis Pembayaran berhasil');
    redirect('manage/payment');
  } elseif (!$_POST) {
    $this->session->set_flashdata('delete', 'Delete');
    redirect('manage/payment/edit/' . $id);
  }
}

function get_student(){
    $params = array();
    $id_kelas = $this->input->post('id_kelas');
    $params['class_id'] = $id_kelas;
    $student  = $this->Student_model->get($params);
    
    echo '<select name="student_id" class="form-control">
			<option value="">-- Pilih Santri --</option>';
			foreach($student as $row){
			echo '<option value="'.$row['student_id'].'">'.$row['student_full_name'].'</option>';
			}
	echo '</select>';
}

    function get_form(){
      
        for($count = 0; $count < count($_POST["student_id"]); $count++)
        {
            $student = $this->db->query("SELECT student_id
                                        FROM student
                                        WHERE student_id IN (".$_POST['student_id'][$count].")")->result_array();
        
            foreach($student as $row){
    		    echo '<input type="hidden" name="student_id[]" id="student_id" value="'.$row['student_id'].'">';
    	    }
        }
    }

}