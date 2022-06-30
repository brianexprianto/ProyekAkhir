<?php
error_reporting(0);
include 'configuration/config_connect.php';
$themese = $responsiven = "";
        $queryback="SELECT * FROM backset";
		$resultback=mysqli_query($conn,$queryback);
		$rowback=mysqli_fetch_assoc($resultback);
		$themes=$rowback['themesback'];
		$responsive=$rowback['responsive'];

//themes

if($themes == '2'){
	$themese = 'skin-blue';
}else if ($themes == '3'){
	$themese = 'skin-green';
}else if ($themes == '4'){
	$themese = 'skin-purple';
}else if ($themes == '5'){
	$themese = 'skin-red';
}else if ($themes == '6'){
	$themese = 'skin-yellow';
}else{
	$themese = 'skin-custom-light';
}

//responsive

if($responsive == '1'){
	$responsiven = '';
}else{
	$responsiven = 'fixed';
}
		?>

<body class="hold-transition <?php echo $themese; ?><?php echo ' '.$responsiven; ?> sidebar-collapse sidebar-mini"> 
