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
						<div class="row">
						<div class="col-md-9">
						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
    					<div class="box-body table-responsive">
							<table>
							    <tr>
							        <td>     
    								<select style="width: 200px;" id="m" name="m" class="form-control" required onchange="get_kelas()">
    								    <option value="">--- Pilih Unit Sekolah ---</option>
            						    <?php foreach($majors as $row){?>
            						        <option value="<?php echo $row['majors_id']; ?>" <?php echo (isset($s['m']) && $s['m'] == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
            						    <?php } ?>
    								</select>
							        </td>
							        <td>
							            &nbsp&nbsp
							        </td>
							        <td id="td_kelas">
    								<select style="width: 200px;" id="c" name="c" class="form-control" required>
    								    <option value="">--- Pilih Kelas ---</option>
							        <?php if(isset($s['m'])){?>
							        <option value="all" <?php echo (isset($s['c']) && $s['c']=='all') ? 'selected' : '' ?> >Semua Kelas</option>
            						    <?php foreach($class as $row){?>
            						        <option value="<?php echo $row['class_id']; ?>" <?php echo (isset($s['c']) && $s['c'] == $row['class_id']) ? 'selected' : '' ?>><?php echo $row['class_name'] ?></option>
            						    <?php } ?>
    								</select>
    								<?php } ?>
							        <td>
							            &nbsp&nbsp
							        </td>
							        <td>     
    								<select style="width: 200px;" id="s" name="s" class="form-control" required>
    								  <option value="" <?php echo (isset($s['s']) && $s['s'] == '') ? 'selected' : '' ?>> --- Pilih Status --- </option>
    								  <option value="all" <?php echo (isset($s['s']) && $s['s'] == 'all') ? 'selected' : '' ?>>Semua</option>
    								  <option value="1" <?php echo (isset($s['s']) && $s['s'] == '1') ? 'selected' : '' ?>>Terverifikasi</option>
            						  <option value="0" <?php echo (isset($s['s']) && $s['s'] == '0') ? 'selected' : '' ?>>Dibatalkan</option>
            						  <option value="2" <?php echo (isset($s['s']) && $s['s'] == '2') ? 'selected' : '' ?>>Dibayar</option>
            						  <option value="3" <?php echo (isset($s['s']) && $s['s'] == '3') ? 'selected' : '' ?>>Ditolak</option>
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
						</div>
						<?php echo form_close(); ?>
						</div>
						</div>
						<!-- /.box-header -->
						    <div class="box-body table-responsive">
    							<table id="dtable" class="table table-hover">
    							    <thead>
    								<tr>
    									<th>No</th>
    									<th>NIS</th>
    									<th>Nama</th>
    									<th>Kelas</th>
    									<th>Tanggal Bayar</th>
    									<th>Bukti Bayar</th>
    									<th>Keterangan</th>
    									<th>Status</th>
    									<th>Aksi</th>
    								</tr>
    								</thead>
    								<tbody>
    									<?php
    									if (!empty($prove)) {
    										$i = 1;
    										foreach ($prove as $row):
        									$date=date_create($row['prove_date']);
    											?>
    											<tr>
    												<td><?php echo $i; ?></td>
    												<td><?php echo $row['student_nis']; ?></td>
    												<td><?php echo $row['student_full_name']; ?></td>
    												<td><?php echo $row['majors_short_name'] . ' - ' . $row['class_name']; ?></td>
    												<td><?php echo date_format($date,"d-m-Y H:i:s"); ?></td>
    												<td><a href="<?php echo base_url() . 'uploads/prove/' . $row['prove_img']; ?>" target="_blank"><img src="<?php echo base_url() . 'uploads/prove/' . $row['prove_img']; ?>" width="70"></a></td>
    												<td><?php echo $row['prove_note']; ?></td>
    												<td><label class="label <?php if ($row['prove_status']==1) { echo 'label-success'; } else if ($row['prove_status']==0) { echo 'label-danger'; } else if ($row['prove_status']==2) { echo 'label-warning'; } else if ($row['prove_status']==3) { echo 'label-danger'; } ?>"><?php if ($row['prove_status']==1) { echo 'DIVERIFIKASI [Sudah Diverifikasi Admin]'; } else if ($row['prove_status']==0) { echo 'DIBATALKAN [Dibatalkan oleh Pengirim]'; } else if ($row['prove_status']==2) { echo 'DIBAYAR [Menunggu Verifikasi Admin]'; } else if ($row['prove_status']==3) { echo 'DITOLAK [Bukti Transfer Ditolak Admin]'; } ?></label></td>
    												<td>
    												    <?php if ($row['prove_status']==2) { ?>
    												    <a href="#verificationProve<?php echo $row['prove_id']; ?>" data-toggle="modal" class="btn btn-xs btn-success">Verifikasi Transaksi</a>
    												    <?php } ?>
    												</td>	
    											</tr>
    											
										<div class="modal modal-default fade" id="verificationProve<?php echo $row['prove_id']; ?>">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span></button>
															<h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi Verifikasi Transfer Wali Murid</h3>
														</div>
														<div class="modal-body">
															<center>
															    <a href="prove/approve/<?php echo $row['prove_id'] ?>" type="button" class="btn btn-success">Verifikasi</a>
															<a href="prove/ignore/<?php echo $row['prove_id'] ?>" type="button" class="btn btn-danger">Tolak</a>
															</center>
														</div>
														<div class="modal-footer">
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
			</form>
		</section>
		<!-- /.content -->
	</div>

<script>
    function get_kelas(){
        var id_majors    = $("#m").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/prove/class_searching',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#td_kelas").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
    }
</script>