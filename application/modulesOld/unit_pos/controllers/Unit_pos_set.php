<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_pos_set extends CI_Controller {

	public function __construct() {
		parent::__construct(TRUE);
		if ($this->session->userdata('logged') == NULL) {
			header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
		}
		$this->load->model(array('payment/Payment_model', 'student/Student_model', 'period/Period_model', 'pos/Pos_model', 'item/Item_model', 'logs/Logs_model', 'unit_pos/Unit_pos_model', 'unit_pos/Unit_pos_detail_model'));

	}

	public function index(){
	    
	    $params = array();
		$data['item'] = $this->Item_model->get($params);
		
		$config['base_url'] = site_url('manage/unit_pos/index');
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
        
        $data['majors'] = $this->Student_model->get_majors();
        
		$data['title'] = 'Laporan Unit Pos';
		$data['main'] = 'unit_pos/unit_pos_list';
		$this->load->view('manage/layout', $data);
	}
	
	function get_item(){
        $majors_id = $this->input->post('majors_id');
        $item  = $this->db->query("SELECT * FROM item WHERE item_majors_id = '$majors_id' ORDER BY item_name ASC")->result_array();
    
        echo '<select name="item_id" id="item_id" class="form-control" required="">
                    <option value="">-- Pilih Unit Pos --</option>';
                echo '<option value="all">Semua Unit Pos</option>';
                      foreach ($item as $row):
        
                        echo '<option value="'.$row['item_id'].'">';
                            
                        echo $row['item_name'];
                            
                        echo '</option>';
                    
                        endforeach;
                                        
        echo '</select>';
    }
	
	public function search_unit_pos(){
	    
		$ds         = $this->input->post('ds');
		$de         = $this->input->post('de');
		$item_id    = $this->input->post('item_id');
		$majors_id  = $this->input->post('majors_id');
		$createDS   = date_create($ds);
		$createDE   = date_create($de);
		$start      = date_format($createDS,"n");
		$end        = date_format($createDE,"n");
		
		if ($start == '1'){
		    $monthStart = '7';
		} else if ($start == '2'){
		    $monthStart = '8';
		} else if ($start == '3'){
		    $monthStart = '9';
		} else if ($start == '4'){
		    $monthStart = '10';
		} else if ($start == '5'){
		    $monthStart = '11';
		} else if ($start == '6'){
		    $monthStart = '12';
		} else if ($start == '7'){
		    $monthStart = '1';
		} else if ($start == '8'){
		    $monthStart = '2';
		} else if ($start == '9'){
		    $monthStart = '3';
		} else if ($start == '10'){
		    $monthStart = '4';
		} else if ($start == '11'){
		    $monthStart = '5';
		} else if ($start == '12'){
		    $monthStart = '6';
		}
		
		if ($end == '1'){
		    $monthEnd = '7';
		} else if ($end == '2'){
		    $monthEnd = '8';
		} else if ($end == '3'){
		    $monthEnd = '9';
		} else if ($end == '4'){
		    $monthEnd = '10';
		} else if ($end == '5'){
		    $monthEnd = '11';
		} else if ($end == '6'){
		    $monthEnd = '12';
		} else if ($end == '7'){
		    $monthEnd = '1';
		} else if ($end == '8'){
		    $monthEnd = '2';
		} else if ($end == '9'){
		    $monthEnd = '3';
		} else if ($end == '10'){
		    $monthEnd = '4';
		} else if ($end == '11'){
		    $monthEnd = '5';
		} else if ($end == '12'){
		    $monthEnd = '6';
		}
		
		$interval = $monthStart - 1;
		
		$last = "SELECT '$ds' - INTERVAL '$interval' MONTH as last_month, '$ds' - INTERVAL '1' DAY as yesterday";
		
		$qLast = $this->db->query($last)->row_array();

		//$data['q'] = $q;

		$params = array();
		$param = array();

        // Date start
		if (isset($ds) && !empty($ds) && $ds != '') {
			$params['date_start'] = $ds;
			$param['date_start'] = $ds;
		}

        // Date end
		if (isset($de) && !empty($de) && $de != '') {
			$params['date_end'] = $de;
			$param['date_end'] = $de;
		}
		
		if (isset($item_id) && !empty($item_id) && $item_id != 'all') {
			$params['item_id'] = $item_id;
			$param['item_id'] = $item_id;
		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
		$params['kas_noref'] = 'isi';
		$param['kas_noref'] = 'isi';
		
		}
        
		$params['status'] = 1;
		$param['status'] = 1;

		$bulan  = $this->Unit_pos_model->get_bulan($params);
		$free   = $this->Unit_pos_model->get_free($params);
		$gaji   = $this->Unit_pos_model->get_gaji($params);
		$kredit = $this->Unit_pos_model->get_kredit($params);
		$debit  = $this->Unit_pos_model->get_debit($params);
		
		$bulanLast  = $this->Unit_pos_model->get_bulan_last($param);
 		$freeLast   = $this->Unit_pos_model->get_free_last($param);
		$gajiLast   = $this->Unit_pos_model->get_gaji_last($param);
		$kreditLast = $this->Unit_pos_model->get_kredit_last($param);
		$debitLast  = $this->Unit_pos_model->get_debit_last($param);
		
		//$sumBulanLast = $bulanLast['bulan_bill'];
		$sumBulanLast = 0;
		foreach($bulanLast as $row){
		    $sumBulanLast += $row['bulan_bill'];
		}
		
// 		//$sumFreeLast = $freeLast['bebas_pay_bill'];
		$sumFreeLast = 0;
		foreach($freeLast as $row){
		    $sumFreeLast += $row['bebas_pay_bill'];
		}
		
// 		//$sumGajiLast = $gajiLast['kredit_value'];
		$sumGajiLast = 0;
		foreach($gajiLast as $row){
		    $sumGajiLast += $row['kredit_value'];
		}
		
// 		//$sumKreditLast = $kreditLast['kredit_value'];
		$sumKreditLast = 0;
		foreach($kreditLast as $row){
		    $sumKreditLast += $row['kredit_value'];
		}
		
// 		//$sumDebitLast = $debitLast['debit_value'];
		$sumDebitLast = 0;
		foreach($debitLast as $row){
		    $sumDebitLast += $row['debit_value'];
		}
		
		$saldoAwal = 0;
		
		
		echo '<div class="box box-primary box-solid">
            		    <div class="box-header with-border">
            			  <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan per Tanggal '.pretty_date($ds, 'd/m/Y', FALSE).' Sampai '.pretty_date($de, 'd/m/Y', FALSE).'</h3>
            			</div>
            			<div class="box-body table-responsive">
            			<table class="table table-responsive table-hover table-bordered" id="xtable" style="white-space: nowrap;">
            			        <thead>
    							<tr>
    							    <th>Order</th>
    								<th>Tanggal</th>
    								<th>Kode Akun</th>
    							    <th>Keterangan</th>
    								<th>NIS</th>
    								<th>Nama Siswa</th>
    								<th>Kelas</th>
    								<th>Penerimaan</th>
    								<th>Pengeluaran</th>
    						    </tr>
    						    </thead>
    						    <tbody>';
    						$no       = 1;
    						$sumBulan = 0;
    					    foreach ($bulan as $row) {
    				        echo '
    				              <tr>
    				                <td>'.pretty_date($row['bulan_date_pay'], 'Ymd', FALSE).'</td>
    				                <td>'.pretty_date($row['bulan_date_pay'], 'd/m/Y', FALSE).'</td>
    				                <td>'.$row['account_code'].'</td>
    				                <td>'.$row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'].'-'.$row['month_name'].'</td>
    				                <td>'.$row['student_nis'].'</td>
    				                <td>'.$row['student_full_name'].'</td>
    				                <td>'.$row['class_name'].'</td>
    				                <td>'.'Rp '.number_format($row['bulan_bill'], 0, ",", ".").'</td>
    				                <td> - </td>
    						    </tr>';
    						    $sumBulan += $row['bulan_bill'];
    					    } 
    					    $sumFree = 0;
    					    foreach ($free as $row) {
    				        echo '<tr>
    				                <td>'.pretty_date($row['bebas_pay_input_date'], 'Ymd', FALSE).'</td>
    				                <td>'.pretty_date($row['bebas_pay_input_date'], 'd/m/Y', FALSE).'</td>
    				                <td>'.$row['account_code'].'</td>
    				                <td>'.$row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'].'</td>
    				                <td>'.$row['student_nis'].'</td>
    				                <td>'.$row['student_full_name'].'</td>
    				                <td>'.$row['class_name'].'</td>
    				                <td>'.'Rp '.number_format($row['bebas_pay_bill'],0,",",".").'</td>
    				                <td> - </td>
    						    </tr>';
    						    $sumFree += $row['bebas_pay_bill'];
    					    }  
    					    $sumDebit = 0;
    					    foreach ($debit as $row) {
    				        echo '<tr>
    				                <td>'.pretty_date($row['debit_date'], 'Ymd', FALSE).'</td>
    				                <td>'.pretty_date($row['debit_date'], 'd/m/Y', FALSE).'</td>
    				                <td>'.$row['account_code'].'</td>
    				                <td>'.$row['debit_desc'].'</td>
    				                <td> - </td>
    				                <td> - </td>
    				                <td> - </td>
    				                <td>'.'Rp '.number_format($row['debit_value'],0,",",".").'</td>
    				                <td> - </td>
    						    </tr>';
    						    $sumDebit += $row['debit_value'];
    					    }
    					    $sumGaji = 0;
    					    foreach ($gaji as $row) {
    				        echo '<tr>
    				                <td>'.pretty_date($row['kredit_date'], 'Ymd', FALSE).'</td>
    				                <td>'.pretty_date($row['kredit_date'], 'd/m/Y', FALSE).'</td>
    				                <td>'.$row['account_code'].'</td>
    				                <td>'.$row['kredit_desc'].'</td>
    				                <td> - </td>
    				                <td> - </td>
    				                <td> - </td>
    				                <td> - </td>
    				                <td>'.'Rp '.number_format($row['kredit_value'],0,",",".").'</td>
    						    </tr>';
    						    $sumGaji += $row['kredit_value'];
    					    } 
    					    $sumKredit = 0;
    					    foreach ($kredit as $row) {
    				        echo '<tr>
    				                <td>'.pretty_date($row['kredit_date'], 'Ymd', FALSE).'</td>
    				                <td>'.pretty_date($row['kredit_date'], 'd/m/Y', FALSE).'</td>
    				                <td>'.$row['account_code'].'</td>
    				                <td>'.$row['kredit_desc'].'</td>
    				                <td> - </td>
    				                <td> - </td>
    				                <td> - </td>
    				                <td> - </td>
    				                <td>'.'Rp '.number_format($row['kredit_value'],0,",",".").'</td>
    						    </tr>';
    						    $sumKredit += $row['kredit_value'];
    					    }
    					    $sumA = $sumBulan + $sumFree + $sumDebit;
    					    $sumB = $sumKredit + $sumGaji;
    					    echo '
    						    </tbody>
    						    <tr style="background-color: #E2F7FF;">
    				                <td colspan = "6" align = "right"><strong>Sub Total</strong></td>
    				                <td>'.'Rp '.number_format($sumA,0,",",".").'</td>
    				                <td>'.'Rp '.number_format($sumB,0,",",".").'</td>
    						    </tr>';
    					    $sumLastA = $sumBulanLast + $sumFreeLast + $sumDebitLast;
    					    $sumLastB = $sumKreditLast + $sumGajiLast;
    					    echo '<tr style="background-color: #F0B2B2;">
    				                <td colspan = "6" align = "right"><strong>Saldo Awal</strong></td>
    				                <td>'.'Rp '.number_format($saldoAwal+$sumLastA-$sumLastB,0,",",".").'</td>
    				                <td> - </td>
    						    </tr>';
    						echo '<tr style="background-color: #FFFCBE;">
    				                <td colspan = "6" align = "right"><strong>Total (Sub Total + Saldo Awal)</strong></td>
    				                <td>'.'Rp '.number_format($saldoAwal+$sumLastA+$sumA-$sumLastB,0,",",".").'</td>
    				                <td>'.'Rp '.number_format($sumB,0,",",".").'</td>
    						    </tr>';
    						echo '<tr style="background-color: #c2d2f6;">
    				                <td colspan = "6" align = "right"><strong>Saldo Akhir</strong></td>
    				                <td>'.'Rp '.number_format(($saldoAwal+$sumLastA+$sumA)-($sumLastB+$sumB),0,",",".").'</td>
    				                <td> - </td>
    						    </tr>';
    				echo '</table>
    					</div>
    					<div class="box-footer">
    					<table class="table">
        			        <tr>
        					    <td>
                					<div class="md-6">
                					    <a class="btn btn-danger" target="_blank" href="'.base_url().'manage/unit_pos/cetak_detail/'.$ds.'/'.$de.'/'.$item_id.'/'.$majors_id.'"><span class="fa fa-file-pdf-o"></span> PDF Per Jenis Anggaran
                					    </a>
                					    <a class="btn btn-success" target="_blank" href="'.base_url().'manage/unit_pos/excel_detail/'.$ds.'/'.$de.'/'.$item_id.'/'.$majors_id.'"><span class="fa fa-file-excel-o"></span> Excel Per Jenis Anggaran
                					    </a>
                					</div>
        					    </td>
        					    <td>
        					        <div class="pull-right">
                					    <a class="btn btn-danger" target="_blank" href="'.base_url().'manage/unit_pos/cetak_rekap/'.$ds.'/'.$de.'/'.$item_id.'/'.$majors_id.'"><span class="fa fa-file-pdf-o"></span> PDF Rekap Laporan
                					    </a>
                					    <a class="btn btn-success" target="_blank" href="'.base_url().'manage/unit_pos/excel_rekap/'.$ds.'/'.$de.'/'.$item_id.'/'.$majors_id.'"><span class="fa fa-file-excel-o"></span> Excel Rekap Laporan
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
	
	public function cetak_detail(){
	    ob_start();
		
	    $ds         = $this->uri->segment('4');
		$de         = $this->uri->segment('5');
		$item_id    = $this->uri->segment('6');
		$majors_id  = $this->uri->segment('7');
		$createDS   = date_create($ds);
		$createDE   = date_create($de);
		$start      = date_format($createDS,"n");
		$end        = date_format($createDE,"n");
		
		if ($start == '1'){
		    $monthStart = '7';
		} else if ($start == '2'){
		    $monthStart = '8';
		} else if ($start == '3'){
		    $monthStart = '9';
		} else if ($start == '4'){
		    $monthStart = '10';
		} else if ($start == '5'){
		    $monthStart = '11';
		} else if ($start == '6'){
		    $monthStart = '12';
		} else if ($start == '7'){
		    $monthStart = '1';
		} else if ($start == '8'){
		    $monthStart = '2';
		} else if ($start == '9'){
		    $monthStart = '3';
		} else if ($start == '10'){
		    $monthStart = '4';
		} else if ($start == '11'){
		    $monthStart = '5';
		} else if ($start == '12'){
		    $monthStart = '6';
		}
		
		if ($end == '1'){
		    $monthEnd = '7';
		} else if ($end == '2'){
		    $monthEnd = '8';
		} else if ($end == '3'){
		    $monthEnd = '9';
		} else if ($end == '4'){
		    $monthEnd = '10';
		} else if ($end == '5'){
		    $monthEnd = '11';
		} else if ($end == '6'){
		    $monthEnd = '12';
		} else if ($end == '7'){
		    $monthEnd = '1';
		} else if ($end == '8'){
		    $monthEnd = '2';
		} else if ($end == '9'){
		    $monthEnd = '3';
		} else if ($end == '10'){
		    $monthEnd = '4';
		} else if ($end == '11'){
		    $monthEnd = '5';
		} else if ($end == '12'){
		    $monthEnd = '6';
		}
		
		$interval = $monthStart - 1;
		
		$last = "SELECT '$ds' - INTERVAL '$interval' MONTH as last_month, '$ds' - INTERVAL '1' DAY as yesterday";
		
		$qLast = $this->db->query($last)->row_array();

		//$data['q'] = $q;

		$params = array();
		$param = array();

        // Date start
		if (isset($ds) && !empty($ds) && $ds != '') {
			$params['date_start'] = $ds;
			$param['date_start'] = $qLast['last_month'];
		}

        // Date end
		if (isset($de) && !empty($de) && $de != '') {
			$params['date_end'] = $de;
			$param['date_end'] = $qLast['yesterday'];
		}
		
		if (isset($item_id) && !empty($item_id) && $item_id != 'all') {
			$params['item_id'] = $item_id;
			$param['item_id'] = $item_id;
		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			
			$data['saldoAwal'] = 0;
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
    		$params['kas_noref'] = 'isi';
    		$param['kas_noref'] = 'isi';
    		
    		$data['saldoAwal'] = 0;
		}
        
		$params['urutan'] = "ada";
		$params['status'] = 1;
		$param['status'] = 1;

		$data['bulan']  = $this->Unit_pos_model->get_rekap_bulan($params);
		$data['free']   = $this->Unit_pos_model->get_rekap_bebas($params);
		$data['kredit'] = $this->Unit_pos_model->get_rekap_kredit($params);
		$data['gaji']   = $this->Unit_pos_model->get_rekap_gaji($params);
		$data['debit']  = $this->Unit_pos_model->get_rekap_debit($params);
		
		$data['bulanLast']  = $this->Unit_pos_model->get_rekap_bulan_last($param);
		$data['freeLast']   = $this->Unit_pos_model->get_rekap_bebas_last($param);
		$data['kreditLast'] = $this->Unit_pos_model->get_rekap_kredit_last($param);
		$data['gajiLast']   = $this->Unit_pos_model->get_rekap_gaji_last($param);
		$data['debitLast']  = $this->Unit_pos_model->get_rekap_debit_last($param);
		
		$data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
        $filename = 'Laporan Per Jenis Anggaran Kas Tunai per Tanggal '.pretty_date($ds, 'd/m/Y', FALSE).' Sampai '.pretty_date($de, 'd/m/Y', FALSE).'.pdf';
        
        $this->load->view('report/cetak_detail_report',$data);
        
        $html = ob_get_contents();
        ob_end_clean();
        
        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15',array(10, 5, 10, 5));
        
        $pdf->setDefaultFont('arial');
        $pdf->setTestTdInOnePage(false);
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'D');
	}
	
	public function excel_detail(){
	    $ds         = $this->uri->segment('4');
		$de         = $this->uri->segment('5');
		$item_id    = $this->uri->segment('6');
		$majors_id  = $this->uri->segment('7');
		$createDS   = date_create($ds);
		$createDE   = date_create($de);
		$start      = date_format($createDS,"n");
		$end        = date_format($createDE,"n");
		
		if ($start == '1'){
		    $monthStart = '7';
		} else if ($start == '2'){
		    $monthStart = '8';
		} else if ($start == '3'){
		    $monthStart = '9';
		} else if ($start == '4'){
		    $monthStart = '10';
		} else if ($start == '5'){
		    $monthStart = '11';
		} else if ($start == '6'){
		    $monthStart = '12';
		} else if ($start == '7'){
		    $monthStart = '1';
		} else if ($start == '8'){
		    $monthStart = '2';
		} else if ($start == '9'){
		    $monthStart = '3';
		} else if ($start == '10'){
		    $monthStart = '4';
		} else if ($start == '11'){
		    $monthStart = '5';
		} else if ($start == '12'){
		    $monthStart = '6';
		}
		
		if ($end == '1'){
		    $monthEnd = '7';
		} else if ($end == '2'){
		    $monthEnd = '8';
		} else if ($end == '3'){
		    $monthEnd = '9';
		} else if ($end == '4'){
		    $monthEnd = '10';
		} else if ($end == '5'){
		    $monthEnd = '11';
		} else if ($end == '6'){
		    $monthEnd = '12';
		} else if ($end == '7'){
		    $monthEnd = '1';
		} else if ($end == '8'){
		    $monthEnd = '2';
		} else if ($end == '9'){
		    $monthEnd = '3';
		} else if ($end == '10'){
		    $monthEnd = '4';
		} else if ($end == '11'){
		    $monthEnd = '5';
		} else if ($end == '12'){
		    $monthEnd = '6';
		}
		
		$interval = $monthStart - 1;
		
		$last = "SELECT '$ds' - INTERVAL '$interval' MONTH as last_month, '$ds' - INTERVAL '1' DAY as yesterday";
		
		$qLast = $this->db->query($last)->row_array();

		//$data['q'] = $q;

		$params = array();
		$param = array();

        // Date start
		if (isset($ds) && !empty($ds) && $ds != '') {
			$params['date_start'] = $ds;
			$param['date_start'] = $qLast['last_month'];
		}

        // Date end
		if (isset($de) && !empty($de) && $de != '') {
			$params['date_end'] = $de;
			$param['date_end'] = $qLast['yesterday'];
		}
		
		if (isset($item_id) && !empty($item_id) && $item_id != 'all') {
			$params['item_id'] = $item_id;
			$param['item_id'] = $item_id;
		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			
			$data['saldoAwal'] = 0;
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
    		$params['kas_noref'] = 'isi';
    		$param['kas_noref'] = 'isi';
    		
    		$data['saldoAwal'] = 0;
		}
        
		$params['urutan'] = "ada";
		$params['status'] = 1;
		$param['status'] = 1;

		$data['bulan']  = $this->Unit_pos_model->get_rekap_bulan($params);
		$data['free']   = $this->Unit_pos_model->get_rekap_bebas($params);
		$data['kredit'] = $this->Unit_pos_model->get_rekap_kredit($params);
		$data['gaji']   = $this->Unit_pos_model->get_rekap_gaji($params);
		$data['debit']  = $this->Unit_pos_model->get_rekap_debit($params);
		
		$data['bulanLast']  = $this->Unit_pos_model->get_rekap_bulan_last($param);
		$data['freeLast']   = $this->Unit_pos_model->get_rekap_bebas_last($param);
		$data['kreditLast'] = $this->Unit_pos_model->get_rekap_kredit_last($param);
		$data['gajiLast']   = $this->Unit_pos_model->get_rekap_gaji_last($param);
		$data['debitLast']  = $this->Unit_pos_model->get_rekap_debit_last($param);
		
		$data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
        $this->load->view('report/excel_detail_report',$data);
	}
	
	public function cetak_rekap(){
        ob_start();
		
	    $ds         = $this->uri->segment('4');
		$de         = $this->uri->segment('5');
		$item_id    = $this->uri->segment('6');
		$majors_id  = $this->uri->segment('7');
		$createDS   = date_create($ds);
		$createDE   = date_create($de);
		$start      = date_format($createDS,"n");
		$end        = date_format($createDE,"n");
		
		if ($start == '1'){
		    $monthStart = '7';
		} else if ($start == '2'){
		    $monthStart = '8';
		} else if ($start == '3'){
		    $monthStart = '9';
		} else if ($start == '4'){
		    $monthStart = '10';
		} else if ($start == '5'){
		    $monthStart = '11';
		} else if ($start == '6'){
		    $monthStart = '12';
		} else if ($start == '7'){
		    $monthStart = '1';
		} else if ($start == '8'){
		    $monthStart = '2';
		} else if ($start == '9'){
		    $monthStart = '3';
		} else if ($start == '10'){
		    $monthStart = '4';
		} else if ($start == '11'){
		    $monthStart = '5';
		} else if ($start == '12'){
		    $monthStart = '6';
		}
		
		if ($end == '1'){
		    $monthEnd = '7';
		} else if ($end == '2'){
		    $monthEnd = '8';
		} else if ($end == '3'){
		    $monthEnd = '9';
		} else if ($end == '4'){
		    $monthEnd = '10';
		} else if ($end == '5'){
		    $monthEnd = '11';
		} else if ($end == '6'){
		    $monthEnd = '12';
		} else if ($end == '7'){
		    $monthEnd = '1';
		} else if ($end == '8'){
		    $monthEnd = '2';
		} else if ($end == '9'){
		    $monthEnd = '3';
		} else if ($end == '10'){
		    $monthEnd = '4';
		} else if ($end == '11'){
		    $monthEnd = '5';
		} else if ($end == '12'){
		    $monthEnd = '6';
		}
		
		$interval = $monthStart - 1;
		
		$last = "SELECT '$ds' - INTERVAL '$interval' MONTH as last_month, '$ds' - INTERVAL '1' DAY as yesterday";
		
		$qLast = $this->db->query($last)->row_array();

		//$data['q'] = $q;

		$params = array();
		$param = array();

        // Date start
		if (isset($ds) && !empty($ds) && $ds != '') {
			$params['date_start']   = $ds;
			$param['date_start']    = $qLast['last_month'];
		}

        // Date end
		if (isset($de) && !empty($de) && $de != '') {
			$params['date_end']     = $de;
			$param['date_end']      = $qLast['yesterday'];
		}
		
		if (isset($item_id) && !empty($item_id) && $item_id != 'all') {
			$params['item_id']    = $item_id;
			$param['item_id']     = $item_id;
		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id']    = $majors_id;
			$param['account_majors_id']     = $majors_id;
			
			$data['saldoAwal']      = 0;
			
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
    		$params['kas_noref']    = 'isi';
    		$param['kas_noref']     = 'isi';
    		
    		$data['saldoAwal']      = 0;
		}
        
		$params['urutan']   = "ada";
		$params['status']   = 1;
		$param['status']    = 1;

		$data['bulan']  = $this->Unit_pos_model->get_rekap_bulan($params);
		$data['free']   = $this->Unit_pos_model->get_rekap_bebas($params);
		$data['kredit'] = $this->Unit_pos_model->get_rekap_kredit($params);
		$data['gaji']   = $this->Unit_pos_model->get_rekap_gaji($params);
		$data['debit']  = $this->Unit_pos_model->get_rekap_debit($params);
		
		$data['bulanLast']  = $this->Unit_pos_model->get_rekap_bulan_last($param);
		$data['freeLast']   = $this->Unit_pos_model->get_rekap_bebas_last($param);
		$data['kreditLast'] = $this->Unit_pos_model->get_rekap_kredit_last($param);
		$data['gajiLast']   = $this->Unit_pos_model->get_rekap_gaji_last($param);
		$data['debitLast']  = $this->Unit_pos_model->get_rekap_debit_last($param);
		
		$data['setting_nip_bendahara']  = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city']           = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district']       = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school']         = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address']        = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone']          = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
        $filename = 'Rekap Laporan Kas Tunai per Tanggal '.pretty_date($ds, 'd/m/Y', FALSE).' Sampai '.pretty_date($de, 'd/m/Y', FALSE).'.pdf';
        
        $this->load->view('report/cetak_rekap_report',$data);
        
        $html = ob_get_contents();
        ob_end_clean();
        
        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15',array(10, 5, 10, 5));
        $pdf->setDefaultFont('arial');
        $pdf->setTestTdInOnePage(false);
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'D');
	}
	
	public function excel_rekap(){
	    
	    $ds         = $this->uri->segment('4');
		$de         = $this->uri->segment('5');
		$item_id    = $this->uri->segment('6');
		$majors_id  = $this->uri->segment('7');
		$createDS   = date_create($ds);
		$createDE   = date_create($de);
		$start      = date_format($createDS,"n");
		$end        = date_format($createDE,"n");
		
		if ($start == '1'){
		    $monthStart = '7';
		} else if ($start == '2'){
		    $monthStart = '8';
		} else if ($start == '3'){
		    $monthStart = '9';
		} else if ($start == '4'){
		    $monthStart = '10';
		} else if ($start == '5'){
		    $monthStart = '11';
		} else if ($start == '6'){
		    $monthStart = '12';
		} else if ($start == '7'){
		    $monthStart = '1';
		} else if ($start == '8'){
		    $monthStart = '2';
		} else if ($start == '9'){
		    $monthStart = '3';
		} else if ($start == '10'){
		    $monthStart = '4';
		} else if ($start == '11'){
		    $monthStart = '5';
		} else if ($start == '12'){
		    $monthStart = '6';
		}
		
		if ($end == '1'){
		    $monthEnd = '7';
		} else if ($end == '2'){
		    $monthEnd = '8';
		} else if ($end == '3'){
		    $monthEnd = '9';
		} else if ($end == '4'){
		    $monthEnd = '10';
		} else if ($end == '5'){
		    $monthEnd = '11';
		} else if ($end == '6'){
		    $monthEnd = '12';
		} else if ($end == '7'){
		    $monthEnd = '1';
		} else if ($end == '8'){
		    $monthEnd = '2';
		} else if ($end == '9'){
		    $monthEnd = '3';
		} else if ($end == '10'){
		    $monthEnd = '4';
		} else if ($end == '11'){
		    $monthEnd = '5';
		} else if ($end == '12'){
		    $monthEnd = '6';
		}
		
		$interval = $monthStart - 1;
		
		$last = "SELECT '$ds' - INTERVAL '$interval' MONTH as last_month, '$ds' - INTERVAL '1' DAY as yesterday";
		
		$qLast = $this->db->query($last)->row_array();

		//$data['q'] = $q;

		$params = array();
		$param = array();

        // Date start
		if (isset($ds) && !empty($ds) && $ds != '') {
			$params['date_start'] = $ds;
			$param['date_start'] = $qLast['last_month'];
		}

        // Date end
		if (isset($de) && !empty($de) && $de != '') {
			$params['date_end'] = $de;
			$param['date_end'] = $qLast['yesterday'];
		}
		
		if (isset($item_id) && !empty($item_id) && $item_id != 'all') {
			$params['item_id'] = $item_id;
			$param['item_id'] = $item_id;
		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			
			$data['saldoAwal'] = 0;
			
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
    		$params['kas_noref'] = 'isi';
    		$param['kas_noref'] = 'isi';
    		
    		$data['saldoAwal'] = 0;
		}
        
		$params['urutan'] = "ada";
		$params['status'] = 1;
		$param['status'] = 1;

		$data['bulan']  = $this->Unit_pos_model->get_rekap_bulan($params);
		$data['free']   = $this->Unit_pos_model->get_rekap_bebas($params);
		$data['kredit'] = $this->Unit_pos_model->get_rekap_kredit($params);
		$data['gaji']   = $this->Unit_pos_model->get_rekap_gaji($params);
		$data['debit']  = $this->Unit_pos_model->get_rekap_debit($params);
		
		$data['bulanLast']  = $this->Unit_pos_model->get_rekap_bulan_last($param);
		$data['freeLast']   = $this->Unit_pos_model->get_rekap_bebas_last($param);
		$data['kreditLast'] = $this->Unit_pos_model->get_rekap_kredit_last($param);
		$data['gajiLast']   = $this->Unit_pos_model->get_rekap_gaji_last($param);
		$data['debitLast']  = $this->Unit_pos_model->get_rekap_debit_last($param);
		
		$data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
        $this->load->view('report/excel_rekap_report',$data);
	}

}