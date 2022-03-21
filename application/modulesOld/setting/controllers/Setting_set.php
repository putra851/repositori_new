<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_set extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
    }

    public function index() {
        $this->load->model('setting/Setting_model');
        // $this->load->library('form_validation');
        // $this->form_validation->set_rules('setting_school', 'Nama Sekolah', 'trim|required|xss_clean');
        // $this->form_validation->set_rules('setting_address', 'Alamat', 'trim|required|xss_clean');
        // $this->form_validation->set_rules('setting_phone', 'Nomor Telephone', 'trim|required|xss_clean');
        // $this->form_validation->set_rules('setting_district', 'Nama Kecamatan', 'trim|required|xss_clean');
        // $this->form_validation->set_rules('setting_city', 'Nama Kota/Kab', 'trim|required|xss_clean');

        if ($_POST) {
            
            $wa_center = $this->input->post('setting_wa_center');
                 
            $wa_center = str_replace(" ","",$wa_center);
            $wa_center = str_replace("(","",$wa_center);
            $wa_center = str_replace(")","",$wa_center);
            $wa_center = str_replace(".","",$wa_center);
            
            if(!preg_match('/[^+0-9]/',trim($wa_center)))
            {
            	 if(substr(trim($wa_center), 0, 1)=='+')
            	 {
            	 $wa = trim($wa_center);
            	 }
            	 elseif(substr(trim($wa_center), 0, 1)=='0')
            	 {
            	 $wa = '+62'.substr(trim($wa_center), 1);
            	 }
            	 elseif(substr(trim($wa_center), 0, 2)=='62')
            	 {
            	 $wa = '+'.trim($wa_center);
            	 }
            	 elseif(substr(trim($wa_center), 0, 1)=='8')
            	 {
            	 $wa = '+62'.trim($wa_center);
            	 }
            	 else
            	 {
            	 $wa = '+'.trim($wa_center);
            	 }		 
            }

            $param['setting_school'] = $this->input->post('setting_school');
            $param['setting_address'] = $this->input->post('setting_address');
            $param['setting_phone'] = $this->input->post('setting_phone');
            $param['setting_district'] = $this->input->post('setting_district');
            $param['setting_city'] = $this->input->post('setting_city');
            $param['setting_nip_kepsek'] = $this->input->post('setting_nip_kepsek');
            $param['setting_nama_kepsek'] = $this->input->post('setting_nama_kepsek');
            $param['setting_nip_katu'] = $this->input->post('setting_nip_katu');
            $param['setting_nama_katu'] = $this->input->post('setting_nama_katu');
            $param['setting_nip_bendahara'] = $this->input->post('setting_nip_bendahara');
            $param['setting_nama_bendahara'] = $this->input->post('setting_nama_bendahara');
            $param['setting_wa_center'] = $wa;
            $param['setting_level'] = $this->input->post('setting_level');
            $param['setting_user_sms'] = $this->input->post('setting_user_sms');
            $param['setting_pass_sms'] = $this->input->post('setting_pass_sms');
            $param['setting_sms'] = $this->input->post('setting_sms');
            $param['setting_email'] = $this->input->post('setting_email');
            $param['setting_website'] = $this->input->post('setting_website');
            $param['setting_whatsapp'] = $this->input->post('setting_whatsapp');
            $param['setting_facebook'] = $this->input->post('setting_facebook');
            $param['setting_instagram'] = $this->input->post('setting_instagram');
            $param['setting_youtube'] = $this->input->post('setting_youtube');

            $status =$this->Setting_model->save($param);

            if (!empty($_FILES['setting_logo']['name'])) {
                $paramsupdate['setting_logo'] = $this->do_upload($name = 'setting_logo', $fileName= $param['setting_school']);

                $paramsupdate['setting_id'] = $status;
                $this->Setting_model->save($paramsupdate);
            } 

            if (!empty($_FILES['setting_kartu_depan']['name'])) {
                $paramsupdate['setting_kartu_depan'] = $this->upload_kartu($name = 'setting_kartu_depan', $fileName= $param['setting_school'] . '_kartu_depan');

                $paramsupdate['setting_id'] = $status;
                $this->Setting_model->save($paramsupdate);
            } 

            if (!empty($_FILES['setting_kartu_belakang']['name'])) {
                $paramsupdate['setting_kartu_belakang'] = $this->upload_kartu($name = 'setting_kartu_belakang', $fileName= $param['setting_school'] . '_kartu_belakang');

                $paramsupdate['setting_id'] = $status;
                $this->Setting_model->save($paramsupdate);
            } 

            $this->session->set_flashdata('success', ' Sunting pengaturan berhasil');
            redirect('manage/setting');
        } else {
            $data['title'] = 'Pengaturan';
            $data['setting_school'] = $this->Setting_model->get(array('id' => 1));
            $data['setting_address'] = $this->Setting_model->get(array('id' => 2));
            $data['setting_phone'] = $this->Setting_model->get(array('id' => 3));
            $data['setting_district'] = $this->Setting_model->get(array('id' => 4));
            $data['setting_city'] = $this->Setting_model->get(array('id' => 5));
            $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
            $data['setting_level'] = $this->Setting_model->get(array('id' => 7));
            $data['setting_user_sms'] = $this->Setting_model->get(array('id' => 8));
            $data['setting_pass_sms'] = $this->Setting_model->get(array('id' => 9));
            $data['setting_sms'] = $this->Setting_model->get(array('id' => 10));
            $data['setting_nip_kepsek'] = $this->Setting_model->get(array('id' => 11));
            $data['setting_nama_kepsek'] = $this->Setting_model->get(array('id' => 12));
            $data['setting_nip_katu'] = $this->Setting_model->get(array('id' => 13));
            $data['setting_nama_katu'] = $this->Setting_model->get(array('id' => 14));
            $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
            $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
            $data['setting_wa_center'] = $this->Setting_model->get(array('id' => 17));
            $data['setting_kartu_depan'] = $this->Setting_model->get(array('id' => 18));
            $data['setting_kartu_belakang'] = $this->Setting_model->get(array('id' => 19));
            $data['setting_notif'] = $this->Setting_model->get(array('id' => 20));
            $data['setting_aktivasi'] = $this->Setting_model->get(array('id' => 33));
            $data['setting_email'] = $this->Setting_model->get(array('id' => 90));
            $data['setting_website'] = $this->Setting_model->get(array('id' => 91));
            $data['setting_whatsapp'] = $this->Setting_model->get(array('id' => 92));
            $data['setting_facebook'] = $this->Setting_model->get(array('id' => 93));
            $data['setting_instagram'] = $this->Setting_model->get(array('id' => 94));
            $data['setting_youtube'] = $this->Setting_model->get(array('id' => 95));
            
            $data['main'] = 'setting/setting_list';
            $this->load->view('manage/layout', $data);
        }
    }    
    
    public function active(){
        
        $this->load->model('setting/Setting_model');
        $act = $this->input->post("act_value");
        
        $params['setting_notif']   = $this->input->post("act_value");
        
        $this->Setting_model->save($params);
    }
    
    public function act_val() {
        
        if($_GET['act'] == 'active'){
            $this->session->set_flashdata('success',' Notifikasi WA Berhasil Diaktifkan');
        } else if ($_GET['act'] == 'inactive') {
            $this->session->set_flashdata('success',' Notifikasi WA Berhasil Dinonaktifkan');
        }
        
        redirect('manage/setting');
    }

    // Setting Upload File Requied
    function do_upload($name=NULL, $fileName=NULL) {
        $this->load->library('upload');

        $config['upload_path'] = FCPATH . 'uploads/school/';

        /* create directory if not exist */
        if (!is_dir($config['upload_path'])) {
          mkdir($config['upload_path'], 0777, TRUE);
        }

      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['max_size'] = '1024';
      $config['file_name'] = $fileName;
      $this->upload->initialize($config);

      if (!$this->upload->do_upload($name)) {
          $this->session->set_flashdata('success', $this->upload->display_errors('', ''));
          redirect(uri_string());
      }

      $upload_data = $this->upload->data();

      return $upload_data['file_name'];
  }
  
    function upload_kartu($name=NULL, $fileName=NULL) {
        $this->load->library('upload');

        $config['upload_path'] = FCPATH . 'uploads/kartu/';

        /* create directory if not exist */
        if (!is_dir($config['upload_path'])) {
          mkdir($config['upload_path'], 0777, TRUE);
        }

      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['max_size'] = '1024';
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

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
