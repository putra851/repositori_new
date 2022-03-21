<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
  }

  public function index() {
      redirect(base_url() . 'manage');
  }

  public function area() {
    $data['title'] = 'Tidak Tersedia untuk Versi Demo';
    $data['main'] = 'presensi/404';
    $this->load->view('manage/layout', $data);
  }
  
  public function rekap() {
    $data['title'] = 'Tidak Tersedia untuk Versi Demo';
    $data['main'] = 'presensi/404';
    $this->load->view('manage/layout', $data);
  }
  
  public function data_area() {
    $data['title'] = 'Tidak Tersedia untuk Versi Demo';
    $data['main'] = 'presensi/404';
    $this->load->view('manage/layout', $data);
  }
  
  public function khusus() {
    $data['title'] = 'Tidak Tersedia untuk Versi Demo';
    $data['main'] = 'presensi/404';
    $this->load->view('manage/layout', $data);
  }

}