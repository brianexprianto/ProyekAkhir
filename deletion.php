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
$halaman = "deletion"; // halaman
$dataapa = "Penghapusan"; // data

$chmod = 5; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$kode = $_GET['k'];
$tabel = $_GET['f'];
$next = $_GET['page'];


 
?>


<!-- SETTING STOP -->


<!-- BREADCRUMB -->

<ol class="breadcrumb ">
<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
<li><a href="<?php echo $next;?>"><?php echo $tabel ?></a></li>
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

                         <?php if($tabel=='barang'){?>
                         <div class="col-lg-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Konfirmasi Penghapusan</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <b>Apakah anda yakin untuk menghapus data <?php echo $tabel;?> ini?</b>


            <div class="box-footer">
                <form method="post">

                <input type="hidden" name="tabel" value="<?php echo $tabel;?>">
                 <input type="hidden" name="next" value="<?php echo $next;?>">
                  <input type="hidden" name="kode" value="<?php echo $kode;?>">


                 <button type="button" class="btn btn-secondary" onclick="window.location.href='<?php echo $next;?>'">Kembali</button>
                <button type="submit" name="produk" class="btn btn-danger pull-right">YA, HAPUS</button>

            </form>
            </div>

        </div>

                                <!-- /.box-body -->
                            </div>
                        </div>
                <?php } else if($tabel=='supplier'){?>
                     <div class="col-lg-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Konfirmasi Penghapusan</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <b>Apakah anda yakin untuk menghapus data <?php echo $tabel;?> ini?</b>


           

            <div class="box-footer">
                <form method="post">

                <input type="hidden" name="tabel" value="<?php echo $tabel;?>">
                 <input type="hidden" name="next" value="<?php echo $next;?>">
                  <input type="hidden" name="kode" value="<?php echo $kode;?>">


                 <button type="button" class="btn btn-secondary" onclick="window.location.href='<?php echo $next;?>'">Kembali</button>
                <button type="submit" name="vendor" class="btn btn-danger pull-right">YA, HAPUS</button>

            </form>
            </div>

        </div>

                                <!-- /.box-body -->
                            </div>
                        </div>
                <?php } else if($tabel=='pelanggan'){ ?>

                     <div class="col-lg-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Konfirmasi Penghapusan</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <b>Apakah anda yakin untuk menghapus data <?php echo $tabel;?> ini?</b>


           

             <div class="box-footer">
                <form method="post">

                <input type="hidden" name="tabel" value="<?php echo $tabel;?>">
                 <input type="hidden" name="next" value="<?php echo $next;?>">
                  <input type="hidden" name="kode" value="<?php echo $kode;?>">
                  
                <button type="button" class="btn btn-secondary" onclick="window.location.href='<?php echo $next;?>'">Kembali</button>
                <button type="submit" name="customer" class="btn btn-danger pull-right">YA, HAPUS</button>

            </form>
            </div>

        </div>

                                <!-- /.box-body -->
                            </div>
                        </div>

                <?php } ?>





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



<!--PHP -->


<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){


$kode = mysqli_real_escape_string($conn, $_POST["kode"]);
$next = mysqli_real_escape_string($conn, $_POST["next"]);
$tabel = mysqli_real_escape_string($conn, $_POST["tabel"]);

//hapus barang
if(isset($_POST['produk'])){

$a=mysqli_query($conn,"DELETE buy,invoicebeli FROM invoicebeli INNER JOIN buy ON buy.nota=invoicebeli.nota WHERE invoicebeli.kode='$kode'");
$b=mysqli_query($conn,"DELETE retur,dataretur FROM dataretur INNER JOIN retur ON retur.nota=dataretur.nota WHERE dataretur.kode='$kode'");

$c=mysqli_query($conn,"DELETE bayar,transaksimasuk FROM transaksimasuk INNER JOIN bayar ON bayar.nota=transaksimasuk.nota WHERE transaksimasuk.kode='$kode'");
$d=mysqli_query($conn,"DELETE sale,invoicejual FROM invoicejual INNER JOIN sale ON sale.nota=invoicejual.nota WHERE invoicejual.kode='$kode'");

$e=mysqli_query($conn,"DELETE FROM $tabel WHERE kode='$kode'");

 echo "<script type='text/javascript'>window.location = '$next?delete=1';</script>";


}


//hapus supplier
if(isset($_POST['vendor'])){

$a=mysqli_query($conn,"DELETE buy,invoicebeli FROM buy INNER JOIN invoicebeli ON invoicebeli.nota=buy.nota WHERE buy.supplier='$kode'");
$e=mysqli_query($conn,"DELETE FROM $tabel WHERE kode='$kode'");

 echo "<script type='text/javascript'>window.location = '$next?delete=1';</script>";

}


//hapus barang
if(isset($_POST['customer'])){

$a=mysqli_query($conn,"DELETE sale,invoicejual,payment FROM sale INNER JOIN invoicejual ON invoicejual.nota=sale.nota INNER JOIN payment ON payment.nota=sale.nota WHERE sale.pelanggan='$kode'");

$e=mysqli_query($conn,"DELETE FROM $tabel WHERE kode='$kode'");

 echo "<script type='text/javascript'>window.location = '$next?delete=1';</script>";

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
