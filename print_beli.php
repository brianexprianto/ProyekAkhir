<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aplikasi IndoTory PRO | Invoice</title>
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
$halaman = "invoice_beli"; // halaman
$dataapa = "Invoice Pembelian"; // data
$tabeldatabase = "invoicebeli"; // tabel database
$chmod = $chmenu5; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$tabel = "buy";

 
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
        $tglbayar=$row['tglsale'];
        $bayar=$row['kasir'];
        $total=$row['total'];
        $keterangan=$row['keterangan'];
        $supplier=$row['supplier'];
        $status=$row['status'];
       
        $sql1="SELECT * FROM supplier where kode='$supplier' ";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $customer=$row['nama'];
        $nohp=$row['nohp'];
        $address=$row['alamat'];


        $sql1="SELECT SUM(jumlah) as data FROM $tabeldatabase where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $totalqty=$row['data'];

        $sql1="SELECT SUM(hargaakhir) as data FROM $tabeldatabase where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $totalprice=$row['data'];

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
          <i></i> <?php echo $nama;?>
          <small class="pull-right"><?php echo  $tglbayar;?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        FROM:
        <address>
          <strong><?php echo $customer;?></strong><br>
          <?php echo $address;?><br>
          Phone: <?php echo $nohp;?><br>
      <!--    Email: info@<almasaeedstudio class="com">-->
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To:
        <address>
          <strong><?php echo $nama;?></strong><br>
          <?php echo $alamat;?><br>
            
            Phone: <?php echo $notelp;?><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Invoice  #<?php echo $nota;?></b><br>
        <br>
        
        <b>Payment Due:</b> <?php echo $tglbayar;?><br>
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
              <th>Price/Item</th>
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
          <img src="dist/img/credit/bca.png" alt="BCA">
          <img src="dist/img/credit/mandiri.png" alt="Mandiri">
          <img src="dist/img/credit/bni.png" alt="bni">
          <img src="dist/img/credit/bri.png" alt="bri">

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            <?php echo $keterangan;?>
          </p>
        </div>
         <div class="col-xs-6">
          <p class="lead">Jatuh Tempo <?php echo $tglbayar;?></p>

        <?php } else if($status=='hutang'){?>

<div class="col-xs-6">
   <p class="lead"><h2>Hutang</h2></p>
  </div>

        <?php } else {?>

          <div class="col-xs-6">
        
        <img src="dist/img/lunas.png" alt="Visa">
        
      </div>
      <div class="col-xs-6">
          <p class="lead">Paid</p>

          <?php } ?>


      <div class="col-xs-6">
        <p class="lead">Amount Due <?php echo $tglbayar;?></p>

        
          <table class="table">
            <tr>
                <th style="width:50%">Total Qty:</th>
                <td><?php echo $totalqty;?> Pcs</td>
              </tr>
              
              <tr>
                <th>Total:</th>
                <td>Rp. <?php echo number_format($totalprice, $decimal, $a_decimal, $thousand).',-';?></td>
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
