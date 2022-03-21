<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Registrasi Admin Sekolah</title>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $this->config->item('app_name') ?> <?php echo isset($title) ? ' | ' . $title : null; ?></title>
	<link rel="icon" type="image/png" href="<?php echo media_url('ico/favicon.ico') ?>">
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?php echo media_url() ?>/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo media_url() ?>/css/font-awesome.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo media_url() ?>/css/AdminLTE.min.css">
   <link rel="stylesheet" href="<?php echo media_url() ?>css/jquery.toast.css">
	<link rel="stylesheet" href="<?php echo media_url() ?>/css/style.css">
	<link rel="stylesheet" href="<?php echo media_url() ?>/css/frontend-style.css">
	<link rel="stylesheet" href="<?php echo media_url() ?>/css/load-font-googleapis.css">
	<link rel="stylesheet" href="<?php echo media_url() ?>DataTables/css/dataTables.bootstrap.css">
   <link rel="stylesheet" href="<?php echo media_url() ?>DataTables/css/jquery.dataTables.css">
   
   <link href="<?php echo media_url() ?>/css/select2/dist/css/select2.min.css" rel="stylesheet" />

	<script src="<?php echo media_url() ?>/js/jquery.min.js"></script>
   <script src="<?php echo media_url() ?>DataTables/js/jquery.dataTables.js"></script>
    <script src="<?php echo media_url() ?>/css/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo media_url() ?>js/jquery.toast.js"></script>
	

</head>
<body>
		<header>
			<a class="navbar-brand" href="<?php echo base_url(); ?>">
				<?php if (isset($setting_logo) AND $setting_logo['setting_value'] != NULL) { ?>
				<img src="<?php echo upload_url('school/' . $setting_logo['setting_value']) ?>" style="height: 40px; margin-top: -10px;" class="pull-left">
				<?php } else { ?>
				<img src="<?php echo media_url('img/logo.svg') ?>" style="height: 40px; margin-top: -10px; margin-right: 5px;" class="pull-left">
				<?php } ?>
            </a>
            <font size="4">
            <b>
                <?php echo $this->config->item('app_name') . ' ' . $setting_school['setting_value'] ?>
            </b>
            </font>
            <br>
            <font size="">
                <?php
                    echo $setting_address['setting_value'].' '.$setting_district['setting_value'].' - '.$setting_city['setting_value'].' Telp. '.$setting_phone['setting_value']
                ?>
            </font>
		</header>


		
        <?php isset($main) ? $this->load->view($main) : null; ?>
		<?php $this->load->view('frontend/footer') ?>

		<script src="<?php echo media_url() ?>/js/bootstrap.min.js"></script>
	</body>
	</html>


    <script>
    	$(document).ready(function(){
    		$('#dtable').DataTable();
    	});
    </script>
    
    <script>
        $(document).ready(function(){
            $(".select2").select2();
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