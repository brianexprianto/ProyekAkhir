<!DOCTYPE html>
<html>
<?php
include "configuration/config_include.php";
connect();

$queryback="SELECT * FROM data";
    $resultback=mysqli_query($conn,$queryback);
    $rowback=mysqli_fetch_assoc($resultback);
    $footer=$rowback['nama'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
   $PIN=$_GET['pin']; 

?>


<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Lockscreen</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="dist/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="../../index2.html"><b><?php echo $footer;?></b>POS</a>
  </div>


<?php 
if($PIN=='true'){?>

<form method="post" action="">
<div>

<button type="submit" name="reset" class="btn btn-danger btn-block">RESET</button>
</div>

</form>
<p>Klik RESET lalu Login dengan username: admin & password: admin</p>

<?php } else {?>

  <!-- User name -->
  <div class="lockscreen-name">Admin</div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="dist/img/avatar.png" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials" action="" method="post">
      <div class="input-group">
        <input type="password" class="form-control" name="pin" placeholder="Masukan PIN">

        <div class="input-group-btn">
          <button type="submit" class="btn" name="cek"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Masukan PIN Anda Untuk mereset password Admin
  </div>

<?php } ?>

  <div class="text-center">
    
  </div>
  
</div>

<!-- /.center -->



<?php 
if(isset($_POST['reset'])){
if($_SERVER["REQUEST_METHOD"]=="POST"){

$password="90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad";
$user = "admin";

 $sql="select * from user where userna_me='$user'";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
          $updt = "UPDATE user SET pa_ssword='$password', jabatan='$user' where userna_me='$user' ";
          $query =mysqli_query($conn, $updt);
          if ($query){
            echo "<script type='text/javascript'>window.location = 'login';</script>";
          }
        } else {

           $sql2 = "insert into user values( '$user','$password','admin','alamat','111','2020-02-02','2020-02-02','admin','dist/upload/index.jpg','')";
            $query =mysqli_query($conn,$sql2);
             if ($query){
           echo "<script type='text/javascript'>window.location = 'login';</script>";
          }
        }
}
}

?>





<?php

      if(isset($_POST['cek'])){
   if($_SERVER["REQUEST_METHOD"] == "POST"){
    $pin = mysqli_real_escape_string($conn, $_POST["pin"]);
    $pina=sha1(MD5($pin));

       $sql="select * from pin where pin='$pina'";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){

          $_SESSION['pin']= $pina;
            echo "<script type='text/javascript'>window.location = 'reset?pin=true';</script>";
        } else {
           echo "<script type='text/javascript'>  alert('PIN salah!'); </script>";
        }

    }}
    ?>

<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
