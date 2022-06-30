<!DOCTYPE html>
<html>
<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
etc();encryption();session();connect();head();body();timing();
//alltotal();
pagination();
?>

<?php
if (!login_check()) {
?>
<meta http-equiv="refresh" content="0; url=logout" />
<?php
exit(0);
}
?>
        <div class="wrapper">
<?php
theader();
menu();
?>
            <div class="content-wrapper">
                <section class="content-header">
</section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
            <div class="col-lg-12">
                        <!-- ./col -->

<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "barang"; // halaman
$dataapa = "Barang"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu6; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
$insert = $_POST['insert'];
$nota= $_GET['nota'];
 
?>


<!-- SETTING STOP -->
 <?php

    if($nota == null || $nota == ""){

            $sqle="SELECT SUM(hargaakhir) as data FROM transaksimasuk WHERE nota='$nota' ";
            $hasile=mysqli_query($conn,$sqle);
            $row=mysqli_fetch_assoc($hasile);
            $datatotal=$row['data'];

            $sqle="SELECT SUM(hargabeliakhir) as data FROM transaksimasuk WHERE nota='$nota'";
            $hasile=mysqli_query($conn,$sqle);
            $row=mysqli_fetch_assoc($hasile);
            $databelitotal=$row['data'];
    }else{

      $sqle="SELECT SUM(hargaakhir) as data FROM transaksimasuk WHERE nota='$nota'";
      $hasile=mysqli_query($conn,$sqle);
      $row=mysqli_fetch_assoc($hasile);
      $datatotal=$row['data'];

      $sqle="SELECT SUM(hargabeliakhir) as data FROM transaksimasuk WHERE nota='$nota'";
      $hasile=mysqli_query($conn,$sqle);
      $row=mysqli_fetch_assoc($hasile);
      $databelitotal=$row['data'];


    }

    ?>

<!-- BREADCRUMB -->
<?php 

//menyimpan ke tabel bayar

    if(isset($_POST["simpan"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
         $tglnota = mysqli_real_escape_string($conn, $_POST["tglnota"]);
         $diskon = mysqli_real_escape_string($conn, $_POST["diskon"]);
         $total = mysqli_real_escape_string($conn, $_POST["total"]);
         $bayar = mysqli_real_escape_string($conn, $_POST["bayar"]);
         $kembali = mysqli_real_escape_string($conn, $_POST["kembali"]);
         $tipe = mysqli_real_escape_string($conn, $_POST["tipe"]);
         $ket = mysqli_real_escape_string($conn, $_POST["keterangan"]);
         $databelitotal = mysqli_real_escape_string($conn, $_POST["beli"]);

          $kasir = $_SESSION["nama"];
              $insert = ($_POST["insert"]);
              $berhasil = "berhasil";

               $sql="select * from bayar where nota='$nota'";
            $result=mysqli_query($conn,$sql);


                  if(mysqli_num_rows($result)>0){

                    echo "<script type='text/javascript'>  alert('Terjadi kesalahan: Nomor Nota yang sama sudah ada!');</script>";
              } else if (( $chmod >= 2 || $_SESSION['jabatan'] == 'admin')&&($bayar >= $datatotal && $bayar != null)) {



                 $sql2 = "insert into bayar values( '$nota','$tglnota','$bayar','$total','$kembali','$databelitotal','$kasir','$diskon','','$tipe','$ket')";
               $insertan = mysqli_query($conn, $sql2);

               //update mutasi
               $sql3 = "UPDATE mutasi SET status='$berhasil' where keterangan='$kode'";
               $updatemutasi = mysqli_query($conn, $sql3);
?>
<script type="text/javascript">
window.onload = function() {
  var win = window.open('print_one.php?nota=<?php echo $nota;?>','Cetak',' menubar=0, resizable=0,dependent=0,status=0,width=260,height=400,left=10,top=10','_blank');
if (win) {
  alert('Berhasil, Data telah disimpan!');
    win.focus();
   window.location = 'add_jual';
} else {
    alert('Silakan Allow Pop Up bila ingin mencetak!');
}
}

</script>
<?php


              } else {
                echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan! Pastikan Data pembayaran benar');</script>";
                echo "<script type='text/javascript'>window.location = 'bayar?nota=$nota';</script>";
              }


       } }


?>

<!-- BREADCRUMB -->

<!-- BOX INSERT BERHASIL -->

         <script>
 window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 5000);
