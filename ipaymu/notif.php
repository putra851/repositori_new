<?php
date_default_timezone_set('Asia/Jakarta');
$db_host='localhost';
$db_user='epesantren';
$db_pass='{^ya1Ed77gX8';
$db_name='epesantr_demo';
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

$data = file_get_contents('php://input');

//$data_json = json_decode($data, true);

	$sql = "insert into data_ipaymu_notif_log (txt) values ('$data')";
	$rs = mysqli_query($koneksi,$sql);

	echo '{"status":"00"}';


?>