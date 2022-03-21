<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Slip extends CI_Controller {

  public function __construct() {
    parent::__construct(TRUE);
    
    $this->load->model(array('slip/Slip_model', 'kredit/Kredit_model', 'payment/Payment_model', 'student/Student_model', 'period/Period_model', 'bulan/Bulan_model', 'employees/Employees_model', 'penggajian/Penggajian_model', 'setting/Setting_model', 'logs/Logs_model', 'ltrx/Log_trx_model'));

  }

// payment view in list
  
    function download(){
      ob_start();
        
      $f = $this->input->get(NULL, TRUE);
    
      $data['f'] = $f;
    
      if (isset($f['key']) && !empty($f['key']) && $f['key'] != '') {
        $id   = base64_decode($f['key']);
      }
      
      $print = $this->Slip_model->get_print($id);
      $data['print'] = $this->Slip_model->get_print($id);
      
      $print = $this->Slip_model->get_print($id);
      $data['print'] = $this->Slip_model->get_print($id);
      
        if($print['month_id']>0 && $print['month_id']<7){
            $tahun = $print['period_start'];
        }
        else if($print['month_id']>6 && $print['month_id']<13){
            $tahun = $print['period_end'];
        } else {
            $tahun = '?';
        }
        $this->barcode2($print['kredit_kas_noref'], '');
      
      $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
      $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
      $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
      $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
      $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
      $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
      $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
      
      $filename = 'Slip Gaji Bulan '.$print['month_name'].' ('.$print['position_name'].') '.$print['employee_name'].'.pdf';
      
      $this->load->view('slip_print',$data);
        
        $html = ob_get_contents();
        ob_end_clean();
        
        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('l',array('216.5', '158'),'en', false, 'ISO-8859-15',array(21, 15, 21, 10));
        
        $pdf->setDefaultFont('arial');
        $pdf->setTestTdInOnePage(false);
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->WriteHTML($html);
        $pdf->Output($filename);
    }
  
    private function barcode2($sparepart_code, $barcode_type=39, $scale=6, $fontsize=1, $thickness=30,$dpi=72) {

      $this->load->library('upload');
      $config['upload_path'] = FCPATH . 'media/barcode_fee/';
    
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
        $drawing->setFilename( FCPATH .'media/barcode_fee/'. $sparepart_code.'.png');
        // proses penyimpanan barcode hasil generate
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
    
        return $filename_img_barcode;
    
      }
}