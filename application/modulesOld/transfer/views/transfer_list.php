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
						<h3 class="box-title">Filter Data Akun</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
    						<div class="form-group">
						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>						
							<label class="col-sm-2 control-label">Unit Pesantren</label>
							<div class="col-sm-2">
								<select class="form-control" name="n" id="majors_id" onchange="find_account()">
									<option <?php echo (isset($f['n']) AND $f['n'] == '0') ? 'selected' : '' ?> value="0">Pilih Unit</option>
									<?php foreach ($majors as $row): ?>
										<option <?php echo (isset($f['n']) AND $f['n'] == $row['majors_id']) ? 'selected' : '' ?> value="<?php echo $row['majors_id'] ?>"><?php echo $row['majors_short_name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div id="div_account">
    						<?php if(isset($f['n'])) { ?>
							<label class="col-sm-2 control-label">Akun Kas</label>
							<div class="col-sm-2">
								<select class="form-control" name="r" id="kas_account_id">
									<?php foreach ($account as $row): ?>
										<option <?php echo (isset($f['r']) AND $f['r'] == $row['account_id']) ? 'selected' : '' ?> value="<?php echo $row['account_id'] ?>"><?php echo $row['account_description'] ?></option>
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
						<h3 class="box-title">Informasi Akun</h3>
						<?php if (isset($f['n']) AND isset($f['r'])) { ?>
							<!--<a href="<?php //echo site_url('manage/banking/printBook' . '/?' . http_build_query($f)) ?>" target="_blank" class="btn btn-danger btn-xs pull-right">Cetak Semua Transfer</a>-->
						<?php } ?>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="col-md-9">
							<table class="table table-striped">
								<tbody>
									<tr>
										<td>Unit Pesantren</td>
										<td>:</td>
										<?php foreach ($account as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['account_id']) ? 
											'<td>'.$row['majors_short_name'].'</td>' : '' ?> 
										<?php endforeach; ?>
									</tr>
									<tr>
										<td>Nama Akun</td>
										<td>:</td>
										<?php foreach ($account as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['account_id']) ? 
											'<td>'.$row['account_description'].'</td>' : '' ?> 
										<?php endforeach; ?>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<!-- List Tagihan Bulanan --> 
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Riwayat Transaksi</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="box-body">
							<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addDebit"><i class="fa fa-plus"></i> Transfer</button>
						</div>
						<div class="box-body table-responsive">
							<table class="table table-bordered" style="white-space: nowrap;">
								<thead>
									<tr class="info">
										<th>No.</th>
										<th>No. Ref</th>
										<th>Tanggal</th>
										<th>Nominal</th>
										<th>Keterangan</th>
										<th>Aksi</th>
									</tr>
								</thead>
								
								<tbody>
									<?php
									$i =1;
									foreach ($history as $row):
									?>
									<tr>
										<td><?php echo $i ?></td>
										<td><?php echo ($row['log_tf_kredit_id'] != NULL) ? $row['kredit_kas_noref'] : $row['debit_kas_noref'] ?></td>
										<td><?php echo ($row['log_tf_kredit_id'] != NULL) ? pretty_date($row['kredit_date'], 'd F Y', false) : pretty_date($row['debit_date'], 'd F Y', false) ?></td>
										<td><?php echo ($row['log_tf_kredit_id'] != NULL) ? 'Rp '.number_format($row['kredit_value'], 0, ',', '.') : 'Rp '.number_format($row['debit_value'], 0, ',', '.') ?></td>
										<td><?php echo ($row['log_tf_kredit_id'] != NULL) ? $row['kredit_desc'] : $row['debit_desc'] ?></td>
										<td>
										</td>
									</tr>
								<?php 
										$i++;
									endforeach; 
								?>				
								</tbody>
							</table>
						</div>
						<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		
		
		<div class="modal fade" id="addDebit" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Transfer Kas</h4>
					</div>
					<div class="modal-body">
					    
    					<?php echo form_open('manage/transfer/transfer_process', array('method'=>'post')); ?>
    					
    					<?php foreach ($account as $row): ?>
    					<?php echo (isset($f['n']) AND $f['r'] == $row['account_id']) ? 
    					'<input type="hidden" name="kredit_kas_account_id" value="'.$row['account_id'].'">' : '' ?> 
    				    <?php endforeach; ?>
    				    
    				    <input type="hidden" class="form-control" required="" name="kredit_account_id" class="form-control" value="<?php echo $acc['account_id']?>">
    				    <input type="hidden" class="form-control" required="" name="kredit_majors_id" class="form-control" value="<?php echo $acc['account_majors_id']?>">
					
						<div class="form-group">
							<label>Tanggal</label>
							<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input class="form-control" required="" type="text" name="kredit_date" value="<?php echo date("Y-m-d") ?>" placeholder="Tanggal Setor">
							</div>
						</div>
						
						<div class="form-group">
						    <label>Akun Tujuan</label>
							<select class="form-control" name="transfer_kas_account_id" id="transfer_kas_account_id">
								<?php foreach ($akun as $row): ?>
									<option value="<?php echo $row['account_id'] ?>"><?php echo $row['account_description'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label>Nominal</label>
							<input type="text" class="form-control" required="" name="kredit_val" class="form-control" placeholder="Jumlah Setoran">
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info">Transfer</button>
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

<script type="text/javascript">
function startCalculate(){
    interval=setInterval("Calculate()",10);
}

function Calculate() {
	var numberHarga = $('#harga').val(); // a string
	numberHarga = numberHarga.replace(/\D/g, '');
	numberHarga = parseInt(numberHarga, 10);

	var numberBayar = $('#bayar').val(); // a string
	numberBayar = numberBayar.replace(/\D/g, '');
	numberBayar = parseInt(numberBayar, 10);

	var total = numberBayar - numberHarga;
	$('#kembalian').val(total);
}

function stopCalc(){
	clearInterval(interval);
}
</script>

<script>
$(document).ready(function() {
	$("#selectall").change(function() {
		$(".checkbox").prop('checked', $(this).prop("checked"));
	});
});
</script>

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
	$('.view-cicilan').on('click',function(){
		var link = $(this).attr('href');      
		var iframe = '<object type="text/html" data="'+link+'" width="100%" height="350">No Support</object>'
		$.createModal({
			title:'Lihat Pembayaran/Cicilan',
			message: iframe,
			closeButton:true,
			scrollable:false
		});
		return false;        
	});    
});
</script>


<script>
    function find_account(){
        var id_majors    = $("#majors_id").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/transfer/find_account',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#div_account").html(msg);
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