
<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$tipe=$_GET['tipe'];
$nota = $_GET["nota"];

include "configuration/config_connect.php";
$halaman = "faktur_one"; // halaman
$dataapa = "Faktur"; // data

if($tipe=='quotation'){
$tabel = "quotation"; // tabel database
$tabeldatabase = "quotation_list"; // tabel database
$judul="Penawaran";

      $sql1="SELECT * FROM $tabel where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        
        $nomor=$row['nomor'];
        $due=$row['due'];
        $bayar=$row['oleh'];
        $biaya=$row['biayatambahan'];
        $total=$row['total'];
        $status=$row['status'];
         $tgl=$row['tgl'];
        $pelanggan=$row['pelanggan'];
        $diskon=$row['diskon'];
        $pot=$row['potongan'];
         $keterangan=$row['keterangan'];
        $batas="Berlaku Sampai*";
} else {

$tabel = "sale"; // tabel database
$tabeldatabase = "invoicejual"; // tabel database
$judul="Invoice";

  $sql1="SELECT * FROM $tabel where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        
        $nomor=$row['nomor'];
        $due=$row['duedate'];
        $bayar=$row['kasir'];
        $biaya=$row['biaya'];
        $total=$row['total'];
        $status=$row['status'];
         $tgl=$row['tglsale'];
        $pelanggan=$row['pelanggan'];
        $diskon=$row['diskon'];
        $pot=$row['potongan'];
         $keterangan=$row['keterangan'];
        $batas="Jatuh Tempo";
}


$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman


date_default_timezone_set("Asia/Jakarta");
$today = date('d-m-Y');
 
?>

<?php
        $decimal ="0";
        $a_decimal =",";
        $thousand =".";
        ?>
<?php
        $sql1="SELECT * FROM data";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $nama=$row['nama'];
        $alamat=$row['alamat'];
        $notelp=$row['notelp'];
        $tagline=$row['tagline'];
        $signature=$row['signature'];
        $avatar=$row['avatar'];

        $sql1="SELECT * FROM pelanggan where kode='$pelanggan' ";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $customer=$row['nama'];
        $nohp=$row['nohp'];
        $address=$row['alamat'];


?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		 <title> <?php echo $judul;?></title>
		  <link rel="stylesheet" href="dist/css/AdminLTE.min.css"> 
		  	<link rel="stylesheet" href="dist/ico/font-awesome/css/font-awesome.min.css">
		<!-- Invoice styling -->
			<link rel="stylesheet" href="libs/faktur/three/style.css"  />
	</head>



<style>
@media print {
  #printPageButton {
    display: none;
  }
}
</style>

	<body>
		
		<div class="invoice-box">
			<table>
				<tr class="top">
					<td colspan="4">
						<table>
							<tr>
								<td class="title">
			<img src="<?php echo $avatar;?>" alt="<?php echo $nama;?>" style="width: 100%; max-width: 90px;height:90px;" />
								</td>

								<td>
									<?php echo $judul;?> <?php echo $nota;?><br />
									Tanggal <?php echo date('d-m-Y',strtotime($tgl));?><br />
								
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="4">
						<table>
							<tr>
								<td style="max-width: 60px">
									  <?php echo $nama;?><br />
									
									<?php echo $notelp;?>
								</td>

								<td style="max-width: 60px">
									<?php echo $customer;?><br />
									<?php echo $address;?><br />
									<?php echo $nohp;?>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				

				

				<tr class="heading">
					
					<td style="text-align:left">PRODUK</td>
					<td>Harga Satuan</td>
					<td style="text-align:center">Jumlah</td>
					<td style="text-align:right">Subtotal</td>
				</tr>

<?php
 $sql    = "select * from $tabeldatabase where nota ='$nota' order by no";
   $result = mysqli_query($conn, $sql);
   $no_urut=0;
   while ($fill=mysqli_fetch_assoc($result)){
?>
				<tr class="item">
					
					
					<td style="text-align:left"><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
					<td><?php  echo mysqli_real_escape_string($conn, number_format($fill['harga'], $decimal, $a_decimal, $thousand).',-'); ?></td>
					<td style="text-align:center"><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
					<td style="text-align:right"><?php  echo mysqli_real_escape_string($conn, number_format(($fill['jumlah']*$fill['harga']), $decimal, $a_decimal, $thousand).',-'); ?></td>
				</tr>
<?php } ?>
		

				
				<tr class="total">
					<td></td>
					<td style="text-align:right">Diskon <?php echo $diskon;?>%:</td>
					
					<td colspan="2" style="text-align:right"><?php echo number_format($pot, $decimal, $a_decimal, $thousand).',-';?></td>			
				</tr>

				<tr class="total">
					<td></td>
					<td style="text-align:right">Biaya Tambahan:</td>
					
					<td colspan="2" style="text-align:right"><?php echo number_format($biaya, $decimal, $a_decimal, $thousand).',-';?></td>			
				</tr>

				<tr class="total">

					<?php if($tipe=='quotation'){?>

							<td><b>Berlaku sampai <?php echo date('d-m-Y',strtotime($due));?></b></td>

					<?php } else {?>

					 <?php if ($status=='sudah'){?>
		
					<td><b>LUNAS</b></td>
				<?php } else {?>
					<td>Pembayaran</td>
				<?php } ?>

			<?php } ?>
					
					<td style="text-align:right"><b>Grand Total:</b></td>
									
					<td colspan="2" style="text-align:right"><b>Rp <?php echo number_format($total, $decimal, $a_decimal, $thousand).',-';?></b></td>
				</tr>

<?php if($tipe=='quotation'){?>

	<tr>
		<td colspan="3"><p  style="max-width:40%;word-wrap: break-word"><small><?php echo $keterangan;?></small></p></td>
	</tr>

<?php } else {?>
				 <?php if ($status!='sudah'){?>

				 <?php 
          $query1="SELECT * FROM  rekening order by no ";
               $hasil = mysqli_query($conn,$query1);
          while ($fill = mysqli_fetch_assoc($hasil)){
            ?>

				<tr class="item">
					
					<td><strong><?php echo $fill['bank'];?>:</strong>  <?php echo $fill['norek'];?> A.n <?php echo $fill['nama'];?></td>
					
				</tr>
<?php } ?>



<?php } ?>
<?php } ?>



				
			</table>
<button id="printPageButton" class="btn btn-lg bg-maroon" onClick="window.print()"><i class="fa fa-print"></i> Print</button>			
		</div>
		

	</body>
</html>

