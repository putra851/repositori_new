<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rekap_presensi_android_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {

        $id_pegawai=0;
        if (isset($params['id_pegawai'])) {
            $id_pegawai=$params['id_pegawai'];
        }

        $periode=date('Y-m');
        if (isset($params['periode'])) {
            $periode=$params['periode'];
        }

        $res = $this->db->query("select tanggal, min(jam_datang) jam_datang, max(jam_pulang) jam_pulang
        from
        (
        select tanggal, min(time) jam_datang, null jam_pulang 
        from data_absensi 
            where id_pegawai='$id_pegawai' and jenis_absen='DATANG' group by tanggal
        union
        select tanggal, null jam_datang, max(time) jam_pulang 
        from data_absensi 
            where id_pegawai='$id_pegawai' and jenis_absen='PULANG' group by tanggal
        ) as aa
        where tanggal between '$periode-01' and '$periode-31'
        group by tanggal
        order by tanggal");

        return $res->result_array();

    }

}
