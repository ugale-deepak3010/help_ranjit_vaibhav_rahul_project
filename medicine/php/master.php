<?php

error_reporting(0);

include "dbconnect.php";

if($_POST['deep_medicine_list_']){




    $exportJsonLogin = array();
    
    $sql_medicine_list = "SELECT * FROM medicine";




    $emparray = array();

    if($res = mysqli_query($conn, $sql_medicine_list)){ 
    if(mysqli_num_rows($res) > 0){
    /* Value Found */  
        while($row = mysqli_fetch_array($res)){
            $emparray[] = $row;
        } /* WHILE CLOSED */
        echo json_encode($emparray);

    }
}


}




if($_POST['Deep_get_info']){
   $i= $_POST['Deep_get_info'];

   $sql_info= "SELECT medical_store.medical_id, medical_name, medical_address, dist, medical_contact FROM medical_store, medicine_avalable WHERE medicine_avalable.medicine_id= $i && medicine_avalable.medical_id=medical_store.medical_id";


   $emparray = array();

   if($res = mysqli_query($conn, $sql_info)){ 
   if(mysqli_num_rows($res) > 0){
   /* Value Found */  
       while($row = mysqli_fetch_array($res)){
           $emparray[] = $row;
       } /* WHILE CLOSED */
       echo json_encode($emparray);

   }
}



}








?>