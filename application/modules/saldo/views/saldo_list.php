<style type="text/css">

td {
	cursor: pointer;
}

.editor{
	display: none;
}

</style>
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
	    <?php 
	        $majors_id = $this->session->userdata('umajorsid'); 
	    ?>
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header">
					    <?php if($majors_id == '0') { ?>
    					<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
    					<div class="box-body table-responsive">
							<table>
							    <tr>
							        <td>     
    								<select style="width: 200px;" id="m" name="m" class="form-control" required>
    								    <option value="">-- Pilih Unit Sekolah --</option>
            						    <?php foreach($majors as $row){?>
            						    <option value="<?php echo $row['majors_id']; ?>" <?php echo (isset($s['m']) && $s['m'] == $row['majors_id']) ? 'selected' : '' ?> ><?php echo $row['majors_short_name'] ?></option>
            						    <?php } ?>
    								</select>
							        </td>
							        <td>
							            &nbsp&nbsp
							        </td>
							        <td>
							        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Pilih</button>    
							        </td>
							    </tr>
							</table>
						</div>
						<?php echo form_close(); ?>
						<?php } ?>
					    </div>
					<!-- /.box-header -->
					<?php if(isset($s['m'])){ ?>
					<div class="box-body table-responsive">
						<table id='dtable' class='table table-hover table-responsive'>
                            <thead>
                                <tr>
    								<th>No</th>
    								<th>Kode Akun</th>
    								<th>Keterangan</th>
    								<th>Debit</th>
    								<th>Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if(isset($s['m'])){
                                    $majorsID = $s['m'];
                                    $piece = "account_majors_id = '$majorsID' AND";
                                } else {
                                    $piece = "";
                                }
                            
                                $sql_main = "SELECT account.account_id, account.account_code, account.account_description, IF(saldo_awal.saldo_awal_debit IS NOT NULL, saldo_awal.saldo_awal_debit, 0) account_debit, IF(saldo_awal.saldo_awal_kredit IS NOT NULL, saldo_awal.saldo_awal_kredit, 0) account_kredit FROM `account` LEFT JOIN saldo_awal ON saldo_awal.saldo_awal_account = account.account_id LEFT JOIN majors ON majors.majors_id = account.account_majors_id WHERE account_note = '0' ORDER BY account_code ASC";
                                $main_account = $this->db->query($sql_main)->result();
                                $no = 1;
                                foreach ($main_account as $main) {
                                
                                $main_id = $main->account_id;
                                $sql_sub = "SELECT account.account_id, account.account_code, account.account_description, IF(saldo_awal.saldo_awal_debit IS NOT NULL, saldo_awal.saldo_awal_debit, 0) account_debit, IF(saldo_awal.saldo_awal_kredit IS NOT NULL, saldo_awal.saldo_awal_kredit, 0) account_kredit FROM `account` LEFT JOIN saldo_awal ON saldo_awal.saldo_awal_account = account.account_id LEFT JOIN majors ON majors.majors_id = account.account_majors_id WHERE $piece account_note = '$main_id' ORDER BY account_code ASC";
                                $sub_account = $this->db->query($sql_sub)->result();
                                
                                if (count($sub_account) > 0) {
                            ?>        
                            <tr style="font-weight: bold;">
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $main->account_code ?></td>
                                <td><?php echo $main->account_description ?></td>
                                <td> - </td>
                                <td> - </td>
                            </tr>
                            <?php
                                foreach($sub_account as $sub){
                            
                                $sub_id = $sub->account_id;
                                $sql_child = "SELECT account.account_id, account.account_code, account.account_description, IF(saldo_awal.saldo_awal_debit IS NOT NULL, saldo_awal.saldo_awal_debit, 0) account_debit, IF(saldo_awal.saldo_awal_kredit IS NOT NULL, saldo_awal.saldo_awal_kredit, 0) account_kredit FROM `account` LEFT JOIN saldo_awal ON saldo_awal.saldo_awal_account = account.account_id LEFT JOIN majors ON majors.majors_id = account.account_majors_id WHERE $piece account_note = '$sub_id' ORDER BY account_code ASC";
                                $child_account = $this->db->query($sql_child)->result();
                                
                                if (count($child_account) > 0) {
                            ?>        
                            <tr style="font-weight: bold;">
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $sub->account_code ?></td>
                                <td><?php echo $sub->account_description ?></td>
                                <td> - </td>
                                <td> - </td>
                             </tr>                   
                        <?php
                            foreach($child_account as $child) {
                                
                            $child_id = $child->account_id;
                            $sql_grandchild = "SELECT account.account_id, account.account_code, account.account_description, IF(saldo_awal.saldo_awal_debit IS NOT NULL, saldo_awal.saldo_awal_debit, 0) account_debit, IF(saldo_awal.saldo_awal_kredit IS NOT NULL, saldo_awal.saldo_awal_kredit, 0) account_kredit FROM `account` LEFT JOIN saldo_awal ON saldo_awal.saldo_awal_account = account.account_id LEFT JOIN majors ON majors.majors_id = account.account_majors_id WHERE $piece account_note = '$child_id' ORDER BY account_code ASC";
                            $grandchild_account = $this->db->query($sql_grandchild)->result();
                            
                            if (count($grandchild_account) > 0) {
                        ?>
                        <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $child->account_code ?></td>
                                <td><?php echo $child->account_description ?></td>
                                <td><span class="caption" data-id="<?php echo $child->account_id ?>"><?php echo $child->account_debit ?></span> <input type="text" class="field-debit form-control editor" value="<?php echo $child->account_debit ?>" data-id="<?php echo $child->account_id ?>" data-toggle="tooltip" title="Tekan Enter Setelah Selesai!" /></td>
                                <td><span class="caption" data-id="<?php echo $child->account_id ?>"><?php echo $child->account_kredit ?></span> <input type="text" class="field-kredit form-control editor" value="<?php echo $child->account_kredit ?>" data-id="<?php echo $child->account_id ?>" data-toggle="tooltip" title="Tekan Enter Setelah Selesai!" /></td>
                            </tr>
                        <?php 
                            foreach($grandchild_account as $grandchild) {
                        ?>
                        
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $grandchild->account_code ?></td>
                                <td><?php echo $grandchild->account_description ?></td>
                                <td><span class="caption" data-id="<?php echo $grandchild->account_id ?>"><?php echo $grandchild->account_debit ?></span> <input type="text" class="field-debit form-control editor" value="<?php echo $grandchild->account_debit ?>" data-id="<?php echo $grandchild->account_id ?>" data-toggle="tooltip" title="Tekan Enter Setelah Selesai!" /></td>
                                <td><span class="caption" data-id="<?php echo $grandchild->account_id ?>"><?php echo $grandchild->account_kredit ?></span> <input type="text" class="field-kredit form-control editor" value="<?php echo $grandchild->account_kredit ?>" data-id="<?php echo $grandchild->account_id ?>" data-toggle="tooltip" title="Tekan Enter Setelah Selesai!" /></td>
                            </tr>
                        <?php    
                            }
                            } else { 
                        ?>
                        
                        	<tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $child->account_code ?></td>
                                <td><?php echo $child->account_description ?></td>
                                <td><span class="caption" data-id="<?php echo $child->account_id ?>"><?php echo $child->account_debit ?></span> <input type="text" class="field-debit form-control editor" value="<?php echo $child->account_debit ?>" data-id="<?php echo $child->account_id ?>" data-toggle="tooltip" title="Tekan Enter Setelah Selesai!" /></td>
                                <td><span class="caption" data-id="<?php echo $child->account_id ?>"><?php echo $child->account_kredit ?></span> <input type="text" class="field-kredit form-control editor" value="<?php echo $child->account_kredit ?>" data-id="<?php echo $child->account_id ?>" data-toggle="tooltip" title="Tekan Enter Setelah Selesai!" /></td>
                            </tr>
                        <?php
                            }
                            }
                            } else {
                        ?>
                      	    <tr style="font-weight: bold;">
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $sub->account_code ?></td>
                                <td><?php echo $sub->account_description ?></td>
                                <td> - </td>
                                <td> - </td>
                            </tr>
                        <?php
                            }
                            }
                            } else {
                        ?>
                            <tr style="font-weight: bold;">
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $main->account_code ?></td>
                                <td><?php echo $main->account_description ?></td>
                                <td> - </td>
                                <td> - </td>
                            </tr>  
                        <?php
                                }
                            }
                        ?>
                        </tbody>
                        <tr>
                        <td colspan = "5" id="saldo_awal">
						</td>
						</tr>
                        </table>
						</div>
						<?php } ?>
						<!-- /.box-body -->
					</div>
					<div>
						<?php echo $this->pagination->create_links(); ?>
					</div>
					<!-- /.box -->
				</div>
			</div>
		</section>
		<!-- /.content -->
	</div>
	
	<script type="text/javascript">
	
	get_total();
    
    $(function(){
    
    $.ajaxSetup({
    	type:"POST",
    	cache:false,
    });
    
    $(document).on("click","td",function(){
        $(this).find("span[class~='caption']").hide();
        $(this).find("input[class~='editor']").fadeIn().focus();
    });
    
    $(document).on("keydown",".editor",function(e){
        
        if(e.keyCode==13){
            
            var target=$(e.target);
            var value=target.val();
            var id=target.attr("data-id");
            var data={id:id,value:value};
            
            if (target.is(".field-debit")){
            data.modul="saldo_awal_debit";
            } else if (target.is(".field-kredit")){
            data.modul="saldo_awal_kredit";
            }
            
                $.ajax({
                	data:data,
                	url: '<?php echo base_url();?>manage/saldo/add',
                	success: function(msg){
                    $("span[class~='caption']").show();
                    $("[data-toggle='tooltip']").tooltip('hide');
                    $("input[class~='editor']").fadeOut();
                	 target.hide();
                	 target.siblings("span[class~='caption']").html(value).fadeIn();
                	 get_total();
                	}
                
                })
            
        }
    
    });
    
    })
    
    function get_total(){
        
        var id_majors    = $("#m").val();
        	    
        $.ajax({ 
            url: '<?php echo base_url();?>manage/saldo/get_total',
            type: 'POST', 
        	cache:false,
            data: {
                    'id_majors' : id_majors,
            },    
            success: function(msg) {
                    $("#saldo_awal").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
		
    }
    </script>
