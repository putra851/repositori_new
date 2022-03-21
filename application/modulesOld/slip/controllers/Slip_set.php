<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Slip_set extends CI_Controller {

  public function __construct() {
    parent::__construct(TRUE);
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $this->load->model(array('slip/Slip_model', 'kredit/Kredit_model', 'payment/Payment_model', 'student/Student_model', 'period/Period_model', 'bulan/Bulan_model', 'employees/Employees_model', 'penggajian/Penggajian_model', 'setting/Setting_model', 'logs/Logs_model', 'ltrx/Log_trx_model'));

  }

// payment view in list
  public function index($offset = NULL, $id =NULL) {
      error_reporting(0);
      
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;
    
    $params = array();
    $param = array();
    $fee = array();
    $month = array();
    $logs = array();
    $employee = '';
    $employee['majors_id'] = '';
    $employee['employee_nip'] = '';
    $employee['majors_short_name'] = '';

// Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['period_id'] = $f['n'];
      $tahun=$f['n'];
      $nip = $f['r'];
      $bln = $f['d'];
    }

// Siswa
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['employee_nip'] = $f['r'];
      $nip = $f['r'];
      $employee = $this->Employees_model->get(array('employee_nip'=>$f['r']));
    }

    // tanggal
    if (isset($f['d']) && !empty($f['d']) && $f['d'] != '') {
      $params['month_id'] = $f['d'];
      $bln = $f['d'];
    }

    if(isset($f['n']) && !empty($f['n']) && $f['n'] != '' && isset($f['r']) && !empty($f['r']) && $f['r'] != '' && isset($f['d']) && !empty($f['d']) && $f['d'] != ''){
        $data['dataMonth']  = $this->db->query("SELECT * FROM month")->result();
        $data['employee']   = $this->Employees_model->get(array('employee_id'=>$employee['employee_id']));
        $gaji = $this->Penggajian_model->get(array('employee_nip'=>$f['r']));
        
        foreach($gaji as $row){
            $x = $row['employee_id'];
        }
        
        $data['account']    = $this->db->query("SELECT * FROM account WHERE account_note = '7' AND account_category = '2' AND account_description LIKE '%gaji%' ")->result_array();    
        $data['gaji']       = $this->Penggajian_model->get(array('id'=>$x));
        $data['anak']       = $this->db->query("SELECT COUNT(fam_desc) as numAnak FROM employee_fam WHERE fam_desc = '3' AND fam_employee_id = '$x'")->row_array();
        $data['istri']      = $this->db->query("SELECT COUNT(fam_desc) as numIstri FROM employee_fam WHERE fam_desc = '1' AND fam_employee_id = '$x'")->row_array();
        
        $params['gaji_period_id']   = $f['n'];
        $params['gaji_employee_id'] = $x;
        
        $data['history'] = $this->Slip_model->get_history($params);

    }
    
    $majorsID = $employee['majors_id'];
    $config['base_url'] = site_url('manage/payment/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    
    $data['periodActive'] = $this->db->query("SELECT period_id FROM period WHERE period_status = '1'")->row_array();
    $data['period'] = $this->Period_model->get($params);
    $data['bulan'] = $this->Bulan_model->get_month($params);
    $data['dataKas'] = $this->db->query("SELECT * FROM account WHERE account_category = '2' AND account_majors_id = '$majorsID' AND account_code LIKE '1%' AND account_note IN (SELECT account_id FROM account WHERE account_category = '0' AND account_majors_id = '$majorsID' AND account_code LIKE '1%' AND account_description LIKE '%Aktiva%' ORDER BY account_code ASC) ORDER BY account_code ASC")->result_array();
    
    $data['dataKasActive'] = $this->db->query("SELECT account_id FROM account WHERE account_category = '2' AND account_majors_id = '$majorsID' AND account_code LIKE '1%' AND account_description LIKE '%Tunai%'")->row_array();
    
    $like   = $data['noref'] = 'GK'.$employee['majors_short_name'].$employee['employee_nip'];
    $tmp    = $this->Slip_model->get_noref($like, $majorsID);
    $data['noref'] = 'GK'.$employee['majors_short_name'].$employee['employee_nip'].$tmp;
    $data['majorsID'] = $majorsID;
    
    //$data['majors'] = $this->Student_model->get_majors();

    $data['title'] = 'Penggajian Pegawai';
    $data['main'] = 'slip/slip_list';
    $this->load->view('manage/layout', $data);
  }
  
  function delete_history($id = NULL){
   if ($_POST) {
            $period = $this->input->post('delPeriod');
            $month  = $this->input->post('delMonth');
            $nip    = $this->input->post('delNIP');
            $noref = $this->input->post('delNoref');
		    
		    $gaji   = $this->db->query("SELECT gaji_jumlah FROM gaji WHERE gaji_id = '$id'")->row_array();
		    
		    $bulan  = $this->db->query("SELECT month_name FROM month WHERE month_id = '$month'")->row_array();
		    
		    $ta     = $this->db->query("SELECT period_start, period_end FROM period WHERE period_id = '$period'")->row_array();
			
    		$this->Logs_model->add_trx(
                array(
                  'ltrx_date'   => date('Y-m-d H:i:s'),
                  'user_id'     => $this->session->userdata('uid'),
                  'ltrx_module' => 'Penggajian',
                  'ltrx_action' => 'Hapus Gaji',
                  'ltrx_info'   => 'NIP:' . $nip . ';Title: Hapus Gaji Bulan ' . $bulan['month_name'] . ' ' . $ta['period_start'] . '/' . $ta['period_end'] . ' No. Ref ' . $noref . ' nominal ' . $gaji['gaji_jumlah'],
                  'ltrx_browser' => $this->agent->browser(),
                  'ltrx_version' => $this->agent->version(),
                  'ltrx_os'      => $this->agent->platform(),
                  'ltrx_ip'      => $this->input->ip_address()
                )
            );
            
			$this->Slip_model->delete_history($id, $noref);
			$this->session->set_flashdata('success', 'Hapus History Penggajian Berhasil');
			redirect('manage/slip?n='.$period.'&d='.$month.'&r='.$nip);
		} elseif (!$_POST) {
			$this->session->set_flashdata('failed', 'Hapus History Penggajian Gagal');
			redirect('manage/slip?n='.$period.'&d='.$month.'&r='.$nip);
		}   
  }
  
  function add_slip(){
    if ($_POST == TRUE) {
			
			$params['gaji_pokok']        = $_POST['pokok'];
			$params['gaji_potongan']     = $_POST['potongan'];
			$params['gaji_jumlah']       = $_POST['jumlah_gaji'];
			$params['gaji_month_id']     = $_POST['month_id'];
			$params['gaji_period_id']    = $_POST['period_id'];
			$params['gaji_employee_id']  = $_POST['employee_id'];
			$params['gaji_tanggal']      = date('Y-m-d H:i:s');
			$params['user_user_id']      = $this->session->userdata('uid');
			
			$this->Slip_model->add($params);
			
			$query = $this->Employees_model->get(array('id'=>$_POST['employee_id']));
		
			$month_id     = $_POST['month_id'];
            $period_id    = $_POST['period_id'];
            $employee_id  = $_POST['employee_id'];
            
            $q = $this->db->query("SELECT gaji_id FROM gaji WHERE gaji_month_id = '$month_id' 
                        			AND gaji_period_id = '$period_id' 
                        			AND gaji_employee_id = '$employee_id'")->row_array();
			
			$paramskredit['kredit_date']          = date('Y-m-d H:i:s');
			$paramskredit['kredit_value']         = $_POST['jumlah_gaji'];
			$paramskredit['kredit_desc']          = 'Gaji '.$query['position_name'].' '.$query['employee_name'];
			$paramskredit['kredit_account_id']    = $_POST['gaji_account_id'];
			$paramskredit['kredit_gaji_id']       = $q['gaji_id'];
			$paramskredit['kredit_kas_noref']     = $_POST['kas_noref'];
            $paramskredit['kredit_kas_account_id']= $this->input->post('kas_account_id'); 
			$paramskredit['kredit_input_date']    = date('Y-m-d H:i:s');
			$paramskredit['kredit_last_update']   = date('Y-m-d H:i:s');
			$paramskredit['user_user_id']         = $this->session->userdata('uid');
			
			$this->Kredit_model->add($paramskredit);
			
		    $bulan  = $this->db->query("SELECT month_name FROM month WHERE month_id = '" . $_POST['month_id'] . "'")->row_array();
		    
		    $ta     = $this->db->query("SELECT period_start, period_end FROM period WHERE period_id = '" . $_POST['month_id'] . "'")->row_array();
			
    		$this->Logs_model->add_trx(
                array(
                  'ltrx_date'   => date('Y-m-d H:i:s'),
                  'user_id'     => $this->session->userdata('uid'),
                  'ltrx_module' => 'Penggajian',
                  'ltrx_action' => 'Input Gaji',
                  'ltrx_info'   => 'NIP:' . $_POST['nip'] . ';Title: Hapus Gaji Bulan ' . $bulan['month_name'] . ' ' . $ta['period_start'] . '/' . $ta['period_end'] . ' No. Ref ' . $_POST['kas_noref'] . ' nominal ' . $_POST['pembulatan_gaji'],
                  'ltrx_browser' => $this->agent->browser(),
                  'ltrx_version' => $this->agent->version(),
                  'ltrx_os'      => $this->agent->platform(),
                  'ltrx_ip'      => $this->input->ip_address()
                )
            );
			
			$date = date('Y-m-d');
            $bulan = $this->db->query("SELECT MONTH('$date') as n")->row_array();
            
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
			
			$paramskas['kas_majors_id'] = $this->input->post('kas_majors_id'); 
            $paramskas['kas_noref']     = $this->input->post('kas_noref'); 
            $paramskas['kas_period']    = $this->input->post('kas_period'); 
            $paramskas['kas_date']      = date('Y-m-d');
            $paramskas['kas_input_date']= date('Y-m-d');
            $paramskas['kas_month_id']  = $id_bulan; 
            $paramskas['kas_account_id']= $this->input->post('kas_account_id'); 
            $paramskas['kas_note']      = 'Gaji '.$query['position_name'].' '.$query['employee_name'];
            $paramskas['kas_kredit']    = $_POST['jumlah_gaji'];
            $paramskas['kas_category']  = '2';
            $paramskas['kas_user_id']   = $user_id = $this->session->userdata('uid');
            
			$this->Slip_model->save($paramskas);
			
			$this->db->query("DELETE a FROM kas a INNER JOIN kas b WHERE a.kas_id > b.kas_id AND a.kas_noref = b.kas_noref AND DATE(b.kas_input_date)=CURDATE();");
			
			$paramssubsatu['subsatu_pokok']          = $this->input->post('premier_pokok');
            $paramssubsatu['subsatu_lain']           = $this->input->post('premier_lain');
            $paramssubsatu['subsatu_gaji_id']        = $q['gaji_id'];
      
            $paramssubtiga['subtiga_simpanan']   = $this->input->post('potongan_simpanan');
            $paramssubtiga['subtiga_bpjstk']      = $this->input->post('potongan_bpjstk');
            $paramssubtiga['subtiga_sumbangan']       = $this->input->post('potongan_sumbangan');
            $paramssubtiga['subtiga_koperasi']        = $this->input->post('potongan_koperasi');
            $paramssubtiga['subtiga_bpjs']        = $this->input->post('potongan_bpjs');
            $paramssubtiga['subtiga_pinjaman']= $this->input->post('potongan_pinjaman');
            $paramssubtiga['subtiga_lain']  = $this->input->post('potongan_lain');
            $paramssubtiga['subtiga_gaji_id']        = $q['gaji_id'];
      
            $this->Slip_model->set_subsatu($paramssubsatu);
            $this->Slip_model->set_subtiga($paramssubtiga);
			
			redirect('manage/slip/print_slip/'.$q['gaji_id']);
		}     
  }
  
  function print_slip($id){
     ob_start();
      
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

    // pos view in list
    public function send_slip($offset = NULL) {
        $q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$params = array();

		if (isset($q['p']) && !empty($q['p']) && $q['p'] != '') {
			$params['period_id'] = $q['p'];
		}

		if (isset($q['k']) && !empty($q['k']) && $q['k'] != '' && $q['k'] != 'all') {
			$params['majors_id'] = $q['k'];
		}

		if (isset($q['m']) && !empty($q['m']) && $q['m'] != '') {
			$params['month_id'] = $q['m'];
		}
        
		$data['period']     = $this->Period_model->get($params);
		$data['class']      = $this->Student_model->get_class($params);
		$data['majors']     = $this->Student_model->get_majors($params);
		$data['month']      = $this->Bulan_model->get_month($params);
		$data['employee']   = $this->Penggajian_model->get_report($params);
        
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
        
        $data['title'] = 'Kirim Notif Gaji';
        $data['main'] = 'slip/slip_send_list';
        $this->load->view('manage/layout', $data);
    }

    function get_form(){
      
        for($count = 0; $count < count($_POST["employee_id"]); $count++)
        {
            $employee = $this->db->query("SELECT employee_id
                                        FROM employee
                                        WHERE employee_id IN (".$_POST['employee_id'][$count].")")->result_array();
        
            foreach($employee as $row){
    		    echo '<input type="hidden" name="employee_id[]" id="employee_id" value="'.$row['employee_id'].'">';
    	    }
        }
    }
    
    public function send(){
        if ($_POST == TRUE) {
        
            $wa_center  = $this->Setting_model->get(array('id' => 17));
                
            $period_id      = $_POST['period_id'];
            $employee_id    = $_POST['employee_id'];
            $month_id       = $_POST['month_id'];
            
            $cpt = count($_POST['employee_id']);
            for ($i = 0; $i < $cpt; $i++) {
            
            $params['employee_id']  = $employee_id[$i];
    	    $params['period_id']    = $period_id;
    	    $params['month_id']     = $month_id;
			
		    $bul  = $this->db->query("SELECT month_name FROM month WHERE month_id = '" . $_POST['month_id'] . "'")->row_array();
		    
		    $ta   = $this->db->query("SELECT period_start, period_end FROM period WHERE period_id = '" . $_POST['period_id'] . "'")->row_array();
            
			
			$query  = $this->Employees_model->get(array('id'=>$employee_id[$i]));
            $employee   = $this->Penggajian_model->get_report_employee($params);
            
            if(isset($query['employee_phone']) AND $query['employee_phone'] != '+62'){
            
                $school = $this->Setting_model->get(array('id' => SCHOOL_NAME));
                  
                $total   = $employee['gaji_jumlah'];
                $gaji_id = $employee['gaji_id'];
                
        	    $no_wa = $query['employee_phone'];
        	    $pesan = 'Assalamu alaikum Ustadz/Ustadzah ' . $query['employee_name'] . ' (' .$query['position_name'] . ') kami dari ' . str_replace('`', '', $school['setting_value']) . ' mengucapkan terima kasih atas dedikasi dan kinerjanya Ustadz/Ustadzah. Maka dari itu kami serahkan hak Ustadz/Ustadzah di bulan ' . $bul['month_name'] . ' tahun ajaran ' . $ta['period_start'] . '/' . $ta['period_end'] . ' sebesar  Rp ' . number_format($total, 0, ",", ".") . '. Syukron wa jazakumullahu khoiran.' . "\n\n" .
                    'Download Slip : ' . base_url() . 'slip/download?key=' . base64_encode($gaji_id) . "\n\n" .
                    'Nomor WA Bendahara : http://wa.me/' . $wa_center['setting_value'];
            
                $key1='93f92c81ba61d09610e18a5cd0504d25ee308318f9dbc967'; //decareptil
                $url='http://116.203.92.59/api/send_message';
                
                	$data = array(
                	  "phone_no"    =>	$no_wa,
                	  "key"		    =>	$key1,
                	  "message"	    =>	$pesan
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
            
            }
            
            $this->session->set_flashdata('success',' Notif Slip Gaji Berhasil Dikirim');
            redirect('manage/slip/send_slip');
        }
    }

}