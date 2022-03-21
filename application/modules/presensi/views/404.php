<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h1 class="headline text-green"> Mohon Maaf</h1>
        <br><br><br><br><br><br>
        <h3>Fitur ini tidak tersedia untuk versi demo.</h3>   
      </div>
      <!-- /.error-page -->
    </section>
</div>