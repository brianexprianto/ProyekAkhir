<!DOCTYPE html>
<html>
<?php
include "configuration/config_include.php";
include "configuration/config_alltotal.php";
include "configuration/config_connect.php";

;encryption();session();connect();head();body();timing();
//pagination();
?>
<?php
        $decimal ="0";
        $a_decimal =",";
        $thousand =".";
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
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING) );
$halaman = "index"; // halaman
$dataapa = "Dashboard"; // data
$tabeldatabase = "index"; // tabel database
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman

//$search = $_POST['search'];
// hak tampil dashboard

$jabatan = $_SESSION['jabatan'];
$sqlnya="SELECT * FROM chmenu where userjabatan = '$jabatan'";
$hasilnya= mysqli_query($conn,$sqlnya);
  if(mysqli_num_rows($hasilnya)>0){
    $rownya=mysqli_fetch_assoc($hasilnya);
    $hak=$rownya['menu1']; //user

  }


?>

<!-- SETTING STOP -->


<!-- BREADCRUMB -->
<div class="col-lg-12">
<ol class="breadcrumb ">
<li><a href="#">Dashboard </a></li><span class="badge bg-light-blue pull-right"> <?php echo $today;?> </span>
</ol>
</div>

<!-- BREADCRUMB -->




                                <!-- /.box-body -->

                        <!-- ./col -->

                </div>

<?php if($_SESSION['jabatan'] !='admin'){}else{ ?>

 <div class="row">
<?php

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$alert = $_GET['alert'];

$sql1="SELECT url FROM backset";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $url=$row['url'];
if ($alert == 1 && $url =='http://localhost/tokonabila'){
?>


<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                
              </button>
              </div>

   <?php } else {?>            
                   

                         <div class="col-lg-3 col-xs-6">
                           <!-- small box -->
                           <div class="small-box bg-aqua">
                               <div class="inner">
                                   <h3><?php echo $datax1; ?></h3>
                                   <p>Pegawai</p>
                               </div>
                               <div class="icon">
                                   <i class="ion ion-person"></i>
                               </div>
                                 <a href="admin" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                           </div>
                       </div>

                       <div class="col-lg-3 col-xs-6">
                         <!-- small box -->
                         <div class="small-box bg-green">
                             <div class="inner">
                                 <h3><?php echo $datax2; ?></h3>
                                 <p>Supplier</p>
                             </div>
                             <div class="icon">
                                 <i class="ion ion-person"></i>
                             </div>
                               <a href="supplier" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                         </div>
                     </div>

                     <div class="col-lg-3 col-xs-6">
                       <!-- small box -->
                       <div class="small-box bg-yellow">
                           <div class="inner">
                               <h3><?php echo $datax3; ?></h3>
                               <p>Barang</p>
                           </div>
                           <div class="icon">
                               <i class="glyphicon glyphicon-blackboard"></i>
                           </div>
                             <a href="barang" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                       </div>
                   </div>

                   <div class="col-lg-3 col-xs-6">
                     <!-- small box -->
                     <div class="small-box bg-red">
                         <div class="inner">
                             <h3><?php echo $datax4; ?></h3>

                             <?php
                             $sql= "SELECT batas from backset";
                              $hasilx2=mysqli_query($conn,$sql);
                              $row=mysqli_fetch_assoc($hasilx2);
                              $alert = $row['batas'];

                             ?>
                             <p>Barang dengan Stok dibawah minimal</p>
                         </div>
                         <div class="icon">
                             <i class="glyphicon glyphicon-folder-close"></i>
                         </div>
                           <a href="stok_menipis" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                     </div>
                 </div>



                     </div>

<?php } } ?>


<?php
if ($_SESSION['jabatan'] != 'admin') {
  

 // $sql="select * from info";
 //                  $hasil2 = mysqli_query($conn,$sql);


 //                  while ($fill = mysqli_fetch_assoc($hasil2)){

 //          $nama = $fill["nama"];
 //                  $avatar = $fill["avatar"];
 //                  $tanggal = $fill["tanggal"];
 //                  $isi= $fill["isi"];


 //    }
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$alert = $_GET['alert'];

$sql1="SELECT url FROM backset";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $url=$row['url'];
if ($url =='http://localhost/tokonabila'){
?>

<div class="row">
 <!-- Left col -->
        <div class="col-lg-3 col-xs-6">
                         
                         <div class="small-box bg-green">
                             <div class="inner">
                                 <h3><?php echo $datax2; ?></h3>
                                 <p>Supplier</p>
                             </div>
                             <div class="icon">
                                 <i class="ion ion-person"></i>
                             </div>
                               <a href="supplier" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                         </div>
                     </div>

                     <div class="col-lg-3 col-xs-6">
                       <!-- small box -->
                       <div class="small-box bg-yellow">
                           <div class="inner">
                               <h3><?php echo $datax3; ?></h3>
                               <p>Barang</p>
                           </div>
                           <div class="icon">
                               <i class="glyphicon glyphicon-blackboard"></i>
                           </div>
                             <a href="barang" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                       </div>
                   </div>

                   <div class="col-lg-3 col-xs-6">
                     <!-- small box -->
                     <div class="small-box bg-red">
                         <div class="inner">
                             <h3><?php echo $datax4; ?></h3>

                             <?php
                             $sql= "SELECT batas from backset";
                              $hasilx2=mysqli_query($conn,$sql);
                              $row=mysqli_fetch_assoc($hasilx2);
                              $alert = $row['batas'];

                             ?>
                             <p>Barang dengan Stok dibawah minimal</p>
                         </div>
                         <div class="icon">
                             <i class="glyphicon glyphicon-folder-close"></i>
                         </div>
                           <a href="stok_menipis" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                     </div>

      </div>
    <?php } } ?>


