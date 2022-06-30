<!DOCTYPE html>
<html>
<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
include "configuration/config_alltotal.php";
etc();encryption();session();connect();head();body();timing();
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
                <section class="content">
                  

<div class="container-fluid">
<div class="col-md-12">
                    <div class="box box-success">
                      <div class="box-body">

 <!-- form start -->
            <form class="form-horizontal" method="post" action="report_belii.php" >
            <div class="row">

                 <label for="tahun" class="col-sm-1 control-label">Dari</label>
                 <div class="col-sm-2">
                         <input type="text" class="form-control" id="datepicker" name="dari" autocomplete="off" placeholder="Dari">
                  </div>
                                                
                
                  <label for="bulan" class="col-sm-1 control-label">Sampai</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="datepicker2" name="sampai">
                  
                </div>
<div class="col-sm-2">
                
                <button type="submit" name="filter" class="btn btn-info pull-right">Filter</button>
              </div>
                
            
              
              <!-- /.box-footer -->
</div>
            </form>

                      </div>
                  </div>
              </div>



<?php
 if(isset($_POST['filter'])){

  $dr = $_POST['dari'];
$sam = $_POST['sampai'];

 } else {
  $dr=date('Y-m-d');
  $sam=date('Y-m-d');

 }

  $sqlb="SELECT SUM(total) AS data, SUM(keluar) as hpp FROM bayar WHERE tglbayar BETWEEN '" . $dr . "' AND  '" . $sam . "'";
$hasila=mysqli_query($conn,$sqlb);
$rowa=mysqli_fetch_assoc($hasila);
$totalbay=$rowa['data'];
$hpp=$rowa['hpp'];
$incom=$totalbay-$hpp;




if($dr!=''){

   $dari=date("d-m-Y",strtotime($dr));
} else {
  $dari="Awal";
}


 $sampe=date("d-m-Y",strtotime($sam));

 

?>



<section class="col-lg-12 connectedSortable">
 <div class="box">
       
        <div class="box-body">
           <table class="table table-bordered">
                <tr>
                 
                  <th>Periode</th>
                  <th>Total Penjualan </th>
                  <th >Harga Pokok Penjualan (HPP)</th>
                     <th >Pemasukan</th>
                </tr>
                <tr>
                  
                  <td><?php echo $dari;?> - <?php echo $sampe;?></td>
                  <td>
                    
                    <?php echo number_format($totalbay);?>
                 
                  </td>
                  <td>  <?php echo number_format($hpp);?></td>
                  <td>  <?php echo number_format($incom);?></td>
                </tr>
                
              </table>
        </div>
      </div>
    </section>







</div>
                    <div class="row">
            <div class="col-lg-12">

              <!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "report_trxjual"; // halaman
$dataapa = "Laporan Transaksi Penjualan"; // data
$tabeldatabase = "stok_masuk_daftar"; // tabel database
$chmod = $chmenu9; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman


?>

<!-- SETTING STOP -->

<textarea id="printing-css" style="display:none;">.no-print{display:none}</textarea>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
<script type="text/javascript">
function printDiv(elementId) {
 var a = document.getElementById('printing-css').value;
 var b = document.getElementById(elementId).innerHTML;
 window.frames["print_frame"].document.title = document.title;
 window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
 window.frames["print_frame"].window.focus();
 window.frames["print_frame"].window.print();
}
</script>

<!-- BREADCRUMB -->


<!-- BOX HAPUS BERHASIL -->

         <script>
 window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 5000);
</script>


       <!-- BOX INFORMASI -->
    <?php