</script>


       <!-- BOX INFORMASI -->
    <?php
if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
  ?>


  <!-- KONTEN BODY AWAL -->
                         <!-- Default box -->
                         <div class="col-lg-9">
      <div class="main box">

       

<div class="row">


        <div class="box-body col-lg-8">
         

            <!--tabel-->

<div class="box-body no-padding">
     <?php
     
           error_reporting(E_ALL ^ E_DEPRECATED);

           $sql    = "select * from transaksimasuk where nota ='$nota' order by no";
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
              <table class="table table-condensed">
               <thead>
                      <tr>
                          <th>No</th>
                          <th style="width: 55%">Nama Barang</th>
                          
                          <th>Jumlah Jual</th>
                          <th>Total</th>
           
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
           
           <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?> x <?php  echo mysqli_real_escape_string($conn, 'Rp '.number_format($fill['harga'], $decimal, $a_decimal, $thousand).',-'); ?></td>
           <td><?php  echo mysqli_real_escape_string($conn, 'Rp '. number_format(($fill['jumlah']*$fill['harga']), $decimal, $a_decimal, $thousand).',-'); ?></td>
          </tr>
           <?php
           $i++;
           $count++;
           }

           ?>
           </tbody>


              </table>
            </div>
            <!--end tabel-->


        </div>

         <div class="box-body">
            <div class="col-lg-3">
                                        <script>
                                   function sum1() {
                                         var txtFirstNumberValue =  document.getElementById('subtotal').value
                                         var txtSecondNumberValue = document.getElementById('diskon').value;
                                         var result = parseFloat(txtFirstNumberValue) - parseFloat(txtSecondNumberValue);
                                         if (!isNaN(result)) {
                                            document.getElementById('total').value = result;
                                            document.getElementById('disc').value = txtSecondNumberValue;
                                            document.getElementById('tot').value = result;
                                         }
                                       if (!$(bayar).val()){
                                         document.getElementById('total').value = "0";
                                       }
                                       if (!$(total).val()){
                                         document.getElementById('total').value = "0";
                                       }
                                   }
                                   </script>

                                   
                <!-- /.box-header -->
            <div class="box-body no-padding">
