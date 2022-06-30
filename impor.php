<!DOCTYPE html>
<html>
<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
etc();encryption();session();connect();head();body();timing();
//alltotal();
pagination();
?>

<?php
if (!login_check()) {
?>
<meta http-equiv="refresh" content="0; url=logout" />
<?php
exit(0);
}
?>
        <div class="wrapper">
<?php
theader();
menu();
?>
            <div class="content-wrapper">
                <section class="content-header">
</section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
            <div class="col-lg-12">
                        <!-- ./col -->

<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "barang"; // halaman
$dataapa = "Barang"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu4; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
$insert = $_POST['insert'];

 
?>


<!-- SETTING STOP -->


<!-- BREADCRUMB -->

<ol class="breadcrumb ">
<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
<li><a href="<?php echo $halaman;?>"><?php echo $dataapa ?></a></li>
<?php

if ($search != null || $search != "") {
?>
 <li> <a href="<?php echo $halaman;?>">Data <?php echo $dataapa ?></a></li>
  <li class="active"><?php
    echo $search;
?></li>
  <?php
} else {
?>
 <li class="active">Data <?php echo $dataapa ?></li>
  <?php
}
?>
</ol>

<!-- BREADCRUMB -->

<!-- BOX INSERT BERHASIL -->

         <script>
 window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 5000);
</script>


       <!-- BOX INFORMASI -->
    <?php
if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
  ?>


  <!-- KONTEN BODY AWAL -->
                         <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Modul Import Barang</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          





              
        <!-- Content -->
        <div style="padding: 0 15px;">
            <?php 

            $cek=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(kode) as cnt FROM barang"));
              
              if($cek['cnt']<=0){?>
                 <h4>Hanya Import File dengan Format CSV"</h4>
                 <br> 
             <button type="button" class="btn btn-success" onclick="window.location.href='impor_form'">IMPORT DATA PRODUK</button>
          <?php } else {?>
              <h4>Anda tidak bisa import data karena data produk sudah ada, Klik "Reset Produk"</h4> 
              <br><form method="post">
                  <button type="button" class="btn bg-maroon" data-toggle="modal" data-target="#transaksi">RESET PRODUK</button>
               
             </form>
          <?php } ?>

            
            <hr>
            
            <!-- Buat sebuah div dan beri class table-responsive agar tabel jadi responsive -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>no</th>
                        <th>Kode</th>
                        <th>SKU</th>
                        <th>Nama</th>
                        <th>Hbeli</th>
                        <th>Hjual</th>
                        <th>keterangan</th>
                        <th>kategori</th>
                        <th>Stok Minimal</th>
                         <th>sisa</th>
                          <th>terbeli</th>
                        <th>terjual</th>
                                        
                       
                        <th>barcode</th>
                        <th>brand</th>
                       

                    </tr>
                    <?php
                    // Load file koneksi.php
                    include "configuration/config_connect.php";
                    
                    // Buat query untuk menampilkan semua data siswa
                    $sql = mysqli_query($conn, "SELECT * FROM barang order by no");
    
                    $no = 1; // Untuk penomoran tabel, di awal set dengan 1
                    while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
                        echo "<tr>";
                       
                            echo "<td>".$data['no']."</td>";
                        echo "<td>".$data['kode']."</td>";
                         echo "<td>".$data['sku']."</td>";
                        echo "<td>".$data['nama']."</td>";
                        echo "<td>".$data['hargabeli']."</td>";
                        echo "<td>".$data['hargajual']."</td>";
                        echo "<td>".$data['keterangan']."</td>";
                        echo "<td>".$data['kategori']."</td>";
                         echo "<td>".$data['stokmin']."</td>";
                        echo "<td>".$data['sisa']."</td>";
                        echo "<td>".$data['terbeli']."</td>";
                        echo "<td>".$data['terjual']."</td>";
                    
                        echo "<td>".$data['barcode']."</td>";
                        echo "<td>".$data['brand']."</td>";
                       
                        echo "</tr>";
                        
                        $no++; // Tambah 1 setiap kali looping
                    }
                    ?>
                </table>
            </div>
        </div>
   





        </div>

                                <!-- /.box-body -->
                            </div>

                             <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Petunjuk Import CSV</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          
          <p>1.Ada 12 kolom CSV yang wajib di isi semua</p><br>
          <p>2.Kolom "Kode" Wajib di isi dengan format angka naik: 0001, 0002 dst hingga 0500</p><br>
          <p>3.Kolom "no" Wajib di isi dengan angka naik, dimulai dr 1 sampai 500, tidak boleh ada baris dg angka yg sama</p><br>
            <p>4.Kolom "avatar" di isi dengan path/direktori file, pertama copy dulu file gambar ke folder upload yang ada di aplikasi lalu tuliskan pathnya, misalkan nama file "gambar1" dengan format "jpg", maka ditulis "dist/upload/gambar1.jpg", atau bisa isi dengan "dist/upload/index.jpg untuk semua baris" </p><br>
            <p>5.bila ingin hemat waktu maka tidak perlu masukan gambar dulu, anda bisa isikan "dist/upload/index.jpg" pada semua baris, nantinya bisa di edit lagi setelah upload</p><br>

            <p>6.Kolom "sisa" adalah hasil pengurangan kolom "terbeli" dikurangi kolom "terjual"</p><br>
            <p>7.Lama Proses upload sangat bergantung pada kecepatan server hosting dan hasilnya berbeda tiap hosting dan layanan</p><br>
            <p>8.Untuk instalasi di hosting, kami sarankan coba upload 100 produk dulu, lalu naik 150,200 dst sampai ketika proses terasa mulai melambat berarti itulah batasdari kapasitas hosting anda, jangan dipaksakan karena bisa menyebabkan error, pada localhost (offline) anda bisa coba langsung upload 500 produk</p><br>
            
            <p>9.<strong>Sebelum melakukan import kami sarankan mulai dari kondisi data barang kosong, jika ada barang maka pastikan kolom "kode" dan "no" dimulai dari kode dan no terbesar.Misalkan sudah ada barang dengan kode 0105 dan no 105 di database aplikasi, maka di csv mulailah dari kode 0106 dan no 106</strong></p><br>

            <a href="tmp/contohup.csv" class="btn btn-default">
                    <span class="glyphicon glyphicon-download"></span>
                    Download Contoh CSV
                </a>
        </div>

                                <!-- /.box-body -->
                            </div>
                        </div>

                        
