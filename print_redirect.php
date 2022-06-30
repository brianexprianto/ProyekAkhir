<?php

include "configuration/config_connect.php";

$nota=$_GET['nota'];
$tipe=$_GET['tipe'];

$a=mysqli_fetch_assoc(mysqli_query($conn,"SELECT tipenota FROM backset"));

$q=$a['tipenota'];


if($q<2){
  echo "<script type='text/javascript'>window.location = 'faktur_one?nota=$nota&tipe=$tipe';</script>";
} else if($q>2){
echo "<script type='text/javascript'>window.location = 'faktur_three?nota=$nota&tipe=$tipe';</script>";
} else {
echo "<script type='text/javascript'>window.location = 'faktur_two?nota=$nota&tipe=$tipe';</script>";
}





?>