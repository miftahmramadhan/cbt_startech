<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../configurasi/koneksi.php";
include "../../../configurasi/library.php";
include "../../../configurasi/fungsi_thumb.php";

$module=$_GET['module'];
$act=$_GET['act'];

if ($module=='quiz' AND $act=='input_topikquiz'){
    $pelajaran = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$_POST[id_matapelajaran]'");
    $data = mysql_fetch_array($pelajaran);
    $pengajar = mysql_query("SELECT * FROM pengajar WHERE id_pengajar = '$data[id_pengajar]'");
    $cek_pengajar_pelajaran = mysql_num_rows($pengajar);
    if (!empty($cek_pengajar_pelajaran)){
    
    $wpengerjaan = $_POST['waktu'] * 60;
    mysql_query("INSERT INTO topik_quiz(
                                    judul,
                                    id_kelas,
                                    id_matapelajaran,
                                    tgl_buat,
                                    pembuat,
                                    waktu_pengerjaan,
                                    info,
                                    terbit)
                            VALUES('$_POST[judul]',
                                   '$_POST[id_kelas]',
                                   '$_POST[id_matapelajaran]',
                                   '$tgl_sekarang',
                                   '$data[id_pengajar]',
                                   '$wpengerjaan',
                                   '$_POST[info]',
                                   '$_POST[terbit]')");
    }else{
        $wpengerjaan = $_POST['waktu'] * 60;
        mysql_query("INSERT INTO topik_quiz(
                                    judul,
                                    id_kelas,
                                    id_matapelajaran,
                                    tgl_buat,
                                    pembuat,
                                    waktu_pengerjaan,
                                    info,
                                    terbit)
                            VALUES('$_POST[judul]',
                                   '$_POST[id_kelas]',
                                   '$_POST[id_matapelajaran]',
                                   '$tgl_sekarang',
                                   '$_SESSION[leveluser]',
                                   '$wpengerjaan',
                                   '$_POST[info]',
                                   '$_POST[terbit]')");
    }
  header('location:../../media_admin.php?module='.$module);
}

