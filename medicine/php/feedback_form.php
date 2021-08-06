<?php
require "dbconnect.php";

$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];
$pin_code = $_POST['pin_code'];
$state = $_POST['state'];
$country = $_POST['country'];
$comment = $_POST['comment'];
$rating = $_POST['star'];


//echo $full_name.$phone.$email.$address.$city.$pin_code.$state.$country.$comment.$rating;

$sql_feedback= "INSERT INTO feedback_form (full_name, phone, email, address, city, pincode, state, country, comment, rating) VALUES 
        ('$full_name', '$phone', '$email', '$address', '$city', $pin_code, '$state', '$country', '$comment', $rating ) ";



if($conn->query($sql_feedback)){
    echo "Thank you for feedback";
}else{
    echo "Something went wrong please try again later";
}



?>