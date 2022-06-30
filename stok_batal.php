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
                <section class="content">
                    <div class="row">
            <div class="col-lg-12">
<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "stok_batal"; // halaman
$dataapa = "Pembatalan Stok"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu8; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
$trx = $_POST['trx'];

?>

<!-- SETTING STOP -->
<?php
$decimal ="0";
$a_decimal =",";
$thousand =".";
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
           <div id="myAlert" class="alert alert-danger alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Gagal!</strong> <?php echo $dataapa;?> tidak bisa dihapus dari Data <?php echo $dataapa;?> karena telah melakukan transaksi sebelumnya, gunakan menu update untuk merubah informasi <?php echo $dataapa;?> .
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


<div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <?php if($trx == '1'){?>
          <li class="active"><a href="#tab_1-1" data-toggle="tab">Pembatalan Penjualan</a></li>
          <li><a href="#tab_2-2" data-toggle="tab">Pembatalan Pembelian</a></li>
          <?php }else if ($trx == '2'){ ?>
            <li><a href="#tab_1-1" data-toggle="tab">Pembatalan Penjualan</a></li>
            <li class="active"><a href="#tab_2-2" data-toggle="tab">Pembatalan Pembelian</a></li>
            <?php }else{ ?>
                <li class="active"><a href="#tab_1-1" data-toggle="tab">Pembatalan Penjualan</a></li>
                <li><a href="#tab_2-2" data-toggle="tab">Pembatalan Pembelian</a></li>
              <?php } ?>
          <li class="pull-left header"><i class="fa fa-cart-arrow-down"></i> Pembatalan Transaksi</li>
        </ul>
        <div class="tab-content">

<?php if($trx != '2'){?>
            <div class="tab-pane active" id="tab_1-1">
<?php }else{ ?>
            <div class="tab-pane" id="tab_1-1">
<?php } ?>
              <?php
              if($search != null || $search != ""){
                                    $sqla="SELECT no, COUNT( * ) AS totaldata FROM bayar where nota like '%$search%' or tglbayar like '%$search%' ";
                                  }else{
                                    $sqla="SELECT no, COUNT( * ) AS totaldata FROM bayar";
                                  }
                  $hasila=mysqli_query($conn,$sqla);
                  $rowa=mysqli_fetch_assoc($hasila);
                  $totaldata=$rowa['totaldata'];

              ?>

                           <div class="box">
            <div class="box-header">

            <h3 class="box-title">Data Transaksi Penjualan <span class="label label-default"> <?php echo $totaldata; ?></span>
          </h3>

        <form method="post">
        <br/>
                <div class="input-group input-group-sm" style="width: 250px;">
                  <input type="text" name="search" class="form-control pull-right" placeholder="Cari">
                  <input type="hidden" name="trx" value='1'>

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>

          </form>


            </div>

                                <!-- /.box-header -->
                                  <!-- /.Paginasi -->
                                 <?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    $sql    = "select * from bayar order by no desc";
    $result = mysqli_query($conn, $sql);
    $rpp    = 10;
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
                                                <th>Total Pembayaran</th>
                                                <th>Cc</th>
                        <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
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
        $query1="SELECT * FROM  bayar where nota like '%$search%' or tglbayar like '%$search%' order by no desc limit $rpp";
        $hasil = mysqli_query($conn,$query1);
        $no = 1;
        while ($fill = mysqli_fetch_assoc($hasil)){
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
             ?>
            <td><?php  echo mysqli_real_escape_string($conn, $jumlahbayar); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['total'], $decimal, $a_decimal, $thousand).',-'); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
            <td>
            <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
              <button type="button" class="btn btn-info btn-xs" onclick="window.location.href='stok_detail?trx=1&nota=<?php  echo $fill['nota']; ?>'">Detail</button>
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
   ?>
  <td><?php  echo mysqli_real_escape_string($conn, $jumlahbayar); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['total'], $decimal, $a_decimal, $thousand).',-'); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
  <td>
  <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
