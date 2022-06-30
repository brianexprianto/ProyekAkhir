<!DOCTYPE html>
<html>

<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
date_default_timezone_set("Asia/Jakarta");
$today=date('Y-m-d');
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
$halaman = "jual"; // halaman
$dataapa = "Penjualan"; // data
$tabeldatabase = "transaksimasuk"; // tabel database
$chmod = $chmenu6; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman

$insert = $_POST['insert'];
 $sort_num = 1900;
 function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT MAX(RIGHT(nota, 5)) as max_id FROM bayar ORDER BY nota";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);
  $id_max = $data['max_id'];
  $sort_num = (int) substr($id_max, 1, 5);
 
  $sort_num++;
  $new_code = sprintf("%05s", $sort_num);
  return $new_code;
 }
?>

<?php
$decimal ="0";
$a_decimal =",";
$thousand =".";
?>


<!-- SETTING STOP -->

<script>
  function SubmitForm() {
    var nota = $("#nota").val();
      var kode = $("#kode").val();
        var nama = $("#nama").val();
          var hargajual = $("#hargajual").val();
            var hargabeli = $("#hargabeli").val();
            var jumlah = $("#jumlah").val();
            var hargaakhir = $("#hargaakhir").val();
            var datatotal = $("#datatotal").val();

    //alert("Produk : "+nama+"\nTelah berhasil ditambahkan!");

    $.post("add_jual.php", { nota: nota, kode: kode, nama: nama, hargajual: hargajual, hargabeli: hargabeli, jumlah: jumlah, hargaakhir: hargaakhir, datatotal: datatotal}, function(data) {

    });


  }
</script>
<script>
function setFocusToTextBox(){
    document.getElementById("barcode").focus();
}
</script>
<!-- BOX INSERT BERHASIL -->

         <script>
 window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 5000);
</script>
<?php
  if($insert == "10"){
    ?>
  <div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong> Berhasil!</strong> <?php echo $dataapa;?> telah berhasil <b>ditambahkan</b> ke Data <?php echo $dataapa;?>.
</div>

<?php
  }
  if($insert == "3"){
    ?>
  <div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong> Berhasil!</strong> <?php echo $dataapa;?> telah <b>terupdate</b>.
</div>

<!-- BOX UPDATE GAGAL -->
<?php
  }
  ?>

       <!-- BOX INFORMASI -->
    <?php
if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
  ?>


  <!-- KONTEN BODY AWAL -->
                            <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Data <?php echo $dataapa;?></h3>
            </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                <div class="table-responsive">
    <!----------------KONTEN------------------->
      <?php 
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

   

    $nota=$nama=$hargajual=$hargabeli=$jumlah=$hargaakhir=$tglnota=$bayar=$kembalian="";
    $no = $_GET["no"];
    $nota = $_POST['nota'];
    $hargaakhir = $_POST['hargaakhir'];
    $tglnota = $_POST['tglnota'];
    $datatotal = $_POST['datatotal'];
        $insert = '1';
