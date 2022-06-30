 <?php 

 include "configuration/config_connect.php";

 if($_POST['rowid']) {
        $id = $_POST['rowid'];
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap

$sql1="SELECT * FROM retur where nota='$id'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $status=$row['status'];


        $sql = "SELECT * FROM bayar WHERE nota = $id";
        $result = mysqli_query($conn,$sql);
        foreach ($result as $baris) { ?>


        <form action="update.php" method="post">

             <table class="table table-striped">
                <tr>
                  <th style="width: 30px">Nota</th>
                  <th style="width: 30px">Subtotal</th>
                  <th style="width: 30px">Diskon</th>
                  <th style="width: 40px">Total</th>
                </tr>
                <tr>
                  <td><?php echo $baris['nota'];?></td>
                  <td><?php $subtotal = $baris['diskon']+$baris['total'];
                   echo $subtotal;?></td>
                  <td>
                   <?php echo $baris['diskon'];?>
                  </td>
                  <td><?php echo $baris['total'];?></td>
                </tr>

                <tr>
                  <th style="width: 10px">Bayar</th>
                  <th>Kembalian</th>
                  <th>Kasir</th>
                  <th style="width: 40px">Tanggal</th>
                </tr>

                <tr>
                  <td><?php echo $baris['bayar'];?></td>
                  <td><?php echo $baris['kembali'];?></td>
                  <td>
                    <?php echo $baris['kasir'];?>
                  </td>
                   <?php  $tglbayar = date("d-m-Y",strtotime($baris['tglbayar'])); ?>
                  <td><?php echo $tglbayar;?></td>
                </tr>


                
                <?php if ($status=="Retur"){ ?>
                 <tr style="background-color: #3498DB ">
                  <th style="width: 10px">Status</th>
                  <th>Kembalian</th>
                  <th>Kasir</th>
                  <th style="width: 40px">Tanggal</th>
                </tr>

                <tr>
                  <td><?php echo $row['status'];?></td>
                   <?php  $tanggal = date("d-m-Y",strtotime($row['tanggal'])); ?>
                  <td><?php echo $tanggal;?></td>
                  <td>
                    <?php echo $row['dana'];?>
                  </td>
                  <td><?php echo $row['petugas'];?></td>
                </tr>
              <?php } else {} ?>
            </table>





             <?php 
           error_reporting(E_ALL ^ E_DEPRECATED);
           $halaman = "retur_fetch"; // halaman
           $not = $baris['nota'];

           $sql    = "select * from dataretur where nota ='$not' order by no";
           $result = mysqli_query($conn, $sql);
           $rpp    = 30;
           $reload = "$halaman"."?pagination=true";
           $page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);



           if ($page <= 0)
           $page = 1;
           $tcount  = mysqli_num_rows($result);
           $tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
           $count   = 0;
           $i       = ($page - 1) * $rpp;
           $no_urut = ($page - 1) * $rpp;
           ?>

             <div class="box-body no-padding">
              <span class="badge bg-red">Barang Diretur</span>
              <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Nama Barang</th>
                  <th>Qty Diretur</th>
                  <th style="width: 40px">Dikembalikan</th>
                </tr>
                 <?php
           error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
           while(($count<$rpp) && ($i<$tcount)) {
           mysqli_data_seek($result,$i);
           $fill = mysqli_fetch_array($result);
           ?>
                <tbody>

                <tr>
                  <td><?php echo ++$no_urut;?></td>
                  <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                  <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?> x <?php  echo mysqli_real_escape_string($conn, $fill['harga']); ?>
                    
                  </td>
                  <td><?php  echo mysqli_real_escape_string($conn, $fill['hargaakhir']); ?></td>
                </tr>
             <?php
           $i++;
           $count++;
           }

           ?>
           </tbody></table>
           <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>

               
                
              </table>
            </div>




             <?php
           error_reporting(E_ALL ^ E_DEPRECATED);
           $halaman = "retur_fetch"; // halaman
           $not = $baris['nota'];

           $sql    = "select * from transaksimasuk where nota ='$not' and retur !='YES' order by no";
           $result = mysqli_query($conn, $sql);

           if(mysqli_num_rows($result)>0){

           $rpp    = 30;
           $reload = "$halaman"."?pagination=true";
           $page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);



           if ($page <= 0)
           $page = 1;
           $tcount  = mysqli_num_rows($result);
           $tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
           $count   = 0;
           $i       = ($page - 1) * $rpp;
           $no_urut = ($page - 1) * $rpp;
           ?>

             <div class="box-body no-padding">
              <span class="badge bg-blue">Daftar Transaksi Barang</span>
              <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Nama Barang</th>
                  <th>Qty Terjual</th>
                  <th style="width: 40px">Jumlah</th>
                </tr>
                 <?php
           error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
           while(($count<$rpp) && ($i<$tcount)) {
           mysqli_data_seek($result,$i);
           $fill = mysqli_fetch_array($result);
           ?>
                <tbody>

                <tr>
                  <td><?php echo ++$no_urut;?></td>
                  <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                  <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?> x <?php  echo mysqli_real_escape_string($conn, $fill['harga']); ?>
                    
                  </td>
                  <td><?php  echo mysqli_real_escape_string($conn, $fill['hargaakhir']); ?></td>
                </tr>
             <?php
           $i++;
           $count++;
           }

           ?>
           </tbody></table>









           <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} } ?></div>

               
                
              </table>
            </div>







            <!-- /.box-body -->

          
        </form>
        
<?php  } }  ?>