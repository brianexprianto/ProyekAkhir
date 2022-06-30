<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$tipe=$_GET['tipe'];
$nota = $_GET["nota"];

include "configuration/config_connect.php";
$halaman = "faktur_one"; // halaman
$dataapa = "Faktur"; // data

if($tipe=='quotation'){
$tabel = "quotation"; // tabel database
$tabeldatabase = "quotation_list"; // tabel database
$judul="Penawaran";

      $sql1="SELECT * FROM $tabel where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        
        $nomor=$row['nomor'];
        $due=$row['due'];
        $bayar=$row['oleh'];
        $biaya=$row['biayatambahan'];
        $total=$row['total'];
        $status=$row['status'];
         $tgl=$row['tgl'];
        $pelanggan=$row['pelanggan'];
        $diskon=$row['diskon'];
        $pot=$row['potongan'];
         $keterangan=$row['keterangan'];
        $batas="Berlaku Sampai*";
} else {

$tabel = "sale"; // tabel database
$tabeldatabase = "invoicejual"; // tabel database
$judul="Invoice";

  $sql1="SELECT * FROM $tabel where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        
        $nomor=$row['nomor'];
        $due=$row['duedate'];
        $bayar=$row['kasir'];
        $biaya=$row['biaya'];
        $total=$row['total'];
        $status=$row['status'];
         $tgl=$row['tglsale'];
        $pelanggan=$row['pelanggan'];
        $diskon=$row['diskon'];
        $pot=$row['potongan'];
         $keterangan=$row['keterangan'];
        $batas="Jatuh Tempo";
}


$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman


date_default_timezone_set("Asia/Jakarta");
$today = date('d-m-Y');
 
?>

<?php
date_default_timezone_set("Asia/Jakarta");
$today = date('d-m-Y');

        $sql1="SELECT * FROM data";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $nama=$row['nama'];
        $alamat=$row['alamat'];
        $notelp=$row['notelp'];
        $tagline=$row['tagline'];
        $signature=$row['signature'];
        $avatar=$row['avatar'];
                    
        $sql1="SELECT * FROM pelanggan where kode='$pelanggan' ";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $customer=$row['nama'];
        $nohp=$row['nohp'];
        $address=$row['alamat'];


?>



<head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> <?php echo $judul;?></title>
<link href="libs/faktur/two/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="libs/faktur/two/bootstrap.min.js"></script>
<script src="libs/faktur/two/jquery.min.js"></script>
 <link rel="stylesheet" href="libs/faktur/two/style.css" >

<!------ Include the above in your HEAD tag ---------->
</head>

<style>
@media print {
  #printPageButton {
    display: none;
  }
}
</style>


<div id="invoice">

    <div class="toolbar hidden-print">
        <div class="text-right">
            <button id="printPageButton" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
           
        </div>
        <hr>
    </div>
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <a target="_blank">
                            <img src="<?php echo $avatar;?>" data-holder-rendered="true" style="width:90px;height:90px;" />
                            </a>
                    </div>
                    <div class="col company-details">
                        <h2 class="name">
                            <a target="_blank" href="">
                            <?php echo $nama;?>
                            </a>
                        </h2>
                       <div> <?php echo $alamat;?></div>
                        <div> <?php echo $notelp;?></div>
                        <div> <?php echo $tagline;?></div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">KEPADA:</div>
                        <h2 class="to"><?php echo $customer;?></h2>
                        <div class="address">  <?php echo $address;?></div>
                        <div class="email"><?php echo $nohp;?></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id"><?php echo $judul;?> <?php echo $nota;?></h1>
                        <div class="date"><?php echo $batas;?>: <?php echo date('d-m-Y',strtotime($due));?></div>
                        
                    </div>
                </div>

                <?php
           error_reporting(E_ALL ^ E_DEPRECATED);
           $halaman = "faktur_two"; // halaman
           $sql    = "select * from $tabeldatabase where nota ='$nota' order by no";
           $result = mysqli_query($conn, $sql);
           $rpp    = 15;
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
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-left">PRODUK</th>
                            <th class="text-right">HARGA SATUAN</th>
                            <th class="text-right">JUMLAH</th>
                            <th class="text-right">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
           error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
           while(($count<$rpp) && ($i<$tcount)) {
           mysqli_data_seek($result,$i);
           $fill = mysqli_fetch_array($result);
           ?>

                        <tr>
                            <td class="no"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                            <td class="unit"><?php  echo mysqli_real_escape_string($conn, number_format($fill['harga'], $decimal, $a_decimal, $thousand).',-'); ?></td>
                            <td class="qty"><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
                            <td class="total"><?php  echo mysqli_real_escape_string($conn, number_format(($fill['jumlah']*$fill['harga']), $decimal, $a_decimal, $thousand).',-'); ?></td>
                        </tr>
                      

         <?php
           $i++;
           $count++;
           }

           ?>
                      
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td><?php echo number_format(($pot+$total-$biaya), $decimal, $a_decimal, $thousand).',-';?></td>
                        </tr>
                        <tr>
                            <td colspan="2" ></td>
                            <td colspan="2">DISKON <?php echo $diskon;?>%</td>
                            <td> <?php echo number_format($pot, $decimal, $a_decimal, $thousand).',-';?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:left">
                              <?php if($tipe=='quotation'){?>
                              <b>*Berlaku sampai batas yang ditentukan</b>
                              <?php } ?>
                            </td>
                            <td colspan="2">Biaya Tambahan</td>
                            <td> <?php echo number_format($biaya, $decimal, $a_decimal, $thousand).',-';?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">GRAND TOTAL</td>
                            <td>Rp. <?php echo number_format($total, $decimal, $a_decimal, $thousand).',-';?></td>
                        </tr>
                    </tfoot>
                </table>

<?php if($tipe=='quotation'){?>


     <div class="notices">
    Catatan: <?php echo $keterangan;?>
  </div>
 <div>
   Dibuat pada <?php echo date('d-m-Y',strtotime($tgl));?>   
 </div>


  
<?php } else {?>

                <?php if ($status=='sudah'){?>

                <div class="thanks">LUNAS</div>
            <?php } else { ?>
                <div class="notices">
                    <div>Pembayaran:</div>
                      <?php 
          $query1="SELECT * FROM  rekening order by no ";
               $hasil = mysqli_query($conn,$query1);
          while ($fill = mysqli_fetch_assoc($hasil)){
            ?>
    <div class="notice"><strong><?php echo $fill['bank'];?>:</strong>  <?php echo $fill['norek'];?> A.n <?php echo $fill['nama'];?></div>
                     
        <?php } ?>
                </div>
        <?php } ?>

<?php } ?>

            </main>
            <footer>
            <?php echo $signature?>
            </footer>
        </div>
       
        <div></div>
    </div>
</div>

<script>
 $('#printPageButton').click(function(){
            Popup($('.invoice')[0].outerHTML);
            function Popup(data) 
            {
                window.print();
                return true;
            }
        });
    </script>