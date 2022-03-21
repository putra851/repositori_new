<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->config->item('app_name') ?> <?php echo isset($title) ? ' | ' . $title : null; ?></title>
  <link rel="icon" type="image/png" href="<?php echo media_url('ico/favicon.ico') ?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo media_url() ?>css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo media_url() ?>css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo media_url() ?>css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo media_url() ?>css/style.css">
  <link rel="stylesheet" href="<?php echo media_url() ?>css/load-font-googleapis.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
   folder instead of downloading all of them to reduce the load. -->
   <!-- Notyfy JS - Notification -->
   <link rel="stylesheet" href="<?php echo media_url() ?>css/jquery.toast.css">
   <link rel="stylesheet" href="<?php echo media_url() ?>css/_all-skins.min.css">
   <!-- Date Picker -->
   <link rel="stylesheet" href="<?php echo media_url() ?>css/bootstrap-datepicker.min.css">
   <!-- Daterange picker -->
   <link rel="stylesheet" href="<?php echo media_url() ?>css/daterangepicker.css">
    <link rel="stylesheet" href="<?php echo media_url() ?>DataTables/css/dataTables.bootstrap.css">
   <link rel="stylesheet" href="<?php echo media_url() ?>DataTables/css/jquery.dataTables.css">
    
   <link href="<?php echo base_url('/media/js/fullcalendar/fullcalendar.css');?>" rel="stylesheet">

   <script src="<?php echo media_url() ?>js/jquery.min.js"></script>
   <script src="<?php echo media_url() ?>js/dateFormat.js"></script>
   <script src="<?php echo media_url() ?>js/jquery.dateFormat.js"></script>
   <script src="<?php echo media_url() ?>DataTables/js/jquery.dataTables.js"></script>
   <!--<script src="<?php echo media_url() ?>DataTables/plugins/range-date.js"></script>-->
   <script src="<?php echo media_url() ?>js/jquery.ajaxfileupload.js"></script>
   <!-- jQuery UI 1.11.4 -->
   <script src="<?php echo media_url() ?>js/jquery-ui.min.js"></script>
   <script src="<?php echo media_url() ?>js/jquery.inputmask.bundle.js"></script>
   
   <script src="<?php echo base_url('/media/js/fullcalendar/fullcalendar.js');?>"></script>

 </head>
 <body class="hold-transition skin-green fixed sidebar-mini" <?php echo isset($ngapp) ? $ngapp : null; ?>>
  <div class="wrapper"> 
<!-- Content Wrapper. Contains page content -->
<?php isset($main) ? $this->load->view($main) : null; ?>
<!-- Content Wrapper. Contains page content -->


<!-- jQuery 3 -->




<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo media_url() ?>js/bootstrap.min.js"></script>
<script src="<?php echo media_url() ?>js/moment.min.js"></script>

<script src="<?php echo media_url() ?>js/fullcalendar.min.js"></script>


<!-- daterangepicker -->
<script src="<?php echo media_url() ?>js/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo media_url() ?>js/bootstrap-datepicker.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo media_url() ?>js/jquery.slimscroll.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo media_url() ?>js/adminlte.min.js"></script>
<!-- Notyfy JS -->
<script src="<?php echo media_url() ?>js/jquery.toast.js"></script>

<!-- select2 -->
<link href="<?php echo media_url() ?>select2_css/select2.min.css" rel="stylesheet" />
<script src="<?php echo media_url() ?>select2_js/select2.min.js"></script>

<script>
$('.s2').select2();
</script>

<script>
  $(".years").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    autoclose: true,
    todayHighlight: true
  });
  $(".input-group.date").datepicker({
    format: "yyyy-mm-dd",
    autoclose: true,
    todayHighlight: true
  });
</script>

<?php if ($this->session->flashdata('success')) { ?>
  <script>
    $(document).ready(function() {
      $.toast({
       heading: 'Berhasil',
       text: '<?php echo $this->session->flashdata('success') ?>',
       position: 'top-right',
       loaderBg: '#ff6849',
       icon: 'success',
       hideAfter: 3500,
       stack: 6
     })
    });
  </script>
<?php } ?>

<?php if ($this->session->flashdata('failed')) { ?>
  <script>
    $(document).ready(function() {
      $.toast({
       heading: 'Gagal',
       text: '<?php echo $this->session->flashdata('failed') ?>',
       position: 'top-right',
       loaderBg: '#ff2e2e',
       icon: 'error',
       hideAfter: 3500,
       stack: 6
     })
    });
  </script>
<?php } ?>


<script>
	$(document).ready(function(){
		$('#dtable').DataTable();
	});
</script>

<script>

  $(document).ready(function(){
    $('.numeric').inputmask("numeric", {
      removeMaskOnSubmit: true,
      radixPoint: ".",
      groupSeparator: ",",
      digits: 2,
      autoGroup: true,
            prefix: 'Rp ', //Space after $, this will not truncate the first character.
            rightAlign: false,
            // oncleared: function() {
            //   self.Value('');
            // }
          });
  });
</script>

<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
  });
</script>

<script>
    // JavaScript New Window
	var win = null;
	function newWindow(mypage,myname,w,h,features) {
		var winl = (screen.width-w)/2;
		var wint = (screen.height-h)/2;
		if (winl < 0) winl = 0;
		if (wint < 0) wint = 0;
		var settings = 'height=' + h + ',';
		settings += 'width=' + w + ',';
		settings += 'top=' + wint + ',';
		settings += 'left=10,';
		settings += features;
		win = window.open(mypage,myname,settings);
		win.window.focus();
	}
</script>

</body>
</html>
