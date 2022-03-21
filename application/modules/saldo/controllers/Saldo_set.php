<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Saldo_set extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged') == NULL) {
          header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('saldo/Saldo_model', 'student/Student_model', 'logs/Logs_model'));
        $this->load->library('upload');
    }
    
    // saldo view in list
    public function index($offset = NULL) {
        $this->load->library('pagination');
    // Apply Filter
    // Get $_GET variable
        $s = $this->input->get(NULL, TRUE);
    
        $data['s'] = $s;
    
        $majors_id = NULL;
    /*    
        if (isset($s['m']) && !empty($s['m']) && $s['m'] != 'all') {
            $majors_id = $s['m'];
        }
    */    
        $data['majors'] = $this->Student_model->get_majors();
        
        //$data['total']  = $this->db->query("SELECT account.account_id, account.account_code, account.account_description, SUM(saldo_awal.saldo_awal_debit) sumDebit, SUM(saldo_awal.saldo_awal_kredit) sumKredit FROM `account` LEFT JOIN saldo_awal ON saldo_awal.saldo_awal_account = account.account_id LEFT JOIN majors ON majors.majors_id = account.account_majors_id WHERE account_majors_id = '$majors_id'")->row_array();
    
        $data['title'] = 'Setting Saldo Awal';
        $data['main'] = 'saldo/saldo_list';
        $this->load->view('manage/layout', $data);
    }
    
    public function add(){
		$id         = $this->input->post("id");
		$value      = $this->input->post("value");
		$modul      = $this->input->post("modul");
		$date       = date('Y-m-d');
		$updater    = $this->session->userdata('uid');
		$cek = $this->db->query("SELECT count(*) as num FROM saldo_awal WHERE saldo_awal_account = '$id'")->row_array();
		if($cek['num'] != 0){
		    $this->Saldo_model->update($id, $value, $modul, $date, $updater);
		} else {
		    $this->Saldo_model->add($id, $value, $modul, $date, $updater);
		}
	}
	
	public function get_total(){
	    $majors_id = $this->input->post('id_majors');
	    
	    $total  = $this->db->query("SELECT account.account_id, account.account_code, account.account_description, SUM(saldo_awal.saldo_awal_debit) sumDebit, SUM(saldo_awal.saldo_awal_kredit) sumKredit FROM `account` LEFT JOIN saldo_awal ON saldo_awal.saldo_awal_account = account.account_id LEFT JOIN majors ON majors.majors_id = account.account_majors_id WHERE account_majors_id = '$majors_id'")->row_array();
	    
	    $saldo_awal = $total['sumDebit']-$total['sumKredit'];
	    
        echo '
        <table class="table table-hover table-responsive">
        <tr style="background-color: #F3F1F1">
            <td colspan = "3" align = "right"><b> Total</b></td>
            <td>Rp '.number_format($total['sumDebit'],0,",",".").'</td>
            <td>Rp '.number_format($total['sumKredit'],0,",",".").'</td>
	    </tr>';
        echo
        '<tr style="background-color: ';
        echo ($saldo_awal == '0') ? '#93F9B3' : '#FD8989';
        echo '">
            <td colspan = "3" align = "right"><b>';
         echo ($saldo_awal == '0') ? 'Saldo Awal (Benar, saldo awal sudah 0 (nol))' : 'Saldo Awal (Kesalahan, saldo awal harus 0 (nol))';
         echo '</b></td>
            <td colspan = "2">Rp '.number_format($saldo_awal,0,",",".").'</td>
	    </tr>
	    </table>';
	    
	}

}