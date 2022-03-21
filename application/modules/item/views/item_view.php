<script type="text/javascript" src="<?php echo media_url('js/jquery-migrate-3.0.0.min.js') ?>"></script>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
			<small>Detail</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>
	<section class="content">
		<div class="row"> 
			<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo $title . ' '. $judul; ?></h3>
					</div><!-- /.box-header -->
					<div class="box-body">
					    
    					
					    <div class="nav-tabs-custom">
					        
    						<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPendapatan"><i class="fa fa-plus"></i> Tambah Akun Pendapatan</button>
    						
        					<div class="box-body table-responsive">
        						<table class="table table-hover">
        						    <thead>
            							<tr>
            								<th>No</th>
            								<th>Kode Akun</th>
            								<th>Nama Akun</th>
            								<th>Aksi</th>
            							</tr>
        							</thead>
        							<tbody>
        							    <?php 
        							    $no = 1;
        							    foreach ($debit_list as $row) :
        							    ?>
            							<tr>
            							    <td><?php echo $no++ ?></td>
            							    <td><?php echo $row['account_code'] ?></td>
            							    <td><?php echo $row['account_description'] ?></td>
            							    <td>
            							        <a href="#delModalDebit<?php echo $row['pos_debit_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
            							    </td>
            							</tr>
            							
								<div class="modal modal-default fade" id="delModalDebit<?php echo $row['pos_debit_id']; ?>">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span></button>
													<h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
												</div>
												<div class="modal-body">
													<p>Apakah anda yakin akan menghapus data ini?</p>
												</div>
												<div class="modal-footer">
													<?php echo form_open('manage/item/delete_debit/' . $row['pos_debit_id']); ?>
												<input type="hidden" name="item_id" value="<?php echo $this->uri->segment('4')?>">
													<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
													<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
													<?php echo form_close(); ?>
												</div>
											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
        							    <?php endforeach ?>
        						    </tbody>
        					    </table>
        				    </div>
        				    
        				    <br>
            				    
    						<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addBeban"><i class="fa fa-plus"></i> Tambah Akun Beban</button>
    						
        					<div class="box-body table-responsive">
        						<table class="table table-hover">
        						    <thead>
        							<tr>
        								<th>No</th>
        								<th>Kode Akun</th>
        								<th>Nama Akun</th>
        								<th>Aksi</th>
        							</tr>
        							</thead>
        							<tbody>
        							    <?php 
        							    $no = 1;
        							    foreach ($kredit_list as $row) :
        							    ?>
            							<tr>
            							    <td><?php echo $no++ ?></td>
            							    <td><?php echo $row['account_code'] ?></td>
            							    <td><?php echo $row['account_description'] ?></td>
            							    <td>
                				            <a href="#delModalKredit<?php echo $row['pos_kredit_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
                						    </td>
            							</tr>
            							
									<div class="modal modal-default fade" id="delModalKredit<?php echo $row['pos_kredit_id']; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span></button>
														<h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
													</div>
													<div class="modal-body">
														<p>Apakah anda yakin akan menghapus data ini?</p>
													</div>
													<div class="modal-footer">
														<?php echo form_open('manage/item/delete_kredit/' . $row['pos_kredit_id']); ?>
													<input type="hidden" name="item_id" value="<?php echo $this->uri->segment('4')?>">
														<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
														<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
														<?php echo form_close(); ?>
													</div>
												</div>
												<!-- /.modal-content -->
											</div>
											<!-- /.modal-dialog -->
										</div>
            							
        							    <?php endforeach ?>
        						    </tbody>
        					    </table>
        				    </div>
							</div>
						
						<a class="btn btn-default btn-sm" href="<?php echo site_url('manage/item') ?>"><span class="glyphicon glyphicon-repeat"></span> Kembali</a>
					</div>
				</div><!-- /.box-body -->
		</div>
	    </div>
	    

		<!-- Modal -->
		<div class="modal fade" id="addPendapatan" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Tambah Akun POS</h4>
					</div>
					<?php echo form_open('manage/item/add_glob_debit', array('method'=>'post')); ?>
					<div class="modal-body">
					    <input type="hidden" name="item_id" value="<?php echo $this->uri->segment('4')?>">
						<div id="p_scents_akun_debit">
							<p>
								<label>Akun Pendapatan</label>
								<select required="" name="item_account_id[]" class="form-control">
								    <option value="">-Pilih Akun Pendapatan-</option>
								    <?php foreach($account_debit as $row){?>
								        <option value="<?php echo $row['account_id'] ?>"><?php echo $row['account_code'] . '-' . $row['account_description'] ?></option>
								    <?php } ?>
								</select>
							</p>
						</div>
						<h6 ><a href="#" class="btn btn-xs btn-success" id="addScnt_akun_debit"><i class="fa fa-plus"></i><b> Tambah Baris</b></a></h6>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Simpan</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="addBeban" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Tambah Akun POS</h4>
					</div>
					<?php echo form_open('manage/item/add_glob_kredit', array('method'=>'post')); ?>
					<div class="modal-body">
					    <input type="hidden" name="item_id" value="<?php echo $this->uri->segment('4')?>">
						<div id="p_scents_akun_kredit">
							<p>
								<label>Akun Beban</label>
								<select required="" name="item_account_id[]" class="form-control">
								    <option value="">-Pilih Akun Beban-</option>
								    <?php foreach($account_kredit as $row){?>
								        <option value="<?php echo $row['account_id'] ?>"><?php echo $row['account_code'] . '-' . $row['account_description'] ?></option>
								    <?php } ?>
								</select>
							</p>
						</div>
						<h6 ><a href="#" class="btn btn-xs btn-success" id="addScnt_akun_kredit"><i class="fa fa-plus"></i><b> Tambah Baris</b></a></h6>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Simpan</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
		
    </section>
</div>

	<script>
		$(function() {
			var scntDiv = $('#p_scents_akun_debit');
			var i = $('#p_scents_akun_debit p').size() + 1;

			$("#addScnt_akun_debit").click(function() {
				$('<p><label>Akun Pendapatan</label><select required="" name="item_account_id[]" class="form-control"><option value="">-Pilih Akun Pendapatan-</option><?php foreach($account_debit as $row){?><option value="<?php echo $row['account_id'] ?>"><?php echo $row['account_code'] . "-" . $row['account_description'] ?></option><?php } ?></select><a href="#" class="btn btn-xs btn-danger remScnt_akun_debit">Hapus Baris</a></p>').appendTo(scntDiv);
				i++;
				return false;
			});

			$(document).on("click", ".remScnt_akun_debit", function() {
				if (i > 2) {
					$(this).parents('p').remove();
					i--;
				}
				return false;
			});
		});
	</script>
	
	<script>
		$(function() {
			var scntDiv = $('#p_scents_akun_kredit');
			var i = $('#p_scents_akun_kredit p').size() + 1;

			$("#addScnt_akun_kredit").click(function() {
				$('<p><label>Akun Beban</label><select required="" name="item_account_id[]" class="form-control"><option value="">-Pilih Akun Beban-</option><?php foreach($account_kredit as $row){?><option value="<?php echo $row['account_id'] ?>"><?php echo $row['account_code'] . "-" . $row['account_description'] ?></option><?php } ?></select><a href="#" class="btn btn-xs btn-danger remScnt_akun_kredit">Hapus Baris</a></p>').appendTo(scntDiv);
				i++;
				return false;
			});

			$(document).on("click", ".remScnt_akun_kredit", function() {
				if (i > 2) {
					$(this).parents('p').remove();
					i--;
				}
				return false;
			});
		});
	</script>