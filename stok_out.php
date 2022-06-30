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
$halaman = "stok_out"; // halaman
$dataapa = "Stok Keluar"; // data
$tabeldatabase = "stok_keluar"; // tabel database
$tabel="stok_keluar_daftar";
$chmod = $chmenu4; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
$insert = $_POST['insert'];



 function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT MAX(RIGHT(nota, 4)) as max_id FROM stok_keluar ORDER BY nota";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);
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

<?php 
//fungsi menangkap barcode

if(isset($_GET['barcode'])) {
   $barcode = mysqli_real_escape_string($conn, $_GET["barcode"]);
    $sql1= "SELECT * FROM barang where barcode='$barcode'";
    $query=mysqli_query($conn, $sql1);
    $data=mysqli_fetch_assoc($query);
    $nama=$data['nama'];
    $kode=$data['kode'];
    $stok=$data['sisa'];
    $jumlah ='1';
}
    ?>
<!-- tambah -->
<?php

    if(isset($_POST["keluar"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){
               $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
                $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
                 $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
                  $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);
                   $stok = mysqli_real_escape_string($conn, $_POST["stok"]);

                    $kegiatan = "Stok Keluar";
                     $status = "pending";
                    $usr=$_SESSION['nama'];
                    $today=date('Y-m-d');
                 if($jumlah <= $stok){
               
                    $brg=mysqli_query($conn,"SELECT * FROM barang WHERE kode='$kode'");
                    $ass=mysqli_fetch_assoc($brg);
                    $oldstok=$ass['sisa'];
                    $oldout=$ass['terjual'];
                    $newstok=$oldstok-$jumlah;
                    $newout=$oldout+$jumlah;

                    $sqlx="UPDATE barang SET sisa='$newstok', terjual='$newout' WHERE kode='$kode'";
                    $updx=mysqli_query($conn, $sqlx);
                    if($updx){

                   $sql="select * from stok_keluar_daftar where nota='$nota' and kode_barang='$kode'";
            $resulte=mysqli_query($conn,$sql);

                 if(mysqli_num_rows($resulte)>0){
                    $q = mysqli_fetch_assoc($resulte);
                    $cart = $q['jumlah'];
                    $newcart = $cart + $jumlah;
                    $sqlu ="UPDATE stok_keluar_daftar SET jumlah='$newcart' where nota='$nota' AND kode_barang='$kode'";
                    $ucart=mysqli_query($conn,$sqlu);
                    if($ucart){


         //            $sql3 = "UPDATE mutasi SET jumlah='$newcart' WHERE keterangan='$nota' AND kegiatan='$kegiatan' ";
         //            $upd=mysqli_query($conn,$sql3);

                      echo "<script type='text/javascript'>  alert('Jumlah Stok keluar telah ditambah!');</script>";
                      echo "<script type='text/javascript'>window.location = '$halaman';</script>";
                    } else {
                      echo "<script type='text/javascript'>  alert('GAGAL, Periksa kembali input anda!');</script>";
                    }

                   
              } else {

                    $sql2 = "insert into stok_keluar_daftar values( '$nota','$kode','$nama','$jumlah','')";
                     $insertan = mysqli_query($conn, $sql2);

                      if($insertan){

             $sql9="INSERT INTO mutasi VALUES('$usr','$today','$kode','$newstok','$jumlah','stok keluar','$nota','','pending')";
                    $mutasi=mysqli_query($conn,$sql9);


                      echo "<script type='text/javascript'>  alert('Produk telah dimasukan dalam daftar!');</script>";
                      echo "<script type='text/javascript'>window.location = '$halaman';</script>";
                    } else {
                      echo "<script type='text/javascript'>  alert('GAGAL memasukan produk, periksa kembali!');</script>";
                    }




              }
} else {
 echo "<script type='text/javascript'>  alert('Gagal mengupdate jumlah stok!');</script>";
                      echo "<script type='text/javascript'>window.location = '$halaman';</script>";

}


} else {

   echo "<script type='text/javascript'>  alert('Jumlah keluar tidak boleh lebih besar dari stok tersedia!');</script>";
                      echo "<script type='text/javascript'>window.location = 'stok_out';</script>";
}

} }
 ?>              
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
                         <div class="col-lg-5 col-xs-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Stok Keluar</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
  <body OnLoad='document.getElementById("barcode").focus();'>
<form method="get" action="">
   <div class="row" >
           <div class="form-group col-md-12 col-xs-12" >
                  <!--<label for="barang" class="col-sm-2 control-label">Barcode:</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" id="barcode" name="barcode" >
                  </div>
                   <div class="col-sm-2">
                    <b>atau</b>
                   </div>-->
                </div>
        </div>
</form>

   <div class="row" >
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="barang" class="col-sm-2 control-label">Pilih Barang:</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%;" name="produk" id="produk">
                      <option selected="selected"> Pilih Barang</option>
              <?php
              error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
         $sql=mysqli_query($conn,"select *,barang.nama as nama, barang.kode as kode, barang.sku as sku from barang");
        while ($row=mysqli_fetch_assoc($sql)){
          if ($barcode==$row['barcode'])
          echo "<option value='".$row['kode']."' nama='".$row['nama']."' kode='".$row['kode']."' stok='".$row['sisa']."' selected='selected'>".$row['sku']." | ".$row['nama']."</option>";
          else
          echo "<option value='".$row['kode']."' nama='".$row['nama']."' kode='".$row['kode']."' stok='".$row['sisa']."' >".$row['sku']." | ".$row['nama']."</option>";
        }
      ?>
                    </select>
                  </div>
                </div>
        </div>




