<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Payout_set extends CI_Controller {

  public function __construct() {
    parent::__construct(TRUE);
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $this->load->model(array('payout/Payout_model', 'payment/Payment_model', 'student/Student_model', 'period/Period_model', 'pos/Pos_model', 'bulan/Bulan_model', 'bebas/Bebas_model', 'bebas/Bebas_pay_model', 'setting/Setting_model', 'letter/Letter_model', 'logs/Logs_model', 'ltrx/Log_trx_model', 'billing/Billing_model'));

  }

// payment view in list
  public function index($offset = NULL, $id =NULL) {
      error_reporting(0);
// Apply Filter
// Get $_GET variable
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;
    
    $majorsID = '';
    $noref = '';
    $siswa['student_nis'] = '';
    $siswa['student_id'] = '';
    $siswa['majors_id'] = '';
    $siswa['majors_short_name'] = '';
    $params = array();
    $param = array();
    $pay = array();
    $cashback = array();
    $logs = array();

// Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['period_id'] = $f['n'];
      $pay['period_id'] = $f['n'];
      //$cashback['period_id'] = $f['n'];
      $logs['period_id'] = $f['n'];
      $tahun=$f['n'];
      $nis = $f['r'];
    }

// Santri
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis'] = $f['r'];
      $param['student_nis'] = $f['r'];
      $nis = $f['r'];
      $cashback['student_nis'] = $f['r'];
      $logs['student_nis'] = $f['r'];
      $siswa = $this->Student_model->get(array('student_nis'=>$f['r']));
    }

    // tanggal
    if (isset($f['d']) && !empty($f['d']) && $f['d'] != '') {
      $param['date'] = $f['d'];
      $date = $f['d'];
    }

    if(isset($f['n']) && !empty($f['n']) && $f['n'] != '' && isset($f['r']) && !empty($f['r']) && $f['r'] != ''){
        $data['dataMonth']  = $this->db->query("SELECT * FROM month")->result();
        $data['pembayaran'] = $this->Bulan_model->get_pembayaran($tahun,$nis);
    }
    
    $like = 'SP'.str_replace(" ", "", $siswa['majors_short_name']).$siswa['student_nis'];
    
	$tmp    = $this->Payout_model->get_noref($like, $siswa['majors_id']);
	
	$logs['payment_noref'] = 'SP'.str_replace(" ", "", $siswa['majors_short_name']).$siswa['student_nis'].$tmp;
	$cashback['noref'] = 'SP'.str_replace(" ", "", $siswa['majors_short_name']).$siswa['student_nis'].$tmp;
    
    $params['group']                    = TRUE;
    $pay['paymentt']                    = TRUE;
    $param['status']                    = 1;
    $cashback['status']                 = 1;
    $pay['student_id']                  = $siswa['student_id'];
    $cashback['student_id']             = $siswa['student_id'];
    $logs['student_id']                 = $siswa['student_id'];
    $cashback['date']                   = date('Y-m-d');
    $cashback['bebas_pay_input_date']   = date('Y-m-d');
    
    $paramsPage = $params;
    $data['periodActive']   = $this->db->query("SELECT period_id FROM period WHERE period_status = '1'")->row_array();
    $data['period']         = $this->Period_model->get($params);
    $data['siswa']          = $this->Student_model->get(array('student_id'=>$siswa['student_id'], 'group'=>TRUE));
    $data['student']        = $this->Bulan_model->get($pay);
    $data['bulan']          = $this->Bulan_model->get(array('student_id'=>$siswa['student_id']));
    $data['bebasPay']       = $this->Bebas_model->get($pay);
    $data['free']           = $this->Bebas_pay_model->get($params);
    $data['dom']            = $this->Bebas_pay_model->get($params);
    $data['bill']           = $this->Bulan_model->get_total($params);
    $data['in']             = $this->Bulan_model->get_total($param);
    $data['month']          = $this->Bulan_model->get_total($cashback);
    $data['beb']            = $this->Bebas_pay_model->get($cashback);
    $data['log']            = $this->Log_trx_model->get_history($logs);
    $data['trx']            = $this->Log_trx_model->get_trx($logs);
    $data['noref']          = 'SP'.str_replace(" ", "", $siswa['majors_short_name']).$siswa['student_nis'].$tmp;

    // cashback
    $data['cash'] = 0;
    foreach ($data['month'] as $row) {
      $data['cash'] += $row['total'];
    }

    $data['cashb'] = 0;
    foreach ($data['beb'] as $row) {
      $data['cashb'] += $row['bebas_pay_bill'];
    }

    $data['total'] = 0;
    foreach ($data['bill'] as $key) {
      $data['total'] += $key['total'];
    }

    $data['pay'] = 0;
    foreach ($data['in'] as $row) {
      $data['pay'] += $row['total'];
    }

    $data['pay_bill'] = 0;
    foreach ($data['dom'] as $row) {
      $data['pay_bill'] += $row['bebas_pay_bill'];
    }
    
    
        
    $majorsID        = $siswa['majors_id'];
    $noref           = 'SP'.str_replace(" ", "", $siswa['majors_short_name']).$siswa['student_nis'].$tmp;
    
    
    $akunBulan       = $this->db->query("SELECT bulan_account_id FROM bulan WHERE bulan_status = '1' AND bulan_noref = '$noref'")->row_array();
    $akunBebas       = $this->db->query("SELECT bebas_pay_account_id FROM bebas_pay WHERE bebas_pay_noref = '$noref'")->row_array();
    
    $data['dataKas'] = $this->db->query("SELECT * FROM account WHERE account_category = '2' AND account_majors_id = '$majorsID' 
    AND account_code LIKE '1%' AND account_note IN (SELECT account_id FROM account WHERE account_category = '0' AND account_majors_id = '$majorsID'
    AND account_code LIKE '1%' AND account_description LIKE '%Aktiva%' ORDER BY account_code ASC) ORDER BY account_code ASC")->result_array();
    
    if(isset($akunBulan['bulan_account_id']) AND empty($akunBebas['bebas_pay_account_id'])){
        $data['dataKasActive'] = $akunBulan['bulan_account_id'];  
    } else if(empty($akunBulan['bulan_account_id']) AND isset($akunBebas['bebas_pay_account_id'])){
        $data['dataKasActive'] = $akunBebas['bebas_pay_account_id'];
    } else if(isset($akunBulan['bulan_account_id']) AND isset($akunBebas['bebas_pay_account_id'])){
        $data['dataKasActive'] = $akunBulan['bulan_account_id'];
    } else {
    $kasActive = $this->db->query("SELECT account_id FROM account WHERE account_category = '2' 
    AND account_majors_id = '$majorsID' AND account_code LIKE '1%' AND account_description LIKE '%Tunai%'")->row_array();
    $data['dataKasActive'] = $kasActive['account_id'];
    }

    $config['base_url'] = site_url('manage/payment/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Bulan_model->get($paramsPage));
    $data['majors'] = $this->Student_model->get_majors();

    $data['title'] = 'Pembayaran Santri';
    $data['main'] = 'payout/payout_list';
    $this->load->view('manage/layout', $data);
  } 
  
  function get_noref(){
    $nis = $this->input->post('nis');
    
    $student = $this->Student_model->get(array('student_nis'=>$nis));  
    $majors = $this->Student_model->get_majors(array('id'=>$student['majors_id']));
    
    $like  = 'SP'.$majors['majors_short_name'].$nis;
	$tmp    = $this->Payout_model->get_noref($like, $student['majors_id']);
    $data  = 'SP'.$majors['majors_short_name'].$nis.$tmp;
    
    echo json_encode($data);
  }
  
    public function cari_noref(){
        
        $nis                  = $this->input->post('nis');
        $student              = $this->Student_model->get(array('student_nis'=>$nis));
        $params['student_id'] = $student['student_id'];
        $params['date']       = $this->input->post('trxDate');
        
    	$noref = $this->Payout_model->cari_noref($params);
    	
    	echo '<label>No. Referensi</label>
    			<select required="" name="f" id="no_ref" class="form-control"  onchange="copy_data()">
    			   <option value="">-- Pilih No. Referensi --</option>';
    			    foreach($noref as $row){
    		echo '<option value="'.$row['kas_noref'].'">';
        			 echo $row['kas_noref'];
    		 echo '</option>';
    			     }
        	echo '</select>';
    }
  
  function printBill() {
    $this->load->helper(array('dompdf'));
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $siswa['student_id'] = '';
    $params = array();
    $pay = array();

// Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['period_id'] = $f['n'];
      $pay['period_id'] = $f['n'];
    }

// Santri
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis'] = $f['r'];
      $siswa = $this->Student_model->get(array('student_nis'=>$f['r']));

    }

    $pay['student_id']=$siswa['student_id'];

    $data['period'] = $this->Period_model->get($params);
    $data['siswa']  = $this->Student_model->get(array('student_id'=>$siswa['student_id'], 'group'=>TRUE));
    $data['bulan']  = $this->Bulan_model->get($pay);
    $data['bebas']  = $this->Bebas_model->get($pay);
    $data['majors'] = $this->Student_model->get_majors();
    $data['unit']   = $this->Student_model->get_majors(array('status' => 1));

    $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
    $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
    $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
    $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
    $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
    $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 

    $html = $this->load->view('payout/payout_bill_pdf', $data, true);
    $data = pdf_create($html, $siswa['student_full_name'], TRUE, 'A4', TRUE);
  }

  function cetakBukti() {
    $this->load->helper(array('dompdf'));
    $this->load->helper(array('tanggal'));
    $this->load->helper(array('terbilang'));
    $this->load->model('student/Student_model');
    $this->load->model('setting/Setting_model');
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $siswa['student_id'] = '';
    $params = array();
    $param = array();
    $kas = array();
    $pay = array();
    $cashback = array();

// Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['period_id'] = $f['n'];
      $pay['period_id'] = $f['n'];
      //$cashback['period_id'] = $f['n'];
    }

