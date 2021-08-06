<?php

require "dbconnect.php";

$phone= $_POST['phone'];


//echo $user_name.$password;

$sql_forgot = "SELECT * FROM user WHERE phone='$phone'";

if($res = mysqli_query($conn, $sql_forgot)){ 

    if(mysqli_num_rows($res) > 0){
    /* Value Found */  
        while($row = mysqli_fetch_array($res)){
            $phone_reset = $row['phone'];
            //echo "phone matched <a href='../change_password.php'>change Password </a> ";
            header("Location:../change_password.php?phone=$phone_reset");
        }
    }else{
        echo "Invalid Phone";
    }
}



?>