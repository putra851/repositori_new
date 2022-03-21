<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggajian_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('employees/Employees_model', 'setting/Setting_model', 'period/Period_model', 'bulan/Bulan_model', 'employees/Employees_detail_model', 'position/Position_model', 'penggajian/Penggajian_model', 'student/Student_model'));
    $this->load->helper(array('form', 'url'));
  }

  public function index($offset = NULL) {
    $this->load->library('pagination');
    
    $f = $this->input->get(NULL, TRUE);
    $s = $this->input->get(NULL, TRUE);

    $data['f'] = $f;
    $data['s'] = $s;

    $params = array();
    $param = array();
    
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['employee_search'] = $f['n'];
    } 
    
    if (isset($s['m']) && !empty($s['m']) && $s['m'] != '') {
      $param['majors_id'] = $s['m'];
    }
    $data['employee'] = $this->Penggajian_model->get($params);
    $data['majors'] = $this->Student_model->get_majors();
    $data['position'] = $this->Position_model->get();

    $config['base_url'] = site_url('manage/student/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");

    $data['title'] = 'Penggajian';
    $data['main'] = 'penggajian/penggajian_list';
    $this->load->view('manage/layout', $data);
  }
  
  function searching_position(){
	    $id_majors = $this->input->post('id_majors');
        $dataPosition  = $this->db->query("SELECT * FROM position WHERE position_majors_id = '$id_majors' ORDER BY position_name ASC")->result_array();
    
        echo '<select style="width: 200px;" id="p" name="p" class="form-control" required>
    			<option value="">--- Pilih Jabatan ---</option>
    			<option value="all">Semua Jabatan</option>';
              foreach($dataPosition as $row){ 

                echo '<option value="'.$row['position_id'].'">';
                    
                echo $row['position_name'];
                    
                echo '</option>';
            
                }
        echo '</select>';
	}
  
  function get_position(){
        $id_majors   = $this->input->post('id_majors');
        $dataPosition  = $this->db->query("SELECT * FROM position WHERE position_majors_id = '$id_majors' ORDER BY position_name ASC")->result_array();
    
        echo '<div class="form-group"> 
			<label >Jabatan *</label>
            <select name="employee_position_id" id="employee_position_id" class="form-control">
				<option value=""> -- Pilih Jabatan -- </option>';
                      foreach($dataPosition as $row){ 
        
                        echo '<option value="'.$row['position_id'].'">';
                            
                        echo $row['position_name'];
                            
                        echo '</option>';
                    
                        }
                                        
        echo '</select>
            </div>';
  }
  
  function details($id){
      
  }

    // Add User and Update
  public function set($id = NULL) {

    $data['operation'] = is_null($id) ? 'Setting' : 'Setting';

    if ($_POST) {

      if ($this->input->post('employee_id')) {
        $params['employee_id'] = $id;
      }
      
      $params['account_id']         = $this->input->post('gaji_account_id');
      $params['premier_pokok']      = $this->input->post('premier_pokok');
      $params['premier_lain']       = $this->input->post('premier_lain');
      
      $params['potongan_simpanan']  = $this->input->post('potongan_simpanan');
      $params['potongan_bpjstk']    = $this->input->post('potongan_bpjstk');
      $params['potongan_sumbangan'] = $this->input->post('potongan_sumbangan');
      $params['potongan_koperasi']  = $this->input->post('potongan_koperasi');
      $params['potongan_bpjs']      = $this->input->post('potongan_bpjs');
      $params['potongan_pinjaman']  = $this->input->post('potongan_pinjaman');
      $params['potongan_lain']      = $this->input->post('potongan_lain');
      
      $status_akun      = $this->Penggajian_model->set_akun($params);
      $status_premier   = $this->Penggajian_model->set_premier($params);
      $status_potongan  = $this->Penggajian_model->set_potongan($params);
        
      $paramsupdateakun['employee_id']      = $status_akun;
      $paramsupdatepremier['employee_id']   = $status_premier;
      $paramsupdatepotongan['employee_id']  = $status_potongan;
      
      $this->Penggajian_model->set_akun($paramsupdateakun);
      $this->Penggajian_model->set_premier($paramsupdatepremier);
      $this->Penggajian_model->set_potongan($paramsupdatepotongan);

    // activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Student',
          'log_action' => $data['operation'],
          'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('employee_name')
        )
      );

      $this->session->set_flashdata('success', $data['operation'] . ' Penggajian Berhasil');
      redirect('manage/penggajian');
      
    } else {
      if ($this->input->post('employee_id')) {
        redirect('manage/penggajian/set/' . $this->input->post('employee_id'));
    }

    // Edit mode
      if (!is_null($id)) {
          
        $majors_id = $this->session->userdata('umajorsid');
        if($majors_id != '0')
        {
        $data['account']    = $this->db->query("SELECT * FROM account WHERE account_category = '2' AND account_majors_id = '$majors_id' AND account_code LIKE '5%' AND account_description LIKE '%gaji%' OR account_description LIKE '%bisyarah%' ORDER BY account_code ASC")->result_array();
        } else {
        $data['account']    = $this->db->query("SELECT * FROM account WHERE account_category = '2' AND account_code LIKE '5%' AND account_description LIKE '%gaji%' OR account_description LIKE '%bisyarah%' ORDER BY account_code ASC")->result_array();
        }
        $object = $this->Penggajian_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/penggajian');
        } else {
          $data['employee'] = $object;
        }
      }
      
      $data['title'] = $data['operation'] . ' Penggajian';
      $data['main'] = 'penggajian/penggajian_setup';
      $this->load->view('manage/layout', $data);
    }
  }
  
  function report(){
	    $params = array();
		$data['period'] = $this->Period_model->get($params);
		$data['month'] = $this->Bulan_model->get_month($params);
		
		$config['base_url'] = site_url('manage/penggajian/index');
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		//$config['total_rows'] = count($this->Bulan_model->get($paramsPage));
        
        $data['majors'] = $this->Student_model->get_majors();
        
		$data['title'] = 'Laporan Gaji Guru & Karyawan';
		$data['main'] = 'penggajian/penggajian_report';
		$this->load->view('manage/layout', $data);
  }
  
  public function get_report(){
	    
		$month_id   = $this->input->post('month_id');
		$period_id  = $this->input->post('period_id');
		$majors_id  = $this->input->post('majors_id');
		
		$period     = $this->Period_model->get(array('id' => $period_id));
		$month      = $this->Bulan_model->get_month(array('id' => $month_id));
		
		$params['month_id']  = $month_id;
		$params['period_id'] = $period_id;
		
		if($majors_id != 'all'){    
		    $params['majors_id'] = $majors_id;
		}
		
		if($month['month_id']<7){
            $th = $period['period_start'];   
	    } else {
	        $th = $period['period_end'];
	    }
		
		$report     = $this->Penggajian_model->get_report($params);
		
		$school_name = $this->Setting_model->get(array('id' => 'SCHOOL_NAME'));
		
		echo '<div class="box box-primary box-solid">
            		    <div class="box-header with-border">
            			  <h4 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Gaji Guru dan Karyawan '.$school_name['setting_value'].' T.A. '.$period['period_start'].'/'.$period['period_end'].' Bulan : '.$month['month_name'].' '.$th.'</h4>
            			</div>
            			<div class="box-body table-responsive">
            			<table class="table table-responsive table-hover table-bordered" id="xtable" style="white-space: nowrap;">
            			        <thead>
    							<tr>
    								<th>No</th>
    								<th>Nama</th>
    							    <th>Jabatan</th>
    								<th>Bulan</th>
    								<th>Gaji</th>
    								<th>Simpanan Wajib & Penggajian</th>
    								<th>BPJS Tenaga Kerja</th>
    								<th>Sumbangan</th>
    								<th>Belanja Koperasi</th>
    								<th>BPJS</th>
    								<th>Pinjam</th>
    								<th>Lain-lain</th>
    								<th>Jumlah Potongan</th>
    								<th>Gaji Diterima</th>
    						    </tr>
    						    </thead>
    						    <tbody>';
    						    
    						$no             = 1;
    						$sumGaji        = 0;
    						$sumSimpanan    = 0;
    						$sumBPJSTK      = 0;
    						$sumSumbangan   = 0;
    						$sumKoperasi    = 0;
    						$sumBPJS        = 0;
    						$sumPinjaman    = 0;
    						$sumLain        = 0;
    						$sumPotongan    = 0;
    						$sumDiterima    = 0;
    						
    						
    						
    					    foreach ($report as $row) {
    					        $gaji = $row['subsatu_pokok']+$row['subsatu_lain'];
    					        
							    if($row['gaji_month_id']<7){
                                    $tahun = $row['period_start'];   
							    } else {
							        $tahun = $row['period_end'];
							    }
    				        echo '
    				              <tr>
    				                <td>'.$no++.'</td>
    				                <td>'.$row['employee_name'].'</td>
    				                <td>'.$row['position_name'].'</td>
    				                <td>'.$row['month_name'].' '.$tahun.'</td>
    				                <td>'.'Rp '.number_format($gaji, 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($row['subtiga_simpanan'], 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($row['subtiga_bpjstk'], 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($row['subtiga_sumbangan'], 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($row['subtiga_koperasi'], 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($row['subtiga_bpjs'], 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($row['subtiga_pinjaman'], 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($row['subtiga_lain'], 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($row['gaji_potongan'], 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($row['gaji_jumlah'], 0, ",", ".").'</td>
    						    </tr>';
    						    $sumGaji        += $gaji;
    						    $sumSimpanan    += $row['subtiga_simpanan'];
        						$sumBPJSTK      += $row['subtiga_bpjstk'];
        						$sumSumbangan   += $row['subtiga_sumbangan'];
        						$sumKoperasi    += $row['subtiga_koperasi'];
        						$sumBPJS        += $row['subtiga_bpjs'];
        						$sumPinjaman    += $row['subtiga_pinjaman'];
        						$sumLain        += $row['subtiga_lain'];
        						$sumPotongan    += $row['gaji_potongan'];
        						$sumDiterima    += $row['gaji_jumlah'];
    					    }
    					    echo '
    						    </tbody>
    						    <tr style="background-color: #E2F7FF;">
    				                <td align="center" colspan="3"><b>Total</b></td>
    				                <td></td>
    				                <td>'.'Rp '.number_format($sumGaji, 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($sumSimpanan, 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($sumBPJSTK, 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($sumSumbangan, 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($sumKoperasi, 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($sumBPJS, 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($sumPinjaman, 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($sumLain, 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($sumPotongan, 0, ",", ".").'</td>
    				                <td>'.'Rp '.number_format($sumDiterima, 0, ",", ".").'</td>
    						    </tr>';
    				echo '</table>
    					</div>
    					<div class="box-footer">
    					<table class="table">
        			        <tr>
        					    <td>
        					        <div class="pull-right">
                					    <a class="btn btn-danger" target="_blank" href="'.base_url().'manage/penggajian/cetak_rekap_gaji/'.$month_id.'/'.$period_id.'/'.$majors_id.'"><span class="fa fa-file-pdf-o"></span> PDF Rekap Gaji
                					    </a>
                					    <a class="btn btn-success" target="_blank" href="'.base_url().'manage/penggajian/excel_rekap_gaji/'.$month_id.'/'.$period_id.'/'.$majors_id.'"><span class="fa fa-file-excel-o"></span> Excel Rekap Gaji
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
                            	$("#xtable").DataTable();
                            });
                        </script>
    				    ';
   
	}
	
	public function cetak_rekap_gaji(){
        ob_start();
        
        $month_id            = $this->uri->segment('4');
        $period_id           = $this->uri->segment('5');
        $majors_id           = $this->uri->segment('6');
        
        $school_name = $this->Setting_model->get(array('id' => 'SCHOOL_NAME'));
        $period      = $this->Period_model->get(array('id' => $period_id));
		$month       = $this->Bulan_model->get_month(array('id' => $month_id));
		
		if($month['month_id']<7){
            $th = $period['period_start'];   
	    } else {
	        $th = $period['period_end'];
	    }
		
		$params['month_id']  = $month_id;
		$params['period_id'] = $period_id;
		
		if($majors_id != 'all'){    
		    $params['majors_id'] = $majors_id;
		}
		
		$data['period']     = $this->Period_model->get(array('id' => $period_id));
		$data['month']      = $this->Bulan_model->get_month(array('id' => $month_id));
		
		$data['report']     = $this->Penggajian_model->get_report($params);
        
        $data['setting_nip_bendahara']  = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city']           = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district']       = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school']         = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address']        = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone']          = $this->Setting_model->get(array('id' => SCHOOL_PHONE));  
    
        $filename = 'Laporan-Gaji-Guru-dan-Karyawan-'.$school_name['setting_value'].'-TA-'.$period['period_start'].'-'.$period['period_end'].'-Bulan-'.$month['month_name'].'-'.$th.'.pdf';
        $this->load->view('penggajian/penggajian_pdf', $data);
        
        $html = ob_get_contents();
        ob_end_clean();
        
        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('l','A4','en');
        $pdf->setDefaultFont('arial'); 
        $pdf->setTestTdInOnePage(false);
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->WriteHTML($html);
        $pdf->Output($filename);
    }
    
    public function excel_rekap_gaji(){
        
        $month_id            = $this->uri->segment('4');
        $period_id           = $this->uri->segment('5');
        $majors_id           = $this->uri->segment('6');
        
        $school_name = $this->Setting_model->get(array('id' => 'SCHOOL_NAME'));
        $period      = $this->Period_model->get(array('id' => $period_id));
		$month       = $this->Bulan_model->get_month(array('id' => $month_id));
		
		if($month['month_id']<7){
            $th = $period['period_start'];   
	    } else {
	        $th = $period['period_end'];
	    }
		
		$params['month_id']  = $month_id;
		$params['period_id'] = $period_id;
		
		if($majors_id != 'all'){    
		    $params['majors_id'] = $majors_id;
		}
		
		$data['period']     = $this->Period_model->get(array('id' => $period_id));
		$data['month']      = $this->Bulan_model->get_month(array('id' => $month_id));
		
		$data['report']     = $this->Penggajian_model->get_report($params);
        
        $data['setting_nip_bendahara']  = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city']           = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district']       = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school']         = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address']        = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone']          = $this->Setting_model->get(array('id' => SCHOOL_PHONE));  
    
        $this->load->view('penggajian/penggajian_excel', $data);
    }
  
}