// Santri
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis'] = $f['r'];
      $param['student_nis'] = $f['r'];
      $siswa = $this->Student_model->get(array('student_nis'=>$f['r']));

    }
    /*
    // tanggal
    if (isset($f['d']) && !empty($f['d']) && $f['d'] != '') {
      $param['date'] = $f['d'];
      $cashback['date'] = $f['d'];
    }
    */
    if (isset($f['f']) && !empty($f['f']) && $f['f'] != '') {
      $kas['date'] = $f['d'];
      $kas['noref'] = $f['f'];
      $param['noref'] = $f['f'];
      $cashback['noref'] = $f['f'];
    }

    $params['group']        =   TRUE;
    $pay['paymentt']        =   TRUE;
    $param['status']        =   1;
    $param['student_id']    =   $siswa['student_id'];
    $cashback['status']     =   1;
    $pay['student_id']      =   $siswa['student_id'];
    $cashback['student_id'] =   $siswa['student_id'];
    
    $data['majors']  = $this->Student_model->get_majors();
    $data['unit']    = $this->Student_model->get_unit(array('status' => 1));

    $data['period']  = $this->Period_model->get($params);
    $data['siswa']   = $this->Student_model->get(array('student_id'=>$siswa['student_id'], 'group'=>TRUE));
    $data['student'] = $this->Bulan_model->get($pay);
    $data['bulan']   = $this->Bulan_model->get($param);
    $data['bebas']   = $this->Bebas_model->get($pay);
    $data['free']    = $this->Bebas_pay_model->get($param);
    $data['s_bl']    = $this->Bulan_model->get_total($cashback);
    $data['s_bb']    = $this->Bebas_pay_model->get($cashback);
    $data['bcode']   = $this->Payout_model->get_bcode($kas);
    $bcode           = $this->Payout_model->get_bcode($kas);

    //total
    $data['summonth'] = 0;
    foreach ($data['s_bl'] as $row) {
      $data['summonth'] += $row['total'];
    }

    $data['sumbeb'] = 0;
    foreach ($data['s_bb'] as $row) {
      $data['sumbeb'] += $row['bebas_pay_bill'];
    }
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
    
    $this->barcode2($bcode['kas_noref'], '');
    
    $data['huruf'] = number_to_words($data['summonth']+$data['sumbeb']);
    $html = $this->load->view('payout/payout_cetak_pdf', $data, TRUE);
    $data = pdf_create($html, 'Cetak_Struk_'.$siswa['student_full_name'].'_'.date('Y-m-d'), TRUE, 'A4', TRUE);
  }

  function cetakThermal() {
    $this->load->helper(array('dompdf'));
    $this->load->helper(array('tanggal'));
    $this->load->helper(array('terbilang'));
    $this->load->model('student/Student_model');
    $this->load->model('setting/Setting_model');
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $siswa['student_id'] = '';
    $params = array();
    $param = array();
    $kas = array();
    $pay = array();
    $cashback = array();

// Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['period_id'] = $f['n'];
      $pay['period_id'] = $f['n'];
      //$cashback['period_id'] = $f['n'];
    }