<form method="post" action="">
 <div class="row" >
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="barang" class="col-sm-2 control-label">Nama Produk:</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" readonly id="nama" name="nama" value="<?php echo $nama;?>" >
                       <input type="hidden" class="form-control" readonly id="kode" name="kode" value="<?php echo $kode;?>">
                       <input type="hidden" class="form-control" readonly id="nota" name="nota" value="<?php echo autoNumber(); ?>">
                      
                  </div>
                  
                </div>
        </div>
 
<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
?>

<div class="row" >
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="barang" class="col-sm-2 control-label">Stok:</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $stok;?>" readonly>
                  </div>
                  
                </div>
        </div>


<div class="row" >
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="barang" class="col-sm-2 control-label">Jumlah:</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo $jumlah;?>" >
                  </div>
                   <div class="col-sm-5">
                    <button type="submit" name="keluar" class="btn bg-maroon btn-flat btn-block">Tambahkan</button>
                   </div>
                </div>
        </div>


</form>
        </div>

                                <!-- /.box-body -->
                            </div>
                          </div>




                           <div class="col-lg-7 col-xs-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Keluar</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          


          <div class="row">
                <div class="col-md-12">
                  <div class="box box-success">
                    <div class="box-header with-border">
         
           </div>

           <?php
           error_reporting(E_ALL ^ E_DEPRECATED);

           $sql    = "select * from stok_keluar_daftar where nota =".autoNumber()." order by no";
           $result = mysqli_query($conn, $sql);
           $rpp    = 30;
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
              <table class="data table table-hover table-bordered">
                  <thead>
                      <tr>
                          <th style="width:10px">No</th>
                          <th>Nama Barang</th>
                          <th style="width:10%">Jumlah Keluar</th>
                          
           <?php  if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                          <th style="width:10px">Opsi</th>
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
           <td><?php echo ++$no_urut;?></td>

          
           <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
          
           <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
        
           <td>
           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
           <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_stok?get=<?php echo 'out'.'&'; ?>barang=<?php echo $fill['kode_barang'].'&'; ?>jumlah=<?php echo $fill['jumlah'].'&'; ?>&kode=<?php echo $kode.'&'; ?>no=<?php echo $fill['no'].'&'; ?>forward=<?php echo $tabel.'&';?>forwardpage=<?php echo "".$forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
           <?php } else {}?>
           </td></tr>
           <?php
           $i++;
           $count++;
           }

           ?>
           </tbody></table>
           <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>


           </div>

           </div>


         </div>
                  </div>

                  <div class="row">
                <div class="col-md-12">
                  <div class="box box-danger">
                    <div class="box-header with-border">

<form method="post" action="">
                      
<div class="row" >
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="barang" class="col-sm-2 control-label">Keterangan:</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="ket">
                  </div>
                  
                </div>
        </div>
        <br>
             <input type="hidden" class="form-control" readonly id="notae" name="notae" value="<?php echo autoNumber(); ?>">

           <div class="row" >
           <div class="form-group col-md-12 col-xs-12" >
                 <div class="col-lg-12">
                 <button type="submit" name="simpan" class="btn btn-flat bg-teal btn-block">SIMPAN</button>
                  </div>
                   
                </div>
        </div>
</form>


                    </div>
                  </div>
                </div>
              </div>





        </div>

                                <!-- /.box-body -->
                            </div>
                          </div>




<?php

    if(isset($_POST["simpan"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){
               $nota = mysqli_real_escape_string($conn, $_POST["notae"]);
               $ket= mysqli_real_escape_string($conn, $_POST["ket"]);
                $tgl= date('Y-m-d');
                  $usr=$_SESSION['nouser'];
                  $cab='01';

                    $kegiatan = "Stok Keluar";

                    $sql2 = "insert into stok_keluar values( '$nota','$cab','$tgl','$usr','$ket','')";
                     $insertan = mysqli_query($conn, $sql2);

                        $mut="UPDATE mutasi SET status='berhasil', keterangan='$ket' WHERE keterangan='$nota' AND kegiatan='$kegiatan'";
                $muta=mysqli_query($conn,$mut);

                     echo "<script type='text/javascript'>  alert('Stok selesai dikeluarkan!');</script>";
                      echo "<script type='text/javascript'>window.location = 'stok_out';</script>";


             } } ?>







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

<!-- Script -->
    <script src='jquery-3.1.1.min.js' type='text/javascript'></script>

    <!-- jQuery UI -->
    <link href='jquery-ui.min.css' rel='stylesheet' type='text/css'>
    <script src='jquery-ui.min.js' type='text/javascript'></script>

<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="dist/plugins/jQuery/jquery-ui.min.js"></script>





<script>
$("#produk").on("change", function(){

  var nama = $("#produk option:selected").attr("nama");
   var kode = $("#produk option:selected").attr("kode");
    var stok = $("#produk option:selected").attr("stok");
 

  $("#nama").val(nama);
   $("#kode").val(kode);
    $("#stok").val(stok);
  $("#jumlah").val(1);
});
</script>


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
