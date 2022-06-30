<!DOCTYPE html>
<html>
<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
include "configuration/config_alltotal.php";
etc();encryption();session();connect();head();body();timing();
//alltotal();
pagination();
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
                <section class="content-header">
</section>
                <section class="content">
                    <div class="row">
                      <div class="col-lg-12">
<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "pembelian"; // halaman
$dataapa = "Invoice Pembelian"; // data
$tabeldatabase = "buy"; // tabel database
$tabel = "invoicebeli"; // tabel database
$chmod = $chmenu5; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];

?>

<!-- SETTING STOP -->
<?php
$decimal ="0";
$a_decimal =",";
$thousand =".";
$today=date('Y-m-d');
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
<!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 style="font-size: 30px"><sup style="font-size: 20px">Rp</sup><?php echo number_format($inv11, $decimal, $a_decimal, $thousand);?></h3>

              <p>Total Pembelian</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="pembelian" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 style="font-size: 30px"><sup style="font-size: 20px">Rp</sup><?php echo number_format($inv12, $decimal, $a_decimal, $thousand);?></h3>

              <p>Total Dibayar</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
               <form align="center" method="post" action="pembelian.php">  <button style="background-color: Transparent;border: none;" type="submit" name="search" value="dibayar" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></button>    </form>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 style="font-size: 30px"><sup style="font-size: 20px">Rp</sup><?php echo number_format($inv13, $decimal, $a_decimal, $thousand);?></h3>

              <p>Hutang/Belum Dibayar</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
             <form align="center" method="post" action="pembelian.php">  <button style="background-color: Transparent;border: none;" type="submit" name="search" value="hutang" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></button>    </form>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 style="font-size: 30px"><sup style="font-size: 20px">Rp</sup><?php echo number_format($inv15, $decimal, $a_decimal, $thousand);?></h3>

              <p>Tagihan Jatuh Tempo</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
             <form align="center" method="post" action="pembelian.php">  <button style="background-color: Transparent;border: none;" type="submit" name="search" value="<?php echo $today;?>" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></button>    </form>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

<!-- BOX HAPUS BERHASIL -->

         <script>
 window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 5000);
</script>

                            <?php
$hapusberhasil = $_POST['hapusberhasil'];

if ($hapusberhasil == 1) {
?>
    <div id="myAlert"  class="alert alert-success alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Berhasil!</strong> <?php echo $dataapa;?> telah berhasil dihapus dari Data <?php echo $dataapa;?>.
</div>

<!-- BOX HAPUS BERHASIL -->
<?php
} elseif ($hapusberhasil == 2) {
?>
           <div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Berhasil!</strong> <?php echo $dataapa;?> tidak bisa dihapus dari Data <?php echo $dataapa;?> karena telah melakukan transaksi sebelumnya, gunakan menu update untuk merubah informasi <?php echo $dataapa;?> .
</div>
<?php
} elseif ($hapusberhasil == 8) {
?>
           <div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Berhasil!</strong> <?php echo $dataapa;?> telah berhasil diupdate status barangnya, pastikan jangan terima bila barang rusak dan jangan konfirmasi bila belum terima barang!
</div>
<?php
} elseif ($hapusberhasil == 3) {
?>
           <div id="myAlert" class="alert alert-danger alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Gagal!</strong> Hanya user tertentu yang dapat mengupdate Data <?php echo $dataapa;?> .
</div>
<?php
}

?>
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

        $sqla="SELECT no, COUNT( * ) AS totaldata FROM $forward";
        $hasila=mysqli_query($conn,$sqla);
        $rowa=mysqli_fetch_assoc($hasila);
        $totaldata=$rowa['totaldata'];

?>
   <div class="box" id="tabel1">

            <div class="box-header">
            <h3 class="box-title">Data <?php echo $dataapa ?>  <span class="no-print label label-default" id="no-print"><?php echo $totaldata; ?></span>
          </h3> &nbsp;&nbsp;
 <div class="col-lg-12 col-md-12 col-sm-12 no-print">
          <form method="post">

  <div class="col-lg-3 col-md-3 col-sm-3">
                 

</div>

 </form>
         

  <div class="col-lg-3 col-md-3 col-sm-3">
                <form method="post">

                <div class="input-group input-group-sm" style="width: 100%;">
                  <input type="text" name="search" class="form-control pull-right" placeholder="Cari">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                  </div>
</form>
</div>


<div class="col-lg-3 col-md-3 col-sm-3">
<!-- isi -->
</div>


<?php

$sqlw=mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(nota) as nt, SUM(totalbeliakhir) as tt FROM pembelian WHERE cabang LIKE '%$cab%' AND status LIKE '%hutang%'"));

?>

<div class="col-lg-6 col-md-6 col-sm-6">
  
                    <div class="well well-sm">
                    Barang yang telah dibeli harus diproses dan diterima dulu sebelum masuk kedalam data stok
                </div>
                  
