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
$halaman = "report_labarugi"; // halaman
$dataapa = "Report"; // data
$tabeldatabase = "bayar"; // tabel database
$chmod = $chmenu9; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
$insert = $_POST['insert'];

 
?>


<!-- SETTING STOP -->


<!-- BREADCRUMB --

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

 BREADCRUMB -->

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
          <h3 class="box-title">Laporan Laba Rugi</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body" style="background-color:#D6EDEF">
          

<div class="row" >

                      <div class="col-sm-2">
                      <label for="usr">Periode Tanggal:</label>
                      
</div>

<div class="row" >

  <form method="POST" action="">

                      <div class="col-sm-3">
                     <input type="text" class="form-control" id="datepicker" name="dari" autocomplete="off" placeholder="dari Tanggal" >
                    </div>


                      <div class="col-sm-3">
                     <input type="text" class="form-control" id="datepicker2" name="sampai" autocomplete="off" placeholder="Sampai Tanggal" >
                    </div>

                    <div class="col-sm-3">
                    <button type="submit" name="rekap" class="btn btn-lg btn-primary">Submit</button>

                     </form>


                  

   


                    </div>
                    

                 


</div>




        </div>







                                <!-- /.box-body -->
                            </div>



<?php

if(isset($_POST["rekap"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

$dari = mysqli_real_escape_string($conn, $_POST["dari"]);
$sampai = mysqli_real_escape_string($conn, $_POST["sampai"]);

$sqlx="SELECT SUM(total) AS retail FROM bayar WHERE tglbayar BETWEEN '" . $dari . "' AND  '" . $sampai . "' ";
$hasilx=mysqli_query($conn,$sqlx);
$row=mysqli_fetch_assoc($hasilx);
$retail=$row['retail'];




$sqlx1="SELECT SUM(total) AS sales FROM sale WHERE tglsale BETWEEN '" . $dari . "' AND  '" . $sampai . "' ";
$hasilx1=mysqli_query($conn,$sqlx1);
$row=mysqli_fetch_assoc($hasilx1);
$totalsales=$row['sales'];

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



} }


if($dari==''){
$newdari ='Awal';
} else {
$newdari = date("d-m-Y", strtotime($dari));
}


$newsampai = date("d-m-Y", strtotime($sampai));


?>

<?php 
                   if(isset($_POST["rekap"])){

                    ?>


                        </div>

                        <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Ringkasan laba rugi (dibayar & belum dibayar) periode <?php echo $newdari;?> sampai <?php echo $newsampai;?></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body" style="background-color:#D6EDEF">
          

                    <div class="row" >

                      <div class="col-sm-3">
                      <label for="usr">Pemasukan</label>
                      
                    </div>

                   
                      <div class="col-sm-3">
                    <label for="usr">Biaya Barang terjual</label>
                    </div>


                      <div class="col-sm-3">
                    <label for="usr">Biaya Operasional:</label>
                    </div>

                    <div class="col-sm-3">
                    <label for="usr">Laba/Rugi Bersih</label>
                    </div>




                      <div class="col-sm-3">
                      <h2 >Rp. <?php echo $pemasukan;?> &nbsp;&nbsp;- </h2>
                     
                    </div>
                    <div class="col-sm-3">
                      <h2 >Rp. <?php echo $biaya;?>&nbsp;&nbsp;-</h2>
                    </div>
                    <div class="col-sm-3">
                   <h2 >Rp. <?php echo $cost;?>&nbsp;&nbsp;=</h2>
                    </div>
                    <div class="col-sm-3">
                      <h2 >Rp. <?php echo $net;?></h2>
                    </div>

                  



        </div>


    </div>
    <br>

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Detail</h3>&nbsp;&nbsp;<a href="labarugi?dari=<?php echo $dari;?>&sampai=<?php echo $sampai;?> " target="_blank" class="btn btn-success"><i class="fa fa-print"></i> Print</a>


          <div class="box-tools pull-right">
           
          </div>
        </div>
        <div class="box-body" >
          

<div class="col-lg-6" >

    <div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th style="width: 10px">#</th>
                  <th></th>
                  <th></th>
                
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Pendapatan retail</td>
                  <td> Rp. <?php echo number_format($retail);?>          
                  </td>
                  
                </tr>

                 <tr>
                  <td>2.</td>
                  <td>Pendapatan Non retail</td>
                  <td>Rp. <?php echo number_format($totalsales);?>          
                  </td>
                  
                </tr>

                 <tr>
                  <td>3.</td>
                  <td>Modal Penjualan</td>
                  <td>Rp. <?php echo number_format($biaya);?>         
                  </td>
                  
                </tr>

                 <tr style="background-color:#D6EDEF">
                  <td></td>
                  <td><strong><h4>Gross Profit</h4></strong></td>
                  <td>  <h4>Rp. <?php echo number_format($gross1);?></h4>                 
                  </td>
                  
                </tr>

                <tr style="background-color:#D6EDEF" >
                  <td></td>
                  <td>Persentase terhadap total pendapatan</td>
                  <td> <h4><?php echo number_format($prctg1);?> %</h4>                   
                  </td>
                  
                </tr>

                 <tr>
                  <td>4.</td>
                  <td>Biaya Operasional</td>
                  <td>Rp. <?php echo number_format($cost);?>                   
                  </td>
                  
                </tr>

                 <tr style="background-color:#D6EDEF">
                  <td></td>
                  <td><strong><h4>Net Profit</h4></strong></td>
                  <td><h4>Rp <?php echo number_format($net);?> </h4>                    
                  </td>
                  
                </tr>

                <tr style="background-color:#D6EDEF" >
                  <td></td>
                  <td>Persentase terhadap total pendapatan</td>
                  <td><h4><?php echo $prctg2;?> %</h4>                    
                  </td>
                  
                </tr>
                
              </table>
            </div>

</div>



<div class="col-lg-6" >

<div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Tipe Pengeluaran</th>
                  <th>Jumlah</th>
                  <th style="width: 40px">%</th>
                </tr>
<?php 
  
  $no = 1;
  while ($fill = mysqli_fetch_array($operasional)){
?>

                <tr>
                  <td><?php echo ++$no;?></td>
                  <td><?php echo $fill['tipe'];?></td>
                  <td>
                   <?php echo number_format($fill['cost']);?>
                  </td>
                  <td><span class="badge bg-red">
                    <?php $persen = $fill['cost'];
                  echo ROUND(($persen/$cost),2) * 100;
                  ?>%
                    
                  </span></td>
                </tr>

              <?php } ?>
                
              </table>
            </div>

</div>






        </div>



<?php } ?>





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
