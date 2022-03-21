<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Poshutang_set extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('student/Student_model', 'poshutang/Poshutang_model', 'payment/Payment_model', 'logs/Logs_model'));
        $this->load->library('upload');
    }

    // pos view in list
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
            $params['poshutang_name'] = $f['n'];
        }
        
        if (isset($s['m']) && !empty($s['m']) && $s['m'] != 'all') {
            $params['account_majors_id'] = $s['m'];
        } else if (isset($s['m']) && !empty($s['m']) && $s['m'] == 'all') {
            
        }
        
        $data['poshutang'] = $this->Poshutang_model->get($params);

        $majors_id = $this->session->userdata('umajorsid');
        
        if($majors_id != '0')
        {
            $data['account'] = $this->db->query("SELECT * FROM account WHERE account_code LIKE '2%' AND account_category = '2' AND account_majors_id = '$majors_id'")->result();
        } else {
            $data['account'] = $this->db->query("SELECT * FROM account WHERE account_code LIKE '2%' AND account_category = '2'")->result();
        }
        
        $config['base_url'] = site_url('manage/poshutang/index');
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        
        $data['majors'] = $this->Student_model->get_majors();

        $data['title'] = 'Pos Hutang';
        $data['main'] = 'poshutang/poshutang_list';
        $this->load->view('manage/layout', $data);
    }

    public function add_glob(){
    if ($_POST == TRUE) {
      $posName = $_POST['poshutang_name'];
      $posKet = $_POST['poshutang_description'];
      $accountID = $_POST['poshutang_account_id'];
      $cpt = count($_POST['poshutang_name']);
      for ($i = 0; $i < $cpt; $i++) {
        $params['poshutang_name'] = $posName[$i];
        $params['poshutang_description'] = $posKet[$i];
        $params['poshutang_account_id'] = $accountID[$i];

        $this->Poshutang_model->add($params);
      }
    }
    $this->session->set_flashdata('success',' Tambah POS Berhasil');
    redirect('manage/poshutang');
  }


    // Add pos and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('poshutang_name', 'Pos Hutang', 'trim|required|xss_clean');
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('poshutang_id')) {
                $params['poshutang_id'] = $this->input->post('poshutang_id');
            }

            $params['poshutang_name'] = $this->input->post('poshutang_name');
            $params['poshutang_description'] = $this->input->post('poshutang_description');
            $params['poshutang_account_id'] = $this->input->post('poshutang_account_id');

            $status = $this->Poshutang_model->add($params);
            $paramsupdate['poshutang_id'] = $status;
            $this->Poshutang_model->add($paramsupdate);


            // activity log
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('user_id'),
                        'log_module' => 'Pos Hutang',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:null;Title:' . $params['poshutang_name']
                    )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' Pos Hutang berhasil');
            redirect('manage/poshutang');
        } else {
            if ($this->input->post('poshutang_id')) {
                redirect('manage/poshutang/edit/' . $this->input->post('poshutang_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $data['poshutang'] = $this->Poshutang_model->get(array('id' => $id));
                $majors_id = $this->session->userdata('umajorsid');
                if($majors_id != '0')
                {
                    $data['account'] = $this->db->query("SELECT * FROM account WHERE account_code LIKE '2%' AND account_category = '2' AND account_majors_id = '$majors_id'")->result_array();
                } else {
                    $data['account'] = $this->db->query("SELECT * FROM account WHERE account_code LIKE '2%' AND account_category = '2'")->result_array();
                }
            }
            $data['title'] = $data['operation'] . ' Pos Hutang';
            $data['main'] = 'poshutang/poshutang_add';
            $this->load->view('manage/layout', $data);
        }
    }


    // Delete to database
    public function delete($id = NULL) {
       if ($this->session->userdata('uroleid')!= SUPERUSER){
          redirect('manage');
        }
        if ($_POST) {

            $payment = $this->Payment_model->get(array('poshutang_id'=>$id));

            if (count($payment) > 0) {
                $this->session->set_flashdata('failed', 'Data POS tidak dapat dihapus');
                redirect('manage/poshutang');
            }

            $this->Poshutang_model->delete($id);
            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Pos Hutang',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus Pos Hutang berhasil');
            redirect('manage/poshutang');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('manage/poshutang/edit/' . $id);
        }
    }

}