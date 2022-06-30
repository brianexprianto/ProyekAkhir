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
$no = $_GET['no'];


$halaman = "barang_detail?no=$no"; // halaman
$dataapa = "Barang"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu4; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
$insert = $_POST['insert'];



$sql = "SELECT * from $tabeldatabase where no = '$no' ";
$query = mysqli_query($conn,$sql);
$data=mysqli_fetch_assoc($query);
$avatar = $data['avatar'];
if ($avatar== "dist/upload/") {
  $avatar="dist/upload/index.jpg";
} else { $avatar = $data['avatar'];
}

$nama = $data['nama'];
$sku = $data['sku'];
$hargabeli = $data['hargabeli'];
$hargajual = $data['hargajual'];
$keterangan = $data['keterangan'];
$kategori = $data['kategori'];
$nama_supplier = $data['nama_supplier'];
$barcode = $data['barcode'];
$terjual = $data['terjual'];
$terbeli = $data['terbeli'];
$sisa = $data['sisa'];
$kode = $data['kode'];


function custom_echo($x, $length)
{
  if(strlen($x)<=$length)
  {
    echo $x;
  }
  else
  {
    $y=substr($x,0,$length) . '...';
    echo $y;
  }
}

 
?>


<!-- SETTING STOP -->


<!-- BREADCRUMB -->

<ol class="breadcrumb ">
<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
<li><a href="barang"><?php echo $dataapa ?></a></li>
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
              <h3 class="box-title">Detail | Kode Barang: #<?php echo $sku;?></h3>
            </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                <div class="table-responsive">
    <!----------------KONTEN------------------->
      <?php
    
    ?>
  <div id="main">
   <div class="container-fluid">

<div class="box-body col-md-3">
<!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php  echo $avatar; ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php custom_echo( $nama,15);?></h3>

              <p class="text-muted text-center"><?php custom_echo( $nama_supplier,15);?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Terjual</b> <a class="pull-right"><?php echo $terjual;?></a>
                </li>
                <li class="list-group-item">
                  <b>Dibeli</b> <a class="pull-right"><?php echo $terbeli;?></a>
                </li>
                <li class="list-group-item">
                  <b>Stok</b> <a class="pull-right"><?php echo $sisa;?></a>
                </li>
              </ul>

              <a href="stok_in?sku=<?php echo $sku;?>" class="btn btn-primary btn-block"><b>Tambah Stok</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
</div>

<div class="box-body col-md-2">
    </div>

<div class="box-body col-md-6">
<div class="tab-pane" id="settings">
                <form class="form-horizontal"  >
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nama</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" readonly="readonly" value="<?php echo $nama;?>" placeholder="Nama barang">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Satuan</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?php echo $kategori;?>" readonly="readonly" placeholder="kategori">
                    </div>
                  </div>

                    <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Supplier</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?php echo $data['nama_supplier'];?>" readonly="readonly" placeholder="kategori">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Harga Beli</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?php echo $hargabeli;?>" readonly="readonly" placeholder="kategori">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Harga Jual</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?php echo $hargajual;?>" readonly="readonly" placeholder="kategori">
                    </div>
                  </div>
                  <!--
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Ukuran</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?php echo $data['ukuran'];?>" readonly="readonly" placeholder="kategori">
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Warna</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?php echo $data['warna'];?>" readonly="readonly" placeholder="kategori">
                    </div>
                  </div>

                   <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Expiry Date</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?php echo $data['expired'];?>" readonly="readonly" placeholder="kategori">
                    </div>
                  </div>

                   <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Lokasi</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?php echo $data['lokasi'];?>" readonly="readonly" placeholder="kategori">
                    </div>
                  </div>
                  -->

                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Keterangan</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" readonly><?php echo $keterangan;?></textarea>
                    </div>
                  </div>
<!--
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Barcode</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="barcode" placeholder="barcode" value="<?php echo $barcode;?>" placeholder="BARCODE" readonly="readonly">
                    </div>
                  </div>
           
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" class="btn btn-danger" onclick="window.open('cetak_barcode?kode=<?php echo $kode;?>')">Cetak Barcode</button>
                    </div>
                  </div>
                </form>
              </div>
-->                     
              <!-- /.tab-pane -->
</div>
          
</div>


    <!-- KONTEN BODY AKHIR -->

                                </div>
                </div>

                                <!-- /.box-body -->
                            </div>
                        </div>



                        <div class="box-body col-md-10">

                

<div class="tab-content">
              <div class="active tab-pane" id="activity">
                <!-- Post -->
                <div class="box-body">
                  <div class="box box-primary">
                    
                  </div>
                  <!-- /.user-block -->
                  
                   <div class="box-body">
                     <?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    $sql    = "select *, mutasi.keterangan as ket from mutasi inner join barang on mutasi.kodebarang=barang.kode where mutasi.kodebarang='$kode' order by tgl desc";
    $result = mysqli_query($conn, $sql);
    $rpp    = 25;
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
              <table class="table table-condensed">
                <thead>
                    <tr>
                  <th style="width: 10px">#</th>
                  <th>Tanggal</th>
                  <th>User</th>
                  <th>Aktivitas</th>
                  <th>Keterangan/ No Transaksi</th>
                  <th>jumlah</th>
                  
                  
                  
                </tr>
                </thead>
                <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    $search = $_POST['search'];

    if ($search != null || $search != "") {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

              if(isset($_POST['search'])){
        $query1="select * from mutasi where kodebarang='$kode' order by tgl desc limit $rpp";
        $hasil = mysqli_query($conn,$query1);
        $no = 1;
        while ($fill = mysqli_fetch_assoc($hasil)){
          ?>

      
       <tbody>
                <tr>
                  <td><?php echo ++$no_urut;?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['tgl']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['namauser']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['kegiatan']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['ket']); ?></td>
             <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
             <td><?php  echo mysqli_real_escape_string($conn, $fill['sisa']); ?></td>
                  
                </tr>
                <?php
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
            <td><?php  echo mysqli_real_escape_string($conn, $fill['tgl']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['namauser']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['kegiatan']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['ket']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
            
            

            
          </tr>
            
      <?php
      $i++;
      $count++;
    }

    ?>
                  </tbody></table>
          <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>
  <?php } ?>
              </table>
            </div>
            <!-- /.box-body -->

                  
                </div>
                <!-- /.post -->

                

                
              </div>
              <!-- /.tab-pane -->


              </div>
              <!-- /.tab-pane -->
</div>
          
</div>


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
