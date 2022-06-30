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
$halaman = "stok_detail"; // halaman
$dataapa = "Detail"; // data
$nota = $_GET['nota'];
$trx = $_GET['trx'];
$id = $_GET['id'];

if($id=='1'){
$chmod = $chmenu9; // Hak akses Menu
}else{
  $chmod = $chmenu8; // Hak akses Menu
}
if($trx=='1'){
  $tabeldatabase = "transaksimasuk"; // tabel database
}else if($trx=='2'){
      $tabeldatabase = "invoicebeli"; // tabel database
}

$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman

?>

<?php
$decimal ="0";
$a_decimal =",";
$thousand =".";
?>

<!-- SETTING STOP -->


<!-- BREADCRUMB -->

<ol class="breadcrumb ">
<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
<li><a href="<?php echo $halaman;?>"><?php echo $dataapa ?></a></li>
<?php

if ($nota != null || $nota != "") {
?>
 <li> <a href="<?php echo $halaman;?>">Data <?php echo $dataapa ?></a></li>
  <li class="active"><?php
    echo $nota;
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

<?php

        $sqla="SELECT no, COUNT( * ) AS totaldata FROM $forward where nota='$nota'";
 // (is_null($sqla))
// {
//  echo 'Variable is  NULL';
 //   }
//else
//{
    $hasila=mysqli_query($conn,$sqla);
    $rowa=mysqli_fetch_assoc($hasila);
    $totaldata=$rowa['totaldata'];

if($trx == '1'){
    $sqla="SELECT * FROM bayar where nota='$nota'";
$hasila=mysqli_query($conn,$sqla);
$rowa=mysqli_fetch_assoc($hasila);
$tanggal=$rowa['tglbayar'];
$total=$rowa['total'];
}else if($trx == '2'){
      $sqla="SELECT * FROM buy where nota='$nota'";
  $hasila=mysqli_query($conn,$sqla);
  $rowa=mysqli_fetch_assoc($hasila);
  $tanggal=$rowa['tglbeli'];
  $total=$rowa['total'];
}

?>
                           <div class="box">
            <div class="box-header">
            <h3 class="box-title">Data <?php echo $forward ?>  <span class="label label-default"><?php echo $totaldata; ?></span> <span class="label label-warning"><?php echo $nota; ?></span> <span class="label label-success"><?php echo $tanggal; ?></span>
              <span class="label label-info"><?php echo 'Rp '.number_format($total, $decimal, $a_decimal, $thousand).',-'; ?></span>
          </h3>



            </div>

                                <!-- /.box-header -->
                                  <!-- /.Paginasi -->
                                 <?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    if($trx != null || $trx != ""){
    $sql    = "select * from $forward where nota='$nota' order by no ";
  }else{
    error_reporting(0);
  }
    $result = mysqli_query($conn, $sql);
    $rpp    = 100;
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
                                              <th>Kode Barang</th>
                                              <th>Nama Barang</th>
                                              <th>Harga Satuan</th>
                                              <th>Jumlah</th>
                                              <th>Harga Akhir</th>

                                      <?php    if($trx == '1'){?>
                                                <th>Retur</th>   
                                              <?php } ?>
                        <?php if (($chmod >= 3 || $_SESSION['jabatan'] == 'admin')&&( $id != '1')) { ?>
                                                <th>Opsi</th>
                        <?php }else{} ?>
                                            </tr>
                                        </thead>
                                          <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    $nota = $_POST['nota'];

    while(($count<$rpp) && ($i<$tcount)) {
      mysqli_data_seek($result,$i);
      $fill = mysqli_fetch_array($result);
      ?>
                      <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['harga'], $decimal, $a_decimal, $thousand).',-'); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format(($fill['jumlah']*$fill['harga']), $decimal, $a_decimal, $thousand).',-'); ?></td>
  <?php    if($trx == '1'){?>
 <td><?php  echo mysqli_real_escape_string($conn, $fill['retur']); ?></td>
  <?php } ?>
  <?php if($id!='1'){ ?>
  <td>

           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
             <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_produk?get=<?php echo $trx.'&'; ?>barang=<?php echo $fill['kode'].'&'; ?>jumlah=<?php echo $fill['jumlah'].'&'; ?>kode=<?php echo $nota.'&'; ?>
               no=<?php echo $fill['no'].'&'; ?>forward=<?php echo $tabeldatabase.'&'?>&forwardpage=stok_batal&chmod=<?php echo $chmod; ?>'">Batalkan</button>
             <?php } else {}?>
           </td>
<?php }else{} ?>
         </tr>
      <?php
      $i++;
      $count++;
    }

    ?>
                  </tbody></table>
          <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>


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