// Santri
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis'] = $f['r'];
      $param['student_nis'] = $f['r'];
      $siswa = $this->Student_model->get(array('student_nis'=>$f['r']));

    }
    /*
    // tanggal
    if (isset($f['d']) && !empty($f['d']) && $f['d'] != '') {
      $param['date'] = $f['d'];
      $cashback['date'] = $f['d'];
    }
    */
    if (isset($f['f']) && !empty($f['f']) && $f['f'] != '') {
      $kas['date'] = $f['d'];
      $kas['noref'] = $f['f'];
      $param['noref'] = $f['f'];
      $cashback['noref'] = $f['f'];
    }

    $params['group']        =   TRUE;
    $pay['paymentt']        =   TRUE;
    $param['status']        =   1;
    $param['student_id']    =   $siswa['student_id'];
    $cashback['status']     =   1;
    $pay['student_id']      =   $siswa['student_id'];
    $cashback['student_id'] =   $siswa['student_id'];
    
    $data['majors']  = $this->Student_model->get_majors();
    $data['unit']    = $this->Student_model->get_unit(array('status' => 1));

    $data['period']  = $this->Period_model->get($params);
    $data['siswa']   = $this->Student_model->get(array('student_id'=>$siswa['student_id'], 'group'=>TRUE));
    $data['student'] = $this->Bulan_model->get($pay);
    $data['bulan']   = $this->Bulan_model->get($param);
    $data['bebas']   = $this->Bebas_model->get($pay);
    $data['free']    = $this->Bebas_pay_model->get($param);
    $data['s_bl']    = $this->Bulan_model->get_total($cashback);
    $data['s_bb']    = $this->Bebas_pay_model->get($cashback);
    $data['bcode']   = $this->Payout_model->get_bcode($kas);
    $bcode           = $this->Payout_model->get_bcode($kas);

    //total
    $data['summonth'] = 0;
    foreach ($data['s_bl'] as $row) {
      $data['summonth'] += $row['total'];
    }

    $data['sumbeb'] = 0;
    foreach ($data['s_bb'] as $row) {
      $data['sumbeb'] += $row['bebas_pay_bill'];
    }
    // endtotal
    $data['setting_nip_bendahara']  = $this->Setting_model->get(array('id' => 15));
    $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
    $data['setting_city']           = $this->Setting_model->get(array('id' => SCHOOL_CITY));
    $data['setting_district']       = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
    $data['setting_school']         = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
    $data['setting_address']        = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
    $data['setting_phone']          = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
    
    $tanggal = date_create($f['d']);
    $dformat = date_format($tanggal,'dmYHis');
    
    $this->barcode2($bcode['kas_noref'], '');
    
    $data['huruf'] = number_to_words($data['summonth']+$data['sumbeb']);
    $html = $this->load->view('payout/payout_thermal_pdf', $data, TRUE);
    $data = pdf_create_thermal($html, 'Cetak_Struk_'.$siswa['student_full_name'].'_'.date('Y-m-d'), TRUE, 'A4', TRUE);
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

// View data detail
  public function view_bulan($id = NULL) {

// Apply Filter
// Get $_GET variable
    $q = $this->input->get(NULL, TRUE); 

    $data['q'] = $q;
    $params = array();

// Programs
    if (isset($q['pr']) && !empty($q['pr']) && $q['pr'] != '') {
      $params['class_id'] = $q['pr'];
    }

    $data['class'] = $this->Student_model->get_class($params);
    $data['student'] = $this->Student_model->get($params);
    $data['payment'] = $this->Payment_model->get(array('id' => $id));
    $data['bulan'] = $this->Bulan_model->get(array('id' => $id));
    $data['title'] = 'Tarif Pembayaran';
    $data['main'] = 'payment/payment_view_bulan';
    $this->load->view('manage/layout', $data);
  }