//fungsi menangkap barcode
if(isset($_GET['barcode'])) {
    $barcode = $_GET['barcode'] ;

    $sql1= "SELECT * FROM barang where barcode='$barcode'";
    $query=mysqli_query($conn, $sql1);
    $data=mysqli_fetch_assoc($query);
    $nama=$data['nama'];
    $stok=$data['sisa'];
    $hargajual=$data['hargajual'];
    $hargabeli=$data['hargabeli'];
    $kode1=$data['kode'];
    $_SESSION['kode'] = $kode1;    //menyimpan kode barang di session
    
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
  //menambah jumlah otomatis untuk produk yang beda  
    if ($barcode==$_SESSION['lama'] || !isset($_SESSION['lama']) ){  
    $i = isset($_SESSION['i']) ? $_SESSION['i'] : 0;
    echo ++$i;
    $_SESSION['i'] = $i;
    $jumlah = $_SESSION['i'];
    $_SESSION['lama'] = $barcode;
    $hargaakhir = $jumlah*$hargajual;
  } else{
    unset($_SESSION['i']);
    $i = isset($_SESSION['i']) ? $_SESSION['i'] : 0;
    echo ++$i;
    $_SESSION['i'] = $i;
    $_SESSION['lama'] = $barcode;
    $jumlah = $_SESSION['i'];
    $hargaakhir = $jumlah*$hargajual;
}

}



    if(($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')){

         $sql="select * from $tabeldatabase where kode='$kode'";
                  $hasil2 = mysqli_query($conn,$sql);


                  while ($fill = mysqli_fetch_assoc($hasil2)){


          $kode = $fill["kode"];
          $nama = $fill["nama"];
                  $insert = '3';

    }
    }
    ?>

    <?php

    if($nota == null || $nota == ""){

            $sqle="SELECT SUM(hargaakhir) as data FROM transaksimasuk WHERE nota=".autoNumber()."";
            $hasile=mysqli_query($conn,$sqle);
            $row=mysqli_fetch_assoc($hasile);
            $datatotal=$row['data'];

            $sqle="SELECT SUM(hargabeliakhir) as data FROM transaksimasuk WHERE nota=".autoNumber()."";
            $hasile=mysqli_query($conn,$sqle);
            $row=mysqli_fetch_assoc($hasile);
            $databelitotal=$row['data'];
    }else{

      $sqle="SELECT SUM(hargaakhir) as data FROM transaksimasuk WHERE nota='$nota'";
      $hasile=mysqli_query($conn,$sqle);
      $row=mysqli_fetch_assoc($hasile);
      $datatotal=$row['data'];

      $sqle="SELECT SUM(hargabeliakhir) as data FROM transaksimasuk WHERE nota='$nota'";
      $hasile=mysqli_query($conn,$sqle);
      $row=mysqli_fetch_assoc($hasile);
      $databelitotal=$row['data'];


    }
//menyimpan ke table transaksi masuk

    if(isset($_POST["tambah"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

              $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
              $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
              $kode = mysqli_real_escape_string($conn, $_POST["koda"]);
               $hargajual = mysqli_real_escape_string($conn, $_POST["hargajual"]);
              $hargabeli = mysqli_real_escape_string($conn, $_POST["hargabeli"]);
              $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);
              $hargaakhir = mysqli_real_escape_string($conn, $_POST["hargaakhir"]);
              $hargabeliakhir = mysqli_real_escape_string($conn, $_POST["hargabeli"]*$_POST["jumlah"]);
              $stok = mysqli_real_escape_string($conn, $_POST["stok"]);
              $kasir = $_SESSION["nama"];
              $kegiatan = "menjual barang memakai struk";
              $status = "pending";
              $insert = ($_POST["insert"]);
              $retur = "NO";


                 $sql="select * from $tabeldatabase where nota='$nota' and kode='$kode'";
            $result=mysqli_query($conn,$sql);

                  if(mysqli_num_rows($result)>0){

                    echo "<script type='text/javascript'>  alert('Barang sudah ada, silakan hapus dahulu untuk merubah!');</script>";
              }
          else if(( $chmod >= 2 || $_SESSION['jabatan'] == 'admin')&&($jumlah <= $stok && $jumlah >= '0.1' && $stok >= '0')){

            $sqle3="SELECT * FROM barang where kode='$kode'";
            $hasile3=mysqli_query($conn,$sqle3);
            $row=mysqli_fetch_assoc($hasile3);
            $terjualawal=$row['terjual'];
            $terbeliawal=$row['terbeli'];

            $terjualakhir = $terjualawal + $jumlah;
            $sisaakhir = $stok - $jumlah;
            $kurang = 0 - $jumlah;

            if($sisaakhir >= '0'){
               $sql2 = "insert into $tabeldatabase values( '$nota','$kode','$nama','$hargajual',$hargabeli,'$jumlah','$hargaakhir','$hargabeliakhir','$retur','')";
               $insertan = mysqli_query($conn, $sql2);

               $sql3 = "UPDATE barang SET terjual='$terjualakhir', sisa='$sisaakhir' where kode='$kode'";
               $updatestok = mysqli_query($conn, $sql3);

                $sql4 = "INSERT INTO mutasi values ( '$kasir','$today','$kode','$sisaakhir','$kurang','$kegiatan','$nota','','$status')";
               $mutasi = mysqli_query($conn, $sql4);


               echo "<script type='text/javascript'>  alert('Berhasil, Produk telah berhasil ditambahkan!');</script>";
             }else{
                echo "<script type='text/javascript'>  alert('Gagal, Stok Kurang !');</script>";
              }
             }else{
              echo "<script type='text/javascript'>  alert('Gagal, Stok Kurang / Jumlah tidak boleh kosong!');</script>";

             }

      }

    }


//menyimpan ke tabel bayar

    if(isset($_POST["simpan"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

              $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
              $tglnota = mysqli_real_escape_string($conn, $_POST["tglnota"]);
               $bayar = mysqli_real_escape_string($conn, $_POST["bayar"]);
              $kembalian = mysqli_real_escape_string($conn, $_POST["kembalian"]);
              $kasir = $_SESSION["nama"];
              $insert = ($_POST["insert"]);
              $berhasil = "berhasil";


                 $sql="select * from bayar where nota='$nota'";
            $result=mysqli_query($conn,$sql);


                  if(mysqli_num_rows($result)>0){

                    echo "<script type='text/javascript'>  alert('Data tidak bisa diubah!');</script>";
              }
          else if(( $chmod >= 2 || $_SESSION['jabatan'] == 'admin')&&($bayar >= $datatotal && $bayar != null)){

               $sql2 = "insert into bayar values( '$nota','$tglnota','$bayar','$datatotal','$kembalian','$databelitotal','$kasir','')";
               $insertan = mysqli_query($conn, $sql2);

               //update mutasi
               $sql3 = "UPDATE mutasi SET status='$berhasil' where keterangan='$kode'";
               $updatemutasi = mysqli_query($conn, $sql3);


?>
<script type="text/javascript">
window.onload = function() {
  var win = window.open('print_one.php?nota=<?php echo $kode;?>','Cetak',' menubar=0, resizable=0,dependent=0,status=0,width=260,height=400,left=10,top=10','_blank');
if (win) {
  alert('Berhasil, Data telah disimpan!');
    win.focus();
   window.location = 'add_jual';
} else {
    alert('Silakan Allow Pop Up bila ingin mencetak!');
}

}

</script>

<?php

  //             echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
//echo "<script type='text/javascript'>window.location = 'add_jual';</script>";

             }else{
              echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan! Pastikan pembayaran benar');</script>";
              
             

             }

      }

    }



    if($nota == null || $nota == ""){

            $sqle="SELECT SUM(hargaakhir) as data FROM transaksimasuk WHERE nota=".autoNumber()."";
            $hasile=mysqli_query($conn,$sqle);
            $row=mysqli_fetch_assoc($hasile);
            $datatotal=$row['data'];
    }else{

      $sqle="SELECT SUM(hargaakhir) as data FROM transaksimasuk WHERE nota='$nota'";
      $hasile=mysqli_query($conn,$sqle);
      $row=mysqli_fetch_assoc($hasile);
      $datatotal=$row['data'];


    }


             ?>


<body OnLoad="document.barcodeform.barcode.focus();">

  <div id="main">
   <div class="container-fluid">

          <form class="form-horizontal" method="get" action="add_<?php echo $halaman; ?>" name="barcodeform" id="Myform" class="form-user">
              <div class="box-body">

                <div class="row">

                  <div class="col-md-6">
                    <div class="box box-success">
                      <div class="box-body">
<!--
 <label for="barang" class="col-sm-2 control-label">Scan barcode:</label>
                        <div class="form-group col-md-6 col-xs-12" >
                          <input type="text" class="form-control" id="barcode" name="barcode" >
                </div> 
                <label for="barang" class="col-sm-2 control-label">Atau</label>
              -->
</form>
<form class="form-horizontal" method="post" action="add_<?php echo $halaman; ?>" id="Myform" class="form-user">
                  



        <div class="row" >
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="barang" class="col-sm-2 control-label">Pilih Produk:</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%;" name="kode" id="kode">
                      <option></option>
              <?php
        $sql=mysqli_query($conn,"select * from barang");
        while ($row=mysqli_fetch_assoc($sql)){
          if ($barang==$row['kode'])
          echo "<option value='".$row['kode']."' koda='".$row['kode']."' nama='".$row['nama']."' hargajual='".$row['hargajual']."' sisa='".$row['sisa']."' hargabeli='".$row['hargabeli']."' selected='selected'>".$row['sku']." | ".$row['nama']."</option>";
          else
          echo "<option value='".$row['kode']."' koda='".$row['kode']."' nama='".$row['nama']."' hargajual='".$row['hargajual']."'  sisa='".$row['sisa']."' hargabeli='".$row['hargabeli']."' >".$row['sku']." | ".$row['nama']."</option>";
        }
      ?>
                    </select>

                    <!--
option value kode dari select tidak dipakai, sebagai gantinya digunakan koda yang valuenya diteruskan ke input dibawah
-->
                  </div>
                </div>
        </div>


            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="box box-info">
            <div class="box-body">

              <div class="row" >


                <div class="form-group col-md-12 col-xs-12" >
                        
                          <label for="tglnota" class="col-sm-4 control-label">No Nota:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nota" name="nota" value="<?php echo autoNumber(); ?>" maxlength="50" required readonly>
             
          </div>
                          
                      
                      </div>


                 
              </div>


</div>
</div>
</div>

<div class="col-md-3">
          <div class="box box-danger">
            <div class="box-body">

              <div class="row" >


                

                 <div class="form-group col-md-12 col-xs-12" >
                        <div class="col-sm-10">

                          <?php 
                          error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                          if($datatotal == "" || $datatotal == null){?>
                            <h1 align="center">Rp   <?php echo '0'.',-'; ?></h1>
                            <?php }else{ ?>
                        <h1 align="center">Rp   <?php echo number_format($datatotal, $decimal, $a_decimal, $thousand).',-'; ?></h1>
                        <?php } ?>
                        </div>
                      </div>
              </div>


</div>
</div>
</div>

      <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert;?>" maxlength="1" >


<!--
kode dari select dan barcode scanner dimasukan dalam input koda
-->

      <input type="hidden" class="form-control" id="koda" name="koda" value="<?php echo $kode1; ?>" readonly>


              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="box box-default">
                    <div class="box-body">

                  <div class="row" >

                      <div class="col-sm-4">
                      <label for="usr">Nama Barang</label>
                      <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" readonly>
                    </div>

                    <div class="col-sm-2">
                    <label for="usr">Sisa Stok</label>
                    <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $stok; ?>" readonly>
                  </div>


                                                <script>
                                               function sum() {
                                                     var txtFirstNumberValue =  document.getElementById('jumlah').value
                                                     var txtSecondNumberValue = document.getElementById('hargajual').value;
                                                     var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
                                                     if (!isNaN(result)) {
                                                        document.getElementById('hargaakhir').value = result;
                                                     }
                                                   if (!$(jumlah).val()){
                                                     document.getElementById('hargaakhir').value = "0";
                                                   }
                                                   if (!$(hargajual).val()){
                                                     document.getElementById('hargaakhir').value = "0";
                                                   }
                                               }
                                               </script>

                  <div class="col-sm-2">
                  <label for="usr">Harga Satuan</label>
                  <input type="text" class="form-control" id="hargajual" name="hargajual" value="<?php echo $hargajual; ?>" readonly>
                  <input type="hidden" id="hargabeli" name="hargabeli" value="<?php echo $hargabeli; ?>" readonly>
                  <input type="hidden" id="kode1" name="kode1" value="<?php echo $kode1; ?>" readonly>
                </div>


                <div class="col-sm-2">
                <label for="usr">Jumlah Jual</label>
                <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo $jumlah; ?>" placeholder="Masukan Jumlah" onkeyup="sum();">
              </div>

              <div class="col-sm-2">
              <label for="usr">Total Pembayaran</label>
              <input type="text" class="form-control" id="hargaakhir" name="hargaakhir" value="<?php echo $hargaakhir; ?>" readonly>
            </div>


            <!-- keterangan-->
 <div class="row" >

                      

                    

           
            <!--end keterangan-->

                  </div>
                </br>
                  



</div><button type="submit" class="btn btn-primary" name="tambah" onclick="SubmitForm()" ><span class="glyphicon glyphicon-shopping-cart"></span> Tambah</button>
</div>
                </div>
              </div>



              <div class="row">
                <div class="col-md-12">
                  <div class="box box-info">
                    <div class="box-header with-border">
             <b>Daftar Transaksi</b>
           </div>

           <?php
           error_reporting(E_ALL ^ E_DEPRECATED);

           $sql    = "select * from transaksimasuk where nota =".autoNumber()." order by no";
           $result = mysqli_query($conn, $sql);
           $rpp    = 15;
           $reload = "$halaman"."?pagination=true";
           $page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);



           if ($page <= 0)
           $page = 1;
           $tcount  = mysqli_num_rows($result);
           $tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
           $count   = 0;
           $i       = ($page - 1) * $rpp;
           $no_urut = ($page - 1) * $rpp;
           ?>
           <div class="box-body table-responsive">
              <table class="data table table-hover table-bordered">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Harga Satuan</th>
                          <th>Jumlah Jual</th>
                          <th>Total Pembayaran</th>
           <?php  if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                          <th>Opsi</th>
           <?php }else{} ?>
                      </tr>
                  </thead>
                    <?php
           error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
           while(($count<$rpp) && ($i<$tcount)) {
           mysqli_data_seek($result,$i);
           $fill = mysqli_fetch_array($result);
           ?>
           <tbody>
           <tr>
           <td><?php echo ++$no_urut;?></td>
           <td><?php  $cba =$fill['kode'];
        $r=mysqli_fetch_assoc(mysqli_query($conn,"SELECT sku FROM barang WHERE kode='$cba'"));
       echo mysqli_real_escape_string($conn, $r['sku']); ?>
                        </td>
           <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
           <td><?php  echo mysqli_real_escape_string($conn, 'Rp '.number_format($fill['harga'], $decimal, $a_decimal, $thousand).',-'); ?></td>
           <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
           <td><?php  echo mysqli_real_escape_string($conn, 'Rp '.number_format(($fill['jumlah']*$fill['harga']), $decimal, $a_decimal, $thousand).',-'); ?></td>
           <td>
           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
           <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_produk?get=<?php echo '1'.'&'; ?>barang=<?php echo $fill['kode'].'&'; ?>jumlah=<?php echo $fill['jumlah'].'&'; ?>kode=<?php echo $kode.'&'; ?>no=<?php echo $fill['no'].'&'; ?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo "add_".$forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
           <?php } else {}?>
           </td></tr>
           <?php
           $i++;
           $count++;
           }

           ?>
           </tbody></table>
           <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>


           </div>

           </div>


         </div>
                  </div>
                </div>



                            <div class="row">
                              <div class="col-md-12">
                                <div class="box box-solid">
                                  <div class="box-header with-border">

                                  <a class="btn btn-danger"  href="bayar?nota=<?php echo autoNumber();?>" >&nbsp&nbsp&nbsp&nbsp BAYAR &nbsp&nbsp&nbsp&nbsp</a>   






                                  </div>
                                </div>
                              </div>
                            </div>

              <!-- /.box-body -->
              <div class="box-footer" >
                <div class="col-sm-6">
                  <!--
                <button type="submit" class="btn btn-block pull-left btn-flat btn-danger" onclick="Struk('bayar?nota=<?php echo $nota;?>'); document.getElementById('Myform').submit();" ><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>     -->
                                
                