</div>
                </div>


                                <!-- /.box-header -->
                                  <!-- /.Paginasi -->
                                 <?php
    error_reporting(E_ALL ^ E_DEPRECATED );
    $sql    = "select * from buy inner join supplier on buy.supplier=supplier.kode order by buy.nota desc";
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
                                                <th>Nota</th>
                                                <th>Due Date</th>
                                                <th>Supplier</th>
                                                <th>Total</th>
                                                <th>Kasir</th>
                                                <th>Status</th>
                                                <th>Penerima</th>
                                                <?php   if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                                                <th>Opsi</th>
                                                <?php }else{} ?>
                                            </tr>
                                        </thead>
                                          <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    $search = $_POST['search'];

    if ($search != null || $search != "") {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if(isset($_POST['search'])){
                $query1="SELECT * from buy inner join supplier on buy.supplier=supplier.kode where buy.nota like '%$search%' or supplier.nama like '%$search%' or buy.status like '%$search%' or buy.tglsale <= '$search' order by buy.nota DESC limit $rpp ";
                $hasil = mysqli_query($conn,$query1);
                $no = 1;
                while ($fill = mysqli_fetch_assoc($hasil)){
                    ?>
                     <tbody>
<tr>
                      <td><?php echo ++$no_urut;?></td>
                      <td><?php  echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
                      <td><?php $newtgl = date("d-m-Y",strtotime($fill['tglsale']));
                       echo mysqli_real_escape_string($conn, $newtgl); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['total'], $decimal, $a_decimal, $thousand).',-'); ?></td>
                      <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>

                      <td><?php  echo mysqli_real_escape_string($conn, $fill['status']); ?></td>
                      <td><?php  echo mysqli_real_escape_string($conn, $fill['diterima']); ?></td>
                      
                      <td>
                      

                      
                     <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin')  { ?>

                      <?php if($fill['diterima']==''){ ?>

             <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_invoice?nota=<?php echo $fill['nota'].'&'; ?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo $forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>';myFunction()">Hapus</button>

                    <?php } else {?>

                 <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='pembelian_batal?q=<?php echo $fill['nota']; ?>'">Batal</button>

                    <?php } ?>



                     <?php } else {}?>
           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
         
          <?php  if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
          <?php if ($fill['status']!='Diterima'){?>
           
             <?php if ($fill['status']!='Diterima'){?>
             <button type="button" class="btn btn-success btn-xs no-print btn-flat" style="width:55px" onclick="window.location.href='invoice_beli?nota=<?php echo $fill['nota']?>'">Proses</button>
           <?php } } } } else {}?>







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
             <td><?php $newtgl = date("d-m-Y",strtotime($fill['tglsale']));
                       echo mysqli_real_escape_string($conn, $newtgl); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['total'], $decimal, $a_decimal, $thousand).',-'); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['status']); ?></td>
            
            <td><?php  echo mysqli_real_escape_string($conn, $fill['diterima']); ?></td>

            
            <td>
                      
                     <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin')  { ?>

                      <?php if($fill['diterima']==''){ ?>

             <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_inv?nota=<?php echo $fill['nota'].'&'; ?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo $forwardpage.'&'; ?>tabel=<?php echo $tabel.'&'; ?>tipe=1&chmod=<?php echo $chmod; ?>';myFunction()">Hapus</button>

                    <?php } else {?>

                 <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='pembelian_batal?q=<?php echo $fill['nota']; ?>'">Batal</button>

                    <?php } ?>



                     <?php } else {}?>

             <?php  if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
           <button type="button" class="btn btn-info btn-xs" onclick="window.location.href='invoice_beli?nota=<?php echo $fill['nota']?>'">Detail</button>
           <?php } else {}?>

           <?php  if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
          <?php if ($fill['diterima'] =='' || $fill['diterima'] ==null){?>
             <button type="button" class="btn btn-success btn-xs no-print btn-flat" style="width:55px" onclick="window.location.href='invoice_beli?nota=<?php echo $fill['nota']?>'">Proses</button>

             <?php if ($fill['status']=='hutang'){?>
              
           <?php } } } else {}?>

           <?php  if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
             <?php if (($fill['status'] =='hutang')&&($fill['diterima'] !='')){?>
           <button type="button" class="btn btn-primary btn-xs" onclick="window.location.href='bayar_hutang_beli?nota=<?php echo $fill['nota'];?>'">Bayar Hutang</button>

           <?php } } else {}?>




                     </td></tr>
            <?php
            $i++;
            $count++;
        }

        ?>
                  </tbody></table>
                  <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>
    <?php } ?>
<div class="col-xs-1" align="right">
          <a href="add_buy" class="btn btn-info" role="button">Beli barang</a>
        </div>
                               </div>
                                <!-- /.box-body -->
                            </div>

                            <?php } else {} ?>
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
        <script src="dist/plugins/jQuery/jquery-ui.min.js"></script>
        <script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<script>
function myFunction() {
  alert("INGAT! Menghapus transaksi tidak akan mengubah stok kembali seperti semula");
}
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
