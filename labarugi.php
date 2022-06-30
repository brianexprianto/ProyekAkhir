<!DOCTYPE html>
<html>

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_etc.php";
include "configuration/config_include.php";
etc();session();connect();
?>



<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
</head>

<!--SETTING-->



<?php


date_default_timezone_set("Asia/Jakarta");
$now=date('d-m-Y');


$dari =$_GET["dari"];
$sampai = $_GET["sampai"];


        $sql1="SELECT * FROM data";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $nama=$row['nama'];
        $logo=$row['avatar'];

$sqlx="SELECT SUM(total) AS retail FROM bayar WHERE tglbayar BETWEEN '" . $dari . "' AND  '" . $sampai . "' ";
$hasilx=mysqli_query($conn,$sqlx);
$row=mysqli_fetch_assoc($hasilx);
$retail=$row['retail'];


$sqlx1="SELECT SUM(total) AS unpaid FROM sale WHERE status LIKE '%dibayar%' AND tglsale BETWEEN '" . $dari . "' AND  '" . $sampai . "' ";
$hasilx1=mysqli_query($conn,$sqlx1);
$row=mysqli_fetch_assoc($hasilx1);
$salespaid=$row['unpaid'];

$sqlx1="SELECT SUM(total) AS sales FROM sale WHERE tglsale BETWEEN '" . $dari . "' AND  '" . $sampai . "' ";
$hasilx1=mysqli_query($conn,$sqlx1);
$row=mysqli_fetch_assoc($hasilx1);
$totalsales=$row['sales'];
$salesunpaid = $totalsales - $salespaid;


$pemasukan= $retail + $totalsales + 0;

$sqlx="SELECT SUM(keluar) AS retailcost FROM bayar WHERE tglbayar BETWEEN '" . $dari . "' AND  '" . $sampai . "' ";
$hasilx=mysqli_query($conn,$sqlx);
$row=mysqli_fetch_assoc($hasilx);
$retailcost=$row['retailcost'];

$sqlx="SELECT SUM(modalbeli) AS salescost FROM sale WHERE tglsale BETWEEN '" . $dari . "' AND  '" . $sampai . "' ";
$hasilx=mysqli_query($conn,$sqlx);
$row=mysqli_fetch_assoc($hasilx);
$salescost=$row['salescost'];

$biaya = $retailcost + $salescost + 0;


$sqlx="SELECT SUM(biaya) AS cost FROM operasional WHERE tanggal BETWEEN '" . $dari . "' AND  '" . $sampai . "' ";
$hasilx=mysqli_query($conn,$sqlx);
$row=mysqli_fetch_assoc($hasilx);
$cost=$row['cost'] + 0;


$net = $pemasukan - $biaya -$cost;
$gross1= $pemasukan -$biaya;
$prctg1 = round((($gross1/$pemasukan)*100),2);
$prctg2 = round((($net/$pemasukan)*100),2);

 $operasional       = mysqli_query($conn, "SELECT tipe,SUM(biaya) as cost FROM operasional WHERE tanggal BETWEEN '" . $dari . "' AND  '" . $sampai . "' GROUP BY tipe order by no asc"); 


if($dari==''){
$newdari ='Awal';
} else {
$newdari = date("d-m-Y", strtotime($dari));
}


$newsampai = date("d-m-Y", strtotime($sampai));


?>



<!--END SETTING-->







<body>



<table>
  
  <tr>
    <td style="text-align:center;width:900px;height:50px;"><h3><?php echo $nama;?></h3></td>
    
    <td rowspan="2" style="width:200px;height:100px;"><img src="<?php echo $logo;?>" style="width:200px;height:100px;"></td>
  </tr>
  <tr>
    <td  style="text-align:center;width:900px;height:50px;">Laporan Laba Rugi Periode: <?php echo $newdari;?> - <?php echo $newsampai;?></td>
    
  </tr>
</table>

<br>

<table>
  
  <tr style="background-color:#8F9899">
    <td style="text-align:center;width:200px;height:40px;">Penjualan</td>
    <td style="text-align:center;width:700px;height:40px;">Detail Penjualan</td>
    <td  style="text-align:center;width:200px;height:40px;">Jumlah (Rp)</td>
    
    
  </tr>
  <tr>
   <td style="text-align:center;width:200px;height:20px;">1</td>
    <td style="width:700px;height:20px;">Retail</td>
    <td  style="text-align:center;width:200px;height:20px;"><?php echo number_format($retail);?></td>
    
  </tr>

   <tr>
   <td style="text-align:center;width:200px;height:20px;">2</td>
    <td style="width:700px;height:20px;">Invoice (belum dibayar)</td>
    <td  style="text-align:center;width:200px;height:20px;"><?php echo number_format($salesunpaid);?></td>
    
  </tr>

   <tr>
   <td style="text-align:center;width:200px;height:20px;">3</td>
    <td style="width:700px;height:20px;">Invoice (Lunas)</td>
    <td  style="text-align:center;width:200px;height:20px;"><?php echo number_format($salespaid);?></td>
    
  </tr>

 <tr>
   <td style="text-align:center;width:200px;height:20px;">Beban Penjualan</td>
    <td style="width:700px;height:20px;">Harga Pokok Penjualan</td>
    <td  style="text-align:center;width:200px;height:20px;"><?php echo number_format($biaya);?></td>
    
  </tr>

  <tr>
   <td colspan="2" style="text-align:center;width:900px;height:40px;"><strong>Total Laba Kotor</strong></td>
   
    <td  style="text-align:center;width:200px;height:40px;"><?php echo number_format($gross1);?></td>
    
  </tr>

</table>

<br>
<br>

<table>
  
  <tr>
    <tr style="background-color:#8F9899">
   <td style="text-align:center;width:200px;height:40px;">Biaya Operasional</td>
    <td style="text-align:center;width:700px;height:40px;">Rincian Operasional</td>
    <td  style="text-align:center;width:200px;height:40px;"></td>
    
  </tr>

<?php 
  
  $no = 0;
  while ($fill = mysqli_fetch_array($operasional)){
?>


  <tr>
   <td style="text-align:center;width:200px;height:20px;"><?php echo ++$no;?></td>
    <td style="width:700px;height:20px;"><?php echo $fill['tipe'];?></td>
    <td  style="text-align:center;width:200px;height:20px;"><?php echo number_format($fill['cost']);?></td>
    
  </tr>


<?php } ?>


  <tr>
   <td colspan="2" style="text-align:center;width:900px;height:40px;"><strong>Total Laba Bersih</strong></td>
    
    <td  style="text-align:center;width:200px;height:40px;"><strong>Rp <?php echo number_format($net);?></strong></td>
    
  </tr>
</table>

<br>
<br>

<table>
  
  <tr>
    <td style="font-weight:bold;text-align:center;width:200px;height:20px;">Diprint oleh</td>
    
    <td  style="text-align:center;width:700px;height:20px;"><?php echo $_SESSION["username"];;?></td>
     <td style="text-align:center;width:200px;height:20px;"><?php echo $now;?></td>
    
    
    
    
  </tr>


</table>

</body>
</html>
