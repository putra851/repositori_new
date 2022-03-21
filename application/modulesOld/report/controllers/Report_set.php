<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_set extends CI_Controller {

	public function __construct() {
		parent::__construct(TRUE);
		if ($this->session->userdata('logged') == NULL) {
			header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
		}
		
		$this->load->model(array('payment/Payment_model', 'student/Student_model', 'period/Period_model',
		                        'pos/Pos_model', 'bulan/Bulan_model', 'bebas/Bebas_model', 'bebas/Bebas_pay_model',
		                        'setting/Setting_model', 'kredit/Kredit_model', 'debit/Debit_model', 'logs/Logs_model',
		                        'report/Report_model', 'report/Detail_jurnal_model', 'report/Jurnal_model'));

	}

    // payment view in list
	public function index($offset = NULL) {
        // Apply Filter
        // Get $_GET variable
		$q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$params = array();

    // Date start
		if (isset($q['ds']) && !empty($q['ds']) && $q['ds'] != '') {
			$params['date_start'] = $q['ds'];
		}

        // Date end
		if (isset($q['de']) && !empty($q['de']) && $q['de'] != '') {
			$params['date_end'] = $q['de'];
		}


		$paramsPage         = $params;
		$data['period']     = $this->Period_model->get($params);
		$data['class']      = $this->Student_model->get_class();
        $data['majors']     = $this->Student_model->get_majors();
        $data['pos']        = $this->Pos_model->get();
        $data['payment']    = $this->Payment_model->get();
        
		$config['base_url'] = site_url('manage/report/index');
        
		$data['title'] = 'Laporan Pembayaran Per Kelas';
		$data['main'] = 'report/report_list';
		$this->load->view('manage/layout', $data);
	}
	
	public function report_period(){
        $data['period'] = $this->Period_model->get();
        $data['majors'] = $this->Student_model->get_majors();
        
		$config['base_url'] = site_url('manage/report/index');
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		
	    
	    $data['title'] = 'Laporan Pembayaran Per Tanggal';
		$data['main'] = 'report/report_period_list';
		$this->load->view('manage/layout', $data);
	}
	
	public function cari_report_period(){
	    $id_periode = $this->input->post('id_periode');
	    $id_majors  = $this->input->post('id_majors');
        $id_kelas   = $this->input->post('id_kelas');
        $ds         = $this->input->post('ds');
        $de         = $this->input->post('de');
        
        if($id_kelas != '0'){
            $dataClass      = $this->db->query("SELECT * FROM class WHERE class_id = '$id_kelas'")->row_array();
            $kelas = ' Kelas '.$dataClass['class_name'];
        } else {
            $kelas = ' Semua Kelas';
        }
        $dataPeriod     = $this->db->query("SELECT * FROM period WHERE period_id = '$id_periode'")->row_array();
        $dataPayment    = $this->db->query("SELECT * FROM `payment` JOIN period ON payment.period_period_id = period.period_id JOIN pos ON payment.pos_pos_id = pos.pos_id JOIN account ON account.account_id = pos.account_account_id WHERE payment.period_period_id = '$id_periode' AND account.account_majors_id = '$id_majors' ORDER BY payment.payment_type DESC")->result_array();
        
        echo '<div class="box box-primary box-solid">
    		    <div class="box-header with-border">
    			  <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Pembayaran'.$kelas.' T.A.'.$dataPeriod['period_start'].'/'.$dataPeriod['period_end'].' Tanggal '.pretty_date($ds,"d/m/Y",FALSE).' Sampai '.pretty_date($de,"d/m/Y",FALSE).'</h3>
    			</div>
    			<div class="box-body table-responsive">
			    <table class="table">
			    <tr><td>';
			    
    			foreach($dataPayment as $result){
    			    echo '<h4><strong>'.$result['pos_name'].' - T.A '.$result['period_start'].'/'.$result['period_end'].'</strong></h4>';
    			    
                    $paymentID      = $result['payment_id'];
                    $paymentType    = $result['payment_type'];
                    if($paymentType == 'BULAN'){
                        $data = $this->Report_model->get_bulan($paymentID, $id_kelas, $ds, $de);
		                        
		              echo '
            			<div class="box-body table-responsive"><table class="table table-responsive table-hover table-bordered" style="white-space: nowrap;">
    							<tr>
    							    <th>No.</th>
    							    <th>Tanggal</th>
    								<th>NIS</th>
    								<th>Nama</th>
    							    <th>Nominal</th>
    							    <th>Keterangan</th>
    						    <tr>';
    						$sumBulan = 0;
    					    $no = 1;
    					    foreach($data as $row){
    				        echo '<tr>
    				                <td>'.$no++.'</td>
    				                <td>'.pretty_date($row['bulan_date_pay'],"d/m/Y",FALSE).'</td>
    				                <td>'.$row['student_nis'].'</td>
    				                <td>'.$row['student_full_name'].'</td>
    				                <td>'.'Rp '.number_format($row['bulan_bill'],0,",",".").'</td>
    				                <td>'.$row['month_name'].'</td>
    						    </tr>';
    						    $sumBulan += $row['bulan_bill'];
    					    }
    						echo '<tr style="background-color: #f0f0f0"><td colspan="4"><strong>Total Pembayaran</strong></td><td>'.'Rp '.number_format($sumBulan,0,",",".").'</td><td></td></tr>';
    				echo '</table>
    					</div>';
		                    } else {
		                        $data = $this->Report_model->get_bebas($paymentID, $id_kelas, $ds, $de);
		                        echo '
            			<div class="box-body table-responsive"><table class="table table-responsive table-hover table-bordered" style="white-space: nowrap;">
    							<tr>
    							    <th>No.</th>
    							    <th>Tanggal</th>
    								<th>NIS</th>
    								<th>Nama</th>
    							    <th>Nominal</th>
    							    <th>Keterangan</th>
    						    <tr>';
    						$sumBebas = 0;
    					    $no = 1;
    					    foreach($data as $row){
    				        echo '<tr>
    				                <td>'.$no++.'</td>
    				                <td>'.pretty_date($row['bebas_pay_input_date'],"d/m/Y",FALSE).'</td>
    				                <td>'.$row['student_nis'].'</td>
    				                <td>'.$row['student_full_name'].'</td>
    				                <td>'.'Rp '.number_format($row['bebas_pay_bill'],0,",",".").'</td>
    				                <td>'.$row['bebas_pay_desc'].'</td>
    						    </tr>';
    						    $sumBebas += $row['bebas_pay_bill'];
    					    }
    						echo '<tr style="background-color: #f0f0f0"><td colspan="4"><strong>Total Pembayaran</strong></td><td>'.'Rp '.number_format($sumBebas,0,",",".").'</td><td></td></tr>';
    				echo '</table>
    					</div>';
		                    }
            			}
            			
    		    echo '</td>
    		          </tr>
					</table>
				</div>';
			echo '<div class="box-footer">
			         <a class="pull-right btn btn-danger" target="_blank" href="'.base_url().'manage/report/report_period_print/'.$ds.'/'.$de.'/'.$id_periode.'/'.$id_majors.'/'.$id_kelas.'"><span class="glyphicon glyphicon-print"></span> Cetak PDF</a>
				</div>
				</div>
			</div>';
	}
	
	public function report_period_print(){
        $this->load->helper(array('dompdf'));
        
        $ds         = $this->uri->segment('4');
        $de         = $this->uri->segment('5');
	    $id_periode = $this->uri->segment('6');
        $id_majors  = $this->uri->segment('7');
        $id_kelas   = $this->uri->segment('8');
        
        $dataClass  = $this->db->query("SELECT * FROM class WHERE class_id = '$id_kelas'")->row_array();
        $dataPeriod       = $this->db->query("SELECT * FROM period WHERE period_id = '$id_periode'")->row_array();
        
        $data['dataClass']  = $this->db->query("SELECT * FROM class WHERE class_id = '$id_kelas'")->row_array();
        $data['dataPeriod']       = $this->db->query("SELECT * FROM period WHERE period_id = '$id_periode'")->row_array();
        $data['dataPayment'] = $this->db->query("SELECT * FROM `payment` JOIN period ON payment.period_period_id = period.period_id JOIN pos ON payment.pos_pos_id = pos.pos_id JOIN account ON account.account_id = pos.account_account_id WHERE payment.period_period_id = '$id_periode' AND account.account_majors_id = '$id_majors' ORDER BY payment.payment_type DESC")->result_array();
        
        
        $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));  
        
        
        $html = $this->load->view('report/cetak_report_period',$data, TRUE);
        $data = pdf_create($html, 'Laporan Pembayaran Kelas '.$dataClass['class_name'].' T.A.'.$dataPeriod['period_start'].'/'.$dataPeriod['period_end'].' Tanggal '.pretty_date($ds,"d/m/Y",FALSE).' Sampai '.pretty_date($de,"d/m/Y",FALSE), TRUE, 'A4', TRUE);
        
	}
	
	public function report_tagihan(){
		$params = array();
		
		//$paramsPage = $params;
		$data['period'] = $this->Period_model->get($params);
		$data['majors'] = $this->Student_model->get_majors($params);
		
		$config['base_url'] = site_url('manage/report/index');
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		//$config['total_rows'] = count($this->Bulan_model->get($paramsPage));
        
		$data['title'] = 'Laporan Tagihan';
		$data['main'] = 'report/report_tagihan_list';
		$this->load->view('manage/layout', $data);
	}
	
	function cari_tagihan(){
        $id_periode = $this->input->post('id_periode');
        $dataTagihan  = $this->Payment_model->cari_tagihan($id_periode);
    
        echo ' <select name="tagihan_id" id="tagihan_id" class="form-control" required="">
                    <option value="">--Pilih Tagihan--</option>';
                      foreach($dataTagihan as $row){ 
        
                        echo '<option value="'.$row['payment_id'].'">';
                            
                        echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'];
                            
                        echo '</option>';
                    
                        }
                                        
        echo '</select>';
    }
	
	function class_searching(){
	    $id_majors = $this->input->post('id_majors');
        $dataKelas  = $this->db->query("SELECT * FROM class WHERE majors_majors_id = '$id_majors' ORDER BY class_name ASC")->result_array();
    
        echo '<div class="col-md-3">  
				<div class="form-group">
				    <label>Kelas</label>
		            <select name="c" id="class_id" class="form-control" required="">
                    <option value="">-- Pilih Kelas --</option>';
                      foreach($dataKelas as $row){ 
        
                        echo '<option value="'.$row['class_id'].'">';
                            
                        echo $row['class_name'];
                            
                        echo '</option>';
                    
                        }
            echo '</select>
				</div>
			</div>';
	}
	
	function cari_kelas(){
        $id_majors = $this->input->post('id_majors');
        $dataKelas  = $this->db->query("SELECT * FROM class WHERE majors_majors_id = '$id_majors' ORDER BY class_name ASC")->result_array();
    
        echo '<select name="class_id" id="class_id" class="form-control" required="">
                    <option value="">--Pilih Kelas--</option>
                    <option value="0">Semua Kelas</option>';
                      foreach($dataKelas as $row){ 
        
                        echo '<option value="'.$row['class_id'].'">';
                            
                        echo $row['class_name'];
                            
                        echo '</option>';
                    
                        }
                                        
        echo '</select>';
    }
	
	function get_tagihan(){
        $id_periode = $this->input->post('id_periode');
        $id_majors  = $this->input->post('id_majors');
        $dataTagihan  = $this->Payment_model->get_tagihan($id_periode, $id_majors);
    
        echo ' <select name="tagihan_id" id="tagihan_id" class="form-control" required="">
                    <option value="">--Pilih Tagihan--</option>';
                      foreach($dataTagihan as $row){ 
        
                        echo '<option value="'.$row['payment_id'].'">';
                            
                        echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'];
                            
                        echo '</option>';
                    
                        }
                                        
        echo '</select>';
    }

    function cari_data(){
        $dataMonth    = $this->db->query("SELECT * FROM month")->result();
        $id_periode   = $this->input->post('id_periode');
        $id_tagihan   = $this->input->post('id_tagihan');
        $id_kelas     = $this->input->post('id_kelas');
        if($id_kelas != '0'){
            $kls          = $this->db->query("SELECT class_name FROM class WHERE class_id = '$id_kelas'")->row();
            $kelas = ' Kelas '.$kls->class_name;
            $kueri = "SELECT * FROM `bulan` join student on bulan.student_student_id = student.student_id JOIN class ON student.class_class_id = class.class_id where bulan.payment_payment_id = '$id_tagihan' AND class.class_id = '$id_kelas'";
        } else {
            $kelas = ' Semua Kelas';
            $kueri = "SELECT * FROM `bulan` join student on bulan.student_student_id = student.student_id JOIN class ON student.class_class_id = class.class_id where bulan.payment_payment_id = '$id_tagihan'";
        }
        $bayarBulan   = $this->db->query($kueri)->result();
        $query        = "SELECT payment_type FROM payment WHERE payment_id = '$id_tagihan'";
        $dataCek      = $this->db->query($query)->row();
        $q = "SELECT * FROM `payment` JOIN period ON payment.period_period_id = period.period_id JOIN pos ON payment.pos_pos_id = pos.pos_id WHERE payment.payment_id = '$id_tagihan'";
        $dataHead     = $this->db->query($q)->row();
        $dataBulan    = $this->Bulan_model->get_cari_bulan($id_periode,$id_tagihan,$id_kelas);
        $dataBebas    = $this->Bebas_model->get_cari_bebas($id_periode,$id_tagihan,$id_kelas);
        if($id_periode == '' || $id_tagihan == '' || $id_kelas==''){
            echo "<script>alert('Maaf, ada kategori pencarian yang belum diisi. Tolang periksa lagi.');</script>";
        }
        else{
            if($dataCek->payment_type == 'BULAN'){
                echo '<div class="box box-primary box-solid">
            		    <div class="box-header with-border">
            			  <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Pembayaran '.$dataHead->pos_name.' - T.A '.$dataHead->period_start.'/'.$dataHead->period_end.$kelas.'</h3>
            			</div>
            			<div class="box-body table-responsive">
    						<table id="dtable" class="table table-responsive table-hover table-bordered" style="white-space: nowrap;">
    						<thead>
    							<tr>
    							    <th>No.</th>
    							    <th>NIS</th>
    								<th>Nama</th>';	 
    							foreach ($dataMonth as $bln) {  
    						    echo '<th>'.$bln->month_name.'</th>';
    							} 
    					    echo '</tr>
    					    </thead><tbody>';
    					    $no = 1;
    					    foreach ($dataBulan as $row) {
    				        echo '<tr>
    				                <td>'.$no++.'</td>
    				                <td>'.$row->student_nis.'</td>
    				                <td>'.$row->student_full_name.'</td>';
    				                
    					    $sumBulan = 0;
    				         foreach($bayarBulan as $key){       
    				          if ($key->student_student_id==$row->student_student_id) {
    							echo '<td style="color:'; 
    							if ($key->bulan_status==1){ 
    							    echo '#00000';
    							} else{ 
    							    echo '#00000';
    							}
    							echo '">';
    							if($key->bulan_status==1) {
    							    echo "Rp ".number_format($key->bulan_bill, 0, ",", ".");
    							    echo '<br>';
    							    echo date_format(date_create($key->bulan_date_pay),"d/m/Y");
    							} 
    							  else { 
    							     echo '-';
    							  }
    							  echo '</td>';
    								}
    								
    					    }
                            echo '</tr>';
    					    }
    				echo '</tbody></table>
    					</div>
    					<div class="box-footer">
    					    <a class="btn btn-success" target="_blank" href="'.base_url().'manage/report/report_excel_bulan/'.$id_periode.'/'.$id_tagihan.'/'.$id_kelas.'"><i class="fa fa-file-excel-o"></i> Export Excel</a>
    					    <a class="pull-right btn btn-danger" target="_blank" href="'.base_url().'manage/report/report_cetak_bulan/'.$id_periode.'/'.$id_tagihan.'/'.$id_kelas.'"><span class="glyphicon glyphicon-print"></span> Cetak PDF</a>
    					</div>
    					</div>
    				</div>';
    				
    				echo "
    				    <script>
                            $(document).ready(function(){
                            	$('#dtable').DataTable();
                            });
                        </script>
    				    ";
            }
            else{
                echo '<div class="box box-primary box-solid">
            		    <div class="box-header with-border">
            			  <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Pembayaran '.$dataHead->pos_name.' - T.A '.$dataHead->period_start.'/'.$dataHead->period_end.' '.$kelas.'</h3>
            			</div>
            			<div class="box-body table-responsive">
            			<table id="dtable" class="table table-responsive table-hover table-bordered" style="white-space: nowrap;">
    						<thead>
    						    <tr>
    							    <th>No.</th>
    							    <th>NIS</th>
    								<th>Nama</th>
    								<th>Tagihan</th>
    								<th>Sudah Dibayar</th>
    								<th>Kekurangan</th>
    								<th>Keterangan</th>
    						    </tr>
    					    </thead>
    					    <tbody>';
    						    $no = 1;
    						    $sumBebas = 0;
    					    foreach ($dataBebas as $row) {
    				        echo '<tr>
    				                <td>'.$no++.'</td>
    				                <td>'.$row->student_nis.'</td>
    				                <td>'.$row->student_full_name.'</td>
    				                <td>'.'Rp '.number_format($row->bebas_bill, 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($row->bebas_total_pay, 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($row->kekurangan, 0, ",", ".").'</td>
    				                <td style="color:';
    				                if ($row->kekurangan<1){ 
    							        echo '#000000';
    							    } else{ 
    							        echo '#000000';
    							    }
    							echo '">';
    							    if ($row->kekurangan<1){ 
    							        echo 'LUNAS';
    							    } else{ 
    							        echo 'BELUM LUNAS';
    							    }
    				            echo'</td>
    						    </tr>';
    						    $sumBebas += $row->bebas_total_pay;
    					    }
    				    echo '</tbody>
    				            <tr style="background-color: #F0F0F0;">
                                    <td colspan="4">
                                        <b>Total Pembayaran Siswa</b>
                                    </td>
                                    <td><b>Rp '.
                                      number_format($sumBebas,0,",",".")
                                      .'</b></td>
                                    <td colspan="2">
                                    </td>
                                </tr>';
    				echo '</table>
    					</div>
    					<div class="box-footer">
    					    <a class="btn btn-success" target="_blank" href="'.base_url().'manage/report/report_excel_bebas/'.$id_periode.'/'.$id_tagihan.'/'.$id_kelas.'"><i class="fa fa-file-excel-o"></i> Export Excel</a>
    					    <a class="pull-right btn btn-danger" target="_blank" href="'.base_url().'manage/report/report_cetak_bebas/'.$id_periode.'/'.$id_tagihan.'/'.$id_kelas.'"><span class="glyphicon glyphicon-print"></span> Cetak PDF</a>
    					</div>
    					</div>
    				</div>';
    				
    				echo "
    				    <script>
                            $(document).ready(function(){
                            	$('#dtable').DataTable();
                            });
                        </script>
    				    ";
                }
                
        }
    }
    
    public function report_cetak_bulan(){
        ob_start();
        
        $id_periode         = $this->uri->segment('4');
        $id_tagihan         = $this->uri->segment('5');
        $id_kelas           = $this->uri->segment('6');
        $data['dataMonth']  = $this->db->query("SELECT * FROM month")->result();
        $q                  = "SELECT * FROM `payment` JOIN period ON payment.period_period_id = period.period_id JOIN pos ON payment.pos_pos_id = pos.pos_id WHERE payment.payment_id = '$id_tagihan'";
        if($id_kelas != '0'){
            $kueri = "SELECT * FROM `bulan` join student on bulan.student_student_id = student.student_id JOIN class ON student.class_class_id = class.class_id where bulan.payment_payment_id = '$id_tagihan' AND class.class_id = '$id_kelas'";
            $dKelas = $this->db->query("SELECT class_name FROM class WHERE class_id='$id_kelas'")->row();
            $dataKelas = $dKelas->class_name;
        } else {
            $kueri = "SELECT * FROM `bulan` join student on bulan.student_student_id = student.student_id JOIN class ON student.class_class_id = class.class_id where bulan.payment_payment_id = '$id_tagihan'";
            $dataKelas = 'Semua Kelas';
        }
        $data['bayarBulan'] = $this->db->query($kueri)->result();
        $dHead              = $this->db->query($q)->row();
        $data['dataKelas'] = $this->db->query("SELECT class_name FROM class WHERE class_id='$id_kelas'")->row();
        $data['dataHead']   = $this->db->query($q)->row();
        $data['dataBulan']  = $this->Bulan_model->get_cari_bulan($id_periode,$id_tagihan,$id_kelas);
        
        $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));  
    
        $filename = 'Laporan_Pembayaran_'.$dHead->pos_name.'- TA'.$dHead->period_start.'-'.$dHead->period_end.'_Kelas_'.$dataKelas.'_'.date('Y-m-d').'.pdf';
        $this->load->view('report/report_cetak_bulan',$data);
        
        $html = ob_get_contents();
        ob_end_clean();
        
        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('l','A4','en');
        $pdf->setDefaultFont('arial'); 
        $pdf->setTestTdInOnePage(false);
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'D');
    }
    
    public function report_cetak_bebas(){
        $this->load->helper(array('dompdf'));
        
        $id_periode         = $this->uri->segment('4');
        $id_tagihan         = $this->uri->segment('5');
        $id_kelas           = $this->uri->segment('6');
        
        $q                  = "SELECT * FROM `payment` JOIN period ON payment.period_period_id = period.period_id JOIN pos ON payment.pos_pos_id = pos.pos_id WHERE payment.payment_id = '$id_tagihan'";
        
        if($id_kelas != '0'){
            $kueri = "SELECT * FROM `bebas` join student on bebas.student_student_id = student.student_id JOIN class ON student.class_class_id = class.class_id where bebas.payment_payment_id = '$id_tagihan' AND class.class_id = '$id_kelas'";
            $dKelas = $this->db->query("SELECT class_name FROM class WHERE class_id='$id_kelas'")->row();
            $dataKelas = $dKelas->class_name;
        } else {
            $kueri = "SELECT * FROM `bebas` join student on bebas.student_student_id = student.student_id JOIN class ON student.class_class_id = class.class_id where bebas.payment_payment_id = '$id_tagihan'";
            $dataKelas = 'Semua Kelas';
        }
        $data['bayarBebas'] = $this->db->query($kueri)->result();
        $dHead              = $this->db->query($q)->row();
        $data['dataKelas'] = $this->db->query("SELECT class_name FROM class WHERE class_id='$id_kelas'")->row();
        $data['dataHead']   = $this->db->query($q)->row();
        $data['dataBebas']  = $this->Bebas_model->get_cari_bebas($id_periode,$id_tagihan,$id_kelas);
        
        $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
        $html = $this->load->view('report/report_cetak_bebas', $data, TRUE);
        $data = pdf_create($html, 'Laporan_Pembayaran_'.$dHead->pos_name.'- TA'.$dHead->period_start.'-'.$dHead->period_end.'_Kelas_'.$dataKelas.'_'.pretty_date(date('Y-m-d'),'d F Y',false), TRUE, 'A4', TRUE);
    }
    
    public function report_excel_bulan(){
        $id_periode         = $this->uri->segment('4');
        $id_tagihan         = $this->uri->segment('5');
        $id_kelas           = $this->uri->segment('6');
        $data['dataMonth']  = $this->db->query("SELECT * FROM month")->result();
        
        if($id_kelas != '0'){
            $kueri = "SELECT * FROM `bulan` join student on bulan.student_student_id = student.student_id JOIN class ON student.class_class_id = class.class_id where bulan.payment_payment_id = '$id_tagihan' AND class.class_id = '$id_kelas'";
            $dKelas = $this->db->query("SELECT class_name FROM class WHERE class_id='$id_kelas'")->row();
            $dataKelas = $dKelas->class_name;
        } else {
            $kueri = "SELECT * FROM `bulan` join student on bulan.student_student_id = student.student_id JOIN class ON student.class_class_id = class.class_id where bulan.payment_payment_id = '$id_tagihan'";
            $dataKelas = 'Semua Kelas';
        }
        
        $data['bayarBulan'] = $this->db->query($kueri)->result();
        $q                  = "SELECT * FROM `payment` JOIN period ON payment.period_period_id = period.period_id JOIN pos ON payment.pos_pos_id = pos.pos_id WHERE payment.payment_id = '$id_tagihan'";
        $data['dataKelas']     = $this->db->query("SELECT class_name FROM class WHERE class_id='$id_kelas'")->row();
        $dHead              = $this->db->query($q)->row();
        $data['dataHead']   = $this->db->query($q)->row();
        $data['dataBulan']  = $this->Bulan_model->get_cari_bulan($id_periode,$id_tagihan,$id_kelas);
        
        $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
    
        $this->load->view('report/excel_cetak_bulan',$data);
    }
    
    public function report_excel_bebas(){
        $id_periode         = $this->uri->segment('4');
        $id_tagihan         = $this->uri->segment('5');
        $id_kelas           = $this->uri->segment('6');
        
        $q                  = "SELECT * FROM `payment` JOIN period ON payment.period_period_id = period.period_id JOIN pos ON payment.pos_pos_id = pos.pos_id WHERE payment.payment_id = '$id_tagihan'";
        
        if($id_kelas != '0'){
            $kueri = "SELECT * FROM `bebas` join student on bebas.student_student_id = student.student_id JOIN class ON student.class_class_id = class.class_id where bebas.payment_payment_id = '$id_tagihan' AND class.class_id = '$id_kelas'";
            $dKelas = $this->db->query("SELECT class_name FROM class WHERE class_id='$id_kelas'")->row();
            $dataKelas = $dKelas->class_name;
        } else {
            $kueri = "SELECT * FROM `bebas` join student on bebas.student_student_id = student.student_id JOIN class ON student.class_class_id = class.class_id where bebas.payment_payment_id = '$id_tagihan'";
            $dataKelas = 'Semua Kelas';
        }
        $data['bayarBebas'] = $this->db->query($kueri)->result();
        $dHead              = $this->db->query($q)->row();
        $data['dataKelas'] = $this->db->query("SELECT class_name FROM class WHERE class_id='$id_kelas'")->row();
        $data['dataHead']   = $this->db->query($q)->row();
        $data['dataBebas']  = $this->Bebas_model->get_cari_bebas($id_periode,$id_tagihan,$id_kelas);
        
        $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
        
        $this->load->view('report/excel_cetak_bebas',$data);
    }
    
	public function report_bill() {

		$q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$params = array();
		$param = array();
		$stu = array();
		$free = array();
		$bul = 'BULAN';

		if (isset($q['p']) && !empty($q['p']) && $q['p'] != '') {
			$params['period_id'] = $q['p'];
			$param['period_id'] = $q['p'];
			$stu['period_id'] = $q['p'];
			$free['period_id'] = $q['p'];
			$data['looping'] = $this->Bulan_model->get_jumlah($q['c']);
		}

		if (isset($q['c']) && !empty($q['c']) && $q['c'] != '') {
			$params['class_id'] = $q['c'];
			$param['class_id'] = $q['c'];
			$stu['class_id'] = $q['c'];
			$free['class_id'] = $q['c'];
			$data['looping'] = $this->Bulan_model->get_jumlah($q['c']);
		}

		if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
			$params['majors_id'] = $q['k'];
			$param['majors_id'] = $q['k'];
			$stu['majors_id'] = $q['k'];
			$free['majors_id'] = $q['k'];
			$data['looping'] = $this->Bulan_model->get_jumlah($q['c']);

		$param['paymentt'] = TRUE;
		$params['grup'] = TRUE;
		$stu['group'] = TRUE;
		
		$data['student'] = $this->Bulan_model->get($stu);
		$data['bulan'] = $this->Bulan_model->get($free);
		$data['month'] = $this->Bulan_model->get($params);
		$data['py'] = $this->Bulan_model->get($param);
		$data['bebas'] = $this->Bebas_model->get($params);
		$data['free'] = $this->Bebas_model->get($free);
		
		}
        
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		
		
		$data['period'] = $this->Period_model->get($params);
		$data['class'] = $this->Student_model->get_class($params);
		$data['majors'] = $this->Student_model->get_majors($params);

		$data['title'] = 'Rekapitulasi';
		$data['main'] = 'report/report_bill_list';
		$this->load->view('manage/layout', $data);
	}
	
	public function report_jurnal(){
	    
	    $params = array();
		$data['period'] = $this->Period_model->get($params);
		
		$config['base_url'] = site_url('manage/report/index');
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		//$config['total_rows'] = count($this->Bulan_model->get($paramsPage));
        
        $data['majors'] = $this->Student_model->get_majors();
        
		$data['title'] = 'Laporan Jurnal';
		$data['main'] = 'report/report_jurnal';
		$this->load->view('manage/layout', $data);
	}
	
	public function search_report_jurnal(){
	    
		$ds         = $this->input->post('ds');
		$de         = $this->input->post('de');
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
			$param['date_end'] = $ds;
		}
		