<form action="bayar" method="post" id="Myform" class="form-user">

              <table class="table table-striped">
                <tr>


                  
                  <th>Sub total</th>
                  <input type="hidden" value="<?php echo $nota;?>" class="form-control" name="nota">
                  <input type="hidden" value="<?php echo $datatotal;?>" class="form-control" id="subtotal">
                  <input type="hidden" value="<?php echo $databelitotal;?>" class="form-control" name="beli">
                  
                  <th ><input type="text" value="<?php echo number_format($datatotal, $decimal, $a_decimal, $thousand).',-'; ?>" class="form-control" readonly></th>
                </tr>
                <tr>
                 
                  <td>Diskon(Rp)</td>
                 
                  <td><input type="text" class="form-control" id="diskon" name="diskon" value="0" onkeyup="sum1();"></td>
                </tr>
                <tr>


                     <script>
                                   function sum2() {
                                         var txtFirstNumberValue =  document.getElementById('jumlah').value
                                         var txtSecondNumberValue = document.getElementById('total').value;
                                         var result = parseFloat(txtFirstNumberValue) - parseFloat(txtSecondNumberValue);
                                         if (!isNaN(result)) {
                                            document.getElementById('kembalian').value = result;
                                            document.getElementById('change').value = result;
                                            document.getElementById('pay').value = txtFirstNumberValue;
                                         }
                                       if (!$(jumlah).val()){
                                         document.getElementById('kembalian').value = "0";
                                       }
                                       if (!$(total).val()){
                                         document.getElementById('kembalian').value = "0";
                                       }
                                   }
                                   </script>
                  
                  <td>Total Bayar</td>
                 
                  <td><input type="text" class="form-control" value="<?php echo $datatotal;?>" id="total" name="total" readonly></td>
                </tr>
                
                  
                  <td>Jumlah Bayar</td>
                  
                  <td><input type="text" class="form-control" id="jumlah" name="bayar" autocomplete="off" onkeyup="sum2();"></td>
                </tr>

                <tr>
                  
                  <td>Uang Kembali</td>
                  
                  <td><input type="text" class="form-control" name="kembali" id="kembalian" readonly></td>

                </tr>

                <tr>

                  <input type="hidden" class="form-control" name="tipe" value=Cash></td>
                  
                </tr>
                <tr>

                 <tr>
                  
                  <td>Keterangan</td>
                  
                  <td><textarea name="keterangan"></textarea> </td>

                </tr>

                <tr>
                  
                  <td>Tanggal Transaksi</td>
                  
                  <td><input type="text" class="form-control" id="datepicker2" name="tglnota"></td>

                </tr>



                 <tr>
                  
                  <td > <input type="button" class="btn btn-block pull-left btn-flat btn-danger"  onclick="window.open('add_jual','_self')" value="KEMBALI" /> </td>
                  <td ><button type="submit" class="btn btn-block pull-left btn-flat btn-success" name="simpan" onclick=" document.getElementById('Myform').submit();" >SIMPAN</button></td>
                  
                  

                </tr>
              </table>
          </form>
            </div>
            <!-- /.box-body -->
            </div>
         

           


        </div>

</div>
                                <!-- /.box-body -->
                            </div>
                       

                       </div>

                       <!--
<script>
function myFunction() {
    document.getElementById("Myform").submit();
}

         var helpWindow;

function Struk(url) {
    helpWindow = window.open(url, 'helpWindow');


}
      </script>

  -->

  <!---STRUK-->
<?php 
        $sql1="SELECT * FROM data";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $nama=$row['nama'];
        $alamat=$row['alamat'];
        $notelp=$row['notelp'];
        $tagline=$row['tagline'];
        $signature=$row['signature'];
        $avatar=$row['avatar'];

        $sql1="SELECT * FROM bayar where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $tglbayar=$row['tglbayar'];
        $bayar=$row['bayar'];
        $total=$row['total'];
        $kembali=$row['kembali'];
        $kasir=$row['kasir'];

        $sql1="SELECT SUM(jumlah) as data FROM transaksimasuk where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $totalqty=$row['data'];

        $sql1="SELECT * FROM transaksimasuk where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $kode=$row['kode'];
        $berhasil="berhasil";

        $sql1="SELECT * FROM mutasi where keterangan='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $status=$row['status'];

        if($status=="pending" || $status=="berhasil" ){
        //update mutasi
               $sql3 = "UPDATE mutasi SET status='$berhasil' where keterangan='$nota'";
               $updatemutasi = mysqli_query($conn, $sql3);
             }

        ?>
  <!--END STRUK-->

<link rel="stylesheet" href="dist/plugins/print/one.css">
<style>
input {
      border-top-style: hidden;
      border-right-style: hidden;
      border-left-style: hidden;
      border-bottom-style: hidden;
      background-color: #fefefe;
      text-align:right;
      }
    </style>
                        <div class="col-lg-3">
      <div class="box">

        <div class="box-header with-border">

          <h3 class="box-title">Tampilan Struk</h3>

          <div class="box-tools pull-right">
            
           
          </div>
        </div>
        <div class="box-body">
          


 <table  class="table-header">

        <!-- <tr><td><img src=\dist\img\avatar.png></td></tr>  -->
