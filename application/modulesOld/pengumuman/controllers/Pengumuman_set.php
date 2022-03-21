<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengumuman_set extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('setting/Setting_model', 'student/Student_model'));
        $this->load->library('upload');
    }

    // pos view in list
    

    // pos view in list
    public function index($offset = NULL) {
        $q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$params = array();
		
		if (isset($q['c']) && !empty($q['c']) && $q['c'] != '') {
			$params['class_id']  = $q['c'];
		}

		if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
			$params['majors_id'] = $q['k'];
		}
		$data['class']      = $this->Student_model->get_class($params);
		$data['majors']     = $this->Student_model->get_majors($params);
		$data['student']    = $this->Student_model->get($params);
        
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
        
        $data['title'] = 'Kirim Pengumuman Siswa';
        $data['main'] = 'pengumuman/pengumuman_send_list';
        $this->load->view('manage/layout', $data);
    }
    
    function class_searching(){
	    $id_majors = $this->input->post('id_majors');
        $dataKelas  = $this->db->query("SELECT * FROM class WHERE majors_majors_id = '$id_majors' ORDER BY class_name ASC")->result_array();
    
        echo '<div class="col-md-2">  
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

    function get_form(){
      
        for($count = 0; $count < count($_POST["student_id"]); $count++)
        {
            $student = $this->db->query("SELECT student_id
                                        FROM student
                                        WHERE student_id IN (".$_POST['student_id'][$count].")")->result_array();
        
            foreach($student as $row){
    		    echo '<input type="hidden" name="student_id[]" id="student_id" value="'.$row['student_id'].'">';
    	    }
        }
        
        echo '<div class="form-group">
                <label>Pengumuman (wajib diisi)</label>
				<textarea class="form-control" name="pengumuman" placeholder="Masukkan Pengumuman" required></textarea>
                <label >Gambar (tidak harus diisi)</label>
				<input type="file" id="pengumuman_img" name="pengumuman_img">
			    </div>';
    }
    
    public function blast(){
        if ($_POST == TRUE) {
            
            $gambar         = NULL;
            $student_id     = $_POST['student_id'];
            $kode_sekolah   = $_POST['kode_sekolah'];
            $pengumuman     = $_POST['pengumuman'];
            
            $pengumuman = str_replace('(kode pesantren)', $kode_sekolah, $pengumuman);
            
            if (!empty($_FILES['pengumuman_img']['name'])) {
                $gambar = $this->do_upload($name = 'pengumuman_img', $fileName= base64_encode(substr($pengumuman,0,5)));
            } 
            
            $wa_center      = $this->Setting_model->get(array('id' => 17));
            
            $cpt = count($_POST['student_id']);
            for ($i = 0; $i < $cpt; $i++) {
            
            $params['student_id']   = $student_id[$i];
            
            $siswa = $this->db->query("SELECT student_id, student_full_name, student_nis, student_parent_phone FROM student WHERE student.student_id = '$student_id[$i]'")->row_array();
            
            if(isset($siswa['student_parent_phone']) AND $siswa['student_parent_phone'] != '+62'){
                
        	    $no_wa = $siswa['student_parent_phone'];
        	    $pengumuman = str_replace('(nis santri)', $siswa['student_nis'], $pengumuman);
    		    //$no_wa='+6281233640003';
    			
                $info_wa = "\n\n" . 'Untuk Informasi hubungi No. WA Pesantren : http://wa.me/' . $wa_center['setting_value'] . "\n\n" . 'NB : Jika link tidak aktif silahkan simpan No. HP ini terlebih dahulu.';
    			$pesan = $pengumuman . $info_wa;
            
                $key1='93f92c81ba61d09610e18a5cd0504d25ee308318f9dbc967'; //decareptil
                
                if (!empty($gambar)) {
                    $url='http://116.203.92.59/api/send_image_url';
                    $img_url = 'https://demo.adminsekolah.net/uploads/pengumuman/'.$gambar;
                    $data = array(
                	  "phone_no"    =>	$no_wa,
                	  "key"		    =>	$key1,
                      "url"		    =>  $img_url,
                	  "message"	    =>	$pesan
                	);          
                } else {
                    $url='http://116.203.92.59/api/send_message';
                    $data = array(
                	  "phone_no"    =>	$no_wa,
                	  "key"		    =>	$key1,
                	  "message"	    =>	$pesan
                	);
                }
                
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
            
            
            $this->session->set_flashdata('success',' Kirim Pengumuman Siswa Berhasil');
            redirect('manage/pengumuman');
        }
    }
    
    function do_upload($name=NULL, $fileName=NULL) {
    $this->load->library('upload');

    $config['upload_path'] = FCPATH . 'uploads/pengumuman/';

    /* create directory if not exist */
    if (!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }

    $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
    $config['max_size'] = '10240';
    $config['file_name'] = $fileName;
    $this->upload->initialize($config);

    if (!$this->upload->do_upload($name)) {
      $this->session->set_flashdata('success', $this->upload->display_errors('', ''));
      redirect(uri_string());
    }

    $upload_data = $this->upload->data();

    return $upload_data['file_name'];
  }
	
}