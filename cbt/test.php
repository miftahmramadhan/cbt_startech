<?php
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
	//$rvjaw="";
	//$crv2="";			
	do{
	$rvjaw="ABCD";
	$crv2="ABCD";
	echo "$rvjaw <br> $crv2 <br>";
	}while($rvjaw==$crv2);			
	//$rvjaw = randomRvjaw();
	//$cekrv=mysql_query("SELECT id_rvjaw FROM rvjawaban WHERE id_rvjaw='$rvjaw'");
	//$crv=mysql_fetch_array($cekrv);
	//$crv2=$crv[id_rvjaw];
	//$crv2="ABCD";
	//$rv
	echo "$rvjaw <br> $crv2 <br>";
	
	//echo "$rvjaw <br> $crv2";
	
	
	echo "git";
?>
