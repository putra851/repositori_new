
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
					<div class="box-header"> <br>
						<div class="row">
							<div class="col-md-2">  
								<div class="form-group">
									<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										<input class="form-control" type="text" name="ds" id="ds" readonly="readonly" placeholder="Tanggal Awal">
									</div>
								</div>
							</div>
							<div class="col-md-2">  
								<div class="form-group">
									<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										<input class="form-control" type="text" name="de" id="de" readonly="readonly" placeholder="Tanggal Akhir">	
									</div>
								</div>
							</div>
							<div class="col-md-3">  
								<div class="form-group">
        						<select required="" name="majors_id" id="majors_id" class="form-control" onchange="get_item()">
        						    <option value="">-- Pilih Unit Sekolah --</option>
        						    <?php if ($this->session->userdata('umajorsid') == '0') { ?>
        						    <option value="all">Semua Unit Sekolah</option>
        						    <?php } ?>
        						    <?php foreach($majors as $row){?>
        						        <option value="<?php echo $row['majors_id']; ?>" ><?php echo $row['majors_short_name'] ?></option>
        						    <?php } ?>
        						</select>
								</div>
							</div>
							<div class="col-md-3">  
    							<div class="form-group">
    							    <div id="div_item">
            						<select class="form-control" name="item_id" id="item_id" required="">
            								<option value="">-- Pilih Unit Pos --</option>
    							    </select>
    							    </div>
							    </div>
							</div>
							<button type="submit" class="btn btn-primary" onclick="cari_data()">Filter</button>
						</div>
					<div id="div_show_data">
					</div>
				</div>
			</div>

		</div>
	</section>
	<!-- /.content -->
</div>

<script>
    function cari_data(){
        var ds          = $("#ds").val();
        var de          = $("#de").val();
        var item_id   = $("#item_id").val();
        var majors_id   = $("#majors_id").val();
        //alert(id_jurusan+id_kelas);
        if(ds != '' && de != '' && item_id != '' && majors_id != ''){
        $.ajax({ 
            url: '<?php echo base_url();?>manage/unit_pos/search_unit_pos',
            type: 'POST', 
            data: {
                    'ds'        : ds,
                    'de'        : de,
                    'item_id' : item_id,
                    'majors_id' : majors_id,
            },    
            success: function(msg) {
                    $("#div_show_data").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
        }
    }
</script>

<script>
    function get_item(){
        var majors_id    = $("#majors_id").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/unit_pos/get_item',
            type: 'POST', 
            data: {
                    'majors_id': majors_id,
            },    
            success: function(msg) {
                    $("#div_item").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
    }
</script>