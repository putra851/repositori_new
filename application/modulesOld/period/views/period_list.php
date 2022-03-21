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
						<a href="<?php echo site_url('manage/period/add') ?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
						<table id="dtable" class="table table-hover">
						    <thead>
							<tr>
								<th>No</th>
								<th>Tahun Ajaran</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($period)) {
									$i = 1;
									foreach ($period as $row):
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row['period_start'].'/'.$row['period_end'] ?></td>
											<td><label class="label <?php echo ($row['period_status']==1) ? 'label-success' : 'label-danger' ?>"><?php echo ($row['period_status']==1) ? 'Aktif' : 'Tidak Aktif' ?></label></td>
											<td>
												<a href="<?php echo site_url('manage/period/edit/' . $row['period_id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
												<button type="button" onclick="getId(<?php echo $row['period_id'] ?>)" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deletePeriod">
													<i class="fa fa-trash"></i>
												</button>
												<?php if($row['period_status']!=1){ ?>
													<a href="<?php echo site_url('manage/period/period_active/' . $row['period_id']) ?>" class="btn btn-xs btn-success" data-toggle="tooltip" title="Aktifkan"><i class="fa fa-check"></i></a>
												<?php } ?>
											</td>	
										</tr>
										<?php
										$i++;
									endforeach;
								} else {
									?>
									<tr id="row">
										<td colspan="4" align="center">Data Kosong</td>
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

<div class="modal fade" id="deletePeriod">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Konfirmasi Hapus</h4>
			</div>
			<form action="<?php echo site_url('manage/period/delete') ?>" method="POST">
				<div class="modal-body">
					<p>Apakah anda akan menghapus data ini?</p>
					<input type="hidden" name="period_id" id="periodID">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Hapus</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script>

	function getId(id) {
		$('#periodID').val(id)
	}
</script>