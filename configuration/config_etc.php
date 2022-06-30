<?php 
error_reporting(0);
include_once 'config_connect.php';
date_default_timezone_set("Asia/Jakarta");

		$baseurl= "tokonabila";
        $queryback="SELECT * FROM backset";
		$resultback=mysqli_query($conn,$queryback);
		$rowback=mysqli_fetch_assoc($resultback);
		$baseurl=$rowback['url'];


?>