<script type="text/javascript" src="<?php echo media_url('js/jquery-migrate-3.0.0.min.js') ?>"></script>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>
	<section class="content">
		<div class="row"> 
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Filter Data Kelas</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
    						<div class="form-group">
						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>						
							<label class="col-sm-2 control-label">Unit Pesantren</label>
							<div class="col-sm-2">
								<select class="form-control" name="n" id="majors_id" onchange="find_class()">
									<option <?php echo (isset($f['n']) AND $f['n'] == '0') ? 'selected' : '' ?> value="0">Pilih Unit</option>
									<?php foreach ($majors as $row): ?>
										<option <?php echo (isset($f['n']) AND $f['n'] == $row['majors_id']) ? 'selected' : '' ?> value="<?php echo $row['majors_id'] ?>"><?php echo $row['majors_short_name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div id="div_class">
    						<?php if(isset($f['n'])) { ?>
							<label class="col-sm-2 control-label">Kelas</label>
							<div class="col-sm-2">
								<select class="form-control" name="r" id="class_id">
								    <option  value="">-- Pilih Kelas --</option>
									<?php foreach ($class as $row): ?>
										<option <?php echo (isset($f['r']) AND $f['r'] == $row['class_id']) ? 'selected' : '' ?> value="<?php echo $row['class_id'] ?>"><?php echo $row['class_name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<button class="btn btn-success" type="submit">Cari</button>
    						<?php } ?>
							</div>
								
					    </form>
					    </div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->

			<?php if ($f) { ?>
			<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">Jadwal Pelajaran</h3>
						<?php //if (isset($f['n']) AND isset($f['r'])) { ?>
							<a href="<?php //echo site_url('manage/banking/printBook' . '/?' . http_build_query($f)) ?>" target="_blank" class="btn btn-danger btn-xs pull-right">Cetak Jadwal Pelajaran</a>
						<?php //} ?>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
					    
						<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addSchedule"><i class="fa fa-pencil"></i> Buat Jadwal</button>
						
						<br>
						<br>
						
						<div class="col-md-9">
							<table class="table table-striped">
								<tbody>
									<tr>
										<td>Unit Pesantren</td>
										<td>:</td>
										<?php foreach ($class as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['class_id']) ? 
											'<td>'.$row['majors_short_name'].'</td>' : '' ?> 
										<?php endforeach; ?>
									</tr>
									<tr>
										<td>Kelas</td>
										<td>:</td>
										<?php foreach ($class as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['class_id']) ? 
											'<td>'.$row['class_name'].'</td>' : '' ?> 
										<?php endforeach; ?>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<!-- List Tagihan Bulanan -->
					
				    <div class="row">
				    <?php
				        foreach ($day as $row){ 
				        $day_id = $row['day_id'];
				        $id_kelas = $f['r'];
				        $schedule = $this->db->query("SELECT * FROM schedule JOIN lesson ON lesson.lesson_id = schedule.schedule_lesson_id WHERE schedule_day = '$day_id' AND schedule_class_id = '$id_kelas'")->result_array();
				    ?>
					    <div class="col-md-4">
					        
        					<div class="box box-primary">
        					<div class="box-header with-border">
        						<h3 class="box-title"><?php echo $row['day_name'] ?></h3>
        					</div>
        					
        					<div class="box-body table-responsive">
        					    <table class="table table-hover table-striped">
        						    <thead>
        							<tr>
        								<th>No</th>
        								<th>Mata Pelajaran</th>
        								<th>Waktu</th>
        								<th>Aksi</th>
        							</tr>
        							</thead>
        							<tbody>
        							    <?php 
        							        $no = 1;
        							        foreach ($schedule as $jadwal) {
        							    ?>
        							    <tr>
            								<td><?php echo $no++ ?></td>
            								<td><?php echo $jadwal['lesson_name'] ?></td>
            								<td><?php echo $jadwal['schedule_time'] ?></td>
            								<td>
												<a href="#delModal<?php echo $jadwal['schedule_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>	    
            								</td>
        							    </tr>
        							    
										<div class="modal modal-default fade" id="delModal<?php echo $jadwal['schedule_id']; ?>">
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
															<?php echo form_open('manage/schedule/delete/' . $jadwal['schedule_id']); ?>
															<input type="hidden" name="majors_id" value="<?php echo $f['n']; ?>">
															<input type="hidden" name="class_id" value="<?php echo $f['r']; ?>">
															<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
															<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
															<?php echo form_close(); ?>
														</div>
													</div>
													<!-- /.modal-content -->
												</div>
												<!-- /.modal-dialog -->
											</div>
        							    <?php } ?>
        							</tbody>
        						</table>
        					</div>
        					
        				    </div>
        				    
					    </div>
				    <?php } ?>
					</div>
				
			    <?php } ?>
			</div>
		</div>
	</section>
</div>
		
		
		<div class="modal fade" id="addSchedule" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Jadwal Pelajaran</h4>
					</div>
					<div class="modal-body">
					    
    					<?php echo form_open('manage/schedule/add_glob', array('method'=>'post')); ?>
    					
    					<?php foreach ($majors as $row): ?>
    					<?php echo (isset($f['n']) AND $f['n'] == $row['majors_id']) ? 
    					'<input type="hidden" name="schedule_majors_id" value="'.$row['majors_id'].'">' : '' ?> 
    				    <?php endforeach; ?>
    					
    					<?php foreach ($class as $row): ?>
    					<?php echo (isset($f['n']) AND $f['r'] == $row['class_id']) ? 
    					'<input type="hidden" name="schedule_class_id" value="'.$row['class_id'].'">' : '' ?> 
    				    <?php endforeach; ?>
					
						<div class="form-group">
							<label>Hari</label>
							<select class="form-control" name="schedule_day" id="schedule_day">
									<option value="">-- Pilih Hari --</option>
									<?php foreach ($day as $row){ ?>
                					<?php
                					echo '<option value="' . $row['day_id'] . '">' . $row['day_name'] . '</option>'; ?> 
                				    <?php } ?>
							</select>
						</div>
						
						<div id="p_scents_lesson">
						<div id="id_row">
						<div class="row">
						    <div class="col-md-6">
        						<div class="form-group">
        						    <label>Pelajaran</label>
        							<select class="form-control" name="schedule_lesson[]" id="schedule_lesson[]"><option value="">-- Pilih Mata Pelajaran --</option>
        								<?php foreach ($lesson as $row): ?>
        									<option value="<?php echo $row['lesson_id'] ?>"><?php echo $row['lesson_name'] ?></option>
        								<?php endforeach; ?>
        							</select>
        						</div>
						    </div>
						    <div class="col-md-3">
        						<div class="form-group">
        							<label>Mulai Jam</label>
        							<input type="text" maxlength="5" class="form-control" required="" name="schedule_start[]" class="form-control" placeholder="Mulai Jam">
        						</div>
						    </div>
						    <div class="col-md-3">
        						<div class="form-group">
        							<label>Selesai Jam</label>
        							<input type="text" maxlength="5" class="form-control" required="" name="schedule_end[]" class="form-control" placeholder="Selesai Jam">
        						</div>
						    </div>
						</div>
						</div>
						</div>
						
						<h6 ><a href="#" class="btn btn-xs btn-success" id="addScnt_lesson"><i class="fa fa-plus"></i><b> Tambah Baris</b></a></h6>
						
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info">Buat Jadwal</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>

<script>

    function get_kelas(){
	    var id_majors    = $("#majors_id").val();
	    
        $.ajax({ 
            url: '<?php echo base_url();?>manage/banking/get_kelas',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#div_kelas").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
	}
	
	function get_student(){
	    var id_majors       = $("#majors_id").val();
	    var id_kelas        = $("#class_id").val();
	    var student_name    = $("#student_name").val();
	    
        $.ajax({ 
            url: '<?php echo base_url();?>manage/banking/get_student',
            type: 'POST', 
            data: {
                    'id_majors'   : id_majors,
                    'id_kelas'    : id_kelas,
                    'student_name': student_name,
            },    
            success: function(msg) {
                    $("#div_data").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
	}
</script>

<script>
	$(function() {
		var scntDiv = $('#p_scents_lesson');
		var i = $('#p_scents_lesson p').size() + 1;

		$("#addScnt_lesson").click(function() {
			$('<div id="id_row"><div class="row"><div class="col-md-6"><div class="form-group"><label>Pelajaran</label><select class="form-control" name="schedule_lesson[]" id="schedule_lesson[]"><option value="">-- Pilih Mata Pelajaran --</option><?php foreach ($lesson as $row): ?><option value="<?php echo $row['lesson_id'] ?>"><?php echo $row['lesson_name'] ?></option><?php endforeach; ?></select></div></div><div class="col-md-3"><div class="form-group"><label>Mulai Jam</label><input type="text" maxlength="5" class="form-control" required="" name="schedule_start[]" class="form-control" placeholder="Mulai Jam"></div></div><div class="col-md-3"><div class="form-group"><label>Selesai Jam</label><input type="text" maxlength="5" class="form-control" required="" name="schedule_end[]" class="form-control" placeholder="Selesai Jam"></div></div></div><a href="#" class="btn btn-xs btn-danger remScnt_lesson">Hapus Baris</a></div>').appendTo(scntDiv);
			i++;
			return false;
		});

		$(document).on("click", ".remScnt_lesson", function() {
			if (i > 1) {
				$(this).parents('#id_row').remove();
				i--;
			}
			return false;
		});
	});
</script>

<script>
    function find_class(){
        var id_majors    = $("#majors_id").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/schedule/find_class',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#div_class").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
    }
</script>
	
<style>
    div.over {
        width: 700px;
        height: 165px;
        overflow: scroll;
    }
    
    div.extended {
        width: 900px;
        height: 200px;
        overflow: scroll;
    }
</style>