<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('employees/Employees_model', 'employees/Employees_detail_model', 'position/Position_model', 'student/Student_model', 'setting/Setting_model'));
    $this->load->helper(array('form', 'url'));
  }

    // User_customer view in list
  public function index($offset = NULL) {
    $this->load->library('pagination');
    // Apply Filter
    // Get $_GET variable
    $f = $this->input->get(NULL, TRUE);
    $s = $this->input->get(NULL, TRUE);

    $data['f'] = $f;
    $data['s'] = $s;

    $params = array();
    $param = array();
    // Nip
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['employee_search'] = $f['n'];
    } 
    
    if (isset($s['m']) && !empty($s['m']) && $s['m'] != '') {
      $params['majors_id'] = $s['m'];
    }

    $data['employee'] = $this->Employees_model->get($params);
    $data['majors'] = $this->Student_model->get_majors();
    $data['position'] = $this->Position_model->get();

    $config['base_url'] = site_url('manage/student/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");

    $data['title'] = 'Pegawai';
    $data['main'] = 'employees/employees_list';
    $this->load->view('manage/layout', $data);
  }
  
  function searching_position(){
	    $id_majors = $this->input->post('id_majors');
        $dataPosition  = $this->db->query("SELECT * FROM position WHERE position_majors_id = '$id_majors' ORDER BY position_name ASC")->result_array();
    
        echo '<select style="width: 200px;" id="p" name="p" class="form-control" required>
    			<option value="">--- Pilih Jabatan ---</option>
    			<option value="all">Semua Jabatan</option>';
              foreach($dataPosition as $row){ 

                echo '<option value="'.$row['position_id'].'">';
                    
                echo $row['position_name'];
                    
                echo '</option>';
            
                }
        echo '</select>';
	}
  
  function get_position(){
        $id_majors   = $this->input->post('id_majors');
        $dataPosition  = $this->db->query("SELECT * FROM position WHERE position_majors_id = '$id_majors' ORDER BY position_name ASC")->result_array();
    
        echo '<div class="form-group"> 
			<label >Jabatan *</label>
            <select name="employee_position_id" id="employee_position_id" class="form-control">
				<option value=""> -- Pilih Jabatan -- </option>';
                      foreach($dataPosition as $row){ 
        
                        echo '<option value="'.$row['position_id'].'">';
                            
                        echo $row['position_name'];
                            
                        echo '</option>';
                    
                        }
                                        
        echo '</select>
            </div>';
    }

    // Add User and Update
  public function add($id = NULL) {

    $this->load->library('form_validation');

    if (!$this->input->post('employee_id')) {
      $this->form_validation->set_rules('employee_nip', 'NIP', 'trim|required|xss_clean|is_unique[employee.employee_nip]');
    }
    $this->form_validation->set_rules('employee_position_id', 'Jabatan', 'trim|required|xss_clean');
    $this->form_validation->set_rules('employee_name', 'Nama lengkap', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('employee_id')) {
        $params['employee_id'] = $id;
      } else {
        $params['employee_input_date'] = date('Y-m-d H:i:s');
        $default = "123456";
        $pass = $this->input->post('employee_password');
        if($pass !=''){
            $params['employee_password'] = md5($pass);
        } else {
            $params['employee_password'] = md5($default);
        }
      }
      $params['employee_nip'] = $this->input->post('employee_nip');
      $params['employee_gender'] = $this->input->post('employee_gender');
      $params['employee_phone'] = $this->input->post('employee_phone');
      $params['employee_email'] = $this->input->post('employee_email');
      $params['employee_position_id'] = $this->input->post('employee_position_id');
      $params['employee_majors_id'] = $this->input->post('employee_majors_id');
      $params['employee_category'] = $this->input->post('employee_category');
      $params['employee_last_update'] = date('Y-m-d H:i:s');
      $params['employee_name'] = $this->input->post('employee_name');
      $params['employee_born_place'] = $this->input->post('employee_born_place'); 
      $params['employee_born_date'] = $this->input->post('employee_born_date'); 
      $params['employee_address'] = $this->input->post('employee_address'); 
      $params['employee_strata'] = $this->input->post('employee_strata'); 
      $params['employee_start'] = $this->input->post('employee_start'); 
      $params['employee_end'] = $this->input->post('employee_end'); 
      $params['employee_status'] = $this->input->post('employee_status'); 
      $status = $this->Employees_model->add($params);

      if (!empty($_FILES['employee_photo']['name'])) {
        $paramsupdate['employee_photo'] = $this->do_upload($name = 'employee_photo', $fileName= $params['employee_name']);
      } 

      $paramsupdate['employee_id'] = $status;
      $this->Employees_model->add($paramsupdate);

    // activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Student',
          'log_action' => $data['operation'],
          'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('employee_name')
        )
      );

      $this->session->set_flashdata('success', $data['operation'] . ' Pegawai Berhasil');
      redirect('manage/employees');
    } else {
      if ($this->input->post('employee_id')) {
        redirect('manage/employees/edit/' . $this->input->post('employee_id'));
      }

    // Edit mode
      if (!is_null($id)) {
        $object = $this->Employees_model->get(array('id' => $id));
        if ($object == NULL) {
        } else {
          $data['employee'] = $object;
        }
        $id_unit = $object['majors_id'];
        $data['position'] = $this->db->query("SELECT * FROM position WHERE position.position_majors_id = '$id_unit' ORDER BY position_name")->result_array();
      }
      $data['setting_level'] = $this->Setting_model->get(array('id' => 7)); 
      //$data['ngapp'] = 'ng-app="classApp"';
      $data['majors'] = $this->Student_model->get_majors();
      $data['title'] = $data['operation'] . ' Pegawai';
      $data['main'] = 'employees/employees_add';
      $this->load->view('manage/layout', $data);
    }
  }

    // View data detail
  public function view($id = NULL) {
    $x = $this->uri->segment('4');
    $data['education']      = $this->Employees_detail_model->get_education($x);
    $data['workshop']       = $this->Employees_detail_model->get_workshop($x);
    $data['family']         = $this->Employees_detail_model->get_family($x);
    $data['position']       = $this->Employees_detail_model->get_position($x);
    $data['teaching']       = $this->Employees_detail_model->get_teaching($x);
    $data['achievement']    = $this->Employees_detail_model->get_achievement($x);
    $data['employee']       = $this->Employees_model->get(array('id' => $id));
    $data['title']          = 'Detail Pegawai';
    $data['main']           = 'employees/employees_view';
    $this->load->view('manage/layout', $data);
  }

    // Delete to database
  public function delete($id = NULL) {
    if ($_POST) {
      $this->Employees_model->delete($this->input->post('employee_id'));

      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'user',
          'log_action' => 'Hapus',
          'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
        )
      );
      $this->session->set_flashdata('success', 'Hapus Pegawai berhasil');
      redirect('manage/employees');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/employees/edit/' . $id);
    }
  }

    // Class view in list
  public function clasess($offset = NULL) {
    $this->load->library('pagination');

    $data['class'] = $this->Student_model->get_class(array('limit' => 10, 'offset' => $offset));
    $data['title'] = 'Daftar Kelas';
    $data['main'] = 'student/class_list';
    $config['total_rows'] = count($this->Student_model->get_class());
    $this->pagination->initialize($config);

    $this->load->view('manage/layout', $data);
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
  
  public function import_employees(){
        $data['title'] = 'Import Data Pegawai';
        $data['main'] = 'employees/employees_import';
        $data['action'] = site_url(uri_string());
        $this->load->view('manage/layout', $data);
  }
  
  public function download() {
    $data = file_get_contents("./media/template_excel/Template_Data_Pegawai.xls");
    $name = 'Template_Data_Pegawai.xls';

  $this->load->helper('download');
  force_download($name, $data);
}
  
  public function do_import(){
    $default = "123456";
    $this->load->library('excel');
    if(isset($_FILES["file"]["name"]))
	{      
        $path = $_FILES["file"]["tmp_name"];
		$object = PHPExcel_IOFactory::load($path);
		foreach($object->getWorksheetIterator() as $worksheet)
		{
			$highestRow = $worksheet->getHighestRow();
			$highestColumn = $worksheet->getHighestColumn();
			for($row=3; $row<=$highestRow; $row++)
			{
				$employee_nip           = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				$employee_name          = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$employee_majors_id     = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$employee_position_id   = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				$employee_status        = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				$employee_wa            = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				
				$q = $this->db->query("SELECT COUNT(employee_nip) as nipNum FROM employee WHERE employee_nip = '$employee_nip'")->row_array();
				$nipNum = $q['nipNum'];
				
				if(empty($employee_nip) || $nipNum != 0){
				    $this->session->set_flashdata('failed', 'Duplikasi No. Induk Pegawai');
				} else {
				    
				    $employee_wa = str_replace(" ","",$employee_wa);
                    $employee_wa = str_replace("(","",$employee_wa);
                    $employee_wa = str_replace(")","",$employee_wa);
                    $employee_wa = str_replace(".","",$employee_wa);
                    
                    if(!preg_match('/[^+0-9]/',trim($employee_wa)))
                    {
                    	 if(substr(trim($employee_wa), 0, 1)=='+')
                    	 {
                    	 $hp = trim($employee_wa);
                    	 }
                    	 elseif(substr(trim($employee_wa), 0, 1)=='0')
                    	 {
                    	 $hp = '+62'.substr(trim($employee_wa), 1);
                    	 }
                    	 elseif(substr(trim($employee_wa), 0, 2)=='62')
                    	 {
                    	 $hp = '+'.trim($employee_wa);
                    	 }
                    	 elseif(substr(trim($employee_wa), 0, 1)=='8')
                    	 {
                    	 $hp = '+62'.trim($employee_wa);
                    	 }
                    	 else
                    	 {
                    	 $hp = '+'.trim($employee_wa);
                    	 }		 
                    }
                    
    				$data[] = array(
    					'employee_nip'		    =>	$employee_nip,
    					'employee_name'	        =>	$employee_name,
    					'employee_password'	    =>	md5($default),
    					'employee_majors_id'	=>	$employee_majors_id,
    					'employee_position_id'	=>	$employee_position_id,
    					'employee_status'	    =>	$employee_status,
    					'employee_phone'	    =>	$hp
    				);
				}
			}
		}
          
        $this->db->insert_batch('employee', $data);
        $this->session->set_flashdata('success', 'Import Data Pegawai Berhasil');
		redirect('manage/employees');
	}
  }

function rpw($id = NULL) {
  $this->load->library('form_validation');
  $this->form_validation->set_rules('employee_password', 'Password', 'trim|required|xss_clean|min_length[6]');
  $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|xss_clean|min_length[6]|matches[employee_password]');
  $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
  if ($_POST AND $this->form_validation->run() == TRUE) {
    $id = $this->input->post('employee_id');
    $default = "123456";
    $pass = $this->input->post('employee_password');
    if($pass !=''){
        $params['employee_password'] = md5($pass);
    } else {
        $params['employee_password'] = md5($default);
    }
    $status = $this->Employees_model->change_password($id, $params);

    $this->session->set_flashdata('success', 'Reset Password Berhasil');
    redirect('manage/employees');
  } else {
    if ($this->Employees_model->get(array('id' => $id)) == NULL) {
      redirect('manage/employees');
    }
    $data['employee'] = $this->Employees_model->get(array('id' => $id));
    $data['title'] = 'Reset Password';
    $data['main'] = 'employees/change_pass';
    $this->load->view('manage/layout', $data);
  }
}

function printEmployees($id){
    ob_start();
        
    $data['education']      = $this->Employees_detail_model->get_education($id);
    $data['workshop']       = $this->Employees_detail_model->get_workshop($id);
    $data['family']         = $this->Employees_detail_model->get_family($id);
    $data['position']       = $this->Employees_detail_model->get_position($id);
    $data['teaching']       = $this->Employees_detail_model->get_teaching($id);
    $data['achievement']    = $this->Employees_detail_model->get_achievement($id);
    $data['employee']       = $this->Employees_model->get(array('id' => $id));
    $employee       = $this->Employees_model->get(array('id' => $id));  

    $filename = 'Data Pegawai NIP '.$employee['employee_nip'].' Nama '.$employee['employee_name'].'.pdf';
    $this->load->view('employees/employees_print',$data);
    
    $html = ob_get_contents();
    ob_end_clean();
    
    require_once('./assets/html2pdf/html2pdf.class.php');
    $pdf = new HTML2PDF('P','A4','en');
    $pdf->WriteHTML($html);
    $pdf->Output($filename);
}

function print_employees()
{
    $this->load->model('setting/Setting_model');
    ob_start();
    // $f = $_POST['modal_majors'];
    // $s = $_POST['modal_posision'];
    $f = $this->input->post(NULL, TRUE);
    $s = $this->input->post(NULL, TRUE);

    
    $data['f'] = $f;
    $data['s'] = $s;
    $params = array();
    $id_majors = $f['modal_majors'];
    
    $data['majors']  = $this->db->query("SELECT majors_short_name FROM majors WHERE majors_id = '$id_majors'")->row_array();
    $majors = $data['majors'];
    if (isset($s['modal_posision']) && !empty($s['modal_posision']) && $s['modal_posision'] != '') {
      $params['employee_position_id'] = $s['modal_posision'];
    }
    $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
    $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
    $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
    $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
    $data['employee'] = $this->Employees_model->get($params);

    $filename = 'Data Pegawai '. $data['majors']['majors_short_name'].'.pdf';
    $this->load->view('employees/employees_cetak', $data);

    $html = ob_get_contents();
    ob_end_clean();

    require_once('./assets/html2pdf/html2pdf.class.php');
    $pdf = new HTML2PDF('L', 'A4', 'en');
    $pdf->WriteHTML($html);
    $pdf->Output($filename);
  
}

function printPdf($id = NULL) {
  $this->load->helper(array('dompdf'));
  $this->load->helper(array('tanggal'));
  $this->load->model('employees/Employees_model');
  $this->load->model('setting/Setting_model');
  if ($id == NULL)
    redirect('manage/employees');

  $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
  $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
  $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
  $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
  $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY)); 
  $data['employee'] = $this->Employees_model->get(array('id' => $id));
  $this->barcode2($data['employee']['employee_nip'], '');
  $html = $this->load->view('employees/employees_pdf', $data, true);
  $data = pdf_create($html, $data['employee']['employee_name'], TRUE, 'A4', 'potrait');
}

