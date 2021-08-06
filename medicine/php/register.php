<?php

require "dbconnect.php";


$full_name = $_POST['fname'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$user_name_=$_POST['user_name'];
$password=$_POST['password'];
$rep_password=$_POST['rep_password'];

//echo $full_name.$email.$phone.$user_name_.$password.$rep_password;


$sql_register= "INSERT INTO user (full_name, email, phone, user_name, password, confirm_password ) VALUES ('$full_name', '$email', '$phone', '$user_name_', '$password', '$rep_password')";

//echo $sql_register;

if($conn->query($sql_register)){
    echo "registration  success";
}else{
    echo "registration faild";
}


?>