
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
					<div class="box-body table-responsive">
						<table class="table">
						    <tr>
						        <td>
						            <select class="form-control" name="period_id" id="period_id" required="">
									<option value="">--Pilih Tahun Ajaran--</option>
									<?php foreach ($period as $row): ?>
										<option value="<?php echo $row['period_id'] ?>"><?php echo $row['period_start'].'/'.$row['period_end'] ?></option>
									<?php endforeach; ?>
								    </select>
						        </td>
						        <td>
						            <select class="form-control" name="majors_id" id="majors_id" required="">
									<option value="">--Pilih Unit Sekolah--</option>
									<?php foreach ($majors as $row): ?>
										<option value="<?php echo $row['majors_id'] ?>"><?php echo $row['majors_short_name'] ?></option>
									<?php endforeach; ?>
								    </select>
						        </td>
						        <td id="td_kelas">
						            <select name="class_id" id="class_id" class="form-control" required="">
						                <option value="">--Pilih Kelas--</option>
									</select>
						        </td>
						        <td>
						            <div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										<input class="form-control" type="text" name="ds" id="ds" readonly="readonly" placeholder="Tanggal Awal">
									</div>
						        </td>
						        <td>
									<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										<input class="form-control" type="text" name="de" id="de" readonly="readonly" placeholder="Tanggal Akhir">	
									</div>
						        </td>
						        <td>
						            <button type="button" class="btn btn-primary" onclick="cari_data()"><i class="fa fa-search"></i>Cari</button>
						        </td>
						    </tr>
						</table>
						</div>
						</div>
					</div>
					<div id="div_tampil_data">
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<script>
    function cari_data(){
        var id_periode  = $("#period_id").val();
        var id_majors   = $("#majors_id").val();
        var id_kelas    = $("#class_id").val();
        var ds          = $("#ds").val();
        var de          = $("#de").val();
        if(id_periode != '' && id_majors != '' && id_kelas != '' && ds != '' && de != ''){
            $.ajax({ 
                url: '<?php echo base_url();?>manage/report/cari_report_period',
                type: 'POST', 
                data: {
                        'id_periode': id_periode,
                        'id_majors' : id_majors,
                        'id_kelas'  : id_kelas,
                        'ds'        : ds,
                        'de'        : de,
                },    
                success: function(msg) {
                        $("#div_tampil_data").html(msg);
                },
    			error: function(msg){
    					alert('msg');
    			}
                
            });
        }
    }
</script>

<script>
    $(document).ready(function(){
        $("#majors_id").change(function(e){
    	    var id_majors    = $("#majors_id").val();
            //alert(id_jurusan+id_kelas);
            $.ajax({ 
                url: '<?php echo base_url();?>manage/report/cari_kelas',
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
    		e.preventDefault();
    	});
    });
</script>