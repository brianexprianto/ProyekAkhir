<!DOCTYPE html>
<html>
<?php
include "configuration/config_include.php";
etc();encryption();session();connect();head();body();timing();
//alltotal();
//pagination();
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
                <!-- Content Header (Page header) -->
                <section class="content-header">
</section>
                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!-- ./col -->

<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "index"; // halaman
$dataapa = "Dashboard"; // data
$tabeldatabase = "index"; // tabel database
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$chmod = $chmenu1; // Hak akses Menu
$search = $_POST['search'];
?>

<!-- SETTING STOP -->
       <!-- BOX INFORMASI -->
    <?php
if ($_SESSION['jabatan'] == 'admin' || $chmod >= '1') {
  ?>

<!-- BREADCRUMB -->
<div class="col-lg-12">
<ol class="breadcrumb ">
<li><a href="#">Setting</a></li>
</ol>
</div>

<!-- BREADCRUMB -->

<?php
  if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = 1;
          $nama=  $_SESSION['nama'];
                  $avatar= $_SESSION['avatar'];
                  $tanggal = date('Y-m-d');
                  $isi= $_POST["isi"];

                  if(isset($_POST['simpan'])){

           $sql="select * from info";
                  $result=mysqli_query($conn,$sql);

              if(mysqli_num_rows($result)>0){

           $sql1 = "update info set nama='$nama', avatar='$avatar',tanggal='$tanggal', isi='$isi' where id='1'";
             $result = mysqli_query($conn, $sql1);

        }else{
                $sql1 = "insert into info values('$nama','$tanggal','$isi','$avatar','$id')";
              $result = mysqli_query($conn, $sql1);
        }
          }
  }


         ?>



 

                </div>


                 <!-- TIMER -->
<div id="counter" style="display: none;">3</div>
<script type="text/javascript">
function countdown() {
    var i = document.getElementById('counter');
    if (parseInt(i.innerHTML)<=0) {
        $('#loading').hide();
      clearInterval(counter);
   resetEverything();
   recognition.stop();
    }
    i.innerHTML = parseInt(i.innerHTML)-1;

}
setInterval(function(){ countdown(); },1000);
</script>
<!-- /.TIMER -->


<?php
//    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

      $nama=$avatar=$tanggal=$isi="";
      if($_SERVER["REQUEST_METHOD"] == "POST"){
                  $nama = $_SESSION['nama'];
                  $avatar = $_SESSION['avatar'];
                  $tanggal = date('Y-m-d');
                  $isi= $_POST["isi"];


    }

         $sql="select * from info";
                  $hasil2 = mysqli_query($conn,$sql);


                  while ($fill = mysqli_fetch_assoc($hasil2)){

          $nama = $fill["nama"];
                  $avatar = $fill["avatar"];
                  $tanggal = $fill["tanggal"];
                  $isi= $fill["isi"];


    }
    ?>



                <div class="row">
                <?php if($_SESSION['jabatan'] !='admin'){}else{ ?>
                <div class="col-lg-6">
               <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Pengumuman</h3>
            </div>
             <div class="overlay" id="loading">  <i class="fa fa-refresh fa-spin"></i></div>

                                <div class="box-body">

                            <form class="form-horizontal" method="post">
              <div class="box-body">

               <div class="form-group">
                <textarea class="textarea" name="isi" placeholder="<?php echo $isi;?>" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" value="<?php echo $ketentuane;?>"></textarea>

            </div>


              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-default pull-right btn-flat" name="simpan"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
              </div>
              <!-- /.box-footer -->
            </form>
     

                </div>

                                <!-- /.box-body -->

                            </div>
              </div>


  


              <div class="col-lg-6">
             <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="<?php  echo $avatar; ?>" alt="User Image">
                <span class="username"><?php  echo $nama; ?></span>
                <span class="description"><?php echo $tanggal; ?></span>
              </div>
              <!-- /.user-block -->
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- post text -->
              <?php echo $isi; ?>

            </div>
            <!-- /.box-body -->

          </div>
          <!-- /.box -->
            </div>

              <?php } ?>

                                <!-- /.box-body -->
                            </div>


                            
<!-- TIMER -->

<!-- /.TIMER -->

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
            <!-- BATAS -->
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
        <script src="dist/js/pages/dashboard.js"></script>
        <script src="dist/js/demo.js"></script>
    <script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="dist/plugins/fastclick/fastclick.js"></script>
    </body>
</html>
