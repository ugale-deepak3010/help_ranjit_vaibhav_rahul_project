<?php

require "dbconnect.php";


$phone= $_POST['phone'];
$password = $_POST['password'];
$rep_password = $_POST['rep_password'];


$sql_change_password= " UPDATE user SET password ='$password', confirm_password='$rep_password' WHERE phone='$phone'";

if($conn->query($sql_change_password)){
    echo "changes password success";
}else{
    echo "changes faild";
}



?>