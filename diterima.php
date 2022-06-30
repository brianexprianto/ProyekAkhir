<!DOCTYPE html>
<html>
<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
etc();encryption();session();connect();head();body();timing();
//alltotal();
pagination();

$nouser= $_SESSION['nouser'];
$user= "SELECT * FROM user WHERE no='$nouser' ";
$query = mysqli_query($conn, $user);
$row  = mysqli_fetch_assoc($query);
$namaorg = $row['nama'];
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
$halaman = "diterima"; // halaman
$dataapa = "Terima Barang"; // data
$nota = $_GET['nota'];
$chmod = $chmenu4; // Hak akses Menu


$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman

?>

<!-- SETTING STOP -->


<!-- BREADCRUMB -->

<ol class="breadcrumb ">
<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
<li><a href="pembelian">Pembelian</a></li>
<?php

if ($nota != null || $nota != "") {
?>
  <li class="active"><?php
    echo $nota;
?></li>
  <?php
} else {
?>
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
$berhasil = $_GET['berhasil'];

if ($berhasil == 1) {
?>
    <div id="myAlert"  class="alert alert-success alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Berhasil!</strong> Jumlah diterima dan Stok Barang telah berhasil diupdate .
</div>

<!-- BOX HAPUS BERHASIL -->
<?php
} elseif ($berhasil == 2) {
?>
           <div id="myAlert" class="alert alert-danger alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Gagal!</strong> jumlah diterima dan stok barang gagal diupdate, periksa kembali input anda .
</div>
<?php
} elseif ($berhasil == 3) {
?>
           <div id="myAlert" class="alert alert-danger alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Gagal!</strong> Terjadi kesalahan, hubungi admin untuk masalah ini .
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

     

$sqla="SELECT * FROM user where userna_me='$user'";
$hasila=mysqli_query($conn,$sqla);
$rowax=mysqli_fetch_assoc($hasila);
$namakasir=$rowax['nama'];
?>
                           <div class="box">
            <div class="box-header">
            <h3 class="box-title">Data <?php echo $forward ?>  <span class="label label-default"><?php echo $nota; ?></span> <span class="label label-warning"><?php echo $cabang; ?></span> <span class="label label-success"><?php echo $unit; ?></span>
              <span class="label label-info"><?php echo $namakasir; ?></span>
					</h3>



            </div>

                                <!-- /.box-header -->
                                  <!-- /.Paginasi -->
                                 <?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    if($nota != null || $nota != ""){
    $sql    = "select * from buy where nota='$nota' order by no ";
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
                                              <th>Nota</th>
                                              <th>Tanggal</th>
                                              <th>Supplier</th>
                                              <th>Total Bayar</th>
                                              <th>Keterangan</th>
												<?php	if (($chmod >= 3 || $_SESSION['jabatan'] == 'admin')) { ?>
                                                <th>Status</th>
												<?php }else{} ?>
                                            </tr>
                                        </thead>
                                          <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
   
		while(($count<$rpp) && ($i<$tcount)) {
			mysqli_data_seek($result,$i);
			$fill = mysqli_fetch_array($result);
			?>
                      <tbody>
<tr>
  
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
  <td><?php 
          $awal1 = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$fill['tglsale']);
          
          ?>
    <?php  echo mysqli_real_escape_string($conn, $awal1); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['supplier']); ?></td>
  <td>
             
                  <?php  echo mysqli_real_escape_string($conn, $fill['total']); ?>

            </td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['keterangan']); ?></td>
  
  <?php if($id!='1'){ ?>
  <td>

					 <?php	if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
             <?php  echo mysqli_real_escape_string($conn, $fill['status']); ?>
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

                    <div class="row">
            <div class="col-lg-12">
              <div class="box">
       <div class="box-header">
       <h3 class="box-title">Daftar Request Barang No: <?php echo '#'.$_GET['nota'];?>
       <span class="label label-danger"><?php echo $status; ?></span>
       </h3>
       </div>
         <div class="box-body table-responsive">

                   <!-- /.Paginasi -->
                                 <?php
    error_reporting(E_ALL ^ E_DEPRECATED);
   
    $sql    = "select * from invoicebeli where nota='$nota' order by no ";
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
                                              <th>Nama</th>
                                              <th>Jumlah beli</th>
                                              <th>Jumlah Diterima</th>
                                              
                                              
                        <?php if (($chmod >= 3 || $_SESSION['jabatan'] == 'admin')) { ?>
                                                <th>Konfirmasi</th>
                        <?php }else{} ?>
                                            </tr>
                                        </thead>
                                          <?php
    
    while(($count<$rpp) && ($i<$tcount)) {
      mysqli_data_seek($result,$i);
      $fill = mysqli_fetch_array($result);
      ?>
      
                      <tbody>
                        <form action="accepted" method="post">
<tr>



  <td><?php echo ++$no_urut;?>
  
     <input type="hidden" name="no" value="<?php echo $fill['no'];?>" readonly >
     <input type="hidden" name="nota" value="<?php echo $fill['nota'];?>" readonly >
  </td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kode']); ?>
    <input type="hidden" name="kode" value="<?php echo $fill['kode'];?>" readonly >
  </td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
  <td><?php  echo number_format(($fill['jumlah']), $decimal, $a_decimal, $thousand).''; ?>
    
  </td>
  <td><?php if($fill['terima']==0){?>
    <input type="text" name="terima" value="<?php echo $fill['jumlah'];?>" >
  <?php } else { echo number_format(($fill['terima']), $decimal, $a_decimal, $thousand).'';
   } ?>


  </td>
  
  
  <?php if($nota!="" || $nota != null){ ?>
  <td>

           <?php  if ($fill['terima']==0) { ?>
              <button type="submit"  name="diterima" class="btn btn-info btn-xs" >Konfirmasi Terima</button>
             <?php } else {?>telah diterima<?php }?>

             
           </td>



<?php }else{} ?>
         </tr>
         </form>
      <?php
      $i++;
      $count++;
    }

    ?>
                  </tbody>
                
                </table>
          <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>



         </div>
     </div>


            </div>

          </div>
<?php 
$ceksql= "SELECT * from invoicebeli where nota='$nota' and terima>0 ";
$cekres=mysqli_query($conn,$ceksql);

if (mysqli_num_rows($cekres)>0){
?>

                    

          <div class="box-body col-lg-2">
            <form method="post" action="diterima" id="Myform">
             
              <input type="hidden" name="org" value="<?php echo $namaorg;?>">
              <input type="hidden" name="nota" value="<?php echo $nota;?>">
          <button type="submit" name="simpan" class="btn pull-left btn-success col-lg-12" name="simpan" onclick="document.getElementById('Myform').submit();" ><span class="glyphicon glyphicon-floppy-disk"></span> Selesai</button>

        </form>
  <?php } ?>      
        </div> 

       

        </form>
        </div> <p>* Klik Selesai setelah menerima semua barang</p>
        <!-- /.row -->

 <?php 
 if(isset($_POST["simpan"])){
if($_SERVER["REQUEST_METHOD"] == "POST"){

$nota = mysqli_real_escape_string($conn, $_POST["nota"]);
$org = mysqli_real_escape_string($conn, $_POST["org"]);



$sqlw = "UPDATE buy SET diterima='$org' where nota='$nota' ";
$updt = mysqli_query($conn, $sqlw);

if ($updt){

  echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
                  echo "<script type='text/javascript'>window.location = 'pembelian';</script>";
}
} }

 ?>       
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

 

      <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'fetch.php',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>

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
