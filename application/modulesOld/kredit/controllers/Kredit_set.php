<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kredit_set extends CI_Controller {

	public function __construct() {
		parent::__construct(TRUE);
		if ($this->session->userdata('logged') == NULL) {
			header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
		}
		$this->load->model(array('student/Student_model', 'account/Account_model', 'kredit/Kredit_model', 'tax/Tax_model', 'item/Item_model', 'kredit/Kredit_trx_model', 'logs/Logs_model'));
		$this->load->library('upload');
	}

    // kredit view in list
	public function index($offset = NULL) {
		$this->load->library('pagination');
        // Apply Filter
        // Get $_GET variable
        $f = $this->input->get(NULL, TRUE);
        $s = $this->input->get(NULL, TRUE);
        
        $data['f'] = $f;
        $data['s'] = $s;

		$params = array();
        // Nip
		if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
			$params['kredit_desc'] = $f['n'];
		}
        
        if (isset($s['m']) && !empty($s['m']) && $s['m'] != 'all') {
            $params['account_majors_id'] = $s['m'];
        } else if (isset($s['m']) && !empty($s['m']) && $s['m'] == 'all') {
            
        }

		//$paramsPage = $params;
		//$params['limit'] = 5;
		//$params['offset'] = $offset;
		$params['urutan'] = 'isset';
		$data['kredit'] = $this->Kredit_model->get($params);

		//$config['per_page'] = 5;
		//$config['uri_segment'] = 4;
		$config['base_url'] = site_url('manage/kredit/index');
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		//$config['total_rows'] = count($this->Kredit_model->get($paramsPage));
		//$this->pagination->initialize($config);
        
        $data['majors'] = $this->Student_model->get_majors();
        
        //$data['account'] = $this->db->query("SELECT * FROM account WHERE account_note = '2' AND account_category = '2'")->result_array();
        
		$data['title'] = 'Kas Keluar';
		$data['main'] = 'kredit/kredit_list';
		$this->load->view('manage/layout', $data);
	}
	
	
	public function trx() {
		$params = array();
        $params['account_category'] = '2';
		
		$data['kredit'] = $this->Kredit_model->get($params);
        $data['majors'] = $this->Student_model->get_majors();
        $data['pajak'] = $this->Tax_model->get();
        $data['item'] = $this->Item_model->get();
		$data['account'] = $this->Account_model->get($params);
        
		$data['title'] = 'Transaksi Kas Keluar';
		$data['main'] = 'kredit/kredit_trx';
		$this->load->view('manage/layout', $data);
	}
	
	public function data_trx($kas_noref){
	    $data       = $this->Kredit_trx_model->trx_list($kas_noref);
		echo json_encode($data);
	}

	function add_trx(){
        $majors_id          = $this->input->post('majors_id'); 
        $kas_noref          = $this->input->post('kas_noref'); 
        $kas_date           = $this->input->post('kas_date'); 
        $kredit_kas_account_id  = $this->input->post('kas_account_id'); 
        $kredit_account_id  = $this->input->post('kredit_account_id'); 
        $kredit_desc        = $this->input->post('kredit_desc'); 
        $kredit_value       = $this->input->post('kredit_value');
        $kredit_tax_id      = $this->input->post('kredit_tax_id');
        $kredit_item_id     = $this->input->post('kredit_item_id');
        
		$data               = $this->Kredit_trx_model->add_trx($majors_id, $kas_noref, $kredit_kas_account_id, $kas_date, $kredit_account_id, $kredit_desc, $kredit_value, $kredit_tax_id, $kredit_item_id);
		
        $this->Logs_model->add_trx(
            array(
              'ltrx_date' => date('Y-m-d H:i:s'),
              'user_id' => $this->session->userdata('uid'),
              'ltrx_module' => 'Kas Keluar',
              'ltrx_action' => 'Input Transaksi',
              'ltrx_info' => 'No. Ref:' . $kas_noref . ';Title: Input ' . $kredit_desc . ' - ' . ' nominal ' . $kredit_value,
              'ltrx_browser' => $this->agent->browser(),
              'ltrx_version' => $this->agent->version(),
              'ltrx_os'      => $this->agent->platform(),
              'ltrx_ip'      => $this->input->ip_address()
            )
        );
        
		echo json_encode($data);
	}

	function del_trx(){
		$id=$this->input->post('id');
		
		$kredit = $this->db->query("SELECT kredit_temp_noref, kredit_temp_desc, kredit_temp_value FROM kredit_temp WHERE kredit_temp_id = '$id'")->row_array();
		
		$this->Logs_model->add_trx(
            array(
              'ltrx_date'   => date('Y-m-d H:i:s'),
              'user_id'     => $this->session->userdata('uid'),
              'ltrx_module' => 'Kas Keluar',
              'ltrx_action' => 'Hapus Transaksi',
              'ltrx_info'   => 'No. Ref:' . $kredit['kredit_temp_noref'] . ';Title: Hapus ' . $kredit['kredit_temp_desc'] . ' - ' . ' nominal ' . $kredit['kredit_temp_value'],
              'ltrx_browser' => $this->agent->browser(),
              'ltrx_version' => $this->agent->version(),
              'ltrx_os'      => $this->agent->platform(),
              'ltrx_ip'      => $this->input->ip_address()
            )
        );
        
		$data=$this->Kredit_trx_model->del_trx($id);
		
		echo json_encode($data);
	}

	function cancel_trx(){ 
        $kas_noref        = $this->input->post('kas_noref');
		$data             = $this->Kredit_trx_model->cancel_trx($kas_noref);
		
		$this->Logs_model->add_trx(
            array(
              'ltrx_date'   => date('Y-m-d H:i:s'),
              'user_id'     => $this->session->userdata('uid'),
              'ltrx_module' => 'Kas Keluar',
              'ltrx_action' => 'Pembatalan Transaksi',
              'ltrx_info'   => 'No. Ref:' . $kas_noref,
              'ltrx_browser' => $this->agent->browser(),
              'ltrx_version' => $this->agent->version(),
              'ltrx_os'      => $this->agent->platform(),
              'ltrx_ip'      => $this->input->ip_address()
            )
        );
        
		echo json_encode($data);
	}
	
	function save_trx(){
	    $period = $this->db->query("SELECT period_id FROM period WHERE period_status = '1'")->row_array();
	    
	    $date = $this->input->post('kas_date');
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
	    
	    $params['kas_majors_id']    = $this->input->post('majors_id'); 
        $params['kas_noref']        = $this->input->post('kas_noref'); 
        $params['kas_date']         = $this->input->post('kas_date');
        $params['kas_month_id']     = $id_bulan; 
        $params['kas_account_id']   = $this->input->post('kas_account_id'); 
        $params['kas_note']         = $this->input->post('kas_note');
        $params['kas_kredit']         = $this->input->post('kas_value');
        $params['kas_period']       = $period['period_id'];
        $params['kas_input_date']   = date('Y-m-d');
        $params['kas_category']     = '2';
        $params['kas_user_id']      = $this->session->userdata('uid');
        
        $kas_noref        = $this->input->post('kas_noref');
		
        if (!empty($_FILES)) {
            $params['kas_reciept'] = $this->upload_reciept($name = 'kas_reciept', $fileName= $kas_noref.'_'.$kas_note);
        }
        
		$data = $this->Kredit_trx_model->save_trx($params, $kas_noref);
		
		$this->Logs_model->add_trx(
            array(
              'ltrx_date'   => date('Y-m-d H:i:s'),
              'user_id'     => $this->session->userdata('uid'),
              'ltrx_module' => 'Kas Keluar',
              'ltrx_action' => 'Simpan Transaksi',
              'ltrx_info'   => 'No. Ref:' . $kas_noref,
              'ltrx_browser' => $this->agent->browser(),
              'ltrx_version' => $this->agent->version(),
              'ltrx_os'      => $this->agent->platform(),
              'ltrx_ip'      => $this->input->ip_address()
            )
        );
		
		$this->db->query("DELETE a FROM kas a INNER JOIN kas b WHERE a.kas_id > b.kas_id AND a.kas_noref = b.kas_noref AND DATE(b.kas_input_date)=CURDATE();");
		
		echo json_encode($data);
	}
	
	function upload_reciept($name=NULL, $fileName=NULL) {
        $this->load->library('upload');

        $config['upload_path'] = FCPATH . 'uploads/kredit_reciept/';

        /* create directory if not exist */
        if (!is_dir($config['upload_path'])) {
          mkdir($config['upload_path'], 0777, TRUE);
        }
    
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '1024';
        $config['file_name'] = $fileName;
        $this->upload->initialize($config);
    
        if (!$this->upload->upload_reciept($name)) {
          $this->session->set_flashdata('success', $this->upload->display_errors('', ''));
          redirect(uri_string());
        }
    
        $upload_data = $this->upload->data();
    
        return $upload_data['file_name'];
    }
    
    function upload_tax_reciept($name=NULL, $fileName=NULL) {
        $this->load->library('upload');

        $config['upload_path'] = FCPATH . 'uploads/kredit_tax_reciept/';

        /* create directory if not exist */
        if (!is_dir($config['upload_path'])) {
          mkdir($config['upload_path'], 0777, TRUE);
        }
    
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '1024';
        $config['file_name'] = $fileName;
        $this->upload->initialize($config);
    
        if (!$this->upload->upload_tax_reciept($name)) {
          $this->session->set_flashdata('success', $this->upload->display_errors('', ''));
          redirect(uri_string());
        }
    
        $upload_data = $this->upload->data();
    
        return $upload_data['file_name'];
    }
	
	public function cari_kas(){
	    $id_majors = $this->input->post('id_majors');
	    
		$dataKas = $this->db->query("SELECT * FROM account WHERE account_category = '2' AND account_majors_id = '$id_majors' AND account_code LIKE '1%' AND account_note IN (SELECT account_id FROM account WHERE account_category = '0' AND account_majors_id = '$id_majors' AND account_code LIKE '1%' AND account_description LIKE '%Aktiva%' ORDER BY account_code ASC) ORDER BY account_code ASC")->result_array();
		
		echo '<label>Akun Kas *</label>
    			<select required="" name="kas_account_id" id="kas_account_id" class="form-control">
    			   <option value="">-Pilih Akun Kas-</option>';
    			    foreach($dataKas as $row){
    		echo '<option value="'.$row['account_id'].'">';
        			 echo $row['account_code'];
    			     echo ' - ';
    			     echo $row['account_description'];
    		 echo '</option>';
    			     }
        	echo '</select>';
	}
	
	public function cari_ref(){
	    $id_majors = $this->input->post('id_majors');
	    $majorsSN = $this->Student_model->get_majors(array('id'=>$id_majors));
	    $like   = 'JK'.$majorsSN['majors_short_name'];
		$tmp    = $this->Kredit_trx_model->get_noref($id_majors, $like);
		$noref  = 'JK'.$majorsSN['majors_short_name'].$tmp;
		
		echo '
		    <label>No. Ref *</label>
			<input type="text" required="" id="kas_noref" name="kas_noref" class="form-control" value="'.$noref.'" readonly="">
		';
	}
	
	public function cari_kode(){
	    $id_majors = $this->input->post('id_majors');
	    
	    $dataAccount = $this->db->query("SELECT * FROM account WHERE account_category = '2' AND account_majors_id = '$id_majors' AND account_code LIKE '5%' AND account_description NOT LIKE '%gaji%' AND account_description NOT LIKE '%bisyarah%' ORDER BY account_code ASC")->result_array();
	    
	    echo '<label>Kode Akun *</label>
    			<select required="" name="kredit_account_id" id="kredit_account_id" class="form-control">
    			   <option value="">-Pilih Kode Akun-</option>';
    			    foreach($dataAccount as $row){
    		echo '<option value="'.$row['account_id'].'">';
        			 echo $row['account_code'];
    			     echo ' - ';
    			     echo $row['account_description'];
    		 echo '</option>';
    			     }
        	echo '</select>';
	}
	
	public function cari_unit_pos(){
	    $id_majors = $this->input->post('id_majors');
	    $dataUnitPos = $this->Item_model->get(array('majors_id'=>$id_majors));
	    
	    echo '<div class="col-md-2">
    		    <label>Unit POS</label>
    		    <select name="kredit_item_id" id="kredit_item_id" class="form-control">
			    <option value="0">Tidak Ada</option>';
			     foreach($dataUnitPos as $row){
	    echo '<option value="'.$row['item_id'].'" >'.$row['item_name'].'</option>';
    			     } 
    	echo '</select>
    		</div>';
	}

	public function add_glob(){
		if ($_POST == TRUE) {
			$krValue = str_replace('.', '', $_POST['kredit_value']);
			$krDesc = $_POST['kredit_desc'];
			$krAccount = $_POST['kredit_account_id'];
			$cpt = count($_POST['kredit_value']);
			for ($i = 0; $i < $cpt; $i++) {
				$params['kredit_date'] = $this->input->post('kredit_date');
				$params['kredit_value'] = $krValue[$i];
				$params['kredit_desc'] = $krDesc[$i];
				$params['kredit_account_id'] = $krAccount[$i];
				$params['kredit_input_date'] = date('Y-m-d H:i:s');
				$params['kredit_last_update'] = date('Y-m-d H:i:s');
				$params['user_user_id'] = $this->session->userdata('uid');

				$this->Kredit_model->add($params);
			}
		}
		$this->session->set_flashdata('success',' Tambah Kas Keluar Berhasil');
		redirect('manage/kredit');
	}

    // Add kredit and Update
	public function add($id = NULL) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('kredit_date', 'Tanggal', 'trim|required|xss_clean');
		$this->form_validation->set_rules('kredit_value', 'Nilai', 'trim|required|xss_clean');
		$this->form_validation->set_rules('kredit_desc', 'Keterangan', 'trim|required|xss_clean');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
		$data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

		if ($_POST AND $this->form_validation->run() == TRUE) {

			if ($this->input->post('kredit_id')) {
				$params['kredit_id'] = $this->input->post('kredit_id');
			} else {
				$params['kredit_input_date'] = date('Y-m-d H:i:s');
			}
            $noref = $this->input->post('kredit_noref');
			$params['kredit_kas_noref'] = $this->input->post('kredit_noref');
			$params['kredit_date'] = $this->input->post('kredit_date');
			$params['kredit_value'] = $this->input->post('kredit_value');
			$params['kredit_desc'] = $this->input->post('kredit_desc');
			$params['kredit_account_id'] = $this->input->post('kredit_account_id');
			$params['kredit_tax_id'] = $this->input->post('kredit_tax_id');
			$params['kredit_item_id'] = $this->input->post('kredit_item_id');
			$params['kredit_last_update'] = date('Y-m-d H:i:s');
			$params['user_user_id'] = $this->session->userdata('uid');

			$status = $this->Kredit_model->add($params);
			$paramsupdate['kredit_id'] = $status;
			$this->Kredit_model->add($paramsupdate);
			
			$this->Logs_model->add_trx(
                array(
                  'ltrx_date'   => date('Y-m-d H:i:s'),
                  'user_id'     => $this->session->userdata('uid'),
                  'ltrx_module' => 'Kas Keluar',
                  'ltrx_action' => 'Edit Item',
                  'ltrx_info'   => 'No. Ref:' . $this->input->post('kredit_noref') . ';Title: Edit ' . $this->input->post('kredit_desc') . ' - ' . ' nominal ' . $this->input->post('kredit_value'),
                  'ltrx_browser' => $this->agent->browser(),
                  'ltrx_version' => $this->agent->version(),
                  'ltrx_os'      => $this->agent->platform(),
                  'ltrx_ip'      => $this->input->ip_address()
                )
            );
			
			$total = $this->db->query("SELECT SUM(kredit_value) as sumKredit FROM kredit WHERE kredit_kas_noref = '$noref'")->row_array();
			
			$this->db->query("UPDATE kas SET kas_kredit = '".$total['sumKredit']."' WHERE kas_noref = '$noref'");

			$this->session->set_flashdata('success', $data['operation'] . ' Kas Keluar berhasil');
			redirect('manage/kredit');
		} else {
			if ($this->input->post('kredit_id')) {
				redirect('manage/kredit/edit/' . $this->input->post('kredit_id'));
			}

            // Edit mode
			if (!is_null($id)) {
			    $q = $this->db->query("SELECT account_majors_id AS id FROM account JOIN kredit ON kredit.kredit_account_id = account.account_id WHERE account.account_category = '2' AND kredit.kredit_id = '$id' AND account.account_code LIKE '5%' ORDER BY account.account_code ASC")->row_array();
			    $majors_id  = $q['id'];
			    $data['m']  = $q['id'];
			    $data['majors'] = $this->Student_model->get_majors();
				$data['kredit'] = $this->Kredit_model->get(array('id' => $id));
                $data['account'] = $this->db->query("SELECT * FROM account WHERE account_category = '2' AND account_majors_id = '$majors_id' AND account_code LIKE '5%' ORDER BY account_code ASC")->result_array();
                $data['tax'] = $this->Tax_model->get();
                $data['item'] = $this->Item_model->get(array('majors_id'=>$majors_id));
			}
			$data['title'] = $data['operation'] . ' Kas Keluar';
			$data['main'] = 'kredit/kredit_add';
			$this->load->view('manage/layout', $data);
		}
	}

    // Delete to database
	public function delete($id = NULL) {
		if ($_POST) {
		    
		    $kredit = $this->db->query("SELECT kredit_kas_noref, kredit_desc, kredit_value FROM kredit WHERE kredit_id = '$id'")->row_array();
			
    		$this->Logs_model->add_trx(
                array(
                  'ltrx_date'   => date('Y-m-d H:i:s'),
                  'user_id'     => $this->session->userdata('uid'),
                  'ltrx_module' => 'Kas Keluar',
                  'ltrx_action' => 'Hapus Item',
                  'ltrx_info'   => 'No. Ref:' . $kredit['kredit_kas_noref'] . ';Title: Hapus ' . $kredit['kredit_desc'] . ' - ' . ' nominal ' . $kredit['kredit_value'],
                  'ltrx_browser' => $this->agent->browser(),
                  'ltrx_version' => $this->agent->version(),
                  'ltrx_os'      => $this->agent->platform(),
                  'ltrx_ip'      => $this->input->ip_address()
                )
            );
            
			$this->Kredit_model->delete($id);
		    $noref = $this->input->post('delNoref');
		    $gajiID = $this->input->post('delGaji');
		    
		    if($gajiID != ''){
		        $this->db->query("DELETE FROM gaji WHERE gaji_id = '$gajiID'");
		    } else {
			$total = $this->db->query("SELECT SUM(kredit_value) as sumKredit FROM kredit WHERE kredit_kas_noref = '$noref'")->row_array();
			
			$this->db->query("UPDATE kas SET kas_kredit = '".$total['sumKredit']."' WHERE kas_noref = '$noref'");
		    }
		    
		    $cek  = $this->db->query("SELECT COUNT(kredit_id) AS nums FROM kredit WHERE kredit_kas_noref = '$noref'")->row_array();
		    if($cek['nums']=='0'){
		        $this->db->query("DELETE FROM kas WHERE kas_noref = '$noref'");
		    }
            // activity log
			$this->load->model('logs/Logs_model');
			$this->Logs_model->add(
				array(
					'log_date' => date('Y-m-d H:i:s'),
					'user_id' => $this->session->userdata('uid'),
					'log_module' => 'Kas Keluar',
					'log_action' => 'Hapus',
					'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
				)
			);
			$this->session->set_flashdata('success', 'Hapus Kas Keluar berhasil');
			redirect('manage/kredit');
		} elseif (!$_POST) {
			$this->session->set_flashdata('delete', 'Delete');
			redirect('manage/kredit/edit/' . $id);
		}
	}function cetakTrx($noref) {
	    
    $this->load->helper(array('dompdf'));
    $this->load->helper(array('tanggal'));
    $this->load->helper(array('terbilang'));
    $this->load->model('student/Student_model');
    $this->load->model('setting/Setting_model');
    
    $params          = array();
    $param           = array();
    
    $params['noref'] = $noref;
    $params['group']        =   TRUE;
    $param['status']        =   1;
    
    $data['majors']     = $this->Student_model->get_majors();
    $data['unit']       = $this->Student_model->get_unit(array('status' => 1));
    $data['bcode']      = $this->Kredit_model->get_bcode($params);
    $bcode              = $this->Kredit_model->get_bcode($params);
    $data['kredit']     = $this->Kredit_model->get($params);
    $data['sumKredit']  = $this->Kredit_model->get_sum($params);
    $sumKredit          = $this->Kredit_model->get_sum($params);
    
    // endtotal
    $data['setting_nip_bendahara']  = $this->Setting_model->get(array('id' => 15));
    $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
    $data['setting_city']           = $this->Setting_model->get(array('id' => SCHOOL_CITY));
    $data['setting_district']       = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
    $data['setting_school']         = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
    $data['setting_address']        = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
    $data['setting_phone']          = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
    
    $this->barcode2($bcode['kas_noref'], '');
    $data['huruf'] = number_to_words($sumKredit['total']);
    
    $html = $this->load->view('kredit/kredit_bukti_trx', $data, TRUE);
    $data = pdf_create($html, 'Cetak_Bukti_Trx_'.$sumKredit['kredit_kas_noref'].'_'.date('Y-m-d'), TRUE, 'A4', TRUE);
    //$this->load->view('kredit/kredit_bukti_trx', $data);
  }
  
    private function barcode2($sparepart_code, $barcode_type=39, $scale=6, $fontsize=1, $thickness=30,$dpi=72) {

  $this->load->library('upload');
  $config['upload_path'] = FCPATH . 'media/barcode_transaction/';

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
    $drawing->setFilename( FCPATH .'media/barcode_transaction/'. $sparepart_code.'.png');
    // proses penyimpanan barcode hasil generate
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

    return $filename_img_barcode;

  }

}

/* End of file Jurnal_set.php */
/* Location: ./application/modules/jurnal/controllers/Jurnal_set.php */