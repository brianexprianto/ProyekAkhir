<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
   <link rel="stylesheet" href="dist/bootstrap/css/bootstrap.min.css"> 
    <!-- Font Awesome -->
    <link rel="stylesheet" href="dist/ico/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="dist/ico/ionicons/css/ionicons.min.css">
        <!-- Theme style -->         
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css"> 
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>



<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));


include "configuration/config_chmod.php";
include "configuration/config_connect.php";
$halaman = "invoice_jual"; // halaman
$dataapa = "Invoice Penjualan"; // data
$tabeldatabase = "invoicejual"; // tabel database
$chmod = $chmenu6; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$tabel = "sale";

date_default_timezone_set("Asia/Jakarta");
$today = date('d-m-Y');
 
?>
<?php
        $decimal ="0";
        $a_decimal =",";
        $thousand =".";
        ?>
<?php
        $nota = $_GET["nota"];

        $sql1="SELECT * FROM data";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $nama=$row['nama'];
        $alamat=$row['alamat'];
        $notelp=$row['notelp'];
        $tagline=$row['tagline'];
        $signature=$row['signature'];
        $avatar=$row['avatar'];

        $sql1="SELECT * FROM $tabel where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
       
        $bayar=$row['kasir'];
        $total=$row['total'];
        $status=$row['status'];
        $keterangan=$row['keterangan'];
        $pelanggan=$row['pelanggan'];
        $diskon=$row['diskon'];
        $pot=$row['potongan'];
           $biaya=$row['biaya'];
         $totalprice=$total+$pot-$biaya;

         $tglbayar = date("d-m-Y",strtotime($row['tglsale']));

          $due = date("d-m-Y",strtotime($row['duedate']));

        $sql1="SELECT * FROM pelanggan where kode='$pelanggan' ";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $customer=$row['nama'];
        $nohp=$row['nohp'];
        $address=$row['alamat'];



        ?>


<body onload="window.print();">
  <!--   -->
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> <?php echo $nama;?>
          <small class="pull-right">Date: <?php echo $today;?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong><?php echo $nama;?></strong><br>
          <?php echo $alamat;?><br>
          Phone: <?php echo $notelp;?><br>
      <!--    Email: info@<almasaeedstudio class="com">-->
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong><?php echo $customer;?></strong><br>
          <?php echo $address;?><br>
            
            Phone: <?php echo $nohp;?><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Invoice  #<?php echo $nota;?></b><br>
        <br>
        
        <b>Payment Due:</b> <?php echo $due;?><br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <?php
           error_reporting(E_ALL ^ E_DEPRECATED);

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
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
              <th>No</th>
              <th>Product</th>
              <th>Price/item</th>
              <th>Qty</th>
              <th>Subtotal</th>
            </tr>
          </thead>
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
             <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['harga'], $decimal, $a_decimal, $thousand).',-'); ?></td>
              <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
               <td><?php  echo mysqli_real_escape_string($conn, number_format(($fill['jumlah']*$fill['harga']), $decimal, $a_decimal, $thousand).',-'); ?></td>
            </tr>
            

            <?php
           $i++;
           $count++;
           }

           ?>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <?php if ($status=='belum'){?>
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Payment Options:</p>
           <?php 
         $query1="SELECT * FROM  rekening order by no ";
               $hasil = mysqli_query($conn,$query1);
          while ($fill = mysqli_fetch_assoc($hasil)){
            ?>
          <p><strong><?php echo $fill['bank'];?>:</strong>   <?php echo $fill['norek'];?> A.n <?php echo $fill['nama'];?></p>
        <?php } ?>

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            <?php echo $keterangan;?>
          </p>
        </div>
         <div class="col-xs-6">
          <p class="lead"></p>

        <?php } else {?>

          <div class="col-xs-6">
        
        <img src="dist/img/lunas.png" alt="Visa">
        
      </div>
      <div class="col-xs-6">
          <p class="lead">Paid</p>

          <?php } ?>
        <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead"></p>

       
          <table class="table">
            <tr>
                <th>Sub Total:</th>
                <td>Rp. <?php echo number_format($totalprice, $decimal, $a_decimal, $thousand).',-';?></td>
              </tr>
               <tr>
                <th>Discount(<?php echo $diskon;?>)%:</th>
                <td>Rp. <?php echo number_format($pot, $decimal, $a_decimal, $thousand).',-';?></td>
              </tr>
              <tr>
                <th>Biaya Tambahan:</th>
                <td>Rp. <?php echo number_format($biaya, $decimal, $a_decimal, $thousand).',-';?></td>
              </tr>
              <tr>
                <th>Total:</th>
                <td><b>Rp. <?php echo number_format($total, $decimal, $a_decimal, $thousand).',-';?></b></td>
              </tr>
          </table>
       
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<H4 align="center"><?php echo $signature?><H4>
<!-- ./wrapper -->
</body>
</html>
