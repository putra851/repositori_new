<?php
header("Content-type:application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db_host='localhost';
$db_user='epesantren';
$db_pass='{^ya1Ed77gX8';
$db_name='epesantr_demo';
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

date_default_timezone_set('Asia/Jakarta');

function GetValue($tablename, $column, $where) {
    global $koneksi;
    $sql = "SELECT $column FROM $tablename WHERE $where";
    $rowult_get_value = mysqli_query($koneksi,$sql);
    $row_get_value = mysqli_fetch_row($rowult_get_value);
    return $row_get_value[0];
}



$nip = trim($_REQUEST["nip"]);
$password = md5(trim($_REQUEST["password"]));

//menampilkan data dari database, user wp
$sql = "select employee.employee_id, employee_nip, employee_name, employee_password, employee_email, employee_gender, employee_phone, employee_address, employee_born_place, employee_born_date, employee_photo, employee_status, employee_strata, employee.employee_majors_id, employee_position_id, employee_start, employee_end, employee_category, employee_input_date, employee_last_update,get_status_absen(employee.status_absen_temp,employee.status_absen) validasi,employee.jarak_radius,employee.area_absen,'PEGAWAI' as employee_role_id_name
from employee
where employee_nip='$nip' and employee_password='$password'";

$rs = mysqli_query($koneksi,$sql);
			$row = mysqli_fetch_array($rs);

			$longitude = GetValue("area_absensi","longi","id_area = '".$row['area_absen']."'");
			$latitude = GetValue("area_absensi","lati","id_area = '".$row['area_absen']."'");
			$lokasi = GetValue("area_absensi","nama_area","id_area = '".$row['area_absen']."'");

			$num = mysqli_num_rows($rs);
			if($num != 0) 
			{
			$obj = (object) [
           'is_correct' => true,
           'username' => $row["employee_id"],
			'nama' => $row["employee_name"],
			'nip' => $row["employee_nip"],
			'role_id' => $row["employee_role_id_name"],
			'lokasi' => $lokasi,
			'longitude' => $longitude,
			'latitude' => $latitude,
			'validasi' => $row["validasi"],
			'jarak_radius' => $row["jarak_radius"],
           'message' => 'Data login anda valid'
			];
			} 
		else {
		   $obj = (object) [
			   'is_correct' => false,
			   'message' => 'Data login anda salah'
		   ];
				}

echo json_encode($obj, JSON_PRETTY_PRINT);