<?php

error_reporting(E_ALL ^ E_DEPRECATED);
$servername = "localhost";
$username = "root";
$password = "";
$dbname="tokonabila";

      $koneksi = mysqli_connect('localhost', 'root', '');
        $db = mysqli_select_db($koneksi ,$dbname);

	// Create connection
	global $conn;
	$conn = mysqli_connect($servername, $username, $password,$dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>
