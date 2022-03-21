<?php

if (isset($settinghutang)) {

	$inputPeriodValue   = $settinghutang['settinghutang_period_id'];
	$inputPosValue      = $settinghutang['settinghutang_poshutang_id'];
	$inputMajorsValue   = $settinghutang['majors_id'];

} else {
	$inputPeriodValue   = set_value('period_id');
	$inputPosValue      = set_value('poshutang_id');
	$inputMajorsValue   = set_value('majors_id');
}
?>

<div class="content-wrapper"> 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li><a href="<?php echo site_url('manage/settinghutang') ?>">Manage Hutang</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>

	<!-- Main content -->
	<!-- Main content -->
	<section class="content">
		<?php echo form_open_multipart(current_url()); ?>
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-9">
				<div class="box box-primary">
					<!-- /.box-header -->
					<div class="box-body">
						<?php echo validation_errors(); ?>
						<?php if (isset($settinghutang)) { ?>
							<input type="hidden" name="settinghutang_id" value="<?php echo $settinghutang['settinghutang_id']; ?>">
						<?php } ?>

						<div class="form-group">
							<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select name="majors_id" id="majors_id" class="form-control" onchange="get_pos()">
								<option value="">-Pilih Unit-</option>
								<?php foreach ($majors as $row): ?> 
									<option value="<?php echo $row['majors_id']; ?>" <?php echo ($inputMajorsValue == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						
                        <div id="div_pos">
						<div class="form-group">
							<label>POS Hutang <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select name="poshutang_id" class="form-control">
								<option value="">-Pilih POS Hutang-</option>
								<?php foreach ($poshutang as $row): ?> 
									<option value="<?php echo $row['poshutang_id']; ?>" <?php echo ($inputPosValue == $row['poshutang_id']) ? 'selected' : '' ?>><?php echo $row['poshutang_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						</div>

						<div class="form-group">
							<label>Tahun Ajaran <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select name="period_id" class="form-control">
								<option value="">-Pilih Tahun-</option>
								<?php foreach ($period as $row): ?> 
									<option value="<?php echo $row['period_id']; ?>" <?php echo ($inputPeriodValue == $row['period_id']) ? 'selected' : '' ?>><?php echo $row['period_start'].'/'.$row['period_end']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<p class="text-muted">*) Kolom wajib diisi.</p>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
			<div class="col-md-3">
				<div class="box box-primary">
					<!-- /.box-header -->
					<div class="box-body">
						<button type="submit" class="btn btn-block btn-success">Simpan</button>
						<a href="<?php echo site_url('manage/settinghutang'); ?>" class="btn btn-block btn-info">Batal</a>
						<?php if (isset($settinghutang['settinghutang_id'])) { ?>
							<button type="button" onclick="getId(<?php echo $settinghutang['settinghutang_id'] ?>)" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteSettinghutang">Hapus
							</button>
						<?php } ?>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
	<?php if (isset($settinghutang['settinghutang_id'])) { ?>
		<div class="modal fade" id="deleteSettinghutang">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Konfirmasi Hapus</h4>
					</div>
					<form action="<?php echo site_url('manage/settinghutang/delete') ?>" method="POST">
						<div class="modal-body">
							<p>Apakah anda akan menghapus data ini?</p>
							<input type="hidden" name="settinghutang_id" id="settinghutangId">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-danger">Hapus</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php } ?>
</div>
<script>

	function getId(id) {
		$('#settinghutangId').val(id)
	}
	
	function get_pos(){
	    var id_majors    = $("#majors_id").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/settinghutang/get_pos',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#div_pos").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
	}
</script>