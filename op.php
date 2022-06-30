<?php
error_reporting(0);
session_start();
include "configuration/config_etc.php" ;
include "configuration/config_include.php" ;
include 'configuration/config_connect.php';
connect(); timing();
?>

<?php


$queryback="SELECT url FROM backset";
    $resultback=mysqli_query($conn,$queryback);
    $rowback=mysqli_fetch_assoc($resultback);
    $url=$rowback['url'];


$username=$password="";


$tabeldatabase = "user"; // tabel database
$forward = mysqli_real_escape_string($conn, $tabeldatabase);

if($_SERVER["REQUEST_METHOD"]=="POST"){
  $username= mysqli_real_escape_string($conn, $_POST['txtuser']);
  $password= mysqli_real_escape_string($conn, $_POST['txtpass']);
  $password=md5($password);
  $password=sha1($password);

  $sql="select * from $forward where userna_me='$username' and pa_ssword='$password'";
  $hasil= mysqli_query($conn,$sql);
  if(($url =='http://idwares.esy.es')&&(mysqli_num_rows($hasil)>0)){
    $data=mysqli_fetch_assoc($hasil);
    $_SESSION['username']=$data['userna_me'];
    $_SESSION['nama']=$data['nama'];
    $_SESSION['jabatan']=$data['jabatan'];
    $_SESSION['avatar']=$data['avatar'];
    $_SESSION['nouser']=$data['no'];
    $_SESSION['baseurl']=$baseurl;
    login_validate();
    header("Location: index?alert=1");

   } else if (mysqli_num_rows($hasil)>0){
  $data=mysqli_fetch_assoc($hasil);
    $_SESSION['username']=$data['userna_me'];
    $_SESSION['nama']=$data['nama'];
    $_SESSION['jabatan']=$data['jabatan'];
    $_SESSION['avatar']=$data['avatar'];
    $_SESSION['nouser']=$data['no'];
    $_SESSION['baseurl']=$baseurl;
    login_validate();
    header("Location: index");

  }
  else {
    header("Location: loginagain");
  
  }


}




?>