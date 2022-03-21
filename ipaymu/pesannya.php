<?php
$txt = "<br><h2 class='title' data-rgen-sm='medium'>Terimakasih <br>Orang Taua / Wali a/n $nama </h2>";
$txt .= "<br><p class='title-sub' data-rgen-sm='small'>";
$txt .="Data Pemesanaa Anda adalah :";
$txt .="<br>TransactionId : ".$TransactionId;
$txt .="<br>Nama : ".$nama;
$txt .="<br>Email : ".$email;
$txt .="<br>Phone : ".$phone;
$txt .="<br>Nominal : ".number_format($nominal);
$txt .="<br>Nama Tagihan: ".$nama_tagihan;
$txt .="<br>Biaya Admin : ".number_format($Fee);
$txt .="<br>PaymentChannel : ".$paymentChannel;
$txt .="<br>PaymentMethod : ".$paymentMethod;

$Total = $Fee+$nominal;

$txt .="<br>Total Bayar : ".number_format($Total);

$txt .="<br>";
if ($paymentMethod == "va")
{
$txt .="<br>Silahkan Transfer Rp ".number_format($Total);
$txt .="<br>ke Nomor Virtual Account : $PaymentNo <br>a/n $PaymentName"; 
$txt .="<br>Bank : $Channel"; 
}
elseif ($paymentMethod == "cstore")
{
$txt .="<br>Silahkan lakukan pembayaran ke $paymentChannel Rp ".number_format($Total);
$txt .="<br>dengan Nomor Pembayaran : $PaymentNo <br>a/n $PaymentName"; 
}
else
{
$txt .="<br>Silahkan Transfer Rp ".number_format($Total);
$txt .="<br>ke Nomor Rekening : $PaymentNo <br>a/n $PaymentName"; 
$txt .="<br>Bank : $Channel"; 
}

$txt .="<br>				  ";
$txt .="<br>untuk respon Cepat, mohon setelah transfer, bukti Transfer silahkan di kirim ke nomor WA : <a target='_blank' href='http://wa.me/6285712703865?text=Selamat Pagi, berikut saya kirim bukti Transfer Pembayaran'><font color=blue>62 857 1270 3865</font></a>";
$txt .="<br>				  ";
if ($paymentMethod == "va")
{
$txt .="<br><font color=red>Tata Cara Pembayaran</font>";
$txt .="<br>				  ";
}

if ($paymentChannel == "bni" and $paymentMethod == "va")
{
$txt .= "<br><strong>Pembayaran Melalui mBanking BNI</strong>";
$txt .= "<br>* Akses BNI Mobile Banking dari handphone kemudian masukkan USER ID dan PASSWORD";
$txt .= "<br>* Pilih menu 'TRANSFER'";
$txt .= "<br>* Pilih menu 'VIRTUAL ACCOUNT BILLING' kemudian pilih rekening debet";
$txt .= "<br>* Masukkan NOMOR VIRTUAL ACCOUNT Anda ( $PaymentNo a/n $PaymentName ) pada menu 'INPUT BARU'";
$txt .= "<br>* Tagihan yang harus dibayarkan akan muncul pada LAYAR KONFIRMASI";
$txt .= "<br>* Konfirmasi transaksi dan masukkan PASSWORD TRANSAKSI.";
$txt .= "<br>* Pembayaran Anda Telah Berhasil.";
$txt .= "<br>";
$txt .= "<br><strong>Pembayaran Melalui Cabang atau Outlet BNI (Teller)</strong>";
$txt .= "<br>* Kunjungi Kantor Cabang/outlet BNI terdekat";
$txt .= "<br>* Informasikan kepada Teller, bahwa ingin melakukan pembayaran 'VIRTUAL ACCOUNT BILLING'";
$txt .= "<br>* Serahkan NOMOR VIRTUAL ACCOUNT ( $PaymentNo a/n $PaymentName ) Anda kepada Teller";
$txt .= "<br>* Teller melakukan KONFIRMASI kepada Anda";
$txt .= "<br>* Teller MEMPROSES TRANSAKSI";
$txt .= "<br>* Apabila transaksi SUKSES anda akan menerima bukti pembayaran dari Teller tersebut";
$txt .= "<br>";
$txt .= "<br><strong>Pembayaran melalui ATM Bersama</strong>";
$txt .= "<br>* Masukkan PIN";
$txt .= "<br>* Pilih menu TRANSAKSI";
$txt .= "<br>* Pilih menu KE REK BANK LAIN";
$txt .= "<br>* Masukkan kode sandi Bank BNI (009) diikuti dengan nomor VIRTUAL ACCOUNT yang tertera pada halaman konfirmasi ( $PaymentNo a/n $PaymentName ), dan tekan BENAR";
$txt .= "<br>* Masukkan jumlah pembayaran sesuai dengan yang ditagihkan dalam halaman konfirmasi";
$txt .= "<br>* Pilih BENAR untuk menyetujui transaksi tersebut";
}

