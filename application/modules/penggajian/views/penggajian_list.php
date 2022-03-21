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
						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
    					<div class="box-body table-responsive">
							<table>
							    <tr>
							        <td>     
    								<select style="width: 200px;" id="m" name="m" class="form-control" required onchange="get_position()">
    								    <option value="">--- Pilih Unit Sekolah ---</option>
            						    <?php foreach($majors as $row){?>
            						        <option value="<?php echo $row['majors_id']; ?>" <?php echo (isset($s['m']) && $s['m'] == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
            						    <?php } ?>
    								</select>
							        </td>
							        <td>
							            &nbsp&nbsp
							        </td>
							        <td id="td_position">
    								<select style="width: 200px;" id="p" name="p" class="form-control" required>
    								    <option value="">--- Pilih Jabatan ---</option>
							        <?php if(isset($s['m'])){?>
							        <option value="all" <?php echo (isset($s['p']) && $s['p']=='all') ? 'selected' : '' ?> >Semua Jabatan</option>
            						    <?php foreach($class as $row){?>
            						        <option value="<?php echo $row['class_id']; ?>" <?php echo (isset($s['p']) && $s['p'] == $row['jabatan_id']) ? 'selected' : '' ?>><?php echo $row['jabatan_name'] ?></option>
            						    <?php } ?>
    								</select>
    								<?php } ?>
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
						<!-- /.box-header -->
						<div class="box-body table-responsive">
							<table id="dtable" class="table table-hover">
							    <thead>
								<tr>
									<th>No</th>
									<th>NIP</th>
									<th>Nama</th>
									<th>Unit Sekolah</th>
									<th>Jabatan</th>
									<th>Status Kepegawaian</th>
									<th>Pendidikan Terakhir</th>
									<th>Setting</th>
								<!--<th>Penggajian</th>-->
								</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($employee)) {
										$i = 1;
										foreach ($employee as $row):
											?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $row['employee_nip']; ?></td>
												<td><?php echo $row['employee_name']; ?></td>
												<td><?php echo $row['majors_short_name']; ?></td>
												<td><?php echo $row['position_name']; ?></td>
												<td><?php if( $row['employee_category']=='1') {
												    echo 'Pegawai Tetap';
												} else if( $row['employee_category']=='2') {
												    echo 'Pegawai Tidak Tetap';
												} else {
												    echo '-';
												} ?></td>
												<td><?php echo $row['employee_strata']; ?></td>
												<td>
													<?php if ($this->session->userdata('uroleid') != USER) { ?>
													<a href="<?php echo site_url('manage/penggajian/set/' . $row['employee_id']) ?>" class="btn btn-xs btn-success" data-toggle="tooltip" title="Setting Gaji">Setting Gaji</a>
													<?php } ?>
												</td>
											<!--<td>
													<?php if ($this->session->userdata('uroleid') != USER) { ?>
													<a href="<?php echo site_url('manage/penggajian/details/' . $row['employee_id']) ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Lihat Detail">Lihat Detail</a>
													<?php } ?>
												</td>-->
											</tr>
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

	<script type="text/javascript">
		(function(a){
			a.createModal=function(b){
				defaults={
					title:"",message:"Your Message Goes Here!",closeButton:true,scrollable:false
				};
				var b=a.extend({},defaults,b);
				var c=(b.scrollable===true)?'style="max-height: 420px;overflow-y: auto;"':"";
				html='<div class="modal fade" id="myModal">';
				html+='<div class="modal-dialog">';
				html+='<div class="modal-content">';
				html+='<div class="modal-header">';
				html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>';
				if(b.title.length>0){
					html+='<h4 class="modal-title">'+b.title+"</h4>"
				}
				html+="</div>";
				html+='<div class="modal-body" '+c+">";
				html+=b.message;
				html+="</div>";
				html+='<div class="modal-footer">';
				if(b.closeButton===true){
					html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>'
				}
				html+="</div>";
				html+="</div>";
				html+="</div>";
				html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){
					a(this).remove()})}})(jQuery);

/*
* Here is how you use it
*/
$(function(){    
	$('.view-pdf').on('click',function(){
		var pdf_link = $(this).attr('href');      
		var iframe = '<object type="application/pdf" data="'+pdf_link+'" width="100%" height="350">No Support</object>'
		$.createModal({
			title:'Cetak Kartu Pegawai',
			message: iframe,
			closeButton:true,
			scrollable:false
		});
		return false;        
	});    
})
</script>
<script>
	$(document).ready(function() {
		$("#selectall").change(function() {
			$(".checkbox").prop('checked', $(this).prop("checked"));
		});
	});
</script>

<script>
    function get_position(){
        var id_majors    = $("#m").val();
        $.ajax({ 
            url: '<?php echo base_url();?>manage/employees/searching_position',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#td_position").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
    }
</script>