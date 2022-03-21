<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>REKAPITULASI ABSENSI </title>
    <link rel="icon" type="image/png" href="<?php echo media_url('ico/favicon.ico') ?>">
    <style>
      a {
          color: #000000;
          font-weight: bold;
          font-family: Verdana;
          font-size: 11px;
          text-decoration: none;
      }
      tr, td {
          font-family: Verdana;
          font-size: 11px;
          border-collapse: collapse;
      }
      .td {
          font-weight: bold;
          font-family: Verdana;
          font-size: 11px;
          text-decoration: none;
          border-collapse: collapse;
      }
      .table>tbody>tr.info>td, .table>tbody>tr.info>th, .table>tbody>tr>td.info, .table>tbody>tr>th.info, .table>tfoot>tr.info>td, .table>tfoot>tr.info>th, .table>tfoot>tr>td.info, .table>tfoot>tr>th.info, .table>thead>tr.info>td, .table>thead>tr.info>th, .table>thead>tr>td.info, .table>thead>tr>th.info {
          background-color: #d9edf7;
      }
      .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
          border: 1px solid #f4f4f4;
      }
      .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
          border: 1px solid #ddd;
      }
      .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
          padding: 8px;
          line-height: 1.42857143;
      }
      a:hover {
        color: red;
      }
    </style>
  </head>
  <body>

<table border="0" cellpadding="10" cellpadding="5" width="100%" align="left">   
  <tr>
    <td align="left" valign="top">   
      <center>   
        <font size="4"><strong>REKAPITULASI ABSENSI</strong></font><br/>
        <br>   
        PERIODE : <?=$tgl_awal?> s/d <?=$tgl_akhir?>
        <br>
        <br>
        <a href="<?php echo site_url('manage/rekap_presensi/export_excel')?>?tgl_awal=<?=$tgl_awal?>&tgl_akhir=<?=$tgl_akhir?>&majors_id=<?=$f['majors_id']?>" ><img src="<?php echo upload_url('absensi/excel.png')?>" border="0"/>Cetak Excel</a> 
      </center><br /><br />   
      <table class="table table-bordered" width="100%" style="border-collapse:collapse">
        <thead>   
          <tr class="info" height="30">   
            <td rowspan=3 align="center" class="td">No</td>
            <td colspan=4 align="center" class="td">Data</td>
            <td colspan=3 align="center" class="td">Keterangan</td>
            <td rowspan=3 align="center" class="td">Score</td>
          </tr>
          <tr class="info" height="30">   
            <td width="250" rowspan=2 align="center" class="td">Nama Lengkap</td>
            <td rowspan=2 align="center" class="td">Tanggal Masuk</td>
            <!-- <td colspan=3 align="center" class="td">Usia Kerja</td> -->
            <td rowspan=2 align="center" class="td">Jabatan</td>
            <td rowspan=2 align="center" class="td">Unit Kerja</td>
            <td colspan=3 align="center" class="td">Rekap Kehadiran</td>
          </tr>
        
          <tr class="info" height="30">   
            <!-- <td width="100" align="center" class="td">Tahun</td>   
            <td width="100" align="center" class="td">Bulan</td>   
            <td width="100" align="center" class="td">Hari</td>    -->
            <td width="100" align="center" class="td">Hadir</td>      
            <td width="100" align="center" class="td">Terlambat</td>   
            <td width="100" align="center" class="td">Ijin</td>   
          </tr>
        <thead>
        <tbody>
          <?php
          $no=1;
          foreach($rekap_absensi as $row):
            $lahir=new DateTime($row['employee_start']);
            $today =new DateTime();
            $umur=$today->diff($lahir);

            $idp=$row['employee_id'];

            $hadir = $this->db->query("select id from data_absensi where id_pegawai='$idp' and (tanggal between '$tgl_awal' and '$tgl_akhir') and jenis_absen='DATANG'");
            $hadir=$hadir->num_rows();

            $ijin = $this->db->query("select id from data_absensi where id_pegawai='$idp' and (tanggal between '$tgl_awal' and '$tgl_akhir') and (jenis_absen='IJIN' or jenis_absen='SAKIT' or jenis_absen='CUTI' or jenis_absen='LAIN-LAIN')");
            $ijin=$ijin->num_rows();

            $terlambat = $this->db->query("select id from data_absensi where id_pegawai='$idp' and (tanggal between '$tgl_awal' and '$tgl_akhir') and jenis_absen='DATANG' and time >= '07:16:00'");
            $terlambat=$terlambat->num_rows();

            // $score= round(((intval($hadir) - intval($terlambat)) / intval($hadir)) * 100,2);
            $score=((intval($hadir) - intval($terlambat))!==0)?(round(((intval($hadir) - intval($terlambat)) / intval($hadir)) * 100,2)):0;

            if(is_nan($score)){
              $score=0;
            }

          ?>
          <tr>
            <td><?=$no++?></td>
            <td><a href="javascript:open_window('<?php echo site_url('manage/rekap_presensi/rekap_detil')?>?tgl_awal=<?=$tgl_awal?>&tgl_akhir=<?=$tgl_akhir?>&employee_id=<?=$row['employee_id']?>')"><?=$row['employee_name']?></a></td>
            <td><?=$row['employee_start']?></td>
            <!-- <td><?=$umur->y." Tahun"?></td>
            <td><?=$umur->m." Bulan"?></td>
            <td><?=$umur->d." Hari"?></td> -->
            <td><?=$row['jabatan']?></td>
            <td><?=$row['nama_unit']?></td>
            <td><?=$hadir?></td>
            <td><?=$terlambat?></td>
            <td><?=$ijin?></td>
            <td><?=$score."%"?></td>
          </tr>
          <?php
          endforeach;
          ?>
        </tbody>
      </table>   
    </td>   
  </tr>   
  <!-- END TABLE CENTER -->       
</table>

  </body>
</html>
<script>
function open_window(url) {    
  newWindow(""+url+"", "popup","1800","1600","resizable=0,scrollbars=1,status=0,toolbar=0") 
}
</script>
<script>
    // JavaScript New Window
	var win = null;
	function newWindow(mypage,myname,w,h,features) {
		var winl = (screen.width-w)/2;
		var wint = (screen.height-h)/2;
		if (winl < 0) winl = 0;
		if (wint < 0) wint = 0;
		var settings = 'height=' + h + ',';
		settings += 'width=' + w + ',';
		settings += 'top=' + wint + ',';
		settings += 'left=10,';
		settings += features;
		win = window.open(mypage,myname,settings);
		win.window.focus();
	}
</script>