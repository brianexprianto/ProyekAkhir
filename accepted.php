<?php 
 include "configuration/config_connect.php";
 session_start();

 date_default_timezone_set("Asia/Jakarta");
$today=date('Y-m-d');

if(isset($_POST["diterima"])){
if($_SERVER["REQUEST_METHOD"] == "POST"){


$no = mysqli_real_escape_string($conn, $_POST["no"]);
$nota = mysqli_real_escape_string($conn, $_POST["nota"]);
$kode = mysqli_real_escape_string($conn, $_POST["kode"]);
$terima = mysqli_real_escape_string($conn, $_POST["terima"]);


$kasir = $_SESSION["username"];
$kegiatan = "terima barang invoice pembelian";
$status = "berhasil";

 $sql="select * from invoicebeli where nota='$nota' and kode='$kode' and no='$no' ";
            $result=mysqli_query($conn,$sql);


            if(mysqli_num_rows($result)>0){

 $sql1 = "update invoicebeli set terima='$terima' where nota='$nota' and kode='$kode' and no='$no' ";
			            $updatean = mysqli_query($conn, $sql1);
if ($updatean){


 $sqle3="SELECT * FROM barang where kode='$kode'";
              $hasile3=mysqli_query($conn,$sqle3);
              $row=mysqli_fetch_assoc($hasile3);
              $sisaawal=$row['sisa'];
              $terbeliawal=$row['terbeli'];
              $terjualawal=$row['terjual'];

              $terbeliakhir = $terbeliawal + $terima;
              $sisaakhir = $terbeliakhir - $terjualawal;

               $sql3 = "UPDATE barang SET terbeli='$terbeliakhir', sisa='$sisaakhir' where kode='$kode'";
               $updatestok = mysqli_query($conn, $sql3);


// masukan mutasi
               $sql4 = "INSERT INTO mutasi values ( '$kasir','$today','$kode','$sisaakhir','$terima','$kegiatan','$nota','','$status')";
               $mutasi = mysqli_query($conn, $sql4);


if ($updatestok){
                 
                  echo "<script type='text/javascript'>window.location = 'diterima?nota=$nota&berhasil=1';</script>";

} else { echo "<script type='text/javascript'>window.location = 'diterima?nota=$nota&berhasil=2';</script>"; }

} else {echo "<script type='text/javascript'>window.location = 'diterima?nota=$nota&berhasil=2';</script>";}

} else {echo "<script type='text/javascript'>window.location = 'diterima?nota=$nota&berhasil=3';</script>";}

  } } else {echo "<script type='text/javascript'>window.location = 'diterima?nota=$nota&berhasil=3';</script>";}

 ?>