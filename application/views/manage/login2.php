<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login ePesantren</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="<?php echo media_url('ico/favicon.ico') ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo media_url() ?>login/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo media_url() ?>login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo media_url() ?>login/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo media_url() ?>login/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="<?php echo media_url() ?>login/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo media_url() ?>login/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo media_url() ?>login/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo media_url() ?>login/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="<?php echo media_url() ?>login/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo media_url() ?>login/css/main.css">

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-25 p-b-20">
				<?php echo form_open('manage/auth/login', array('class'=>'login100-form validate-form')); ?>
					<span class="login100-form-title p-b-30">
						<p class="merk"><span style="color: #45a65a">SIM Pengelolaan</span> Pesantren</p> 
                              <?php if (isset($setting_school) AND $setting_school['setting_value'] == '-') { ?>
                              <p class="school">Mengelola Administrasi Pesantren Online</p> 
                              <?php } else { ?>
                              <p class="school"><?php echo $setting_school['setting_value'] ?></p> 
                              <?php } ?>
					</span>
					<span class="login100-form-avatar">
                        <?php if (isset($setting_logo) AND $setting_logo['setting_value'] == NULL) { ?>
                        <img src="<?php echo media_url('img/logo.svg') ?>" class="img-responsive">
                        <?php } else { ?>
                        <img src="<?php echo upload_url('school/' . $setting_logo['setting_value']) ?>" class="img-responsive">
                        <?php } ?>
					</span>

					<div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "Masukkan Username">
						<input class="input100" type="email" name="email">
						<span class="focus-input100" data-placeholder="Masukkan Email"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-50" data-validate="Masukkan Password">
						<input class="input100" type="password" name="password">
						<span class="focus-input100" data-placeholder="Masukkan Password"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<button class="login100-form-btn">
							Kembali
						</button>
					</div>
					
				
        <?php echo form_close(); ?>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	

	<script scr="<?php echo media_url() ?>login/vendor/jquery/jquery-3.2.1.min.js"></script>

	<script scr="<?php echo media_url() ?>login/vendor/animsition/js/animsition.min.js"></script>

	<script scr="<?php echo media_url() ?>login/vendor/bootstrap/js/popper.js"></script>
	<script scr="<?php echo media_url() ?>login/vendor/bootstrap/js/bootstrap.min.js"></script>

	<script scr="<?php echo media_url() ?>login/vendor/select2/select2.min.js"></script>

	<script scr="<?php echo media_url() ?>login/vendor/daterangepicker/moment.min.js"></script>
	<script scr="<?php echo media_url() ?>login/vendor/daterangepicker/daterangepicker.js"></script>

	<script scr="<?php echo media_url() ?>login/vendor/countdowntime/countdowntime.js"></script>

	<script scr="<?php echo media_url() ?>login/js/main.js"></script>
	
	


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

</body>
</html>