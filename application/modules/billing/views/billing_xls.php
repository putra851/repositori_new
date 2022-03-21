<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Laporan_Tagihan_Kelas.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="1">
    <thead>
	<tr>
		<th>No. </th> 
		<th>NIS</th> 
		<th>Nama</th>
		<th>Kelas</th>
		<th>Total Tagihan</th>
	</tr>
	</thead>
	<tbody>
	<?php 
	
	    $no = 1;
	    foreach ($student as $row) : 
	    $billMonth = 0;
	    $billFree = 0;
	    $params = array();
	    $params['student_id']   = $row['student_id'];
	    $params['period_id']    = $q['p'];
	    $params['class_id']     = $q['c'];
	    $params['majors_id']    = $q['k'];
	    $params['month_start']  = $q['d'];
	    $params['month_end']    = $q['s'];
	    
        $month = $this->Billing_model->get_tagihan_bulan($params);
        $free  = $this->Billing_model->get_tagihan_bebas($params);
	?>
		<tr>
			<td align="center"><?php echo $no++ ?></td>
			<td align="center"><?php echo $row['student_nis']?></td> 
			<td><?php echo $row['student_full_name']?></td>
			<td align="center"><?php echo $row['class_name']?></td>
			<td>
			    <?php
			        foreach($month as $mon){
			            $billMonth += $mon['bulan_bill'];      
			        }
			        foreach($free as $fr){
                        $billFree += $fr['bebas_bill'] - $fr['bebas_total_pay'];
			        }
			        echo 'Rp '.number_format($billMonth + $billFree,0,",",".");
			    ?>
			</td>
		</tr>
		<tr id="collapse<?php echo $row['student_id']; ?>" class="collapse">
		    <td></td>
		    <td colspan="4">
		        <table border="1">
		            <thead>
		                <th>
		                   Rician Tagihan
		                </th>
		                <th>
		                </th>
		                <th>
		                </th>
		                <th>
		                    Nominal
		                </th>
		            </thead>
		            <tbody>
		    <?php
            
		    $billBulan = 0;
		    $billBebas = 0;
		    $params = array();
		    $params['student_id']   = $row['student_id'];
		    $params['period_id']    = $q['p'];
		    $params['class_id']     = $q['c'];
		    $params['majors_id']    = $q['k'];
		    $params['month_start']  = $q['d'];
		    $params['month_end']    = $q['s'];
		    
            $bulan = $this->Billing_model->get_tagihan_bulan($params);
            $bebas = $this->Billing_model->get_tagihan_bebas($params);
		    foreach($bulan as $row): ?>
		    <tr>
                <td><?php echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'].'-'.$row['month_name'] ?>
                </td>
                <td>
                </td>
                <td align="right">
                    Rp
                </td>
                <td align="right">
                <?php echo number_format($row['bulan_bill'],0,",",".") ?>
                </td>
            <?php $billBulan += $row['bulan_bill']; ?>
            </tr>
	        <?php endforeach; ?>
		    <?php foreach($bebas as $row): ?>
		    <tr>
                <td><?php echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'] ?>
                </td>
                <td>
                </td>
                <td align="right">
                    Rp
                </td>
                <td align="right">
                <?php echo number_format($row['bebas_bill']-$row['bebas_total_pay'],0,",",".") ?>
                </td>
            <?php $billBebas += $row['bebas_bill']-$row['bebas_total_pay']; ?>
            </tr>
	        <?php endforeach ?>
            <tr style="background-color: #f0f0f0">
                <td><b><?php echo 'Total Tagihan' ?></b>
                </td>
                <td>
                </td>
                <td align="right">
                    Rp
                </td>
                <td align="right">
                <?php echo number_format($billBulan+$billBebas,0,",",".") ?>
                </td>
            </tr>
            </tbody>
	        </table>
	            </td>
		    </tr>
	<?php endforeach ?>
	        <?php
	            $kelas = $this->Student_model->get_class(array('id'=>$q['c']));
	        ?>
	        <tr style="background-color: #f0f0f0;">
	            <td><td>
	            <td colspan="2" align="center">
	                <b>Total Tagihan Kelas <?php echo $kelas['class_name'] ?></b>
	            </td>
	            <td>
                <?php
                    $billM = 0;
				    $billF = 0;
				    $params = array();
				    $params['period_id']    = $q['p'];
				    $params['class_id']     = $q['c'];
				    $params['majors_id']    = $q['k'];
				    $params['month_start']  = $q['d'];
				    $params['month_end']    = $q['s'];
				    
                    $m = $this->Billing_model->get_tagihan_bulan($params);
                    $f  = $this->Billing_model->get_tagihan_bebas($params);
                    
                    foreach ($m as $m){
                        $billM += $m['bulan_bill'];
                    }
                    
                    foreach ($f as $f){
                        $billF += $f['bebas_bill']-$f['bebas_total_pay'];
                    }
                    
                    echo "Rp ".number_format($billM+$billF,0,",",".")
                ?>
	            </td>
	        </tr>
    </tbody>
</table>