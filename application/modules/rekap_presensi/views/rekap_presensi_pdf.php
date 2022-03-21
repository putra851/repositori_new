<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>REKAPITULASI ABSENSI </title>
    <link rel="icon" type="image/png" href="<?php echo media_url('ico/favicon.ico') ?>">
    <style>
      @page {
          margin-top: 0.5cm;
          /*margin-bottom: 0.1em;*/
          margin-left: 1cm;
          margin-right: 1cm;
          margin-bottom: 0.1cm;
      }
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
        TANGGAL : <?=$tgl_awal?> s/d <?=$tgl_akhir?>
      </center><br /><br />   
      <table class="table table-bordered" border=1 style="border-collapse:collapse">
        <thead>   
          <tr bgcolor=#d9edf7 height="30">   
            <td rowspan=3 align="center" class="td">No</td>
            <td colspan=7 align="center" class="td">Data</td>
            <td colspan=3 align="center" class="td">Keterangan</td>
            <td rowspan=3 align="center" class="td">Score</td>
          </tr>
          <tr bgcolor=#d9edf7 height="30">   
            <td width="300" rowspan=2 align="center" class="td">Nama Lengkap</td>
            <td rowspan=2 align="center" class="td">Tanggal Masuk</td>
            <td colspan=3 align="center" class="td">Usia Kerja</td>
            <td rowspan=2 align="center" class="td">Jabatan</td>
            <td rowspan=2 align="center" class="td">Unit Kerja</td>
            <td colspan=3 align="center" class="td">Rekap Kehadiran</td>
          </tr>
        
          <tr bgcolor=#d9edf7 height="30">   
            <td width="*" align="center" class="td">Tahun</td>   
            <td width="*" align="center" class="td">Bulan</td>   
            <td width="*" align="center" class="td">Hari</td>   
            <td width="*" align="center" class="td">Hadir</td>   
            <td width="*" align="center" class="td">Ijin</td>   
            <td width="*" align="center" class="td">Terlambat</td>   
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

            $ijin = $this->db->query("select id from data_absensi where id_pegawai='$idp' and (tanggal between '$tgl_awal' and '$tgl_akhir') and jenis_absen!='DATANG'");
            $ijin=$ijin->num_rows();

            $terlambat = $this->db->query("select id from data_absensi where id_pegawai='$idp' and (tanggal between '$tgl_awal' and '$tgl_akhir') and jenis_absen!='DATANG' and time >= '07:16:00'");
            $terlambat=$terlambat->num_rows();

            $score= round(((intval($hadir) - intval($terlambat)) / intval($hadir)) * 100,2);

            if(is_nan($score)){
              $score=0;
            }

          ?>
          <tr>
            <td><?=$no++?></td>
            <td><a href="javascript:void(0)"><?=$row['employee_name']?></a></td>
            <td><?=$row['employee_start']?></td>
            <td><?=$umur->y." Tahun"?></td>
            <td><?=$umur->m." Bulan"?></td>
            <td><?=$umur->d." Hari"?></td>
            <td><?=$row['jabatan']?></td>
            <td><?=$row['nama_unit']?></td>
            <td><?=$hadir?></td>
            <td><?=$ijin?></td>
            <td><?=$terlambat?></td>
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