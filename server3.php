<?php 

include "configuration/config_connect.php";
$jumlah = 0;
$bayar = 0;

if(isset($_POST['search'])){
    $search = $_POST['search'];

    $query = "SELECT * FROM barang WHERE barcode like'%".$search."%'";
    $result = mysqli_query($conn,$query);
    
    while($row = mysqli_fetch_array($result) ){
        $response[] = array("value"=>$row['barcode'],"label"=>$row['nama'],"hjual"=>$row['terjual'],"sisa"=>$row['sisa'],"hbeli"=>$row['terbeli'],"kode"=>$row['kode'],"jumlah"=>$jumlah,"bayar"=>$bayar);
    }

    echo json_encode($response);
}

exit;


