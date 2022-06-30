 <?php 

 include "configuration/config_connect.php";

 if($_POST['rowid']) {
        $id = $_POST['rowid'];
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap




        $sql = "SELECT * FROM barang WHERE kode = $id";
        $result = mysqli_query($conn,$sql);
        foreach ($result as $baris) { ?>


        <form action="stok_retur" method="post">

             <table class="table table-striped">
                <tr>
                  <th >Nama</th>
                  <th style="width: 30px">Stok Gudang</th>
                  
                </tr>
                <tr>
                  <td><?php echo $baris['nama'];?></td>
                  <td><?php echo $baris['sisa'];;?></td>
                  
                </tr>

                <tr>
                  <th >Stok Retur</th>
                  <th>Jumlah Dipindah</th>
                  
                </tr>

                <tr>
                  <td><?php echo $baris['retur'];?></td>
                  <td><input type="text" value="<?php echo $baris['retur'];?>" name="pindah"></td>
                  
                </tr>

                
                 
                


                
            </table>

            <input type="hidden" value="<?php echo $baris['kode'];?>" name="kode">
            <input type="hidden" value="<?php echo $baris['sisa'];?>" name="sisa">
            <input type="hidden" value="<?php echo $baris['retur'];?>" name="retur">


 <input type="submit" class="btn btn-info btn-flat" value="Pindah Stok" name="simpan">



             
          
        </form>
        
<?php  } }  ?>