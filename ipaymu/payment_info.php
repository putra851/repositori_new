<?php
$paymentChannel = '';
if (isset($_REQUEST["paymentChannel"]))  
  $paymentChannel=$_REQUEST["paymentChannel"];

$ongkir = '';
if (isset($_REQUEST["ongkir"]))  
  $ongkir=$_REQUEST["ongkir"];


$paymentMethod = '';
if (isset($_REQUEST["paymentMethod"]))  
  $paymentMethod=$_REQUEST["paymentMethod"];

$nama = '';
if (isset($_REQUEST["nama"]))  
  $nama=$_REQUEST["nama"];

$nama_tagihan = '';
if (isset($_REQUEST["nama_tagihan"]))  
  $nama_tagihan=$_REQUEST["nama_tagihan"];

$Fee = '';
if (isset($_REQUEST["Fee"]))  
  $Fee=$_REQUEST["Fee"];


$TransactionId = '';
if (isset($_REQUEST["TransactionId"]))  
  $TransactionId=$_REQUEST["TransactionId"];

$email = '';
if (isset($_REQUEST["email"]))  
  $email=$_REQUEST["email"];

$phone = '';
if (isset($_REQUEST["phone"]))  
  $phone=$_REQUEST["phone"];

$jumlah = '';
if (isset($_REQUEST["jumlah"]))  
  $jumlah=$_REQUEST["jumlah"];

$nominal = '';
if (isset($_REQUEST["nominal"]))  
  $nominal=$_REQUEST["nominal"];

$alamat = '';
if (isset($_REQUEST["alamat"]))  
  $alamat=$_REQUEST["alamat"];

$kurir = '';
if (isset($_REQUEST["kurir"]))  
  $kurir=$_REQUEST["kurir"];

$Channel = '';
if (isset($_REQUEST["Channel"]))  
  $Channel=$_REQUEST["Channel"];

$Via = '';
if (isset($_REQUEST["Via"]))  
  $Via=$_REQUEST["Via"];

$Total = '';
if (isset($_REQUEST["Total"]))  
  $Total=$_REQUEST["Total"];

$PaymentName = '';
if (isset($_REQUEST["PaymentName"]))  
  $PaymentName=$_REQUEST["PaymentName"];

$PaymentNo = '';
if (isset($_REQUEST["PaymentNo"]))  
  $PaymentNo=$_REQUEST["PaymentNo"];


$produk = '';
if (isset($_REQUEST["produk"]))  
  $produk=$_REQUEST["produk"];



?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Terimakasih</title>
      <link href="lib/bootstrap/css/bootstrap.css" rel="stylesheet">
      <link href="lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
      <link href="lib/owl-carousel/owl.css" rel="stylesheet">
      <link href="lib/Swiper/css/swiper.min.css" rel="stylesheet">
      <link href="lib/owl-carousel/assets/owl.carousel.min.css" rel="stylesheet">
      <link href="lib/vegas/vegas.min.css" rel="stylesheet">
      <link href="lib/Magnific-Popup/magnific-popup.css" rel="stylesheet">
      <link href="lib/sweetalert/sweetalert2.min.css" rel="stylesheet">
      <link href="lib/materialize-parallax/materialize-parallax.css" rel="stylesheet">
      <link href="fonts/fontawesome-all.min.css" rel="stylesheet">
      <link href="fonts/pe-icon-7-stroke.css" rel="stylesheet">
      <link href="fonts/et-line-font.css" rel="stylesheet">
      <link href="css/animate.css" rel="stylesheet">
      <link href="css/main.css" rel="stylesheet">
      <link href="css/rgen-grids.css" rel="stylesheet">
      <link href="css/helper.css" rel="stylesheet">
      <link href="css/responsive.css" rel="stylesheet">
      <link href="css/themes/theme-05.css" rel="stylesheet">
      <link href="css/template-custom.css" rel="stylesheet">
      <link rel="icon" href="images/sliming.png">
      <link rel="apple-touch-icon" href="images/favicons/apple-touch-icon.png">
      <link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-touch-icon-72x72.png">
      <link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-touch-icon-114x114.png">
      <link rel="stylesheet" href="css/novi.css">
      <!--[if lt IE 9]>     <script src="js/html5shiv.js"></script>     <script src="js/respond.min.js"></script>     <![endif]-->     <!--[if IE 9 ]><script src="js/ie-matchmedia.js"></script><![endif]--> 
      <meta name="keywords" content="Slimming Honey , lemak tubuh, menurunkan kadar kolesterol, anti inflamasi. turun berat badan, madu">
      <meta name="description" content="Slimming Honey bermanfaat untuk membantu mengurangi lemak tubuh, menurunkan kadar kolesterol, menangkal radikal bebas, serta sebagai anti inflamasi.">
      <link rel="icon" type="image/x-icon" href="images/sliming.png">
   </head>
   <body>
      <div class="page-loader"><b class="spinner"></b></div>
      <div id="page" data-linkscroll="y">
         <section class="pd-tb-small" data-rgen-sm="pd-tb-small" id="classes">
            <div class="container align-c">
               <div class="w75 mr-auto" data-animate-in="fadeIn">
<?php
include "pesannya.php";

echo $txt;
?>
<br>
<a href="index.php"><< Back Home</a>
               </div>
            </div>
         </section>
      </div>
      <script src="js/webfonts.js" type="text/javascript"></script>  
	  <script src="lib/jquery/jquery-3.3.1.min.js" type="text/javascript"></script> 
	  <script src="lib/jquery/jquery-migrate-3.0.0.min.js" type="text/javascript"></script> 
	  <script src="lib/jquery/popper.min.js" type="text/javascript"></script> 
	  <script src="lib/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
	  <script src="lib/jquery-smooth-scroll/jquery.smooth-scroll.min.js" type="text/javascript"></script> 
	  <script src="lib/jQuery-viewport-checker/jquery.viewportchecker.min.js" type="text/javascript"></script> 
	  <script src="lib/Swiper/js/swiper.min.js" type="text/javascript"></script> 
	  <script src="lib/owl-carousel/owl.js" type="text/javascript"></script> 
	  <script src="lib/Magnific-Popup/jquery.magnific-popup.min.js" type="text/javascript"></script> 
	  <script src="lib/isotope/imagesloaded.pkgd.min.js" type="text/javascript"></script> 
	  <script src="lib/isotope/isotope.pkgd.min.js" type="text/javascript"></script> 
	  <script src="lib/isotope/packery-mode.pkgd.min.js" type="text/javascript"></script> 
	  <script src="lib/jQuery-Countdown/jquery-countdown.js" type="text/javascript"></script>  
	  <script src="lib/sweetalert/sweetalert2.min.js" type="text/javascript"></script> 
	  <script src="lib/jquery-validation/jquery.validate.min.js" type="text/javascript"></script> 
	  <script src="lib/youtubebackground/jquery.youtubebackground.js" type="text/javascript"></script> 
	  <script src="lib/Vide/jquery.vide.min.js" type="text/javascript"></script> 
	  <script src="lib/vegas/vegas.min.js" type="text/javascript"></script> 
	  <script src="lib/materialize-parallax/materialize-parallax.js" type="text/javascript"></script> 
	  <script src="lib/countUp/countUp.js" type="text/javascript"></script> 
	  <script src="lib/stellar/jquery.stellar.min.js" type="text/javascript"></script> 
	  <script src="js/enquire.min.js" type="text/javascript"></script> 
	  <script src="js/main.js"></script>   
   </body>
</html>