elseif($module=='quiz' AND $act=='inputnilai'){
    mysql_query("UPDATE siswa_sudah_mengerjakan SET dikoreksi = 'S'
                                                WHERE id_tq ='$_POST[id_tq]' AND id_siswa = '$_POST[id_siswa]'");
    mysql_query("INSERT INTO nilai_soal_esay (id_tq,id_siswa,nilai)
                                   VALUES ('$_POST[id_tq]','$_POST[id_siswa]','$_POST[nilai]')");
    header('location:../../media_admin.php?module=quiz&act=daftarsiswayangtelahmengerjakan&id='.$_POST[id_tq]);
}

elseif($module=='quiz' AND $act=='inputeditnilai'){
    mysql_query("UPDATE nilai_soal_esay SET nilai = '$_POST[nilai]' WHERE id_tq ='$_POST[id_tq]' AND id_siswa = '$_POST[id_siswa]' ");
    header('location:../../media_admin.php?module=quiz&act=daftarsiswayangtelahmengerjakan&id='.$_POST[id_tq]);
}


elseif($module=='quiz' AND $act=='edit_topikquiz'){
    $pelajaran = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$_POST[id_matapelajaran]'");
    $data = mysql_fetch_array($pelajaran);
    $pengajar = mysql_query("SELECT * FROM pengajar WHERE id_pengajar = '$data[id_pengajar]'");
    $cek_pengajar_pelajaran = mysql_num_rows($pengajar);
    if (!empty($cek_pengajar_pelajaran)){
    $waktu = $_POST['waktu'] * 60;
    mysql_query("UPDATE topik_quiz SET judul = '$_POST[judul]',
                                        id_kelas = '$_POST[id_kelas]',
                                        id_matapelajaran = '$_POST[id_matapelajaran]',
                                        tgl_buat = '$tgl_sekarang',
                                        pembuat = '$data[id_pengajar]',
                                        waktu_pengerjaan = '$waktu',
                                        info = '$_POST[info]',
                                        terbit = '$_POST[terbit]'
                             WHERE id_tq = '$_POST[id]'");
    }else{
        $waktu = $_POST['waktu'] * 60;
        mysql_query("UPDATE topik_quiz SET judul = '$_POST[judul]',
                                        id_kelas = '$_POST[id_kelas]',
                                        id_matapelajaran = '$_POST[id_matapelajaran]',
                                        tgl_buat = '$tgl_sekarang',
                                        pembuat = '$_SESSION[leveluser]',
                                        waktu_pengerjaan = '$waktu',
                                        info = '$_POST[info]',
                                        terbit = '$_POST[terbit]'
                             WHERE id_tq = '$_POST[id]'");
    }
header('location:../../media_admin.php?module='.$module);
}

elseif($module=='quiz' AND $act=='editsiswayangtelahmengerjakan'){
    mysql_query("DELETE FROM siswa_sudah_mengerjakan WHERE id_siswa='$_GET[id_siswa]' AND id = '$_GET[id]'");
    mysql_query("DELETE FROM nilai_soal_esay WHERE id_tq='$_GET[id_tq]' AND id_siswa='$_GET[id_siswa]'");
    mysql_query("DELETE FROM nilai WHERE id_tq='$_GET[id_tq]' AND id_siswa='$_GET[id_siswa]'");
    mysql_query("DELETE FROM jawaban WHERE id_tq='$_GET[id_tq]' AND id_siswa ='$_GET[id_siswa]'");
    mysql_query("DELETE FROM rvjawaban WHERE id_rvjaw='$_GET[id_rvjaw]'");
    header('location:../../media_admin.php?module='.$module);

}

elseif($module=='quiz' AND $act=='hapustopikquiz'){
    //hapus topik
  mysql_query("DELETE FROM topik_quiz WHERE id_tq = '$_GET[id]'");
  //hapus kuiz esay
  $cek = mysql_query("SELECT * FROM quiz_esay WHERE id_tq = '$_GET[id]'");
     $r = mysql_fetch_array($cek);
     if(empty($r[gambar])){
        mysql_query("DELETE FROM quiz_esay WHERE id_tq = '$_GET[id]'");
     }else{
         $img = "../../../foto_soal/$r[gambar]";
         unlink($img);
         $img2 = "../../../foto_soal/medium_$r[gambar]";
         unlink($img2);
         mysql_query("DELETE FROM quiz_esay WHERE id_tq = '$_GET[id]'");
     }
  //hapus kuiz pilihan ganda
  $cek2 = mysql_query("SELECT * FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
     $r2 = mysql_fetch_array($cek2);
     if(empty($r2[gambar])){
        mysql_query("DELETE FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
     }else{
         $img = "../../../foto_soal_pilganda/$r2[gambar]";
         unlink($img);
         $img2 = "../../../foto_soal_pilganda/medium_$r2[gambar]";
         unlink($img2);
         mysql_query("DELETE FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
     }
  header('location:../../media_admin.php?module='.$module);
}

elseif($module=='quiz' AND $act=='input_quizesay'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];
  $direktori_file = "../../../foto_soal/$nama_file";
  $tipe_file = $_FILES['fupload']['type'];
  
  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
        if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=quiz&&act=buatquizesay&id=$_POST[id]')</script>";
        }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"             
            ){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='../../media_admin.php?module=quiz&act=buatquizesay&id=$_POST[id]')</script>";
            }else{
                UploadImage_soal($nama_file);
                mysql_query("INSERT INTO quiz_esay(id_tq,pertanyaan,gambar,tgl_buat)
                   VALUES('$_POST[id]','$_POST[pertanyaan]','$nama_file','$tgl_sekarang')");
            }
        }     
    }else{
        mysql_query("INSERT INTO quiz_esay(id_tq,pertanyaan,tgl_buat)
                   VALUES('$_POST[id]','$_POST[pertanyaan]','$tgl_sekarang')");
    }
header('location:../../media_admin.php?module=daftarquizesay&act=daftarquizesay&id='.$_POST[id]);
}

elseif($module=='quiz' AND $act=='input_quizpilganda'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $nama_file   = $_FILES['fupload']['name'];
    $direktori_file = "../../../foto_soal_pilganda/$nama_file";
    $tipe_file = $_FILES['fupload']['type'];

     // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=buatquizpilganda&&act=buatquizpilganda&id=$_POST[id]')</script>";
        }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"
            ){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='../../media_admin.php?module=buatquizpilganda&act=buatquizpilganda&id=$_POST[id]')</script>";
            }else{
                UploadImage_soal_pilganda($nama_file);
                mysql_query("INSERT INTO quiz_pilganda(id_tq,pertanyaan,gambar,pil_a,pil_b,pil_c,pil_d,kunci,id_field,id_step,tgl_buat)
                   VALUES('$_POST[id]','$_POST[pertanyaan]','$nama_file','$_POST[pila]','$_POST[pilb]','$_POST[pilc]','$_POST[pild]','$_POST[kunci]','$_POST[id_field]','$_POST[id_step]','$tgl_sekarang')");
            }
        }
    }else{
        mysql_query("INSERT INTO quiz_pilganda(id_tq,pertanyaan,pil_a,pil_b,pil_c,pil_d,kunci,id_field,id_step,tgl_buat)
                   VALUES('$_POST[id]','$_POST[pertanyaan]','$_POST[pila]','$_POST[pilb]','$_POST[pilc]','$_POST[pild]','$_POST[kunci]','$_POST[id_field]','$_POST[id_step]','$tgl_sekarang')");
    }          
    header('location:../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id='.$_POST[id]);
}

