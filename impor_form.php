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

<script>
        $(document).ready(function(){
            // Sembunyikan alert validasi kosong
            $("#kosong").hide();
        });
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
          





              
        <body>
        <!--
        -- START HEADER
        -- Membuat Menu Header / Navbar
        -- Hapus saja jika tidak diperlukan
        -->
        

        <!-- Content -->
       <div style="padding: 0 15px;">
            <!-- Buat sebuah tombol Cancel untuk kemabli ke halaman awal / view data -->
            <a href="import.php" class="btn btn-danger pull-right">
                <span class="glyphicon glyphicon-remove"></span> Cancel
            </a>

            <h3>Form Import Data</h3>
            <hr>

            <!-- Buat sebuah tag form dan arahkan action nya ke file ini lagi -->
            <form method="post" action="" enctype="multipart/form-data">
                <a href="tmp/format_upload_produk.csv" class="btn btn-default">
                    <span class="glyphicon glyphicon-download"></span>
                    Download Format
                </a><br><br>

                <!--
                -- Buat sebuah input type file
                -- class pull-left berfungsi agar file input berada di sebelah kiri
                -->
                <input type="file" name="file" class="pull-left">

                <button type="submit" name="preview" class="btn btn-success btn-sm">
                    <span class="glyphicon glyphicon-eye-open"></span> Preview
                </button>
            </form>

            <hr>
          
            <!-- Buat Preview Data -->
            <?php
            // Jika user telah mengklik tombol Preview
            if(isset($_POST['preview'])){
                $nama_file_baru = 'data.csv';

                // Cek apakah terdapat file data.xlsx pada folder tmp
                if(is_file('tmp/'.$nama_file_baru)) // Jika file tersebut ada
                    unlink('tmp/'.$nama_file_baru); // Hapus file tersebut

                $nama_file = $_FILES['file']['name']; // Ambil nama file yang akan diupload
                $tmp_file = $_FILES['file']['tmp_name'];
                $ext = pathinfo($nama_file, PATHINFO_EXTENSION); // Ambil ekstensi file yang akan diupload

                // Cek apakah file yang diupload adalah file CSV
                if($ext == "csv"){
                    // Upload file yang dipilih ke folder tmp
                    move_uploaded_file($tmp_file, 'tmp/'.$nama_file_baru);

                    // Load librari PHPExcel nya
                    require_once 'PHPExcel/PHPExcel.php';

                    $inputFileType = 'CSV';
                    $inputFileName = 'tmp/data.csv';

                    $reader = PHPExcel_IOFactory::createReader($inputFileType);
                    $excel = $reader->load($inputFileName);

                    // Buat sebuah tag form untuk proses import data ke database
                    echo "<form method='post' action='act_import.php'>";

                    // Buat sebuah div untuk alert validasi kosong
                    echo "<div class='alert alert-danger' id='kosong'>
                    Kemungkinan ada data belum diisi, Periksa kembali, jika sudah OK klik 'Import' di Pojok Kiri Bawah.
                    </div>";

                    echo "<table class='table table-bordered'>
                    <tr>
                        <th colspan='5' class='text-center'>Preview Data</th>
                    </tr>
                    <tr>
                       <th>no</th>
                        <th>Kode</th>
                        <th>SKU</th>
                        <th>Nama</th>
                        <th>Hbeli</th>
                        <th>Hjual</th>
                      
                        <th>kategori</th>
                         <th>brand</th>
                        <th>Stok Minimal</th>
                         <th>sisa</th>
                          <th>terbeli</th>
                        <th>terjual</th>
                                        
                       
                        <th>barcode</th>
                       
                         <th>keterangan</th>
                       
                    </tr>";

                    $numrow = 1;
                    $kosong = 0;
                    $worksheet = $excel->getActiveSheet();
                    foreach ($worksheet->getRowIterator() as $row) { // Lakukan perulangan dari data yang ada di csv
                        // Cek $numrow apakah lebih dari 1
                        // Artinya karena baris pertama adalah nama-nama kolom
                        // Jadi dilewat saja, tidak usah diimport
                        if($numrow > 1){
                            // START -->
                            // Skrip untuk mengambil value nya
                            $cellIterator = $row->getCellIterator();
                            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set

                            $get = array(); // Valuenya akan di simpan kedalam array,dimulai dari index ke 0
                            foreach ($cellIterator as $cell) {
                                array_push($get, $cell->getValue()); // Menambahkan value ke variabel array $get
                            }
                            // <-- END

                            // Ambil data value yang telah di ambil dan dimasukkan ke variabel $get
                            $no = $get[0]; // Ambil data kode
                             $kode = sprintf("%06s", $no);
                            $sku = $get[1]; // Ambil data nama
                            $nama = $get[2]; // Ambil data hbeli
                            $hbeli = $get[3]; // Ambil data hjual
                            $hjual = $get[4]; // Ambil data alamat
                            $kategori = $get[5]; // Ambil data NIS
                            $brand = $get[6]; // Ambil data nama
                            $ukuran = $get[7]; // Ambil data jenis kelamin
                            $warna = $get[8]; // Ambil data telepon
                           
                            $exp = $get[9]; // Ambil data NIS
                            $lokasi= $get[10]; // Ambil data nama
                           
                            $stokmin = $get[11];
                             $sisa = $get[12];
                              $terbeli = $get[13];
                               $terjual = $get[14];
                                $barcode = $get[15];
                                 $keterangan = $get[16];
                         
                            

                            // Cek jika semua data tidak diisi
                            if($sku == "" && $nama == "" && $hbeli == "" && $hjual == "" && $kategori == "" && $sisa == "" && $no == "" )
                                continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                            // Validasi apakah semua data telah diisi
                             $no_td = ( ! empty($no))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                              $sku_td = ( ! empty($sku))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $nama_td = ( ! empty($nama))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                            $hbeli_td = ( ! empty($hbeli))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                            $hjual_td = ( ! empty($hjual))? "" : " style='background: #E07171;'"; // Jika Telepon kosong, beri warna merah
                            $keterangan_td = ( ! empty($keterangan))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $kategori_td = ( ! empty($kategori))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $terjual_td = ( ! empty($terjual))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $terbeli_td = ( ! empty($terbeli))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $sisa_td = ( ! empty($sisa))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $stokmin_td = ( ! empty($stokmin))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $ukuran_td = ( ! empty($ukuran))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                           $warna_td = ( ! empty($warna))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                           $exp_td = ( ! empty($exp))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                           $lokasi_td = ( ! empty($lokasi))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $barcode_td = ( ! empty($barcode))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $brand_td = ( ! empty($brand))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                         

                            // Jika salah satu data ada yang kosong
                            if($sku == "" or $nama == "" or $hbeli == "" or $hjual == "" or $no == "" ){
                                $kosong++; // Tambah 1 variabel $kosong
                            }

                            echo "<tr>";
                              echo "<td".$no_td.">".$no."</td>";
                            echo "<td".$kode_td.">".$kode."</td>";
                            echo "<td".$sku_td.">".$sku."</td>";
                            echo "<td".$nama_td.">".$nama."</td>";
                            echo "<td".$hbeli_td.">".$hbeli."</td>";
                            echo "<td".$hjual_td.">".$hjual."</td>";
                           
                            echo "<td".$kategori_td.">".$kategori."</td>";
                             echo "<td".$brand_td.">".$brand."</td>";
                              echo "<td".$stokmin_td.">".$stokmin."</td>";
                                echo "<td".$sisa_td.">".$sisa."</td>";
                            echo "<td".$terjual_td.">".$terjual."</td>";
                            echo "<td".$terbeli_td.">".$terbeli."</td>";
                          
                           
                            echo "<td".$barcode_td.">".$barcode."</td>";
                          
                             echo "<td".$keterangan_td.">".$keterangan."</td>";
                         
                            echo "</tr>";
                        }

                        $numrow++; // Tambah 1 setiap kali looping
                    }

                    echo "</table>";

                    // Cek apakah variabel kosong lebih dari 1
                    // Jika lebih dari 1, berarti ada data yang masih kosong
                    if($kosong > 1){
                    ?>
                        <script>
                        $(document).ready(function(){
                            // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
                            $("#jumlah_kosong").html('<?php echo $kosong; ?>');

                            $("#kosong").show(); // Munculkan alert validasi kosong
                        });
                        </script>
                    <?php
                    }else{ // Jika semua data sudah diisi
                        echo "<hr>";

                        // Buat sebuah tombol untuk mengimport data ke database
                        echo "<button type='submit' name='import' class='btn btn-primary'><span class='glyphicon glyphicon-upload'></span> Import</button>";
                    }

                    echo "</form>";
                }else{ // Jika file yang diupload bukan File CSV
                    // Munculkan pesan validasi
                    echo "<div class='alert alert-danger'>
                    Hanya File CSV (.csv) yang diperbolehkan
                    </div>";
                }
            }
            ?>
        </div>
    </body>
   





        </div>

                                <!-- /.box-body -->
                            </div>


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


            <div class="col-lg-8">
          <p>1.Ada 12 kolom CSV yang wajib di isi semua</p><br>
          <p>2.Kolom "No" Wajib di isi dengan format angka naik mulai dari 1 tidak boleh ada baris dg angka yg sama. Contoh: 1, 2, 3 dst</p><br>
           <p><b>Semua kolom wajib diisi, tidak boleh ada yang kosong </p></b><br>
          <p>3.Foto produk akan diisikan gambar standar, anda bisa menggantinya setelah melakukan upload</p><br>
            <p>4.Kolom terjual,terbeli dan sisa diisi dengan angka bulat (tidak memakai koma), boleh diisi 0</p><br>
            <p>5.Pastikan Server atau Komputer Anda kuat untuk mengimport data dalam jumlah banyak</p><br>

            <p><b>6.IMPORT DATA hanya bisa dilakukan dalam kondisi data produk kosong, jangan import jika data produk anda masih ada</p></b><br>
            <p>7.Lama Proses upload sangat bergantung pada kecepatan server hosting dan hasilnya berbeda tiap hosting dan layanan</p><br>
            <p>8.Untuk instalasi di hosting, kami sarankan berhati hati,jangan dipaksakan melebihi kapasitas maksimal server anda karena bisa menyebabkan error, pada localhost (offline) anda bisa upload ribuan produk sekaligus</p><br>
            
            <br>

            <a href="tmp/contohup.csv" class="btn btn-default">
                    <span class="glyphicon glyphicon-download"></span>
                    Download Contoh CSV
                </a>
        </div>



        </div>
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
