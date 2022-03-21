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
						<h3 class="box-title">Filter Data Hutang</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
						<div class="form-group">						
							<label for="" class="col-sm-2 control-label">Periode Hutang</label>
							<div class="col-sm-2">
								<select class="form-control" name="n" id="th_ajar">
									<?php foreach ($period as $row): ?>
										<option <?php if (isset($f['n']) AND $f['n'] == $row['period_id']) {
										    echo 'selected';
										} else if (empty($f['n']) AND $periodActive['period_id'] == $row['period_id']) {
										    echo 'selected';
										} else {
										    echo '';
										} ?> value="<?php echo $row['period_id'] ?>"><?php echo $row['period_start'].'/'.$row['period_end'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<label for="" class="col-sm-2 control-label">Cari Kreditur</label>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" class="form-control" autofocus name="r" id="hutang_noref" <?php echo (isset($f['r'])) ? 'placeholder="'.$f['r'].'"' : 'placeholder="No. Ref"' ?> required>
									<span class="input-group-btn">
										<button class="btn btn-success" type="submit">Cari</button>
									</span>
									<span class="input-group-btn">
									</span>
									<span class="input-group-btn">
									</span>
									<span class="input-group-btn">
									</span>
                					<span class="input-group-btn">
                					    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#dataKreditur"><b>Data No. Ref</b></button>
                					</span>
								</div>
							</div>
						</div>
					</form>
				</div><!-- /.box-body -->
			</div><!-- /.box -->

			<?php if ($f) { ?>

				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">Informasi Kreditur</h3>
						<?php if (isset($f['n']) AND isset($f['r'])) { ?>
							<a href="<?php echo site_url('manage/bayarhutang/printBook' . '/?' . http_build_query($f)) ?>" target="_blank" class="btn btn-danger btn-xs pull-right">Cetak Buku Hutang</a>
						<?php } ?>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="col-md-9">
							<table class="table table-striped">
								<tbody>
									<tr>
										<td width="200">Periode Hutang</td><td width="4">:</td>
										<?php foreach ($period as $row): ?>
											<?php echo (isset($f['n']) AND $f['n'] == $row['period_id']) ? 
											'<td>'.$row['period_start'].'/'.$row['period_end'].'</td>' : '' ?> 
										<?php endforeach; ?>
										<td width="200">Dicicil</td><td width="4">:</td>
										<?php foreach ($kreditur as $row): ?>
											<?php echo (isset($f['r']) AND $f['r'] == $row['hutang_noref']) ? 
											'<td>'.$row['hutang_cicil'].' Kali</td>' : '' ?> 
										<?php endforeach; ?>
									</tr>
									<tr>
										<td>Nama Kreditur</td>
										<td>:</td>
										<?php foreach ($kreditur as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['hutang_noref']) ? 
											'<td>'.$row['employee_name'].'</td>' : '' ?> 
										<?php endforeach; ?>
										<td width="200">Nominal per Cicilan</td><td width="4">:</td>
										<?php foreach ($kreditur as $row): ?>
											<?php echo (isset($f['r']) AND $f['r'] == $row['hutang_noref']) ? 
											'<td>Rp '.number_format($row['hutang_pay_bill'],'0',',','.').'</td>' : '' ?> 
										<?php endforeach; ?>
									</tr>
									<tr>
										<td>Posisi</td>
										<td>:</td>
										<?php foreach ($kreditur as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['hutang_noref']) ? 
											'<td>'.$row['position_name'].'</td>' : '' ?> 
										<?php endforeach; ?>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>No. Ref Hutang</td>
										<td>:</td>
										<?php foreach ($kreditur as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['hutang_noref']) ? 
											'<td>'.$row['hutang_noref'].'</td>' : '' ?> 
										<?php endforeach; ?>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>No. Ref Hutang</td>
										<td>:</td>
										<?php foreach ($kreditur as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['hutang_noref']) ? 
											'<td>'.pretty_date($row['hutang_input_date'], 'd F Y', false).'</td>' : '' ?> 
										<?php endforeach; ?>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>Nominal Hutang</td>
										<td>:</td>
										<?php foreach ($kreditur as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['hutang_noref']) ? 
											'<td>Rp '.number_format($row['hutang_bill'],'0',',','.').'</td>' : '' ?> 
										<?php endforeach; ?>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-3">
							<?php foreach ($kreditur as $row): ?>
								<?php if (isset($f['n']) AND $f['r'] == $row['hutang_noref']) { ?> 
									<?php if (!empty($row['employee_img'])) { ?>
										<img src="<?php echo upload_url('student/'.$row['employee_img']) ?>" class="img-thumbnail img-responsive">
									<?php } else { ?>
										<img src="<?php echo media_url('img/user.png') ?>" class="img-thumbnail img-responsive">
									<?php } 
								} ?>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<div class="row">

					<div class="col-md-5">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Transaksi Terakhir</h3>
							</div><!-- /.box-header -->
							
							<div class="box-body table-responsive">
							    <div class="over">
								<table class="table table-responsive table-bordered" style="white-space: nowrap;">
									<tr class="info">
										<th>Tanggal</th>
										<th>Nominal</th>
										<th>Keterangan</th>
									</tr>
									<?php 
									foreach ($history as $row) :
									?>
									<tr>
										<td><?php echo pretty_date($row['hutang_pay_input_date'], 'd F Y', false) ?></td>
										<td>Rp <?php echo number_format($row['hutang_pay_bill'],'0',',','.') ?></td>
										<td><?php echo ($row['hutang_pay_status'] == '1') ? 'Sudah Dibayar' : 'Belum Dibayar' ?></td>
									</tr>
								<?php endforeach ?>

								</table>
							</div>
						</div>
						</div>
						</div>
					
					<div class="col-md-4">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Rekap Hutang</h3>
							</div>
							<div class="box-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Total Hutang</label>
												<input type="text" class="form-control" name="total_setor" id="total_setor" value="<?php echo 'Rp '.number_format($sumHutang, '0', ',', '.') ?>" placeholder="Total Setoran" readonly="">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Total Terlunasi</label>
												<input type="text" class="form-control" name="total_tarik" id="total_tarik" value="<?php echo 'Rp '.number_format($sumHutangPay, '0', ',', '.') ?>" placeholder="Total Penarikan" readonly="">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Belum Lunas</label>
										<input type="text" class="form-control" readonly="" name="saldo" id="saldo"  value="<?php echo 'Rp '.number_format($sumHutang-$sumHutangPay, '0', ',', '.') ?>" placeholder="Sisa Hutang">
									</div>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Cetak Bukti Transaksi</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<form action="<?php echo site_url('manage/bayarhutang/cetakBukti') ?>" method="GET" class="view-pdf">
									<input type="hidden" name="n" value="<?php echo $f['n'] ?>">
									<input type="hidden" name="r" value="<?php echo $f['r'] ?>">
									<div class="form-group">
										<label>Tanggal Transaksi</label>
										<div class="input-group date " data-date="<?php echo date('Y-m-d') ?>" data-date-format="yyyy-mm-dd">
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
											<input class="form-control" readonly="" required="" type="text" name="d" value="<?php echo date('Y-m-d') ?>">
										</div>
									</div>
									<button class="btn btn-success btn-block" formtarget="_blank" type="submit">Cetak</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				
				<!-- List Tagihan Bulanan --> 
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Cicil Hutang</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
					    
					    <div class="row">
                    		<div class="col-md-3">
                    		    <label>Akun Kas *</label>
                    			<select required="" name="kas_account_id" id="kas_account_id" class="form-control">
                    			    <option value="">-- Pilih Akun Kas --</option>
                    			    <?php
                    			    foreach($dataKas as $row){
                    			    ?>
                                		<option value="<?php echo $row['account_id'] ?>" <?php echo($dataKasActive['account_id']==$row['account_id']) ? 'selected' : '' ?> > 
                                		<?php echo $row['account_code'].' - '.$row['account_description'];
                                		?>
                                		 </option>
                                	<?php	 
                        			 }
                    			    ?>
                    			</select>
                    		</div>
                    		<br>
					    </div>
					    <br>
						<div class="nav-tabs-custom">
							<div class="tab-content">
									<div class="box-body table-responsive">
										<table id="dtable" class="table table-bordered" style="white-space: nowrap;">
											<thead>
												<tr class="info">
													<th>No.</th>
													<th>Cicilan</th>
													<th>Nominal</th>
													<th>Keterangan</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i =1;
												foreach ($hutang_pay as $row):
												?>
												<tr>
													<td><?php echo $i ?></td>
													<td><?php echo 'Cicilan '.$i ?></td>
													<td>Rp <?php echo ($row['hutang_pay_status'] == '0') ? number_format($row['hutang_pay_bill'], 0, ',', '.') : pretty_date($row['hutang_pay_input_date'],'d/M/Y',false) ?></td>
													<td><?php echo ($row['hutang_pay_status'] == '1') ? 'Sudah Dibayar' : 'Belum Dibayar' ?></td><td>
											<a href="<?php echo ($row['hutang_pay_status'] ==0) ? site_url('manage/bayarhutang/pay/' . $row['hutang_pay_id']) : site_url('manage/payout/not_pay/' . 'manage/bayarhutang/not_pay/' . $row['hutang_pay_id'])?>" onclick="return confirm('<?php echo ($row['hutang_pay_status']==0) ? 'Anda Akan Melakukan Pembayaran Cicilan ini ?' : 'Anda Akan Menghapus Pembayaran Cicilan Ini ?' ?>')">
																	<?php echo ($row['hutang_pay_status'] == '0' ) ? '
										<button class="btn btn-sm btn-success" type="button">Bayar</button>' : '
										<button class="btn btn-sm btn-danger" type="button">Hapus Bayar</button>'  ?></a></td>
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
					</div>
				</div>
			</section>
		</div>
		
		<!-- Modal -->
		
		<div class="modal fade" id="dataKreditur" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Cari Data Kreditur</h4>
				</div>
				<div class="modal-body">
    <?php $dataHutang = $this->Hutang_model->get();
      
      echo '
            <div class="box-body table-responsive">
							<table id="dtable" class="table table-hover">
							    <thead>
								<tr>
									<th>No</th>
    								<th>No. Ref</th>
    								<th>Nama</th>
    								<th>Posisi</th>
    								<th>Hutang</th>
    								<th>Jumlah Angsuran</th>
    								<th>Angsuran</th>
									<th>Aksi</th>
								</tr>
								</thead>
								<tbody>';
									if (!empty($dataHutang)) {
										$i = 1;
										foreach ($dataHutang as $row):
						               echo '<tr>
												<td>'.$i.'</td>
										<td>'.$row['hutang_noref'].'</td>
										<td>'.$row['employee_name'].'</td>
										<td>'.$row['position_name'].'</td>
										<td>Rp. '. number_format($row['hutang_bill'], 0, ',', '.').'</td> 
										<td>'.$row['hutang_cicil'].' Kali</td> 
										<td>Rp. '. number_format($row['hutang_pay_bill'], 0, ',', '.').'</td>';
										echo '<td align="center">';
                                        echo '<button type="button" data-dismiss="modal" class="btn btn-primary btn-xs" onclick="ambil_data(';
                                        echo "'".$row['hutang_noref']."'";
                                        echo ')">Pilih</button>';
                                        echo '</td>';
										echo '</tr>';
											$i++;
										endforeach;
									} else {
									echo '<tr id="row">
											<td colspan="8" align="center">Data Kosong</td>
										</tr>';
									    }
							echo	'</tbody>
								</table>
							</div>
      '; ?>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
    				</div>
    			</div>
    		</div>
    	</div>
	</div>

<script>
    function ambil_data(noref){
            var norefHutang = noref;
            var thAjaran    = $("#th_ajar").val();
            
            window.location.href = '<?php echo base_url();?>manage/bayarhutang?n='+thAjaran+'&r='+norefHutang;
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
<style>
    div.over {
        width: 425px;
        height: 165px;
        overflow: scroll;
    }
    
    div.extended {
        width: 900px;
        height: 200px;
        overflow: scroll;
    }
</style>