<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
        header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
       
        $this->load->model(array('users/Users_model','student/Student_model'));
        $this->load->helper(array('form', 'url'));
    }

     // User_customer view in list
    public function index($offset = NULL) {
        // Apply Filter
        // Get $_GET variable
        $f = $this->input->get(NULL, TRUE);

        $data['f'] = $f;

        $params = array();
        // Nip
        if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
            $params['search'] = $f['n'];
        }
        
        $role_id = $this->session->userdata('uroleid');
        
        if($role_id != '3'){
            $params['role_id'] = '3';
        }
        $data['user'] = $this->Users_model->get($params);

        $data['majors'] = $this->Student_model->get_majors();
        $data['title'] = 'Pengguna';
        $data['main'] = 'users/user_list';
        $this->load->view('manage/layout', $data);
    }

    // Add User and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');

        if (!$this->input->post('user_id')) {
            $this->form_validation->set_rules('user_password', 'Password', 'trim|required|xss_clean|min_length[6]');
            $this->form_validation->set_rules('passconf', 'Konfirmasi password', 'trim|required|xss_clean|min_length[6]|matches[user_password]');
            $this->form_validation->set_rules('user_email', 'Email', 'trim|required|xss_clean|is_unique[users.user_email]');
            $this->form_validation->set_message('passconf', 'Password dan konfirmasi password tidak cocok');
        }
        $this->form_validation->set_rules('role_id', 'Peran', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user_full_name', 'Nama lengkap', 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('user_id')) {
                $params['user_id'] = $id;
            } else {
                $params['user_input_date'] = date('Y-m-d H:i:s');
                $params['user_email'] = $this->input->post('user_email');
                $params['user_password'] = md5($this->input->post('user_password'));
            }
            $params['user_email'] = $this->input->post('user_email');
            $params['user_role_role_id'] = $this->input->post('role_id');
            $params['user_majors_id'] = $this->input->post('majors_id');
            $params['user_last_update'] = date('Y-m-d H:i:s');
            $params['user_full_name'] = $this->input->post('user_full_name');
            $params['user_description'] = $this->input->post('user_description'); 
            $params['user_last_update'] = date('Y-m-d H:i:s');
            $status = $this->Users_model->add($params);

           if (!empty($_FILES['user_image']['name'])) {
                $paramsupdate['user_image'] = $this->do_upload($name = 'user_image', $fileName= $params['user_full_name']);
            } 

            $paramsupdate['user_id'] = $status;
            $this->Users_model->add($paramsupdate);

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'user',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('user_full_name')
                    )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' Pengguna Berhasil');
            redirect('manage/users');
        } else {
            if ($this->input->post('user_id')) {
                redirect('manage/users/edit/' . $this->input->post('user_id'));
            }
 
            // Edit mode
            if (!is_null($id)) {
                $object = $this->Users_model->get(array('id' => $id));
                if ($object == NULL) {
                    redirect('manage/users');
                } else {
                    $data['user'] = $object;
                }
            }
            $data['roles'] = $this->Users_model->get_role();
            $data['majors'] = $this->Student_model->get_majors();
            $data['title'] = $data['operation'] . ' Pengguna';
            $data['main'] = 'users/user_add';
            $this->load->view('manage/layout', $data);
        }
    }

    // View data detail
    public function view($id = NULL) {
        $data['user'] = $this->Users_model->get(array('id' => $id));
        $data['title'] = 'Pengguna';
        $data['main'] = 'users/user_view';
        $this->load->view('manage/layout', $data);
    }

    // Delete to database
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Users_model->delete($id);
            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'user',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus Pengguna berhasil');
            redirect('manage/users');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('manage/users/edit/' . $id);
        }
    }
    
    function role(){
        $data['roles'] = $this->Users_model->get_role();
        $data['title'] = 'Manajemen Pengguna';
        $data['main'] = 'users/user_role';
        $this->load->view('manage/layout', $data);   
    }
    
    function modul(){
        $role_id = $_GET['role_id'];
        echo "<table class='table table-hover table-responsive'>
                    <tr>
                        <th width='10'>No</th>
                        <th>Nama Modul</th>
                        <th>Keterangan</th>
                        <th width='100'>Aksi</th>
                    </tr>";
            $sql_menu = "SELECT * FROM navmenu WHERE menu_child = '0' ORDER BY menu_order ASC";
            $main_menu = $this->db->query($sql_menu)->result();
            $no = 1;
            foreach ($main_menu as $main) {
            
            $main_id = $main->menu_id;
            $sql_sub = "SELECT * FROM navmenu WHERE menu_child = '$main_id' ORDER BY menu_order ASC";
            $sub_menu = $this->db->query($sql_sub)->result();
            
            if (count($sub_menu) > 0) {
                
        echo "<tr>
          <td>".$no++."</td>
          <td>".$main->menu_nama."</td>
          <td>Main Menu</td>
          <td align='center'><input type='checkbox' ";
            $this->cek_akses($role_id, $main->menu_id);
             echo " onclick='addRule($main->menu_id)'></td>
          </tr>";
          
            foreach($sub_menu as $sub){
        
            $sub_id = $sub->menu_id;
            $sql_child = "SELECT * FROM navmenu WHERE menu_child = '$sub_id' ORDER BY menu_order ASC";
            $child_menu = $this->db->query($sql_child)->result();
            
            if (count($child_menu) > 0) {
            echo "<tr>
                <td>".$no++."</td>
                <td>".$sub->menu_nama."</td>
                <td>Sub Menu 1</td>
                <td align='center'><input type='checkbox' ";
                    $this->cek_akses($role_id, $sub->menu_id);
                    echo " onclick='addRule($sub->menu_id)'></td>
            </tr>";
            
            foreach($child_menu as $child) {
                echo "<tr>
                    <td>".$no++."</td>
                    <td>".$child->menu_nama."</td>
                    <td>Sub Menu 2</td>
                    <td align='center'><input type='checkbox' ";
                    $this->cek_akses($role_id, $child->menu_id);
                    echo " onclick='addRule($child->menu_id)'></td>
                </tr>";
            }
                } else {
          echo "<tr>
                    <td>".$no++."</td>
                    <td>".$sub->menu_nama."</td>
                    <td>Sub Menu 1</td>
                    <td align='center'><input type='checkbox' ";
                    $this->cek_akses($role_id, $sub->menu_id);
                    echo " onclick='addRule($sub->menu_id)'></td>
                </tr>";
                }
            }
                } else {
        echo "<tr>
                <td>".$no++."</td>
                <td>".$main->menu_nama."</td>
                <td>Main Menu</td>
                <td align='center'><input type='checkbox' ";
                $this->cek_akses($role_id, $main->menu_id);
                echo " onclick='addRule($main->menu_id)'></td>
            </tr>";
                }
            }
        echo "</table>";
    }
    
    function cek_akses($role_id,$menu_id){
        $data = array('role_id'=>$role_id,'menu_id'=>$menu_id);
        $cek = $this->db->get_where('hak_akses',$data);
        if($cek->num_rows()>0){
            echo "checked";
        }
    }

    function addrule(){
        $role_id    = $_GET['role_id'];
        $menu_id    = $_GET['menu_id'];
        $data       = array('role_id'=>$role_id,'menu_id'=>$menu_id);
        $cek       = $this->db->get_where('hak_akses',$data);
        if($cek->num_rows()<1){
            $this->db->insert('hak_akses',$data);
            echo "alert('berhasil memberikan akses modul')";
        }else{
            $this->db->where('menu_id',$menu_id);
            $this->db->where('role_id',$role_id);
            $this->db->delete('hak_akses');
            echo "alert('berhasil menghapus akses modul')";
        }
    }

    // Setting Upload File Requied
    function do_upload($name=NULL, $fileName=NULL) {
        $this->load->library('upload');

        $config['upload_path'] = FCPATH . 'uploads/users/';

        /* create directory if not exist */
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '32000';
        $config['file_name'] = $fileName;
                $this->upload->initialize($config);

        if (!$this->upload->do_upload($name)) {
            $this->session->set_flashdata('success', $this->upload->display_errors('', ''));
            redirect(uri_string());
        }

        $upload_data = $this->upload->data();

        return $upload_data['file_name'];
    }


    function rpw($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_password', 'Password', 'trim|required|xss_clean|min_length[6]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|xss_clean|min_length[6]|matches[user_password]');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        if ($_POST AND $this->form_validation->run() == TRUE) {
            $id = $this->input->post('user_id');
            $params['user_password'] = md5($this->input->post('user_password'));
            $status = $this->Users_model->change_password($id, $params);

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Pengguna',
                        'log_action' => 'Reset Password',
                        'log_info' => 'ID:null;Title:' . $this->input->post('user_nik')
                    )
            );
            $this->session->set_flashdata('success', 'Reset Password Berhasil');
            redirect('manage/users');
        } else {
            if ($this->Users_model->get(array('id' => $id)) == NULL) {
                redirect('manage/users');
            }
            $data['user'] = $this->Users_model->get(array('id' => $id));
            $data['title'] = 'Reset Password';
            $data['main'] = 'users/change_pass';
            $this->load->view('manage/layout', $data);
        }
    }

}
