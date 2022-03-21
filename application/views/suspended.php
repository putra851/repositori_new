<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Epesantren | Portal</title>
	<link rel="icon" type="image/png" href="<?php echo media_url('ico/favicon.ico') ?>">

	<!-- Bootstrap Core CSS -->
	<link href="<?php echo media_url() ?>/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo media_url() ?>/css/load-font-googleapis.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo media_url() ?>/css/font-awesome.min.css">


	<!-- Custom CSS -->
	<link href="<?php echo media_url() ?>/css/frontend-style.css" rel="stylesheet">
	<link href="<?php echo media_url() ?>/css/portal.css" rel="stylesheet">

</head>

<body>

    	<!-- Home -->
	<section class="content-section">
		<div class="container text-center">
			<div class="row">
				<div class="col-md-12">
				    
				    <?php 
				    $this->load->model('setting/Setting_model');
				    $school = $this->Setting_model->get(array('id'=>1)); ?>
					<h1>Mohon maaf Aplikasi ePesantren <?php echo $school['setting_value'] ?> <br> untuk sementara non-aktif, karena ada masalah administrasi.<p>Terima kasih &#128522;
					</h1>
				</div>
			</div>
		</div>
	</section>


</body>

</html>