// 		if (isset($period_id) && !empty($period_id) && $period_id != '') {
// 			$params['period_id'] = $period_id;
// 			$param['period_id'] = $period_id;
// 		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			
			$saldoAwal = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Tunai%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
			
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
		$params['kas_noref'] = 'isi';
		$param['kas_noref'] = 'isi';
		
		$saldoAwal = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Tunai%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		
		}
        
		$params['status'] = 1;
		$param['status'] = 1;

		$bulan  = $this->Bulan_model->get_jurnal($params);
		$free   = $this->Bebas_pay_model->get_jurnal($params);
		$gaji   = $this->Kredit_model->gaji_jurnal($params);
		$kredit = $this->Kredit_model->get_jurnal($params);
		$debit  = $this->Debit_model->get_jurnal($params);
		
		$bulanLast  = $this->Bulan_model->get_last_jurnal($param);
		$freeLast   = $this->Bebas_pay_model->get_last_jurnal($param);
		$gajiLast = $this->Kredit_model->gaji_last_jurnal($param);
		$kreditLast = $this->Kredit_model->get_last_jurnal($param);
		$debitLast  = $this->Debit_model->get_last_jurnal($param);
		
		$sumBulanLast = 0;
		foreach($bulanLast as $row){
		    $sumBulanLast += $row['bulan_bill'];
		}
		$sumFreeLast = 0;
		foreach($freeLast as $row){
		    $sumFreeLast += $row['bebas_pay_bill'];
		}
		$sumGajiLast = 0;
		foreach($gajiLast as $row){
		    $sumGajiLast += $row['kredit_value'];
		}
		$sumKreditLast = 0;
		foreach($kreditLast as $row){
		    $sumKreditLast += $row['kredit_value'];
		}
		$sumDebitLast = 0;
		foreach($debitLast as $row){
		    $sumDebitLast += $row['debit_value'];
		}
		
		echo '<div class="box box-primary box-solid">
            		    <div class="box-header with-border">
            			  <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan per Tanggal '.pretty_date($ds, 'd/m/Y', FALSE).' Sampai '.pretty_date($de, 'd/m/Y', FALSE).'</h3>
            			</div>
            			<div class="box-body table-responsive">
            			<table class="table table-responsive table-hover table-bordered" id="xtable" style="white-space: nowrap;">
            			        <thead>
    							<tr>
    							    <th>Order</th>
    								<th>Akun</th>
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
    				                <td>'.$row['account_description'].'</td>
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
    				                <td>'.$row['account_description'].'</td>
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
    					    $sumGaji = 0;
    					    foreach ($gaji as $row) {
    				        echo '<tr>
    				                <td>'.pretty_date($row['kredit_date'], 'Ymd', FALSE).'</td>
    				                <td>'.$row['accDesc'].'</td>
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
    				                <td>'.$row['accDesc'].'</td>
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
    					    $sumDebit = 0;
    					    foreach ($debit as $row) {
    				        echo '<tr>
    				                <td>'.pretty_date($row['debit_date'], 'Ymd', FALSE).'</td>
    				                <td>'.$row['account_description'].'</td>
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
    					    $sumA = $sumBulan + $sumFree + $sumDebit;
    					    $sumB = $sumKredit + $sumGaji;
    					    echo '
    						    </tbody>
    						    <tr style="background-color: #E2F7FF;">
    				                <td colspan = "7" align = "right"><strong>Sub Total</strong></td>
    				                <td>'.'Rp '.number_format($sumA,0,",",".").'</td>
    				                <td>'.'Rp '.number_format($sumB,0,",",".").'</td>
    						    </tr>';
    					    $sumLastA = $sumBulanLast + $sumFreeLast + $sumDebitLast;
    					    $sumLastB = $sumKreditLast + $sumGajiLast;
    					    echo '<tr style="background-color: #F0B2B2;">
    				                <td colspan = "7" align = "right"><strong>Saldo Awal</strong></td>
    				                <td>'.'Rp '.number_format($saldoAwal['nominal']+$sumLastA-$sumLastB,0,",",".").'</td>
    				                <td> - </td>
    						    </tr>';
    						echo '<tr style="background-color: #FFFCBE;">
    				                <td colspan = "7" align = "right"><strong>Total (Sub Total + Saldo Awal)</strong></td>
    				                <td>'.'Rp '.number_format($saldoAwal['nominal']+$sumLastA+$sumA-$sumLastB,0,",",".").'</td>
    				                <td>'.'Rp '.number_format($sumB,0,",",".").'</td>
    						    </tr>';
    						echo '<tr style="background-color: #c2d2f6;">
    				                <td colspan = "7" align = "right"><strong>Saldo Akhir</strong></td>
    				                <td>'.'Rp '.number_format(($saldoAwal['nominal']+$sumLastA+$sumA)-($sumLastB+$sumB),0,",",".").'</td>
    				                <td> - </td>
    						    </tr>';
    				echo '</table>
    					</div>
    					<div class="box-footer">
    					<table class="table">
        			        <tr>
        					    <td>
                					<div class="md-6">
                					    <a class="btn btn-danger" target="_blank" href="'.base_url().'manage/report/cetak_detail_jurnal/'.$ds.'/'.$de.'/'.$majors_id.'"><span class="fa fa-file-pdf-o"></span> PDF Per Jenis Anggaran
                					    </a>
                					    <a class="btn btn-success" target="_blank" href="'.base_url().'manage/report/excel_detail_jurnal/'.$ds.'/'.$de.'/'.$majors_id.'"><span class="fa fa-file-excel-o"></span> Excel Per Jenis Anggaran
                					    </a>
                					</div>
        					    </td>
        					    <td>
        					        <div class="pull-right">
                					    <a class="btn btn-danger" target="_blank" href="'.base_url().'manage/report/cetak_rekap_jurnal/'.$ds.'/'.$de.'/'.$majors_id.'"><span class="fa fa-file-pdf-o"></span> PDF Rekap Laporan
                					    </a>
                					    <a class="btn btn-success" target="_blank" href="'.base_url().'manage/report/excel_rekap_jurnal/'.$ds.'/'.$de.'/'.$majors_id.'"><span class="fa fa-file-excel-o"></span> Excel Rekap Laporan
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
	
	public function report_date(){
	    
	    $params = array();
		$data['period'] = $this->Period_model->get($params);
		
		$config['base_url'] = site_url('manage/report/index');
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		//$config['total_rows'] = count($this->Bulan_model->get($paramsPage));
        
        $data['majors'] = $this->Student_model->get_majors();
        
		$data['title'] = 'Laporan Jurnal (Kas Tunai)';
		$data['main'] = 'report/report_date_list';
		$this->load->view('manage/layout', $data);
	}
	
	public function search_report_date(){
	    
		$ds         = $this->input->post('ds');
		$de         = $this->input->post('de');
		$period_id  = $this->input->post('period_id');
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
			$param['date_start'] = $qLast['last_month'];
		}

        // Date end
		if (isset($de) && !empty($de) && $de != '') {
			$params['date_end'] = $de;
			$param['date_end'] = $qLast['yesterday'];
		}
		
		if (isset($period_id) && !empty($period_id) && $period_id != '') {
			$params['period_id'] = $period_id;
			$param['period_id'] = $period_id;
		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			
			$saldoAwal = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Tunai%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
			
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
		$params['kas_noref'] = 'isi';
		$param['kas_noref'] = 'isi';
		
		$saldoAwal = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Tunai%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		
		}
        
		$params['status'] = 1;
		$param['status'] = 1;

		$bulan  = $this->Bulan_model->get_kas($params);
		$free   = $this->Bebas_pay_model->get_kas($params);
		$gaji   = $this->Kredit_model->gaji_kas($params);
		$kredit = $this->Kredit_model->get_kas($params);
		$debit  = $this->Debit_model->get_kas($params);
		
		$bulanLast  = $this->Bulan_model->get_last_kas($param);
		$freeLast   = $this->Bebas_pay_model->get_last_kas($param);
		$gajiLast = $this->Kredit_model->gaji_last_kas($param);
		$kreditLast = $this->Kredit_model->get_last_kas($param);
		$debitLast  = $this->Debit_model->get_last_kas($param);
		
		$sumBulanLast = 0;
		foreach($bulanLast as $row){
		    $sumBulanLast += $row['bulan_bill'];
		}
		$sumFreeLast = 0;
		foreach($freeLast as $row){
		    $sumFreeLast += $row['bebas_pay_bill'];
		}
		$sumGajiLast = 0;
		foreach($gajiLast as $row){
		    $sumGajiLast += $row['kredit_value'];
		}
		$sumKreditLast = 0;
		foreach($kreditLast as $row){
		    $sumKreditLast += $row['kredit_value'];
		}
		$sumDebitLast = 0;
		foreach($debitLast as $row){
		    $sumDebitLast += $row['debit_value'];
		}
		
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
    				                <td>'.'Rp '.number_format($saldoAwal['nominal']+$sumLastA-$sumLastB,0,",",".").'</td>
    				                <td> - </td>
    						    </tr>';
    						echo '<tr style="background-color: #FFFCBE;">
    				                <td colspan = "6" align = "right"><strong>Total (Sub Total + Saldo Awal)</strong></td>
    				                <td>'.'Rp '.number_format($saldoAwal['nominal']+$sumLastA+$sumA,0,",",".").'</td>
    				                <td>'.'Rp '.number_format($sumLastB+$sumB,0,",",".").'</td>
    						    </tr>';
    						echo '<tr style="background-color: #c2d2f6;">
    				                <td colspan = "6" align = "right"><strong>Saldo Akhir</strong></td>
    				                <td>'.'Rp '.number_format(($saldoAwal['nominal']+$sumLastA+$sumA)-($sumLastB+$sumB),0,",",".").'</td>
    				                <td> - </td>
    						    </tr>';
    				echo '</table>
    					</div>
    					<div class="box-footer">
    					<table class="table">
        			        <tr>
        					    <td>
                					<div class="md-6">
                					    <a class="btn btn-danger" target="_blank" href="'.base_url().'manage/report/cetak_detail_jurnal/'.$ds.'/'.$de.'/'.$period_id.'/'.$majors_id.'"><span class="fa fa-file-pdf-o"></span> PDF Per Jenis Anggaran
                					    </a>
                					    <a class="btn btn-success" target="_blank" href="'.base_url().'manage/report/excel_detail_jurnal/'.$ds.'/'.$de.'/'.$period_id.'/'.$majors_id.'"><span class="fa fa-file-excel-o"></span> Excel Per Jenis Anggaran
                					    </a>
                					</div>
        					    </td>
        					    <td>
        					        <div class="pull-right">
                					    <a class="btn btn-danger" target="_blank" href="'.base_url().'manage/report/cetak_rekap_jurnal/'.$ds.'/'.$de.'/'.$period_id.'/'.$majors_id.'"><span class="fa fa-file-pdf-o"></span> PDF Rekap Laporan
                					    </a>
                					    <a class="btn btn-success" target="_blank" href="'.base_url().'manage/report/excel_rekap_jurnal/'.$ds.'/'.$de.'/'.$period_id.'/'.$majors_id.'"><span class="fa fa-file-excel-o"></span> Excel Rekap Laporan
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
	
	public function report_bank(){
	    
	    $params = array();
		$data['period'] = $this->Period_model->get($params);
		
		$config['base_url'] = site_url('manage/report/index');
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		//$config['total_rows'] = count($this->Bulan_model->get($paramsPage));
        
        $data['majors'] = $this->Student_model->get_majors();
        
		$data['title'] = 'Laporan Kas Bank';
		$data['main'] = 'report/report_bank_list';
		$this->load->view('manage/layout', $data);
	}
	
	public function cari_bank(){
	    $id_majors = $this->input->post('majors_id');
	    
		$bank = $this->db->query("SELECT * FROM account WHERE account_category = '2' AND account_majors_id = '$id_majors' AND account_code LIKE '1%' AND account_description LIKE '%Bank%' AND account_note IN (SELECT account_id FROM account WHERE account_category = '0' AND account_majors_id = '$id_majors' AND account_code LIKE '1%' AND account_description LIKE '%Aktiva%' ORDER BY account_code ASC) ORDER BY account_code ASC")->result_array();
		
		echo '<div class="col-md-2">  
			<div class="form-group">
			<select required="" name="bank_id" id="bank_id" class="form-control">
			    <option value="">-- Pilih Bank --</option>
			    <option value="all">Semua Bank</option>';
			     foreach($bank as $row){
			        echo '<option value="'.$row['account_id'].'" >'.$row['account_code'].' - '.$row['account_description'].'</option>';
			     }
		echo '</select>
			</div>
		</div>';
	}
	
	public function search_report_bank(){
	    
		$ds         = $this->input->post('ds');
		$de         = $this->input->post('de');
		$period_id  = $this->input->post('period_id');
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
			$param['date_start'] = $qLast['last_month'];
		}

        // Date end
		if (isset($de) && !empty($de) && $de != '') {
			$params['date_end'] = $de;
			$param['date_end'] = $qLast['yesterday'];
		}
		
		if (isset($period_id) && !empty($period_id) && $period_id != '') {
			$params['period_id'] = $period_id;
			$param['period_id'] = $period_id;
		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			
			$saldoAwal = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Bank%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
			
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
		$params['kas_noref'] = 'isi';
		$param['kas_noref'] = 'isi';
		
		$saldoAwal = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Bank%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		}
        
		$params['status'] = 1;
		$param['status'] = 1;

		$bulan  = $this->Bulan_model->get_bank($params);
		$free   = $this->Bebas_pay_model->get_bank($params);
		$kredit = $this->Kredit_model->get_bank($params);
		$gaji = $this->Kredit_model->gaji_bank($params);
		$debit  = $this->Debit_model->get_bank($params);
		
		$bulanLast  = $this->Bulan_model->get_last_bank($param);
		$freeLast   = $this->Bebas_pay_model->get_last_bank($param);
		$kreditLast = $this->Kredit_model->get_last_bank($param);
		$gajiLast = $this->Kredit_model->gaji_last_bank($param);
		$debitLast  = $this->Debit_model->get_last_bank($param);
		//$data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
		
		$sumBulanLast = 0;
		foreach($bulanLast as $row){
		    $sumBulanLast += $row['bulan_bill'];
		}
		$sumFreeLast = 0;
		foreach($freeLast as $row){
		    $sumFreeLast += $row['bebas_pay_bill'];
		}
		$sumKreditLast = 0;
		foreach($kreditLast as $row){
		    $sumKreditLast += $row['kredit_value'];
		}
		$sumGajiLast = 0;
		foreach($gajiLast as $row){
		    $sumGajiLast += $row['kredit_value'];
		}
		$sumDebitLast = 0;
		foreach($debitLast as $row){
		    $sumDebitLast += $row['debit_value'];
		}
		
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
    					    } $sumGaji = 0;
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
    				                <td>'.'Rp '.number_format($saldoAwal['nominal']+$sumLastA-$sumLastB,0,",",".").'</td>
    				                <td> - </td>
    						    </tr>';
    						echo '<tr style="background-color: #FFFCBE;">
    				                <td colspan = "6" align = "right"><strong>Total (Sub Total + Saldo Awal)</strong></td>
    				                <td>'.'Rp '.number_format($saldoAwal['nominal']+$sumLastA+$sumA,0,",",".").'</td>
    				                <td>'.'Rp '.number_format($sumLastB+$sumB,0,",",".").'</td>
    						    </tr>';
    						echo '<tr style="background-color: #c2d2f6;">
    				                <td colspan = "6" align = "right"><strong>Saldo Akhir</strong></td>
    				                <td>'.'Rp '.number_format(($saldoAwal['nominal']+$sumLastA+$sumA)-($sumLastB+$sumB),0,",",".").'</td>
    				                <td> - </td>
    						    </tr>';
    				echo '</table>
    					</div>
    					<div class="box-footer">
    					<table class="table">
        			        <tr>
        					    <td>
                					<div class="md-6">
                					    <a class="btn btn-danger" target="_blank" href="'.base_url().'manage/report/cetak_detail_bank/'.$ds.'/'.$de.'/'.$period_id.'/'.$majors_id.'"><span class="fa fa-file-pdf-o"></span> PDF Per Jenis Anggaran
                					    </a>
                					    <a class="btn btn-success" target="_blank" href="'.base_url().'manage/report/excel_detail_bank/'.$ds.'/'.$de.'/'.$period_id.'/'.$majors_id.'"><span class="fa fa-file-excel-o"></span> Excel Per Jenis Anggaran
                					    </a>
                					</div>
        					    </td>
        					    <td>
        					        <div class="pull-right">
                					    <a class="btn btn-danger" target="_blank" href="'.base_url().'manage/report/cetak_rekap_bank/'.$ds.'/'.$de.'/'.$period_id.'/'.$majors_id.'"><span class="fa fa-file-pdf-o"></span> PDF Rekap Laporan
                					    </a>
                					    <a class="btn btn-success" target="_blank" href="'.base_url().'manage/report/excel_rekap_bank/'.$ds.'/'.$de.'/'.$period_id.'/'.$majors_id.'"><span class="fa fa-file-excel-o"></span> Excel Rekap Laporan
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
	
	public function cetak_detail_jurnal(){
	    ob_start();
		
	    $ds         = $this->uri->segment('4');
		$de         = $this->uri->segment('5');
		//$period_id  = $this->uri->segment('6');
		$majors_id  = $this->uri->segment('6');
		$createDS   = date_create($ds);
		$createDE   = date_create($de);
		$start      = date_format($createDS,"n");
		$end        = date_format($createDE,"n");
		
        $data['dataPeriod']       = $this->db->query("SELECT * FROM period WHERE period_id = '$period_id'")->row_array();
		
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
		
// 		if (isset($period_id) && !empty($period_id) && $period_id != '') {
// 			$params['period_id'] = $period_id;
// 			$param['period_id'] = $period_id;
// 		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			
			$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Tunai%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
    		$params['kas_noref'] = 'isi';
    		$param['kas_noref'] = 'isi';
    		
    		$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Tunai%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		}
        
		$params['urutan'] = "ada";
		$params['status'] = 1;
		$param['status'] = 1;

		$data['bulan']  = $this->Report_model->get_rekap_bulan_kas($params);
		$data['free']   = $this->Report_model->get_rekap_bebas_kas($params);
		$data['kredit'] = $this->Report_model->get_rekap_kredit_kas($params);
		$data['gaji']   = $this->Report_model->get_rekap_gaji_kas($params);
		$data['debit']  = $this->Report_model->get_rekap_debit_kas($params);
		
		$data['bulanLast']  = $this->Report_model->get_rekap_bulan_last_kas($param);
		$data['freeLast']   = $this->Report_model->get_rekap_bebas_last_kas($param);
		$data['kreditLast'] = $this->Report_model->get_rekap_kredit_last_kas($param);
		$data['gajiLast']   = $this->Report_model->get_rekap_gaji_last_kas($param);
		$data['debitLast']  = $this->Report_model->get_rekap_debit_last_kas($param);
		
		$data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
        $filename = 'Laporan Per Jenis Anggaran Kas Tunai per Tanggal '.pretty_date($ds, 'd/m/Y', FALSE).' Sampai '.pretty_date($de, 'd/m/Y', FALSE).'.pdf';
        
        $this->load->view('report/cetak_detail_jurnal',$data);
        
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
	
	public function excel_detail_jurnal(){
	    $ds         = $this->uri->segment('4');
		$de         = $this->uri->segment('5');
		//$period_id  = $this->uri->segment('6');
		$majors_id  = $this->uri->segment('6');
		$createDS   = date_create($ds);
		$createDE   = date_create($de);
		$start      = date_format($createDS,"n");
		$end        = date_format($createDE,"n");
		
        $data['dataPeriod']       = $this->db->query("SELECT * FROM period WHERE period_id = '$period_id'")->row_array();
		
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
		
// 		if (isset($period_id) && !empty($period_id) && $period_id != '') {
// 			$params['period_id'] = $period_id;
// 			$param['period_id'] = $period_id;
// 		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			
			$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Tunai%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
    		$params['kas_noref'] = 'isi';
    		$param['kas_noref'] = 'isi';
    		
    		$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Tunai%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		}
        
		$params['urutan'] = "ada";
		$params['status'] = 1;
		$param['status'] = 1;

		$data['bulan']  = $this->Report_model->get_rekap_bulan_kas($params);
		$data['free']   = $this->Report_model->get_rekap_bebas_kas($params);
		$data['kredit'] = $this->Report_model->get_rekap_kredit_kas($params);
		$data['gaji']   = $this->Report_model->get_rekap_gaji_kas($params);
		$data['debit']  = $this->Report_model->get_rekap_debit_kas($params);
		
		$data['bulanLast']  = $this->Report_model->get_rekap_bulan_last_kas($param);
		$data['freeLast']   = $this->Report_model->get_rekap_bebas_last_kas($param);
		$data['kreditLast'] = $this->Report_model->get_rekap_kredit_last_kas($param);
		$data['gajiLast'] = $this->Report_model->get_rekap_gaji_last_kas($param);
		$data['debitLast']  = $this->Report_model->get_rekap_debit_last_kas($param);
		
		$data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
        $this->load->view('report/excel_detail_jurnal',$data);
	}
	
	public function cetak_rekap_jurnal(){
        ob_start();
		
	    $ds         = $this->uri->segment('4');
		$de         = $this->uri->segment('5');
		$majors_id  = $this->uri->segment('6');
		$createDS   = date_create($ds);
		$createDE   = date_create($de);
		$start      = date_format($createDS,"n");
		$end        = date_format($createDE,"n");
		
        //$data['dataPeriod']       = $this->db->query("SELECT * FROM period WHERE period_id = '$period_id'")->row_array();
		
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
		
// 		if (isset($period_id) && !empty($period_id) && $period_id != '') {
// 			$params['period_id'] = $period_id;
// 			$param['period_id'] = $period_id;
// 		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			
			$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Tunai%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
			
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
    		$params['kas_noref'] = 'isi';
    		$param['kas_noref'] = 'isi';
    		
    		$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Tunai%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		}
        
		$params['urutan'] = "ada";
		$params['status'] = 1;
		$param['status'] = 1;

		$data['bulan']  = $this->Report_model->get_rekap_bulan_kas($params);
		$data['free']   = $this->Report_model->get_rekap_bebas_kas($params);
		$data['kredit'] = $this->Report_model->get_rekap_kredit_kas($params);
		$data['gaji']  = $this->Report_model->get_rekap_gaji_kas($params);
		$data['debit']  = $this->Report_model->get_rekap_debit_kas($params);
		
		$data['bulanLast']  = $this->Report_model->get_rekap_bulan_last_kas($param);
		$data['freeLast']   = $this->Report_model->get_rekap_bebas_last_kas($param);
		$data['kreditLast'] = $this->Report_model->get_rekap_kredit_last_kas($param);
		$data['gajiLast']  = $this->Report_model->get_rekap_gaji_last_kas($param);
		$data['debitLast']  = $this->Report_model->get_rekap_debit_last_kas($param);
		
		$data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
        $filename = 'Rekap Laporan Kas Tunai per Tanggal '.pretty_date($ds, 'd/m/Y', FALSE).' Sampai '.pretty_date($de, 'd/m/Y', FALSE).'.pdf';
        
        $this->load->view('report/cetak_rekap_jurnal',$data);
        
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
	
	public function excel_rekap_jurnal(){
	    
	    $ds         = $this->uri->segment('4');
		$de         = $this->uri->segment('5');
		$majors_id  = $this->uri->segment('6');
		$createDS   = date_create($ds);
		$createDE   = date_create($de);
		$start      = date_format($createDS,"n");
		$end        = date_format($createDE,"n");
		
        $data['dataPeriod']       = $this->db->query("SELECT * FROM period WHERE period_id = '$period_id'")->row_array();
		
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
		
// 		if (isset($period_id) && !empty($period_id) && $period_id != '') {
// 			$params['period_id'] = $period_id;
// 			$param['period_id'] = $period_id;
// 		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			
			$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Tunai%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
			
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
    		$params['kas_noref'] = 'isi';
    		$param['kas_noref'] = 'isi';
    		
    		$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Tunai%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();   
		}
        
		$params['urutan'] = "ada";
		$params['status'] = 1;
		$param['status']  = 1;

		$data['bulan']  = $this->Report_model->get_rekap_bulan_kas($params);
		$data['free']   = $this->Report_model->get_rekap_bebas_kas($params);
		$data['kredit'] = $this->Report_model->get_rekap_kredit_kas($params);
		$data['gaji']   = $this->Report_model->get_rekap_gaji_kas($params);
		$data['debit']  = $this->Report_model->get_rekap_debit_kas($params);
		
		$data['bulanLast']  = $this->Report_model->get_rekap_bulan_last_kas($param);
		$data['freeLast']   = $this->Report_model->get_rekap_bebas_last_kas($param);
		$data['kreditLast'] = $this->Report_model->get_rekap_kredit_last_kas($param);
		$data['gajiLast']   = $this->Report_model->get_rekap_gaji_last_kas($param);
		$data['debitLast']  = $this->Report_model->get_rekap_debit_last_kas($param);
		
		$data['setting_nip_bendahara']  = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city']           = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district']       = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school']         = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address']        = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone']          = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
        $this->load->view('report/excel_rekap_jurnal',$data);
	}
	
	public function cetak_detail_bank(){
	    ob_start();
		
	    $ds         = $this->uri->segment('4');
		$de         = $this->uri->segment('5');
		$period_id  = $this->uri->segment('6');
		$majors_id  = $this->uri->segment('7');
		$createDS   = date_create($ds);
		$createDE   = date_create($de);
		$start      = date_format($createDS,"n");
		$end        = date_format($createDE,"n");
		
        $data['dataPeriod']       = $this->db->query("SELECT * FROM period WHERE period_id = '$period_id'")->row_array();
		
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
		
		if (isset($period_id) && !empty($period_id) && $period_id != '') {
			$params['period_id'] = $period_id;
			$param['period_id'] = $period_id;
		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Bank%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
    		$params['kas_noref'] = 'isi';
    		$param['kas_noref'] = 'isi';
    		$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Bank%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		}
        
		$params['urutan'] = "ada";
		$params['status'] = 1;
		$param['status'] = 1;

		$data['bulan']  = $this->Report_model->get_rekap_bulan_bank($params);
		$data['free']   = $this->Report_model->get_rekap_bebas_bank($params);
		$data['kredit'] = $this->Report_model->get_rekap_kredit_bank($params);
		$data['gaji']   = $this->Report_model->get_rekap_gaji_bank($params);
		$data['debit']  = $this->Report_model->get_rekap_debit_bank($params);
		
		$data['bulanLast']  = $this->Report_model->get_rekap_bulan_last_bank($param);
		$data['freeLast']   = $this->Report_model->get_rekap_bebas_last_bank($param);
		$data['kreditLast'] = $this->Report_model->get_rekap_kredit_last_bank($param);
		$data['gajiLast'] = $this->Report_model->get_rekap_gaji_last_bank($param);
		$data['debitLast']  = $this->Report_model->get_rekap_debit_last_bank($param);
		
		$data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
        $filename = 'Laporan Per Jenis Anggaran Kas Bank per Tanggal '.pretty_date($ds, 'd/m/Y', FALSE).' Sampai '.pretty_date($de, 'd/m/Y', FALSE).'.pdf';
        
        $this->load->view('report/cetak_detail_bank',$data);
        
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
	
	public function excel_detail_bank(){
	    $ds         = $this->uri->segment('4');
		$de         = $this->uri->segment('5');
		$period_id  = $this->uri->segment('6');
		$majors_id  = $this->uri->segment('7');
		$createDS   = date_create($ds);
		$createDE   = date_create($de);
		$start      = date_format($createDS,"n");
		$end        = date_format($createDE,"n");
		
        $data['dataPeriod']       = $this->db->query("SELECT * FROM period WHERE period_id = '$period_id'")->row_array();
		
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
		
		if (isset($period_id) && !empty($period_id) && $period_id != '') {
			$params['period_id'] = $period_id;
			$param['period_id'] = $period_id;
		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Bank%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
    		$params['kas_noref'] = 'isi';
    		$param['kas_noref'] = 'isi';
    		$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Bank%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		}
        
		$params['urutan'] = "ada";
		$params['status'] = 1;
		$param['status'] = 1;

		$data['bulan']  = $this->Report_model->get_rekap_bulan_bank($params);
		$data['free']   = $this->Report_model->get_rekap_bebas_bank($params);
		$data['kredit'] = $this->Report_model->get_rekap_kredit_bank($params);
		$data['gaji']   = $this->Report_model->get_rekap_gaji_bank($params);
		$data['debit']  = $this->Report_model->get_rekap_debit_bank($params);
		
		$data['bulanLast']  = $this->Report_model->get_rekap_bulan_last_bank($param);
		$data['freeLast']   = $this->Report_model->get_rekap_bebas_last_bank($param);
		$data['kreditLast'] = $this->Report_model->get_rekap_kredit_last_bank($param);
		$data['gajiLast']   = $this->Report_model->get_rekap_gaji_last_bank($param);
		$data['debitLast']  = $this->Report_model->get_rekap_debit_last_bank($param);
		
		$data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
        $this->load->view('report/excel_detail_bank',$data);
	}
	
	public function cetak_rekap_bank(){
        ob_start();
		
	    $ds         = $this->uri->segment('4');
		$de         = $this->uri->segment('5');
		$period_id  = $this->uri->segment('6');
		$majors_id  = $this->uri->segment('7');
		$createDS   = date_create($ds);
		$createDE   = date_create($de);
		$start      = date_format($createDS,"n");
		$end        = date_format($createDE,"n");
		
        $data['dataPeriod']       = $this->db->query("SELECT * FROM period WHERE period_id = '$period_id'")->row_array();
		
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
		
		if (isset($period_id) && !empty($period_id) && $period_id != '') {
			$params['period_id'] = $period_id;
			$param['period_id'] = $period_id;
		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Bank%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
    		$params['kas_noref'] = 'isi';
    		$param['kas_noref'] = 'isi';
    		$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Bank%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		}
        
		$params['urutan'] = "ada";
		$params['status'] = 1;
		$param['status'] = 1;

		$data['bulan']  = $this->Report_model->get_rekap_bulan_bank($params);
		$data['free']   = $this->Report_model->get_rekap_bebas_bank($params);
		$data['kredit'] = $this->Report_model->get_rekap_kredit_bank($params);
		$data['gaji']  = $this->Report_model->get_rekap_gaji_bank($params);
		$data['debit']  = $this->Report_model->get_rekap_debit_bank($params);
		
		$data['bulanLast']  = $this->Report_model->get_rekap_bulan_last_bank($param);
		$data['freeLast']   = $this->Report_model->get_rekap_bebas_last_bank($param);
		$data['kreditLast'] = $this->Report_model->get_rekap_kredit_last_bank($param);
		$data['gajiLast']  = $this->Report_model->get_rekap_gaji_last_bank($param);
		$data['debitLast']  = $this->Report_model->get_rekap_debit_last_bank($param);
		
		$data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
        $filename = 'Rekap Laporan Kas Bank per Tanggal '.pretty_date($ds, 'd/m/Y', FALSE).' Sampai '.pretty_date($de, 'd/m/Y', FALSE).'.pdf';
        
        $this->load->view('report/cetak_rekap_bank',$data);
        
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
	
	public function excel_rekap_bank(){
	    
	    $ds         = $this->uri->segment('4');
		$de         = $this->uri->segment('5');
		$period_id  = $this->uri->segment('6');
		$majors_id  = $this->uri->segment('7');
		$createDS   = date_create($ds);
		$createDE   = date_create($de);
		$start      = date_format($createDS,"n");
		$end        = date_format($createDE,"n");
		
        $data['dataPeriod']       = $this->db->query("SELECT * FROM period WHERE period_id = '$period_id'")->row_array();
		
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
		
		if (isset($period_id) && !empty($period_id) && $period_id != '') {
			$params['period_id'] = $period_id;
			$param['period_id'] = $period_id;
		}
		
		if (isset($majors_id) && !empty($majors_id) && $majors_id != 'all') {
			$params['account_majors_id'] = $majors_id;
			$param['account_majors_id'] = $majors_id;
			$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Bank%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_majors_id = '$majors_id' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		} else if (isset($majors_id) && !empty($majors_id) && $majors_id == 'all') {
    		$params['kas_noref'] = 'isi';
    		$param['kas_noref'] = 'isi';
    		$data['saldoAwal'] = $this->db->query("SELECT SUM(saldo_awal.saldo_awal_debit) AS nominal FROM `saldo_awal` JOIN account ON saldo_awal.saldo_awal_account =account.account_id WHERE account.account_category = '2' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Bank%' AND account.account_note IN (SELECT account_id FROM account WHERE account.account_category = '0' AND account.account_code LIKE '1%' AND account.account_description LIKE '%Aktiva%')")->row_array();
		}
        
		$params['urutan'] = "ada";
		$params['status'] = 1;
		$param['status'] = 1;

		$data['bulan']  = $this->Report_model->get_rekap_bulan_bank($params);
		$data['free']   = $this->Report_model->get_rekap_bebas_bank($params);
		$data['kredit'] = $this->Report_model->get_rekap_kredit_bank($params);
		$data['gaji']  = $this->Report_model->get_rekap_gaji_bank($params);
		$data['debit']  = $this->Report_model->get_rekap_debit_bank($params);
		
		$data['bulanLast']  = $this->Report_model->get_rekap_bulan_last_bank($param);
		$data['freeLast']   = $this->Report_model->get_rekap_bebas_last_bank($param);
		$data['kreditLast'] = $this->Report_model->get_rekap_kredit_last_bank($param);
		$data['gajiLast']  = $this->Report_model->get_rekap_gaji_last_bank($param);
		$data['debitLast']  = $this->Report_model->get_rekap_debit_last_bank($param);
		
		$data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
        
        $this->load->view('report/excel_rekap_bank',$data);
	}

    public function search_report_tagihan(){
        $id_periode     = $this->input->post('id_periode');
        $id_tagihan     = $this->input->post('id_tagihan');
        $id_majors      = $this->input->post('id_majors');
        $id_kelas       = $this->input->post('id_kelas');
        $ds             = $this->input->post('ds');
		$de             = $this->input->post('de');
		$createDS       = date_create($ds);
		$createDE       = date_create($de);
		$start          = date_format($createDS,"n");
		$end            = date_format($createDE,"n");
		
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

		//$data['q'] = $q;

		$params = array();

        // Date start
		if (isset($ds) && !empty($ds) && $ds != '') {
			$params['month_start'] = $monthStart;
		}

        // Date end
		if (isset($de) && !empty($de) && $de != '') {
			$params['month_end'] = $monthEnd;
		}
		
		$params['payment_id']   = $id_tagihan;
		
		if($id_kelas != '0'){
		    $params['class_id']     = $id_kelas;
		}
		$params['status']       = 0;

		$bulan  = $this->Bulan_model->get_report_tagihan($params);
		
		echo '<div class="box box-primary box-solid">
            		    <div class="box-header with-border">
            			  <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Tagihan Bulan '.pretty_date($ds, 'F', FALSE).' Sampai '.pretty_date($de, 'F', FALSE).'</h3>
            			</div>
            			<div class="box-body table-responsive">
            			<table id="dtable" class="table table-responsive table-hover table-bordered" style="white-space: nowrap;">
            			        <thead>
        							<tr>
        							    <th>No.</th>
        								<th>NIS</th>
        								<th>Nama Siswa</th>
        							    <th>Pembayaran</th>
        							    <th>Tagihan</th>
        						    </tr>
    						    </thead><tbody>';
    						    $no = 1;
    					    foreach ($bulan as $row) {
    				        echo '<tr>
    				                <td>'.$no++.'</td>
    				                <td>'.$row['student_nis'].'</td>
    				                <td>'.$row['student_full_name'].'</td>
    				                <td>'.$row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'].'-'.$row['month_name'].'</td>
    				                <td>'.'Rp '.number_format($row['bulan_bill'],0,",",".").'</td>
    						    </tr>';
    					    }
    				echo '</tbody></table>
    					</div>
    					<div class="box-footer">
    					</div>
    					</div>
    				</div>';
    				
    				echo "
    				    <script>
                            $(document).ready(function(){
                            	$('#dtable').DataTable();
                            });
                        </script>
    				    ";
	}

	public function report()
	{
        // Apply Filter
        // Get $_GET variable
		$q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$params = array();

        // Date start
		if (isset($q['ds']) && !empty($q['ds']) && $q['ds'] != '') {
			$params['date_start'] = $q['ds'];
		}

        // Date end
		if (isset($q['de']) && !empty($q['de']) && $q['de'] != '') {
			$params['date_end'] = $q['de'];
		}

		$params['status'] = 1;


		$data['bulan'] = $this->Bulan_model->get($params);
		$data['bebas'] = $this->Bebas_model->get($params);
		$data['free'] = $this->Bebas_pay_model->get($params);
		$data['kredit'] = $this->Kredit_model->get($params);
		$data['debit'] = $this->Debit_model->get($params);
		$data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));

		$this->load->library("PHPExcel");
		$objXLS   = new PHPExcel();
		$objSheet = $objXLS->setActiveSheetIndex(0);            
		$cell     = 6;        
		$no       = 1;

		$objSheet->setCellValue('A1', 'Laporan Keuangan');
		$objSheet->setCellValue('A2', $data['setting_school']['setting_value'] );
		$objSheet->setCellValue('A3', 'Tanggal Laporan: '.pretty_date($q['ds'],'d F Y',false).' Sampai '.pretty_date($q['de'],'d F Y',false));
		$objSheet->setCellValue('A4', 'Tanggal Unduh: '.pretty_date(date('Y-m-d h:i:s'),'d F Y, H:i',false));
		$objSheet->setCellValue('C4', 'Pengunduh: '.$this->session->userdata('ufullname'));
		

		$objSheet->setCellValue('A5', 'NO');
		$objSheet->setCellValue('B5', 'PEMBAYARAN');
		$objSheet->setCellValue('C5', 'NAMA SISWA');
		$objSheet->setCellValue('D5', 'KELAS');
		$objSheet->setCellValue('E5', 'TANGGAL');
		$objSheet->setCellValue('F5', 'PENERIMAAN');
		$objSheet->setCellValue('G5', 'PENGELUARAN');     
		$objSheet->setCellValue('H5', 'KETERANGAN');     


		foreach ($data['bulan'] as $row) {

			$objSheet->setCellValue('A'.$cell, $no);
			$objSheet->setCellValueExplicit('B'.$cell, $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'].'-'.$row['month_name'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValueExplicit('C'.$cell, $row['student_full_name'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValueExplicit('D'.$cell, $row['class_name'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValue('E'.$cell, pretty_date($row['bulan_date_pay'], 'd/m/Y', FALSE));
			$objSheet->setCellValue('F'.$cell, $row['bulan_bill']);
			$objSheet->setCellValue('G'.$cell, ' ');
			$cell++;
			$no++;    
		}

		foreach ($data['free'] as $row) {

			$objSheet->setCellValue('A'.$cell, $no);
			$objSheet->setCellValueExplicit('B'.$cell, $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValueExplicit('C'.$cell, $row['student_full_name'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValueExplicit('D'.$cell, $row['class_name'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValue('E'.$cell, pretty_date($row['bebas_pay_input_date'], 'd/m/Y', FALSE));
			$objSheet->setCellValue('F'.$cell, $row['bebas_pay_bill']);
			$objSheet->setCellValue('G'.$cell, ' ');
			$cell++;
			$no++;    
		}

		foreach ($data['kredit'] as $row) {

			$objSheet->setCellValue('A'.$cell, $no);
			$objSheet->setCellValueExplicit('B'.$cell, $row['kredit_desc'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValue('C'.$cell, '-');
			$objSheet->setCellValue('D'.$cell, '-');
			$objSheet->setCellValue('E'.$cell, pretty_date($row['kredit_date'], 'd/m/Y', FALSE));
			$objSheet->setCellValue('F'.$cell, '');
			$objSheet->setCellValue('G'.$cell, $row['kredit_value']);
			$cell++;
			$no++;    
		}

		foreach ($data['debit'] as $row) {

			$objSheet->setCellValue('A'.$cell, $no);
			$objSheet->setCellValueExplicit('B'.$cell, $row['debit_desc'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValue('C'.$cell, '-');
			$objSheet->setCellValue('D'.$cell, '-');
			$objSheet->setCellValue('E'.$cell, pretty_date($row['debit_date'], 'd/m/Y', FALSE));
			$objSheet->setCellValue('F'.$cell, $row['debit_value']);
			$objSheet->setCellValue('G'.$cell, '');
			$cell++;
			$no++;    
		}                      

		$objXLS->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objXLS->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$objXLS->getActiveSheet()->getColumnDimension('C')->setWidth(20);

		foreach(range('D', 'Z') as $alphabet)
		{
			$objXLS->getActiveSheet()->getColumnDimension($alphabet)->setWidth(20);
		}

		$objXLS->getActiveSheet()->getColumnDimension('N')->setWidth(20);

		$font = array('font' => array( 'bold' => true, 'color' => array(
			'rgb'  => 'FFFFFF')));
		$objXLS->getActiveSheet()
		->getStyle('A5:H5')
		->applyFromArray($font);

		$objXLS->getActiveSheet()
		->getStyle('A5:H5')
		->getFill()
		->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()
		->setRGB('000');
		$objXLS->getActiveSheet()->getStyle('A1')->getFont()->setBold( true );
		$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5'); 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="LAPORAN_KEUANGAN_'.date('dmY').'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter->save('php://output'); 
		exit();      
	}


// Rekapituliasi
	public function report_bill_detail()
	{
		$q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$params     = array();
		$param      = array();
		$stu        = array();
		$free       = array();
		$bul        = 'BULAN';
        $id_kelas   = $q['c'];
        $id_periode = $q['p'];
        
        
		if (isset($q['p']) && !empty($q['p']) && $q['p'] != '') {
			$params['period_id'] = $q['p'];
			$param['period_id'] = $q['p'];
			$stu['period_id'] = $q['p'];
			$free['period_id'] = $q['p'];
			$data['looping'] = $this->Bulan_model->get_jumlah($q['c']);
		}

		if (isset($q['c']) && !empty($q['c']) && $q['c'] != '') {
			$params['class_id'] = $q['c'];
			$param['class_id'] = $q['c'];
			$stu['class_id'] = $q['c'];
			$free['class_id'] = $q['c'];
			$data['looping'] = $this->Bulan_model->get_jumlah($q['c']);
		}

		if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
			$params['majors_id'] = $q['k'];
			$param['majors_id'] = $q['k'];
			$stu['majors_id'] = $q['k'];
			$free['majors_id'] = $q['k'];
			$data['looping'] = $this->Bulan_model->get_jumlah($q['c']);
		}
		
        $data['dataKelas']  = $this->db->query("SELECT class_name FROM class WHERE class_id='$id_kelas'")->row();
        $data['dataHead']   = $this->db->query("SELECT * FROM period WHERE period_id = '$id_periode'")->row();

		$param['paymentt'] = TRUE;
		$params['grup'] = TRUE;
		$stu['group'] = TRUE;

        
		$data['period'] = $this->Period_model->get($params);
		$data['class'] = $this->Student_model->get_class($params);
		$data['majors'] = $this->Student_model->get_majors($params);
		$data['student'] = $this->Bulan_model->get($stu);
		$data['bulan'] = $this->Bulan_model->get($free);
		$data['month'] = $this->Bulan_model->get($params);
		$data['py'] = $this->Bulan_model->get($param);
		$data['bebas'] = $this->Bebas_model->get($params);
		$data['free'] = $this->Bebas_model->get($free);
		
		$data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 

		$config['suffix'] = '?' . http_build_query($_GET, '', "&");

		$this->load->view('report/report_bill_excel', $data);
	}

}

/* End of file Report_set.php */
/* Location: ./application/modules/report/controllers/Report_set.php */