// View data detail
  public function view_bebas($id = NULL) {

    $data['payment'] = $this->Payment_model->get(array('id' => $id));
    $data['bebas'] = $this->Bebas_model->get(array('id' => $id));
    $data['title'] = 'Tarif Pembayaran';
    $data['main'] = 'payment/payment_view_bebas';
    $this->load->view('manage/layout', $data);
  }


  public function payout_bulan($id = NULL, $student_id = NULL) {

    if ($id == NULL AND $student_id == NULL OR $student_id == NULL) {
      redirect('manage/payout');
    }

    $data['class'] = $this->Student_model->get_class();
    $data['payment'] = $this->Payment_model->get(array('id' => $id));
    $data['bulan'] = $this->Bulan_model->get(array('payment_id' => $id, 'student_id' => $student_id));
    $data['in'] = $this->Bulan_model->get_total(array('status'=>1, 'payment_id' => $id, 'student_id' => $student_id));
    $data['student'] = $this->Student_model->get(array('id'=> $student_id));

    $data['total'] = 0;
    foreach ($data['bulan'] as $key) {
      $data['total'] += $key['bulan_bill'];
    }

    $data['pay'] = 0;
    foreach ($data['in'] as $row) {
      $data['pay'] += $row['bulan_bill'];
    }

    $data['ngapp'] = 'ng-app="App"';
    $data['title'] = 'Pembayaran Santri';
    $data['main'] = 'payout/payout_add_bulan';
    $this->load->view('manage/layout', $data);
  }

  public function payout_bebas($id = NULL, $student_id = NULL, $bebas_id = NULL, $pay_id =NULL) {

    // if ($id == NULL AND $student_id == NULL AND $bebas_id == NULL OR $bebas_id == NULL) {
    //   redirect('manage/payout');
    // }
    if ($_POST == TRUE) {

      $lastletter = $this->Letter_model->get(array('limit' => 1));
      $student = $this->Bebas_model->get(array('id'=>$this->input->post('bebas_id')));
      $user = $this->Setting_model->get(array('id' => 8));
      $password = $this->Setting_model->get(array('id' => 9));
      $activated = $this->Setting_model->get(array('id' => 10));

      if ($lastletter['letter_year'] < date('Y') OR count($lastletter) == 0) {
        $this->Letter_model->add(array('letter_number' => '00001', 'letter_month' => date('m'), 'letter_year' => date('Y')));
        $nomor = sprintf('%05d', '00001');
        $nofull = date('Y'). date('m'). $nomor;
      } else {
        $nomor = sprintf('%05d', $lastletter['letter_number'] + 00001);
        $this->Letter_model->add(array('letter_number' => $nomor, 'letter_month' => date('m'), 'letter_year' => date('Y')));
        $nofull = date('Y'). date('m'). $nomor;
      }
      
      if ($this->input->post('bebas_id')) {
        $param['bebas_id'] = $this->input->post('bebas_id');
      }
      
      $param['bebas_pay_number']      = $nofull;
      $param['bebas_pay_account_id']  = $this->input->post('kas_account');
      $param['bebas_pay_noref']       = $this->input->post('kas_noref');
      $param['bebas_pay_bill']        = $this->input->post('bebas_pay_bill');
      $param['increase_budget']       = $this->input->post('bebas_pay_bill');
      $param['bebas_pay_desc']        = $this->input->post('bebas_pay_desc');
      $param['user_user_id']          = $this->session->userdata('uid');
      $param['bebas_pay_input_date']  = $this->input->post('bebas_pay_date');
      $param['bebas_pay_last_update'] = $this->input->post('bebas_pay_date');

      $data['bill'] = $this->Bebas_pay_model->get(array('bebas_id'=>$this->input->post('bebas_id')));
      $data['bebas'] = $this->Bebas_model->get(array('payment_id' => $this->input->post('payment_payment_id'), 'student_nis' => $this->input->post('student_nis')));

      $data['total'] = 0;
      foreach ($data['bebas'] as $key) {
        $data['total'] += $key['bebas_bill'];
      }

      $data['total_pay'] = 0;
      foreach ($data['bill'] as $row) {
        $data['total_pay'] += $row['bebas_pay_bill'];
      }

      $sisa = $data['total'] - $data['total_pay'];

      if ($this->input->post('bebas_pay_bill') > $sisa OR $this->input->post('bebas_pay_bill') == 0) {
        $this->session->set_flashdata('failed',' Pembayaran yang anda masukkan melebihi total tagihan!!!');
        redirect('manage/payout?n='.$student['period_period_id'].'&r='.$student['student_nis']);
      } else {

        $idd = $this->Bebas_pay_model->add($param);

        $this->Bebas_model->add(array('increase_budget' => $this->input->post('bebas_pay_bill'), 'bebas_id' =>  $this->input->post('bebas_id'), 'bebas_last_update'=>date('Y-m-d H:i:s'))); 
        
        $log = array(
          'bulan_bulan_id' => NULL,
          'bebas_pay_bebas_pay_id' => $idd,
          'student_student_id' => $this->input->post('student_student_id'),
          'log_trx_input_date' =>  $this->input->post('bebas_pay_date'),
          'log_trx_last_update' => date('Y-m-d H:i:s'),
        );
        $this->Log_trx_model->add($log);
        
        $this->Logs_model->add_trx(
            array(
              'ltrx_date' => date('Y-m-d H:i:s'),
              'user_id' => $this->session->userdata('uid'),
              'ltrx_module' => 'Pembayaran',
              'ltrx_action' => 'Bayar Bebas',
              'ltrx_info' => 'NIS:' . $student['student_nis'] . ';Title: ' . $this->input->post('bebas_pay_desc') . ' - ' . $student['pos_name'] . ' ' . $student['period_start'] . '/' . $student['period_end'] . ' nominal ' . $this->input->post('bebas_pay_bill'),
              'ltrx_browser' => $this->agent->browser(),
              'ltrx_version' => $this->agent->version(),
              'ltrx_os'      => $this->agent->platform(),
              'ltrx_ip'      => $this->input->ip_address()
            )
        );
      }

      if ($activated['setting_value'] == 'Y') {

        $userkey = $user['setting_value']; 
        $passkey = $password['setting_value']; 
        $telepon = $student['student_parent_phone'];
        $message = "Pembayaran ".$student['pos_name'].' - T.A '.$student['period_start'].'/'.$student['period_end'].'-'.$this->input->post('bebas_pay_desc').' a/n '.$student['student_full_name'].' Berhasil';
        $url = "https://reguler.zenziva.net/apps/smsapi.php";
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$telepon.'&pesan='.urlencode($message));
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        $results = curl_exec($curlHandle);
        curl_close($curlHandle);
      }

      $this->session->set_flashdata('success',' Pembayaran Berhasil Ditambahkan');
      redirect('manage/payout?n='.$student['period_period_id'].'&r='.$student['student_nis']);

    } else {

      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['bebas'] = $this->Bebas_model->get(array('payment_id' => $id, 'student_id' => $student_id));
      $data['student'] = $this->Student_model->get(array('id'=> $student_id));
      $data['bill'] = $this->Bebas_pay_model->get(array('bebas_id'=>$bebas_id, 'student_id'=>$student_id, 'payment_id'=>$id));

      $data['total'] = 0;
      foreach ($data['bebas'] as $key) {
        $data['total'] += $key['bebas_bill'];
      }

      $data['total_pay'] = 0;
      foreach ($data['bill'] as $row) {
        $data['total_pay'] += $row['bebas_pay_bill'];
      }

      $data['title'] = 'Tagihan Santri';
      // $data['main'] = 'payout/payout_add_bebas';
      $this->load->view('payout/payout_add_bebas', $data);

    }
  }
  
  public function payout_bebas_batch($id = NULL, $student_id = NULL, $bebas_id = NULL, $pay_id =NULL) {
    
    if ($_POST == TRUE) {
    
    $bebas_pay_account_id  = $_POST['kas_account'];
    $bebas_pay_noref       = $_POST['kas_noref'];
    $bebas_id              = $_POST['bebas_id'];
    $bebas_pay_bill        = $_POST['bebas_pay_bill'];
    $increase_budget       = $_POST['bebas_pay_bill'];
    $bebas_pay_desc        = $_POST['bebas_pay_desc'];
    $bebas_pay_date        = $_POST['bebas_pay_date'];
    $user_id          = $this->session->userdata('uid');
    
    $bebas_id       = $_POST['bebas_id'];
    $payment_id     = $_POST['payment_payment_id'];
    $student_nis    = $_POST['student_nis'];
    $student_id     = $_POST['student_student_id'];
    
    $cpt = count($bebas_id);
        
    for ($i = 0; $i < $cpt; $i++) {

      $lastletter   = $this->Letter_model->get(array('limit' => 1));
      $student      = $this->Bebas_model->get(array('id'=>$bebas_id[$i]));
      $user         = $this->Setting_model->get(array('id' => 8));
      $password     = $this->Setting_model->get(array('id' => 9));
      $activated    = $this->Setting_model->get(array('id' => 10));

      if ($lastletter['letter_year'] < date('Y') OR count($lastletter) == 0) {
        $this->Letter_model->add(array('letter_number' => '00001', 'letter_month' => date('m'), 'letter_year' => date('Y')));
        $nomor = sprintf('%05d', '00001');
        $nofull = date('Y'). date('m'). $nomor;
      } else {
        $nomor = sprintf('%05d', $lastletter['letter_number'] + 00001);
        $this->Letter_model->add(array('letter_number' => $nomor, 'letter_month' => date('m'), 'letter_year' => date('Y')));
        $nofull = date('Y'). date('m'). $nomor;
      }
      
      if ($this->input->post('bebas_id')) {
        $param['bebas_id'] = $bebas_id[$i];
      }
      
      $param['bebas_pay_number']      = $nofull;
      $param['bebas_pay_account_id']  = $bebas_pay_account_id;
      $param['bebas_pay_noref']       = $bebas_pay_noref;
      $param['bebas_pay_bill']        = $bebas_pay_bill[$i];
      $param['increase_budget']       = $bebas_pay_bill[$i];
      $param['bebas_pay_desc']        = $bebas_pay_desc[$i];
      $param['user_user_id']          = $user_id;
      $param['bebas_pay_input_date']  = $bebas_pay_date;
      $param['bebas_pay_last_update'] = $bebas_pay_date;

      $data['bill'] = $this->Bebas_pay_model->get(array('bebas_id'=>$bebas_id[$i]));
      $data['bebas'] = $this->Bebas_model->get(array('payment_id' => $payment_id[$i], 
                                                    'student_nis' => $student_nis));

      $data['total'] = 0;
      foreach ($data['bebas'] as $key) {
        $data['total'] += $key['bebas_bill'];
      }

      $data['total_pay'] = 0;
      foreach ($data['bill'] as $row) {
        $data['total_pay'] += $row['bebas_pay_bill'];
      }

      $sisa = $data['total'] - $data['total_pay'];

      if ($bebas_pay_bill[$i] > $sisa OR $bebas_pay_bill[$i] == 0) {
        $this->session->set_flashdata('failed',' Pembayaran yang anda masukkan melebihi total tagihan!!!');
        redirect('manage/payout?n='.$student['period_period_id'].'&r='.$student['student_nis']);
      } else {

        $idd = $this->Bebas_pay_model->add($param);

        $this->Bebas_model->add(array('increase_budget' => $bebas_pay_bill[$i],
                                        'bebas_id' =>  $bebas_id[$i],
                                        'bebas_last_update'=>date('Y-m-d H:i:s'))); 
        
        $log = array(
          'bulan_bulan_id'          => NULL,
          'bebas_pay_bebas_pay_id'  => $idd,
          'student_student_id'      => $student_id,
          'log_trx_input_date'      => $bebas_pay_date,
          'log_trx_last_update'     => date('Y-m-d H:i:s'),
        );
        $this->Log_trx_model->add($log);
      }

      if ($activated['setting_value'] == 'Y') {

        $userkey = $user['setting_value']; 
        $passkey = $password['setting_value']; 
        $telepon = $student['student_parent_phone'];
        $message = "Pembayaran ".$student['pos_name'].' - T.A '.$student['period_start'].'/'.$student['period_end'].'-'.$bebas_pay_desc[$i].' a/n '.$student['student_full_name'].' Berhasil';
        $url = "https://reguler.zenziva.net/apps/smsapi.php";
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$telepon.'&pesan='.urlencode($message));
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        $results = curl_exec($curlHandle);
        curl_close($curlHandle);
      }
        
    }

      $this->session->set_flashdata('success',' Pembayaran Berhasil Ditambahkan');
      redirect('manage/payout?n='.$student['period_period_id'].'&r='.$student['student_nis']);

    } else {

      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['bebas'] = $this->Bebas_model->get(array('payment_id' => $id, 'student_id' => $student_id));
      $data['student'] = $this->Student_model->get(array('id'=> $student_id));
      $data['bill'] = $this->Bebas_pay_model->get(array('bebas_id'=>$bebas_id, 'student_id'=>$student_id, 'payment_id'=>$id));

      $data['total'] = 0;
      foreach ($data['bebas'] as $key) {
        $data['total'] += $key['bebas_bill'];
      }

      $data['total_pay'] = 0;
      foreach ($data['bill'] as $row) {
        $data['total_pay'] += $row['bebas_pay_bill'];
      }

      $data['title'] = 'Tagihan Santri';
      // $data['main'] = 'payout/payout_add_bebas';
      $this->load->view('payout/payout_add_bebas', $data);

    }
  }

  function payout_finish(){
    $nis        = $this->input->post('student_nis');
    
    $student    = $this->Student_model->get(array('student_nis'=>$nis));
    
    $noref      = $this->input->post('kas_noref');
    
    $date       = date('Y-m-d');
    $bulan      = $this->db->query("SELECT MONTH('$date') as n")->row_array();
            
    if($bulan['n'] == '1'){
        $id_bulan = '7';
    } else if($bulan['n'] == '2'){
        $id_bulan = '8';
    } else if($bulan['n'] == '3'){
        $id_bulan = '9';
    } else if($bulan['n'] == '4'){
        $id_bulan = '10';
    } else if($bulan['n'] == '5'){
        $id_bulan = '11';
    } else if($bulan['n'] == '6'){
        $id_bulan = '12';
    } else if($bulan['n'] == '7'){
        $id_bulan = '1';
    } else if($bulan['n'] == '8'){
        $id_bulan = '2';
    } else if($bulan['n'] == '9'){
        $id_bulan = '3';
    } else if($bulan['n'] == '10'){
        $id_bulan = '4';
    } else if($bulan['n'] == '11'){
        $id_bulan = '5';
    } else if($bulan['n'] == '12'){
        $id_bulan = '6';
    }
    
    $totalBulan = $this->db->query("SELECT SUM(bulan_bill) as sumBulan FROM bulan WHERE bulan_status = '1' AND bulan_noref = '$noref'")->row_array();
    $totalBebas = $this->db->query("SELECT SUM(bebas_pay_bill) as sumBebas FROM bebas_pay WHERE bebas_pay_noref = '$noref'")->row_array();
    
    if($totalBulan['sumBulan'] == ''){
        $sumBulan = 0;
    } else {
        $sumBulan = $totalBulan['sumBulan'];
    }
    
    if($totalBebas['sumBebas'] == ''){
        $sumBebas = 0;
    } else {
        $sumBebas = $totalBebas['sumBebas'];
    }
    
    $total = $sumBulan + $sumBebas;
    
    $params['kas_account_id']   = $this->input->post('kas_account_id');
    $params['kas_noref']        = $this->input->post('kas_noref');
    $params['kas_majors_id']    = $student['majors_id'];
    $params['kas_note']         = 'Pembayaran Pesantren '.$student['student_full_name'];
    $params['kas_debit']        = $total;
    $params['kas_period']       = $this->input->post('period');
    $params['kas_date']         = date('Y-m-d');
    $params['kas_input_date']   = date('Y-m-d');
    $params['kas_month_id']     = $id_bulan;
    $params['kas_category']     = '1';
    $params['kas_user_id']      = $user_id = $this->session->userdata('uid');
    
    $this->Log_trx_model->trx_finish($params);
    
    $this->db->query("DELETE a FROM kas a INNER JOIN kas b WHERE a.kas_id > b.kas_id AND a.kas_noref = b.kas_noref AND DATE(b.kas_input_date)=CURDATE()");
    
    $this->Logs_model->add_trx(
        array(
          'ltrx_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'ltrx_module' => 'Pembayaran',
          'ltrx_action' => 'Simpan Pembayaran',
          'ltrx_info' => 'NIS:' . $student['student_nis'] . ';Title: Simpan No. Ref : ' . $this->input->post('kas_noref'),
          'ltrx_browser' => $this->agent->browser(),
          'ltrx_version' => $this->agent->version(),
          'ltrx_os'      => $this->agent->platform(),
          'ltrx_ip'      => $this->input->ip_address()
        )
    );
    
    if(isset($student['student_parent_phone']) AND $student['student_parent_phone'] != "+62"){
        
        $email                  = $this->session->unset_userdata('uemail');
        
        $wa_center              = $this->Setting_model->get(array('id' => 17));
        $tanggal_ini            = date("d-m-Y");
        $today                  = date("Y-m-d");
        $nis_enc                = base64_encode($student['student_nis']);
        $noref_enc              = base64_encode($noref);
        $date_enc               = base64_encode($today);
        $params_msg['pesan']    = 'Assalamualaikum Wr.Wb' . "\n\n" . 'Pembayaran ' . $student['majors_school_name'] . ' a/n ' . $student['student_full_name'] . ', Kelas ' .$student['class_name'] . ', telah kami terima Tanggal ' . $tanggal_ini . ' sejumlah '.number_format($total) . ' Referensi ID : ' . $noref  . "\n\n" . 'Terima kasih atas kerjasamanya semoga rezeki bapak/ibu sekeluarga tambah berkah dan dipermudah Allah SWT' . "\n\n" .
            'Download kwitansi : ' . base_url() . 'payout/cetakBukti?r=' . $nis_enc . '&d=' . $date_enc .  '&f=' . $noref_enc . "\n\n" .
            'Nomor WA Pesantren : http://wa.me/' . $wa_center['setting_value'];
    
        $params_msg['no_wa']                = $student['student_parent_phone'];
        $params_msg['status_kirim']         = 'PENDING';
        $params_msg['id_funding']           = $noref;
        $params_msg['created_by']           = $user_id = $this->session->userdata('uid');
        $params_msg['created_date']         = date("Y-m-d H:i:s");
    	
        $this->Log_trx_model->send_pesan($params_msg);
     
        $no_wa = $student['student_parent_phone'];
        $pesan = $params_msg['pesan'];
    
        $key1='fce9862deac8554e58028c35011e14214b47496d05fbd61c'; //decareptil
        $url='http://116.203.92.59/api/send_message';
        
        	$data = array(
        	  "phone_no"=>$no_wa,
        	  "key"		=>$key1,
        	  "message"	=>$pesan
        	);
        	$data_string = json_encode($data);
        
        	$ch = curl_init($url);
        	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	curl_setopt($ch, CURLOPT_VERBOSE, 0);
        	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        	curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        	  'Content-Type: application/json',
        	  'Content-Length: ' . strlen($data_string))
        	);
        	$res=curl_exec($ch);
        	curl_close($ch);       
    }
    
    $this->session->set_flashdata('success', 'Pembayaran Berhasil Masuk Ke Kas');
  }

  function pay() { 
    $payment_id     = $this->input->post('payment_id');
    $payout_date    = $this->input->post('payout_date');
    $payout_value   = $this->input->post('payout_value');
    $student_id     = $this->input->post('student_id');
    $id             = $this->input->post('payout_id');
    $kas_account_id = $this->input->post('kas_account');
    $kas_noref      = $this->input->post('kas_noref');
    
    $lastletter = $this->Letter_model->get(array('limit' => 1));
    $student = $this->Bulan_model->get(array('student_id'=>$student_id,'id'=>$id));
    $user = $this->Setting_model->get(array('id' => 8));
    $password = $this->Setting_model->get(array('id' => 9));
    $activated = $this->Setting_model->get(array('id' => 10));

    if ($lastletter['letter_year'] < date('Y') OR count($lastletter) == 0) {
      $this->Letter_model->add(array('letter_number' => '00001', 'letter_month' => date('m'), 'letter_year' => date('Y')));
      $nomor = sprintf('%05d', '00001');
      $nofull = date('Y'). date('m'). $nomor;
    } else {
      $nomor = sprintf('%05d', $lastletter['letter_number'] + 00001);
      $this->Letter_model->add(array('letter_number' => $nomor, 'letter_month' => date('m'), 'letter_year' => date('Y')));
      $nofull = date('Y'). date('m'). $nomor;
    }


    $pay = array(
      'bulan_id'            => $id,
      'bulan_number_pay'    => $nofull,
      'bulan_account_id'    => $kas_account_id,
      'bulan_noref'         => $kas_noref,
      'bulan_bill'          => $payout_value,
      'bulan_date_pay'      => $payout_date,
      'bulan_last_update'   => $payout_date,
      'bulan_status'        => 1,
      'user_user_id'        => $this->session->userdata('uid')
    );

    $log = array(
      'bulan_bulan_id' => $id,
      'student_student_id' => $student_id,
      'bebas_pay_bebas_pay_id' => NULL,
      'log_trx_input_date' =>  date('Y-m-d H:i:s'),
      'log_trx_last_update' => date('Y-m-d H:i:s'),
    );


    $status = $this->Bulan_model->add($pay);
    
    $this->Log_trx_model->add($log);
    
    $this->Logs_model->add_trx(
        array(
          'ltrx_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'ltrx_module' => 'Pembayaran',
          'ltrx_action' => 'Bayar Bulanan',
          'ltrx_info' => 'NIS:' . $student['student_nis'] . ';Title: Bayar' . ' - ' . $student['pos_name'] . ' ' . $student['period_start'] . '/' . $student['period_end'] . ' bulan ' . $student['month_name'] . ' nominal ' . $payout_value,
          'ltrx_browser' => $this->agent->browser(),
          'ltrx_version' => $this->agent->version(),
          'ltrx_os'      => $this->agent->platform(),
          'ltrx_ip'      => $this->input->ip_address()
        )
    );

    if ($activated['setting_value'] == 'Y') {

      $userkey = $user['setting_value']; 
      $passkey = $password['setting_value']; 
      $telepon = $student['student_parent_phone'];

      $namePay = $student['pos_name'].' - T.A '.$student['period_start'].'/'.$student['period_end'];
      $mont = ($student['month_month_id']<=6) ? $student['period_start'] : $student['period_end'];

      $message = "Pembayaran ".$namePay.' - ('.$student['month_name'].' '. $mont.') a/n '.$student['student_full_name'].' Berhasil';

      $url = "https://reguler.zenziva.net/apps/smsapi.php";
      $curlHandle = curl_init();
      curl_setopt($curlHandle, CURLOPT_URL, $url);
      curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$telepon.'&pesan='.urlencode($message));
      curl_setopt($curlHandle, CURLOPT_HEADER, 0);
      curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
      curl_setopt($curlHandle, CURLOPT_POST, 1);
      $results = curl_exec($curlHandle);
      curl_close($curlHandle);
    }

    if ($this->input->is_ajax_request()) {
      echo $status;
    } else {
      $this->session->set_flashdata('success',' Pembayaran Berhasil Ditambahkan');
      redirect('manage/payout?n='.$student['period_period_id'].'&r='.$student['student_nis']);
    }
  }

  function not_pay($payment_id = NULL, $student_id =NULL, $id = NULL) {
    
    $student = $this->Bulan_model->get(array('student_id'=>$student_id,'id'=>$id));
    
    $pay = array(
      'bulan_id' => $id,
      'bulan_number_pay'  => NULL,
      'bulan_account_id'  => NULL,
      'bulan_noref'       => NULL,
      'bulan_status'      => 0,
      'bulan_date_pay'    => date('Y-m-d'),
      'bulan_last_update' => date('Y-m-d'),
      'user_user_id'      => NULL
    );
    
    $noref = $student['bulan_noref'];
    $bill  = $student['bulan_bill'];
    
    $kas = $this->db->query("SELECT kas_debit FROM kas WHERE kas_noref = '$noref'")->row_array();
    $kasDebit = $kas['kas_debit'];
    
    $newKasDebit = $kasDebit - $bill;
    
    if($newKasDebit == '0'){
        $this->db->query("DELETE FROM kas WHERE kas_noref = '$noref'");
    }else{
        $this->db->query("UPDATE kas SET kas_debit = '$newKasDebit' WHERE kas_noref = '$noref'");
    }

    $this->Log_trx_model->delete_log(array(
      'student_id' => $student_id,
      'bulan_id' => $id
    ));
    
    $this->Logs_model->add_trx(
        array(
          'ltrx_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'ltrx_module' => 'Pembayaran',
          'ltrx_action' => 'Hapus Bayar Bulanan',
          'ltrx_info' => 'NIS:' . $student['student_nis'] . ';Title: Hapus' . ' - ' . $student['pos_name'] . ' ' . $student['period_start'] . '/' . $student['period_end'] . ' bulan ' . $student['month_name'] . ' nominal ' . $student['bulan_bill'],
          'ltrx_browser' => $this->agent->browser(),
          'ltrx_version' => $this->agent->version(),
          'ltrx_os'      => $this->agent->platform(),
          'ltrx_ip'      => $this->input->ip_address()
        )
    );

    $this->Bulan_model->add($pay);
    if ($this->input->is_ajax_request()) {
      echo $status;
    } else {
      $this->session->set_flashdata('success', 'Hapus Pembayaran Berhasil');
      redirect('manage/payout?n='.$student['period_period_id'].'&r='.$student['student_nis']);
    }
  }

  function printPay($payment_id = NULL, $student_id =NULL, $id = NULL) {
    $this->load->helper(array('dompdf'));
    $this->load->helper(array('tanggal'));

    if ($id == NULL)
      redirect('manage/payout/payout_bulan/'.$payment_id.'/'.$student_id);

    $data['printpay'] = $this->Bulan_model->get(array('id' =>$id));
    
    $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
    $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
    $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
    $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
    $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
    $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
    

    $html = $this->load->view('payout/payout_pdf', $data, true);
    $data = pdf_create($html, $data['printpay']['student_full_name'], TRUE, 'A4', TRUE);
  }

  function printPayFree($payment_id = NULL, $student_id =NULL, $id = NULL) {
    $this->load->helper(array('dompdf'));
    $this->load->helper(array('tanggal'));

    if ($id == NULL)
      redirect('manage/payout/payout_bebas/'.$payment_id.'/'.$student_id);

    $data['printpay'] = $this->Bebas_pay_model->get(array('id' =>$id));
    
    $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
    $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
    $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
    $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
    $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
    $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));  
    $data['bebas'] = $this->Bebas_model->get(array('payment_id' => $payment_id, 'student_id' => $student_id));

    $data['total_bill'] = 0;
    foreach ($data['bebas'] as $key) {
      $data['total_bill'] += $key['bebas_total_pay'];
    }

    $data['bill'] = 0;
    foreach ($data['bebas'] as $key) {
      $data['bill'] += $key['bebas_bill'];
    }

    $html = $this->load->view('payout/payout_free_pdf', $data, true);
    $data = pdf_create($html, $data['printpay']['student_full_name'], TRUE, 'A4', TRUE);
  }

  function multiple() {
    $this->load->helper(array('dompdf'));
    $this->load->helper(array('tanggal'));
    $action = $this->input->post('action');
    $print = array();
    if ($action == "printAll") {
      $bln = $this->input->post('msg');
      for ($i = 0; $i < count($bln); $i++) {
        $print[] = $bln[$i];
      }

      $data['printpay'] = $this->Bulan_model->get(array('multiple_id' => $print, 'group'=>TRUE));
      $data['pay'] = $this->Bulan_model->get(array('multiple_id' => $print));

      $data['total_pay'] = 0;
      foreach ($data['pay'] as $row) {
        $data['total_pay'] += $row['bulan_bill'];
      }

        $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));  

      $html = $this->load->view('payout/payout_bulan_multiple_pdf', $data, true);
      $data = pdf_create($html, 'Tagihan_Pembayaran_'.date('d_m_Y'), TRUE, 'A4', TRUE);

    } 
    redirect('manage/payout');
  }

  function delete_pay_free($payment_id = NULL, $student_id =NULL, $bebas_id = NULL, $id =NULL) {

    $total_pay = $this->Bebas_pay_model->get(array('id'=>$id));

    $this->Bebas_model->add(
      array(
        'decrease_budget'=> $total_pay['bebas_pay_bill'],
        'bebas_id'=>$bebas_id
      )
    );
    
    $noref = $total_pay['bebas_pay_noref'];
    $bill  = $total_pay['bebas_pay_bill'];
    
    $kas = $this->db->query("SELECT kas_debit FROM kas WHERE kas_noref = '$noref'")->row_array();
    $kasDebit = $kas['kas_debit'];
    
    $newKasDebit = $kasDebit - $bill;
    
    if($newKasDebit == '0'){
        $this->db->query("DELETE FROM kas WHERE kas_noref = '$noref'");
    }else{
        $this->db->query("UPDATE kas SET kas_debit = '$newKasDebit' WHERE kas_noref = '$noref'");
    }

    $this->Log_trx_model->delete_log(array(
      'student_id' => $student_id,
      'bebas_pay_id' => $id
    ));
    
    $student = $this->Bebas_model->get(array('id'=>$id));
    
    $this->Logs_model->add_trx(
        array(
          'ltrx_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'ltrx_module' => 'Pembayaran',
          'ltrx_action' => 'Hapus Bayar Bebas',
          'ltrx_info' => 'NIS:' . $student['student_nis'] . ';Title: Hapus ' . $total_pay['bebas_pay_desc'] . ' - ' . $student['pos_name'] . ' ' . $student['period_start'] . '/' . $student['period_end'] . ' nominal ' . $total_pay['bebas_pay_bill'],
          'ltrx_browser' => $this->agent->browser(),
          'ltrx_version' => $this->agent->version(),
          'ltrx_os'      => $this->agent->platform(),
          'ltrx_ip'      => $this->input->ip_address()
        )
    );

    $this->Bebas_pay_model->delete($id);

    if ($this->input->is_ajax_request()) {
      echo $status;
    } else {
      $this->session->set_flashdata('success', 'Delete Berhasil');
      redirect('manage/payout/payout_bebas/' . $payment_id.'/'.$student_id.'/'.$bebas_id);
    }
    
  }

