<?php
session_start();
error_reporting(0);
include "timeout.php";

if($_SESSION[login]==1){
	if(!cek_login()){
		$_SESSION[login] = 0;
	}
}
if($_SESSION[login]==0){
	echo "
	<!DOCTYPE HTML>
	<html lang=\"en\">
	<head>
	<title>Administrator CBT STARTECH .ID</title>
	<meta charset=\"utf-8\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\">
	<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"images/favicon.png\">
	<!--[if lte IE 8]>
	<script type=\"text/javascript\" src=\"js/html5.js\"></script>
	<![endif]-->
	<script type=\"text/javascript\" src=\"js/jquery-1.4.4.min.js\"></script>
	<script type=\"text/javascript\" src=\"js/cufon-yui.js\"></script>
	<script type=\"text/javascript\" src=\"js/Delicious_500.font.js\"></script>
	<script language=\"javascript\">
	function validasi(form){
	  if (form.username.value == \"\"){
	      document.getElementById('eroruser').innerHTML = \"<div class='error msg'>Username is empty, click to close</div>\";
	      form.username.focus();
	      $(function() {
		Cufon.replace('#site-title');
		$('.msg').click(function() {
			$(this).fadeTo('slow', 0);
			$(this).slideUp(341);
		});
	      });
	    return (false);
	  }

	  if (form.password.value == \"\"){
	    document.getElementById('erorpass').innerHTML = \"<div class='error msg'>Password is empty, click to close</div>\";
	    form.password.focus();
	    $(function() {
		Cufon.replace('#site-title');
		$('.msg').click(function() {
			$(this).fadeTo('slow', 0);
			$(this).slideUp(341);
		});
	    });
	    return (false);
	  }
	  return (true);
	}
	</script>

	</head>
	<body>

	<header id=\"top\">
		<div class=\"container_12 clearfix\">
			<div id=\"logo\" class=\"grid_12\">
				<!-- replace with your website title or logo -->
				<a id=\"site-title\">Computer Based Training <span>STARTECH .ID</span></a>
				<a id=\"view-site\" href=\"../index.php\">View Site</a>
			</div>
		</div>
	</header>

	<div id=\"login\" class=\"box\">
		<h2>Login Admin</h2>
		<section>
			
	                <p id=\"eroruser\"></p>
	                <p id=\"erorpass\"></p>
			<form method=\"POST\"action=\"cek_login.php\" onSubmit=\"return validasi(this)\">
				<dl>
					<dt><label>Username</label></dt>
	                                <dd><input id=\"username\" type=\"text\"  name=\"username\"/></dd>

					<dt><label>Password</label></dt>
					<dd><input id=\"adminpassword\" type=\"password\" name=\"password\"/></dd>
				</dl>
				<p>
					<input type=\"submit\" class=\"button white\" value=\"Login\"></input>
	                                <input type=\"reset\" class=\"button white\" value=\"Reset\"></input>
				</p>
			</form>
		</section>
	</div>

	</body>
	</html>
	";
}
else{
	if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
			echo "
			<!DOCTYPE HTML>
			<html lang=\"en\">
			<head>
			<title>Administrator CBT STARTECH .ID</title>
			<meta charset=\"utf-8\">
			<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\">
			<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"images/favicon.png\">
			<!--[if lte IE 8]>
			<script type=\"text/javascript\" src=\"js/html5.js\"></script>
			<![endif]-->
			<script type=\"text/javascript\" src=\"js/jquery-1.4.4.min.js\"></script>
			<script type=\"text/javascript\" src=\"js/cufon-yui.js\"></script>
			<script type=\"text/javascript\" src=\"js/Delicious_500.font.js\"></script>
			<script language=\"javascript\">
			function validasi(form){
			  if (form.username.value == \"\"){
			      document.getElementById('eroruser').innerHTML = \"<div class='error msg'>Username is empty, click to close</div>\";
			      form.username.focus();
			      $(function() {
				Cufon.replace('#site-title');
				$('.msg').click(function() {
					$(this).fadeTo('slow', 0);
					$(this).slideUp(341);
				});
			      });
			    return (false);
			  }

			  if (form.password.value == \"\"){
			    document.getElementById('erorpass').innerHTML = \"<div class='error msg'>Password is empty, click to close</div>\";
			    form.password.focus();
			    $(function() {
				Cufon.replace('#site-title');
				$('.msg').click(function() {
					$(this).fadeTo('slow', 0);
					$(this).slideUp(341);
				});
			    });
			    return (false);
			  }
			  return (true);
			}
			</script>

			</head>
			<body>

			<header id=\"top\">
				<div class=\"container_12 clearfix\">
					<div id=\"logo\" class=\"grid_12\">
						<!-- replace with your website title or logo -->
						<a id=\"site-title\">Computer Based Training <span>STARTECH .ID</span></a>
						<a id=\"view-site\" href=\"../index.php\">View Site</a>
					</div>
				</div>
			</header>

			<div id=\"login\" class=\"box\">
				<h2>Login Admin</h2>
				<section>
					
			                <p id=\"eroruser\"></p>
			                <p id=\"erorpass\"></p>
					<form method=\"POST\"action=\"cek_login.php\" onSubmit=\"return validasi(this)\">
						<dl>
							<dt><label>Username</label></dt>
			                                <dd><input id=\"username\" type=\"text\"  name=\"username\"/></dd>

							<dt><label>Password</label></dt>
							<dd><input id=\"adminpassword\" type=\"password\" name=\"password\"/></dd>
						</dl>
						<p>
							<input type=\"submit\" class=\"button white\" value=\"Login\"></input>
			                                <input type=\"reset\" class=\"button white\" value=\"Reset\"></input>
						</p>
					</form>
				</section>
			</div>

			</body>
			</html>
			";
	}
	else{
	
	    if ($_SESSION['leveluser']=='siswa'){
			     echo "<link href=css/style.css rel=stylesheet type=text/css>";
    			 echo "<div class='error msg'>LOGOUT Terlebih Dahulu Sebagai Peserta untuk LOGIN sebagai Admin</div>";
       	}
    	else{
    	
    		//echo "wajig";
    		header('location:media_admin.php?module=home');
    	}
    }	
}
?>