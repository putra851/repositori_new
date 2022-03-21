<?php
$db_host='localhost';
$db_user='epesantr_demonstran';
$db_pass='5[RB*SpX,X0)p#mXn2';
$db_name='epesantr_demo';
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

date_default_timezone_set('Asia/Jakarta');

function GetValue($tablename, $column, $where) {
    global $koneksi;
    $sql = "SELECT $column FROM $tablename WHERE $where";
    $result_get_value = mysqli_query($koneksi,$sql);
    $row_get_value = mysqli_fetch_row($result_get_value);
    return $row_get_value[0];
}

//$target_path = "http://demo.epesantren.co.id/uploads/";
$target_path = "absensi/";

// array for final json respone
$response = array();
 
// final file url that is being uploaded
$file_upload_url = $target_path;

$id_pegawai = isset($_REQUEST['id_pegawai']) ? $_REQUEST['id_pegawai'] : '';
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
$lokasi = isset($_REQUEST['lokasi']) ? $_REQUEST['lokasi'] : '';
$longi = isset($_REQUEST['longi']) ? $_REQUEST['longi'] : '';
$lati = isset($_REQUEST['lati']) ? $_REQUEST['lati'] : '';
$keterangan = isset($_REQUEST['keterangan']) ? $_REQUEST['keterangan'] : '';
$created_date  = date("Y-m-d H:i:s");
$status = "SUKSES_UPLOAD";

$img = $_REQUEST['image'];

if($img){
    $response['error']=false;
    $response['msg'] = 'SUKSES_UPLOAD';
    $status = "SUKSES_UPLOAD";
}else{
    $response['error']=true;
    $response['msg'] = 'GAGAL_UPLOAD';
    $status = "GAGAL_UPLOAD";
}

// tulis data ke database dulu
$created_date  = date("Y-m-d H:i:s");   
$bulan= date("Y-m");
$date = date("Y-m-d");
$time = date("H:i:s");
$file_path = $file_upload_url . $id_pegawai .date('Ymdhis'). '.jpeg';
if ($status == "GAGAL_UPLOAD") $file_path = "absensi/no_image.jpeg";

$id_pegawai = $id_pegawai;  
$jenis_absen = $type;  
$foto = $file_path;  
$catatan_absen = $keterangan;  
$remark = $status;  
$lokasi = $lokasi;  

$area_absen = GetValue("employee","area_absen","employee_id='$id_pegawai'");
$lokasi = GetValue("area_absensi","nama_area","id_area='$area_absen'");

$koneksi->query("delete from data_absensi where id_pegawai='$id_pegawai' and tanggal='$date' and (jenis_absen='SAKIT' or jenis_absen='IJIN' or jenis_absen='CUTI')");

// $koneksi->query("SET FOREIGN_KEY_CHECKS=0");

$sql = "insert into data_absensi set 
        id_pegawai = '$id_pegawai', 
        area_absen = '$area_absen', 
        bulan = '$bulan', 
        tanggal = '$date', 
        time = '$time', 
        jenis_absen = '$jenis_absen', 
        longi = '$longi', 
        lati = '$lati', 
        foto = '$img', 
        catatan_absen = '$catatan_absen', 
        lokasi = '$lokasi', 
        remark = '$remark', 
        created_by = '$created_by',
        created_date = '$created_date'";
$rs = mysqli_query($koneksi,$sql);

// $koneksi->query("SET FOREIGN_KEY_CHECKS=1");
if($rs){
    $response['error']=false;
    $response['msg'] = 'SUKSES_UPLOAD';
}else{
    $response['error']=true;
    $response['msg'] = 'GAGAL_UPLOAD';
}

// Echo final json response to client
echo json_encode($response);
?>