<?php
include "../../configuration/config_connect.php";
include "../../configuration/config_session.php";
include "../../configuration/config_chmod.php";
include "../../configuration/config_etc.php";
$forward =$_GET['forward'];
$no = $_GET['no'];
$chmod = $_GET['chmod'];
$forwardpage = $_GET['forwardpage'];
$nota = $_GET['nota'];
$jumlah = $_GET['jumlah'];
$kode = $_GET['kode'];
$jenis = $_GET['jenis'];
$harga=$_GET['harga'];
$sub=$jumlah*$harga;
?>

<?php
if( $chmod == '4' || $chmod == '5' || $_SESSION['jabatan'] =='admin'){

if($jenis == '1'){
  $sqle3="SELECT * FROM barang where kode='$kode'";
  $hasile3=mysqli_query($conn,$sqle3);
  $row=mysqli_fetch_assoc($hasile3);
 $sisaawal=$row['sisa'];
  $terbeliawal=$row['terbeli'];
  $terjualawal=$row['terjual'];
    $terbeliakhir = $terbeliawal - $jumlah;

  $sisaakhir = $sisaawal - $jumlah;


   $sqll3 = "UPDATE barang SET terbeli='$terbeliakhir', sisa='$sisaakhir' where kode='$kode'";
   $updatestok = mysqli_query($conn, $sqll3);

   $sqlw1=mysqli_fetch_assoc(mysqli_query($conn,"SELECT total FROM buy WHERE nota='$nota'"));
   $newtot=$sub+$sqlw1['total'];
    $up=mysqli_query($conn,"UPDATE buy SET total='$newtot' WHERE nota='$nota'");   


$sqlw1=mysqli_query($conn,"SELECT * FROM invoicebeli WHERE nota='$nota'");

   if(mysqli_num_rows($sqlw1)<=1){

$del=mysqli_query($conn,"DELETE FROM buy WHERE nota='$nota'");

$de1=mysqli_query($conn,"DELETE FROM hutang WHERE nota='$nota'");
$del2=mysqli_query($conn,"DELETE FROM payment WHERE tipe='1' AND nota='$nota'");
$cek=1;
}






}else{
  $sqle3="SELECT * FROM barang where kode='$kode'";
  $hasile3=mysqli_query($conn,$sqle3);
  $row=mysqli_fetch_assoc($hasile3);
 
  $terjualawal=$row['terjual'];
  $sisa=$row['sisa'];

  $terjualakhir = $terjualawal-$jumlah;
  $sisaakhir = $sisa + $jumlah;

   $sql3 = "UPDATE barang SET terjual='$terjualakhir', sisa='$sisaakhir' where kode='$kode'";
   $updatestok = mysqli_query($conn, $sql3);

 $sqa=mysqli_fetch_assoc(mysqli_query($conn,"SELECT total,potongan,biaya,diskon FROM sale WHERE nota='$nota'"));
  $oldsub=$sqa['total']+$sqa['potongan']-$sqa['biaya'];
  $newsub=$oldsub-$sub;
  $newsub2=$newsub-(($newsub*$sqa['diskon'])/100);
  $newtot=$newsub2 + $sqa['biaya'];

 $up=mysqli_query($conn,"UPDATE sale SET total='$newtot' WHERE nota='$nota'"); 



$sqq=mysqli_query($conn,"SELECT * FROM invoicejual WHERE nota='$nota'");

   if(mysqli_num_rows($sqq)<=1){

$del=mysqli_query($conn,"DELETE FROM sale WHERE nota='$nota'");
$del2=mysqli_query($conn,"DELETE FROM payment WHERE tipe='2' AND nota='$nota'");
$cek=1;
}


}

 $sql = "delete from $forward where no='".$no."'";
 if (mysqli_query($conn, $sql)) {
    if($cek==1){

      if($jenis=='1'){

      echo "<script type='text/javascript'>window.location = '$baseurl/pembelian';</script>";

    } else {
       echo "<script type='text/javascript'>window.location = '$baseurl/penjualan';</script>";
    }

    } else {
         echo "<script type='text/javascript'>window.location = '$baseurl/$forwardpage?q=$nota';</script>";

    }


?>



<?php
 } else{
 ?>   <body onload="setTimeout(function() { document.frm1.submit() }, 10)">
   <input type="hidden" name="kode" value="<?php echo $kode;?>" />
	  <input type="hidden" name="hapusberhasil" value="2" />
 <?php
 }


}else{

 ?>
  <body onload="setTimeout(function() { document.frm1.submit() }, 10)">
   <form action="<?php echo $baseurl; ?>/<?php echo $forwardpage;?>" name="frm1" method="post">

<input type="hidden" name="kode" value="<?php echo $kode;?>" />
	  <input type="hidden" name="hapusberhasil" value="2" />
 <?php
 }
?>
<table width="100%" align="center" cellspacing="0">
  <tr>
    <td height="500px" align="center" valign="middle"><img src="../../dist/img/load.gif">
  </tr>
</table>


   </form>
<meta http-equiv="refresh" content="10;url=jump?kode=<?php echo $kode.'&';?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo $forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>">
</body>
