<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $res = array('message' => 'Nothing here');

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
    }

    public function get_class() {
        $this->load->model('student/Student_model');
        $res = $this->Student_model->get_class();

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
    }

    public function get_class2() {
        $this->load->model('student/Student_model');
        $res = $this->Student_model->get(array('group'=>true));

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
    }


    public function get_student_by_class($id = NULL) {
        if ($id != NULL) {
            $this->load->model('student/Student_model');
            $res = $this->Student_model->get(array('status'=>1, 'class_id'=>$id));

            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($res));
        } else {
            redirect('api');
        }
    }


    public function get_student_by_id($student_id= NULL) {
        if ($payment_id != NULL) {
            $this->load->model('student/Student_model');
            $res = $this->Student_model->get(array('id' => $student_id));

            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($res));
        } else {
            redirect('api');
        }
    }


    public function get_payout_bulan($payment_id = NULL, $student_id= NULL) {
        if ($payment_id != NULL) {
            $this->load->model('bulan/Bulan_model');
            $res = $this->Bulan_model->get(array('payment_id' => $payment_id, 'student_id' => $student_id));

            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($res));
        } else {
            redirect('api');
        }
    }

    public function get_users() {
        $this->load->model('employees/Employees_model');
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $nip  = $this->input->get('nip');
            $pass   = md5($this->input->get('password'));
        } else {
            $nip  = $this->input->post('nip');
            $pass   = md5($this->input->post('password'));
        }
    
        $res = $this->Employees_model->get(array('employee_nip' => $nip, 'password' => $pass));

        if(count($res) > 0){
            $lokasi=getValue("nama_area","area_absensi","id_area='".$res['area_absen']."'");
            $longitude=getValue("longi","area_absensi","id_area='".$res['area_absen']."'");
            $latitude=getValue("lati","area_absensi","id_area='".$res['area_absen']."'");
            $obj = (object) [
                'is_correct' => true,
                'username' => $res["employee_id"],
                'nama' => $res["employee_name"],
                'role_id' => $res["employee_role_id_name"],
                'lokasi' => $lokasi,
                'longitude' => $longitude,
                'latitude' => $latitude,
                'validasi' => $res["validasi"],
                'jarak_radius' => $res["jarak_radius"],
                'message' => 'Data login anda valid'
            ];
        }else {
            $obj = (object) [
                'is_correct' => false,
                'message' => 'Data login anda salah'
            ];
        }

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function get_version_apk() {

        $status=200;
        $data['versionCode'] = 9;
        $data['versionName'] = "1.9";
        $data['releaseDate'] = "23 April 2019";
        $status_message="Berhasil ambil versi android apps";

        header("HTTP/1.1 ".$status);
        $response['status']=$status;
        $response['status_message']=$status_message;
        $response['data']=$data;

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response, JSON_PRETTY_PRINT));
    }

}
