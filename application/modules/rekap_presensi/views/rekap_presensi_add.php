<div class="content-wrapper"> 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li><a href="<?php echo site_url('manage/rekap_presensi') ?>">Manage Presensi</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>

	<!-- Main content -->
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
    						
    						<div class="form-group">
    							<label>Jenis <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    							<select name="type" id="type" class="form-control s2" style="width:100%">
									<option value="">--Pilih Jenis--</option>
									<option value="DATANG">Datang</option>
									<option value="PULANG">Pulang</option>
									<option value="SAKIT">Sakit</option>
									<option value="IJIN">Ijin</option>
									<option value="CUTI">Cuti</option>
								</select>
    						</div> 
    						<div class="form-group">
    							<label>Pegawai <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    							<select name="id_pegawai" id="id_pegawai" class="form-control s2" style="width:100%">
									<option value="">--Pilih Pegawai--</option>
									<?php
									foreach($employee as $e):
									?>
									<option value="<?=$e['employee_id']?>"><?=$e['employee_name']?></option>
									<?php
									endforeach;
									?>
								</select>
    						</div> 
    						<div class="form-group">
    							<label>Ambil Foto <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
								<div id="my_camera"></div>
								<br/>
								<button type="button" class="btn btn-info" onClick="take_snapshot()"><i class="fa fa-camera"></i>&nbsp;Ambil Foto</button>
								<input type="hidden" name="image" class="image-tag">
    						</div>
    						<div class="form-group">
								<div id="results">Your captured image will appear here...</div>
    						</div>
    						<div class="form-group">
								<label>Lokasi <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
								<p id="demo"></p>
								<input type="hidden" name="longi" id="longi" />
								<input type="hidden" name="lati" id="lati" />
    						</div>
    						<div class="form-group">
    							<label>Catatan Absen</label>
								<textarea name="keterangan" class="form-control" placeholder="Catatan Absen"></textarea>
    						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-success">Simpan</button>
							<a href="<?php echo site_url('manage/rekap_presensi'); ?>" class="btn btn-danger">Batal</a>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script language="JavaScript">
    Webcam.set({
		width: 500,
        height: 300,
        image_format:'jpeg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
			Webcam.upload( data_uri, '<?php echo site_url('rest-api/uploadImage.php'); ?>', function(code, text) {
				$(".image-tag").val(text);
			});
        });
    }
</script>
<script>
var x = document.getElementById("demo");

if (navigator.geolocation) {
	navigator.geolocation.getCurrentPosition(showPosition);
} else { 
	x.innerHTML = "Geolocation is not supported by this browser.";
}

function showPosition(position) {
  x.innerHTML = "Latitude: " + position.coords.latitude + 
  "<br>Longitude: " + position.coords.longitude;

  $("#longi").val(position.coords.longitude);
  $("#lati").val(position.coords.latitude);
}
</script>