<!--        <tr><td colspan="4" class="nama" style="font-size:16px; align=left; font-weight:bold; width:240px"><?php echo $nama;?></td></tr>
             <tr><td colspan="4" style="font-style:italic; width:240px;  "><?php echo $tagline;?></td></tr>
        <tr><td colspan="4" style="width:240px;"><?php echo $alamat;?></td></tr>
        <tr><td colspan="4" style="border-bottom:double 4px #000; padding-bottom:5px;width:240px;"><?php echo $notelp;?></td></tr>
-->

</table>
        </table>

        <table class="table-print">
        <tr class="spa">
        <td width="20%" style="width:48px;">&nbsp;</td>
        <td width="15%" style="width:28.8px;">&nbsp;</td>
        <td width="20%"  style="width:43.2px;">&nbsp;</td>
        <td width="18%"  style="width:48px;">&nbsp;</td>
        <td width="18%"  style="width:60px;">&nbsp;</td>
        <td width="8%"  style="width:12px;">&nbsp;</td>
        </tr>
        <tr>
        </tr>

        <tr >
           <td style="width:192px;" colspan="6" align="left">No.Nota - <?php echo $nota;?></td>
        </tr>
        
           <tr class="siv solid">
            <td colspan="6" style="width:240px;">
          <div class="solid-border" ></div>
        </td>
          </tr>

          <?php

          $query1="SELECT * FROM  transaksimasuk where nota ='$nota' order by no";
          $hasil = mysqli_query($conn,$query1);
          while ($fill = mysqli_fetch_assoc($hasil)){
            ?>

            <tr>
              <td colspan="5" style="width:240px;"><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
              </tr>

              <tr>

              <td colspan="2" style="width:76.8px;">Qty : </td>
              <td ><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?> x</td>
              <td style="width:40px;" align="center"><?php  echo number_format(($fill['harga']), $decimal, $a_decimal, $thousand).',-'; ?></td>
              <td style="width:72px;" colspan="2" align="right"><?php  echo number_format(($fill['hargaakhir']), $decimal, $a_decimal, $thousand).',-'; ?></td>
              </tr>

            <tr class="siv">
              <td colspan="5" style="width:228px;">
            <div class="dotted-border"></div> </td>
            <td style="width:12px;">(+) </td>
            </tr>

            <?php
            ;
          }

           ?>

        <tr>
          <td colspan="2" style="width:76.8px;">Total Qty</td>
          <td style="width:43.2px;"><?php echo $totalqty; ?></td>
          <td style="width:48px;"><b>Sub Total</b></td>
          <td style="width:72px;" colspan="2" align="right"><b><?php echo number_format($datatotal, $decimal, $a_decimal, $thousand).',-';?></b></td>
         </tr>

        <tr>
          <td colspan="3" style="width:120px;"></td>
          <td style="width:48px;">Diskon</td>
          <td style="width:72px;" colspan="2" align="right"><input type="text" id="disc"></td>
          </tr>

           <tr>
          <td colspan="3" style="width:120px;"></td>
          <td style="width:48px;"><b>Total</b></td>
          <td style="width:72px;" colspan="2" align="right"><input type="text" id="tot"></td>
          </tr>

           <tr>
          <td colspan="3" style="width:120px;"></td>
          <td style="width:48px;">Bayar</td>
          <td style="width:72px;" colspan="2" align="right"><input type="text" id="pay"></td>
          </tr>

        <tr class="siv">
          <td colspan="5" style="width:228px;">
        <div class="dotted-border"></div> </td>
        <td style="width:12px;">(-) </td>
        </tr>

        <tr>
          <td colspan="3" style="width:116px;"></td>
          <td style="width:52px;">Kembali</td>
          <td style="width:72px;" colspan="2" align="right"><input type="text" id="change"></td>
          </tr>

           <tr class="siv solid">
            <td colspan="6" style="width:240px;">
          <div class="solid-border" ></div>
        </td>
          </tr>

        <tr>
          <td style="width:237px;" colspan="6" align="right"><?php echo $kasir;?></td>
          </tr>

           <tr class="siv solid">
            <td colspan="6" style="width:240px;">
          <div class="solid-border" ></div>
        </td>
          </tr>

       
         
        </table>



        </div>

                                <!-- /.box-body -->
                            </div>
                       

                       </div>

