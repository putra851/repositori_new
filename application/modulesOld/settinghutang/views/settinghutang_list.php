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
						<a href="<?php echo site_url('manage/settinghutang/add') ?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</a>
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
							    <th>No.</th>
								<th>POS Hutang</th>
								<th>Nama Hutang</th>
								<th>Tahun</th>
								<th>Jumlah Hutang</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;
								if (!empty($settinghutang)) {
									foreach ($settinghutang as $row):
										?>
										<tr>
										    <td><?php echo $no++ ?></td>
											<td><?php echo $row['poshutang_name']; ?></td>
											<td><?php echo $row['poshutang_name'].' - T.A '.$row['period_start'].'/'.$row['period_end']; ?></td>
											<td><?php echo $row['period_start'].'/'.$row['period_end']; ?></td>
											<td>
											<a data-toggle="tooltip" data-placement="top" title="Ubah"
											class="btn btn-primary btn-xs"
											href="<?php echo site_url('manage/settinghutang/view_hutang/' . $row['settinghutang_id']) ?>">
											Setting Jumlah Hutang
										</a>
									</td>


									<td>
										<a href="<?php echo site_url('manage/settinghutang/edit/' . $row['settinghutang_id']) ?>" class="btn btn-xs btn-success" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>

									</td>	
								</tr>
								<?php
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