elseif($module=='quiz' AND $act=='edit_quizesay'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];
  $direktori_file = "../../../foto_soal/$nama_file";
  $tipe_file = $_FILES['fupload']['type'];

  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
        if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=daftarquizesay&act=daftarquizesay&id=$_POST[topik]')</script>";
        }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"               
            ){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='?module=quiz&act=daftarquizesay&id=$_POST[topik]')</script>";
            }else{
                $cek = mysql_query("SELECT * FROM quiz_esay WHERE id_quiz = '$_POST[id]'");
                $r = mysql_fetch_array($cek);
                if(!empty($r[gambar])){
                $img = "../../../foto_soal/$r[gambar]";
                unlink($img);
                $img2 = "../../../foto_soal/medium_$r[gambar]";
                unlink($img2);
                UploadImage_soal($nama_file);
                mysql_query("UPDATE quiz_esay SET pertanyaan = '$_POST[pertanyaan]',
                                                  gambar     = '$nama_file',
                                                  tgl_buat   = '$tgl_sekarang'
                                            WHERE id_quiz = '$_POST[id]'");
                }else{
                    UploadImage_soal($nama_file);
                    mysql_query("UPDATE quiz_esay SET pertanyaan = '$_POST[pertanyaan]',
                                                  gambar     = '$nama_file',
                                                  tgl_buat   = '$tgl_sekarang'
                                            WHERE id_quiz = '$_POST[id]'");
                }
            }
        }
    }else{
        mysql_query("UPDATE quiz_esay SET pertanyaan = '$_POST[pertanyaan]',
                                          tgl_buat   = '$tgl_sekarang'
                                       WHERE id_quiz = '$_POST[id]'");
    }
    header('location:../../media_admin.php?module=daftarquizesay&act=daftarquizesay&id='.$_POST[topik]);
}

elseif($module=='quiz' AND $act=='hapusquizesay'){
     $cek = mysql_query("SELECT * FROM quiz_esay WHERE id_quiz = '$_GET[id]'");
     $r = mysql_fetch_array($cek);
     if(empty($r[gambar])){
        mysql_query("DELETE FROM quiz_esay WHERE id_quiz = '$_GET[id]'");
     }else{
         $img = "../../../foto_soal/$r[gambar]";
         unlink($img);
         $img2 = "../../../foto_soal/medium_$r[gambar]";
         unlink($img2);
         mysql_query("DELETE FROM quiz_esay WHERE id_quiz = '$_GET[id]'");
     }
     header('location:../../media_admin.php?module=daftarquizesay&act=daftarquizesay&id='.$_GET[id_topik]);
}

