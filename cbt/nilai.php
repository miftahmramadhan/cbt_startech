<?php
session_start();
error_reporting(0);

if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
  echo "<link href='css/screen.css' rel='stylesheet' type='text/css'><link href='css/reset.css' rel='stylesheet' type='text/css'>


 <center><br><br><br><br><br><br>Maaf, untuk masuk <b>Halaman</b><br>
  <center>anda harus <b>Login</b> dahulu!<br><br>";
 echo "<div> <a href='index.php'><img src='images/kunci.png'  height=176 width=143></a>
             </div>";
  echo "<input type=button class=simplebtn value='LOGIN DI SINI' onclick=location.href='index.php'></a></center>";
}
else{
include "configurasi/koneksi.php";
				function randomRvjaw() {
				$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
				$rvjaw = array(); //remember to declare $pass as an array
				$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
				for ($i = 0; $i < 4; $i++) {
					$n = rand(0, $alphaLength);
					$rvjaw[] = $alphabet[$n];
				}
				return implode($rvjaw); //turn the array into a string
				}
	
	do{
	$rvjaw = randomRvjaw();
	$cekrv=mysql_query("SELECT id_rvjaw FROM rvjawaban WHERE id_rvjaw='$rvjaw'");
	$crv=mysql_fetch_array($cekrv);
	$crv2=$crv[id_rvjaw];
	}while($rvjaw==$crv2);
switch ($_GET[act]){
case "bytq":
//	$soal = mysql_query("SELECT * FROM quiz_pilganda where id_tq='$_POST[id_topik]'");
//	$pilganda = mysql_num_rows($soal);
//	$soal_esay = mysql_query("SELECT * FROM quiz_esay WHERE id_tq='$_POST[id_topik]'");
//	$esay = mysql_num_rows($soal_esay);

	
	
	//jika ada pilihan ganda dan ada esay
//	if (!empty($pilganda) AND !empty($esay)){

	//jika ada inputan soal pilganda
	if(!empty($_POST['soal_pilganda'])){
		$benar = 0;
		$salah = 0;

		foreach($_POST['soal_pilganda'] as $key => $value){

		mysql_query("INSERT INTO rvjawaban (id_rvjaw,id_quiz,jaw) VALUES ('$rvjaw','$key','$value')");
		
		$cek = mysql_query("SELECT * FROM quiz_pilganda WHERE id_quiz=$key");
		while($c = mysql_fetch_array($cek)){
			$jawaban = $c['kunci'];
		}

		if($value==$jawaban){
			
			$benar++;
		}else{
			$salah++;
		}

	}


	$jumlah = $_POST['jumlahsoalpilganda'];
	$tidakjawab = $jumlah - $benar - $salah;
	$persen = $benar / $jumlah;
	$hasil = $persen * 100;

	mysql_query("INSERT INTO nilai (id_tq, id_rvjaw, id_siswa, benar, salah, tidak_dikerjakan,persentase)
							   VALUES ('$_POST[id_topik]','$rvjaw','$_SESSION[idsiswa]','$benar','$salah','$tidakjawab','$hasil')");

	}elseif (empty($_POST['soal_pilganda'])){
		$jumlah = $_POST['jumlahsoalpilganda'];
		mysql_query("INSERT INTO nilai (id_tq, id_rvjaw, id_siswa, benar, salah, tidak_dikerjakan,persentase)
							   VALUES ('$_POST[id_topik]','$rvjaw','$_SESSION[idsiswa]','0','0','$jumlah','0')");
	}
header ('location:media.php?module=nilai');
	//jika ada inputan soal esay
	//if(!empty($_POST['soal_esay'])){
	//	foreach($_POST['soal_esay'] as $key2 => $value){
	//	$jawaban = $value;
	//	$cek = mysql_query("SELECT * FROM quiz_esay WHERE id_quiz=$key2");
	//	while($data = mysql_fetch_array($cek)){
	//		mysql_query("INSERT INTO jawaban(id_tq,id_quiz,id_siswa,jawaban)
	//								 VALUES('$_POST[id_topik]','$data[id_quiz]','$_SESSION[idsiswa]','$jawaban')");

	//	}
		
	//	}

	//}
	/*elseif (empty($_POST['soal_esay'])){
		mysql_query("INSERT INTO jawaban(id_tq,id_quiz,id_siswa,jawaban)
									 VALUES('$_POST[id_topik]','$data[id_quiz]','$_SESSION[idsiswa]','')");
	}
	header ('location:media.php?module=nilai');
	}

	//jika soal hanya esay
	if (empty($pilganda) AND !empty($esay)){
		//jika ada inputan soal esay
	if(!empty($_POST['soal_esay'])){
		foreach($_POST['soal_esay'] as $key2 => $value){
		$jawaban = $value;
		$cek = mysql_query("SELECT * FROM quiz_esay WHERE id_quiz=$key2");
		while($data = mysql_fetch_array($cek)){
			mysql_query("INSERT INTO jawaban(id_tq,id_quiz,id_siswa,jawaban)
									 VALUES('$_POST[id_topik]','$data[id_quiz]','$_SESSION[idsiswa]','$jawaban')");

		}

		}

	}
	elseif (empty($_POST['soal_esay'])){
		mysql_query("INSERT INTO jawaban(id_tq,id_quiz,id_siswa,jawaban)
									 VALUES('$_POST[id_topik]','$data[id_quiz]','$_SESSION[idsiswa]','')");
	}
	//header ('location:media.php?module=nilai');
	}

	//jika soal hanya pilihan ganda
	if (!empty($pilganda) AND empty($esay)){
		//jika ada inputan soal pilganda
	if(!empty($_POST['soal_pilganda'])){
		$benar = 0;
		$salah = 0;
		foreach($_POST['soal_pilganda'] as $key => $value){
		$cek = mysql_query("SELECT * FROM quiz_pilganda WHERE id_quiz=$key");
		while($c = mysql_fetch_array($cek)){
			$jawaban = $c['kunci'];
		}
		if($value==$jawaban){
			$benar++;
		}else{
			$salah++;
		}
	}

	$jumlah = $_POST['jumlahsoalpilganda'];
	$tidakjawab = $jumlah - $benar - $salah;
	$persen = $benar / $jumlah;
	$hasil = $persen * 100;

	mysql_query("INSERT INTO nilai (id_tq, id_siswa, benar, salah, tidak_dikerjakan,persentase)
							   VALUES ('$_POST[id_topik]','$_SESSION[idsiswa]','$benar','$salah','$tidakjawab','$hasil')");

	}
	elseif (empty($_POST['soal_pilganda'])){
		$jumlah = $_POST['jumlahsoalpilganda'];
		mysql_query("INSERT INTO nilai (id_tq, id_siswa, benar, salah, tidak_dikerjakan,persentase)
							   VALUES ('$_POST[id_topik]','$_SESSION[idsiswa]','0','0','$jumlah','0')");
	}
	header ('location:media.php?module=nilai');
	}
	*/
break;
case "knowledge":
case "process":
	$q = "SELECT * FROM nilai where id_tq='$_POST[id_topik]' and id_siswa='$_SESSION[idsiswa]'";
	$mq = mysql_query($q);
	//echo $q;
	$cekidot = mysql_num_rows($mq);
	//echo $cekidot;
	if(!empty($_POST['soal_pilganda'])){
		$benar = 0;
		$salah = 0;
		foreach($_POST['soal_pilganda'] as $key => $value){
		$cek = mysql_query("SELECT * FROM quiz_pilganda WHERE id_quiz=$key");
		mysql_query("INSERT INTO rvjawaban (id_rvjaw,id_quiz,jaw) VALUES ('$rvjaw','$key','$value')");
		while($c = mysql_fetch_array($cek)){
			$jawaban = $c['kunci'];
		}
		if($value==$jawaban){
			$benar++;
		}else{
			$salah++;
		}
	}

	$jumlah = $_POST['jumlahsoalpilganda'];
	$tidakjawab = $jumlah - $benar - $salah;
	$persen = $benar / $jumlah;
	$hasil = $persen * 100;
	
	
	if(empty($cekidot)){
		$query="INSERT INTO nilai (id_tq, id_rvjaw, id_siswa, benar, salah, tidak_dikerjakan,persentase)
							VALUE ('$_POST[id_topik]','$rvjaw','$_SESSION[idsiswa]','$benar','$salah','$tidakjawab','$hasil')";
		mysql_query($query);
	//	echo $query;
	}else{
		$query="DELETE FROM nilai WHERE id_tq='$_POST[id_topik]' and id_siswa='$_SESSION[idsiswa]'";
		mysql_query($query);
	//	echo $query;
		$query="INSERT INTO nilai (id_tq, id_rvjaw, id_siswa, benar, salah, tidak_dikerjakan,persentase)
							VALUE ('$_POST[id_topik]','$rvjaw','$_SESSION[idsiswa]','$benar','$salah','$tidakjawab','$hasil')";
		mysql_query($query);
	//	echo $query;
	}
	}
	elseif (empty($_POST['soal_pilganda'])){
	
		$jumlah = $_POST['jumlahsoalpilganda'];

	if(empty($cekidot)){
		$query="INSERT INTO nilai (id_tq, id_siswa, benar, salah, tidak_dikerjakan,persentase)
							   VALUE ('$_POST[id_topik]','$_SESSION[id_siswa]','0','0','$jumlah','0')";
		mysql_query($query);
	//	echo $query;
		
	}else{
		$query="DELETE FROM nilai WHERE id_tq='$_POST[id_topik]' and id_siswa='$_SESSION[idsiswa]";
		mysql_query($query);
	//	echo $query;
		$query="INSERT INTO nilai (id_tq, id_siswa, benar, salah, tidak_dikerjakan,persentase)
							   VALUE ('$_POST[id_topik]','$_SESSION[idsiswa]','0','0','$jumlah','0')";
		mysql_query($query);
	//	echo $query;
		
	}
	}
	header ('location:media.php?module=nilai');
 break;
 
case "processaaaa":
	$q = "SELECT * FROM nilai where id_tq='$_POST[id_topik]' and id_siswa='$_SESSION[idsiswa]'";
	$mq = mysql_query($q);
	//echo $q;
	$cekidot = mysql_num_rows($mq);
	//echo $cekidot;
	if(!empty($_POST['soal_pilganda'])){
		$benar = 0;
		$salah = 0;
		foreach($_POST['soal_pilganda'] as $key => $value){
		$cek = mysql_query("SELECT * FROM quiz_pilganda WHERE id_quiz=$key");
		while($c = mysql_fetch_array($cek)){
			$jawaban = $c['kunci'];
		}
		if($value==$jawaban){
			$benar++;
		}else{
			$salah++;
		}
	}

	$jumlah = $_POST['jumlahsoalpilganda'];
	$tidakjawab = $jumlah - $benar - $salah;
	$persen = $benar / $jumlah;
	$hasil = $persen * 100;
	
	
	if(empty($cekidot)){
		$query="INSERT INTO nilai (id_tq, id_siswa, benar, salah, tidak_dikerjakan,persentase)
							VALUE ('$_POST[id_topik]','$_SESSION[idsiswa]','$benar','$salah','$tidakjawab','$hasil')";
		mysql_query($query);
	//	echo $query;
	}else{
		$query="DELETE FROM nilai WHERE id_tq='$_POST[id_topik]' and id_siswa='$_SESSION[idsiswa]'";
		mysql_query($query);
	//	echo $query;
		$query="INSERT INTO nilai (id_tq, id_siswa, benar, salah, tidak_dikerjakan,persentase)
							VALUE ('$_POST[id_topik]','$_SESSION[idsiswa]','$benar','$salah','$tidakjawab','$hasil')";
		mysql_query($query);
	//	echo $query;
	}
	}
	elseif (empty($_POST['soal_pilganda'])){
	
		$jumlah = $_POST['jumlahsoalpilganda'];

	if(empty($cekidot)){
		$query="INSERT INTO nilai (id_tq, id_siswa, benar, salah, tidak_dikerjakan,persentase)
							   VALUE ('$_POST[id_topik]','$_SESSION[id_siswa]','0','0','$jumlah','0')";
		mysql_query($query);
	//	echo $query;
		
	}else{
		$query="DELETE FROM nilai WHERE id_tq='$_POST[id_topik]' and id_siswa='$_SESSION[idsiswa]";
		mysql_query($query);
	//	echo $query;
		$query="INSERT INTO nilai (id_tq, id_siswa, benar, salah, tidak_dikerjakan,persentase)
							   VALUE ('$_POST[id_topik]','$_SESSION[idsiswa]','0','0','$jumlah','0')";
		mysql_query($query);
	//	echo $query;
		
	}
	}
	header ('location:media.php?module=nilai');
break;

}
}
?>
