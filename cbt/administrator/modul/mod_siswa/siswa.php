<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

include "../../../configurasi/class_paging.php";

$aksi="modul/mod_siswa/aksi_siswa.php";
$aksi_siswa = "administrator/modul/mod_siswa/aksi_siswa.php";
switch($_GET[act]){
  // Tampil Siswa
  default:
    if ($_SESSION[leveluser]=='admin'){

     $p      = new paging_paging;
     $batas  = 20;
     $posisi = $p->cariPosisi($batas);

      $tampil_siswa = mysql_query("SELECT * FROM siswa LIMIT $posisi,$batas");
      echo "<h2>Manajemen Peserta</h2><hr>";
      echo "<br><br><div class='information msg'>Peserta tidak bisa di hapus, tapi bisa di non aktifkan.</div>";
      echo "<br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nama</th>"/*<th>No Telp</th><th>Email</th>*/."<th><center>Expire</center></th>
            <th><center>Blokir</center></th><th width='80'><center>Aksi</center></th></tr></thead>";
      $no = $posisi+1;
      $now = strtotime(date("Y-m-d"));
    while ($r=mysql_fetch_array($tampil_siswa)){
          $expdate = strtotime($r[expdate]);
          if ($now < $expdate){
            $exp="N";
            $aksiexp = "";
          } else {
            $exp="Y";
            $aksiexp = "<br> <a href='$aksi?module=siswa&act=renewsiswa&id=$r[id_siswa]'> ReNew</a>";
          }
       echo "<tr><td>$no</td>
             <td>$r[nama_lengkap]</td>
             "/*<td>$r[no_telp]</td>
             <td>$r[email]</td>*/."
             <td><p align='center'>$exp $aksiexp</p></td>             
             <td><p align='center'>$r[blokir]</p></td>
             <td><a href='?module=siswa&act=editsiswa&id=$r[id_siswa]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=?module=detailsiswa&act=detailsiswa&id=$r[id_siswa]>Detail</a></td></tr>";
      $no++;
    }
    echo "</table>";
    $jmldata=mysql_num_rows(mysql_query("SELECT * FROM siswa"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

    echo "<br><div id=paging>$linkHalaman</div><br>";
    }
    break;
/*
case "renewsiswa":
  
    $expdate = date("Y-m-d",strtotime("+2months"));
    mysql_query("UPDATE siswa SET expdate         = '$expdate'
                                WHERE  id_siswa    = '$_SESSION[idsiswa]'");

    //echo "<script>window.alert('Renew Success');
    //        window.location=(href='../../media_admin.php?module=siswa')</script>";
    header('location:../../media_admin.php?module=siswa');

break;
*/
case "lihatmurid":
    if ($_SESSION[leveluser]=='admin'){
    $p      = new paging_lihatmurid;
    $batas  = 20;
    $posisi = $p->cariPosisi($batas);

    $tampil = mysql_query("SELECT * FROM siswa ORDER BY nama_lengkap LIMIT $posisi,$batas");
    $cek_siswa = mysql_num_rows($tampil);
    if(!empty($cek_siswa)){
    echo "<div class='information msg'>Daftar Peserta</div>
          <br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nama</th><th>No Telp</th><th>Email</th><th>Jenis Kelamin</th>
            <th>Blokir</th><th>Aksi</th></tr></thead>";
     $no=$posisi+1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[nama_lengkap]</td>
             <td>$r[no_telp]</td>
             <td>$r[email]</td>
             <td><p align='center'>$r[jenis_kelamin]</p></td>             
             <td><p align='center'>$r[blokir]</p></td>
             <td><a href='?module=siswa&act=editsiswa&id=$r[id_siswa]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=?module=detailsiswa&act=detailsiswa&id=$r[id_siswa]>Detail</a></td></tr>";
      $no++;
    }
    echo "</table>";
    
    $jmldata=mysql_num_rows(mysql_query("SELECT * FROM siswa"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

    echo "<br><div id=paging>$linkHalaman</div><br>";
    echo "<div class='buttons'><input class='button blue' type=button value=Kembali onclick=self.history.back()></div>";
    }else{
        echo "<script>window.alert('Tidak ada siswa dikelas ini');
            window.location=(href='?module=kelas')</script>";
    }
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
    $p      = new paging_lihatmurid;
    $batas  = 20;
    $posisi = $p->cariPosisi($batas);

    $tampil = mysql_query("SELECT * FROM siswa WHERE id_kelas = '$_GET[id]' ORDER BY nama_lengkap LIMIT $posisi,$batas");
    $cek_siswa = mysql_num_rows($tampil);
    if(!empty($cek_siswa)){
    echo "<form>
          <fieldset>
          <legend>Daftar Siswa</legend>
          <dl class='inline'>";
    echo "<table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nis</th><th>Nama</th><th>Kelas</th><th>Jenis Kelamin</th>
           <th>Aksi</th></tr></thead>";
     $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[nis]</td>
             <td>$r[nama_lengkap]</td>";
             $kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             while($k=mysql_fetch_array($kelas)){
             echo"<td><a href=?module=kelas&act=detailkelas&id=$k[id_kelas]>$k[nama]</a></td>";
             }
             echo "<td><p align='center'>$r[jenis_kelamin]</p></td>                       
             <td><input type=button class='button small white' value='Detail Siswa' onclick=\"window.location.href='?module=detailsiswapengajar&act=detailsiswa&id=$r[id_siswa]';\">";
      $no++;
    }
    echo "</table>";
    $jmldata=mysql_num_rows(mysql_query("SELECT * FROM siswa"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

    echo "<br><div id=paging>$linkHalaman</div><br>
    <input type=button class='button blue' value=Kembali onclick=self.history.back()>";
    }else{
        echo "<script>window.alert('Tidak ada siswa dikelas ini');
            window.location=(href='?module=kelas')</script>";
    }
    }
    else{
    $p      = new paging_lihatmurid;
    $batas  = 20;
    $posisi = $p->cariPosisi($batas);

    $tampil = mysql_query("SELECT * FROM siswa WHERE id_kelas = '$_GET[id]' ORDER BY nama_lengkap LIMIT $posisi,$batas");
    $cek_siswa = mysql_num_rows($tampil);
    if(!empty($cek_siswa)){
    echo"<br><b class='judul'>Daftar Teman</b><br><p class='garisbawah'></p>";
    echo "<table>
          <tr><th>No</th><th>Nis</th><th>Nama</th><th>Jenis Kelamin</th><th>Th Masuk</th>
           <th>Aksi</th></tr>";
     $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[nis]</td>
             <td>$r[nama_lengkap]</td>             
             <td>$r[jenis_kelamin]</td>
             <td>$r[th_masuk]</td>
             <td><input type=button class='tombol' value='Detail Siswa'
                 onclick=\"window.location.href='?module=siswa&act=detailsiswa&id=$r[id_siswa]';\">";
      $no++;
    }
    echo "</table>";
    $jmldata=mysql_num_rows(mysql_query("SELECT * FROM siswa"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>
          <p class='garisbawah'></p>
          <input type=button class='tombol' value='Kembali'
          onclick=self.history.back()>";
    }else{
        echo "<script>window.alert('Tidak ada siswa dikelas ini');
            window.location=(href='?module=kelas')</script>";
    }
    }
    break;



  case "nis_ada":
     if ($_SESSION[leveluser]=='admin'){
         echo "<span class='judulhead'><p class='garisbawah'>NIS SUDAH PERNAH DIGUNAKAN<br>
               <input type=button value=Kembali onclick=self.history.back()></p></span>";
     }
     break;

  case "editsiswa":
    $edit=mysql_query("SELECT * FROM siswa WHERE id_siswa='$_GET[id]'");
    $r=mysql_fetch_array($edit);
    $get_kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
    $kelas = mysql_fetch_array($get_kelas);

    if ($_SESSION[leveluser]=='admin'){
    echo "<form method=POST action=$aksi?module=siswa&act=update_siswa enctype='multipart/form-data'>
          <input type=hidden name=id value='$r[id_siswa]'>
          <fieldset>
          <legend>Edit Siswa</legend>
          <dl class='inline'>
          <dt><label>Nama</label></dt>     <dd> : <input type=text name='nama' value='$r[nama_lengkap]' size=50></dd>
          <dt><label>Username Login</label></dt>     <dd> : <input type=text name='username' value='$r[username_login]' size=50></dd>
          <dt><label>Password Login</label></dt> <dd> : <input type=text name='password' size=30><small>Apabila password tidak diubah, dikosongkan saja</small></dd>
          <dt><label>Kelas</label></dt>        <dd> : <select name='id_kelas'>
                                           <option value=$kelas[id_kelas] selected>$kelas[nama]</option>";
                                           $tampil=mysql_query("SELECT * FROM kelas ORDER BY nama");
                                           while($k=mysql_fetch_array($tampil)){
                                           echo "<option value=$k[id_kelas]>$k[nama]</option>";
                                           }echo "</select></dd>
          <dt><label>Alamat</label></dt>       <dd> : <input type=text name='alamat' size=50 value='$r[alamat]'></dd>
          <dt><label>Tempat Lahir</label></dt> <dd> : <input type=text name='tempat_lahir' size=50 value='$r[tempat_lahir]'></dd>
          <dt><label>Tanggal Lahir</label></dt><dd> : ";
          $get_tgl=substr("$r[tgl_lahir]",8,2);
          combotgl(1,31,'tgl',$get_tgl);
          $get_bln=substr("$r[tgl_lahir]",5,2);
          combonamabln(1,12,'bln',$get_bln);
          $get_thn=substr("$r[tgl_lahir]",0,4);
          combothn(1950,$thn_sekarang,'thn',$get_thn);

    echo "</dd>";
          if ($r[jenis_kelamin]=='L'){
              echo "<dt><label>Jenis Kelamin</label></dt><dd> : <label><input type=radio name='jk' value='L' checked>Laki - Laki</label>
                                           <label><input type=radio name='jk' value='P'>Perempuan</label></dd>";
          }else{
              echo "<dt><label>Jenis Kelamin</label></dt><dd> : <label><input type=radio name='jk' value='L'>Laki - Laki</label>
                                           <label><input type=radio name='jk' value='P' checked>Perempuan</label></dd>";
          }      
          echo "
          
          <dt><label>Email</label></dt>        <dd> : <input type=text name='email' size=30 value='$r[email]'></dd>
          <dt><label>No Telp/HP</label></dt>   <dd> : <input type=text name='no_telp' size=30 value='$r[no_telp]'></dd>
          <dt><label>Foto</label></dt>   <dd> : ";
            if ($r[foto]!=''){
              echo "<ul class='photos sortable'>
                    <li>
                    <img src='../foto_siswa/medium_$r[foto]'>
                    <div class='links'>
                    <a href='../foto_siswa/medium_$r[foto]' rel='facebox'>View</a>
		    <div>
                    </li>
                    </ul>";
          }echo "</dd>
          <dt><label>Ganti Foto</label></dt>       <dd> : <input type=file name='fupload' size=40>
                                                <small>Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px</small>
                                                <small>Apabila foto tidak diganti, dikosongkan saja</small></dd>";
    if ($r[blokir]=='N'){
      echo "<dt><label>Blokir</label></dt>     <dd> : <label><input type=radio name='blokir' value='Y'> Y</label>
                                           <label><input type=radio name='blokir' value='N' checked> N </label></tr>";
    }
    else{
      echo "<dt><label>Blokir</label></dt>     <dd> : <label><input type=radio name='blokir' value='Y' checked> Y</label>
                                          <label><input type=radio name='blokir' value='N'> N </label></tr>";
    }

    echo "</dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='siswa') {
     echo"<br><b class='judul'>Edit Profil</b><br><p class='garisbawah'></p>";
     echo"<form method=POST action=$aksi_siswa?module=siswa&act=update_profil_siswa enctype='multipart/form-data'>
          <input type=hidden name=id value='$r[id_siswa]'>
          <table>
          <tr><td>Nama</td>     <td> : <input type=text name='nama' value='$r[nama_lengkap]' size=40></td></tr>          
          <tr><td>Alamat</td>       <td> : <input type=text name='alamat' size=80 value='$r[alamat]'></td></tr>
          <tr><td>Tempat Lahir</td> <td> : <input type=text name='tempat_lahir' size=60 value='$r[tempat_lahir]'></td></tr>
          <tr><td>Tanggal Lahir</td><td> : ";
          $get_tgl=substr("$r[tgl_lahir]",8,2);
          combotgl(1,31,'tgl',$get_tgl);
          $get_bln=substr("$r[tgl_lahir]",5,2);
          combonamabln(1,12,'bln',$get_bln);
          $get_thn=substr("$r[tgl_lahir]",0,4);
          combothn(1950,$thn_sekarang,'thn',$get_thn);

    echo "</td></tr>";
          if ($r[jenis_kelamin]=='L'){
              echo "<tr><td>Jenis Kelamin</td><td> : <input type=radio name='jk' value='L' checked>Laki - Laki
                                           <input type=radio name='jk' value='P'>Perempuan</tr></tr>";
          }else{
              echo "<tr><td>Jenis Kelamin</td><td> : <input type=radio name='jk' value='L'>Laki - Laki
                                           <input type=radio name='jk' value='P' checked>Perempuan</tr></tr>";
          }
          echo "
          <tr><td>Email</td>        <td> : <input type=text name='email' size=30 value='$r[email]'></td></tr>
          <tr><td>No Telp/HP</td>   <td> : <input type=text name='no_telp' size=20 value='$r[no_telp]'></td></tr>
          <tr><td>Foto</td>   <td> : ";
            if ($r[foto]!=''){
              echo "<img src='foto_siswa/medium_$r[foto]'>";
          }echo "</td></tr>
          <tr><td>Ganti Foto</td>       <td> : <input type=file name='fupload' size=40>
                                           <br>**) Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px<br>
                                                ***) Apabila foto tidak diganti, dikosongkan saja</td></tr>";   

    echo "<tr><td colspan=2><input type=submit class='tombol' value='Update'>
                            <input type=button class='tombol' value='Batal'
                            onclick=self.history.back()>
                            </td></tr>
          </table></form>";
    }
    break;

    
 case "detailsiswa":
    if ($_SESSION[leveluser]=='admin'){
       $detail=mysql_query("SELECT * FROM siswa WHERE id_siswa='$_GET[id]'");
       $siswa=mysql_fetch_array($detail);
       $tgl_lahir   = tgl_indo($siswa[tgl_lahir]);

       $get_kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$siswa[id_kelas]'");
       $kelas = mysql_fetch_array($get_kelas);
       
       echo "<form><fieldset>
          <legend>Detail Siswa</legend>
          <dl class='inline'>
          <dt><label>Nama</label></dt>               <dd> : $siswa[nama_lengkap]</dd>
          <dt><label>Username Login</label></dt>     <dd> : $siswa[username_login]</dd>
          <dt><label>Kelas</label></dt>              <dd> : <a href=?module=kelas&act=detailkelas&id=$siswa[id_kelas]>$kelas[nama]</a></dd>
          <dt><label>Alamat</label></dt>             <dd> : $siswa[alamat]</dd>
          <dt><label>Tempat Lahir</label></dt> <dd> : $siswa[tempat_lahir]</dd>
          <dt><label>Tanggal Lahir</label></dt><dd> : $tgl_lahir</dd>";
          if ($siswa[jenis_kelamin]=='P'){
           echo "<dt><label>Jenis Kelamin</label></dt>     <dd>  : Perempuan</dd>";
            }
            else{
           echo "<dt><label>Jenis kelamin</label></dt>     <dd> :  Laki - Laki </dd>";
            }echo"
          <dt><label>E-Mail</label></dt>             <dd> : <a href=mailto:$siswa[email]>$siswa[email]</a></dd>
          <dt><label>No.Telp/Hp</label></dt>         <dd> : $siswa[no_telp]</dd>
          <dt><label>Blokir</label></dt>             <dd> : $siswa[blokir]</dd>
          <dt><label>Foto</label></dt>             <dd> :
          <ul class='photos sortable'>
              <li>";if ($siswa[foto]!=''){
              echo "<img src='../foto_siswa/medium_$siswa[foto]'>
              <div class='links'>
                    <a href='../foto_siswa/medium_$siswa[foto]' rel='facebox'>View</a>
              <div>
              </li>
              </ul></dd>";
          }
          echo "</dl>
          <div class='buttons'>
          <input class='button blue' type=button value=Kembali onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
       $detail=mysql_query("SELECT * FROM siswa WHERE id_siswa='$_GET[id]'");
       $siswa=mysql_fetch_array($detail);
       $tgl_lahir   = tgl_indo($siswa[tgl_lahir]);

       $get_kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$siswa[id_kelas]'");
       $kelas = mysql_fetch_array($get_kelas);

       echo "<form><fieldset>
             <legend>Detail Siswa</legend>
             <dl class='inline'>
       <table id='table1' class='gtable sortable'>
          <tr><td rowspan='15'>";if ($siswa[foto]!=''){
              echo "<ul class='photos sortable'>
                    <li>
                    <img src='../foto_siswa/medium_$siswa[foto]'>
                    <div class='links'>
                    <a href='../foto_siswa/medium_$siswa[foto]' rel='facebox'>View</a>
                    <div>
                    </li>
                    </ul>";
          }echo "</td><td>Nis</td>        <td> : $siswa[nis]</td></tr>
          <tr><td>Nama</td>               <td> : $siswa[nama_lengkap]</td></tr>          
          <tr><td>Kelas</td>              <td> : <a href=?module=kelas&act=detailkelas&id=$siswa[id_kelas]>$kelas[nama]</td></tr>
          <tr><td>alamat</td>             <td> : $siswa[alamat]</td></tr>
          <tr><td>Tempat Lahir</td> <td> : $siswa[tempat_lahir]</td></tr>
          <tr><td>Tanggal Lahir</td><td> : $tgl_lahir</td></tr>";
          if ($siswa[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td>  : Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td> :  Laki - Laki </td></tr>";
            }echo"
          <tr><td>E-Mail</td>             <td> : <a href=mailto:$siswa[email]>$siswa[email]</a></td></tr>
          <tr><td>No.Telp/Hp</td>         <td> : $siswa[no_telp]</td></tr>
          <tr><td>Aksi</td>               <td> : <input type=button class='button small white' value=Kembali onclick=self.history.back()></td></tr>";
          echo"</table></dl></fieldset</form>";
    }
    elseif ($_SESSION[leveluser]=='siswa'){
       $detail=mysql_query("SELECT * FROM siswa WHERE id_siswa='$_GET[id]'");
       $siswa=mysql_fetch_array($detail);
       $tgl_lahir   = tgl_indo($siswa[tgl_lahir]);

       $get_kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$siswa[id_kelas]'");
       $kelas = mysql_fetch_array($get_kelas);

      echo"<br><b class='judul'>Detail Siswa</b><br><p class='garisbawah'></p>
       <table>
             <tr><td rowspan='14'>";if ($siswa[foto]!=''){
              echo "<img src='foto_siswa/medium_$siswa[foto]'>";
          }echo "</td><td>Nis</td>        <td> : $siswa[nis]</td></tr>
          <tr><td>Nama</td>               <td> : $siswa[nama_lengkap]</td></tr>          
          <tr><td>Kelas</td>              <td> : $kelas[nama]</td></tr>
          <tr><td>alamat</td>             <td> : $siswa[alamat]</td></tr>
          <tr><td>Tempat Lahir</td> <td> : $siswa[tempat_lahir]</td></tr>
          <tr><td>Tanggal Lahir</td><td> : $tgl_lahir</td></tr>";
          if ($siswa[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td>  : Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td> :  Laki - Laki </td></tr>";
            }echo"
          <tr><td>E-Mail</td>             <td> : <a href=mailto:$siswa[email]>$siswa[email]</a></td></tr>
          <tr><td>No.Telp/Hp</td>         <td> : $siswa[no_telp]</td></tr>";
          echo"<tr><td colspan='3'><input type=button class='tombol' value='Kembali'
          onclick=self.history.back()></td></tr></table>";

    }
    break;

case "detailprofilsiswa":
    if ($_SESSION[leveluser]=='siswa'){
       $detail=mysql_query("SELECT * FROM siswa WHERE id_siswa='$_GET[id]'");
       $siswa=mysql_fetch_array($detail);
       $tgl_lahir   = tgl_indo($siswa[tgl_lahir]);

       $get_kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$siswa[id_kelas]'");
       $kelas = mysql_fetch_array($get_kelas);

      echo"<br><b class='judul'>Detail Siswa</b><br><p class='garisbawah'></p>
       <table>
             <tr><td rowspan='14'>";if ($siswa[foto]!=''){
              echo "<img src='foto_siswa/medium_$siswa[foto]'>";
          }echo "
          <tr><td>Nama</td>               <td> : $siswa[nama_lengkap]</td></tr>
          <tr><td>Kelas</td>              <td> : $kelas[nama]</td></tr>
          <tr><td>alamat</td>             <td> : $siswa[alamat]</td></tr>
          <tr><td>Tempat Lahir</td> <td> : $siswa[tempat_lahir]</td></tr>
          <tr><td>Tanggal Lahir</td><td> : $tgl_lahir</td></tr>";
          if ($siswa[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td>  : Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td> :  Laki - Laki </td></tr>";
            }echo"
          <tr><td>E-Mail</td>             <td> : <a href=mailto:$siswa[email]>$siswa[email]</a></td></tr>
          <tr><td>No.Telp/Hp</td>         <td> : $siswa[no_telp]</td></tr>";
          echo"<tr><td colspan='3'><input type=button class='tombol' value='Edit Profil' onclick=\"window.location.href='?module=siswa&act=editsiswa&id=$siswa[id_siswa]';\"></td></tr></table>";
    }
    break;

case "detailaccount":
    if ($_SESSION[leveluser]=='siswa'){
        $detail=mysql_query("SELECT * FROM siswa WHERE id_siswa='$_GET[id]'");
        $siswa=mysql_fetch_array($detail);
        echo"<form method=POST action=$aksi_siswa?module=siswa&act=update_account_siswa>";
        echo"<br><b class='judul'>Edit Account Login</b><br><p class='garisbawah'></p>
        <table>
        <tr><td>Username</td><td>:<input type=text name='username' size='40'></td></tr>
        <tr><td>Password</td><td>:<input type=password name='password' size='40'></td></tr>
        <tr><td colspan=2>*) Apabila Username tidak diubah di kosongkan saja.</td></tr>
        <tr><td colspan=2>**) Apabila Password tidak diubah di kosongkan saja.</td></tr>
        <tr><td colspan=2><input type=submit class='tombol' value='Update'></td></tr>
        </table>";
    }
    break;
}
}
?>
