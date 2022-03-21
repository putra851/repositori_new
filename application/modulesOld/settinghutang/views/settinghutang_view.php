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
			<div class="col-xs-12"> 
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Jumlah - <?php echo $settinghutang['poshutang_name'].' - T.A '.$settinghutang['period_start'].'/'.$settinghutang['period_end']; ?></h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="form-group">						
							<label for="" class="col-sm-1 control-label">Tahun</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" value="<?php echo $settinghutang['period_start'].'/'.$settinghutang['period_end'] ?>" readonly="">
							</div>
							<label for="" class="col-sm-1">Setting Hutang</label>
        					<div class="col-sm-2">
        						<a class="btn btn-primary btn-sm" href="<?php echo site_url('manage/settinghutang/add_settinghutang/' . $settinghutang['settinghutang_id']) ?>"><span class="glyphicon glyphicon-plus"></span> Kepada Kreditur</a>
        					</div>
        					
        					<div class="col-sm-1">
        						<a class="btn btn-default btn-sm" href="<?php echo site_url('manage/settinghutang') ?>"><span class="glyphicon glyphicon-repeat"></span> Kembali</a>
        					</div>
						</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->

				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="dtable" class="table table-hover">
						    <thead>
							<tr>
								<th>No</th>
								<th>No. Ref</th>
								<th>Nama</th>
								<th>Posisi</th>
								<th>Hutang</th>
								<th>Jumlah Angsuran</th>
								<th>Angsuran</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								foreach ($kreditur as $row):
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['hutang_noref']; ?></td>
										<td><?php echo $row['employee_name']; ?></td>
										<td><?php echo $row['position_name']; ?></td>
										<td><?php echo 'Rp. ' . number_format($row['hutang_bill'], 0, ',', '.') ?></td> 
										<td><?php echo $row['hutang_cicil'].' Kali' ?></td> 
										<td><?php echo 'Rp. ' . number_format($row['hutang_pay_bill'], 0, ',', '.') ?></td> 
										<td>
										    <a href="<?php echo site_url('manage/settinghutang/edit_settinghutang/'. $row['hutang_settinghutang_id'].'/'.$row['hutang_employee_id'].'/'.$row['hutang_id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Ubah Jumlah Hutang"><i class="fa fa-edit"></i></a>
											<a href="<?php echo site_url('manage/settinghutang/delete_settinghutang/'. $row['hutang_settinghutang_id'].'/'.$row['hutang_employee_id'].'/'.$row['hutang_id']) ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus Hutang" onclick="return confirm('<?php echo 'Apakah anda akan menghapus hutang a.n '.$row['employee_name'].'?' ?>')"><i class="fa fa-trash"></i></a>
										</td>	
									</tr>
									<?php
									$i++;
								endforeach;
								?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>		
</section>
</div>

<div class="modal fade" id="deletePayhutang">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Konfirmasi Hapus</h4>
			</div>
			<form action="<?php echo site_url('manage/settinghutang/delete_settinghutang_hutang') ?>" method="POST">
				<div class="modal-body">
					<p>Apakah anda akan menghapus data ini?</p>
					<input type="hidden" name="settinghutang_id" id="settinghutangID">
					<input type="hidden" name="employee_id" id="employeeID">
					<input type="hidden" name="hutang_id" class="hutangID">
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
		$('#settinghutangID').val(id),
		$('#employeeID').val(id)

	}
</script>