<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Administrator CBT STARTECH .ID</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="administrator/css/style_register.css">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
<!--[if lte IE 8]>
<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
<script type="text/javascript" src="administrator/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="administrator/js/cufon-yui.js"></script>
<script type="text/javascript" src="administrator/js/Delicious_500.font.js"></script>
<script>
$(document).ready(function(){
   $("#email").change(function(){
		// tampilkan animasi loading saat pengecekan ke database
    $('#pesan_email').html(' <img src="images/loading.gif" width="20" height="20"> checking ...');
    var email = $("#email").val();

    $.ajax({
     type:"POST",
     url:"checking_email.php",
     data: "email=" + email,
     success: function(data){
       if(data==0){
          $("#pesan_email").html('<img src="images/tick.png">');
 	        $('#email').css('border', '3px #090 solid');
       }
       else{
          $("#pesan_email").html('<img src="images/cross.png"> Email sudah digunakan!');
 	        $('#email').css('border', '3px #C33 solid');
                $("#email").val('');
       }
     }
    });
	})
});
</script>
<script language="javascript">
function check_radio(radio)
    {
	// memeriksa apakah radio button sudah ada yang dipilih
	for (i = 0; i < radio.length; i++)
	{
		if (radio[i].checked === true)
		{
			return radio[i].value;
		}
	}
	return false;
    }
    
function validasi(form){

  if (form.nama.value == ""){
      alert('Nama Masih Kosong!');
      form.nama.focus();
      return (false);
  }
  if (form.email.value == ""){
      alert('Email Masih Kosong!');
      form.email.focus();
      return (false);
  }

 
 if (form.no_telp.value == ""){
      alert('No. Telpon Masih Kosong!');
      form.no_telp.focus();
      return (false);
  }

  if (form.alamat.value == ""){
      alert('Alamat Masih Kosong!');
      form.alamat.focus();
      return (false);
  }
  if (form.tempat_lahir.value == ""){
      alert('Tempat Lahir Masih Kosong!');
      form.tempat_lahir.focus();
      return (false);
  }
  var radio_val = check_radio(form.jk);
	if (radio_val === false)
	{
		alert("Anda belum memilih Jenis Kelamin!");
                return false;
	}
 
  if (form.referensi.value == ""){
      alert('Referensi Masih Kosong!');
      form.referensi.focus();
      return (false);
  }
 
  if (form.sumber.value == ""){
      alert('Form Masih Kosong!');
      form.sumber.focus();
      return (false);
  }
  

   return (true);
}
</script>

</head>
<body>

<header id="top">
	<div class="container_12 clearfix">
		<div id="logo" class="grid_12">
			<!-- replace with your website title or logo -->
			<a id="site-title">Computer Based Training <span>STARTECH .ID</span></a>			
		</div>
	</div>
</header>

<div id="login2" class="box">
	<h2>Registrasi Form</h2>
	<section>                
		<form method="POST"action="input_registrasi.php" onSubmit="return validasi(this)">
			<dl>
				<dt><label>Nama Lengkap* :</label></dt>
                                <dd><input type="text" name="nama" size="40"/></dd>
              <dt><label>Email* :</label></dt>
                                <dd><input type="email" name="email" size="40" id="email"/><span id="pesan_email"></span></dd>
              <dt><label>No. Telp.* :</label></dt>
									 <dd><input type="text" name="no_telp" size="40"/></dd>
              <dt><label>Alamat* :</label></dt>
                                <dd><textarea name="alamat" cols="43" rows="3"></textarea></dd>
              <dt><label>Tempat Lahir* :</label></dt>
									 <dd><input type="text" name="tempat_lahir" size="40"/></dd>
              <dt><label>Tanggal Lahir* :</label></dt><dd> <?php
                                  include "configurasi/fungsi_combobox.php";
                                  include "configurasi/library.php";
                                  combotgl(1,31,'tgl_lahir',$tgl_skrg);
                                  combonamabln(1,12,'bln_lahir',$bln_sekarang);
                                  combothn(1950,$thn_sekarang,'thn_lahir',$thn_sekarang);
                                  echo "</dd>";
                                  ?>
              <dt><label>Jenis kelamin* :</label></dt>
                                <dd><input type="radio" name="jk" value="L">Laki - Laki
                                    <input type="radio" name="jk" value="P">Perempuan</dd>
              <dt><label>Siapa Referensi anda* :</label></dt>
									 <dd><input type="text" name="referensi" size="40"/></dd>
              <dt><label>Dari mana anda mengetahui kami* :</label></dt>
									 <dd><textarea name="sumber" cols="43" rows="3"></textarea></dd>
                                              <hr>
                                
			</dl>
			<p>
				<input type="submit" class="button white" value="Daftar"></input>
                                <?php
                               echo "<button type='button' class='button white' onclick=\"window.location.href='index.php';\" > Batal</button>";
                               ?>
			</p>
		</form>
	</section>
</div>

</body>
</html>