if ($paymentChannel == "mandiri" and $paymentMethod == "va")
{
$txt .= "<br><strong>Pembayaran dengan Mandiri Online (Multi Payment)</strong>";
$txt .= "<br>* Login Mandiri Online dengan memasukkan USERNAME dan PASSWORD";
$txt .= "<br>* Pilih menu PEMBAYARAN";
$txt .= "<br>* Pilih menu MULTI PAYMENT";
$txt .= "<br>* Cari Penyedia Jasa 'Ipaymu'";
$txt .= "<br>* Masukkan NOMOR VIRTUAL ACCOUNT ( $PaymentNo a/n $PaymentName ) dan nominal sejumlah Rp. ".number_format($Total).", lalu pilih Lanjut";
$txt .= "<br>* Setelah muncul tagihan, pilih KONFIRMASI";
$txt .= "<br>* Masukkan PIN/ CHALLENGE CODE TOKEN";
$txt .= "<br>* Transaksi selesai, simpan bukti bayar anda";
$txt .= "<br>";
$txt .= "<br><strong>Pembayaran melalui ATM Bersama</strong>";
$txt .= "<br>* Masukkan PIN";
$txt .= "<br>* Pilih menu TRANSAKSI";
$txt .= "<br>* Pilih menu KE REK BANK LAIN";
$txt .= "<br>* Masukkan kode sandi Bank Mandiri (008) diikuti dengan nomor VIRTUAL ACCOUNT yang tertera pada halaman konfirmasi ( $PaymentNo a/n $PaymentName ), dan tekan BENAR";
$txt .= "<br>* Masukkan jumlah pembayaran sesuai dengan yang ditagihkan dalam halaman konfirmasi";
$txt .= "<br>* Pilih BENAR untuk menyetujui transaksi tersebut";
}

if ($paymentChannel == "cimb" and $paymentMethod == "va")
{
$txt .="<br><strong>Pembayaran VA melalui ATM BERSAMA/PRIMA/BANK LAIN</strong>";
$txt .="<br>";
$txt .="<br>* Masukan kartu ATM dan PIN Anda";
$txt .="<br>* Masuk ke menu TRANSFER/TRANSFER Online";
$txt .="<br>* Pilih Bank tujuan -> Bank CIMB Niaga (kode bank: 022)";
$txt .="<br>* Masukkan nomor Virtual Account Anda ( $PaymentNo a/n $PaymentName )";
$txt .="<br>* Masukkan jumlah pembayaran sesuai tagihan ";
$txt .="<br>* Ikuti instruksi untuk menyelesaikan transaksi";
$txt .="<br>";
$txt .="<br><strong>Pembayaran VA melalui OCTO Clicks</strong>";
$txt .="<br>";
$txt .="<br>* Login ke OCTO Clicks";
$txt .="<br>* Pilih menu Pembayaran Tagihan";
$txt .="<br>* Pilih kategori Mobile Rekening Virtual";
$txt .="<br>* Masukkan nomor Virtual Account Anda ( $PaymentNo a/n $PaymentName )";
$txt .="<br>* Tekan tombol 'lanjut untuk verifikasi detail'";
$txt .="<br>* Tekan tombol 'kirim OTP untuk lanjut'";
$txt .="<br>* Masukkan OTP yang dikirimkan ke nomor HP anda";
$txt .="<br>* Tekan tombol 'Konfirmasi'";
$txt .="<br>";
$txt .="<br><strong>Pembayaran VA melalui OCTO MOBILE</strong>";
$txt .="<br>";
$txt .="<br>* Login ke Octo Mobile";
$txt .="<br>* Pilih menu TRANSFER > Transfer to Other CIMB Niaga Account";
$txt .="<br>* Pilih rekening sumber anda: CASA atau Rekening Ponsel";
$txt .="<br>* Masukkan nomor Virtual Account Anda ( $PaymentNo a/n $PaymentName ) pada kolom Transfer To ";
$txt .="<br>* Masukkan jumlah amount sesuai tagihan";
$txt .="<br>* Ikuti instruksi untuk menyelesaikan transaksi";
}


$txt .="</p>";
?>