</div>
              </div>
              <!-- /.box-footer -->

 </form>
</div>
<script>
function myFunction() {
    document.getElementById("Myform").submit();
}

         var helpWindow;

function Struk(url) {
    helpWindow = window.location(url, 'helpWindow');


}
      </script>
    <!-- KONTEN BODY AKHIR -->



                                </div>
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

<!-- Script -->
    <script src='jquery-3.1.1.min.js' type='text/javascript'></script>

    <!-- jQuery UI -->
    <link href='jquery-ui.min.css' rel='stylesheet' type='text/css'>
    <script src='jquery-ui.min.js' type='text/javascript'></script>


          <!-- ./wrapper -->
<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="1-11-4-jquery-ui.min.js"></script>
        <script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script>
$("#kode").on("change", function(){

  var nama = $("#kode option:selected").attr("nama");
  var hargajual = $("#kode option:selected").attr("hargajual");
  var sisa = $("#kode option:selected").attr("sisa");
  var hargabeli = $("#kode option:selected").attr("hargabeli");
  var koda =$("#kode option:selected").attr("koda");
  
  

  $("#nama").val(nama);
  $("#hargajual").val(hargajual);
  $("#stok").val(sisa);
  $("#hargabeli").val(hargabeli);
  $("#koda").val(koda);
    
  $("#hargaakhir").val(0);
  $("#jumlah").val(0);
});
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
<!-- Script -->
    <script type='text/javascript' >
    $( function() {
  
        $( "#barcode" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "server.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#nama').val(ui.item.label);
                $('#barcode').val(ui.item.value); // display the selected text
                $('#hargajual').val(ui.item.hjual);
                $('#stok').val(ui.item.sisa); // display the selected text
                $('#hargabeli').val(ui.item.hbeli);
                $('#jumlah').val(ui.item.jumlah);
                $('#kode').val(ui.item.kode);
                $('#hargaakhir').val(ui.item.bayar); // save selected id to input
                return false;
                
            }
        });

        // Multiple select
        $( "#multi_autocomplete" ).autocomplete({
            source: function( request, response ) {
                
                var searchText = extractLast(request.term);
                $.ajax({
                    url: "server.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: searchText
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function( event, ui ) {
                var terms = split( $('#multi_autocomplete').val() );
                
                terms.pop();
                
                terms.push( ui.item.label );
                
                terms.push( "" );
                $('#multi_autocomplete').val(terms.join( ", " ));

                // Id
                var terms = split( $('#selectuser_ids').val() );
                
                terms.pop();
                
                terms.push( ui.item.value );
                
                terms.push( "" );
                $('#selectuser_ids').val(terms.join( ", " ));

                return false;
            }
           
        });
    });

    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }

    </script>

<!--AUTO Complete-->

<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy/mm/dd"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("yyyy-mm-dd", {"placeholder": "yyyy/mm/dd"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'YYYY/MM/DD h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Hari Ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Akhir 7 Hari': [moment().subtract(6, 'days'), moment()],
            'Akhir 30 Hari': [moment().subtract(29, 'days'), moment()],
            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            'Akhir Bulan': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

   $('.datepicker').datepicker({
    dateFormat: 'yyyy-mm-dd'
 });

   //Date picker 2
   $('#datepicker2').datepicker('update', new Date());

    $('#datepicker2').datepicker({
      autoclose: true
    });

   $('.datepicker2').datepicker({
    dateFormat: 'yyyy-mm-dd'
 });


    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>



</body>
</html>
