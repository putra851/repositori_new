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
						<?php if ($this->session->userdata('uroleid') != USER) { ?>
						<table>
						    <tr>
						        <td>    
            						<a href="<?php echo site_url('manage/presensi_khusus/add') ?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</a>
        					    </td>
        					    <td>
            						<a href="<?php echo site_url('manage/presensi_khusus/export_excel') ?>" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-file-excel-o"></i> Export Excel</a>
            						<?php } ?>
        					    </td>
						    </tr>      
						</table>
						
						
					</div>
						
						
						<!-- /.box-header -->
						<div class="box-body table-responsive">
							<table id="dtable" class="table table-hover">
							    <thead>
								<tr>
									<th>No</th>
									<th>Tanggal</th>
									<th>Nama Pegawai</th>
									<th>Lokasi Absen</th>
									<th>Keterangan</th>
									<th>Aksi</th>
								</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($presensi_khusus)) {
										$i = 1;
										foreach ($presensi_khusus as $row):
											?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $row['tanggal']; ?></td>
												<td><?php echo $row['nama_pegawai']; ?></td>
												<td><?php echo '<b><a href="javascript:void(0)" onclick="maps_area(\''.base64_encode($row['lokasi_absen']).'\')" data-toggle="tooltip" title="Maps Area">'.$row['nama_area']."</a></b>"; ?></td>
												<td><?php echo $row['remark']; ?></td>
												<td>
													<a href="<?php echo site_url('manage/presensi_khusus/view/' . $row['id']) ?>" class="btn btn-xs btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
													<?php if ($this->session->userdata('uroleid') != USER) { ?>
													<a href="<?php echo site_url('manage/presensi_khusus/edit/' . $row['id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
													<?php } ?>
													<a href="#delModal<?php echo $row['id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash-o"></i></a>
												</td>	
											</tr>
											<div class="modal modal-default fade" id="delModal<?php echo $row['id']; ?>">
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
															<?php echo form_open('manage/presensi_khusus/delete/' . $row['id']); ?>
															<input type="hidden" name="delName" value="<?php echo $row['nama_pegawai']; ?>">
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
						<?php echo $this->pagination->create_links(); ?>
						</div>
						<!-- /.box -->
					</div>
				</div>
		</section>
		<!-- /.content -->
	</div>
<script>
function maps_area(id_area) {    
  newWindow("<?php echo base_url()?>manage/presensi_data_area/maps_area?id_area="+id_area+"", "popup","1800","1600","resizable=0,scrollbars=1,status=0,toolbar=0") 
}
</script>