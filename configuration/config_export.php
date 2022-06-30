<?php include 'config_connect.php';
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$search = $_GET['search'];

$forward = $_GET['forward'];
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$forward.xls");

?>
<?php if($forward == 'bayar'){ ?>
      <table class="table">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>No Nota</th>
                                              <th>Tanggal</th>
                                              <th>Jumlah Item</th>
                                              <th>Total Pembayaran</th>
                                              <th>Uang Bayar</th>
                                              <th>Uang Kembali</th>
                                              <th>Cc</th>
                                            </tr>
                                        </thead>
										  <?php
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
					$query1="SELECT * FROM  $forward where nota like '%$search%' or tglbayar like '%$search%' or kasir like '%$search%' order by no ";
				$hasil = mysqli_query($conn,$query1);
				$no = 1;
				while ($fill = mysqli_fetch_assoc($hasil)){
					?>
                     <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['tglbayar']); ?></td>
  <?php
$nota = $fill['nota'];
$sqle="SELECT sum(jumlah) AS data FROM transaksimasuk WHERE nota ='$nota'";

$hasile=mysqli_query($conn,$sqle);
$rowa=mysqli_fetch_assoc($hasile);
$jumlahbayar=$rowa['data'];
   ?>
  <td><?php  echo mysqli_real_escape_string($conn, $jumlahbayar); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['total']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['bayar']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kembali']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
					  </tr><?php
					;
				}
  

				?>

                  </tbody></table>
<?php } ?>


<?php if($forward == 'barang'){ ?>
      <table class="table">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>Kode Barang</th>
                                              <th>Nama Barang</th>
                                              <th>Kategori</th>
                                              <th>Stok Terjual</th>
                                              <th>Stok Terbeli</th>
                                              <th>Stok Tersedia</th>
                                              
                                            </tr>
                                        </thead>
										  <?php
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

  $query1="select * from $forward where kode like '%$search%' or nama like '%$search%' or kategori like '%$search%' order by no";
				$hasil = mysqli_query($conn,$query1);
				$no = 1;
				while ($fill = mysqli_fetch_assoc( $hasil)){
					?>
                     <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kategori']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['terjual']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['terbeli']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['sisa']); ?></td>
  
					  </tr><?php
					;
				}

				?>
                  </tbody></table>
<?php } ?>


<?php if($forward == 'buy'){ ?>
      <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                              <th>No Nota</th>
                                              <th>Tanggal</th>
                                              <th>Jumlah Item</th>
                                              <th>Total Tagihan</th>
                                              <th>Supplier</th>
                                              <th>Status</th>
                                                <th>Diterima</th>
                                              <th>Cc</th>
                                            </tr>
                                        </thead>
										  <?php
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
  $query1="select *, supplier.nama as supplier from buy inner join supplier on supplier.kode = buy.supplier where buy.nota LIKE '%$search%' or buy.tgsale LIKE '%$search%' or buy.supplier LIKE '%$search%' order by buy.no desc";
				$hasil = mysqli_query($conn,$query1);
				$no = 1;
				while ($fill = mysqli_fetch_assoc($hasil)){
					?>
                     <tbody>
    <tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['tglsale']); ?></td>
  <?php
$nota = $fill['nota'];
$sqle="SELECT COUNT( nota ) AS data FROM invoicebeli WHERE nota ='$nota'";
$hasile=mysqli_query($conn,$sqle);
$rowa=mysqli_fetch_assoc($hasile);
$jumlahbeli=$rowa['data'];

$jml= " SELECT SUM(jumlah) tot_beli FROM invoicebeli WHERE nota ='$nota'"  ;
$hasil1=mysqli_query($conn,$jml);
$row1=mysqli_fetch_array($hasil1);
$jmlbeli=$row1['tot_beli'];

   ?>
   
  <td><?php  echo mysqli_real_escape_string($conn, $jmlbeli); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['total']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['supplier']); ?></td>
   <td><?php  echo mysqli_real_escape_string($conn, $fill['status']); ?></td>
    <td><?php  echo mysqli_real_escape_string($conn, $fill['diterima']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
 </tr><?php
					;
				}

				?>
                  </tbody></table>
<?php } ?>


