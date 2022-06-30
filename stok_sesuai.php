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
$halaman = "stok_sesuai"; // halaman
$dataapa = "Penyesuaian Stok"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu8; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
$insert = $_POST['insert'];

 function autoNumber(){
  global $forward;
  $query = "SELECT MAX(RIGHT(kode, 4)) as max_id FROM $forward ORDER BY kode";
  $result = mysql_query($query);
  $data = mysql_fetch_array($result);
  $id_max = $data['max_id'];
  $sort_num = (int) substr($id_max, 1, 4);
  $sort_num++;
  $new_code = sprintf("%04s", $sort_num);
  return $new_code;
 }
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

    $kode=$nama=$terjual=$terbeli=$sisa="";
    $no = $_GET["no"];
    $insert = '1';



    if(($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')){

         $sql="select * from $tabeldatabase where no='$no'";
                  $hasil2 = mysqli_query($conn,$sql);


                  while ($fill = mysqli_fetch_assoc($hasil2)){


          $kode = $fill["kode"];
          $nama = $fill["nama"];
          $terjual = $fill["terjual"];
          $terbeli = $fill["terbeli"];
          $sisa = $fill["sisa"];
                  $insert = '3';

    }
    }
    ?>

  <div id="main">
   <div class="container-fluid">

          <form class="form-horizontal" method="post" action="<?php echo $halaman; ?>" id="Myform">
              <div class="box-body">

                <div class="row">
                        <div class="form-group col-md-6 col-xs-12" >
                          <label for="kode" class="col-sm-3 control-label">Kode:</label>
                          <div class="col-sm-9">
                            <select class="form-control select2" style="width: 100%;" name="kode" id="kode">
                              <option></option>
                     <?php
               $sql=mysqli_query($conn,"select * from barang");
               while ($row=mysqli_fetch_assoc($sql)){
                 if ($kode==$row['kode'])
                 echo "<option value='".$row['kode']."' nama='".$row['nama']."' terjual='".$row['terjual']."' terbeli='".$row['terbeli']."' sisa='".$row['sisa']."' selected='selected'>".$row['kode']." | ".$row['nama']."</option>";
                 else
                 echo "<option value='".$row['kode']."' nama='".$row['nama']."' terjual='".$row['terjual']."'  terbeli='".$row['terbeli']."' sisa='".$row['sisa']."' >".$row['kode']." | ".$row['nama']."</option>";
               }
             ?>
                            </select>
                  </div>
                        </div>
                </div>

        <div class="row">
           <div class="form-group col-md-6 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Nama:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" maxlength="100" readonly>
                  </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-6 col-xs-12" >
                  <label for="terbeli" class="col-sm-3 control-label">Terbeli:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="terbeli" name="terbeli" value="<?php echo $terbeli; ?>" placeholder="Masukan Stok Terbeli" maxlength="50" onkeyup="sum();">
                  </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-6 col-xs-12" >
                  <label for="terjual" class="col-sm-3 control-label">Terjual:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="terjual" name="terjual" value="<?php echo $terjual; ?>" placeholder="Masukan Stok Terjual" maxlength="50" onkeyup="sum();">
                  </div>
                </div>
        </div>

        <script>
       function sum() {
             var txtFirstNumberValue =  document.getElementById('terbeli').value
             var txtSecondNumberValue = document.getElementById('terjual').value;
             var result = parseFloat(txtFirstNumberValue) - parseFloat(txtSecondNumberValue);
             if (!isNaN(result)) {
                document.getElementById('sisa').value = result;
             }
           if (!$(terjual).val()){
             document.getElementById('sisa').value = "0";
           }
           if (!$(terbeli).val()){
             document.getElementById('sisa').value = "0";
           }
       }
       </script>

        <div class="row">
           <div class="form-group col-md-6 col-xs-12" >
                  <label for="sisa" class="col-sm-3 control-label">Sisa:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sisa" name="sisa" value="<?php echo $sisa; ?>" maxlength="50" readonly>
                  </div>
                </div>
        </div>
        
        <input type="hidden" class="form-control" id="selisih" name="selisih" value="<?php echo $selisih; ?>" >


      <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert;?>" maxlength="1" >


              </div>
              <!-- /.box-body -->
              <div class="box-footer" >
                <button type="submit" class="btn btn-default pull-left btn-flat" name="simpan" onclick="document.getElementById('Myform').submit();" ><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
              </div>
              <!-- /.box-footer -->


 </form>
</div>


    <?php

        if(isset($_POST["simpan"])){

       if($_SERVER["REQUEST_METHOD"] == "POST"){

              $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
              $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
              $terjual = mysqli_real_escape_string($conn ,$_POST["terjual"]);
              $terbeli = mysqli_real_escape_string($conn, $_POST["terbeli"]);
              $selisih = mysqli_real_escape_string($conn, $_POST["selisih"]);
              $sisa = mysqli_real_escape_string($conn, $_POST["sisa"]);
              $jumlah = $selisih - $sisa ;
              $kasir = $_SESSION["username"];
              $kegiatan = "menyesuaikan stok secara manual";
              $status = "berhasil";
              $keterangan = "tidak tersedia";
                          $insert = ($_POST["insert"]);


              if(($chmod >= 3 || $_SESSION['jabatan'] == 'admin')&&($sisa >='0')){
                      $sql1 = "update $tabeldatabase set terjual='$terjual', terbeli='$terbeli', sisa='$sisa' where kode='$kode'";
                      $updatean = mysqli_query($conn, $sql1);
                      $sql2= "INSERT INTO mutasi values ( '$kasir','$today','$kode','$sisa','$jumlah','$kegiatan','$keterangan','','$status')";
                      $updatean2 = mysqli_query($conn, $sql2);

                      echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
                      echo "<script type='text/javascript'>window.location = 'stok_sesuai';</script>";
              }if($sisa = '0'){
                  $sql2= "update $tabeldatabase set deposit=terbeli*hargabeli";
                      $updatean2 = mysqli_query($conn, $sql2);

                     echo "<script type='text/javascript'>  alert('Belum ada pemakaian, Update jika sudah ada!');</script>";
              
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
<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
         <script src="1-11-4-jquery-ui.min.js"></script>
        <script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script>
$("#kode").on("change", function(){

  var nama = $("#kode option:selected").attr("nama");
  var terjual = $("#kode option:selected").attr("terjual");
  var terbeli = $("#kode option:selected").attr("terbeli");
  var sisa = $("#kode option:selected").attr("sisa");
  var selisih = $("#kode option:selected").attr("terbeli") - $("#kode option:selected").attr("terjual");

  $("#nama").val(nama);
  $("#terjual").val(terjual);
  $("#terbeli").val(terbeli);
  $("#sisa").val(sisa);
  $("#selisih").val(selisih);
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