<?php
} else {
?>
   <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa;?> ini .</b>
    </div>
    <?php
}
?>
                        <!-- ./col -->
                    </div>

                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <!-- /.Left col -->
                    </div>
                    <!-- /.row (main row) -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php  footer(); ?>
            <div class="control-sidebar-bg"></div>
        </div>
          <!-- ./wrapper -->

<!-- Script -->
    <script src='jquery-3.1.1.min.js' type='text/javascript'></script>

    <!-- jQuery UI -->
    <link href='jquery-ui.min.css' rel='stylesheet' type='text/css'>
    <script src='jquery-ui.min.js' type='text/javascript'></script>

<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="1-11-4-jquery-ui.min.js"></script>

        <script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
        <script src="dist/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="dist/plugins/morris/morris.min.js"></script>
        <script src="dist/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script src="dist/plugins/knob/jquery.knob.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="dist/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="dist/plugins/datepicker/bootstrap-datepicker.js"></script>
        <script src="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="dist/plugins/fastclick/fastclick.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="dist/js/demo.js"></script>
    <script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="dist/plugins/fastclick/fastclick.js"></script>
    <script src="dist/plugins/select2/select2.full.min.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="dist/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="dist/plugins/iCheck/icheck.min.js"></script>

<!--fungsi AUTO Complete-->
<!-- Script -->
    <script type='text/javascript' >
    $( function() {
  
        $( "#barcode" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "server.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#nama').val(ui.item.label);
                $('#barcode').val(ui.item.value); // display the selected text
                $('#hargajual').val(ui.item.hjual);
                $('#stok').val(ui.item.sisa); // display the selected text
                $('#hargabeli').val(ui.item.hbeli);
                $('#jumlah').val(ui.item.jumlah);
                $('#kode').val(ui.item.kode); // save selected id to input
                return false;
                
            }
        });

        // Multiple select
        $( "#multi_autocomplete" ).autocomplete({
            source: function( request, response ) {
                
                var searchText = extractLast(request.term);
                $.ajax({
                    url: "server.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: searchText
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function( event, ui ) {
                var terms = split( $('#multi_autocomplete').val() );
                
                terms.pop();
                
                terms.push( ui.item.label );
                
                terms.push( "" );
                $('#multi_autocomplete').val(terms.join( ", " ));

                // Id
                var terms = split( $('#selectuser_ids').val() );
                
                terms.pop();
                
                terms.push( ui.item.value );
                
                terms.push( "" );
                $('#selectuser_ids').val(terms.join( ", " ));

                return false;
            }
           
        });
    });

    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }

    </script>

<!--AUTO Complete-->

<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy/mm/dd"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("yyyy-mm-dd", {"placeholder": "yyyy/mm/dd"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'YYYY/MM/DD h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Hari Ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Akhir 7 Hari': [moment().subtract(6, 'days'), moment()],
            'Akhir 30 Hari': [moment().subtract(29, 'days'), moment()],
            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            'Akhir Bulan': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

   $('.datepicker').datepicker({
    dateFormat: 'yyyy-mm-dd'
 });

   //Date picker 2
   $('#datepicker2').datepicker('update', new Date());

    $('#datepicker2').datepicker({
      autoclose: true
    });

   $('.datepicker2').datepicker({
    dateFormat: 'yyyy-mm-dd'
 });


    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
</body>
</html>
