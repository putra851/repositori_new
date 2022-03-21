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
						<a href="<?php echo site_url('manage/kredit/trx') ?>"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</button></a>
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
								<th>Kas</th>
								<th>No. Ref</th>
								<th>Tanggal</th>
								<th>Kode Akun</th>
								<th>Keterangan</th>
								<th>Nominal (Rp.)</th>
								<th>Pajak</th>
								<th>Unit POS</th>
								<th>Total (Rp.)</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($kredit)) {
									$i = 1;
									foreach ($kredit as $row):
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td>[<?php echo $row['accDesc']; ?>]</td>
											<td><?php echo $row['kredit_kas_noref']; ?></td>
											<td><?php echo pretty_date($row['kredit_date'],'d/m/Y',false); ?></td>
											<td><?php echo $row['account_code']." - ".$row['account_description']; ?></td>
											<td><?php echo $row['kredit_desc']; ?></td>
											<td><?php echo 'Rp. ' . number_format($row['kredit_value'], 0, ',', '.') ?></td>
											<td><?php echo $row['kredit_tax']; ?> %</td>
											<td><?php echo $row['kredit_item']; ?></td>
											<td><?php echo 'Rp. ' . number_format($row['kredit_value']+($row['kredit_value']*($row['kredit_tax']/100)), 0, ',', '.') ?></td>
											<td>
												<a href="<?php echo site_url('manage/kredit/cetakTrx/' . $row['kredit_kas_noref']) ?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Cetak Tranksaksi" target="_blank"><i class="fa fa-print"></i></a>
												<a href="<?php echo site_url('manage/kredit/edit/' . $row['kredit_id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
												
												<a href="#delModal<?php echo $row['kredit_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
											</td>	
										</tr>
										<div class="modal modal-default fade" id="delModal<?php echo $row['kredit_id']; ?>">
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
															<?php echo form_open('manage/kredit/delete/' . $row['kredit_id']); ?>
															<input type="hidden" name="delNoref" value="<?php echo $row['kredit_kas_noref']; ?>">
															<input type="hidden" name="delGaji" value="<?php echo $row['kredit_gaji_id']; ?>">
															<input type="hidden" name="delName" value="<?php echo $row['kredit_desc']; ?>">
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
					</div>
				</div>
			</section>
			<!-- /.content -->
		</div>

		<!-- Modal -->
		<div class="modal fade" id="addKredit" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Tambah Kas Keluar</h4>
					</div>
					<?php echo form_open('manage/kredit/add_glob', array('method'=>'post')); ?>
					<div class="modal-body">
						<div id="p_scents_kredit">
							<div class="form-group">
								<label>Tanggal</label>
								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
									<input class="form-control" required="" type="text" name="kredit_date" placeholder="Tanggal Kas Keluar">
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
            						<label>Unit Sekolah *</label>
            						<select required="" name="majors_id" id="majors_id" class="form-control" onchange="get_kode()">
            						    <option value="">-Pilih Unit Sekolah-</option>
            						    <?php foreach($majors as $row){?>
            						        <option value="<?php echo $row['majors_id']; ?>" ><?php echo $row['majors_short_name'] ?></option>
            						    <?php } ?>
            						</select>
            					</div>
            					<div class="col-md-3">
            					<div id="div_kode">
        							<label>Kode Akun *</label>
        							<select required="" name="kredit_account_id[]" class="form-control">
        							    <option value="">-Pilih Kode Akun-</option>
        							</select>
								</div>
								</div>
								<div class="col-md-3">
									<label>Jumlah Rupiah *</label>
									<input  type="text" class="form-control" id="kredit" required="" name="kredit_value[]" class="form-control" placeholder="Jumlah">
								</div>
								<div class="col-md-3">
									<label>Keterangan *</label>
									<input type="text" required="" name="kredit_desc[]" class="form-control" placeholder="Keterangan Kas Keluar">
								</div>
							</div>
						</div>
						<!--<h6 ><a href="#" class="btn btn-xs btn-success" id="addScnt_kredit"><i class="fa fa-plus"></i><b> Tambah Baris</b></a></h6>-->
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Simpan</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	
	<script>
	    function get_kode(){
	        
    	    var id_majors    = $("#majors_id").val();
            //alert(id_jurusan+id_kelas);
            $.ajax({ 
                url: '<?php echo base_url();?>manage/kredit/cari_kode',
                type: 'POST', 
                data: {
                        'id_majors': id_majors,
                },    
                success: function(msg) {
                        $("#div_kode").html(msg);
                },
    			error: function(msg){
    					alert('msg');
    			}
                
            });
	    }
	</script>
	<?php $this->load->view('manage/rupiah'); ?>