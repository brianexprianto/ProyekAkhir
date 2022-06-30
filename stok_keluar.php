<!DOCTYPE html>
<html >
<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
etc();encryption();session();connect();head();body();timing();
//alltotal();
pagination();

date_default_timezone_set("Asia/Jakarta");
$today=date('Y-m-d');
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
$halaman = "stok_keluar"; // halaman
$dataapa = "Stok"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu5; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman

 
?>
<?php 
//fungsi menangkap barcode
if(isset($_GET['barcode'])) {
    $barcode = $_GET['barcode'] ;

    $sql1= "SELECT * FROM barang where barcode='$barcode'";
    $query=mysqli_query($conn, $sql1);
    $data=mysqli_fetch_assoc($query);
    $nama=$data['nama'];
    $stok=$data['sisa'];
    $jual=$data['terjual'];
    $terbeli=$data['terbeli'];
    
    $kode=$data['kode'];
    $insert=3;
      //menyimpan kode barang di session
    
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
  //menambah jumlah otomatis untuk produk yang beda  
    if ($barcode==$_SESSION['lama'] || !isset($_SESSION['lama']) ){  
    $i = isset($_SESSION['i']) ? $_SESSION['i'] : 0;
    echo ++$i;
    $_SESSION['i'] = $i;
    $jumlah = $_SESSION['i'];
    $_SESSION['lama'] = $barcode;
    $sisa=$stok -$jumlah;
    $terjual = $jual + $jumlah;
  } else{
    unset($_SESSION['i']);
    $i = isset($_SESSION['i']) ? $_SESSION['i'] : 0;
    echo ++$i;
    $_SESSION['i'] = $i;
    $_SESSION['lama'] = $barcode;
    $jumlah = $_SESSION['i'];
    $sisa=$stok -$jumlah;
    $terjual = $jual + $jumlah;
}

}



?>

<script>
function setFocusToTextBox(){
    document.getElementById("barcode").focus();
}
</script>


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
                            <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Data <?php echo $dataapa;?> Keluar</h3>
            </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                <div class="table-responsive">
    <!----------------KONTEN------------------->
      <?php
    
    ?>
    <body OnLoad="document.barcodeform.barcode.focus();">
  <div id="main">
   
   <!-- right column -->
        <div class="col-md-6" onload='setFocusToTextBox()'>
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Stok Keluar (barcode)</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" name="barcodeform" method="get" action="<?php echo $halaman;?>">
              <div class="box-body">
                <div class="form-group">
                 <label for="inputEmail3" class="col-sm-2 control-label">Barcode</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Ketikan nama atau scan barcode disini">
                  </div>
                </div>
               
              
              <!-- /.box-footer -->
            </form>
            <form  method="post" action="<?php echo $halaman;?>"  >

            <input type="hidden" class="form-control" readonly="readonly" value="<?php echo $kode;?>"  id="kode" name="kode" placeholder="kode Barang">

            <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nama Barang</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly="readonly" value="<?php echo $nama;?>"  id="nama" name="nama" placeholder="Nama Barang">
                  </div>
                </div>
            <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Jumlah Keluar</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo $jumlah;?>" onkeyup="sum2();" autocomplete="off" placeholder="Jumlah yang akan dimasukan" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Total Keluar</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly="readonly" id="terjual" name="terjual" value="<?php echo $terjual;?>" placeholder="Stok terjual sebelumnya">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Total Masuk</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly="readonly" id="terbeli" name="terbeli" value="<?php echo $terbeli;?>" placeholder="Stok masuk sebelumnya">
                  </div>
                </div>
                <script>
       function sum2() {
             var txtFirstNumberValue =  document.getElementById('stok').value
             var txtSecondNumberValue = document.getElementById('jumlah').value;
             var result = parseFloat(txtFirstNumberValue) - parseFloat(txtSecondNumberValue);
             if (!isNaN(result)) {
                document.getElementById('sisa').value = result;
             }
           
       }
       </script>

       

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Stok Awal</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo $stok;?>" readonly="readonly" id="stok" name="stok" placeholder="Stok tersedia saat ini">
                  </div>
                </div>
                <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert;?>" maxlength="1" >

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Stok Akhir</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo $sisa;?>" readonly="readonly" id="sisa" name="sisa" placeholder="0">
                  </div>
                </div>


                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Keterangan</label>

                  <div class="col-sm-10">
                    <textarea class="form-control" name="ket" placeholder="Keterangan"></textarea>
                  </div>
                </div>

                <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert;?>" maxlength="1" >

                <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="simpan" onclick="document.getElementById('Myform').submit();">Submit</button>
                <button type="button" class="btn btn-danger pull-right" name="simpan" onclick="window.location.href='<?php echo $halaman.'?'; ?>unset=1'">Reset</button>
              </div>
              <!-- /.box-footer -->
          </form>



          </div>
          <!-- /.box -->



 <?php
if(isset($_GET['unset'])){
 unset($_SESSION['i']);

 } else if(isset($_POST["simpan"])){

       if($_SERVER["REQUEST_METHOD"] == "POST"){

              $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
              $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
              $terjual = mysqli_real_escape_string($conn ,$_POST["terjual"]);
              $terbeli = mysqli_real_escape_string($conn, $_POST["terbeli"]);
              $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);
              $sisa = mysqli_real_escape_string($conn, $_POST["sisa"]);
              $nota = mysqli_real_escape_string($conn, $_POST["ket"]);
              $selisih = $sisa ;
              $kasir = $_SESSION["username"];
              $kegiatan = "mengeluarkan stok dgn barcode scan";
              $status = "berhasil";
              
            $insert = ($_POST["insert"]);
             unset($_SESSION['i']);


              if(($chmod >= 3 || $_SESSION['jabatan'] == 'admin')&&($sisa >='0')&&($selisih >='0')&&($jumlah >0)){
                      $sql1 = "update $tabeldatabase set terjual='$terjual', terbeli='$terbeli', sisa='$selisih' where kode='$kode'";
                      $updatean = mysqli_query($conn, $sql1);
                      
                      //merekam mutasi
               $sql4 = "INSERT INTO mutasi values ( '$kasir','$today','$kode','$selisih','$jumlah','$kegiatan','$nota','','$status')";
               $mutasi = mysqli_query($conn, $sql4);

                      echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
                      echo "<script type='text/javascript'>window.location = 'stok_keluar';</script>";
              }else{
                     echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan! Pastikan Stok Benar');</script>";
              }


      }
    }

             ?>


<script>
function myFunction() {
    document.getElementById("Myform").submit();
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
          <!-- ./wrapper -->

<!-- Script -->
    <script src='jquery-3.1.1.min.js' type='text/javascript'></script>

    <!-- jQuery UI -->
    <link href='jquery-ui.min.css' rel='stylesheet' type='text/css'>
    <script src='jquery-ui.min.js' type='text/javascript'></script>

<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

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
                    url: "server3.php",
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
                $('#terjual').val(ui.item.hjual);
                $('#sisa').val(ui.item.sisa); 
                $('#stok').val(ui.item.sisa); // display the selected text
                $('#terbeli').val(ui.item.hbeli);
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
                    url: "server3.php",
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
