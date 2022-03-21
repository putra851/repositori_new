<?php
header("Content-Type:application/json");

$data['versionCode'] = 15;
$data['versionName'] = "1.0";
$data['releaseDate'] = "24 Mei 2021";

response(200,"Berhasil ambil versi android apps", $data);


function response($status,$status_message,$data)
{
	header("HTTP/1.1 ".$status);
	
	$response['status']=$status;
	$response['status_message']=$status_message;
	$response['data']=$data;
	
	$json_response = json_encode($response);
	echo $json_response;
}