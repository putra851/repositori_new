<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Neraca_set extends CI_Controller {

	public function __construct() {
		parent::__construct(TRUE);
		if ($this->session->userdata('logged') == NULL) {
			header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
		}
		$this->load->model(array('payment/Payment_model', 'student/Student_model', 'period/Period_model', 'setting/Setting_model', 'bulan/Bulan_model', 'neraca/Neraca_model'));

	}
	
	public function index(){
	    
	    $params = array();
		$data['period'] = $this->Period_model->get($params);
		$data['month'] = $this->Bulan_model->get_month();
        $data['majors'] = $this->Student_model->get_majors();
        
		$data['title'] = 'Laporan Neraca';
		$data['main'] = 'neraca/neraca_list';
		$this->load->view('manage/layout', $data);
	}
	
	public function get_neraca(){
	    
		$start      = $this->input->post('start');
		$end        = $this->input->post('end');
		$period_id  = $this->input->post('period_id');
		$majors_id  = $this->input->post('majors_id');
		
		$start_name = $this->db->query("SELECT month_name FROM month WHERE month_id = '$start'")->row_array();
		$end_name   = $this->db->query("SELECT month_name FROM month WHERE month_id = '$end'")->row_array();
		
		$period = $this->db->query("SELECT period_start, period_end FROM period WHERE period_id = '$period_id'")->row_array();
		
		if($start == '1'){
	        $start_id = $period['period_start'].'-'.'07-01';
	    } else if($start == '2'){
	        $start_id = $period['period_start'].'-'.'08-01';
	    } else if($start == '3'){
	        $start_id = $period['period_start'].'-'.'09-01';
	    } else if($start == '4'){
	        $start_id = $period['period_start'].'-'.'10-01';
	    } else if($start == '5'){
	        $start_id = $period['period_start'].'-'.'11-01';
	    } else if($start == '6'){
	        $start_id = $period['period_start'].'-'.'12-01';
	    } else if($start == '7'){
	        $start_id = $period['period_end'].'-'.'01-01';
	    } else if($start == '8'){
	        $start_id = $period['period_end'].'-'.'02-01';
	    } else if($start == '9'){
	        $start_id = $period['period_end'].'-'.'03-01';
	    } else if($start == '10'){
	        $start_id = $period['period_end'].'-'.'04-01';
	    } else if($start == '11'){
	        $start_id = $period['period_end'].'-'.'05-01';
	    } else if($start == '12'){
	        $start_id = $period['period_end'].'-'.'06-01';
	    }
	    
	    if($end == '1'){
	        $end_id = $period['period_start'].'-'.'08-01';
	    } else if($end == '2'){
	        $end_id = $period['period_start'].'-'.'09-01';
	    } else if($end == '3'){
	        $end_id = $period['period_start'].'-'.'10-01';
	    } else if($end == '4'){
	        $end_id = $period['period_start'].'-'.'11-01';
	    } else if($end == '5'){
	        $end_id = $period['period_start'].'-'.'12-01';
	    } else if($end == '6'){
	        $end_id = $period['period_end'].'-'.'01-01';
	    } else if($end == '7'){
	        $end_id = $period['period_end'].'-'.'02-01';
	    } else if($end == '8'){
	        $end_id = $period['period_end'].'-'.'03-01';
	    } else if($end == '9'){
	        $end_id = $period['period_end'].'-'.'04-01';
	    } else if($end == '10'){
	        $end_id = $period['period_end'].'-'.'05-01';
	    } else if($end == '11'){
	        $end_id = $period['period_end'].'-'.'06-01';
	    } else if($end == '12'){
	        $end_id = $period['period_end'].'-'.'07-01';
	    }
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
		    $aktiva     = $this->Neraca_model->get_aktiva_unit($period_id, $majors_id, $start, $end);
		    $piutang    = $this->Neraca_model->get_piutang_unit($period_id, $majors_id, $start, $end, $start_id, $end_id);
			
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
		    $aktiva     = $this->Neraca_model->get_aktiva_all($period_id, $start, $end);
		    $piutang    = $this->Neraca_model->get_piutang_all($period_id, $start, $end, $start_id, $end_id);
		    
		}
		
		echo '<div class="box box-primary box-solid">
    		    <div class="box-header with-border">
    			  <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Neraca per Bulan '.$start_name['month_name'].' Sampai '.$end_name['month_name'].' Tahun Ajaran '.$period['period_start'].'/'.$period['period_end'].'</h3>
    			</div>
    			<div class="box-body table-responsive">
    			<table class="table table-responsive" style="white-space: nowrap;">
    			    <tr>
    			        <td>
    			        <div class="md-6">
    			            <b>HARTA</b>
    			        </div>
    			        </td>
    			        <td>
    			        <div class="md-6">
    			            <b>KEWAJIBAN</b>
    			        </div>
    			        </td>
    			    </tr>
        			<tr>
        			    <td>
        			    <div class="md-6">
        			        <table class="table table-responsive" style="white-space: nowrap;">
							<tr>
							    <th colspan="4">AKTIVA LANCAR</th>
						    </tr>';
    						$no       = 1;
    						$sumAktivaLancar = 0;
    						$sumPiutang = 0;
    					    foreach ($aktiva as $row) {
			        echo '
			              <tr>
			                <td>'.$row['account_code'].'</td>
			                <td colspan="2">'.$row['account_description'].'</td>
			                <td>'.'Rp '.number_format($row['saldo'], 0, ",", ".").'</td>
					    </tr>';
					    $sumAktivaLancar += $row['saldo'];
				    } foreach ($piutang as $row) {
			        echo '
			              <tr>
			                <td>'.$row['account_code'].'</td>
			                <td colspan="2">'.$row['account_description'].'</td>
			                <td>'.'Rp '.number_format($row['total'], 0, ",", ".").'</td>
					    </tr>';
					    $sumPiutang += $row['total'];
				    } 
					echo '<tr style="background-color: #fcfdff;">
			                <td colspan = "3" align = "right"><strong>Subtotal Aktiva Lancar</strong></td>
			                <td>'.'Rp '.number_format($sumAktivaLancar+$sumPiutang,0,",",".").'</td>
					    </tr>
				        </table>
				        
    			        <table class="table table-responsive" style="white-space: nowrap;">
						<tr>
						    <th colspan="4">AKTIVA TIDAK LANCAR</th>
					    </tr>';
				echo '<tr style="background-color: #fcfdff;">
		                <td colspan = "3" align = "right"><strong>Subtotal Aktiva Tidak Lancar</strong></td>
		                <td>'.'Rp '.number_format(0,0,",",".").'</td>
    				    </tr>
    			        </table>
    			    </div>
        			</td>
        			<td>
        			<div class="md-6">
        			    <table class="table table-responsive" style="white-space: nowrap;">
							<tr>
							    <th colspan="4">HUTANG</th>
						    </tr>';
					echo '<tr style="background-color: #fcfdff;">
			                <td colspan = "3" align = "right"><strong>Subtotal Hutang</strong></td>
			                <td>'.'Rp '.number_format(0,0,",",".").'</td>
					    </tr>
				        </table>
				        
				        <table class="table table-responsive" style="white-space: nowrap;">
							<tr>
							    <th colspan="4">MODAL</th>
						    </tr>';
					echo '<tr style="background-color: #fcfdff;">
			                <td colspan = "3" align = "right"><strong>Subtotal Modal</strong></td>
			                <td>'.'Rp '.number_format(0,0,",",".").'</td>
					    </tr>
				        </table>
				        </div>
        			</td>
    			</tr>
			</table>';
            			
	echo '</div>
			<div class="box-footer">
			<table class="table">
		        <tr>
				    <td>
				        <div class="pull-right">
    					    <a class="btn btn-danger" target="_blank" href="#"><span class="fa fa-file-pdf-o"></span> Cetak PDF
    					    </a>
    					    <a class="btn btn-success" target="_blank" href="#"><span class="fa fa-file-excel-o"></span> Cetak Excel
    					    </a>
    					</div>
				    </td>
			    </tr>
			</table>
			</div>
			</div>
		</div>';
		echo '
		    <script>
                $(document).ready(function(){
                	$("#xtable").DataTable({
                        "order": [[ 0, "asc" ]],
                        "columnDefs": [
                        {
                            "targets": [ 0 ],
                            "visible": false,
                            "searchable": false
                        }
                    ]
                    } );
                });
            </script>
		    ';
   
	}

}

/* End of file Neraca_set.php */
/* Location: ./application/modules/neraca/controllers/Neraca_set.php */