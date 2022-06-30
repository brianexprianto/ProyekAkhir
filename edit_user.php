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
$halaman = "edit_user"; // halaman
$dataapa = "Edit User"; // data
$tabeldatabase = "user"; // tabel database
$chmod = 5; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
$insert = $_POST['insert'];

 
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
<?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));


    $username=$password=$nama=$alamat=$nohp=$tgllahir=$tglaktif=$avatar=$jabatan=$insert=$no="";
    $no = $_GET["no"];
    $insert = '1';



    if(($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')){

         $sql="select * from $tabeldatabase where no='$no'";
                  $hasil2 = mysqli_query($conn,$sql);


                  while ($fill = mysqli_fetch_assoc($hasil2)){


                  $username = $fill["userna_me"];
                  $password = $fill["pa_ssword"];
                  $nama= $fill["nama"];
                  $alamat= $fill["alamat"];
                  $nohp= $fill["nohp"];
                  $tgllahir= $fill["tgllahir"];
                  $tglaktif= $fill["tglaktif"];
                  $jabatan = $fill["jabatan"];
                  $avatar = $fill["avatar"];
                  $insert = '3';

    }
    }
    ?>

<!-- BREADCRUMB -->
<?php

       if($_SERVER["REQUEST_METHOD"] == "POST"){

                      $username = mysqli_real_escape_string($conn, $_POST["username"]);
                      
                      $nama= mysqli_real_escape_string($conn, $_POST["nama"]);
                      $jabatan= mysqli_real_escape_string($conn, $_POST["jabatan"]);
                      $nohp= mysqli_real_escape_string($conn, $_POST["nohp"]);
                      $alamat= mysqli_real_escape_string($conn,$_POST["alamat"]);
                      $tgllahir= mysqli_real_escape_string($conn, $_POST["tgllahir"]);
                      $last= mysqli_real_escape_string($conn, $_POST["lastavatar"]);
                      $namaavatar = $_FILES['avatar']['name'];
                      $ukuranavatar = $_FILES['avatar']['size'];
                      $tipeavatar = $_FILES['avatar']['type'];
                      $tmp = $_FILES['avatar']['tmp_name'];
                      $avatar = "dist/upload/".$namaavatar;
                      $insert = ($_POST["insert"]);
                      $no = ($_GET["no"]);

                 $sql="select * from $tabeldatabase where no ='$no'";
            $result=mysqli_query($conn,$sql);

                  if(mysqli_num_rows($result)>0){
              if((($tipeavatar == "image/jpeg" || $tipeavatar == "image/png") && ($ukuranavatar <= 10000000 && $username != null)) && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')){
                      move_uploaded_file($tmp, $avatar);
                      $sql1 = "update $tabeldatabase set nama='$nama', nohp='$nohp', alamat='$alamat', tgllahir='$tgllahir', jabatan='$jabatan',avatar='$avatar' where userna_me='$username'";
                      $updatean = mysqli_query($conn, $sql1);
                      echo "<script type='text/javascript'>  alert('Berhasil, Data berhasil diupdate!');</script>";

              }else if($chmod >= 3 || $_SESSION['jabatan'] == 'admin'){
                    $avatar = $last;
                    $sql1 = "update $tabeldatabase set nama='$nama', nohp='$nohp', alamat='$alamat', tgllahir='$tgllahir', jabatan='$jabatan',avatar='$avatar' where userna_me='$username'";
                    $updatean = mysqli_query($conn, $sql1);
                    echo "<script type='text/javascript'>  alert('Berhasil, Data berhasil diupdate!');</script>";

            }else{
                ?>
                  <body onload="setTimeout(function() { document.frm1.submit() }, 10)">
      <form action="<?php echo $baseurl; ?>/<?php echo $forwardpage;?>" name="frm1" method="post">
      <input type="hidden" name="hapusberhasil" value="3" />
      </form>
                <?php
              }
            }
          else if((($tipeavatar == "image/jpeg" || $tipeavatar == "image/png") && ($ukuranavatar <= 10000000 && $username != null && $password != null && $nama != null)) && ( $chmod >= 2 || $_SESSION['jabatan'] == 'admin')){
               move_uploaded_file($tmp, $avatar);
               if($password == $password2){
               $sql2 = "insert into $tabeldatabase values( '$username','$password','$nama','$alamat','$nohp','$tgllahir','$tglaktif','$jabatan','$avatar','')";
               $insertan = mysqli_query($conn, $sql2);
               echo "<script type='text/javascript'>  alert('Berhasil, Data berhasil ditambahkan!');</script>";
               echo "<script type='text/javascript'>window.location = 'add_admin';</script>";
             }else{
               echo "<script type='text/javascript'>  alert('Gagal, Pastikan kata sandi sama!');</script>";
             }
             }else {
               if($password == $password2){
               $avatar = "dist/upload/index.jpg";
               $sql2 = "insert into $tabeldatabase values( '$username','$password','$nama','$alamat','$nohp','$tgllahir','$tglaktif','$jabatan','$avatar','')";
               $insertan = mysqli_query($conn, $sql2);
               echo "<script type='text/javascript'>  alert('Berhasil, Data berhasil ditambahkan!');</script>";
               echo "<script type='text/javascript'>window.location = 'add_admin';</script>";
             }else{
                  echo "<script type='text/javascript'>  alert('Gagal, Pastikan kata sandi sama!');</script>";
             }
           }

    }

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
      <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit User: <?php echo $nama;?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="edit_user.php?no=<?php echo $no;?>" id="Myform" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">User Name</label>
                  <input type="text" class="form-control" id="username" name="username" value="<?php echo $username;?>" placeholder="User Name baru">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Password</label>
                  <input type="text" disabled class="form-control" placeholder="Password hanya bisa diganti pada Modul ganti Password">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama;?>" placeholder="Nama lengkap">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">No Hp</label>
                  <input type="text" class="form-control" id="nohp" name="nohp"  value="<?php echo $nohp;?>"placeholder="Nomor Hp">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Alamat</label>
                  <textarea class="form-control" id="alamat" name="alamat"  placeholder="Alamat"> <?php echo $alamat;?></textarea>
                 
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Tanggal lahirp</label>
                  <input type="text" class="form-control" id="datepicker2" name="tgllahir" value="<?php echo $tgllahir;?>" placeholder="Tanggal lahir">
                </div>
                
                <?php if($_SESSION['jabatan'] == 'admin'){ ?>
                <div class="form-group">
                  <label for="exampleInputEmail1">Jabatan</label>
                  <select class="form-control select2" style="width: 100%;" name="jabatan" required>
          <?php
    $sql=mysqli_query($conn,"select distinct(nama) from jabatan");
    while ($row=mysqli_fetch_assoc($sql)){
      if ($jabatan==$row['nama'])
      echo "<option value='".$row['nama']."' selected='selected'>".$row['nama']."</option>";
      else
      echo "<option value='".$row['nama']."'>".$row['nama']."</option>";
    }
  ?>
                 </select>
                </div>
                <?php }else{?>

                    <div class="form-group">
                  <label for="jabatan">Jabatan</label>
                  <input type="text" class="form-control" id="jabatan" nama="jabatan"  value="<?php echo $jabatan;?>"placeholder="jabatan">
                </div>



             <?php   } ?>

                
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" type="file" name="avatar">

    
                  <input type="hidden" class="form-control" id="lastavatar" name="lastavatar"  value="<?php echo $avatar;?>"placeholder="avatar">
              
                 
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
          <!-- /.box -->




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
