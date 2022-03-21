<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Day_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
  }

  $this->load->model('bulan/Bulan_model');
  $this->load->helper(array('form', 'url'));
}

// User_customer view in list
public function index($offset = NULL) {
    $this->load->library('pagination');
// Apply Filter
// Get $_GET variable
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $params = array();
// Nip
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['class_name'] = $f['n'];
  }

  $paramsPage = $params;
  $params['limit'] = 7;
  $params['offset'] = $offset;
  $data['day'] = $this->Bulan_model->get_day($params);

  $config['per_page'] = 7;
  $config['uri_segment'] = 4;
  $config['base_url'] = site_url('manage/day/index');
  $config['suffix'] = '?' . http_build_query($_GET, '', "&");
  $config['total_rows'] = count($this->Bulan_model->get_day($paramsPage));
  $this->pagination->initialize($config);

  $data['title'] = 'Hari';
  $data['main'] = 'day/day_list';
  $this->load->view('manage/layout', $data);
}

// Add User_customer and Update
public function add($id = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('day_name', 'Name', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button ket="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

        if ($this->input->post('day_id')) {
            $params['day_id'] = $this->input->post('day_id');
        }
        $params['day_name'] = $this->input->post('day_name');
        $status = $this->Bulan_model->add_day($params);


        $this->session->set_flashdata('success', $data['operation'] . ' Hari');
        redirect('manage/day');

        if ($this->input->post('from_angular')) {
            echo $status;
        }
    } else {
        if ($this->input->post('day_id')) {
            redirect('manage/day/edit/' . $this->input->post('day_id'));
        }

            // Edit mode
        if (!is_null($id)) {
            $object = $this->Bulan_model->get_day(array('id' => $id));
            if ($object == NULL) {
                redirect('manage/day');
            } else {
                $data['day'] = $object;
            }
        }
        $data['title'] = $data['operation'] . ' Hari';
        $data['main'] = 'day/day_add';
        $this->load->view('manage/layout', $data);
    }
}

}
