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
$halaman = "restore"; // halaman
$dataapa = "restore"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu4; // Hak akses Menu


 
?>


<?php

function restore($host, $user, $pass, $dbname, $file){
    global $rest_dir;


    //konfigurasi restore database: host, user, password, database
    $koneksi = mysqli_connect('localhost', $user, $pass, $dbname);

    $nama_file  = $file['name'];
    $ukrn_file  = $file['size'];
    $tmp_file   = $file['tmp_name'];

    if($nama_file == "" || $_REQUEST['password1'] == ""){
         echo "<script type='text/javascript'>  alert('ERROR, Semua Form Wajib Diisi!');</script>";
        
        die();
    } else {

        $password = $_REQUEST['password1'];
        $no = $_SESSION['nouser'];

        $query = mysqli_query($koneksi, "SELECT pa_ssword FROM user WHERE no='$no' AND pa_ssword=sha1(MD5('$password'))");
        if(mysqli_num_rows($query) > 0){

            $alamatfile = $rest_dir.$nama_file;
            $templine   = array();

            $ekstensi = array('sql');
            $nama_file  = $file['name'];
            $x = explode('.', $nama_file);
            $eks = strtolower(end($x));

            //validasi tipe file
            if(in_array($eks, $ekstensi) == true){

                if(move_uploaded_file($tmp_file , $alamatfile)){

                    $templine   = '';
                    $lines      = file($alamatfile);

                    foreach ($lines as $line){
                        if(substr($line, 0, 2) == '--' || $line == '')
                            continue;

                        $templine .= $line;

                        if(substr(trim($line), -1, 1) == ';'){
                            mysqli_query($koneksi, $templine);
                            $templine = '';
                        }
                    }

                    unlink($nama_file);
                    echo "<script type='text/javascript'>  alert('BERHASIL, Database telah di restore!');</script>";
                    echo "<script type='text/javascript'>window.location = 'backup';</script>";
                    
                    die();
                } else {
                    echo "<script type='text/javascript'>  alert('GAGAL, proses upload gagal, coba lagi!');</script>";
                    
                    die();
                }
            } else {
               echo "<script type='text/javascript'>  alert('GAGAL, file yang di upload bukan file sql');</script>";
                
                die();
            }
        } else {
            session_destroy();
            echo '<script language="javascript">
                    window.alert("ERROR! Password salah. Anda mungkin tidak memiliki akses ke halaman ini");
                    window.location.href="backup";
                  </script>';
        }
    }
}



if(isset($_POST['restore'])){


    $host = mysqli_real_escape_string($conn, $_POST["servername"]);
    $pass = mysqli_real_escape_string($conn, $_POST["password"]);
    $username = mysqli_real_escape_string($conn, $_POST["user"]);
    $dbname = mysqli_real_escape_string($conn, $_POST["db"]);

    include "configuration/config_connect.php";
                    restore($host, $username, $pass, $dbname, $_FILES['file']);
                } else {}

                   

?>

<!-- SETTING STOP -->


<!-- BREADCRUMB -->

<ol class="breadcrumb ">
<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
<li><a href="backup">Backup</a></li>

 <li class="active">Data <?php echo $dataapa ?></li>
  
</ol>

<!-- BREADCRUMB -->

<!-- BOX INSERT BERHASIL -->



       <!-- BOX INFORMASI -->
    <?php
if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
  ?>


  <!-- KONTEN BODY AWAL -->
                         <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Restore Database</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="col-lg-6">

Lakukan restore database apabila diperlukan. Silakan klik upload <strong>"file .sql yang telah dibackup sebelumnya"</strong> untuk memulai proses restore. Selama proses restore dilarang meninggalkan/menutup halaman ini.<span class="red-text"><strong>*</strong></span><br><br>

<p>Anda juga bisa mendownload file database yang isinya kosong untuk merestore aplikasi kembali seperti ketika baru di instal</p>
<button onclick="window.location.href='database/db_kosong.sql'">Database kosong</button>
</div>

<div class="col-lg-6">

 <div class="box box-primary col-lg-6">
            <div class="box-header with-border">
              <h3 class="box-title">Upload Database</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" action="" enctype="multipart/form-data"
        id="frm-restore">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" name="file" class="input-file"  required>

                  <p class="help-block">Hanya upload file dengan format .sql.</p>
                </div>

                 <div class="form-group">
                  <label for="exampleInputFile">Password: </label>
                  <input type="password" name="password1" required>

                  <input type="hidden" name="servername" value="<?php echo $servername;?>" required>
                  <input type="hidden" name="user" value="<?php echo $username;?>" required>
                  <input type="hidden" name="pass" value="<?php echo $password;?>" >
                  <input type="hidden" name="db" value="<?php echo $dbname;?>" required>

                  
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="restore" value="Restore" class="btn btn-primary">Restore</button>
              </div>
            </form>
          </div>
<?php
if (! empty($response)) {
    ?>
<div class="response <?php echo $response["type"]; ?>">
<?php echo nl2br($response["message"]); ?>
</div>
<?php
}
?>
        </div>

                    </div>            <!-- /.box-body -->
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

<!--fungsi AUTO Complete-->


<!--AUTO Complete-->

</body>
</html>
