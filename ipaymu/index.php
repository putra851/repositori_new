<?php
date_default_timezone_set('Asia/Jakarta');
$db_host='localhost';
$db_user='epesantren';
$db_pass='{^ya1Ed77gX8';
$db_name='epesantr_demo';
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

$student_id= 1290;
if (isset($_REQUEST["student_id"]))  
  $student_id=$_REQUEST["student_id"];

$kode_tagihan= "";
if (isset($_REQUEST["kode_tagihan"]))  
  $kode_tagihan=$_REQUEST["kode_tagihan"];

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Pembayaran Siswa</title>
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
      <meta name="keywords" content="Pembayaran Siswa 1">
      <meta name="description" content="Pembayaran Siswa 2">
      <link rel="icon" type="image/x-icon" href="images/sliming.png">
	  
	  <script>
	  function ubah_id()
	  {
		  var student_id=document.getElementById("student_id").value;     
		  location.href="?student_id="+student_id;
	  }
	  </script>
   </head>
   <body>
   <?php
   function selectedok ($fielda, $fieldb)
   {
	   if ($fielda == $fieldb)
	   {
		   return " selected ";
	   }
	   else
	   {
		   return " ";
	   }
	   
   }
   ?>
      <div class="page-loader"><b class="spinner"></b></div>
      <div id="page" data-linkscroll="y">
         <section class="pd-tb-small bg-default" data-rgen-sm="pd-tb-medium">
            <div class="container small typo-light align-c">
               <!-- form-block -->    
               <div class="form-block px-w500 mr-auto" data-rgen-sm="w-reset">
                    <form method="POST" action="payment.php" class="form">
                     <div class="field-wrp">
                        <div class="form-group">        

							<select class="form-control form-control-light bdr-2 bdr-white rd-0" required="" data-msg="Silahkan Isi Kode Tagihan."  onchange="ubah_id()" name="student_id" id="student_id">
								<option value="">Pilih Siswa</option>
<?php
$sql = "SELECT a.student_id, a.student_full_name from student a ORDER BY a.student_full_name DESC ";
$rs = mysqli_query($koneksi,$sql);
while ($row = mysqli_fetch_array($rs))
{
?>								
								<option value="<?php echo $row['student_id']?>"   <?php echo selectedok($row['student_id'],$student_id) ?> ><?php echo $row['student_full_name']?> <?php echo $row['student_id']?></option>

<?php
}
?>								
							</select>


						</div>
                        
						<div class="form-group">        
							<select class="form-control form-control-light bdr-2 bdr-white rd-0" required="" data-msg="Silahkan Isi Kode Tagihan."  name="kode_tagihan">
								<option value="">Pilih Kode Tagihan</option>
<?php
$sql = "SELECT bulan.bulan_id,
       student.student_id,
		 student.student_full_name,
       class.class_name,
	    ifnull(student_parent_phone,'081335111174') student_parent_phone,
       bulan_number_pay,
       bulan_status,
       bulan_input_date,
       bulan_last_update,
       payment_payment_id,
       period_period_id,
       pos_name,
       account_account_id,
       payment_type,
       user_user_id,
       user_full_name,
       account_id,
       account_code,
       period_start,
       period_end,
		 month_month_id,
       month_name,
       bulan_bill nominal,
       concat(pos_name,' ',month_name,' ',case when month_month_id <= 6 then period_start ELSE period_end END) tagihan
  FROM bulan
  LEFT JOIN month ON month.month_id = bulan.month_month_id
  LEFT JOIN student ON student.student_id = bulan.student_student_id
  LEFT JOIN payment ON payment.payment_id = bulan.payment_payment_id
  LEFT JOIN pos ON pos.pos_id = payment.pos_pos_id
  LEFT JOIN period ON period.period_id = payment.period_period_id
  LEFT JOIN class ON class.class_id = student.class_class_id
  LEFT JOIN majors ON majors.majors_id = student.majors_majors_id
  LEFT JOIN users ON users.user_id = bulan.user_user_id
  LEFT JOIN account ON account.account_id = pos.account_account_id
WHERE student.student_id = '$student_id'
   AND bulan.bulan_status = '0'
   AND period_status = '1'
 ORDER BY month_month_id ASC, bulan.payment_payment_id ASC";
$rs = mysqli_query($koneksi,$sql);
while ($row = mysqli_fetch_array($rs))
{
?>								
								<option value="<?php echo $row['bulan_id']?>|<?php echo $row['nominal']?>|<?php echo $row['student_full_name']?>|<?php echo $row['tagihan']?>"   <?php echo selectedok($row['bulan_id'],$kode_tagihan) ?> ><?php echo $row['tagihan']?> Rp. <?php echo number_format($row['nominal'])?>,-</option>

<?php
}
?>								
</select>
						</div>

						<div class="form-group">        
							<select class="form-control form-control-light bdr-2 bdr-white rd-0" required="" data-msg="Silahkan Isi Channel Pembayaran."  name="payment_channel">
								  <option value="">Bayar Via</option>
									<option value='va|bni'>Virtual Account BNI </option>
									<option value='va|mandiri'>Virtual Account Bank Mandiri </option>
									<option value='va|cimb'>Virtual Account Cimb Niaga </option>
									<option value='va|bag'>Virtual Account  Bank Arta Graha</option>
									<!--
									<option value='banktransfer|bca'>Bank Transfer  BCA </option>
									<option value='cstore|indomaret'>Retail Indomaret </option>
									-->
									<option value='cstore|alfamart'>Retail Alfamart / Alfamidi</option>
							</select>
						</div>

						
                     </div>
                     <button type="submit" class="btn solid btn-dark hov-btn-white block rd-0"><i class="fa fa-envelope-o"></i> B A Y A R</button>     
                  </form>
                  <!-- / form -->    
               </div>
               <!-- / form block -->    
            </div>
            <!-- // END : Container //  -->    <!-- ================================= = Background holder ================================= --> 
            <div class="bg-holder full-wh z0">
               <!-- Overlay -->  <b data-bgholder="overlay" class="full-wh z5" data-bgcolor="rgba(45, 51, 69, 0)"></b>  <!-- Parallax image -->  
               <div data-bgholder="parallax" class="full-wh z2"></div>
               <!-- Background image -->  <b data-bgholder="bg-img" class="full-wh bg-cover bg-cc z1"></b> 
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

