<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Billing extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        
        $this->load->model(array('billing/Billing_model', 'student/Student_model', 'account/Account_model', 'pos/Pos_model', 'payment/Payment_model', 'period/Period_model', 'pos/Pos_model', 'bulan/Bulan_model', 'bebas/Bebas_model', 'bebas/Bebas_pay_model', 'setting/Setting_model', 'logs/Logs_model', 'report/Report_model', 'report/Detail_jurnal_model'));
        $this->load->library('upload');
    }
    /*
    public function send_billing(){
        $wa_center  = $this->Setting_model->get(array('id' => 17));
        
        $student = $this->db->query("SELECT student_id, student_full_name, majors_short_name, majors_school_name, class_name, student_parent_phone FROM student JOIN class ON class.class_id = student.class_class_id JOIN majors ON majors.majors_id = student.majors_majors_id WHERE student.student_status = '1' AND majors.majors_status = '1' AND student.student_parent_phone IS NOT NULL")->result_array();
        
        foreach ($student as $siswa) {
            
            $id = $siswa['student_id']; 
        
            $now = pretty_date(date('d-m-Y'), 'F', false);
            
            $month = $this->db->query("SELECT month_id FROM month WHERE month_name = '$now'")->row_array();
            
            $periodActive = $this->db->query("SELECT period_id FROM period WHERE period_status = '1'")->row_array();
            
            $params['student_id']   = $id;
    	    $params['period_id']    = $periodActive['period_id'];
    	    $params['month_start']  = 1;
    	    $params['month_end']    = $month['month_id'];
    		
    		$bulan          = $this->Billing_model->get_tagihan_bulan($params);
    		
    		$periodNow = $this->db->query("SELECT period_start FROM period WHERE period_id = '" . $periodActive['period_id'] . "'")->row_array();
    		
    		$periodLama = $this->db->query("SELECT period_id FROM period WHERE period_start < '" . $periodNow['period_start'] . "'")->result_array();
    		
    		$periode    = NULL;
    		foreach ($periodLama as $row) {
    		    $periode = $row['period_id'];
    		}
    		
    	    $param['student_id']    = $id;
    	    $param['period_id']     = $periode;
    		
    		$sumBulan       = 0;
    		foreach ($bulan as $row) {
    		    $sumBulan += $row['bulan_bill'];
    		}
    	    
    	    if(isset($periode)){
    	        $bulanLama      = $this->Billing_model->get_tagihan_bulan_lama($param);    
        		$sumBulanLama   = 0;
        		foreach ($bulanLama as $row) {
        		    $sumBulanLama += $row['bulan_bill'];
        		}
    	    } else {
    	        $sumBulanLama   = 0;
    	    }
            
            $bulan = $sumBulan + $sumBulanLama;
            $bebas = $this->Bebas_model->get(array('student_id'=> $id));
            
            $sumBulan = $sumBulan + $sumBulanLama;
    
            $total_bebas = 0;
            foreach ($bebas as $row) {
                $total_bebas += $row['bebas_bill'];
            }
    
            $total_diskon = 0;
            foreach ($bebas as $row) {
                $total_diskon += $row['bebas_diskon'];
            }
    
            $total_bebas_pay = 0;
            foreach ($bebas as $row) {
                $total_bebas_pay += $row['bebas_total_pay'];
            }
            
            $sumBebas = $total_bebas - $total_diskon - $total_bebas_pay;
            
            $total    = $sumBulan + $sumBebas;
            
            $dateM = date('m');
            
            if($dateM == '01'){
                $till = '7';
            } else if($dateM == '02'){
                $till = '8';
            } else if($dateM == '03'){
                $till = '9';
            } else if($dateM == '04'){
                $till = '10';
            } else if($dateM == '05'){
                $till = '11';
            } else if($dateM == '06'){
                $till = '12';
            } else if($dateM == '07'){
                $till = '1';
            } else if($dateM == '08'){
                $till = '2';
            } else if($dateM == '09'){
                $till = '3';
            } else if($dateM == '10'){
                $till = '4';
            } else if($dateM == '11'){
                $till = '5';
            } else if($dateM == '12'){
                $till = '6';
            }
            
            if(isset($siswa['student_parent_phone']) AND $siswa['student_parent_phone'] != '+62' AND $total != 0){

        	    $no_wa = $siswa['student_parent_phone'];
				//$no_wa='+6281335111174';
                $pesan = 'Diberitahukan kepada Bapak/Ibu dari ' . $siswa['student_full_name'] . ', Kelas ' .$siswa['class_name'] . $siswa['majors_school_name'] . ', untuk segera melunasi biaya pendidikan sejumlah Rp ' . number_format($total, 0, ",", ".") . '. Atas perhatiannya kami ucapkan terima kasih.' . "\n\n" .
                    'Download Tagihan : ' . base_url() . 'billing/cetak?a=' . base64_encode($periodActive['period_id']) . '&b=' . base64_encode('1') . '&c=' . base64_encode($till) . '&d=' . base64_encode($siswa['student_id']) . "\n\n" .
                    'Nomor WA Sekolah : http://wa.me/' . $wa_center['setting_value'];
            
                $key1='93f92c81ba61d09610e18a5cd0504d25ee308318f9dbc967'; //decareptil
                $url='http://116.203.92.59/api/send_message';
                
                	$data = array(
                	  "phone_no"	=>	$no_wa,
                	  "key"		=>	$key1,
                	  "message"	=>	$pesan
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
        
    }
	*/
	function cetak(){
	    ob_start();
	    
        $f = $this->input->get(NULL, TRUE);
    
        $data['f'] = $f;
	    
        // Tahun Ajaran
        if (isset($f['a']) && !empty($f['a']) && $f['a'] != '') {
          $id_periode   = base64_decode($f['a']);
        }
        
        // Siswa
        if (isset($f['b']) && !empty($f['b']) && $f['b'] != '') {
          $month_start  = base64_decode($f['b']);
        }
        
        if (isset($f['c']) && !empty($f['c']) && $f['c'] != '') {
          $month_end    = base64_decode($f['c']);
        }
        
        if (isset($f['d']) && !empty($f['d']) && $f['d'] != '') {
          $id_siswa    = base64_decode($f['d']);
        }
        
        $student                = $this->Student_model->get_student(array('id' => $id_siswa));
        
        $params = array();
        
	    $params['student_id']   = $id_siswa;
	    $params['period_id']    = $id_periode;
	    $params['majors_id']    = $student['majors_id'];
	    $params['class_id']     = $student['class_id'];
	    $params['month_start']  = $month_start;
	    $params['month_end']    = $month_end;
        
        $data['period']         = $this->Period_model->get(array('id' => $id_periode));
		$data['from']           = $this->Bulan_model->get_month(array('id' => $month_start));
		$data['to']             = $this->Bulan_model->get_month(array('id' => $month_end));
		$data['student']        = $this->Student_model->get_student(array('id' => $id_siswa));
		
		$data['bulan']          = $this->Billing_model->get_tagihan_bulan($params);
		$data['bebas']          = $this->Billing_model->get_tagihan_bebas($params);
		
		$periodLama = $this->db->query("SELECT period_id FROM period WHERE period_id != '$id_periode'")->result_array();
		
		$periode    = NULL;
		foreach ($periodLama as $row) {
		    $periode = $row['period_id'];
		}
		
		if (isset($periode)){
		
	    $param['student_id']    = $id_siswa;
	    $param['period_id']     = $periode;
	    $param['majors_id']     = $student['majors_id'];
	    $param['class_id']      = $student['class_id'];
	    //$param['month_start']   = $month_start;
	    //$param['month_end']     = $month_end;
		    
		} else {
		    
	    $param['student_id']    = "";
	    $param['period_id']     = "";
	    $param['majors_id']     = "";
	    $param['class_id']      = "";
		}
		
		$data['bulanLama']      = $this->Billing_model->get_tagihan_bulan_lama($param);
		$data['bebasLama']      = $this->Billing_model->get_tagihan_bebas_lama($param);
		
		$data['setting_nip_bendahara']  = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city']           = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district']       = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school']         = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address']        = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone']          = $this->Setting_model->get(array('id' => SCHOOL_PHONE));  
    
        $filename = 'Tagihan-Pembayaran-'.$student['student_full_name'].'-Kelas-'.$student['class_name'].'.pdf';
	    
	    $this->load->view('billing/billing_print', $data);
        
        $html = ob_get_contents();
        ob_end_clean();
        
        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15',array(10, 10, 10, 10));
        $pdf->setDefaultFont('arial'); 
        $pdf->setTestTdInOnePage(false);
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->WriteHTML($html);
        $pdf->Output($filename);
        
	}
	
}