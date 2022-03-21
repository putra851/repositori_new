<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Billing_student extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged_student') == NULL) {
          header("Location:" . site_url('student/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('billing/Billing_model', 'student/Student_model', 'account/Account_model', 'pos/Pos_model', 'payment/Payment_model', 'period/Period_model', 'pos/Pos_model', 'bulan/Bulan_model', 'bebas/Bebas_model', 'bebas/Bebas_pay_model', 'setting/Setting_model', 'logs/Logs_model', 'report/Report_model', 'report/Detail_jurnal_model'));
        $this->load->library('upload');
    }
	
	function print_bill(){
	    ob_start();
	    $id_periode             = $this->uri->segment('4');
        $month_start            = $this->uri->segment('5');
        $month_end              = $this->uri->segment('6');
	    $id_siswa               = $this->uri->segment('7');
        
        $student                = $this->Student_model->get_student(array('id'=>$id_siswa));
        
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
		
		
		
		$data['bulan'] = $this->Billing_model->get_tagihan_bulan($params);
		$data['bebas'] = $this->Billing_model->get_tagihan_bebas($params);
		
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
        $pdf->Output($filename, 'D');
        
	}
	
}