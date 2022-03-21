<?php
$nama=getValue("employee_name","employee","employee_id='".$f['employee_id']."'");
?>
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
        <font size="3"><strong><?=$nama?></strong></font>
        <br>   
        <br>   
        <form action="<?=site_url('manage/rekap_presensi/rekap_detil')?>" method="get">
        <input type="hidden" name="employee_id" value="<?=$f['employee_id']?>"/>
        PERIODE : <input type="date" name="tgl_awal" value="<?=$tgl_awal?>" onchange="this.form.submit()" /> s/d <input type="date" name="tgl_akhir" value="<?=$tgl_akhir?>" onchange="this.form.submit()" /> 
        </form>
      </center><br /><br />   
      <table class="table table-bordered" width="100%" style="border-collapse:collapse">
        <thead>   
          <tr class="info" height="30">   
            <td rowspan=2 align="center" class="td">No</td>
            <td rowspan=2 align="center" class="td">Tanggal</td>
            <td colspan=3 align="center" class="td">Datang</td>
            <td colspan=3 align="center" class="td">Pulang</td>
          </tr>
          <tr class="info" height="30">   
            <td align="center" class="td">Jam</td>
            <td align="center" class="td">Lokasi</td>
            <td align="center" class="td">Status</td>
            <td align="center" class="td">Jam</td>
            <td align="center" class="td">Lokasi</td>
          </tr>
        <thead>
        <tbody>
          <?php
          $no=1;
          foreach($rekap_absensi_detil as $row):

            $tgl=$row['tanggal'];
            $idp=$row['id_pegawai'];

            $jam_datang=getValue("min(time)","data_absensi","id_pegawai='$idp' and jenis_absen='DATANG' and tanggal='$tgl'");
            $jam_pulang=getValue("max(time)","data_absensi","id_pegawai='$idp' and jenis_absen='PULANG' and tanggal='$tgl'");
            
            $lokasi_datang=getValue("min(lokasi)","data_absensi","id_pegawai='$idp' and jenis_absen='DATANG' and tanggal='$tgl'");
            $lokasi_pulang=getValue("max(lokasi)","data_absensi","id_pegawai='$idp' and jenis_absen='PULANG' and tanggal='$tgl'");

            $time_datang=$jam_datang;

            if ($time_datang == "" || $time_datang==null)
            {
              $status_datang="TIDAK MASUK (".$row['jenis_absen'].")";
            }
            elseif ($time_datang <= "07:16:00")
            {
              $status_datang="ONTIME";
            }
            else
            {
              $status_datang="TERLAMBAT";
            }

          ?>
          <tr>
            <td><?=$no++?></td>
            <td><?=$row['tanggal']?></td>
            <td><?=$jam_datang?></td>
            <td><?=$lokasi_datang?></td>
            <td>Status : <?=$status_datang?><br>Catatan Absen : <?=$row['catatan_absen']?></td>
            <td><?=$jam_pulang?></td>
            <td><?=$lokasi_pulang?></td>
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