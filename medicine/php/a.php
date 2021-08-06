<?php
include("dbconnect.php");

for($i=1; $i<=36; $i++){
    //echo $i;
    for($j=1; $j<=10; $j++){
        //echo $i." ++ ".$j."---------------------";

         $sql=" INSERT INTO medicine_avalable (medical_id, medicine_id) value ('$i','$j') ";
       // echo "-------------------";
       // $conn->query($sql);
    }
}

?>