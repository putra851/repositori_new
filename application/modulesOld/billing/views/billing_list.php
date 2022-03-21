
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
				<div class="box box-success">
					<div class="box-header">
						<?php echo form_open(current_url(), array('method' => 'get')) ?>
						<div class="row">
							<div class="col-md-2">  
								<div class="form-group">
									<label>Tahun Ajaran</label>
									<select class="form-control" name="p" required="">
										<option value="">-- Pilih T.A. --</option>
										<?php foreach ($period as $row): ?>
											<option <?php echo (isset($q['p']) AND $q['p'] == $row['period_id']) ? 'selected' : '' ?> value="<?php echo $row['period_id'] ?>"><?php echo $row['period_start'].'/'.$row['period_end'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">  
								<div class="form-group">
									<label>Unit Sekolah</label>
									<select class="form-control" name="k" id="majors_id" onchange="get_kelas()"  required="">
										<option value="">-- Pilih Unit --</option>
										<?php foreach ($majors as $row): ?>
											<option <?php echo (isset($q['k']) AND $q['k'] == $row['majors_id']) ? 'selected' : '' ?> value="<?php echo $row['majors_id'] ?>"><?php echo $row['majors_short_name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div id="td_kelas">
							<div class="col-md-2">  
								<div class="form-group">
									<label>Kelas</label>
									<select class="form-control" name="c" id="class_id" required="">
										<option value="">-- Pilih Kelas --</option>
										<?php if(isset($q['k'])){?>
										<?php foreach ($class as $row): ?>
											<option <?php echo (isset($q['c']) AND $q['c'] == $row['class_id']) ? 'selected' : '' ?> value="<?php echo $row['class_id'] ?>"><?php echo $row['class_name'] ?></option>
										<?php endforeach; ?>
										<?php } ?>
									</select>
								</div>
							</div>
							</div>
							
							<div class="col-md-2">  
								<div class="form-group">
									<label>Dari Bulan</label>
									<select class="form-control" name="d" id="dari_id" required="">
										<option value="">-- Dari Bulan --</option>
										<?php foreach ($from as $row): ?>
											<option <?php echo (isset($q['d']) AND $q['d'] == $row['month_id']) ? 'selected' : '' ?> value="<?php echo $row['month_id'] ?>"><?php echo $row['month_name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							
							<div class="col-md-2">  
								<div class="form-group">
									<label>Sampai Bulan</label>
									<select class="form-control" name="s" id="sampai_id">
										<option value="">-- Sampai Bulan --</option>
										<?php foreach ($to as $row): ?>
											<option <?php echo (isset($q['s']) AND $q['s'] == $row['month_id']) ? 'selected' : '' ?> value="<?php echo $row['month_id'] ?>"><?php echo $row['month_name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
							<div style="margin-top:25px;">
							<button type="submit" class="btn btn-primary">Cari</button>
							<?php if ($q AND !empty($student)) { ?>
							<a class="btn btn-success" target="_blank" href="<?php echo site_url('manage/billing/billing_excel' . '/?' . http_build_query($q)) ?>"><i class="fa fa-file-excel-o" ></i> Excel</a>
							<a class="btn btn-success" target="_blank" href="<?php echo site_url('manage/billing/billing_excel_rekap' . '/?' . http_build_query($q)) ?>"><i class="fa fa-file-excel-o" ></i> Rekap Excel</a>
							<?php } ?>
						    </div>
					        </div>
					</div>
					</form>
					</div>
				</div>
				<?php if ($q AND !empty($student)) { ?>
				<div class="box box-info">
					<div class="box-body table-responsive">
						<table id="dtable" class="table table-responsive table-bordered" style="white-space: nowrap;">
						    <thead>
							<tr>
								<th><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></th>
								<th>No. </th> 
								<th>NIS</th> 
								<th>Nama</th>
								<th>Kelas</th>
								<th>Total Tagihan</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
							<?php 
							
							    $no = 1;
							    foreach ($student as $row) : 
							    $billMonth = 0;
							    $billFree = 0;
							    $params = array();
							    $params['student_id']   = $row['student_id'];
							    $params['period_id']    = $q['p'];
							    $params['class_id']     = $q['c'];
							    $params['majors_id']    = $q['k'];
							    $params['month_start']  = $q['d'];
							    $params['month_end']    = $q['s'];
							    
	                            $month = $this->Billing_model->get_tagihan_bulan($params);
	                            $free  = $this->Billing_model->get_tagihan_bebas($params);
							?>
								<tr>
									<td>
									    <input type="checkbox" class="checkbox" name="msg[]" value="<?php echo $row['student_id']; ?>">
									</td>
									<td><?php echo $no++ ?></td>
									<td><?php echo $row['student_nis']?></td> 
									<td><?php echo $row['student_full_name']?></td>
									<td><?php echo $row['class_name']?></td>
									<td>
									    <?php
									        foreach($month as $mon){
									            $billMonth += $mon['bulan_bill'];      
									        }
									        foreach($free as $fr){
                                                $billFree += $fr['bebas_bill'] - $fr['bebas_total_pay'];
									        }
									        echo 'Rp '.number_format($billMonth + $billFree,0,",",".");
									    ?>
									</td>
									<td><a data-toggle="collapse" href="#collapse<?php echo $row['student_id']; ?>"><button class="btn btn-info btn-sm"><i class="fa fa-list"></i>  Rician</button></a>
									    <a href="<?php echo site_url('manage/billing/print_bill/'.$q['p'].'/'.$q['d'].'/'.$q['s'].'/'. $row['student_id']) ?>" target="_blank"><button class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i>  Cetak</button></a></td>
								</tr>
								<tr id="collapse<?php echo $row['student_id']; ?>" class="collapse">
								    <td></td>
								    <td colspan="6">
								        <table id="dtable" class="table table-no-bordered table-responsive" style="white-space: nowrap;" >
								            <thead>
								                <th>
								                   Rician Tagihan
								                </th>
								                <th>
								                </th>
								                <th>
								                    Nominal
								                </th>
                                                <th>
                                                    <?php echo str_repeat("&nbsp;", 100); ?>
                                                </th>
								            </thead>
								            <tbody>
								    <?php
		                            
    							    $billBulan = 0;
    							    $billBebas = 0;
    							    $params = array();
    							    $params['student_id']   = $row['student_id'];
    							    $params['period_id']    = $q['p'];
    							    $params['class_id']     = $q['c'];
    							    $params['majors_id']    = $q['k'];
    							    $params['month_start']  = $q['d'];
    							    $params['month_end']    = $q['s'];
    							    
    	                            $bulan = $this->Billing_model->get_tagihan_bulan($params);
    	                            $bebas = $this->Billing_model->get_tagihan_bebas($params);
								    foreach($bulan as $row): ?>
								    <tr>
                                        <td><?php echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'].'-'.$row['month_name'] ?>
                                        </td>
                                        <td align="right">
                                            Rp
                                        </td>
                                        <td align="right">
                                        <?php echo number_format($row['bulan_bill'],0,",",".") ?>
                                        </td>
                                        <td>
                                            <?php echo str_repeat("&nbsp;", 100); ?>
                                        </td>
                                    <?php $billBulan += $row['bulan_bill']; ?>
                                    </tr>
							        <?php endforeach; ?>
								    <?php foreach($bebas as $row): ?>
								    <tr>
                                        <td><?php echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'] ?>
                                        </td>
                                        <td align="right">
                                            Rp
                                        </td>
                                        <td align="right">
                                        <?php echo number_format($row['bebas_bill']-$row['bebas_total_pay'],0,",",".") ?>
                                        </td>
                                        <td>
                                            <?php echo str_repeat("&nbsp;", 100); ?>
                                        </td>
                                    <?php $billBebas += $row['bebas_bill']-$row['bebas_total_pay']; ?>
                                    </tr>
							        <?php endforeach ?>
                                    <tr style="background-color: #f0f0f0">
                                        <td><b><?php echo 'Total Tagihan' ?></b>
                                        </td>
                                        <td align="right">
                                            Rp
                                        </td>
                                        <td align="right">
                                        <?php echo number_format($billBulan+$billBebas,0,",",".") ?>
                                        </td>
                                        <td>
                                            <?php echo str_repeat("&nbsp;", 100); ?>
                                        </td>
                                    </tr>
                                    </tbody>
							        </table>
							            </td>
								    </tr>
							<?php endforeach ?>
							        <?php
							            $kelas = $this->Student_model->get_class(array('id'=>$q['c']));
							        ?>
							        <tr style="background-color: #f0f0f0;">
							            <td>
							            </td>
							            <td colspan="4" align="center">
							                <b>Total Tagihan Kelas <?php echo $kelas['class_name'] ?></b>
							            </td>
							            <td colspan="2">
						                <?php
						                    $billM = 0;
            							    $billF = 0;
            							    $params = array();
            							    $params['period_id']    = $q['p'];
            							    $params['class_id']     = $q['c'];
            							    $params['majors_id']    = $q['k'];
            							    $params['month_start']  = $q['d'];
            							    $params['month_end']    = $q['s'];
            							    
            	                            $m = $this->Billing_model->get_tagihan_bulan($params);
            	                            $f  = $this->Billing_model->get_tagihan_bebas($params);
            	                            
            	                            foreach ($m as $m){
            	                                $billM += $m['bulan_bill'];
            	                            }
            	                            
            	                            foreach ($f as $f){
            	                                $billF += $f['bebas_bill']-$f['bebas_total_pay'];
            	                            }
            	                            
            	                            echo "Rp ".number_format($billM+$billF,0,",",".")
						                ?>
							            </td>
							        </tr>
                            </tbody>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<?php } ?>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<script>
    function get_kelas(){
        var id_majors    = $("#majors_id").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/billing/class_searching',
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
<script>
	$(document).ready(function() {
		$("#selectall").change(function() {
			$(".checkbox").prop('checked', $(this).prop("checked"));
		});
	});
	$(document).ready(function() {
		$("#selectall2").change(function() {
			$(".checkbox").prop('checked', $(this).prop("checked"));
		});
	});
</script>