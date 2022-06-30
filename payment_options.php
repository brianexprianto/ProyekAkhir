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
$halaman = "payment_options"; // halaman
$dataapa = "Pilihan Pembayaran"; // data
$tabeldatabase = "options"; // tabel database
$chmod = $chmenu4; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
$insert = $_POST['insert'];

 
?>


<!-- SETTING STOP -->
<?php
if($_GET['no']>=1){
if($_SERVER["REQUEST_METHOD"] == "GET"){
$no = $_GET['no'];
     $sql = "delete from options where no='".$no."'";
     if (mysqli_query($conn, $sql)) {
        echo "<script type='text/javascript'>  alert('Berhasil, data telah dihapus!');</script>";
echo "<script type='text/javascript'>window.location = '$halaman';</script>";
     } else {

        echo "<script type='text/javascript'>  alert('GAGAL, data gagal dihapus, terjadi kesalahan!');</script>";
echo "<script type='text/javascript'>window.location = '$halaman';</script>";
     }
} }

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


  <!-- KONTEN BODY AWAL -->
                         <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Pilihan Pembayaran</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          
<div class="col-lg-6">
            <form method=post>

                <div class="row">
           <div class="form-group col-md-6 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Nama Pilihan:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukan pilihan pembayaran" maxlength="20" required="">
                  </div>
                </div>
        </div>

<div class="box-footer" >
                <button type="submit" class="btn btn-default pull-left btn-flat" name="pay" ><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
              </div>
            </form>
        
    </div>



    <div class="col-lg-6">
<form method=post>
           <div class="row">
           <div class="form-group col-md-6 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Nama Bank:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukan Nama BANK" maxlength="20" required="">
                  </div>
                </div>
       
        </div>
    </div>




<div class="box-footer" >
                <button type="submit" class="btn btn-default pull-left btn-flat" name="bank" ><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
              </div>
          </form>


        </div>


                                <!-- /.box-body -->
                            </div>


 <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          

<div class="col-lg-6">
<div class="box box-primary">
          <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                 
                <tr>
                  <th>No</th>
                  <th>Pilihan</th>
                  <th>Hapus</th>
                  
                </tr>
                <tr>
                     <?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    $sql    = "select * from $forward where tipe='pay' order by no";
    $hasil = mysqli_query($conn, $sql);
     $no = 0;
    while ($fill = mysqli_fetch_assoc($hasil)){
    ?>
                  <td><?php echo ++$no;?></td>
                  <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                  <td><button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='payment_options?no=<?php echo $fill['no'];?>'">Hapus</button></td>
                 
                </tr>
                <?php } ?>
              </table>
            </div>
        </div>
    </div>


    <div class="col-lg-6">
<div class="box box-primary">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
              
                <tr>
                  <th>No</th>
                  <th>Bank</th>
                  <th>Hapus</th>
                  
                </tr>
                <tr>
                      <?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    $sql    = "select * from $forward where tipe='bank' order by no";
    $hasil = mysqli_query($conn, $sql);
     $no = 0;
    while ($fill = mysqli_fetch_assoc($hasil)){
    ?>
                   <td><?php echo ++$no;?></td>
                  <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                 <td><button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='payment_options?no=<?php echo $fill['no'];?>'">Hapus</button></td>
                  
                </tr>
               <?php } ?>
              </table>
            </div>
        </div>
    </div>








        </div>

                                <!-- /.box-body -->
                            </div>
                        </div>



                        </div>


<?php


     if(isset($_POST["pay"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

          $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
          
             $sql="select * from $tabeldatabase where nama='$nama'";
        $result=mysqli_query($conn,$sql);
 if(mysqli_num_rows($result)>0){

                    echo "<script type='text/javascript'>  alert('Pilihan Pembayaran dengan nama yang sama sudah ada, silakan hapus dahulu untuk merubah!');</script>";
              } else {
$sql2 = "insert into $tabeldatabase values( '$nama','pay','')";
               $insertan = mysqli_query($conn, $sql2);
echo "<script type='text/javascript'>  alert('Berhasil, Pilihan pembayaran telah ditambahkan!');</script>";
echo "<script type='text/javascript'>window.location = '$halaman';</script>";



              }


    }}

        ?>

<?php


     if(isset($_POST["bank"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

          $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
          
             $sql="select * from $tabeldatabase where nama='$nama'";
        $result=mysqli_query($conn,$sql);
 if(mysqli_num_rows($result)>0){

                    echo "<script type='text/javascript'>  alert('Bank dengan nama yang sama sudah ada, silakan hapus dahulu untuk merubah!');</script>";
              } else {
$sql2 = "insert into $tabeldatabase values( '$nama','bank','')";
               $insertan = mysqli_query($conn, $sql2);
echo "<script type='text/javascript'>  alert('Berhasil, Bank telah ditambahkan!');</script>";
echo "<script type='text/javascript'>window.location = '$halaman';</script>";



              }


    }}

        ?>



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
       <script src="1-11-4-jquery-ui.min.js"></script>

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
