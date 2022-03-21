<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Bayarhutang_set extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged') == NULL) {
          header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('settinghutang/Settinghutang_model', 'employees/Employees_model', 'bayarhutang/bayarhutang_model', 'period/Period_model', 'poshutang/Poshutang_model', 'bulan/Bulan_model', 'hutang/Hutang_model', 'hutang/Hutang_pay_model', 'setting/Setting_model', 'letter_hutang/Letter_hutang_model', 'logs/Logs_model', 'ltrx/Log_trx_model'));
    }

    // settinghutang view in list
    public function index($offset = NULL, $id =NULL) {
        // Apply Filter
        // Get $_GET variable
        $f = $this->input->get(NULL, TRUE);
        
        $data['f']      = $f;
        $majorsID       = '';
        $kreditur       = null;
        $periodID       = null;
        $krediturID     = null;
        $hutangNoref    = null;
        $params         = array();
        
        // Tahun Ajaran
        if (isset($f['n']) && !empty($f['n']) && $f['n'] != '' && $f['n'] != '0') {
          $params['period_id']      = $f['n'];
          $periodID                 = $f['n'];
        }
        
        // Siswa
        if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
            $params['hutang_noref']    = $f['r'];
            $kreditur = $this->Hutang_model->get(array('hutang_noref'=>$f['r']));
            $krediturID = $kreditur['hutang_employee_id'];
            $sumHutang      = $this->Hutang_model->get(array('hutang_noref'=>$params['hutang_noref']));
            $sumHutangPay   = $this->Hutang_pay_model->get_sum(array('hutang_noref'=>$params['hutang_noref'], 'hutang_pay_status' => '1'));
            
            $data['sumHutang']   = $sumHutang['hutang_bill'];    
            
            $data['sumHutangPay']  = $sumHutangPay['hutang_dibayar'];
            
            $majorsID = $sumHutang['majors_id'];
        }
        
        $data['kreditur'] = $this->Hutang_model->get(array('employee_id'=>$kreditur['hutang_employee_id'], 'group'=>TRUE));
        
        $data['periodActive'] = $this->db->query("SELECT period_id FROM period WHERE period_status = '1'")->row_array();
        $data['period']     = $this->Period_model->get($params);
        $data['history']    = $this->Hutang_pay_model->get(array('period_id'=>$periodID, 'employee_id'=>$kreditur['employee_id'], 'hutang_pay_status' => '1'));
        
        $data['hutang_pay']    = $this->Hutang_pay_model->get($params);
        
        $data['majors']     = $this->Settinghutang_model->get();
        
        $data['dataKas'] = $this->db->query("SELECT * FROM account WHERE account_category = '2' AND account_majors_id = '$majorsID' AND account_code LIKE '1%' AND account_note IN (SELECT account_id FROM account WHERE account_category = '0' AND account_majors_id = '$majorsID' AND account_code LIKE '1%' AND account_description LIKE '%Aktiva%' ORDER BY account_code ASC) ORDER BY account_code ASC")->result_array();
        
        $data['dataKasActive'] = $this->db->query("SELECT account_id FROM account WHERE account_category = '2' AND account_majors_id = '$majorsID' AND account_code LIKE '1%' AND account_description LIKE '%Tunai%'")->row_array();
        
        $data['title']      = 'Hutang';
        $data['main']       = 'bayarhutang/bayarhutang_list';
        $this->load->view('manage/layout', $data);
    } 
  
    function pay() { 
        $hutang_pay_id          = $this->input->post('hutang_pay_id');
        $hutang_pay_account_id  = $this->input->post('kas_account_id');
        
        $lastletter     = $this->Letter_hutang_model->get(array('limit' => 1));
        $employee       = $this->Hutang_pay_model->get(array('id'=>$hutang_pay_id));
        $hutang         = $this->Hutang_model->get(array('id' => $employee['hutang_noref']));
    
        if ($lastletter['letter_hutang_year'] < date('Y') OR count($lastletter) == 0) {
          $this->Letter_hutang_model->add(array('letter_hutang_number' => '00001', 'letter_hutang_month' => date('m'), 'letter_hutang_year' => date('Y')));
          $nomor    = sprintf('%05d', '00001');
          $nofull   = date('Y'). date('m'). $nomor;
        } else {
          $nomor = sprintf('%05d', $lastletter['letter_hutang_number'] + 00001);
          $this->Letter_hutang_model->add(array('letter_hutang_number' => $nomor, 'letter_hutang_month' => date('m'), 'letter_hutang_year' => date('Y')));
          $nofull = date('Y'). date('m'). $nomor;
        }
    
        $pay = array(
          'hutang_pay_id'           => $hutang_pay_id,
          'hutang_pay_number'       => $nofull,
          'hutang_pay_account_id'   => $hutang_pay_account_id,
          'hutang_pay_input_date'   => date('Y-m-d H:i:s'),
          'hutang_pay_last_update'  => date('Y-m-d H:i:s'),
          'hutang_pay_status'       => 1,
          'user_user_id'            => $this->session->userdata('uid')
        );
    
        $log = array(
          'log_hutang_hutang_id'    => $hutang['hutang_id'],
          'log_hutang_employee_id'  => $hutang['employee_id'],
          'log_hutang_pay_id'       => $hutang_pay_id,
          'log_hutang_input_date'   => date('Y-m-d H:i:s'),
          'log_hutang_last_update'  => date('Y-m-d H:i:s'),
          'user_user_id'            => $this->session->userdata('uid')
        );
    
        $status = $this->Hutang_pay_model->add($pay);
        
        $this->Log_hutang_model->add($log);
    
        if ($this->input->is_ajax_request()) {
          echo $status;
        } else {
          $this->session->set_flashdata('success', 'Pembayaran Hutang Berhasil');
          redirect('manage/bayarhutang?n='.$employee['settinghutang_period_id'].'&r='.$employee['hutang_noref']);
        }
    }
    
    function not_pay() {
        $student_id     = $this->input->post('student_id');
        
        $student = $this->Bulan_model->get(array('student_id'=>$student_id,'id'=>$id));
        
        $pay = array(
          'bulan_id' => $id,
          'bulan_number_pay' => NULL,
          'bulan_account_id' => NULL,
          'bulan_noref'      => NULL,
          'bulan_status' => 0,
          'bulan_date_pay' => NULL,
          'bulan_last_update' => date('Y-m-d H:i:s'),
          'user_user_id' => NULL
        );
    
        $this->Log_trx_model->delete_log(array(
          'student_id' => $student_id,
          'bulan_id' => $id
        ));
    
        $this->Bulan_model->add($pay);
        if ($this->input->is_ajax_request()) {
          echo $status;
        } else {
          $this->session->set_flashdata('success', 'Hapus Pembayaran Berhasil');
          redirect('manage/bayarhutang?n='.$student['period_period_id'].'&r='.$student['student_nis']);
        }
    }
  
    function printBook() {
        $this->load->helper(array('dompdf'));
        $f = $this->input->get(NULL, TRUE);
    
        $data['f'] = $f;
        $kreditur = null;
        $periodID = null;
        $krediturID = null;
        $params = array();
    
    // Tahun Ajaran
        if (isset($f['n']) && !empty($f['n']) && $f['n'] != '' && $f['n'] != '0') {
          $params['period_id']      = $f['n'];
          $periodID                 = $f['n'];
        }
    
    // Siswa
        if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
          $kreditur = $this->Hutang_model->get(array('period_id'=>$f['n'], 'hutang_noref'=>$f['r']));
          $krediturID = $kreditur['employee_id'];
        }
        
        if (isset($f['d']) && !empty($f['d']) && $f['d'] != '') {
          $date = $f['d'];
        }
        
        $data['kreditur'] = $this->Hutang_model->get(array('employee_id'=>$kreditur['employee_id'], 'group'=>TRUE));
        
        $data['period']     = $this->Period_model->get($params);
        if($f['n'] == '0'){
            $data['book']   = $this->db->query("SELECT banking_date as date, banking_note as note, banking_code as code, banking_debit AS debit, banking_kredit AS kredit, @saldo:=@saldo+banking_debit-banking_kredit AS saldo FROM banking JOIN (SELECT @saldo:=0) a WHERE banking_employee_id = '$krediturID'")->result_array();
        }else{
            $data['book']   = $this->db->query("SELECT banking_date as date, banking_note as note, banking_code as code, banking_debit AS debit, banking_kredit AS kredit, @saldo:=@saldo+banking_debit-banking_kredit AS saldo FROM banking JOIN (SELECT @saldo:=0) a WHERE banking_employee_id = '$krediturID' AND banking_period_id = '$periodID'")->result_array();
        }
        
        $data['unit']    = $this->Employees_model->get_unit(array('status' => 1));
        $data['majors']  = $this->Settinghutang_model->get();
    
        $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
    
        $html = $this->load->view('bayarhutang/bayarhutang_book_pdf', $data, true);
        $data = pdf_create($html, $kreditur['employee_full_name'], TRUE, 'A4', TRUE);
    }

    function cetakBukti() {
        $this->load->helper(array('dompdf'));
        $this->load->helper(array('tanggal'));
        $this->load->helper(array('terbilang'));
        $this->load->model('employee/Employees_model');
        $this->load->model('setting/Setting_model');
        $f = $this->input->get(NULL, TRUE);
    
        $data['f'] = $f;
        $kreditur = null;
        $krediturID = null;
        $periodID = null;
        $params = array();
    
        // Tahun Ajaran
        if (isset($f['n']) && !empty($f['n']) && $f['n'] != '' && $f['n'] != '0') {
          $params['period_id']  = $f['n'];
          $periodID             = $f['n'];
        }
    
        // Siswa
        if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
          $params['employee_nip']    = $f['r'];
          $kreditur = $this->Employees_model->get(array('employee_nip'=>$f['r']));
          $krediturID = $kreditur['employee_id'];
        }
        
        if (isset($f['d']) && !empty($f['d']) && $f['d'] != '') {
          $date = $f['d'];
        }
        
        $data['kreditur'] = $this->Employees_model->get(array('period_id'=>$periodID, 'employee_id'=>$kreditur['employee_id'], 'group'=>TRUE));
        
        $data['period']     = $this->Period_model->get($params);
        $data['trx']        = $this->Hutang_model->get(array('period_id'=>$periodID, 'employee_id'=>$kreditur['employee_id'], 'date'=>$date));
        
        if($f['n'] == 0){
        $sum = $this->db->query("SELECT SUM(banking_debit) AS sumDeb, SUM(banking_kredit) AS sumKrd FROM banking WHERE banking_employee_id = '$krediturID' AND banking_date = '$date'")->row_array();
        }else{
        $sum = $this->db->query("SELECT SUM(banking_debit) AS sumDeb, SUM(banking_kredit) AS sumKrd FROM banking WHERE banking_employee_id = '$krediturID' AND banking_date = '$date' AND banking_period_id = '$periodID'")->row_array();
        }
        
        $data['sumDebit']   = $sum['sumDeb'];
        $data['sumKredit']  = $sum['sumKrd'];
        
        if($f['n'] == 0){
            $qSaldo = $this->db->query("SELECT SUM(banking_debit) AS debit, SUM(banking_kredit) AS kredit FROM banking WHERE banking_employee_id = '$krediturID'")->row_array();
        }else{
            $qSaldo = $this->db->query("SELECT SUM(banking_debit) AS debit, SUM(banking_kredit) AS kredit FROM banking WHERE banking_employee_id = '$krediturID' AND banking_period_id = '$periodID'")->row_array();    
        }
        
        $data['saldo']   = $qSaldo['debit']-$qSaldo['kredit'];
        $data['unit']    = $this->Employees_model->get_unit(array('status' => 1));
        $data['majors']  = $this->Settinghutang_model->get();
        // endtotal
        $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        $tanggal = date_create($f['d']);
        $dformat = date_format($tanggal,'dmYHis');
        $this->barcode2('TAB-'.$dformat.$kreditur['employee_nip'], '');
        $html = $this->load->view('bayarhutang/bayarhutang_cetak_pdf', $data, TRUE);
        $data = pdf_create($html, 'Cetak_Struk_'.$kreditur['employee_full_name'].'_'.date('Y-m-d'), TRUE, 'A4', TRUE);
    }
  
    private function barcode2($sparepart_code, $barcode_type=39, $scale=6, $fontsize=1, $thickness=30,$dpi=72) {
    
      $this->load->library('upload');
      $config['upload_path'] = FCPATH . 'media/barcode_transaction/';
    
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
        $drawing->setFilename( FCPATH .'media/barcode_transaction/'. $sparepart_code.'.png');
        // proses penyimpanan barcode hasil generate
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
    
        return $filename_img_barcode;
        
    }
  
    public function report(){
      $q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$params = array();

		if (isset($q['p']) && !empty($q['p']) && $q['p'] != '') {
			$params['period_id'] = $q['p'];
		}

		if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
			$params['majors_id'] = $q['k'];
		}

		if (isset($q['c']) && !empty($q['c']) && $q['c'] != '' && $q['c'] != '0') {
			$params['class_id']  = $q['c'];
		}

		if (isset($q['m']) && !empty($q['m']) && $q['m'] != '' && $q['m'] != '0') {
			$params['employee_id'] = $q['m'];
		}
        
		$data['period']     = $this->Period_model->get($params);
		$data['class']      = $this->Employees_model->get_class($params);
		$data['majors']     = $this->Settinghutang_model->get($params);
		$data['employee']    = $this->Employees_model->get($params);
		$data['banking']    = $this->Hutang_model->get_sum($params);
        
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
        
        $data['title'] = 'Laporan Tabungan Siswa';
        $data['main'] = 'bayarhutang/bayarhutang_report';
        $this->load->view('manage/layout', $data);
        
    }
  
    public function banking_excel() {
        $q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$params = array();

		if (isset($q['p']) && !empty($q['p']) && $q['p'] != '') {
			$params['period_id'] = $q['p'];
		}

		if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
			$params['majors_id'] = $q['k'];
		}

		if (isset($q['c']) && !empty($q['c']) && $q['c'] != '' && $q['c'] != '0') {
			$params['class_id']  = $q['c'];
		}

		if (isset($q['m']) && !empty($q['m']) && $q['m'] != '' && $q['m'] != '0') {
			$params['employee_id'] = $q['m'];
		}
        
		$data['period']     = $this->Period_model->get($params);
		$data['class']      = $this->Employees_model->get_class($params);
		$data['majors']     = $this->Settinghutang_model->get($params);
		$data['employee']    = $this->Employees_model->get($params);
		$data['hutang']    = $this->Hutang_model->get($params);
		
        $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
        
        $this->load->view('bayarhutang/bayarhutang_xls', $data);
    }

}