<?php if($forward == 'revenue'){

  $forward = 'bayar';
  $bulan = $_GET['bulan'];
  $tahun = $_GET['tahun'];

  ?>

      <table class="table">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>No Nota</th>
                                              <th>Tanggal</th>
                                              <th>Jumlah Item</th>
                                              <th>Total Pembayaran</th>
                                              <th>Uang Bayar</th>
                                              <th>Uang Kembali</th>
                                              <th>Cc</th>
                                            </tr>
                                        </thead>
										  <?php
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if($tahun == null || $tahun == ""){
  $query1="SELECT * FROM  $forward where nota IN (SELECT nota FROM transaksimasuk) order by no ";
}else{
  $query1="SELECT * FROM  $forward where nota IN (SELECT nota FROM transaksimasuk) and tglbayar like '$tahun-$bulan-%' order by no ";
}
				$hasil = mysqli_query($conn,$query1);
				$no = 1;
				while ($fill = mysqli_fetch_assoc($hasil)){
					?>
                     <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn , $fill['nota']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn , $fill['tglbayar']); ?></td>
  <?php
$nota = $fill['nota'];
$sqle="SELECT COUNT( nota ) AS data FROM transaksimasuk WHERE nota ='$nota'";
$hasile=mysqli_query($conn,$sqle);
$rowa=mysqli_fetch_assoc($hasile);
$jumlahbayar=$rowa['data'];
   ?>
  <td><?php  echo mysqli_real_escape_string($conn, $jumlahbayar); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['total']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['bayar']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kembali']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
  <td>
					  </tr><?php
					;
				}

				?>
                  </tbody></table>
<?php } ?>


<?php if($forward == 'income'){

  $forward = 'bayar';
  $bulan = $_GET['bulan'];
  $tahun = $_GET['tahun'];

  ?>

      <table class="table">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>No Nota</th>
                                              <th>Tanggal</th>
                                              <th>Jumlah Item</th>
                                              <th>Total Masuk</th>
                                              <th>Total Keluar</th>
                                              <th>Income</th>
                                              <th>Cc</th>
                                            </tr>
                                        </thead>
										  <?php
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if($tahun == null || $tahun == ""){
  $query1="SELECT * FROM  $forward where nota IN (SELECT nota FROM transaksimasuk) order by no ";
}else{
  $query1="SELECT * FROM  $forward where nota IN (SELECT nota FROM transaksimasuk) and tglbayar like '$tahun-$bulan-%' order by no ";
}
				$hasil = mysqli_query($conn,$query1);
				$no = 1;
				while ($fill = mysqli_fetch_assoc($hasil)){
					?>
                     <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['tglbayar']); ?></td>
  <?php
$nota = $fill['nota'];
$sqle="SELECT COUNT( nota ) AS data FROM transaksimasuk WHERE nota ='$nota'";
$hasile=mysqli_query($conn,$sqle);
$rowa=mysqli_fetch_assoc($hasile);
$jumlahbayar=$rowa['data'];
   ?>
  <td><?php  echo mysqli_real_escape_string($conn, $jumlahbayar); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['total']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['keluar']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['total']-$fill['keluar']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
  <td>
					  </tr><?php
					;
				}

				?>
                  </tbody></table>
<?php } ?>


<?php if($forward == 'operasional'){ ?>

      <table class="table">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>Kode</th>
                                              <th>Nama</th>
                                              <th>Tanggal</th>
                                              <th>Biaya</th>
                                              <th>Keterangan</th>
                                              <th>Cc</th>
                                            </tr>
                                        </thead>
										  <?php
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if($tahun == null || $tahun == ""){
  $query1="SELECT * FROM  $forward order by no ";
}else{
  $query1="SELECT * FROM  $forward where tanggal like '$tahun-$bulan-%' order by no ";
}
				$hasil = mysqli_query($conn,$query1);
				$no = 1;
				while ($fill = mysqli_fetch_assoc($hasil)){
					?>
                     <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['tanggal']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['biaya'])); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['keterangan']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
					  </tr><?php
					;
				}

				?>
                  </tbody></table>
<?php } ?>



<?php if($forward == 'sale'){ 

$tahun = $_GET['tahun'];
$bulan = $_GET['bulan'];
  ?>



      <table class="table">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>Nota</th>
                                              <th>Tanggal</th>
                                              <th>Total</th>
                                              <th>Diskon</th>
                                              <th>Pembeli</th>
                                              <th>Cc</th>
                                            </tr>
                                        </thead>
                      <?php
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if($tahun == null || $tahun == ""){
  $query1="SELECT * FROM  $forward order by no ";
}else{
  $query1="SELECT * FROM  $forward where YEAR(tglsale) like '%$tahun%' AND MONTH(tglsale) like '%$bulan%' order by no ";
}
        $hasil = mysqli_query($conn,$query1);
        $no = 1;
        while ($fill = mysqli_fetch_assoc($hasil)){
          ?>
                     <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['tglsale']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['total'])); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['diskon'])); ?></td>
  <td><?php  $pgn = $fill['pelanggan'];
  $sql = "SELECT nama FROM pelanggan where kode='$pgn'";
  $r =mysqli_fetch_assoc(mysqli_query($conn, $sql));
  echo mysqli_real_escape_string($conn, $r['nama']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
            </tr><?php
          ;
        }

        ?>
                  </tbody></table>
<?php } ?>