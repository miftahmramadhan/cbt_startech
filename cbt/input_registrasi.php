<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include "configurasi/koneksi.php";
if (!empty($_POST['email'])){
    $tgl_lahir = "$_POST[thn_lahir]-$_POST[bln_lahir]-$_POST[tgl_lahir]";
    mysql_query("INSERT INTO registrasi_siswa (nama_lengkap,alamat,tempat_lahir,tgl_lahir,jenis_kelamin,referensi,sumber,email,no_telp) 
    	VALUES ('$_POST[nama]','$_POST[alamat]','$_POST[tempat_lahir]','$tgl_lahir','$_POST[jk]','$_POST[referensi]','$_POST[sumber]','$_POST[email]','$_POST[no_telp]')");
$to = 'support@startech.id';
$subject = 'New Sign Up on PMP Certification';
$txt = "Pendaftaran Baru dari : \n Nama : $_POST[nama] \n Email : $_POST[email] \n Lihat Detail nya di website PMP Certification http://startech.id/cbt/administrator ";
$headers = 'From: mailer@startech.id';
if (mail($to, $subject, $txt, $headers)){
//	echo "Mail Sent";
//echo $subject;
//echo $txt;
}
    echo "<script>window.alert('Terimakasih telah mendaftarkan diri anda, silahkan tunggu konfirmasi email dari admin.');
          window.location=(href='index.php')</script>";
}else{
    header('location:index.php');
}
?>
