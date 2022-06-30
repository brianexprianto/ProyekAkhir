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

include "configuration/config_chmod.php";
$halaman = "barang"; // halaman
$dataapa = "Barang"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu4; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$id = $_GET['q'];

?>


<!-- SETTING STOP -->
<?php

 function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT MAX(no) as max_id FROM $forward ORDER BY no";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);
  $id_max = $data['max_id'];
  $sort_num = $id_max;
  $sort_num++;
  $new_code = sprintf("%06s", $sort_num);
  return $new_code;
 }

 

?>

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



 <?php

if( isset($id) && $id!='' ){

  $w=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM barang WHERE no='$id'"));
}

       ?>
  <!-- KONTEN BODY AWAL -->
                         <!-- Default box -->
    <div class="col-md-8 col-lg-8 col-xs-12">

      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Barang</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
         



<form method="post" enctype="multipart/form-data">

<div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <!-- <li class="active"><a href="#tab_1" data-toggle="tab">Standard</a></li> -->
                        <li style="display:none"><a href="#tab_2" data-toggle="tab">Harga</a></li>
                        <li style="display:none"><a href="#tab_3" data-toggle="tab">Stok</a></li>
                        

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="row">
                                <div class="col-xs-7">
                                    <span style="display:none"><input style="width:400px" class="form-control"
                                            type="text" id="id_barang"></span>
                                    <table class="table">
                                        <tr>
                                            <td style="width:150px">Kode Barang</td>
                                            <td style="width:10px">:</td>
                                            <td>
                                               
                                                         <?php    if( isset($id) && $id!='' ){?>

                                 <input class="form-control" type="hidden" id="kode" name="kode" value="<?php echo $w['kode'];?>">
                                <input class="form-control" type="text" id="sku" name="sku" value="<?php echo $w['sku'];?>">

                                     <?php } else {?>
                                <input class="form-control" type="hidden" id="kode" name="kode" value="<?php echo autoNumber();?>">
                                <input class="form-control" type="text" id="sku" name="sku" value="SKU<?php echo autoNumber();?>">
                                      <?php } ?>         
                                                   
                                            </td>
                                        </tr>

                      <?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));?>
                                        <tr>
                                            <td>Nama Barang</td>
                                            <td>:</td>
                                            <td><input class="form-control" name="nama" maxlength="200" autocomplete="off" value="<?php echo $w['nama'];?>" required> </td>
                                        </tr>
                                        <tr>
                                            <td>Satuan Barang </td>
                                            <td>:</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                      <select class="form-control" style="width: 100%;" name="kategori" required>
                                               
                 <?php
        $sql=mysqli_query($conn,"select * from kategori");
        while ($row=mysqli_fetch_assoc($sql)){
           if ($w['kategori']==$row['nama'])
          echo "<option value='".$row['nama']."' selected='selected'>".$row['nama']."</option>";
          else
          echo "<option value='".$row['nama']."'>".$row['nama']."</option>";
        }
      ?>
                    </select><span
                                                            class="input-group-btn">
                                                            <a class="btn btn-default"
                                                                href="add_kategori" ><i class="fa fa-edit"
                                                                    aria-hidden="true"></i> </a></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Supplier</td>
                                            <td>:</td>
                                            <td>
                                                  <div class="form-group">
                                                    <div class="input-group">
                                                      <select class="form-control" style="width: 100%;" name="nama_supplier" required>
                                                                  <?php
        $sql=mysqli_query($conn,"select * from supplier");
        while ($row=mysqli_fetch_assoc($sql)){
           if ($w['nama']==$row['nama'])
          echo "<option value='".$row['nama']."' selected='selected'>".$row['nama']."</option>";
          else
          echo "<option value='".$row['nama']."'>".$row['nama']."</option>";
        }
      ?>
                    </select><span
                                                            class="input-group-btn">
                                                             <a class="btn btn-default"
                                                                href="add_supplier" ><i class="fa fa-edit"
                                                                    aria-hidden="true"></i> </a></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Harga Beli</td>
                                            <td>:</td>
                                            <td><input class="form-control" name="harga_beli" required autocomplete="off" value="<?php echo $w['hargabeli'];?>"> </td>
                                        </tr>
                                        <tr>
                                            <td>Harga Jual</td>
                                            <td>:</td>
                                            <td><input class="form-control" name="harga_jual" required autocomplete="off" value="<?php echo $w['hargajual'];?>">
                                             </td>
                                        </tr>
                                        <?php    if( isset($id) && $id!='' ){?>
                                        <tr>
                                            <td>Stok Sekarang</td>
                                            <td>:</td>
                                            <td><input class="form-control" name="stok" type="number" min="1" value="<?php echo $w['sisa'];?>" required> </td>
                                        </tr>
                                        <?php } else {?>
                                        <tr>
                                            <td>Stok Sekarang</td>
                                            <td>:</td>
                                            <td><input class="form-control" name="stok" type="number" min="1" autocomplete="off" required> </td>
                                        </tr>  
                                         <?php } ?>

                                    </table>
                                </div>
                               <!--  <div class="col-xs-5">
                                   <table class="table">
                                       <?php    if( isset($id) && $id!='' ){?>

                                         <tr>
                                            <td>Stok Minimal</td>
                                            <td>:</td>
                                            <td><input class="form-control" name="stok_minimal" type="number" min="1" value="<?php echo $w['stokmin'];?>" required>
                                            </td>
                                        </tr>

                                         <tr>
                                            <td>Barcode</td>
                                            <td>:</td>
                                            <td><input class="form-control" name="barcode" value="<?php echo $w['barcode'];?>" required> </td>
                                        </tr>

                                        <tr>
                                            <td>Stok Sekarang</td>
                                            <td>:</td>
                                            <td><input class="form-control" name="stok" type="number" min="1" value="<?php echo $w['sisa'];?>" required> </td>
                                        </tr>

                                        <?php } else {?>

                                        <tr>
                                            <td>Stok Sekarang</td>
                                            <td>:</td>
                                            <td><input class="form-control" name="stok" type="number" min="1" autocomplete="off" required> </td>
                                        </tr>
                                     
                                        <tr>
                                            <td>Stok Minimal</td>
                                            <td>:</td>
                                            <td><input class="form-control" name="stok_minimal" type="number" min="1" value="1" required>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Barcode</td>
                                            <td>:</td>
                                            <td><input class="form-control" name="barcode" value="BRG<?php echo autoNumber();?>" required> </td>
                                        </tr>
                                      
                                     <?php } ?>
                                        

                                        
                                    </table>
                                    
                                </div> -->
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">

                            <div class="row">
                                <div class="col-lg-8">
                                    <table class="table">

                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="tab_3">

                            <div class="row">
                                <div class="col-lg-8">

                                </div>
                            </div>

                        </div>
 <?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));?>
                        <div class="tab-pane" id="tab_4">

                            <div class="row">
                                <div class="col-lg-8">
                                    <table class="table">
                                         <tr>
                                            <td>Ukuran</td>
                                            <td>:</td>
                                            <td><input class="form-control" name="ukuran" value="<?php echo $w['ukuran'];?>"> </td>
                                        </tr>
                                        <tr>
                                            <td>Warna</td>
                                            <td>:</td>
                                            <td><input class="form-control" name="warna" value="<?php echo $w['warna'];?>"> </td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Lokasi Rak</td>
                                            <td>:</td>
                                            <td>
                                                <input class="form-control" name="lokasi" value="<?php echo $w['lokasi'];?>" >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Expired</td>
                                            <td>:</td>
                                            <td>
                                                <input id="datepicker" class="form-control datepicker-here"
                                                    data-language="en" name="expired" autocomplete="off" value="<?php echo $w['expired'];?>">
                                            </td>
                                        </tr>

                                          <tr>
                                            <td>Keterangan</td>
                                            <td>:</td>
                                            <td>
                                                <input class="form-control" name="keterangan" value="<?php echo $w['keterangan'];?>" >
                                            </td>
                                        </tr>

                                          <tr>
                                            <td>Gambar</td>
                                            <td>:</td>
                                            <td>
                                               <input type="file" class="form-control" name="avatar">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
        </div>
        <!-- /.col -->

  <div class="box-footer">
               
                <button class="btn btn-primary" type="submit" name="savebarang"><i class="fa fa-check-square-o"
                        aria-hidden="true"></i> Simpan</button>
                <a class="btn btn-warning" href="add_barang" ><i class="fa fa-retweet" aria-hidden="true"></i>
                    Reset</a>
                <a class="btn btn-danger" href="barang" ><i class="fa fa-window-close"
                        aria-hidden="true"></i> Batal</a>
            </div>

        </form>

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






