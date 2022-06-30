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
$halaman = "admin"; // halaman
$dataapa = "Admin"; // data
$tabeldatabase = "user"; // tabel database
$chmod = $chmenu1; // Hak akses Menu
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

    <?php

       if($_SERVER["REQUEST_METHOD"] == "POST"){


        $pesanError = array();
      if (trim($_POST['username'])=="") {
        $pesanError[] = "<b>User Name</b> tidak boleh kosong !";    
      }

      if (trim($_POST['password'])=="") {
        $pesanError[] = "<b>Password</b> tidak boleh kosong !";    
      }

      if (strlen($_POST['password'])<6) {
        $pesanError[] = "<b>Password</b> minimal 6 karakter !";    
      } 

      if (strlen($_POST['password'])>8) {
        $pesanError[] = "<b>Password</b> maksimal 8 karakter !";    
      } 

      if (trim($_POST['nama'])=="") {
        $pesanError[] = "<b>Nama</b> tidak boleh kosong !";    
      }


                      $username = mysqli_real_escape_string($conn, $_POST["username"]);
                      $password = md5($_POST["password"]);
                      $password = sha1($password);
                      $password = mysqli_real_escape_string($conn, $password);
                      $password2 = md5($_POST["password2"]);
                      $password2 = sha1($password2);
                      $password2 = mysqli_real_escape_string($conn, $password2);
                      $nama= mysqli_real_escape_string($conn, $_POST["nama"]);
                      $jabatan= mysqli_real_escape_string($conn, $_POST["jabatan"]);
                      $nohp= mysqli_real_escape_string($conn, $_POST["nohp"]);
                      $alamat= mysqli_real_escape_string($conn,$_POST["alamat"]);
                      $tgllahir= mysqli_real_escape_string($conn, $_POST["tgllahir"]);
                      $tglaktif= mysqli_real_escape_string($conn, $_POST["tglaktif"]);
                      $namaavatar = $_FILES['avatar']['name'];
                      $ukuranavatar = $_FILES['avatar']['size'];
                      $tipeavatar = $_FILES['avatar']['type'];
                      $tmp = $_FILES['avatar']['tmp_name'];
                      $avatar = "dist/upload/".$namaavatar;
                      $insert = ($_POST["insert"]);
                      $no = ($_GET["no"]);


if (count($pesanError)>=1 ){
        echo "<div class='alert alert-danger alert-dismissable'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
          $noPesan=0;
          foreach ($pesanError as $indeks=>$pesan_tampil) { 
          $noPesan++;
            echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";  
          } 
        echo "</div>"; 
      }
      else {



                 $sql="select * from $tabeldatabase where userna_me ='$username'";
            $result=mysqli_query($conn,$sql);

                  if(mysqli_num_rows($result)>0){
              if((($tipeavatar == "image/jpeg" || $tipeavatar == "image/png") && ($ukuranavatar <= 10000000 && $username != null)) && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')){
                      move_uploaded_file($tmp, $avatar);
                      $sql1 = "update $tabeldatabase set pa_ssword='$password', nama='$nama', nohp='$nohp', alamat='$alamat', tgllahir='$tgllahir', tglaktif='$tglaktif', jabatan='$jabatan',avatar='$avatar' where userna_me='$username'";
                      $updatean = mysqli_query($conn, $sql1);
                      echo "<script type='text/javascript'>  alert('Berhasil, Data berhasil diupdate!');</script>";
                      echo "<script type='text/javascript'>window.location = 'admin';</script>";

              }else if($chmod >= 3 || $_SESSION['jabatan'] == 'admin'){
                    $avatar = "dist/upload/index.jpg";
                    $sql1 = "update $tabeldatabase set pa_ssword='$password', nama='$nama', nohp='$nohp', alamat='$alamat', tgllahir='$tgllahir', tglaktif='$tglaktif', jabatan='$jabatan',avatar='$avatar' where userna_me='$username'";
                    $updatean = mysqli_query($conn, $sql1);
                    echo "<script type='text/javascript'>  alert('Berhasil, Data berhasil diupdate!');</script>";
                    echo "<script type='text/javascript'>window.location = 'admin';</script>";

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
               echo "<script type='text/javascript'>window.location = 'admin';</script>";
             }else{
               echo "<script type='text/javascript'>  alert('Gagal, Pastikan kata sandi sama!');</script>";
             }
             }else {
               if($password == $password2){
               $avatar = "dist/upload/index.jpg";
               $sql2 = "insert into $tabeldatabase values( '$username','$password','$nama','$alamat','$nohp','$tgllahir','$tglaktif','$jabatan','$avatar','')";
               $insertan = mysqli_query($conn, $sql2);
               echo "<script type='text/javascript'>  alert('Berhasil, Data berhasil ditambahkan!');</script>";
               echo "<script type='text/javascript'>window.location = 'admin';</script>";
             }else{
                  echo "<script type='text/javascript'>  alert('Gagal, Pastikan kata sandi sama!');</script>";
             }
           }

    }

  }

             ?>

  <div id="main">
    <div class="col-sm-6">
   <div class="container-fluid">