<?php
} else {
?>
   <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa;?> ini .</b>
    </div>
    <?php
}
?>

 <?php 

 if(isset($_POST["reset"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

$user = $_SESSION['username'];

$sql = "SELECT userna_me FROM user where userna_me = '$user' ";

$result=mysqli_query($conn,$sql);

                  if(mysqli_num_rows($result)>0){

$trun1 = mysqli_query($conn, 'TRUNCATE TABLE barang ');
$trun2 = mysqli_query($conn, 'TRUNCATE TABLE beli ');
$trun3 = mysqli_query($conn, 'TRUNCATE TABLE bayar ');
$trun4 = mysqli_query($conn, 'TRUNCATE TABLE transaksibeli ');
$trun5 = mysqli_query($conn, 'TRUNCATE TABLE transaksimasuk ');
$trun6 = mysqli_query($conn, 'TRUNCATE TABLE sale ');
$trun7 = mysqli_query($conn, 'TRUNCATE TABLE invoicejual ');
$trun8 = mysqli_query($conn, 'TRUNCATE TABLE buy ');
$trun9 = mysqli_query($conn, 'TRUNCATE TABLE invoicebeli ');
$trun10 = mysqli_query($conn, 'TRUNCATE TABLE dataretur ');
$trun11 = mysqli_query($conn, 'TRUNCATE TABLE stokretur ');
$trun12 = mysqli_query($conn, 'TRUNCATE TABLE payment ');
$trun13 = mysqli_query($conn, 'TRUNCATE TABLE mutasi ');
$trun14 = mysqli_query($conn, 'TRUNCATE TABLE hutang ');
$trun15 = mysqli_query($conn, 'TRUNCATE TABLE stok_keluar ');
$trun16 = mysqli_query($conn, 'TRUNCATE TABLE stok_keluar_daftar ');
$trun17 = mysqli_query($conn, 'TRUNCATE TABLE stok_masuk ');
$trun18 = mysqli_query($conn, 'TRUNCATE TABLE stok_masuk_daftar ');
$trun19 = mysqli_query($conn, 'TRUNCATE TABLE retur ');
if ($trun19){
   echo "<script type='text/javascript'>  alert('Berhasil, Data produk telah direset permanen!'); </script>";
              echo "<script type='text/javascript'>window.location = 'impor';</script>";
   

} else {  echo "<script type='text/javascript'>  alert('GAGAL, Data produk gagal di reset seluruhnya. Terjadi kesalahan dalam proses reset. Ulangi lagi dan pastikan internet anda stabil');</script>";}

                    } else {
                        echo "<script type='text/javascript'>  alert('GAGAL, Data telah di RESET Sebelumnya dan belum ada perubahaan sejak itu!'); </script>";
              echo "<script type='text/javascript'>window.location = 'impor';</script>";
                    }
} }


?>



<!-- Modal -->
<div id="transaksi" class="modal fade" role="dialog">
  <div class="modal-dialog">
<form method="post" action="">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">RESET DATA PRODUK</h4>
      </div>
      <div class="modal-body">
        <p><b>Anda yakin mau reset data produk?</b></p><br>
        <p>Tindakan ini permanen dan akan menghapus semua seluruh data produk termasuk data penjualan dan pembelian</p>
      </div>
      <div class="modal-footer">
         <button name="reset" type="submit" class="btn bg-maroon pull-left" >YA, Hapus Semua Produk</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
      </div>
    </div>
</form>
  </div>
</div>
                        <!-- ./col -->
                    </div>

                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <!-- /.Left col -->
                    </div>
                    <!-- /.row (main row) -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php  footer(); ?>
            <div class="control-sidebar-bg"></div>
        </div>
          <!-- ./wrapper -->

<!-- Script -->
    <script src='jquery-3.1.1.min.js' type='text/javascript'></script>

    <!-- jQuery UI -->
    <link href='jquery-ui.min.css' rel='stylesheet' type='text/css'>
    <script src='jquery-ui.min.js' type='text/javascript'></script>

<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="dist/plugins/jQuery/jquery-ui.min.js"></script>

        <script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
        <script src="dist/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="dist/plugins/morris/morris.min.js"></script>
        <script src="dist/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script src="dist/plugins/knob/jquery.knob.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="dist/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="dist/plugins/datepicker/bootstrap-datepicker.js"></script>
        <script src="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="dist/plugins/fastclick/fastclick.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="dist/js/demo.js"></script>
    <script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="dist/plugins/fastclick/fastclick.js"></script>
    <script src="dist/plugins/select2/select2.full.min.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="dist/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="dist/plugins/iCheck/icheck.min.js"></script>

<!--fungsi AUTO Complete-->

</body>
</html>
