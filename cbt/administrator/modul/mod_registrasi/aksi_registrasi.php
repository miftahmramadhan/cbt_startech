<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../configurasi/koneksi.php";

$module="$_GET[module]";
$act="$_GET[act]";
    function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
    }
	 

// Input mapel
if ($module=='registrasi' AND $act=='hapus'){
   mysql_query("DELETE FROM registrasi_siswa WHERE id_registrasi='$_GET[id]'");
   header('location:../../media_admin.php?module='.$module);
}

elseif ($module=='registrasi' AND $act=='terima'){
    $registrasi = mysql_query("SELECT * FROM registrasi_siswa WHERE id_registrasi = '$_GET[id]'");
    $r=mysql_fetch_array($registrasi);
	 $pass = randomPassword();
	 $email = $r[email];
	 $nama = $r[nama_lengkap];
    $passtodb = md5($pass);
    $blokir= 'N';
    $kelas='A';
    $expdate = date("Y-m-d",strtotime("+2months"));
    mysql_query("INSERT INTO siswa(nama_lengkap,username_login,password_login,alamat,tempat_lahir,
                                    tgl_lahir,jenis_kelamin,referensi,sumber,email,blokir,expdate,id_kelas,no_telp)
                             VALUES('$nama','$email','$passtodb','$r[alamat]','$r[tempat_lahir]',
                                     '$r[tgl_lahir]','$r[jenis_kelamin]','$r[referensi]','$r[sumber]',
                                     '$r[email]','$blokir','$expdate','$kelas','$r[no_telp]')");
    
    	 $to = $email;
    	 $subject = 'Your User Name and Password on PMP Cerification';
	 $txt = "Selamat $nama, anda sudah terdaftar di website PMP certification.  \n Informasi Login Anda sebagai berikut : \n Email/Username : $email \n Password : $pass \n Terimakasih.";
	 $headers = 'From: support@startech.id';
		if (mail($to, $subject, $txt, $headers)){
		//	echo "Mail Sent";
	//		echo $subject;
      		mysql_query("DELETE FROM registrasi_siswa WHERE id_registrasi = '$_GET[id]'");
	 	}
	 	//else{
	 	//	echo "$to \n $subject \n $txt \n $headers";
	 	//}
    header('location:../../media_admin.php?module='.$module);
	
	

}

}
?>
