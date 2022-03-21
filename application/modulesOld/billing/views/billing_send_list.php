
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
									<label>Unit Pesantren</label>
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
							<div class="col-md-4">
							<div style="margin-top:25px;">
							<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
							<?php if ($q AND !empty($student)) { ?>
					        <a data-toggle="modal" class="btn btn-success" title="Pastikan Sudah Ada Santri yang Dicentang" href="#kirimTagihan" onclick="get_form()"><span class="fa fa-whatsapp"></span> Kirim Tagihan</a>
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
								<th>WA Ortu</th>
								<th>Total Tagihan</th>
							</tr>
							</thead>
							<tbody>
							<?php 
                                $dateM = date('m');
                                
                                if($dateM == '01'){
                                    $till = '7';
                                } else if($dateM == '02'){
                                    $till = '8';
                                } else if($dateM == '03'){
                                    $till = '9';
                                } else if($dateM == '04'){
                                    $till = '10';
                                } else if($dateM == '05'){
                                    $till = '11';
                                } else if($dateM == '06'){
                                    $till = '12';
                                } else if($dateM == '07'){
                                    $till = '1';
                                } else if($dateM == '08'){
                                    $till = '2';
                                } else if($dateM == '09'){
                                    $till = '3';
                                } else if($dateM == '10'){
                                    $till = '4';
                                } else if($dateM == '11'){
                                    $till = '5';
                                } else if($dateM == '12'){
                                    $till = '6';
                                }
							
							    $no = 1;
							    foreach ($student as $row) : 
							    $billMonth = 0;
							    $billFree = 0;
							    $billMonthOld = 0;
							    $billFreeOld = 0;
							    
							    $params = array();
							    
							    $params['student_id']   = $row['student_id'];
							    $params['period_id']    = $q['p'];
							    $params['class_id']     = $q['c'];
							    $params['majors_id']    = $q['k'];
							    $params['month_start']  = 1;
							    $params['month_end']    = $till;
							    
							    $param = array();
							    
							    $param['student_id']   = $row['student_id'];
							    $param['period_id']    = $q['p'];
							    $param['class_id']     = $q['c'];
							    $param['majors_id']    = $q['k'];
							    
	                            $month = $this->Billing_model->get_tagihan_bulan($params);
	                            $free  = $this->Billing_model->get_tagihan_bebas($params);
							    
	                            $monthOld = $this->Billing_model->get_tagihan_bulan_lama($param);
	                            $freeOld  = $this->Billing_model->get_tagihan_bebas_lama($param);
							?>
								<tr>
									<td>
									    <input type="checkbox" class="checkbox" name="msg[]" id="msg" value="<?php echo $row['student_id']; ?>">
									</td>
									<td><?php echo $no++ ?></td>
									<td><?php echo $row['student_nis']?></td> 
									<td><?php echo $row['student_full_name']?></td>
									<td><?php echo $row['class_name']?></td>
									<td><?php echo $row['student_parent_phone']?></td>
									<td>
									    <?php
									        foreach($month as $mon){
									            $billMonth += $mon['bulan_bill'];      
									        }
									        foreach($free as $fr){
                                                $billFree += $fr['bebas_bill'] - $fr['bebas_diskon'] - $fr['bebas_total_pay'];
									        }
									        foreach($monthOld as $monO){
									            $billMonthOld += $monO['bulan_bill'];      
									        }
									        foreach($freeOld as $frO){
                                                $billFreeOld += $frO['bebas_bill'] - $frO['bebas_diskon'] - $frO['bebas_total_pay'];
									        }
									        echo 'Rp '.number_format($billMonth + $billFree + $billMonthOld + $billFreeOld,0,",",".");
									    ?>
									</td>
								</tr>
							<?php endforeach ?>
							        <?php
							            $kelas = $this->Student_model->get_class(array('id'=>$q['c']));
							        ?>
							        <tr style="background-color: #f0f0f0;">
							            <td colspan="6" align="center">
							                <b>Total Tagihan Kelas <?php echo $kelas['class_name'] ?></b>
							            </td>
							            <td>
						                <?php
						                    $billM = 0;
            							    $billF = 0;
						                    $billMOld = 0;
            							    $billFOld = 0;
            							    
            							    $params = array();
            							    
            							    $params['period_id']    = $q['p'];
            							    $params['class_id']     = $q['c'];
            							    $params['majors_id']    = $q['k'];
            							    $params['month_start']  = 1;
            							    $params['month_end']    = $till;
            							    
            							    $param = array();
            							    
            							    $param['period_id']    = $q['p'];
            							    $param['class_id']     = $q['c'];
            							    $param['majors_id']    = $q['k'];
            							    
            	                            $m = $this->Billing_model->get_tagihan_bulan($params);
            	                            $f  = $this->Billing_model->get_tagihan_bebas($params);
            							    
            	                            $mOld = $this->Billing_model->get_tagihan_bulan_lama($param);
            	                            $fOld  = $this->Billing_model->get_tagihan_bebas_lama($param);
            	                            
            	                            foreach ($m as $m){
            	                                $billM += $m['bulan_bill'];
            	                            }
            	                            
            	                            foreach ($f as $f){
            	                                $billF += $f['bebas_bill']-$f['bebas_diskon']-$f['bebas_total_pay'];
            	                            }
            	                            
            	                            foreach ($mOld as $mOld){
            	                                $billMOld += $mOld['bulan_bill'];
            	                            }
            	                            
            	                            foreach ($fOld as $fOld){
            	                                $billFOld += $fOld['bebas_bill']-$fOld['bebas_diskon']-$fOld['bebas_total_pay'];
            	                            }
            	                            
            	                            echo "Rp ".number_format($billM+$billF+$billMOld+$billFOld,0,",",".")
						                ?>
							            </td>
							        </tr>
                            </tbody>
						</table>
					</div>
					
	
	<div class="modal fade" id="kirimTagihan" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Kirim Tagihan</h4>
					</div>
					<div class="modal-body">
		            <?php echo form_open('manage/billing/send/', array('method'=>'post')); ?>
		                <p>Anda Yakin Mau Mengirim Tagihan ke Orang Tua Santri Tersebut?</p>
		                <input type="hidden" class="form-group" name="period_id" value="<?php echo $q['p'] ?>">
		                <input type="hidden" class="form-group" name="majors_id" value="<?php echo $q['k'] ?>">
		                <input type="hidden" class="form-group" name="class_id" value="<?php echo $q['c'] ?>">
            		    <div id="fbatch"></div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Kirim</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
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
		
<script>

  function get_form(){
    var student_id = $('#msg:checked');
    if(student_id.length > 0)
    {
        var student_id_value = [];
        $(student_id).each(function(){
            student_id_value.push($(this).val());
        });

        $.ajax({
            url: '<?php echo base_url();?>manage/billing/get_form/',
            method:"POST",
            data: {
                    student_id : student_id_value,
            },
            success: function(msg){
                    $("#fbatch").html(msg);
            },
    		error: function(msg){
    				alert('msg');
    		}
        });
    }
    else
    {
        alert("Belum ada Santri yang dipilih");
    }
  }
  
</script>