<?php if($no != null || $no != ""){?>
          <form class="form-horizontal" method="post" action="add_<?php echo $halaman.'?no='.$no; ?>" id="Myform" enctype="multipart/form-data">
            <?php }else{ ?>
              <form class="form-horizontal" method="post" action="add_<?php echo $halaman; ?>" id="Myform" enctype="multipart/form-data">
<?php } ?>
              <div class="box-body">

        <div class="row">
                <div class="form-group col-md-12 col-xs-12" >
                  <label for="username" class="col-sm-3 control-label">Username:</label>
                  <div class="col-sm-9">
                    <?php if($no != null || $no != ""){?>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>"  maxlength="20" required readonly>
                    <?php }else{ ?>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>"  placeholder="Masukan Username" maxlength="20" required autocomplete="off">
                    <?php } ?>
                    <div id="uname_response" ></div>
                  </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="password" class="col-sm-3 control-label">Kata Sandi:</label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" placeholder="Masukan Password" maxlength="50" required>
                    <input type="checkbox" onclick="myFunction()">Show Password
                  </div>
                </div>
        </div>
<?php if($no != null || $no != ""){}else{ ?>
        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="password2" class="col-sm-3 control-label">Ulang Kata Sandi:</label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="password2" name="password2" placeholder="Masukan Password Lagi" maxlength="50" required>
                  </div>
                </div>
        </div>
<?php } ?>
         <div class="row">
                <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Nama Lengkap:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>"  placeholder="Masukan Nama lengkap" maxlength="100" required>
                  </div>
                </div>
        </div>

        <div class="row">
               <div class="form-group col-md-12 col-xs-12" >
                 <label for="alamat" class="col-sm-3 control-label">Alamat:</label>
                 <div class="col-sm-9">
                   <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat; ?>"  placeholder="Masukan Alamat " maxlength="255" >
                 </div>
               </div>
       </div>

       <div class="row">
              <div class="form-group col-md-12 col-xs-12" >
                <label for="nohp" class="col-sm-3 control-label">No Handphone:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nohp" name="nohp" value="<?php echo $nohp; ?>"  placeholder="Masukan Nomor Handphone" maxlength="20" >
                </div>
              </div>
      </div>

      <div class="row">
         <div class="form-group col-md-12 col-xs-12" >
                <label for="tgllahir" class="col-sm-3 control-label">Tanggal Lahir:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control pull-right" id="datepicker" name="tgllahir" placeholder="Masukan Tanggal Lahir" value="<?php echo $tgllahir; ?>" >
                </div>
              </div>
      </div>

      <div class="row">
         <div class="form-group col-md-12 col-xs-12" >
                <label for="tglaktif" class="col-sm-3 control-label">Tanggal Aktif:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control pull-right" id="datepicker2" name="tglaktif" placeholder="Masukan Tanggal Aktif" value="<?php echo $tglaktif; ?>" >
                </div>
              </div>
      </div>
<?php if($_SESSION['jabatan'] == 'admin'){ ?>
      <div class="row">
             <div class="form-group col-md-12 col-xs-12" >
               <label for="jabatan" class="col-sm-3 control-label">Jabatan:</label>
               <div class="col-sm-9">
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
               </div>
             </div>
             <?php }else{} ?>
     </div>

        <?php if($avatar == null || $avatar == ""){ ?>

      <div class="row">
                <div class="form-group col-md-12 col-xs-12" >
                  <label for="avatar" class="col-sm-3 control-label">Avatar:</label>
                  <div class="col-sm-9">
                    <input type="file" name="avatar">
                  </div>
                </div>
        </div>

        <?php }else{ ?>
          <div class="row">
                    <div class="form-group col-md-12 col-xs-12" >
                      <label for="avatar" class="col-sm-3 control-label">Avatar:</label>
                      <div class="col-sm-9">
      <input type="file" name="avatar">
    </div>
  </div>
</div>
<?php }?>

      <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert;?>" maxlength="1" >


              </div>
              <!-- /.box-body -->
              <div class="box-footer" >
                <button type="submit" class="btn btn-default pull-left btn-flat" name="simpan" onclick="document.getElementById('Myform').submit();" ><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
              </div>
              <!-- /.box-footer -->


 </form>
</div>
<div class="col-sm-6">
<div class="box box-widget widget-user">
  <div class="widget-user-header bg-aqua">
      <p>*Password terdiri dari minimal 6 karakter dan maksimal 8 karakter </p><br>
<p>*Password hanya terdiri dari huruf,nomor dan karakter alfanumerik </p>

</div>


</div>
</div>

</div>
</div>

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

  <script>
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
<script src="jquery-3.1.1.min.js" type="text/javascript"></script>

<script>
            $(document).ready(function(){

                $("#username").keyup(function(){

                    var username = $(this).val().trim();
            
                    if(username != ''){
            
                       
            
                        $.ajax({
                            url: 'ajaxfile.php',
                            type: 'post',
                            data: {username: username},
                            success: function(response){
                
                                $('#uname_response').html(response);
                
                             }
                        });
                    }else{
                        $("#uname_response").html("");
                    }
            
                });

            });
        </script>      
          <!-- ./wrapper -->
<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
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
