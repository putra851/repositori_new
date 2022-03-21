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
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<?php if($this->session->userdata('uroleid') == '1' OR $this->session->userdata('uroleid') == '3'){ ?>
						<a href="<?php echo site_url('manage/users/add') ?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</a>
                        <?php } ?>
						<?php 
						    if($this->session->userdata('umajorsid') == '0'){
						        if($this->session->userdata('uroleid') == '1' OR $this->session->userdata('uroleid') == '3'){
						?>
						<a href="<?php echo site_url('manage/users/role') ?>" class="btn btn-sm btn-danger"><i class="fa fa-cogs"></i> Role</a>
                        <?php 
						        }
                            } 
                        ?>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
						<table id="dtable" class="table table-hover">
						    <thead>
							<tr>
								<th>No</th>
								<th>Email</th>
								<th>Nama</th>
								<th>Hak Akses</th>
								<th>Unit Sekolah</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($user)) {
									$i = 1;
									foreach ($user as $row):
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row['user_email']; ?></td>
											<td><?php echo $row['user_full_name']; ?></td>
											<td><?php echo $row['role_name']; ?></td>
											<td><?php echo ($row['user_majors_id'] == '0') ? 'Semua Unit Sekolah' : $row['majors_short_name']; ?></td>
											<td>
											    <?php if ($this->session->userdata('uroleid')=='1') { ?>
												<a href="<?php echo site_url('manage/users/view/' . $row['user_id']) ?>" class="btn btn-xs btn-info" data-toggle="tooltip" title="Lihat"><i class="fa fa-eye"></i></a>

												<?php if ($this->session->userdata('uroleid') == '1') { ?>
												<a href="<?php echo site_url('manage/users/rpw/' . $row['user_id']) ?>" class="btn btn-xs btn-warning"><i class="fa fa-lock" data-toggle="tooltip" title="Reset Password"></i></a>
												<?php } else {
													?>
													<a href="<?php echo site_url('manage/profile/cpw/'); ?>" class="btn btn-xs btn-warning"><i class="fa fa-rotate-left" data-toggle="tooltip" title="Ubah Password"></i></a>
													<?php } ?>
											    <?php if ($this->session->userdata('uroleid') == '1') { ?>
													<a href="#delModal<?php echo $row['user_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
													<?php } ?>
													<?php } ?>
												</td>	
											</tr>
											<div class="modal modal-default fade" id="delModal<?php echo $row['user_id']; ?>">
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
																<?php echo form_open('manage/users/delete/' . $row['user_id']); ?>
																<input type="hidden" name="delName" value="<?php echo $row['user_full_name']; ?>">
																<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
																<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
																<?php echo form_close(); ?>
															</div>
														</div>
														<!-- /.modal-content -->
													</div>
													<!-- /.modal-dialog -->
												</div>
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
							</div>
							<!-- /.box -->
						</div>
					</div>
				</section>
				<!-- /.content -->
			</div>