<button type="button" class="btn btn-info btn-xs" onclick="window.location.href='stok_detail?trx=1&nota=<?php  echo $fill['nota']; ?>'">Detail</button>
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
                          </div>


  <!-- /.Tab 2 -->


  <?php if($trx != '1'){?>
              <div class="tab-pane active" id="tab_2-2">
  <?php }else{ ?>
              <div class="tab-pane" id="tab_2-2">
  <?php } ?>


                <?php
  if($search != null || $search != ""){
                        $sqla="SELECT beli.no, COUNT( * ) AS totaldata FROM beli inner join supplier on supplier.kode = beli.supplier where nota like '%$search%' or tglbeli like '%$search%' or supplier.nama like '%$search%' ";
                      }else{
                        $sqla="SELECT no, COUNT( * ) AS totaldata FROM beli";
                      }
                    $hasila=mysqli_query($conn,$sqla);
                    $rowa=mysqli_fetch_assoc($hasila);
                    $totaldata2=$rowa['totaldata'];

                ?>
                                         <div class="box">
                          <div class="box-header">
                          <h3 class="box-title">Data Transaksi Pembelian  <span class="label label-default"><?php echo $totaldata2; ?></span>
                        </h3>

                      <form method="post">
                      <br/>
                              <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search" class="form-control pull-right" placeholder="Cari">
                                  <input type="hidden" name="trx" value="2">

                                <div class="input-group-btn">
                                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                              </div>

                        </form>


                          </div>

                                              <!-- /.box-header -->
                                                <!-- /.Paginasi -->

                                               <?php
                  error_reporting(E_ALL ^ E_DEPRECATED);
                  $sql    = "select *, supplier.nama as supplier from beli inner join supplier on supplier.kode = beli.supplier order by beli.no desc";
                  $result = mysqli_query($conn, $sql);
                  $rpp    = 10;
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
                                                              <th>Total Pembayaran</th>
                                                              <th>Supplier</th>
                                                              <th>Cc</th>
                                      <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
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
                      $query1="SELECT *, supplier.nama as supplier FROM  beli inner join supplier on supplier.kode = beli.supplier where nota like '%$search%' or tglbeli like '%$search%' or supplier.nama like '%$search%' order by beli.no desc limit $rpp";
                      $hasil = mysqli_query($conn,$query1);
                      $no = 1;
                      while ($fill = mysqli_fetch_assoc($hasil)){
                        ?>
                                   <tbody>
              <tr>
                          <td><?php echo ++$no_urut;?></td>
                          <td><?php  echo mysql_real_escape_string($fill['nota']); ?></td>
                          <td><?php  echo mysql_real_escape_string($fill['tglbeli']); ?></td>
                          <?php
                        $nota = $fill['nota'];
                        $sqle="SELECT COUNT( nota ) AS data FROM transaksibeli WHERE nota ='$nota'";
                        $hasile=mysqli_query($conn,$sqle);
                        $rowa=mysqli_fetch_assoc($hasile);
                        $jumlahbeli=$rowa['data'];
                           ?>
                          <td><?php  echo mysqli_real_escape_string($conn, $jumlahbeli); ?></td>
                          <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['total'], $decimal, $a_decimal, $thousand).',-'); ?></td>
                          <td><?php  echo mysqli_real_escape_string($conn, $fill['supplier']); ?></td>
                          <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
                          <td>
                          <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                            <button type="button" class="btn btn-info btn-xs" onclick="window.location.href='stok_detail?trx=2&nota=<?php  echo $fill['nota']; ?>'">Detail</button>
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
                <td><?php  echo mysqli_real_escape_string($conn, $fill['tglbeli']); ?></td>
                <?php
              $nota = $fill['nota'];
              $sqle="SELECT COUNT( nota ) AS data FROM transaksibeli WHERE nota ='$nota'";
              $hasile=mysqli_query($conn,$sqle);
              $rowa=mysqli_fetch_assoc($hasile);
              $jumlahbeli=$rowa['data'];
                 ?>
                <td><?php  echo mysqli_real_escape_string($conn, $jumlahbeli); ?></td>
                <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['total'], $decimal, $a_decimal, $thousand).',-'); ?></td>
                <td><?php  echo mysqli_real_escape_string($conn, $fill['supplier']); ?></td>
                <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
                <td>
                <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                  <button type="button" class="btn btn-info btn-xs" onclick="window.location.href='stok_detail?trx=2&nota=<?php  echo $fill['nota']; ?>'">Detail</button>
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
                                        </div>


<!-- Close -->
                                      </div>
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