elseif($module=='quiz' AND $act=='uploadquiz'){
    // menggunakan class phpExcelReader
include "../../../configurasi/excel_reader2.php";

// koneksi ke mysql
// membaca file excel yang diupload
//date_default_timezone_set('Asia/Jakarta');
//$tanggal=date("hismdY");
$tempFile =  $_FILES['file']['tmp_name'];
    //$lokasi_file = $_FILES['file']['tmp_name'];
    $nama_file   = $_FILES['file']['name'];
    $targetPath = "../../../upload_soal/";
    $targetFile = $targetPath . $nama_file;
    $tipe_file = $_FILES['file']['type'];
    //echo "$tempFile <br> $targetFile";

  if(!empty($tempFile)){
    //$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
    //$targetPath = "../../../Upload";
    //$targetFile =  str_replace('//','/',$targetPath) . $tanggal.$_FILES['file']['name']  ;
                                      
      //move_uploaded_file($tempFile,$targetFile);  
      //$movedata = move_uploaded_file($tempFile,$targetFile); 

      //if(move_uploaded_file($tempFile,$targetFile)){
                                             
        //chmod($targetFile, 0755);
                                     
        //Create new instance
        $data = new Spreadsheet_Excel_Reader();
        //$excel->setOutputEncoding('CP1251');
        $data->read($tempFile);

        // membaca jumlah baris dari data excel
        $baris = $data->rowcount($sheet_index=0);

        // nilai awal counter untuk jumlah data yang sukses dan yang gagal diimport
        $sukses = 0;
        $gagal = 0;

        // import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
        for ($i=16; $i<=$baris; $i++){
          // membaca data Pertanyaan (kolom ke-1)
          //$tgl=date("d/m/Y", strtotime($data->val($i, 1)));
          $pertanyaan = $data->val($i,2);
          $pila = $data->val($i,3);
          $pilb = $data->val($i,4);
          $pilc = $data->val($i,5);
          $pild = $data->val($i,6);
          $kunci = $data->val($i,7);
          $step = $data->val($i,8);
          $field = $data->val($i,9);
          /* membaca data id coa (kolom ke-2)
          $id_coa = $data->val($i, 2);
          // membaca data deskripsi transaksi (kolom ke-3)
          $desc_trx = $data->val($i, 3);
          // membaca data deskripsi transaksi (kolom ke-3)
          $debit = (int)$data->val($i, 4);
          // membaca data deskripsi transaksi (kolom ke-3)
          $credit = (int)$data->val($i, 5);
          */
        
          $query = ("INSERT INTO quiz_pilganda(id_tq,pertanyaan,pil_a,pil_b,pil_c,pil_d,kunci,id_field,id_step,tgl_buat)
                         VALUES('$_GET[id]','$pertanyaan','$pila','$pilb','$pilc','$pild','$kunci','$field','$step','$tgl_sekarang')");
          $hasil = mysql_query($query);

          // jika proses insert data sukses, maka counter $sukses bertambah
          // jika gagal, maka counter $gagal yang bertambah
          if ($hasil) $sukses++;
          else $gagal++;
        }

        // tampilan status sukses dan gagal
          echo "<script>window.alert('Proses Upload Soal berhasil');
                  window.location=(href='../../media_admin.php?module=buatquiz&act=buatquiz&id=$_GET[id]')</script>";
        /*echo "<h3>Proses import data selesai.</h3>";
        echo "<p>Jumlah data yang sukses diimport : ".$sukses."<br>";
        echo "Jumlah data yang gagal diimport : ".$gagal."</p>"."<br>";
        echo "Harap Tunggu, anda akan di redirect ke halaman awal";
        header( 'Refresh: 3; url= index.php' ) ;*/
    
  }else{
      echo "<script>window.alert('Tidak ada file yang di Upload');
          window.location=(href='../../media_admin.php?module=buatquiz&act=buatquiz&id=$_GET[id]')</script>";
  }
}


elseif($module=='quiz' AND $act=='edit_quizpilganda'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $nama_file   = $_FILES['fupload']['name'];
    $direktori_file = "../../../foto_soal_pilganda/$nama_file";
    $tipe_file = $_FILES['fupload']['type'];

    // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id=$_POST[topik]')</script>";
        }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"
            ){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id=$_POST[topik]')</script>";
            }else{
                $cek = mysql_query("SELECT * FROM quiz_pilganda WHERE id_quiz = '$_POST[id]'");
                $r = mysql_fetch_array($cek);
                if(!empty($r[gambar])){
                $img = "../../../foto_soal_pilganda/$r[gambar]";
                unlink($img);
                $img2 = "../../../foto_soal_pilganda/medium_$r[gambar]";
                unlink($img2);
                UploadImage_soal_pilganda($nama_file);
                mysql_query("UPDATE quiz_pilganda SET pertanyaan = '$_POST[pertanyaan]',
                                           gambar     = '$nama_file',
                                           pil_a      = '$_POST[pila]',
                                           pil_b      = '$_POST[pilb]',
                                           pil_c      = '$_POST[pilc]',
                                           pil_d      = '$_POST[pild]',
                                           kunci      = '$_POST[kunci]',
                                           id_field	  = '$_POST[id_field]',
                                           id_step	  = '$_POST[id_step]',
                                           tgl_buat   = '$tgl_sekarang'
                                        WHERE id_quiz = '$_POST[id]'");
                }else{
                    UploadImage_soal_pilganda($nama_file);
                    mysql_query("UPDATE quiz_pilganda SET pertanyaan = '$_POST[pertanyaan]',
                                           gambar     = '$nama_file',
                                           pil_a      = '$_POST[pila]',
                                           pil_b      = '$_POST[pilb]',
                                           pil_c      = '$_POST[pilc]',
                                           pil_d      = '$_POST[pild]',
                                           kunci      = '$_POST[kunci]',
                                           id_field	  = '$_POST[id_field]',
                                           id_step	  = '$_POST[id_step]',
                                           tgl_buat   = '$tgl_sekarang'
                                        WHERE id_quiz = '$_POST[id]'");
                }
            }
        }
    }else{
        mysql_query("UPDATE quiz_pilganda SET pertanyaan = '$_POST[pertanyaan]',
                                           pil_a      = '$_POST[pila]',
                                           pil_b      = '$_POST[pilb]',
                                           pil_c      = '$_POST[pilc]',
                                           pil_d      = '$_POST[pild]',
                                           kunci      = '$_POST[kunci]',
                                           id_field	  = '$_POST[id_field]',
                                           id_step	  = '$_POST[id_step]',
                                           tgl_buat   = '$tgl_sekarang'
                                        WHERE id_quiz = '$_POST[id]'");
    }
     header('location:../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id='.$_POST[topik]);
}

elseif($module=='quiz' AND $act=='hapusquizpilganda'){
    $cek = mysql_query("SELECT * FROM quiz_pilganda WHERE id_quiz = '$_GET[id]'");
     $r = mysql_fetch_array($cek);
     if(empty($r[gambar])){
        mysql_query("DELETE FROM quiz_pilganda WHERE id_quiz = '$_GET[id]'");
     }else{
         $img = "../../../foto_soal_pilganda/$r[gambar]";
         unlink($img);
         $img2 = "../../../foto_soal_pilganda/medium_$r[gambar]";
         unlink($img2);
         mysql_query("DELETE FROM quiz_pilganda WHERE id_quiz = '$_GET[id]'");
     }
     header('location:../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id='.$_GET[id_topik]);
}

}
?>
