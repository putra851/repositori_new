<?php     
header("Content-Type: application/vnd.ms-excel"); //IE and Opera    
header("Content-Type: application/x-msexcel"); // Other browsers    
header("Content-Disposition: attachment; filename=Data_Libur_Presensi_".date('YmdHis').".xls");  
header("Expires: 0");    
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");      
?>  
<html>  
<head>  
<title>  
DATA LIBUR PRESENSI
</title>  
<style type="text/css">    
.style1 {color: #FFFFFF}  
.style2 {font-size: 14px}    
</style>  
</head>  
<body>  
<table width="900" border="0">  
  <tr>  
    <td>  
<table border="0">  
    <tr HEIGHT="1">  
    <td colspan="5"></td>  
    </tr>  
<tr>  
    <td colspan="5"><div align="center"><FONT SIZE="5" COLOR="">DATA LIBUR PRESENSI</FONT></div></td>  
    </tr>  
  <tr>  
    <td colspan="5"></td>  
  </tr>  
</table>  
    </td>  
  </tr>  
  <tr>  
    <td><table border="1" id="table" class="tab" bordercolor="#000000">  
    <tr HEIGHT="30" BGCOLOR="#808080">   
        <th>No</th>
        <th>HARI</th>
        <th>KETERANGGAN</th>
    </tr>
<?php  
$no=1;  
foreach ($presensi_data_libur as $row):  
  ?>  
    <tr height="25">   
        <td><?=$no++?></td>
        <td><?=$row[hari]?></td>
        <td><?=$row[keterangan]?></td>
    </tr>   
  <?php  
endforeach;  
  ?>    
</table></td>  
  </tr>  
  
  </table>  
</body>  
</html>  
