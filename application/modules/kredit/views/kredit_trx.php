<script type="text/javascript" src="<?php echo media_url('js/jquery-migrate-3.0.0.min.js') ?>"></script>
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
				<div class="box">
					<div class="box-header"></div>
                	<div class="box-body">			
                	<div class="row">
                		<div class="col-md-3">
                			<label>Unit Sekolah *</label>
                			<select required="" name="majors_id" id="majors_id" class="form-control">
                			    <option value="">-Pilih Unit Sekolah-</option>
                			    <?php foreach($majors as $row){?>
                			        <option value="<?php echo $row['majors_id']; ?>" ><?php echo $row['majors_short_name'] ?></option>
                			    <?php } ?>
                			</select>
                		</div>
                		<div class="col-md-3">
                		</div>
                		<div class="col-md-3">
                		<label>Tanggal *</label>
                		<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
                			<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                			<input class="form-control" required="" type="text" name="kas_date" id="kas_date" placeholder="Tanggal Kas Keluar" value="<?php echo date('Y-m-d')?>">
                		</div>
                		</div>
                		<div class="col-md-3">
                		</div>
                	</div>
                	<div class="row">
                		<div class="col-md-3">
                		<div id="div_noref">
                			<label>No. Ref *</label>
                			<input type="text" required="" name="kas_noref" id="kas_noref" class="form-control" placeholder="Nomor Referensi" readonly="">
                		</div>
                		</div>
                		<div class="col-md-3">
                		</div>
                		<div class="col-md-3">
                		<div id="div_kas">
                		    <label>Akun Kas *</label>
                			<select required="" name="kas_account_id" id="kas_account_id" class="form-control">
                			    <option value="">-Pilih Akun Kas-</option>
                			</select>
                		</div>
                		</div>
                		<div class="col-md-3">
                		</div>
                	</div>
                	<div class="row">
                		<div class="col-md-3">
                			<label>Keterangan *</label>
                			<input type="text" required="" name="kas_note" id="kas_note" class="form-control" placeholder="Keterangan Kas Keluar">
                		</div>
                		<div class="col-md-3">
                		</div>
                		<div class="col-md-3">
                			<label>Total *</label>
                			<input type="text" required="" name="kas_value" id="kas_value" class="form-control" placeholder="Total Kas Keluar" readonly="">
                		</div>
                		<div class="col-md-3">
                		</div>
                	</div>
                </div>	
                </div>
            </div>
        </div>
		<div class="row">
			<div class="col-md-12">
				<div class="box">
                	<div class="box-body">
                	<div class="row">
                		<div class="col-md-2">
                		<div id="div_kode">
                			<label>Kode Akun *</label>
                			<select required="" name="kredit_account_id" id="kredit_account_id" class="form-control" required="">
                			    <option value="">-Pilih Kode Akun-</option>
                			</select>
                		</div>
                		</div>
                		<div class="col-md-3">
                			<label>Uraian *</label>
                			<input type="text" required="" name="kredit_desc" id="kredit_desc" class="form-control" placeholder="Uraian Kas Keluar">
                		</div>
                		<div class="col-md-2">
                			<label>Nominal (Rp.)*</label>
                			<input type="text" class="form-control" required="" name="kredit_value" id="kredit_value" class="form-control" placeholder="Jumlah">
                		</div>
                		<div class="col-md-2">
                		    <label>Pajak</label>
                		    <select name="kredit_tax_id" id="kredit_tax_id" class="form-control">
                			    <option value="0">0 %</option>
                			    <?php foreach($pajak as $row){?>
                			        <option value="<?php echo $row['tax_id']; ?>" ><?php echo $row['tax_number'] ?> %</option>
                			    <?php } ?>
                			</select>
                		</div>
                		<div id="div_item">
                		<div class="col-md-2">
                		    <label>Unit POS</label>
                		    <select name="kredit_item_id" id="kredit_item_id" class="form-control">
                			    <option value="0">Tidak Ada</option>
                			</select>
                		</div>
                		</div>
                		<div class="col-md-1">
                			<label><p> </p></label>
                			<input type="button" id="btn_simpan" class="btn btn-success btn-sm form-control" value="Tambah">
                		</div>
                	</div>
		
					<!-- /.box-header -->
					<div class="box-body table-responsive">
						<table class="table table-hover">
						    <thead>
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Kode Akun</th>
								<th>Keterangan</th>
								<th>Nominal (Rp.)</th>
								<th>Pajak</th>
								<th>Unit POS</th>
								<th>Total (Rp.)</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody id="show_data">
                        				
                        	</tbody>
						</table>
					    <div id="btnFinish">
					        <div class="row">
					            <br>
					            <div class="col-md-8">
					            </div>
					            <div class="col-md-2">
                			        <button id="btn_batal" class="btn btn-warning btn-block">Batal</button>
					            </div>
					            <div class="col-md-2">
					                <button id="btn_selesai" class="btn btn-primary btn-block">Simpan Transaksi</button>    
					            </div>
					            
					        </div>
					    </div>	
				    </div>
							<!-- /.box-body -->
						</div>
						<div>
						    <!-- -->
						</div>
						<!-- /.box -->
						</div>
					</div>
				</div>
			</section>
			<!-- /.content -->
		
	</div>
	
	<!--MODAL HAPUS-->
        <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                        <h4 class="modal-title" id="myModalLabel">Hapus Barang</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                          
                            <input type="hidden" name="id" id="id" value="">
                            <div class="alert alert-danger"><p>Apakah Anda yakin mau memhapus data ini?</p></div>
                                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button class="btn_hapus btn btn-danger" id="btn_hapus">Hapus</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--END MODAL HAPUS-->
        
	<script type="text/javascript">
	
	    function onChecked(checkbox) {
	        var id_majors    = $("#majors_id").val();
	        
            if(checkbox.checked == true){
                document.getElementById("kas_tax").removeAttribute("disabled");
            }else{
                document.getElementById("kas_tax").setAttribute("disabled", "disabled");
                
                $("#kas_tax").val(0);
        	    
        	    if(id_majors != ''){
                tampil_data();
        	    } else {
        	        alert("Unit Sekolah Belum Dipilih!");
        	    }
           }
        }
	    
		$("#btnFinish").hide();
		function tampil_data(){
		    var kas_noref    = $("#kas_noref").val();
		    
		    $.ajax({
		        type  : "POST",
		        url   : "<?php echo base_url()?>manage/kredit/data_trx/"+kas_noref,
		        contentType: "application/json; charset=utf-8",
		        dataType : "JSON",
		        success : function(data){
		            
		            var html    = '';
		            var total   = '';
		            var tax     = '';
		            var grand   = '';
		            var sum     = 0;
		            var sumLast = 0;
		            var tot   = 0;
		            var pajak = 0;
		            var pajakAll = 0;
		            var sumAll  = 0;
		            var no      = 1;
		            var i;
		            
		            const frmt = new Intl.NumberFormat('id-ID', {
                          style: 'currency',
                          currency: 'IDR',
                          minimumFractionDigits: 0
                        })
		            
		            for(i=0; i<data.length; i++){
		                
		                var date = new Date(data[i].kredit_temp_date);
                        var dd = date.getDate();
                        var mm = date.getMonth() + 1;
                        
                        var yyyy = date.getFullYear();
                        if (dd < 10) {
                          dd = '0' + dd;
                        } 
                        if (mm < 10) {
                          mm = '0' + mm;
                        } 
                        var date = dd + '/' + mm + '/' + yyyy;
                        
                        sum = parseInt(data[i].kredit_temp_value);
		                pajak = parseInt(data[i].kredit_temp_value*(data[i].kredit_temp_tax/100));
		                sumLast = parseInt(sum+pajak);
		                
		                sumAll += parseInt(data[i].kredit_temp_value);
		                pajakAll += parseInt(data[i].kredit_temp_value*(data[i].kredit_temp_tax/100));
                        
                        var nominal = frmt.format(sum);
                        
                        var lastNominal = frmt.format(sumLast);
		                
		                html += '<tr>'+
		                        '<td>'+no+'</td>'+
		                        '<td>'+date+'</td>'+
		                        '<td>'+data[i].account_code+' - '+data[i].account_description+'</td>'+
		                        '<td>'+data[i].kredit_temp_desc+'</td>'+
		                        '<td>'+nominal+'</td>'+
		                        '<td>'+data[i].kredit_temp_tax+' %</td>'+
		                        '<td>'+data[i].kredit_temp_item+'</td>'+
		                        '<td>'+lastNominal+'</td>'+
		                        '<td style="text-align:center;">'+
                                    '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+data[i].kredit_temp_id+'" title="Hapus"><i class="fa fa-trash"></i></a>'+
                                '</td>'+
		                        '</tr>';
		                        no++
		            }
                        
                    var number = frmt.format(sumAll);
                    
                    var taxNumber = frmt.format(pajakAll);
                    
                    var grandTotal = frmt.format(sumAll+pajakAll);
	                        
		            total += '<tr>'+
	                        '<td colspan="4"></td><td style="text-align:left;"><b>Subtotal</b></td>'+
	                        '<td colspan="2"><b>Pajak</b></td>'+
	                        '<td colspan="2"><b>Grand Total (Subtotal + Pajak)</b></td>'+
	                        '</tr>';
                    
                    tax += '<tr>'+
	                        '<td colspan="4"></td>'+
	                        '<td>'+number+'</td>'+
	                        '<td colspan="2">'+taxNumber+'</td>'+
	                        '<td colspan="2">'+grandTotal+'</td>'+
	                        '</tr>';
	                        
                    var res = html.concat(total, tax);
                    
		            $('#show_data').html(res);
		            $('#kas_value').val(sumAll+pajakAll);
		        }

		    });
		}
	
        $(document).ready(function(){
            $("#majors_id").change(function(e){
        	    var id_majors    = $("#majors_id").val();
        	    
                $.ajax({ 
                    url: '<?php echo base_url();?>manage/kredit/cari_ref',
                    type: 'POST', 
                    data: {
                            'id_majors' : id_majors,
                    },    
                    success: function(msg) {
                            $("#div_noref").html(msg);
                    },
        			error: function(msg){
        					alert('msg');
        			}
                    
                });
        		e.preventDefault();
        	});
        	
        	$("#majors_id").change(function(e){
        	    var id_majors    = $("#majors_id").val();
        	    
                $.ajax({ 
                    url: '<?php echo base_url();?>manage/kredit/cari_kas',
                    type: 'POST', 
                    data: {
                            'id_majors': id_majors,
                    },    
                    success: function(msg) {
                            $("#div_kas").html(msg);
                            tampil_data();
		                    $("#btnFinish").show();
                    },
        			error: function(msg){
        					alert('msg');
        			}
                    
                });
        		e.preventDefault();
        	});
        	
        	$("#majors_id").change(function(e){
        	    var id_majors    = $("#majors_id").val();
        	    
                $.ajax({ 
                    url: '<?php echo base_url();?>manage/kredit/cari_kode',
                    type: 'POST', 
                    data: {
                            'id_majors': id_majors,
                    },    
                    success: function(msg) {
                            $("#div_kode").html(msg);
                    },
        			error: function(msg){
        					alert('msg');
        			}
                    
                });
        		e.preventDefault();
        	});
        	
        	$("#majors_id").change(function(e){
        	    var id_majors    = $("#majors_id").val();
        	    
                $.ajax({ 
                    url: '<?php echo base_url();?>manage/kredit/cari_unit_pos',
                    type: 'POST', 
                    data: {
                            'id_majors': id_majors,
                    },    
                    success: function(msg) {
                            $("#div_item").html(msg);
                    },
        			error: function(msg){
        					alert('msg');
        			}
                    
                });
        		e.preventDefault();
        	});
        	
        	$("#kas_tax").change(function(e){
        	    var id_majors    = $("#majors_id").val();
        	    
        	    if(id_majors != ''){
                tampil_data();
        	    } else {
        	        alert("Unit Sekolah Belum Dipilih!");
        	    }
        	});

		//Simpan Barang
		$('#btn_selesai').on('click',function(){
            var majors_id=$("#majors_id").val();
            var kas_noref=$("#kas_noref").val();
            var kas_date=$("#kas_date").val();
            var kas_account_id=$("#kas_account_id").val();
            var kas_note=$("#kas_note").val();
            var kas_value=$("#kas_value").val();
            
            if(majors_id != '' && kas_noref != '' && kas_date != '' && kas_account_id != '' && kas_note != ''){
            $.ajax({
                type : "POST",
                url   : "<?php echo base_url()?>manage/kredit/save_trx",
                //secureuri: false,
                //fileElementId: "kas_reciept",
                dataType : "JSON",
                data : {
                        'majors_id':majors_id, 
                        'kas_noref':kas_noref, 
                        'kas_date':kas_date, 
                        'kas_account_id':kas_account_id, 
                        'kas_note':kas_note,
                        'kas_value':kas_value,
                    },
                /*
                cache: false,
                processData: false,
                contentType: false,
                */
                success: function(data){
                    changeLoc();
                },
    			error: function(msg){
    					alert('msg');
    			}
            });
            return false;
            } else {
                alert("Ada Kolom yang Kosong, Tolong Dicek Kembali.");    
            }
        });
        
        $('#btn_simpan').on('click',function(){
            var kas_note=$("#kas_note").val();
            var majors_id=$("#majors_id").val();
            var kas_noref=$("#kas_noref").val();
            var kas_date=$("#kas_date").val();
            //var kas_account_id=("kas_account_id").val();
            var kas_account_id=$("#kas_account_id").val();
            var kredit_account_id=$("#kredit_account_id").val();
            var kredit_desc=$("#kredit_desc").val();
            var kredit_value=$("#kredit_value").val();
            var kredit_tax_id=$("#kredit_tax_id").val();
            var kredit_item_id=$("#kredit_item_id").val();
            
            if(majors_id != '' && kas_noref != '' && kas_date != '' && kas_account_id != '' && kredit_account_id != '' && kredit_desc != '' && kredit_value != ''){
            $.ajax({
                type : "POST",
                url   : "<?php echo base_url()?>manage/kredit/add_trx",
                dataType : "JSON",
                data : {
                        'majors_id':majors_id, 
                        'kas_noref':kas_noref, 
                        'kas_account_id':kas_account_id, 
                        'kas_date':kas_date, 
                        'kredit_account_id':kredit_account_id, 
                        'kredit_desc':kredit_desc, 
                        'kredit_value':kredit_value,
                        'kredit_tax_id':kredit_tax_id,
                        'kredit_item_id':kredit_item_id,
                    },
                success: function(data){
                    if(kas_note == ''){
                        var note = kredit_desc;
                    }else{
                        var note = kas_note + ', ' + kredit_desc;
                    }
                    $('[name="kas_note"]').val(note);
                    $('[name="kredit_account_id"]').val("");
                    $('[name="kredit_desc"]').val("");
                    $('[name="kredit_value"]').val("");
                    $('[name="kredit_tax_id"]').val("0");
                    $('[name="kredit_item_id"]').val("0");
                    tampil_data();
                },
    			error: function(msg){
    					alert('msg');
    			}
            });
            return false;
            } else {
                alert("Ada Kolom yang Kosong, Tolong Dicek Kembali.");
            }
        });
        
        $('#btn_batal').on('click',function(){
            var kas_noref=$("#kas_noref").val();
            $.ajax({
                type : "POST",
                url   : "<?php echo base_url()?>manage/kredit/cancel_trx",
                dataType : "JSON",
                data : { 
                        'kas_noref':kas_noref,
                    },
                success: function(data){
                    window.location.href = '<?php echo base_url()?>manage/kredit';
                },
    			error: function(msg){
    					alert('msg');
    			}
            });
            return false;
        });
        
		//GET HAPUS
		$('#show_data').on('click','.item_hapus',function(){
            var id=$(this).attr('data');
            $('#ModalHapus').modal('show');
            $('[name="id"]').val(id);
        });

        //Hapus Barang
        $('#btn_hapus').on('click',function(){
            var id=$('#id').val();
            $.ajax({
            type : "POST",
            url  : "<?php echo base_url('manage/kredit/del_trx')?>",
            dataType : "JSON",
                    data : {
                            'id': id
                        },
                    success: function(data){
                            $('#ModalHapus').modal('hide');
                            tampil_data();
                    }
                });
                return false;
            });

	});
	
    function changeLoc() {
    	window.location.href = '<?php echo base_url()?>manage/kredit';
    }

</script>
<?php $this->load->view('manage/rupiah'); ?>