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
 
// Path to move uploaded files
//$target_path = "http://demo.epesantren.co.id/uploads/";
$target_path = "absensi/";
 
// array for final json respone
$response = array();
 
// getting server ip address
$server_ip = gethostbyname(gethostname());
 
// final file url that is being uploaded
$file_upload_url = $target_path;

    $id_pegawai = isset($_REQUEST['id_pegawai']) ? $_REQUEST['id_pegawai'] : '';
    $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
	$lokasi = isset($_REQUEST['lokasi']) ? $_REQUEST['lokasi'] : '';
    $longi = isset($_REQUEST['longi']) ? $_REQUEST['longi'] : '';
    $lati = isset($_REQUEST['lati']) ? $_REQUEST['lati'] : '';
    $keterangan = isset($_REQUEST['keterangan']) ? $_REQUEST['keterangan'] : '';
    $created_date  = date("Y-m-d H:i:s");
 
    $response['longi'] = $longi;
    $response['lati'] = $lati;
    $response['lokasi'] = $lokasi;
    $response['type'] = $type;
    $response['keterangan'] = $keterangan;
    $response['id_pegawai'] = $id_pegawai;
	$status = "SUKSES_UPLOAD";

    // $hari   = date('l', microtime($created_date));
    // $hari_indonesia = array('Monday'  => 'Senin',
    //     'Tuesday'  => 'Selasa',
    //     'Wednesday' => 'Rabu',
    //     'Thursday' => 'Kamis',
    //     'Friday' => 'Jumat',
    //     'Saturday' => 'Sabtu',
    //     'Sunday' => 'Ahad');

    // $chl=0;
    // $get_libur=$koneksi->query("select hari from data_hari_libur order by hari asc");
    // while($hl=mysqli_fetch_array($get_libur)){
    //     $dl=$hl['hari'];
    //     if($dl==$hari_indonesia[$hari]){
    //         $chl+=1;
    //     }
    // }

    // if($chl == 0){

    // }else{
    //     $response['error'] = true;
	// 	$status = "GAGAL_UPLOAD2";
    //     $response['message'] = 'Maaf hari ini libur kerja, silakan presensi hari kerja';
    // }
 
 
if (isset($_FILES['image']['name'])) {
    $target_path = $target_path . $id_pegawai."_".basename($_FILES['image']['name']);
    $response['file_name'] = $id_pegawai."_".basename($_FILES['image']['name']);
 
    try {
        // Throws exception incase file is not being moved
        $move_upload="../uploads/absensi/". $id_pegawai."_".basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $move_upload)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
			$status = "GAGAL_UPLOAD1";

        }
 
        // File successfully uploaded
        $response['message'] = 'File uploaded successfully!';
        $response['error'] = false;
        $response['file_path'] = $file_upload_url . $id_pegawai."_".basename($_FILES['image']['name']);
    } catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
		$status = "GAGAL_UPLOAD2";
        $response['message'] = $e->getMessage();
    }
}  else {
    $response['message'] = 'Not received any image';
	$status = "GAGAL_UPLOAD3";
 }

// tulis data ke database dulu
$created_date  = date("Y-m-d H:i:s");   
$bulan= date("Y-m");
$date = date("Y-m-d");
$time = date("H:i:s");
$file_path = $file_upload_url . $id_pegawai."_".basename($_FILES['image']['name']);
if ($status == "GAGAL_UPLOAD3") $file_path = "../uploads/absensi/no_image.jpg";

     $id_pegawai = $id_pegawai;  
     $jenis_absen = $type;  
     $foto = $file_path;  
     $catatan_absen = $keterangan;  
     $remark = $status;  
     $lokasi = $lokasi;  

    $area_absen = GetValue("employee","area_absen","employee_id='$id_pegawai'");

    $koneksi->query("delete from data_absensi where id_pegawai='$id_pegawai' and tanggal='$date' and (jenis_absen='SAKIT' or jenis_absen='IJIN' or jenis_absen='CUTI')");

    $sql = "insert into data_absensi set 
             id_pegawai = '$id_pegawai', 
             area_absen = '$area_absen', 
             bulan = '$bulan', 
             tanggal = '$date', 
             time = '$time', 
             jenis_absen = '$jenis_absen', 
             longi = '$longi', 
             lati = '$lati', 
             foto = '$foto', 
             catatan_absen = '$catatan_absen', 
             lokasi = '$lokasi', 
             remark = '$remark', 
             created_by = '$created_by',
             created_date = '$created_date'";
	$rs = mysqli_query($koneksi,$sql);
 
// Echo final json response to client
echo json_encode($response);
?>