<?php
date_default_timezone_set('Asia/Jakarta');
$db_host='localhost';
$db_user='epesantren';
$db_pass='{^ya1Ed77gX8';
$db_name='epesantr_demo';
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    // SAMPLE HIT API iPaymu v2 PHP //
    $va           = '1179001233640003'; //get on iPaymu dashboard
    $secret       = '39F0ADF6-7E9D-4AEB-9934-53DB0145844E'; //get on iPaymu dashboard

//    $va           = '1179005295349915'; //get on iPaymu dashboard
//    $secret       = 'EF267186-229C-43EC-BD49-FCB81839615A'; //get on iPaymu dashboard


    $url          = 'https://my.ipaymu.com/api/v2/payment/direct'; //url
    $method       = 'POST'; //method

$produk = '';
if (isset($_REQUEST["produk"]))  
  $produk=$_REQUEST["produk"];


$payment_channel = 'va|bni';
if (isset($_REQUEST["payment_channel"]))  
  $payment_channel=$_REQUEST["payment_channel"];

$payment = explode("|", $payment_channel);

$paymentMethod =$payment[0];
$paymentChannel =$payment[1];


$student_id = '';
if (isset($_REQUEST["student_id"]))  
  $student_id=$_REQUEST["student_id"];

$kode_tagihan = '';
if (isset($_REQUEST["kode_tagihan"]))  
  $kode_tagihan=$_REQUEST["kode_tagihan"];

$tagihan = explode("|", $kode_tagihan);

$bulan_id =$tagihan[0];
$nominal =$tagihan[1];
$nama =$tagihan[2];
$nama_tagihan =$tagihan[3];


$email = '';
if (isset($_REQUEST["email"]))  
  $email=$_REQUEST["email"];

$phone = '';
if (isset($_REQUEST["phone"]))  
  $phone=$_REQUEST["phone"];

$jumlah = '';
if (isset($_REQUEST["jumlah"]))  
  $jumlah=$_REQUEST["jumlah"];

$alamat = '';
if (isset($_REQUEST["alamat"]))  
  $alamat=$_REQUEST["alamat"];

$kurir = '';
if (isset($_REQUEST["kurir"]))  
  $kurir=$_REQUEST["kurir"];

$email = "abinehana@gmail.com";
$phone = "62813351111745";

	echo $paymentMethod;
	echo "<br>";
	echo $nama;
	echo "<br>";
	echo $email;
	echo "<br>";
	echo $phone;
	echo "<br>";
	echo $nominal;
	echo "<br>";


if ($paymentMethod == 'cstore' || $paymentMethod == 'va')
{
    //Request Body//
    $body['name']    = $nama;
    $body['email']   = $email;
    $body['phone']   = $phone;
    $body['amount']  = $nominal;
    $body['paymentMethod']  = $paymentMethod;
    $body['paymentChannel']   = $paymentChannel;
    $body['notifyUrl']   = 'http://mobile.epesantren.co.id/notif_ipaymu.php';
    $body['expired']   = '30';
    $body['expiredType']   = 'days';
    $body['comments']   = 'One Point Zero';
    $body['referenceId']   = '1';
    $body['description']   = 'One Point Zero';
    //End Request Body//

    //Generate Signature
    // *Don't change this
    $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
    $requestBody  = strtolower(hash('sha256', $jsonBody));
    $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $secret;
	
	echo $stringToSign;
	
    $signature    = hash_hmac('sha256', $stringToSign, $secret);
    $timestamp    = Date('YmdHis');
    //End Generate Signature


    $ch = curl_init($url);

    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
        'va: ' . $va,
        'signature: ' . $signature,
        'timestamp: ' . $timestamp
    );

    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_POST, count($body));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $err = curl_error($ch);
    $ret = curl_exec($ch);
    curl_close($ch);

echo $ret;
echo "<br>";
//echo "<br>";
        $data = json_decode($ret);
		$sessionId  = $data->Data->SessionId;
		$TransactionId  = $data->Data->TransactionId;
		$Fee  = $data->Data->Fee;
		$Expired  = $data->Data->Expired;
		$Via  = $data->Data->Via;
		$Channel  = $data->Data->Channel;
		$Total  = $data->Data->Total;
		$PaymentNo  = $data->Data->PaymentNo;
		$PaymentName  = $data->Data->PaymentName;

}
else
{
		$sessionId  = 1;
		$TransactionId  = 154345;
		$Fee  = 0;
		$Expired  = '';
		$Via  = "Bank Transfer";
		$Channel  = $paymentChannel;
		$Total  = $nominal;
		if ($paymentChannel == "mandiri")
		{
		$PaymentNo  = "1020006414939";
		}

		if ($paymentChannel == "muamalat")
		{
		$PaymentNo  = "1170010114";
		}


		if ($paymentChannel == "bsm")
		{
		$PaymentNo  = "7026284583";
		}


		$PaymentName  = "Jupriyanto";
	
}
echo "<br>No Rekening : ".$PaymentNo;
echo "<br>Nama Rekening : ".$PaymentName;
echo "<br>Total : ".$Total;
echo "<br>Via : ".$Via;
echo "<br>Channel : ".$Channel;

