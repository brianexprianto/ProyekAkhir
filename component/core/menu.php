<?php
include "configuration/config_connect.php";
include "configuration/config_chmod.php";
$nouser= $_SESSION['nouser'];
$user= "SELECT * FROM user WHERE no='$nouser' ";
$query = mysqli_query($conn, $user);
$row  = mysqli_fetch_assoc($query);
$nama = $row['nama'];
$jabatan = $row['jabatan'];
$avatar = $row['avatar'];
?>
 <aside class="main-sidebar">

                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php  echo $avatar; ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php  echo $nama; ?></p>
                            <a href="#"><i class="fa fa-circle text-online"></i> Online</a>
                            
                        </div>
                    </div>
<br>
                             <ul class="sidebar-menu">
                       <!-- <li class="header">MENU UTAMA</li> -->
                        <li class="treeview">
                            <a href="index"> <i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>

                        </li>



<?php

if($chmenu4 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class="glyphicon glyphicon-th-list"></i> <span>Barang</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
                                <li>
                                    <a href="barang"><i class="fa fa-circle-o"></i>Data Barang</a>
                                </li>
                                                                      <li>
                                    <a href="add_barang"><i class="fa fa-circle-o"></i>Tambah Barang</a>
                                                  </li>
                                                  <li>
                                    <a href="barang_perhitungan"><i class="fa fa-circle-o"></i>Persediaan Barang</a>
                                </li>

                            <!--           <li>
                                    <a href="cetak_barcode"><i class="fa fa-circle-o"></i>Barcode</a>
                                                  </li>
                                        
                                        <li>
                                    <a href="merek"><i class="fa fa-circle-o"></i>Brand</a>
                                                  </li>    
                            -->
                                    <li>
                                    <a href="kategori"><i class="fa fa-circle-o"></i>Satuan Barang</a>
                                    </li>
                            </ul>
                        </li>




    <?php }else{}

if($chmenu6 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class="glyphicon glyphicon-shopping-cart"></i> <span>Menu Penjualan</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
                                <li>
                                    <a href="add_jual"><i class="fa fa-circle-o"></i>Tambah Penjualan</a>
                                </li>
                                <?php if ($_SESSION['jabatan'] == 'pegawai'){ } else{?>
                                <li>
                                    <a href="data_penjualan"><i class="fa fa-circle-o"></i>Data Penjualan</a>
                                </li>
                              <?php }?>
                            <!--          <li>
                                    <a href="add_sale"><i class="fa fa-circle-o"></i>Buat Invoice</a>
                                                  </li>
                                       <li>
                                    <a href="penjualan"><i class="fa fa-circle-o"></i>Data Invoice</a>
                                                  </li>
                                       
                                                  <li>
                                    <a href="retur"><i class="fa fa-circle-o"></i>Retur Barang</a>
                                                  </li>
                                                   <li>
                                    <a href="rekening"><i class="fa fa-circle-o"></i>Rekening</a>
                                                  </li>
                             -->         

                            </ul>
                        </li>

<?php }else{}
              if($chmenu8 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

    <li class="treeview">
          <a href="#"> <i class="glyphicon glyphicon-inbox"></i> <span>Stok</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
            <ul class="treeview-menu">
                <li>
                    <a href="stok_barang"><i class="fa fa-circle-o"></i>Data Stok</a>
                  </li>
                  <li>
                      <a href="stok_in"><i class="fa fa-circle-o"></i>Tambah Stok Masuk</a>
                    </li>
                     <li>
                      <a href="stok_out"><i class="fa fa-circle-o"></i>Tambah Stok Keluar</a>
                    </li>
                   
                      <li>
                        <a href="stok_menipis"><i class="fa fa-circle-o"></i>Stok Menipis</a>
                      </li>
                       
                      <!--
                    <li>
                      <a href="stok_retur"><i class="fa fa-circle-o"></i>Stok Barang Retur</a>
                    </li>
                   -->

                </ul>
              </li>


<?php }else{}
  if($chmenu9 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                          <li class="treeview">
                              <a href="#"> <i class="glyphicon glyphicon-stats"></i> <span>Laporan</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
                 <ul class="treeview-menu">
                                  
                                  <li>
                                      <a href="report_jual"><i class="fa fa-circle-o"></i>Penjualan</a>
                                  </li>
                                  <li>
                      <a href="mutasi"><i class="fa fa-circle-o"></i>Mutasi Stok</a>
                    </li>
                    <li>
                      <a href="report_buy"><i class="fa fa-circle-o"></i>Laporan Pembelian</a>
                    </li>
                            <!--       

                            <li>
                                      <a href="report_beli"><i class="fa fa-circle-o"></i>Pembelian</a>
                                  </li>
                            <li>
                                      <a href="report_inv"><i class="fa fa-circle-o"></i>Invoice Penjualan</a>
                                  </li>
                                  <li>
                                      <a href="report_operasi"><i class="fa fa-circle-o"></i>Operasional</a>
                                  </li>
                                 
                                   <li>
                                      <a href="report_labarugi"><i class="fa fa-circle-o"></i>Laba Rugi</a>
                                  </li>
                            -->
                              </ul>
                          </li>
<?php }else{}
if($chmenu2 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class="fa fa-users"></i> <span>Supplier</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
                                <li>
                                    <a href="supplier"><i class="fa fa-circle-o"></i>Data Supplier</a>
                                </li>
<li>
                                    <a href="add_supplier"><i class="fa fa-circle-o"></i>Tambah Supplier</a>
                                                  </li>
                            </ul>
 
                       </li>

<?php }else{}




if($chmenu1 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>


              <li class="treeview">
                            <a href=""> <i class="glyphicon glyphicon-user"></i> <span>Manajemen User</span> <span class="pull-right-container"> </span> </a>
                               <ul class="treeview-menu">
                                <li>
                                    <a href="admin"><i class="fa fa-circle-o"></i>Daftar User</a>
                                </li>
                <li>
                <a href="add_jabatan"><i class="fa fa-circle-o"></i>Jabatan User</a>
                               </li>
                               
                               
                             <!--  <li>
                
                <a href="pengumuman"><i class="fa fa-circle-o"></i>Pengumuman</a>
                                                  </li> -->
                             
                            </ul>
                        </li> 



<?php }else{} 

 ?>


                    </ul>

                </section>
                <!-- /.sidebar -->
            </aside>
