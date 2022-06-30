<?php 
include "configuration/config_connect.php";
$nouser= $_SESSION['nouser'];
$user= "SELECT * FROM user WHERE no='$nouser' ";
$query = mysqli_query($conn, $user);
$row  = mysqli_fetch_assoc($query);
$nama = $row['nama'];
$jabatan = $row['jabatan'];
$avatar = $row['avatar'];


$queryback="SELECT * FROM backset";
    $resultback=mysqli_query($conn,$queryback);
    $rowback=mysqli_fetch_assoc($resultback);
    $nama=$rowback['namabisnis1'];
?>


	<header class="main-header">
        <title><?php echo $nama;?></title>
                <!-- Logo -->
                <a href="<?php  echo $_SESSION['baseurl'];?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>T</b></span>
                    <!-- logo for regular state and mobile devices -->
                 <span class="logo-lg"><b><?php echo $nama;?></b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> </a>
                    
                    

                    
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php  echo $avatar; ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs"> <?php  echo $nama; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php  echo $avatar; ?>" class="img-circle" alt="User Image">
                                        <p>
                  <?php  echo $nama; ?> - <?php  echo $jabatan; ?></p>
                                    </li>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                              <a href="user_profil" class="btn btn-default btn-flat">Profil</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="logout?logout=1" class="btn btn-default btn-flat">Keluar</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <li>
</li>
                        </ul>
                    </div>
                </nav>
            </header>