if ($chmod == '1' || $chmod == '2' || $chmod == '3' || $chmod == '4' || $chmod == '5' || $_SESSION['jabatan'] == 'admin') {
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
if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') {
?>

<?php
if($bulan == null || $search == "" ){
        $sqla="SELECT no, COUNT( * ) AS totaldata FROM $forward";
      }else{

        $sqla="SELECT s.no, COUNT( s.* ) AS totaldata, t.* FROM $forward s left join stok_masuk t on s.nota=t.nota WHERE tgl BETWEEN '" . $dr . "' AND  '" . $sam . "' or kasir like '%$search%'";
      }
    $hasila=mysqli_query($conn,$sqla);
    $rowa=mysqli_fetch_assoc($hasila);
    $totaldata=$rowa['totaldata'];

?>



          <div class="box" id="tabel1">

            <div class="box-header">
          
            <h3 class="box-title">Data <?php echo $dataapa ?>  <?php echo $dari;?> - <?php echo $sampe;?> <span class="no-print label label-default" id="no-print"><?php echo $totaldata; ?></span>
          </h3>
       

           <?php if($totalinv !='' || $totalinv !=null){?>
          <span class="no-print pull-right" id="no-print"> <?php echo 'Total Penjualan pada <b>'.$namabulan.'</b> '.$tahun.' sejumlah <b>Rp '.number_format($totalinv, $decimal, $a_decimal, $thousand).',-</b>'; ?></span>
        <?php } ?>

        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          
            <div class="box-header with-border">
                          </div>
            <!-- /.box-header -->
           
          </div>
          <!-- /.box -->


            </div>

                                <!-- /.box-header -->
                                  <!-- /.Paginasi -->
                                 <?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    if(isset($sam)){
    $sql    = "select * from stok_masuk_daftar s left join stok_masuk t on s.nota=t.nota WHERE tglbayar BETWEEN '" . $dr . "' AND  '" . $sam . "' order by no desc";
  } else {
      $sql    = "select * from stok_masuk_daftar s left join stok_masuk t on s.nota=t.nota ";
  }
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
                                    <table class="table table-hover ">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>No Nota</th>
                                              <th>Tanggal</th>
                                              <th>Jumlah Item</th>
                                              <th>Total Tagihan</th>
                                              <th>Uang Bayar</th>
                                              <th>Uang Kembali</th>
                                              <th>Cc</th>
                        <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                                                <th class="no-print">Opsi</th>
                        <?php }else{} ?>
                                            </tr>
                                        </thead>
                                          <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    $search = $_POST['search'];

    if ($bulan != null || $bulan != "") {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

              if(isset($_POST['bulan'])){
        $query1="SELECT * FROM  stok_masuk  where YEAR(tgl) like '%$tahun%' AND MONTH(tgl) like '%$bulan%' order by nota limit $rpp";
        $hasil = mysqli_query($conn,$query1);
        $no = 1;
        while ($fill = mysqli_fetch_assoc($hasil)){
          ?>
                     <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['tgl']); ?></td>
  <?php
$nota = $fill['nota'];
$sqle="SELECT COUNT( nota ) AS data FROM stok_masuk WHERE nota ='$nota'";
$hasile=mysqli_query($conn,$sqle);
$rowa=mysqli_fetch_assoc($hasile);
$jumlahbayar=$rowa['data'];

$jml= " SELECT SUM(jumlah) tot_jual FROM transaksimasuk WHERE nota ='$nota'"  ;
$hasil1=mysqli_query($conn,$jml);
$row1=mysqli_fetch_array($hasil1);
$jmljual=$row1['tot_jual'];
   ?>
   <td><?php  echo mysqli_real_escape_string($conn, $jmljual); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $jumlahbayar); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['total'])); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['bayar'])); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['kembali'])); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
  <td>
  <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
    <button type="button" class="btn btn-info btn-xs no-print" onclick="window.location.href='stok_detail?id=1&trx=1&nota=<?php  echo $fill['nota']; ?>'">Detail</button>
 <?php } else {}?>

    </td></tr><?php
          ;
        }

        ?>
                  </tbody></table>
 <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>
     <?php
      }

    }

  } else {
    while(($count<$rpp) && ($i<$tcount)) {
      mysqli_data_seek($result,$i);
      $fill = mysqli_fetch_array($result);
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

$jml= " SELECT SUM(jumlah) tot_jual FROM transaksimasuk WHERE nota ='$nota'"  ;
$hasil1=mysqli_query($conn,$jml);
$row1=mysqli_fetch_array($hasil1);
$jmljual=$row1['tot_jual'];
   ?>
   
  <td><?php  echo mysqli_real_escape_string($conn, $jmljual); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['total'])); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['bayar'])); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['kembali'])); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
  <td>
  <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
    <button type="button" class="btn btn-info btn-xs no-print" onclick="window.location.href='stok_detail?id=1&trx=1&nota=<?php  echo $fill['nota']; ?>'">Detail</button>
 <?php } else {}?>

    </td></tr>
      <?php
      $i++;
      $count++;
    }

    ?>
                  </tbody></table>
          <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>
  <?php } ?>

                               </div>
                                <!-- /.box-body -->

                            </div>

              <?php } else {} ?>

              <div align="right"  style="padding-right:15px"  class="no-print" id="no-print" >
             <div align="left" class="no-print" id="no-print"> <a onclick="javascript:printDiv('tabel1');" class="btn btn-default btn-flat" name="cetak" value="cetak"><span class="glyphicon glyphicon-print"></span></a><?php echo " "; ?>
               <a onclick="window.location.href='configuration/config_export?forward=<?php echo $forward; ?>&search=<?php echo $search; ?>'" class="btn btn-default btn-flat" name="cetak" value="export excel"><span class="glyphicon glyphicon-save-file"></span></a></div> <br/>
             </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                    </div>
                    <!-- /.row (main row) -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
           <?php footer();?>
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
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


  <!-- ChartJS 1.0.1 -->
<script src="dist/plugins/chartjs/Chart.min.js"></script>



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
