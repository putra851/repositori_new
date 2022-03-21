<script type="text/javascript" src="<?php echo media_url('js/jquery-migrate-3.0.0.min.js') ?>"></script>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
			<small>List</small>
		</h1> 
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header">
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addPos"><i class="fa fa-plus"></i> Tambah</button>
							<br>
							<br>
							
					<div class="box-body table-responsive">
							<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
							<table>
							    <tr>
							        <td>     
    								<select style="width: 200px;" id="m" name="m" class="form-control" required>
    								    <option value="">--- Pilih Unit Sekolah ---</option>
    								    <?php if($this->session->userdata('umajorsid') == '0') { ?>
    								    <option value="all" <?php echo (isset($s['m']) && $s['m']=='all') ? 'selected' : '' ?> >Semua Unit</option>
    								    <?php } ?>
            						    <?php foreach($majors as $row){?>
            						        <option value="<?php echo $row['majors_id']; ?>" <?php echo (isset($s['m']) && $s['m'] == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
            						    <?php } ?>
    								</select>
							        </td>
							        <td>
							            &nbsp&nbsp
							        </td>
							        <td>
							        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>    
							        </td>
							    </tr>
							</table>
							<?php echo form_close(); ?>
							</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive">
						<table id="dtable" class="table table-hover">
						    <thead>
							<tr>
								<th>No</th>
								<th>Kode Akun</th>
								<th>Akun Piutang</th>
								<th>Nama POS</th>
								<th>Keterangan</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($pos)) {
									$i = 1;
									foreach ($pos as $row):
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row['account_code']." - ".$row['account_description']; ?></td>
											<td><?php echo $row['piutang_code']." - ".$row['piutang_description']; ?></td>
											<td><?php echo $row['pos_name']; ?></td>
											<td><?php echo $row['pos_description']; ?></td>
											<td>
												<a href="<?php echo site_url('manage/pos/edit/' . $row['pos_id']) ?>" class="btn btn-xs btn-success" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
											</td>	
										</tr>
										<?php
										$i++;
									endforeach;
								} else {
									?>
									<tr id="row">
										<td colspan="6" align="center">Data Kosong</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<!-- /.box-body -->
					</div>
					<div>
						<?php echo $this->pagination->create_links(); ?>
					</div>
					<!-- /.box -->
				</div>
			</div>
		</section>
		<!-- /.content -->
	</div>

	<!-- Modal -->
	<div class="modal fade" id="addPos" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Tambah POS Pembayaran</h4>
				</div>
				<?php echo form_open('manage/pos/add_glob', array('method'=>'post')); ?>
				<div class="modal-body">
					<div id="p_scents_pos">
						<div class="row">
							<div class="col-md-12">
							    <div class="form-group">
								<label>Kode Akun</label>
								<select required="" name="account_account_id[]" class="form-control">
								    <option value="">-Pilih Kode Akun-</option>
								    <?php foreach($account as $row){?>
								        <option value="<?php echo $row->account_id ?>"><?php echo $row->account_code.' - '.$row->account_description ?></option>
								    <?php } ?>
								</select>
								</div>
							</div>
							<div class="col-md-12">
							    <div class="form-group">
								<label>Akun Piutang</label>
								<select required="" name="piutang_account_id[]" class="form-control">
								    <option value="">-Pilih Akun Piutang-</option>
								    <?php foreach($piutang as $row){?>
								        <option value="<?php echo $row->account_id ?>"><?php echo $row->account_code.' - '.$row->account_description ?></option>
								    <?php } ?>
								</select>
								</div>
							</div>
							<div class="col-md-12">
							    <div class="form-group">
								<label>Nama POS</label>
								<input type="text" required="" name="pos_name[]" class="form-control" placeholder="Contoh: SPP">
								</div>
							</div>
							<div class="col-md-12">
							    <div class="form-group">
								<label>Keterangan</label>
								<input type="text" required="" name="pos_description[]" class="form-control" placeholder="Contoh: Sumbangan Pendidikan">
								</div>
							</div>
							
						</div>
						
						<!--<button class="btn btn-xs btn-success" id="addScnt_pos"><i class="fa fa-plus"> Tambah Baris</i></button>-->
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>


<script>
	$(function() {
		var scntDiv = $('#p_scents_pos');
		var i = $('#p_scents_pos .row').size() + 1;

		$("#addScnt_pos").click(function() {
			$('<div class="row"><div class="col-md-12"><div class="form-group"><label>Kode Akun</label><select required="" name="account_account_id[]" class="form-control"><option value="">-Pilih Kode Akun-</option><?php foreach($account as $row){?><option value="<?php echo $row->account_id ?>"><?php echo $row->account_code.' - '.$row->account_description ?></option><?php } ?></select><a href="#" class="btn btn-xs btn-danger remScnt_pos">Hapus Baris</a></div></div><div class="col-md-12"><div class="form-group"><label>Akun Piutang</label><select required="" name="piutang_account_id[]" class="form-control"><option value="">-Pilih Akun Piutang-</option><?php foreach($piutang as $row){?><option value="<?php echo $row->account_id ?>"><?php echo $row->account_code.' - '.$row->account_description ?></option><?php } ?></select></div></div><div class="col-md-12"><div class="form-group"><label>Nama POS</label><input type="text" required="" name="pos_name[]" class="form-control" placeholder="Contoh: SPP"></div></div><div class="col-md-12"><div class="form-group"><label>Keterangan</label><input type="text" required="" name="pos_description[]" class="form-control" placeholder="Contoh: Sumbangan Pendidikan"></div></div></div>').appendTo(scntDiv);
			i++;
			return false;
		});

		$(document).on("click", ".remScnt_pos", function() {
			if (i > 2) {
				$(this).parents('.row').remove();
				i--;
			}
			return false;
		});
	});
</script>