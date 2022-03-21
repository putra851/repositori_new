<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
			<small>Detail</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>
	<section class="content">
		<div class="row"> 
			<div class="col-md-12"> 
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Tarif - <?php echo $payment['pos_name'].' - T.A '.$payment['period_start'].'/'.$payment['period_end'] ?></h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
						<div class="form-group">						
							<label for="" class="col-sm-1 control-label">Tahun</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" value="<?php echo $payment['period_start'].'/'.$payment['period_end'] ?>" readonly="">
							</div>
							<label for="" class="col-sm-1 control-label">Kelas</label>
							<div class="col-sm-2">
								<select class="form-control" name="pr">
									<option value="">-- Semua Kelas  --</option>
									<?php foreach ($class as $row): ?>
										<option <?php echo (isset($q['pr']) AND $q['pr'] == $row['class_id']) ? 'selected' : '' ?> value="<?php echo $row['class_id'] ?>"><?php echo $row['class_name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<?php if(majors() == 'senior') { ?>
							<label for="" class="col-sm-2 control-label">Program Keahlian</label>
							<div class="col-sm-2">
								<select class="form-control" name="k">
									<option value="">-- Semua Keahlian  --</option>
									<?php foreach ($majors as $row): ?>
										<option <?php echo (isset($q['k']) AND $q['k'] == $row['majors_id']) ? 'selected' : '' ?> value="<?php echo $row['majors_id'] ?>"><?php echo $row['majors_name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<?php } ?>
							<div class="col-sm-2">
								<button type="submit" class="btn btn-success">Cari / Tampilkan</button>
							</div>
						</div>
					</form>
					<hr>
					<label for="" class="col-sm-2">Setting Tarif</label>
					<div class="col-sm-10">
						<a class="btn btn-primary btn-sm" href="<?php echo site_url('manage/payment/add_payment_bulan/' . $payment['payment_id']) ?>"><span class="glyphicon glyphicon-plus"></span> Berdasarkan Kelas</a>
						<a class="btn btn-info btn-sm" href="<?php echo site_url('manage/payment/add_payment_bulan_student/' . $payment['payment_id']) ?>"><span class="glyphicon glyphicon-plus"></span> Berdasarkan Santri</a>
						<a class="btn btn-warning btn-sm" href="<?php echo site_url('manage/payment/edit_payment_bulan_batch/' . $payment['payment_id']) ?>" data-toggle="tooltip" title="Ubah Tarif Per Kelas"><span class="fa fa-edit"></span> Edit Massal Per Kelas</a>
						
						<a class="btn btn-default btn-sm" href="<?php echo site_url('manage/payment') ?>"><span class="glyphicon glyphicon-repeat"></span> Kembali</a>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->

			<?php if($q) { ?>
			<div class="box box-primary">
				<div class="box-body table-responsive">
					<table id="dtable" class="table table-hover">
					    <thead>
						<tr>
							<th><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></th> 
							<th>No</th>
							<th>NIS</th>
							<th>Nama</th>
							<th>Kelas</th>
							<th>Nominal (Total)</th>
							<th>Aksi</th>
						</tr>
						</thead>
						<tbody>
							<?php
							$i = 1;
							foreach ($student as $row):
								?>
								<tr>
								    <td>
								        <input type="checkbox" class="checkbox" name="msg[]" id="msg" value="<?php echo $row['student_student_id']; ?>">
								    </td>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['student_nis']; ?></td>
									<td><?php echo $row['student_full_name']; ?></td>
									<td><?php echo $row['class_name']; ?></td>
									<?php if (majors() == 'senior') : ?>
										<td><?php echo $row['majors_name']; ?></td>
									<?php endif ?>
									<td>Rp. <?php echo number_format($row['bulan_bill'],0,",","."); ?></td>
									<td>
										<a href="<?php echo site_url('manage/payment/edit_payment_bulan/'. $row['payment_payment_id'].'/'.$row['student_student_id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Ubah Tarif Per Santri"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo site_url('manage/payment/delete_payment_bulan/'. $row['payment_payment_id'].'/'.$row['student_student_id']) ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus Pembayaran" onclick="return confirm('<?php echo 'Apakah anda akan menghapus pembayaran a.n '.$row['student_full_name'].'?' ?>')"><i class="fa fa-trash"></i></a>
									</td>	
								</tr>
								<?php
								$i++;
							endforeach; ?>
					</tbody>
				</table>
				<div class="pull-right">
				    <a data-toggle="modal" class="btn btn-warning btn-xs" title="Pastikan Sudah Ada Santri yang Dicentang" href="#editBanyak" onclick="get_form_edit()"><span class="fa fa-edit"></span> Edit Banyak</a>
				    <a data-toggle="modal" class="btn btn-danger btn-xs" title="Pastikan Sudah Ada Santri yang Dicentang" href="#hapusBanyak" onclick="get_form()"><span class="fa fa-trash"></span> Hapus Banyak</a>
				</div>
			</div>
		</div>
		    <?php } ?>
	</div>
</div>		
</section>
</div>

<div class="modal fade" id="editBanyak" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Pembayaran</h4>
			</div>
			<div class="modal-body">
            <?php echo form_open('manage/payment/update_payment_bulan_batch/', array('method'=>'post')); ?>
				
				<div class="form-group">
					<input type="hidden" name="payment_id" value="<?php echo $this->uri->segment('4') ?>">
				</div>
				
				<div class="form-group">
					<label for="" class="col-sm-4 control-label">Tarif Bulanan Baru (Rp.)</label>
					<div class="col-sm-8">
						<input type="text" placeholder="Nominal Tarif Baru" name="bulan_bill" class="form-control" required>
						<br>
					</div>
					<label for="" class="col-sm-4 control-label">Untuk Bulan <input type="checkbox" id="selectall2" value="checkbox" name="checkbox">
					</label>			
					<?php $month = $this->db->query("SELECT * FROM month")->result_array()?>
					<div class="col-sm-8">
					    <div class="checkbox">
					    <?php foreach($month as $row){ ?>
					    <label><input type="checkbox" class="checkboxBul" class="checkboxBul" name="bln[]" value="<?php echo $row['month_id']; ?>"><?php echo $row['month_name']; ?></label>
						<br>
						<?php } ?>
						</div>
					</div>
					<div class="col-sm-12">
						<h5>&nbsp;&nbsp;&nbsp;
						<b>*) NB : Tarif yang sudah dibayar tidak akan berubah</b></h5>
					</div>
				</div>
				
    		    <div id="fbatchedit"></div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-warning">Update</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<div class="modal fade" id="hapusBanyak" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Hapus Pembayaran</h4>
			</div>
			<div class="modal-body">
            <?php echo form_open('manage/payment/delete_payment_bulan_batch/', array('method'=>'post')); ?>
            
                <p>Apakah Anda yakin menghapus pembayaran Santri tersebut?</p>
				
				<div class="form-group">
					<input type="hidden" name="payment_id" value="<?php echo $this->uri->segment('4') ?>">
				</div>
				
    		    <div id="fbatch"></div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-danger">Hapus</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$("#selectall").change(function() {
			$(".checkbox").prop('checked', $(this).prop("checked"));
		});
	});
</script>

<script>
	$(document).ready(function() {
		$("#selectall2").change(function() {
			$(".checkboxBul").prop('checked', $(this).prop("checked"));
		});
	});
</script>
		
<script>

  function get_form_edit(){
    var student_id = $('#msg:checked');
    if(student_id.length > 0)
    {
        var student_id_value = [];
        $(student_id).each(function(){
            student_id_value.push($(this).val());
        });

        $.ajax({
            url: '<?php echo base_url();?>manage/payment/get_form/',
            method:"POST",
            data: {
                    student_id : student_id_value,
            },
            success: function(msg){
                    $("#fbatchedit").html(msg);
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

  function get_form(){
    var student_id = $('#msg:checked');
    if(student_id.length > 0)
    {
        var student_id_value = [];
        $(student_id).each(function(){
            student_id_value.push($(this).val());
        });

        $.ajax({
            url: '<?php echo base_url();?>manage/payment/get_form/',
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