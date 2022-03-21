<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_student extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged_student') == NULL) {
      header("Location:" . site_url('student/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $this->load->model(array('student/Student_model','logs/Logs_model'));
    $this->load->helper(array('form', 'url'));
  }

  public function index($offset = NULL) {
    $id = $this->session->userdata('uid_student');
    if ($this->Student_model->get_student(array('id' => $id)) == NULL) {
      redirect('student');
    }
    $data['student'] = $this->Student_model->get_student(array('id' => $id));
    $data['title'] = 'Detail Profil';
    $data['main'] = 'profile/profile_view_student';
    $this->load->view('student/layout', $data);
  }

    // Add User and Update
  public function edit($id = NULL) {
    $data['operation'] = 'Edit Profil';

    if ($_POST == TRUE) {
      		    
        $student_parent_phone = $this->input->post('student_parent_phone');
              		    
        $student_parent_phone = str_replace(" ","",$student_parent_phone);
        $student_parent_phone = str_replace("(","",$student_parent_phone);
        $student_parent_phone = str_replace(")","",$student_parent_phone);
        $student_parent_phone = str_replace(".","",$student_parent_phone);
        
        if(!preg_match('/[^+0-9]/',trim($student_parent_phone)))
        {
        	 if(substr(trim($student_parent_phone), 0, 1)=='+')
        	 {
        	 $hp = trim($student_parent_phone);
        	 }
        	 elseif(substr(trim($student_parent_phone), 0, 1)=='0')
        	 {
        	 $hp = '+62'.substr(trim($student_parent_phone), 1);
        	 }
        	 elseif(substr(trim($student_parent_phone), 0, 2)=='62')
        	 {
        	 $hp = '+'.trim($student_parent_phone);
        	 }
        	 elseif(substr(trim($student_parent_phone), 0, 1)=='8')
        	 {
        	 $hp = '+62'.trim($student_parent_phone);
        	 }
        	 else
        	 {
        	 $hp = '+'.trim($student_parent_phone);
        	 }		 
        }

      $params['student_id'] = $this->input->post('student_id');
      $params['student_gender'] = $this->input->post('student_gender');
      $params['student_last_update'] = date('Y-m-d H:i:s');
      $params['student_born_place'] = $this->input->post('student_born_place'); 
      $params['student_born_date'] = $this->input->post('student_born_date'); 
      $params['student_address'] = $this->input->post('student_address'); 
      $params['student_name_of_mother'] = $this->input->post('student_name_of_mother'); 
      $params['student_name_of_father'] = $this->input->post('student_name_of_father'); 
      $params['student_parent_phone'] = $hp; 

      
      $status = $this->Student_model->add($params);

      if (!empty($_FILES['student_img']['name'])) {
        $paramsupdate['student_img'] = $this->do_upload($name = 'student_img', $fileName= base64_encode($params['student_full_name']));
      } 

      $paramsupdate['student_id'] = $status;
      $this->Student_model->add($paramsupdate);


      $this->session->set_flashdata('success', $data['operation'] . ' Santri Berhasil');
      redirect('student/profile');
    } else {
      if ($this->input->post('student_id')) {
        redirect('student/profile/edit/' . $this->input->post('student_id'));
      }

            // Edit mode
      $data['student'] = $this->Student_model->get_student(array('id' => $this->session->userdata('uid_student')));
      $data['title'] = $data['operation'] . ' Santri';
      $data['main'] = 'profile/profile_edit_student';
      $this->load->view('student/layout', $data);
    }
  }

    // Setting Upload File Requied
  function do_upload($name=NULL, $fileName=NULL) {
    $this->load->library('upload');

    $config['upload_path'] = FCPATH . 'uploads/student/';

    /* create directory if not exist */
    if (!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }

    $config['allowed_types'] = 'gif|jpg|jpeg|png';
    $config['max_size'] = '1024';
    $config['file_name'] = $fileName;
    $this->upload->initialize($config);

    if (!$this->upload->do_upload($name)) {
      $this->session->set_flashdata('success', $this->upload->display_errors('', ''));
      redirect(uri_string());
    }

    $upload_data = $this->upload->data();

    return $upload_data['file_name'];
  }



    // Change Password student
  function cpw() {
    $this->load->model('Logs_model');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('student_password', 'Password', 'required|matches[passconf]|min_length[6]');
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|min_length[6]');
    $this->form_validation->set_rules('student_current_password', 'Old Password', 'required|callback_check_current_password');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    if ($_POST AND $this->form_validation->run() == TRUE) {
      $old_password = $this->input->post('student_current_password');

      $params['student_password'] = md5($this->input->post('student_password'));
      $status = $this->Student_model->change_password($this->session->userdata('uid_student'), $params);

      $this->session->set_flashdata('success', 'Ubah password Santri berhasil');
      redirect('student/profile');
    } else {
      if ($this->Student_model->get_student(array('id' => $this->session->userdata('uid_student'))) == NULL) {
        redirect('student');
      }
      $data['title'] = 'Ganti Password Santri';
      $data['main'] = 'profile/change_pass_student';
      $this->load->view('student/layout', $data);
    }
  }

  function check_current_password() {

    $pass = $this->input->post('student_current_password');
    $student = $this->Student_model->get_student(array('id' => $this->session->userdata('uid_student')));
    if (md5($pass) == $student['student_password']) {
      return TRUE;
    } else {
      $this->form_validation->set_message('check_current_password', 'The Password did not same with the current password');
      return FALSE;
    }
  }
      // satuan
    function printPdf($id = NULL) {
      $this->load->helper(array('dompdf'));
      $this->load->helper(array('tanggal'));
      $this->load->model('student/Student_model');
      $this->load->model('setting/Setting_model');
      if ($id == NULL)
        redirect('manage/student');
    
      $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
      $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
      $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
      $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
      $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY)); 
      $data['student'] = $this->Student_model->get_student(array('id' => $id));
      $this->barcode2($data['student']['student_nis'], '');
      $html = $this->load->view('profile/profile_print', $data, true);
      $data = pdf_create($html, $data['student']['student_full_name'], TRUE, 'B6', 'potrait');
      
      //$this->load->view('profile/profile_print', $data);
    }

    private function barcode2($sparepart_code, $barcode_type=39, $scale=6, $fontsize=1, $thickness=30,$dpi=72) {

  $this->load->library('upload');
  $config['upload_path'] = FCPATH . 'media/barcode_student/';

  /* create directory if not exist */
  if (!is_dir($config['upload_path'])) {
    mkdir($config['upload_path'], 0777, TRUE);
  }
  $this->upload->initialize($config);

    // CREATE BARCODE GENERATOR
    // Including all required classes
  require_once( APPPATH . 'libraries/barcodegen/BCGFontFile.php');
  require_once( APPPATH . 'libraries/barcodegen/BCGColor.php');
  require_once( APPPATH . 'libraries/barcodegen/BCGDrawing.php');

    // Including the barcode technology
    // Ini bisa diganti-ganti mau yang 39, ato 128, dll, liat di folder barcodegen
  require_once( APPPATH . 'libraries/barcodegen/BCGcode39.barcode.php');

    // Loading Font
    // kalo mau ganti font, jangan lupa tambahin dulu ke folder font, baru loadnya di sini
  $font = new BCGFontFile(APPPATH . 'libraries/font/Arial.ttf', $fontsize);

    // Text apa yang mau dijadiin barcode, biasanya kode produk
  $text = $sparepart_code;

    // The arguments are R, G, B for color.
  $color_black = new BCGColor(0, 0, 0);
  $color_white = new BCGColor(255, 255, 255);

  $drawException = null;
  try {
        $code = new BCGcode39(); // kalo pake yg code39, klo yg lain mesti disesuaikan
        $code->setScale($scale); // Resolution
        $code->setThickness($thickness); // Thickness
        $code->setForegroundColor($color_black); // Color of bars
        $code->setBackgroundColor($color_white); // Color of spaces
        $code->setFont($font); // Font (or 0)
        $code->parse($text); // Text
      } catch(Exception $exception) {
        $drawException = $exception;
      }

    /* Here is the list of the arguments
    1 - Filename (empty : display on screen)
    2 - Background color */
    $drawing = new BCGDrawing('', $color_white);
    if($drawException) {
      $drawing->drawException($drawException);
    } else {
      $drawing->setDPI($dpi);
      $drawing->setBarcode($code);
      $drawing->draw();
    }
    // ini cuma labeling dari sisi aplikasi saya, penamaan file menjadi png barcode.
    $filename_img_barcode = $sparepart_code .'_'.$barcode_type.'.png';
    // folder untuk menyimpan barcode
    $drawing->setFilename( FCPATH .'media/barcode_student/'. $sparepart_code.'.png');
    // proses penyimpanan barcode hasil generate
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

    return $filename_img_barcode;

  }

}
