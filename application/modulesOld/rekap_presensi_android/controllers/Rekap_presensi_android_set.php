<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_presensi_android_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model(array('rekap_presensi_android/rekap_presensi_android_model','student/Student_model', 'setting/Setting_model'));
    $this->load->helper(array('form', 'url'));
  }

  public function index() {
    $this->load->library('pagination');
    // Apply Filter
    // Get $_GET variable
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $params = array();
    $param = array();
    $periode=date('Y-m');
    if (isset($f['periode']) && !empty($f['periode']) && $f['periode'] != '') {
      $periode = $f['periode'];
    }
    $data['periode']=$periode;
    $id_pegawai=0;
    if (isset($f['id_pegawai']) && !empty($f['id_pegawai']) && $f['id_pegawai'] != '') {
      $id_pegawai = $f['id_pegawai'];
    }

    $res = $this->db->query("select tanggal, min(jam_datang) jam_datang, max(jam_pulang) jam_pulang,catatan_absen,jenis_absen
        from
        (
        select tanggal, min(time) jam_datang, null jam_pulang,min(catatan_absen) catatan_absen,min(jenis_absen) jenis_absen 
        from data_absensi 
            where id_pegawai='$id_pegawai' and jenis_absen='DATANG' group by tanggal
        union
        select tanggal, null jam_datang, max(time) jam_pulang,min(catatan_absen) catatan_absen,min(jenis_absen) jenis_absen 
        from data_absensi 
            where id_pegawai='$id_pegawai' and jenis_absen='PULANG' group by tanggal
        union
        select tanggal, null jam_datang, null jam_pulang,min(catatan_absen) catatan_absen,min(jenis_absen) jenis_absen 
        from data_absensi 
            where id_pegawai='$id_pegawai' and jenis_absen='SAKIT' group by tanggal
        union
        select tanggal, null jam_datang, null jam_pulang,min(catatan_absen) catatan_absen,min(jenis_absen) jenis_absen 
        from data_absensi 
            where id_pegawai='$id_pegawai' and jenis_absen='IJIN' group by tanggal
        union
        select tanggal, null jam_datang, null jam_pulang,min(catatan_absen) catatan_absen,min(jenis_absen) jenis_absen 
        from data_absensi 
            where id_pegawai='$id_pegawai' and jenis_absen='CUTI' group by tanggal
        ) as aa
        where tanggal between '$periode-01' and '$periode-31'
        group by tanggal
        order by tanggal");

    $data['rekap_presensi_android'] = $res->result_array();
    $config['base_url'] = site_url('manage/rekap_presensi_android');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");

    $data['title'] = 'Rekap Presensi';
    $data['main'] = 'rekap_presensi_android/rekap_presensi_android_list';
    $this->load->view('manage/layout_android', $data);
  }

}