private function barcode2($sparepart_code, $barcode_type=39, $scale=6, $fontsize=1, $thickness=30,$dpi=72) {

  $this->load->library('upload');
  $config['upload_path'] = FCPATH . 'media/barcode_employees/';

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
    $drawing->setFilename( FCPATH .'media/barcode_employees/'. $sparepart_code.'.png');
    // proses penyimpanan barcode hasil generate
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

    return $filename_img_barcode;

  }
  
  //---------------------------Detail Employee--------------------------------
  
  //-------------------------------Adding-------------------------------------
  
  public function add_education(){
		if ($_POST == TRUE) {
		    $employeeID     = $_POST['employee_id'];
		    $eduStart    = $_POST['thn_masuk'];
			$eduEnd      = $_POST['thn_lulus'];
			$eduName     = $_POST['sekolah'];
			$eduLocation = $_POST['lokasi'];
			$cpt = count($_POST['sekolah']);
			for ($i = 0; $i < $cpt; $i++) {
				$params['education_start']       = $eduStart[$i];
				$params['education_end']         = $eduEnd[$i];
				$params['education_name']        = $eduName[$i];
				$params['education_location']    = $eduLocation[$i];
				$params['education_employee_id'] = $this->input->post('employee_id');

				$this->Employees_detail_model->add_education($params);
			}
		}
		$this->session->set_flashdata('success',' Tambah Riwayat Pendidikan Berhasil');
		redirect('manage/employees/view/'.$employeeID);
	}
	
	public function add_workshop(){
		if ($_POST == TRUE) {
		    $employeeID     = $_POST['employee_id'];
		    $workStart      = $_POST['start_date'];
			$workEnd        = $_POST['end_date'];
			$workOrganizer  = $_POST['penyelenggara'];
			$workLocation   = $_POST['lokasi'];
			$cpt = count($_POST['penyelenggara']);
			for ($i = 0; $i < $cpt; $i++) {
				$params['workshop_start']       = $workStart[$i];
				$params['workshop_end']         = $workEnd[$i];
				$params['workshop_organizer']   = $workOrganizer[$i];
				$params['workshop_location']    = $workLocation[$i];
				$params['workshop_employee_id'] = $this->input->post('employee_id');

				$this->Employees_detail_model->add_workshop($params);
			}
		}
		$this->session->set_flashdata('success',' Tambah Riwayat Seminar & Pelatihan Berhasil');
		redirect('manage/employees/view/'.$employeeID);
	}
	
	public function add_family(){
		if ($_POST == TRUE) {
		    $employeeID = $_POST['employee_id'];
		    $famName    = $_POST['fam_name'];
			$famDesc    = $_POST['fam_desc'];
			$cpt = count($_POST['fam_name']);
			for ($i = 0; $i < $cpt; $i++) {
				$params['fam_name']         = $famName[$i];
				$params['fam_desc']         = $famDesc[$i];
				$params['fam_employee_id']  = $this->input->post('employee_id');

				$this->Employees_detail_model->add_family($params);
			}
		}
		$this->session->set_flashdata('success',' Tambah Data Keluarga Berhasil');
		redirect('manage/employees/view/'.$employeeID);
	}
	
    public function add_position(){
		if ($_POST == TRUE) {
		    $employeeID         = $_POST['employee_id'];
		    $posHistoryStart    = $_POST['position_start'];
		    $posHistoryEnd      = $_POST['position_end'];
			$posHistoryDesc     = $_POST['position_desc'];
			$cpt = count($_POST['position_desc']);
			for ($i = 0; $i < $cpt; $i++) {
				$params['poshistory_start']         = $posHistoryStart[$i];
				$params['poshistory_end']           = $posHistoryEnd[$i];
				$params['poshistory_desc']          = $posHistoryDesc[$i];
				$params['poshistory_employee_id']   = $this->input->post('employee_id');

				$this->Employees_detail_model->add_position($params);
			}
		}
		$this->session->set_flashdata('success',' Tambah Riwayat Jabatan Berhasil');
		redirect('manage/employees/view/'.$employeeID);
	}
    
    public function add_teaching(){
		if ($_POST == TRUE) {
		    $employeeID     = $_POST['employee_id'];
		    $teachingStart  = $_POST['teaching_start'];
		    $teachingEnd    = $_POST['teaching_end'];
			$teachingLesson = $_POST['teaching_lesson'];
			$teachingDesc   = $_POST['teaching_desc'];
			$cpt = count($_POST['teaching_desc']);
			for ($i = 0; $i < $cpt; $i++) {
				$params['teaching_start']       = $teachingStart[$i];
				$params['teaching_end']         = $teachingEnd[$i];
				$params['teaching_lesson']      = $teachingLesson[$i];
				$params['teaching_desc']        = $teachingDesc[$i];
				$params['teaching_employee_id'] = $this->input->post('employee_id');

				$this->Employees_detail_model->add_teaching($params);
			}
		}
		$this->session->set_flashdata('success',' Tambah Riwayat Mengajar Berhasil');
		redirect('manage/employees/view/'.$employeeID);
	}
  
    public function add_achievement(){
		if ($_POST == TRUE) {
		    $employeeID         = $_POST['employee_id'];
		    $achievementYear    = $_POST['achievement_year'];
		    $achievementName    = $_POST['achievement_name'];
			$cpt = count($_POST['achievement_name']);
			for ($i = 0; $i < $cpt; $i++) {
				$params['achievement_year']         = $achievementYear[$i];
				$params['achievement_name']         = $achievementName[$i];
				$params['achievement_employee_id']  = $this->input->post('employee_id');

				$this->Employees_detail_model->add_achievement($params);
			}
		}
		$this->session->set_flashdata('success',' Tambah Penghargaan Berhasil');
		redirect('manage/employees/view/'.$employeeID);
	}

    //------------------------------Deleting------------------------------------

	public function delete_education($id = NULL) {
		if ($_POST) {
		    $x = $this->input->post('employee_id');
			$this->Employees_detail_model->delete_education($id);
			$this->session->set_flashdata('success', 'Hapus Riwayat Pendidikan berhasil');
			redirect('manage/employees/view/'.$x);
		} elseif (!$_POST) {
		    $x = $this->input->post('employee_id');
			$this->session->set_flashdata('delete', 'Delete');
			redirect('manage/employees/view/'.$x);
		}
	}
	
	public function delete_workshop($id = NULL) {
		if ($_POST) {
		    $x = $this->input->post('employee_id');
			$this->Employees_detail_model->delete_workshop($id);
			$this->session->set_flashdata('success', 'Hapus Riwayat Seminar & Pelatihan berhasil');
			redirect('manage/employees/view/'.$x);
		} elseif (!$_POST) {
		    $x = $this->input->post('employee_id');
			$this->session->set_flashdata('delete', 'Delete');
			redirect('manage/employees/view/'.$x);
		}
	}

	public function delete_family($id = NULL) {
		if ($_POST) {
		    $x = $this->input->post('employee_id');
			$this->Employees_detail_model->delete_family($id);
			$this->session->set_flashdata('success', 'Hapus Data Keluarga berhasil');
			redirect('manage/employees/view/'.$x);
		} elseif (!$_POST) {
		    $x = $this->input->post('employee_id');
			$this->session->set_flashdata('delete', 'Delete');
			redirect('manage/employees/view/'.$x);
		}
	}
    
	public function delete_position($id = NULL) {
		if ($_POST) {
		    $x = $this->input->post('employee_id');
			$this->Employees_detail_model->delete_position($id);
			$this->session->set_flashdata('success', 'Hapus Riwayat Jabatan berhasil');
			redirect('manage/employees/view/'.$x);
		} elseif (!$_POST) {
		    $x = $this->input->post('employee_id');
			$this->session->set_flashdata('delete', 'Delete');
			redirect('manage/employees/view/'.$x);
		}
	}

	public function delete_teaching($id = NULL) {
		if ($_POST) {
		    $x = $this->input->post('employee_id');
			$this->Employees_detail_model->delete_teaching($id);
			$this->session->set_flashdata('success', 'Hapus Riwayat Mengajar berhasil');
			redirect('manage/employees/view/'.$x);
		} elseif (!$_POST) {
		    $x = $this->input->post('employee_id');
			$this->session->set_flashdata('delete', 'Delete');
			redirect('manage/employees/view/'.$x);
		}
	}
	
	public function delete_achievement($id = NULL) {
		if ($_POST) {
		    $x = $this->input->post('employee_id');
			$this->Employees_detail_model->delete_achievement($id);
			$this->session->set_flashdata('success', 'Hapus Penghargaan berhasil');
			redirect('manage/employees/view/'.$x);
		} elseif (!$_POST) {
		    $x = $this->input->post('employee_id');
			$this->session->set_flashdata('delete', 'Delete');
			redirect('manage/employees/view/'.$x);
		}
	}

}