if ($kurir == 'LUAR')
{
$ongkir = 1000;	
}
else
{
$ongkir = 16000;	
}

$created_date  = date("Y-m-d H:i:s");
$sql = "insert into data_ipaymu_new set 
sessionId = '$sessionId',
TransactionId = '$TransactionId',
Fee = '$Fee',
Expired = '$Expired',
PaymentNo = '$PaymentNo',
PaymentName = '$PaymentName',
Total = '$Total',
Via = '$Via',
Channel = '$Channel',
paymentChannel = '$paymentChannel',
paymentMethod = '$paymentMethod',
nama = '$nama',
email = '$email',
phone = '$phone',
jumlah = '$jumlah',
nominal = '$nominal',
bulan_id = '$bulan_id',
student_id = '$student_id',
nama_tagihan = '$nama_tagihan',
created_date = '$created_date'";

$rs = mysqli_query($koneksi,$sql);

include "pesannya.php";
$tahun = date("Y");
			$from = "noreplay@onepoinzero.id";
			$to = $email;
			$subject = "Pemesanan $produk $created_date";

$pesan ="<html>
<head>
<title>Pemesanan $produk</title>
</head>
<body>
<table style='border-collapse:collapse' width='600px' height='100%' cellspacing='0' cellpadding='0' border='0' bgcolor='#f1f1f1' align='center'>
    <tbody><tr>
        <td valign='top'>
            <table style='text-align:left' cellspacing='0' cellpadding='0' border='1' bgcolor='#ffffff'>
                <tbody>
                <tr>
                    <td style='border-top:none;border-bottom:none;border-left:none;border-right:none' height='15'>
                    </td>
                </tr>
                <tr>
                    <td style='border-top:none;border-bottom:none;border-left:none;border-right:none' width='15'>
                    </td>
                    <td style='font-size:83%;border-top:none;border-bottom:none;border-left:none;border-right:none;font-size:13px;font-family:arial,sans-serif;color:#222222;line-height:18px' width='568' valign='top'>
".$txt."
                    </td>
                    <td style='border-top:none;border-bottom:none;border-left:none;border-right:none' width='15'>
                    </td>
                </tr>
                <tr>
                    <td style='border-top:none;border-bottom:none;border-left:none;border-right:none' height='15'>
                    </td>
                </tr>
                <tr>
                    <td style='border-top:none;border-bottom:none;border-left:none;border-right:none' width='15'></td>
                    <td style='font-size:11px;font-family:arial,sans-serif;color:#777777;border-top:none;border-bottom:none;border-left:none;border-right:none' width='568'>
                        Email ini tidak dapat menerima balasan dari anda. 
                    </td>
                    <td style='border-top:none;border-bottom:none;border-left:none;border-right:none' width='15'></td>
                </tr>
                <tr>
                    <td style='border-top:none;border-bottom:none;border-left:none;border-right:none' height='15'>
                    </td>
                </tr>
                </tbody>
            </table>
            <table style='text-align:left' height='80' bgcolor='#f1f1f1'>
                <tbody><tr valign='middle'>
                    <td style='font-size:11px;font-family:arial,sans-serif;color:#777777'>
                        <div style='direction:ltr'>
                            ©$tahun One Point Zero
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody></table>
</body>
</html>
";


$message = $pesan;			
//include("email_data.php");	

?>

<script>
document.body.innerHTML += '<form id="dynForm" action="payment_info.php" method="post">\
<input type="hidden" name="sessionId" value="<?php echo $sessionId?>">\
<input type="hidden" name="produk" value="<?php echo $produk?>">\
<input type="hidden" name="TransactionId" value="<?php echo $TransactionId?>">\
<input type="hidden" name="PaymentNo" value="<?php echo $PaymentNo?>">\
<input type="hidden" name="PaymentName" value="<?php echo $PaymentName?>">\
<input type="hidden" name="Total" value="<?php echo $Total?>">\
<input type="hidden" name="Via" value="<?php echo $Via?>">\
<input type="hidden" name="Fee" value="<?php echo $Fee?>">\
<input type="hidden" name="Channel" value="<?php echo $Channel?>">\
<input type="hidden" name="paymentChannel" value="<?php echo $paymentChannel?>">\
<input type="hidden" name="paymentMethod" value="<?php echo $paymentMethod?>">\
<input type="hidden" name="nama" value="<?php echo $nama?>">\
<input type="hidden" name="email" value="<?php echo $email?>">\
<input type="hidden" name="phone" value="<?php echo $phone?>">\
<input type="hidden" name="jumlah" value="<?php echo $jumlah?>">\
<input type="hidden" name="nominal" value="<?php echo $nominal?>">\
<input type="hidden" name="nama_tagihan" value="<?php echo $nama_tagihan?>">\
<input type="hidden" name="ongkir" value="<?php echo $ongkir?>">\
<input type="hidden" name="kurir" value="<?php echo $kurir?>">\
</form>';
document.getElementById("dynForm").submit();
</script>
