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
				<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Filter Rekap Presensi Di Web</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'post')) ?>
							<div class="form-group">						
								<label for="" class="col-sm-2 control-label">Periode</label>
								<div class="col-sm-2">
									<input type="date" class="form-control" name="tgl_awal" value="<?=$tgl_awal?>" required=""/>
								</div>
								<div class="col-sm-2">
									<input type="date" class="form-control" name="tgl_akhir" value="<?=$tgl_akhir?>" required=""/>
								</div>
								<div class="col-sm-2">
									<select id="m" name="m" class="form-control" required="">
    								    <option value="">--- Pilih Unit Sekolah ---</option>
            						    <?php foreach($majors as $row){?>
            						        <option value="<?php echo $row['majors_id']; ?>" <?php echo (isset($f['m']) && $f['m'] == $row['majors_id'] || !isset($f['m']) && $row['majors_id']==1) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
            						    <?php } ?>
    								    <option value="99">Lainnya</option>
    								</select>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Cari</button>
								</div>
							</div>
						</form>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
				<?php
				if($f){
				?>
				<div class="box"> 
					<div class="box-header">
						<?php if ($this->session->userdata('uroleid') != USER) { ?>
						<table>
						    <tr>
        					    <td>
            						<a href="<?php echo site_url('manage/rekap_presensi/export_excel') ?>?tgl_awal=<?=$tgl_awal?>&tgl_akhir=<?=$tgl_akhir?>&majors_id=<?=$f['m']?>" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-file-excel-o"></i> Export Excel</a>
        					    </td>
								<td>&nbsp;</td>
        					    <td>
            						<a href="<?php echo site_url('manage/rekap_presensi/export_pdf') ?>?tgl_awal=<?=$tgl_awal?>&tgl_akhir=<?=$tgl_akhir?>&majors_id=<?=$f['m']?>" class="btn btn-sm btn-danger" target="_blank"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
        					    </td>
								<td>&nbsp;</td>
        					    <td>
            						<a href="javascript:open_window('<?php echo site_url('manage/rekap_presensi/rekap?tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&majors_id='.$f['m'].'') ?>')" class="btn btn-sm btn-info"><i class="fa fa-list"></i> Rekap Absensi</a>
        					    </td>
								<td>&nbsp;</td>
        					    <td>
            						<a href="<?php echo site_url('manage/rekap_presensi/add') ?>?majors_id=<?=$f['m']?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Presensi WEB</a>
        					    </td>
						    </tr>      
						</table>
						<?php } ?>
					</div>
						
						
						<!-- /.box-header -->
						<div class="box-body table-responsive">
							<table id="dtable" class="table table-hover">
							    <thead>
								<tr>
									<th>No</th>
									<th>Pegawai</th>
									<th>Jenis Absen</th>
									<th>Tanggal</th>
									<th>Time</th>
									<th>Area Absen</th>
									<th>Titik Absen</th>
									<th>Foto</th>
									<th>Catatan Absen</th>
									<th>Aksi</th>
								</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($rekap_presensi)) {
										$i = 1;
										foreach ($rekap_presensi as $row):
											?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $row['nama_pegawai']; ?></td>
												<td><?php echo $row['jenis_absen']; ?></td>
												<td><?php echo $row['tanggal']; ?></td>
												<td><?php echo $row['time']; ?></td>
												<td><?php echo $row['area_absen_nama']; ?></td>
												<td><?php echo '<b><a href="javascript:void(0)" onclick="maps_area(\''.$row['longi'].'\',\''.$row['lati'].'\',null)" data-toggle="tooltip" title="Maps Area">Longi : "'.$row['longi'].'" || Lati : "'.$row['lati'].'"</a></b>'; ?></td>
												<td>
												<?php if (!empty($row['foto'])) { ?>
													<img src="<?php echo upload_url($row['foto']) ?>" onclick="open_foto('<?php echo upload_url($row['foto']) ?>')" style="cursor:pointer;width:50px;height:50px" class="img-thumbnail img-responsive">
												<?php } else { ?>
												Tidak Ada Foto
												<?php } ?>
												</td>
												<td><?php echo $row['catatan_absen']; ?></td>
												<td>
													<a href="<?php echo site_url('manage/rekap_presensi/view/' . $row['id']) ?>" class="btn btn-xs btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
												</td>	
											</tr>
											<?php
											$i++;
										endforeach;
									} else {
										?>
										<tr id="row">
											<td colspan="10" align="center">Data Kosong</td>
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
						<?php }?>
					</div>
				</div>
		</section>
		<!-- /.content -->
	</div>
<script>
function maps_area(longi,lati,nama) {    
  newWindow("<?php echo base_url()?>manage/presensi_data_area/maps_area_global?longi="+longi+"&lati="+lati+"&nama="+nama+"", "popup","1800","1600","resizable=0,scrollbars=1,status=0,toolbar=0") 
}
function open_foto(url) {    
  newWindow(""+url+"", "popup","300","400","resizable=0,scrollbars=1,status=0,toolbar=0") 
}
function open_window(url) {    
  newWindow(""+url+"", "popup","1800","1600","resizable=0,scrollbars=1,status=0,toolbar=0") 
}
</script>