<?php 
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
	 echo randomPassword();
	 
	 
	 $date = date("Y-m-d");
	 //echo strtotime(date("Y-m-d"));
	 $now = "2016-02-03";
	 echo "$now <br>";
	 $expdate = date("Y-m-d",strtotime("+6months"));
	 echo "$expdate <br>";
	 echo strtotime($date)."<br>";
	 echo strtotime($expdate)."<br>";
	 $iya = strtotime($date)."<br>";
	 $exp = strtotime($expdate)."<br>";
	 if ($iya < $exp){
	 	echo "expire";
	 	}else{
	 	echo "berhasil";
	 	}
	?>