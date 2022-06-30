<?php

include 'configuration/config_connect.php';

if(isset($_POST['username'])){
    $username = $_POST['username'];

    $query = "select count(*) as cntUser from user where userna_me='".$username."'";
    
    $result = mysqli_query($conn,$query);
    $response = "<span style='color: green;'>Tersedia.</span>";
    if(mysqli_num_rows($result)){
        $row = mysqli_fetch_array($result);
    
        $count = $row['cntUser'];
        
        if($count > 0){
            $response = "<span style='color: red;'>Sudah dipakai.</span>";
        }
       
    }
    
    echo $response;
    die;
}