<?php

    
   if($_SERVER["REQUEST_METHOD"] == "POST"){
     if(isset($_POST['savebarang'])){

          $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
            $sku = mysqli_real_escape_string($conn, $_POST["sku"]);
          $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
           $satuan = mysqli_real_escape_string($conn, $_POST["satuan"]);
            $kategori = mysqli_real_escape_string($conn, $_POST["kategori"]);
          $hargabeli = mysqli_real_escape_string($conn, $_POST["harga_beli"]);
          $hargajual = mysqli_real_escape_string($conn, $_POST["harga_jual"]);
           $sisa = mysqli_real_escape_string($conn, $_POST["stok"]);
            $stokmin = mysqli_real_escape_string($conn, $_POST["stok_minimal"]);

            $ukuran = mysqli_real_escape_string($conn, $_POST["ukuran"]);
             $warna = mysqli_real_escape_string($conn, $_POST["warna"]);
          $nama_supplier = mysqli_real_escape_string($conn, $_POST["nama_supplier"]);
           $rak = mysqli_real_escape_string($conn, $_POST["lokasi"]);
            $exp = mysqli_real_escape_string($conn, $_POST["expired"]);

            $usr=$_SESSION['nama'];
            $now=date('Y-m-d');

             $ket = mysqli_real_escape_string($conn, $_POST["keterangan"]);         
          
          $namaavatar = $_FILES['avatar']['name'];
                      $ukuranavatar = $_FILES['avatar']['size'];
                      $tipeavatar = $_FILES['avatar']['type'];
                      $tmp = $_FILES['avatar']['tmp_name'];
                      $avatar = "dist/upload/".$namaavatar;
                        $insert = ($_POST["insert"]);


             
             $sql="select * from $tabeldatabase where kode='$kode'";
        $result=mysqli_query($conn,$sql);

              if(mysqli_num_rows($result)>0){
         if((($tipeavatar == "image/jpeg" || $tipeavatar == "image/png") && ($ukuranavatar <= 10000000)) && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')){
             move_uploaded_file($tmp, $avatar);
                   $sql1="UPDATE barang SET sku='$sku', nama='$nama',kategori='$kategori',hargabeli='$hargabeli',hargajual='$hargajual',stokmin='$stokmin',nama_supplier='$nama_supplier',keterangan='$ket', avatar='$avatar' WHERE kode='$kode'";

                  if(mysqli_query($conn, $sql1)){
                  echo "<script type='text/javascript'>  alert('Berhasil, Data barang telah diupdate!'); </script>";
                  echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                } else {
                    echo "<script type='text/javascript'>  alert('GAGAL, terjadi kesalahan!'); </script>";
                  echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                }
        }else if($chmod >= 3 || $_SESSION['jabatan'] == 'admin'){
           
                   $sql1="UPDATE barang SET sku='$sku', nama='$nama',kategori='$kategori',hargabeli='$hargabeli',hargajual='$hargajual',stokmin='$stokmin',nama_supplier='$nama_supplier',keterangan='$ket' WHERE kode='$kode'";

                  if(mysqli_query($conn, $sql1)){
                  echo "<script type='text/javascript'>  alert('Berhasil, Data barang telah diupdate!'); </script>";
                  echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                } else {
                    echo "<script type='text/javascript'>  alert('GAGAL, terjadi kesalahan!'); </script>";
                  echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                }
          } else {

            echo "<script type='text/javascript'>  alert('Gagal, Data gagal diupdate!'); </script>";
          echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";

          }
        }
      else if(( $chmod >= 2 || $_SESSION['jabatan'] == 'admin')){

          move_uploaded_file($tmp, $avatar);
            $sql2 = "insert into $tabeldatabase values( '','$kode','$sku','$nama','$kategori','$nama_supplier','$hargabeli','$hargajual','$terjual','$terbeli','$sisa','$retur','','','','','','0.05','$ket','$avatar')";
           if(mysqli_query($conn, $sql2)){
           echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
           echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";

         }else{

           $avatar = "dist/upload/index.jpg";
         $sql2 = "insert into $tabeldatabase values( '','$kode','$sku','$nama','$kategori','$nama_supplier','$hargabeli','$hargajual','$terjual','$terbeli','$sisa','$retur','','','','','','0.05','$ket','$avatar')";
           if(mysqli_query($conn, $sql2)){
           echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
           echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
         } else {

          echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan!'); </script>";
           echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
         }
           }


        $sql4=mysqli_query($conn,"INSERT INTO mutasi VALUES('$usr','$now','$kode','$sisa','0','menambah Produk','$sku','','berhasil')");


         }

  }
}

         ?>






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
                $('#kode').val(ui.item.kode); // save selected id to input
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
