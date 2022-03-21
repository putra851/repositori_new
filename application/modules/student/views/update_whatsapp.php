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
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<!-- /.box-header -->
					<div class="box-body table-responsive">
						<h4>Petunjuk Singkat</h4>
						<p>Penginputan No. Whatsapp Ortu Siswa bisa dilakukan dengan mengcopy data dari file Ms. Excel. Format file excel harus sesuai kebutuhan aplikasi. Silahkan download formatnya <a data-toggle="modal" data-target="#template_wa"><span class="label label-success">Disini</span></a>
							<br><br>
							<strong>CATATAN :</strong>
							<ol>
							    <li>
							        Pengisian <strong>No. Whatsapp Ortu</strong>  diisi dengan format <strong>62 + No. Whatsapp Ortu</strong> Contoh <strong>6281234567890</strong>
							    </li>
							    <li>
							        Setelah selesai mengisi save as file excel ke format excel 2003-2007
							    </li>
							</ol>
						</p>
						<hr>
                         <div class="col-md-4">
						<?php echo form_open_multipart('manage/student/update_phone') ?>
                        
                        <div class="box-body">
						<div class="form-group">
						    <label>Masukkan File (.xls)</label>
							<input type="file" name="file" required="">
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-success btn-sm btn-flat">Update</button>
							<a href="<?php echo site_url('manage/student') ?>" class="btn btn-info btn-sm btn-flat">Kembali</a>
						</div>
						</div>
						<?php echo form_close() ?>
                        </div>
					</div>
					<!-- /.box-body -->
				</div>

				<!-- /.box -->
			</div>
		</div>
		
	
	<div class="modal fade" id="template_wa" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Download Template Excel</h4>
				</div>
				<form action="<?php echo base_url();?>manage/student/download_wa" method="post" target="_blank">
				<div class="modal-body">
					<label>Unit Sekolah</label>
					<select required="" name="xls_majors" id="xls_majors" class="form-control" onchange="get_xls_class()">
					    <option value="all">-Unit Sekolah-</option>
					    <?php foreach($majors as $row){?>
					        <option value="<?php echo $row['majors_id'] ?>"><?php echo $row['majors_short_name'] ?></option>
					    <?php } ?>
					</select>
					<label>Kelas</label>
					<div id="div_class_xls">
					<select required="" name="xls_class" id="xls_class" class="form-control">
					    <option value="">-Pilih Kelas-</option>
					</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success"><i class="fa fa-excel-o"></i> Download</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	</section>
	<!-- /.content -->
</div>

<script>
    function get_xls_class(){
        var id_majors    = $("#xls_majors").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/student/get_xls_class',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#div_class_xls").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
    }
</script>