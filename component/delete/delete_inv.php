<?php
include "../../configuration/config_connect.php";
include "../../configuration/config_session.php";
include "../../configuration/config_chmod.php";
include "../../configuration/config_etc.php";
$forward =$_GET['forward'];
$tabel =$_GET['tabel'];
$nota = $_GET['nota'];
$chmod = $_GET['chmod'];
$forwardpage = $_GET['forwardpage'];
$tipe=$_GET['tipe'];
?>

<?php
if( $chmod == '4' || $chmod == '5' || $_SESSION['jabatan'] =='admin' || $_SESSION['jabatan'] == 'guru'){

 $sql = "delete from $forward where nota='".$nota."'";
 if (mysqli_query($conn, $sql)) {

$sql2="DELETE FROM $tabel WHERE nota='".$nota."'";
  $del=mysqli_query($conn,$sql2);


if($tipe=='1'){
$del=mysqli_query($conn,"DELETE FROM hutang WHERE nota='$nota'");

$del1=mysqli_query($conn,"DELETE FROM payment WHERE tipe='1' AND nota='$nota'");
} else {


$del1=mysqli_query($conn,"DELETE FROM payment WHERE tipe='2' AND nota='$nota'");
}


 ?>

  <body onload="setTimeout(function() { document.frm1.submit() }, 10)">
  <form action="<?php echo $baseurl; ?>/<?php echo $forwardpage;?>" name="frm1" method="post">

  <input type="hidden" name="hapusberhasil" value="1" />

<?php
 } else{
 ?>   <body onload="setTimeout(function() { document.frm1.submit() }, 10)">
    <input type="hidden" name="hapusberhasil" value="2" />
 <?php
 }
}
else{

 ?>
  <body onload="setTimeout(function() { document.frm1.submit() }, 10)">
   <form action="<?php echo $baseurl; ?>/<?php echo $forwardpage;?>" name="frm1" method="post">


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
<meta http-equiv="refresh" content="10;url=jump?forward=<?php echo $forward.'&';?>forwardpage=<?php echo $forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>">
</body>
