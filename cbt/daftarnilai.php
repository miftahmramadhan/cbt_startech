<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include "configurasi/koneksi.php";

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
        $siswa = mysql_query("SELECT * FROM siswa WHERE id_siswa = '$_SESSION[idsiswa]'");
        $data_siswa = mysql_fetch_array($siswa);
        $mapel = mysql_query("SELECT * FROM mata_pelajaran WHERE id_kelas = '$data_siswa[id_kelas]'");
        $cek_mapel = mysql_num_rows($mapel);
        if (!empty($cek_mapel)){
            echo"<br><b class='judul'>Daftar Nilai</b><br><p class='garisbawah'></p>
            <table>
            <tr><th>No</th><th>Materi</th><th>Aksi</th></tr>";
            $no=1;
            while ($t=mysql_fetch_array($mapel)){
                echo "<tr><td>$no</td>
                        <td>$t[nama]</td>";

                        echo"<td><input type=button class='tombol' value='Lihat'
                       onclick=\"window.location.href='?module=quiz&act=daftarnilai&id=$t[id_matapelajaran]&id_kelas=$data_siswa[id_kelas]';\"></td></tr>";
            $no++;
            }
            echo"</table>";
        }else{
            echo "<script>window.alert('Belum ada mata pelajaran di kelas anda.');
                    window.location=(href='media.php?module=home')</script>";
        }
        echo "<br><b class='judul'>Nilai Pretest</b><br><p class='garisbawah'></p>"; 
        echo "<table class='gtable sortable'><tr><td>";
    echo "<table class='gtable sortable'>
			<thead>
				<tr><th>10 Knowledge</th></tr>
			</thead>
			";
			  $pilih="SELECT * FROM knowledge ORDER BY id";
			  $query=mysql_query($pilih);
			  while($row=mysql_fetch_array($query)){
			  	echo"<tr><td><a href=?module=quiz&act=dnknowledge&id=$row[id_field]&id_kelas=$data_siswa[id_kelas]&id_siswa=$_SESSION[idsiswa]>".$row[knowledge]."</a></td></tr>";
			  }
			  
	echo"
			
	
	</table>";
	echo "</td><td>";
	echo "<table class='gtable sortable'>
			<thead>
				<tr><th>5 Process</th></tr>
			</thead>
			";
			$pilih2="SELECT * FROM process ORDER BY id";
		    $query2=mysql_query($pilih2);
		    while($row2=mysql_fetch_array($query2)){				
			echo"<tr><td><a href=?module=quiz&act=dnprocess&id=$row2[id_step]&id_kelas=$data_siswa[id_kelas]&id_siswa=$_SESSION[idsiswa]>".$row2[process]."</a></td></tr>";
		   }
	echo"
	
	</table>";
	echo "</td></tr></table>";
    
}
?>
