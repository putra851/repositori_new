
<div class="content-wrapper"> 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li><a href="<?php echo site_url('manage/presensi_waktu') ?>">Manage Data Libur Presensi</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<?php echo form_open_multipart(current_url()); ?>
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<!-- /.box-header -->
					<div class="box-body">
    						<?php echo validation_errors(); ?>
    						<?php if (isset($majors)) { ?>
    							<input type="hidden" name="data_waktu_majors_id" value="<?php echo $majors['majors_id']; ?>">
    						<?php } ?>
    						
    						<div class="form-group">
    							<label>Unit</label>
    							<input type="text" class="form-control" value="<?php echo $majors['majors_short_name']; ?>" disabled>
            				</div>
    						
							<?php
							    $majors_id = $majors['majors_id'];
							    foreach($day as $d):
							    $day_id = $d['day_id'];
							    $waktu = $this->db->query("SELECT data_waktu_masuk, data_waktu_pulang FROM data_waktu WHERE data_waktu_day_id = '$day_id' AND data_waktu_majors_id = '$majors_id'")->row_array();
							?>
							
    						<div class="row">
    						    
    						    <div class="col-md-4">
            						<div class="form-group">
            							<label>Hari <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
            							<input type="hidden" name="data_waktu_day_id[]" id="data_waktu_day_id" value="<?=$d['day_id']?>" class="form-control">
            							<input type="text" class="form-control" value="<?=$d['day_name']?>" disabled>
            						</div> 
    						    </div>
    						    
    						    <div class="col-md-4">
            						<div class="form-group">
            							<label>Jam Masuk</label>
        								<input type="time" name="data_waktu_masuk[]" class="form-control" placeholder="Jam Masuk" value="<?=$waktu['data_waktu_masuk']?>">
            						</div>  
    						    </div>
    						    
    						    <div class="col-md-4">
    						        <div class="form-group">
            							<label>Jam Pulang</label>
        								<input type="time" name="data_waktu_pulang[]" class="form-control" placeholder="Jam Pulang" value="<?=$waktu['data_waktu_pulang']?>">
            						</div>  
    						    </div>
    						</div>
    						
							<?php
							endforeach;
							?>
    						
    						<div class="form-group">
    							<button type="submit" class="btn btn-success">Simpan</button>
    							<a href="<?php echo site_url('manage/presensi_waktu'); ?>" class="btn btn-danger">Batal</a>
    						</div>
    						
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>