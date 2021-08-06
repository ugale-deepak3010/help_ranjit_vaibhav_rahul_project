<?php

require "dbconnect.php";

$user_name= $_POST['user_name'];
$password =$_POST['password'];

//echo $user_name.$password;

$sql_login= "SELECT * FROM user WHERE user_name='$user_name' && password='$password'";

if($res = mysqli_query($conn, $sql_login)){ 

    if(mysqli_num_rows($res) > 0){
    /* Value Found */  
        while($row = mysqli_fetch_array($res)){
            $user_name =$row['user_name'];
            $password =$row['password'];

            echo "login success <br> redirecting you ";
        }
    }else{
        echo "Invalid Password and ID ";
    }
}



?>