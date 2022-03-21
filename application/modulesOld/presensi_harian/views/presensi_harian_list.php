
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
					    <h3><?php echo 'Presensi Harian Bulan ' . $bulan['month_name'] . ' ' . $period['period_start'] . '/' . $period['period_end'] . ' Tanggal ' . pretty_date(date('Y-m-d'), 'l, d F Y' ,false); ?></h3>
						<?php echo form_open(current_url(), array('method' => 'get')) ?>
						<input type="hidden" class="form-control" name="p" id="period_id" value="<?php echo $period['period_id'] ?>" readonly="">
						<input type="hidden" class="form-control" name="m" id="month_id" value="<?php echo $bulan['month_id'] ?>" readonly="">
						<input type="hidden" class="form-control" name="d" id="today" value="<?php echo date('Y-m-d') ?>">
						<div class="row">
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
						    </div>
					        </div>
					</div>
					</form>
					</div>
				</div>
				
				<?php if ($q) { ?>
				
				<?php if ($check == 0) { ?>
				
        				<?php if (!empty($student)) { ?>
        				<div class="box box-success">
        					<div class="box-body table-responsive">
            					<?php echo form_open('manage/presensi_harian/add_glob', array('method'=>'post')); ?>
            					<input type="hidden" name="period_id" value="<?php echo $q['p'] ?>"></td>
            					<input type="hidden" name="month_id" value="<?php echo $q['m'] ?>"></td>
            					<input type="hidden" name="presensi_date" value="<?php echo date('Y-m-d'); ?>"></td>
            					<input type="hidden" name="majors_id" value="<?php echo $q['k'] ?>"></td>
            					<input type="hidden" name="class_id" value="<?php echo $q['c'] ?>"></td>
            					<table class="table table-responsive table-bordered" style="white-space: nowrap;">
            						    <thead>
            							<tr>
            								<th width='5' rowspan='2'><center>No.</center></th> 
            								<th rowspan='2'><center>NIS</center></th> 
            								<th rowspan='2'><center>Nama</center></th>
            								<th colspan='4'><center>Status</center></th>
            							</tr>
            							<tr>
            							    <th>Hadir <input name="selectAll" id="selectallhadir" type="radio" value="Y"></th>
            							    <th>Sakit <input name="selectAll" id="selectallsakit" type="radio" value="Y"></th>
            							    <th>Izin <input name="selectAll" id="selectallizin" type="radio" value="Y"></th>
            							    <th>Alpha <input name="selectAll" id="selectallalpha" type="radio" value="Y"></th>
            							</tr>
            							</thead>
            							<tbody>
            							<?php 
            							    $no = 1;
            							    foreach ($student as $row) :
            						    ?>
            								<tr>
            									<td><?php echo $no++ ?><input type="hidden" name="student_id[]" value="<?php echo $row['student_id']?>"></td>
            									<td><?php echo $row['student_nis']?></td> 
            									<td><?php echo $row['student_full_name']?></td>
            									<td>
            										<input type="radio" name="presensi_harian_status<?php echo $row['student_id']?>[]" class="hadir" value="H" requied>
            									</td>
            									<td>
            										<input type="radio" name="presensi_harian_status<?php echo $row['student_id']?>[]" class="sakit" value="S" requied>
            									</td>
            									<td>
            										<input type="radio" name="presensi_harian_status<?php echo $row['student_id']?>[]" class="izin" value="I" requied>
            									</td>
            									<td>
            										<input type="radio" name="presensi_harian_status<?php echo $row['student_id']?>[]" class="alpha" value="A" requied></td>
            								</tr>
            							<?php endforeach ?>
                                        </tbody>
            						</table>
            						<div class="pull-right">
            						    <button type="submit" class="btn btn-success">Simpan</button>
            						</div>
            					<?php echo form_close(); ?>
        					</div>
        					<!-- /.box-body -->
        				</div>
        				<?php 
        				    
        				}
    				
    				} else { ?>
				
				<div class="box box-success">
					<div class="box-body table-responsive">
					    <center>
					        <h3>Presensi Semua Siswa Sudah Didata</h3>
					    </center>
				    </div>
				</div>
				
				<?php
				    }
				}
				?>
				
				
				
				
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
		$("#selectallhadir").click(function() {
            if ($(this).is(':checked'))
                $(".hadir").attr("checked", "checked");
            else
                $(".hadir").removeAttr("checked");
        });
		$("#selectallsakit").click(function() {
            if ($(this).is(':checked'))
                $(".sakit").attr("checked", "checked");
            else
                $(".sakit").removeAttr("checked");
        });
		$("#selectallizin").click(function() {
            if ($(this).is(':checked'))
                $(".izin").attr("checked", "checked");
            else
                $(".izin").removeAttr("checked");
        });
		$("#selectallalpha").click(function() {
            if ($(this).is(':checked'))
                $(".alpha").attr("checked", "checked");
            else
                $(".alpha").removeAttr("checked");
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