<!-- Awal tabel  -->

<div class="row">
 <!-- Left col -->

        <section class="col-lg-6 connectedSortable">
          
          <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">5 Barang dengan Stok paling banyak <span class="badge bg-green">dari  #<?php echo $stok1;?> di gudang</span></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                 
               <thead>
<?php
          $mySql  = "SELECT nama,sisa FROM barang ORDER BY sisa DESC LIMIT 5";
          $myQry  = mysqli_query($conn, $mySql)  or die ("Query  salah : ".mysqli_error());
          $nomor  = 0; 
          
            
          ?>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Barang</th>
                  <th>Stok</th>
                  <th style="width: 40px">Persentase</th>
                </tr>
                </thead>
         <?php       while ($kolomData = mysqli_fetch_array($myQry)) {
            $nomor++;  ?>
                <tbody>
                      <tr>
               <td><?php echo $nomor; ?></td>
              <td><?php echo $kolomData['nama']; ?></td>
              <td><?php echo $kolomData['sisa']; ?></td>
              <td><span class="badge bg-red"><?php echo round((($kolomData['sisa']/$stok1)*100),2); ?></span></td>
              
            </tr>
           </tbody>
           <?php } ?>
  

                 
              </table>
            </div>
            <!-- /.box-body -->
            
          </div>
          <!-- /.box -->
          <!-- /.box -->

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-6 connectedSortable">

         <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">5 Barang Keluar Terbanyak <span class="badge bg-red">dari  #<?php echo $stok2;?> keluar</span></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                 
               <thead>
<?php
          $mySql  = "SELECT nama,terjual FROM barang ORDER BY terjual DESC LIMIT 5";
          $myQry  = mysqli_query($conn, $mySql)  or die ("Query  salah : ".mysqli_error());
          $nomor  = 0; 
          
            
          ?>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Barang</th>
                  <th>Terjual</th>
                  <th style="width: 40px">Persentase</th>
                </tr>
                </thead>
         <?php       while ($kolomData = mysqli_fetch_array($myQry)) {
            $nomor++;  ?>
                <tbody>
                      <tr>
               <td><?php echo $nomor; ?></td>
              <td><?php echo $kolomData['nama']; ?></td>
              <td><?php echo $kolomData['terjual']; ?></td>
              <td><span class="badge bg-light-blue"><?php echo round((($kolomData['terjual']/$stok2)*100),2); ?></span></td>
              
            </tr>
           </tbody>
           <?php } ?>
  

                 
              </table>

              

            </div>
            <!-- /.box-body -->
           
          <!-- /.box -->
          <!-- /.box -->

        </section>
        <!-- right col -->


     
</div>



<!-- akhir tabel -->
<?php
if ($_SESSION['jabatan'] == 'admin' || $hak >='1') {?>
<!-- Awal Chart  -->



<!-- akhir chart -->

<?php } ?>

<!-- awal tabel -->
<div class="row">
 <!-- Left col -->
        <section class="col-lg-12 connectedSortable">


          </section>


        </div>


        <!-- akhir tabel -->
                                <!-- /.box-body -->
                            </div>

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








             <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
               
              </div>

                <form method="post" >
              <div class="modal-body">
                

                

                 <div class="form-group">
                  

                  <div class="col-sm-5">
                    <input type="text" class="form-control" name="url" placeholder="idwares.esy.es">
                  </div>
                </div>

              </div>


              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" name="save" class="btn btn-primary">Save changes</button>
              </div>
            </div>

          </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
 <?php


if(isset($_POST['save'])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

         $url = mysqli_real_escape_string($conn, $_POST['url']);

         $sqlu = "UPDATE backset SET url='$url' ";
         $query = mysqli_query($conn, $sqlu);


         if($query){
           echo "<script type='text/javascript'>  alert('Berhasil, Url Aplikasi telah diubah!'); </script>";
             echo "<script type='text/javascript'>window.location = 'index';</script>";
         }

       } }

        ?>


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
