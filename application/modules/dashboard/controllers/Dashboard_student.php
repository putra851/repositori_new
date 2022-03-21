<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_student extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_student') == NULL) {
            header("Location:" . site_url('student/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('billing/Billing_model', 'student/Student_model', 'bulan/Bulan_model', 'setting/Setting_model','bebas/Bebas_model', 'information/Information_model', 'bebas/Bebas_pay_model'));
    }

    public function index() {
        $id = $this->session->userdata('uid_student'); 
        
        $now = pretty_date(date('d-m-Y'), 'F', false);
        
        $month = $this->db->query("SELECT month_id FROM month WHERE month_name = '$now'")->row_array();
        
        $periodActive = $this->db->query("SELECT period_id FROM period WHERE period_status = '1'")->row_array();
        
        //$params = array();
        //$param  = array();
        
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

        $data['information'] = $this->Information_model->get(array('information_publish'=>1));
        //$data['bulan'] = $this->Bulan_model->get(array('month_id' => $month['month_id'], 'status'=>0, 'period_status'=>1, 'student_id'=> $this->session->userdata('uid_student')));
        
        $data['bulan'] = $sumBulan + $sumBulanLama;
        $data['bebas'] = $this->Bebas_model->get(array('student_id'=> $this->session->userdata('uid_student')));

        //$data['total_bulan'] =0;
        /*
        foreach ($data['bulan'] as $row) {
            $data['total_bulan'] += $row['bulan_bill'];
        }
        */
        
        $data['total_bulan'] = $sumBulan + $sumBulanLama;
        
        $data['b'] = $sumBulan;
        $data['bl'] = $sumBulanLama;

        $data['total_bebas'] =0;
        foreach ($data['bebas'] as $row) {
            $data['total_bebas'] += $row['bebas_bill'];
        }

        $data['total_bebas_pay'] =0;
        foreach ($data['bebas'] as $row) {
            $data['total_bebas_pay'] += $row['bebas_total_pay'];
        }



        $data['title'] = 'Dashboard';
        $data['main'] = 'dashboard/dashboard_student';
        $this->load->view('student/layout', $data);
    }


}