// Delete to database
  public function delete($id = NULL) {
    if ($this->session->userdata('uroleid')!= SUPERUSER){
      redirect('manage');
    }
    if ($_POST) {
      $this->Payment_model->delete($id);
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
      $this->session->set_flashdata('success', 'Hapus Jenis Pembayran berhasil');
      redirect('manage/payment');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/payment/edit/' . $id);
    }
  }
  
  function get_form(){
        for($count = 0; $count < count($_POST["bebas_id"]); $count++)
        {
            $bebasPay = $this->db->query("SELECT period_id, period_start, period_end, pos_id, pos_name,
                                            student_nis, student_student_id, bebas_id, payment_payment_id,
                                            (bebas_bill - bebas_total_pay) as sisa
                                            FROM bebas 
                                            LEFT JOIN student ON bebas.student_student_id = student.student_id
                                            LEFT JOIN payment ON payment.payment_id = bebas.payment_payment_id
                                            LEFT JOIN pos ON pos.pos_id = payment.pos_pos_id
                                            LEFT JOIN period ON period.period_id = payment.period_period_id
                                            WHERE bebas_id IN (".$_POST['bebas_id'][$count].")")->result_array();
        
        foreach($bebasPay as $row){
		echo '
		<input type="hidden" name="student_nis" id="student_nis" value="'.$row['student_nis'].'">					
        <input type="hidden" name="student_student_id" id="student_student_id" value="'.$row['student_student_id'].'">
        <input type="hidden" name="bebas_id[]" id="bebas_id" value="'.$row['bebas_id'].'">								
		<input type="hidden" name="payment_payment_id[]" id="payment_payment_id" value="'.$row['payment_payment_id'].'">
		<hr>
		<div class="form-group">
			<label>Nama Pembayaran</label>
			<input class="form-control" readonly="" type="text" value="'.$row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'].'">
		</div>
		<div class="row">
			<div class="col-md-6">
				<label>Jumlah Bayar</label>
				<input type="text" required="" name="bebas_pay_bill[]" id="bebas_pay_bill" class="form-control" placeholder="Jumlah Bayar" value="'.$row['sisa'].'">
			</div>
			<div class="col-md-6">
				<label>Keterangan</label>
				<input type="text" required="" name="bebas_pay_desc[]" id="bebas_pay_desc" class="form-control" placeholder="Keterangan">
			</div>
		</div>';
	    }
            
        }
	    
  }

}