<?php 

include "configuration/config_connect.php";


if(isset($_POST['search'])){
    $search = $_POST['search'];

    $query = "SELECT * FROM barang WHERE nama like'%".$search."%'";
    $result = mysqli_query($conn,$query);
    
    while($row = mysqli_fetch_array($result) ){
        $response[] = array("value"=>$row['barcode'],"label"=>$row['nama']);
    }

    echo json_encode($response);
}

exit;


