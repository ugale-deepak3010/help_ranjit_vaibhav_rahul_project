<?php
error_reporting(0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set('Asia/Kolkata');
//echo "deepuu";
include 'php/dbconnect.php';
 $timestamp = date('Y-m-d H:i:s',time());



//  some common useful function
function removeDir($target)
    {// delete non empty folder
        $directory = new RecursiveDirectoryIterator($target,  FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if (is_dir($file)) {
                rmdir($file);
            } else {
                unlink($file);
            } 
        }
        rmdir($target);
    }



//echo "deepuu ".$a;
/************************	validation sample code 	*************************/

/*
//  validaton

     $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything
        }//else wrong credetional details
     }//else database problem

*/

/**********************************   register  START ***************************************/
if($_POST['register']){

    $register=json_decode($_POST["register"]);

    $department=$register->Department_id;
    $address=$register->address;
    $dob=$register->dob;
    $email=$register->email;
    $fname=$register->fname;
    $gender=$register->gender;
    $lname=$register->lname;
    $mname=$register->mname;
    $phone=$register->phone;
    $semester=$register->semSel;
    $machine_id=$register->machine_id;

    $approve=0;

    $password=substr(md5(time()), 0, 16);

     $sql_register="INSERT INTO student (fname,mname,lname,gender,dob,address,password,register_time,department,semester,phone,email,machine_id,approve) VALUES ('$fname','$mname','$lname','$gender','$dob','$address','$password','$timestamp','$department',$semester,'$phone','$email','$machine_id',$approve)";

if($conn->query($sql_register)){
    //echo "Registration  Successfully <br> Kindly Exit App <br>We are providing your ID and password<br>Be patience";




        $student_id__=1;

     $sql_get_stud_id="SELECT id FROM student WHERE register_time='$timestamp' && password='$password'";

     if($res = mysqli_query($conn, $sql_get_stud_id)){ 
        if(mysqli_num_rows($res) > 0){
            while($row = mysqli_fetch_array($res)){
                 $student_id__= $row['id'];
                }
            }
        }//sql else stop.


    //create marks for slot.
    $create_slot_marks="INSERT INTO $department"."_marks (id) VALUE ('$student_id__')";
    $conn->query($create_slot_marks);
    // marks slot finished.




    $sql_student_options="INSERT INTO student_options (id) VALUES ($student_id__)";

    if($conn->query($sql_student_options)){
    }else{
        
    }

    $optional="UPDATE student_options SET ";

    foreach($register as $key => $value) {
        //echo "$key is at $value";

        if ( $department!=$value && $address!=$value && $dob!=$value && $email!=$value && $fname!=$value && $mname!=$value && $lname!=$value && $gender!=$value && $phone!=$value && $semester!=$value && $machine_id!=$value ) {
            //echo "$key is at $value";echo "\n";
            $optional=$optional."$value"."_".$semester." = 1,";

            //create marks for slot.
            $create_slot_marks2="INSERT INTO $value"."_marks (id) VALUE ('$student_id__')";
            $conn->query($create_slot_marks2);
            // marks slot finished.


        }
    }

    $optional=rtrim($optional,",");
    $optional=$optional." WHERE id=$student_id__";

     $optional;

    $conn->query($optional);


    echo "Registration  Successfully <br>Be patience while we are <i> approve </i>your register form by college.<br>please note down:<br><b>Your ID :$student_id__<br>Your Password : $password </b><br>Dont Share your Password & ID<br>Kindly please Exit App";

}else{
    echo "Registration Failled";
}

}

/**********************************   register END ***************************************/
/*******************************	LOGIN	******************************/
if($_POST['login']){

    try {
        $login=json_decode($_POST["login"]);
    } catch (Exception $e) {
        echo "exception";
        echo $e;
    }
    
    $id = $login->id;
    $password = $login->password;
    $machine_id = $login->machine_id;
    // check digit for category Administrator/teacher/student
    // 8 digit admin
    // 4 digit teacher
    // 6 digit student
    $log_category=strlen($id);
    $exportJsonLogin = new \stdClass();// very important couse three days


    

//regular
        // administrator
    if ($log_category==8) {



                $login_detail_check = "SELECT * FROM administrator WHERE id='$id' && password='$password'";


                if($res = mysqli_query($conn, $login_detail_check)){ 
                if(mysqli_num_rows($res) > 0){
                /* Value Found */  
                    while($row = mysqli_fetch_array($res)){
                        $exportJsonLogin->id=$row['id'];
                        $exportJsonLogin->active=$row['active'];
                        $exportJsonLogin->name=$row['name'];
                        $exportJsonLogin->password=$row['password'];
                        $exportJsonLogin->approve=$row['approve'];

                    } /* WHILE CLOSED */

                    
                    if($exportJsonLogin->active == "1"){
                        echo "450";//logout another device
                    }else{

                    $key= sprintf('%0Xx', mt_rand(0, 96777215));
                    $exportJsonLogin->machine_id=$machine_id;
                    $exportJsonLogin->active="1";
                    $machine_id_query="UPDATE administrator SET active='1',machine_id='$machine_id' WHERE id='$id' && password='$password'";
                    
                    $conn->query($machine_id_query);

                    echo $exportJsonLogin=json_encode($exportJsonLogin);

                    }
                     
                   }else{ 
                        echo "789";//wrong password and id
                   }

            }else{
                echo "7";//database problem;
            }
        //teacher
    }elseif ($log_category==4) {

                 $login_detail_check = "SELECT * FROM teacher WHERE id='$id' && password='$password'";


                if($res = mysqli_query($conn, $login_detail_check)){ 
                if(mysqli_num_rows($res) > 0){
                /* Value Found */  
                    while($row = mysqli_fetch_array($res)){
                        $exportJsonLogin->id=$row['id'];
                        $exportJsonLogin->active=$row['active'];
                        $exportJsonLogin->phone=$row['phone'];
                        $exportJsonLogin->name=$row['name'];
                        $exportJsonLogin->email=$row['email'];
                        $exportJsonLogin->password=$row['password'];
                        $exportJsonLogin->note=$row['note'];
                        $exportJsonLogin->force_logout=$row['force_logout'];
                    } /* WHILE CLOSED */

                    
                    if($exportJsonLogin->active == "1"){
                        echo "450";//logout another device
                    }else{

                    $key= sprintf('%0Xx', mt_rand(0, 96777215));
                    $exportJsonLogin->machine_id=$machine_id;
                    $exportJsonLogin->active="1";
                    $machine_id_query="UPDATE teacher SET active='1',machine_id='$machine_id' WHERE id='$id' && password='$password'";
                    
                    $conn->query($machine_id_query);

                    echo $exportJsonLogin=json_encode($exportJsonLogin);

                    }
                     
                   }else{ 
                        echo "789";//wrong password and id
                   }

            }else{
                echo "7";//database problem;
            }
        // hod
    }elseif ($log_category==5) {

                 $login_detail_check = "SELECT * FROM hod WHERE id='$id' && password='$password'";


                if($res = mysqli_query($conn, $login_detail_check)){ 
                if(mysqli_num_rows($res) > 0){
                /* Value Found */  
                    while($row = mysqli_fetch_array($res)){
                        $exportJsonLogin->id=$row['id'];
                        $exportJsonLogin->active=$row['active'];
                        $exportJsonLogin->department=$row['department'];
                        $exportJsonLogin->type=$row['type'];
                        $exportJsonLogin->semester_count=$row['semester_count'];
                        $exportJsonLogin->password=$row['password'];
                        $exportJsonLogin->alternative_code=$row['alternative_code'];
                        $exportJsonLogin->machine_id=$row['machine_id'];
                        $exportJsonLogin->force_logout=$row['force_logout'];
                        $exportJsonLogin->name=$row['name'];
                        $exportJsonLogin->email=$row['email'];
                        $exportJsonLogin->phone=$row['phone'];
                    } /* WHILE CLOSED */

                    
                    if($exportJsonLogin->active == "1"){
                        echo "450";//logout another device
                    }else{

                    $key= sprintf('%0Xx', mt_rand(0, 96777215));
                    $exportJsonLogin->machine_id=$machine_id;
                    $exportJsonLogin->active="1";
                    $machine_id_query="UPDATE hod SET active='1',machine_id='$machine_id' WHERE id='$id' && password='$password'";
                    
                    $conn->query($machine_id_query);

                    echo $exportJsonLogin=json_encode($exportJsonLogin);

                    }
                     
                   }else{ 
                        echo "789";//wrong password and id
                   }

            }else{
                echo "7";//database problem;
            }
        // student
    }elseif ($log_category==6) {


                $login_detail_check = "SELECT * FROM student WHERE id='$id' && password='$password'";

                if($res = mysqli_query($conn, $login_detail_check)){
                if(mysqli_num_rows($res) > 0){
                /* Value Found */  
                    while($row = mysqli_fetch_array($res)){
                        $exportJsonLogin->id=$row['id'];
                        $exportJsonLogin->active=$row['active'];
                        $exportJsonLogin->phone=$row['phone'];
                        $exportJsonLogin->fname=$row['fname'];
                        $exportJsonLogin->mname=$row['mname'];
                        $exportJsonLogin->lname=$row['lname'];
                        $exportJsonLogin->dob=$row['dob'];
                        $exportJsonLogin->gender=$row['gender'];
                        $exportJsonLogin->address=$row['address'];
                        $exportJsonLogin->email=$row['email'];
                        $exportJsonLogin->department=$row['department'];
                        $exportJsonLogin->semester=$row['semester'];
                        $exportJsonLogin->password=$row['password'];
                        $exportJsonLogin->register_time=$row['register_time'];
                        $exportJsonLogin->approve=$row['approve'];
                        // minimum  use here for complexity
                    } /* WHILE CLOSED */

                    
                    if($exportJsonLogin->active == "1"){
                        echo "450";//logout another device 
                    }else if($exportJsonLogin->approve==0){
                        echo "788567";
                    }else{

                    $key= sprintf('%0Xx', mt_rand(0, 96777215));
                    $exportJsonLogin->machine_id=$machine_id;
                    $exportJsonLogin->active="1";
                    $machine_id_query="UPDATE student SET force_logout='0', active='1',machine_id='$machine_id' WHERE id='$id' && password='$password'";
                    
                    $conn->query($machine_id_query);

                    echo $exportJsonLogin=json_encode($exportJsonLogin);

                    }
                     
                   }else{ 
                        echo "789";//wrong password and id
                   }

            }else{
                echo "7";//database problem;
            }
        
    }else{
        //id digit count
    }


}

/********************************DEPT VIEW: ADMIN******************************************/

if($_POST['dept_view__administrator']){

    $dept_view_=json_decode($_POST["dept_view__administrator"]);

    $id = $dept_view_->id;
    $password = $dept_view_->password;
    
    $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
    if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
                //fetch table rows from mysql db
                $sql = "select * from hod";
                $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);
        }//else wrong credetional details
     }//else database problem
 
}
/**************************************************************/


/********************************DEPT DELETE : ADMIN******************************************/

if($_POST['del_dept__admin']){
    
    $del_dept__admin=json_decode($_POST["del_dept__admin"]);

    $id = $del_dept__admin->id;
    $password = $del_dept__admin->password;
    $dept_id = $del_dept__admin->dept_id;

//  validaton

     $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            //delete common inside also
            $gtDt_type="some";
            $gtDt_sc=0;
            $gtDn="some";

            $gtDt="select department,type,semester_count from hod where id=".$dept_id;

            if($res = mysqli_query($conn, $gtDt)){
                if(mysqli_num_rows($res) > 0){
                    while($row = mysqli_fetch_array($res)){
                     $gtDn=$row['department'];
                      $gtDt_type=$row['type'];
                      $gtDt_sc=$row['semester_count'];
                    }
                }
            }
            //echo $gtDt_type;
            //echo $gtDn;
            //echo $gtDt_sc;

            if ($gtDt_type=="individual") {
                for ($i=1; $i <= $gtDt_sc; $i++) {
                         $ind_DL_sql="ALTER TABLE common DROP $gtDn"."_".$i;
                        if ($conn->query($ind_DL_sql)) {
                        }
                    }
            } elseif ($gtDt_type=="common") {
                   
                       for ($i=1; $i <= $gtDt_sc; $i++) {
                          $sql_drp_clm="ALTER TABLE student_options DROP $gtDn"."_".$i;
                        if ($conn->query($sql_drp_clm)) {
                           //echo "success";
                        }else{
                            //echo "failed";
                        }
                    } 


                $cmn_d_sql="DELETE FROM common WHERE dept_name='$gtDn'";
                    if ($conn->query($cmn_d_sql)) {
                            
                        }
            }
            




            $del_dept_sql = "delete from hod where id=".$dept_id;
            if($conn->query($del_dept_sql)){
                echo "5436";// deleted
                $sql_drp_marks_tbl="DROP TABLE $gtDn"."_marks";
                $conn->query($sql_drp_marks_tbl);

                $sql_dl_master_sem="DELETE FROM master_semester WHERE dept_name='$gtDn'";
                $conn->query($sql_dl_master_sem);

                $delete_notice_folder="generated/notice/hod/".$gtDn;
                removeDir($delete_notice_folder);

                $delete_chat_folder="generated/chat/".$gtDn;
                removeDir($delete_chat_folder);

            }else{
                echo "5437";// not deleted
            }

        }//else wrong credetional details
     }//else database problem

}

/****************************************************************************/


/************************************ create_dept__admin  ***************************************/

if($_POST['create_dept__admin']){
    
    $create_dept__admin=json_decode($_POST["create_dept__admin"]);

    $id = $create_dept__admin->id;
    $password = $create_dept__admin->password;

    $dept_name = $create_dept__admin->dept_name;
    $alt_code = $create_dept__admin->alt_code;
    $dept_password = $create_dept__admin->dept_password;
    $dept_type = $create_dept__admin->dept_type;
    $dept_sem_count = $create_dept__admin->dept_sem_count;
    $full_name = $create_dept__admin->full_name;
    $dept_phone = $create_dept__admin->dept_phone;
    $dept_email = $create_dept__admin->dept_email;


//  validaton

     $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything user valided
            $flag=0;
            
            // check dept already present or not
            $dept_present="select id from hod where department='$dept_name'";
            if($res = mysqli_query($conn, $dept_present)){

                if(mysqli_num_rows($res) > 0){
                    $dept_type="invalid_dept";// so flag is 0
                }
            }

            // $dept_type;

            if ($dept_type=="individual") {
                    for ($i=1; $i <= $dept_sem_count; $i++) {
                        $ind_sql="ALTER TABLE common ADD $dept_name"."_".$i." int(1)";
                        if ($conn->query($ind_sql)) {
                             $flag=1;
                        }
                    }
            }elseif($dept_type=="common"){
                    

                        for ($i=1; $i <= $dept_sem_count; $i++) {
                        $sql_stud_opt="ALTER TABLE student_options ADD $dept_name"."_".$i." int(1)";
                        if ($conn->query($sql_stud_opt)) {
                        }
                    }





                    $cmn_sql="INSERT INTO common (dept_name) VALUES ('$dept_name')";
                    if ($conn->query($cmn_sql)) {
                            $flag=1;
                        }
            }
            // $dept_type;
            if ($flag==1) {
                             $add_dept_sql = "INSERT INTO hod (department,alternative_code,password,type,semester_count,name,email,phone) VALUES ('$dept_name','$alt_code','$dept_password','$dept_type',$dept_sem_count,'$full_name','$dept_email','$dept_phone')";
                            if($conn->query($add_dept_sql)){
                            echo "5438";// success
                                // department student marks for table
                                $sql_dept_marks_sql="CREATE TABLE $dept_name"."_marks (id int (8) NOT NULL, PRIMARY KEY (id) )";
                                $conn->query($sql_dept_marks_sql);

                                $path_for_notice_txt="generated/notice/hod/".$dept_name;
                                @mkdir($path_for_notice_txt);
                                $f=fopen($path_for_notice_txt."/notice.txt","w");
                                fclose($f);


                                // for chatting
                                $pathChatting="generated/chat/".$dept_name;
                                @mkdir($pathChatting);

                                $f2=fopen($pathChatting."/chat.txt","w");
                                fclose($f2);

                                $pathChatImages="generated/chat/".$dept_name."/images";
                                @mkdir($pathChatImages);

                                $pathChatImagesThumbs="generated/chat/".$dept_name."/images/thumbs";
                                @mkdir($pathChatImagesThumbs);

                            }

            }else{
                echo "5439";// false
            }

        }//else wrong credetional details
     }//else database problem

}

/****************************************************************************/


/************************************ update_dept__admin  ***************************************/

if($_POST['update_dept__admin']){

    $update_dept__admin=json_decode($_POST["update_dept__admin"]);

    $id = $update_dept__admin->id;
    $password = $update_dept__admin->password;

    $update_dept_id = $update_dept__admin->update_dept_id;

//  validaton

    $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything user valided

             $update_dept_sql = "SELECT * FROM hod where id=$update_dept_id";
             $result = mysqli_query($conn, $update_dept_sql);

                //create an array
                $update_tbl = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $update_tbl[] = $row;
                }
                echo json_encode($update_tbl);

        }//else wrong credetional details
     }//else database problem

}

/****************************************************************************/

/************************************ update_dept_final__admin  ***************************************/

if($_POST['update_dept_final__admin']){
    
    $update_dept_final__admin=json_decode($_POST["update_dept_final__admin"]);

    $id = $update_dept_final__admin->id;
    $password = $update_dept_final__admin->password;

    $dept_name = $update_dept_final__admin->dept_name;
    $dept_password = $update_dept_final__admin->dept_password;
    $dept_type = $update_dept_final__admin->dept_type;
    $dept_sem_count = $update_dept_final__admin->dept_sem_count;
    $full_name = $update_dept_final__admin->full_name;
    $alt_code=$update_dept_final__admin->alt_code;
    $dept_phone = $update_dept_final__admin->dept_phone;
    $dept_email = $update_dept_final__admin->dept_email;//update_dept_id
    $dept_id_up = $update_dept_final__admin->update_dept_id;

//  validaton

     $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything user valided

             $UP_dept_sql = "UPDATE hod  SET department='$dept_name',alternative_code='$alt_code',password='$dept_password',type='$dept_type',semester_count=$dept_sem_count,name='$full_name',email='$dept_email',phone='$dept_phone' WHERE id=$dept_id_up";

            if($conn->query($UP_dept_sql)){
                echo "5443";// success
            }else{
                echo "5444";// false
            }

        }//else wrong credetional details
     }//else database problem

}

/****************************************************************************/


/********************************teacher VIEW: ADMIN******************************************/



if($_POST['teacher_view__administrator']){

    $my_register=json_decode($_POST["teacher_view__administrator"]);

    $id = $my_register->id;
    $password = $my_register->password;

    $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
               $sql = "select * from teacher";
                $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);
        }//else wrong credetional details
     }//else database problem

}
/**************************************************************/

/********************************file_shared_teacher******************************************/

if($_POST['file_shared_teacher']){

    $my_register=json_decode($_POST["file_shared_teacher"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $name = $my_register->name;

    $verify_p = "SELECT id,password FROM teacher WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){


                $sql_sthod = "select id from master_semester where teacher='$name'";
                $result = mysqli_query($conn, $sql_sthod);
                //create an array
                $subject_id;
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $subject_id = $row['id'];



                       $sql = "SELECT * from file_share_manager WHERE subject_id=$subject_id";
                        $result23 = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

                        //create an array
                        
                        while($row23 =mysqli_fetch_assoc($result23))
                        {
                            $emparray[] = $row23;
                        }
                       // echo json_encode($emparray);

                }
               echo json_encode($emparray);









        }//else wrong credetional details
     }//else database problem

}
/**************************************************************/

/********************************file_shared_Administrator******************************************/

if($_POST['file_shared_Administrator']){

    $my_register=json_decode($_POST["file_shared_Administrator"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $name = $my_register->name;

    $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){



                //create an array
                $emparray = array();

                $sql = "SELECT * from file_share_manager";
                
                $result23 = mysqli_query($conn, $sql);
                        
                while($row23 =mysqli_fetch_assoc($result23))
                {
                    $emparray[] = $row23;
                }
                // echo json_encode($emparray);

               echo json_encode($emparray);









        }//else wrong credetional details
     }//else database problem

}
/**************************************************************/
/********************************del_teacher__admin : ADMIN******************************************/

if($_POST['del_teacher__admin']){
    
    $del_teacher__admin=json_decode($_POST["del_teacher__admin"]);

    $id = $del_teacher__admin->id;
    $password = $del_teacher__admin->password;
    $dept_id = $del_teacher__admin->dept_id;

//  validaton

     $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){

            $del_dept_sql = "delete from teacher where id=".$dept_id;
            if($conn->query($del_dept_sql)){
                echo "5436";// deleted
            }else{
                echo "5437";// not deleted
            }

        }//else wrong credetional details
     }//else database problem

}

/****************************************************************************/


/********************************del_share_file_teacher : Teacher******************************************/

if($_POST['del_share_file_teacher']){
    
    $del_teacher__admin=json_decode($_POST["del_share_file_teacher"]);

    $id = $del_teacher__admin->id;
    $password = $del_teacher__admin->password;
    $file_id = $del_teacher__admin->file_id;

//  validaton

     $verify_p = "SELECT id,password FROM teacher WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){




                $sql_getMarks="SELECT file_name,file_name_uid,file_extension,subject_id FROM file_share_manager WHERE id=$file_id LIMIT 1";

                $result534 = mysqli_query($conn, $sql_getMarks);

                while($row534 =mysqli_fetch_assoc($result534))
                {
                    $file_extension_1 = $row534['file_extension'];
                    $file_name_1 = $row534['file_name'];
                    $file_uid_1 = $row534['file_name_uid'];
                    $file_subject_id_1 = $row534['subject_id'];

                    $path_file_del="generated/pdf/$file_subject_id_1/$file_name_1"."__"."$file_uid_1"."."."$file_extension_1";
                    unlink($path_file_del);

                    
                    $del_dept_sql = "delete from file_share_manager where id=".$file_id;
                    
                    if($conn->query($del_dept_sql)){
                        echo "5436";// deleted
                    }else{
                        echo "5437";// not deleted
                    }


                }

        }//else wrong credetional details
     }//else database problem

}

/****************************************************************************/

/********************************del_share_file_administrator ******************************************/

if($_POST['del_share_file_administrator']){
    
    $del_teacher__admin=json_decode($_POST["del_share_file_administrator"]);

    $id = $del_teacher__admin->id;
    $password = $del_teacher__admin->password;
    $file_id = $del_teacher__admin->file_id;

//  validaton

     $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){




                $sql_getMarks="SELECT file_name,file_name_uid,file_extension,subject_id FROM file_share_manager WHERE id=$file_id LIMIT 1";

                $result534 = mysqli_query($conn, $sql_getMarks);

                while($row534 =mysqli_fetch_assoc($result534))
                {
                    $file_extension_1 = $row534['file_extension'];
                    $file_name_1 = $row534['file_name'];
                    $file_uid_1 = $row534['file_name_uid'];
                    $file_subject_id_1 = $row534['subject_id'];

                    $path_file_del="generated/pdf/$file_subject_id_1/$file_name_1"."__"."$file_uid_1"."."."$file_extension_1";
                    unlink($path_file_del);

                    
                    $del_dept_sql = "delete from file_share_manager where id=".$file_id;
                    
                    if($conn->query($del_dept_sql)){
                        echo "5436";// deleted
                    }else{
                        echo "5437";// not deleted
                    }


                }

        }//else wrong credetional details
     }//else database problem

}

/****************************************************************************/


/************************************ create_teacher__admin  ***************************************/

if($_POST['create_teacher__admin']){
    
    $create_teacher__admin=json_decode($_POST["create_teacher__admin"]);

    $id = $create_teacher__admin->id;
    $password = $create_teacher__admin->password;

    $dept_password = $create_teacher__admin->dept_password;
    $full_name = $create_teacher__admin->full_name;
    $dept_phone = $create_teacher__admin->dept_phone;
    $dept_email = $create_teacher__admin->dept_email;
    $note= $create_teacher__admin->note;
//  validaton

     $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything user valided

            $add_teacher_sql = "INSERT INTO teacher (name,phone,email,password,note) VALUES ('$full_name','$dept_phone','$dept_email','$dept_password','$note')";
            if($conn->query($add_teacher_sql)){
                echo "5438";// success                
            }else{
                echo "5439";// false
            }

        }//else wrong credetional details
     }//else database problem

}

/****************************************************************************/
/************************************ update_teacher__admin  ***************************************/
if($_POST['update_teacher__admin']){

    $update_teacher__admin=json_decode($_POST["update_teacher__admin"]);

    $id = $update_teacher__admin->id;
    $password = $update_teacher__admin->password;

    $update_dept_id = $update_teacher__admin->update_dept_id;

//  validaton

    $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything user valided

             $update_dept_sql = "SELECT * FROM teacher where id=$update_dept_id";
             $result = mysqli_query($conn, $update_dept_sql);

                //create an array
                $update_tbl = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $update_tbl[] = $row;
                }
                echo json_encode($update_tbl);

        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/

/************************************ update_teacher_final__admin  ***************************************/

if($_POST['update_teacher_final__admin']){
    
    $update_teacher_final__admin=json_decode($_POST["update_teacher_final__admin"]);

    $id = $update_teacher_final__admin->id;
    $password = $update_teacher_final__admin->password;

    $dept_password = $update_teacher_final__admin->dept_password;
    $full_name = $update_teacher_final__admin->full_name;
    $dept_phone = $update_teacher_final__admin->dept_phone;
    $dept_email = $update_teacher_final__admin->dept_email;//update_dept_id
    $note = $update_teacher_final__admin->note;

    $dept_id_up = $update_teacher_final__admin->update_dept_id;

//  validaton

     $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything user valided

             $UP_dept_sql = "UPDATE teacher  SET name='$full_name',password='$dept_password',email='$dept_email',phone='$dept_phone',note='$note' WHERE id=$dept_id_up";

            if($conn->query($UP_dept_sql)){
                echo "5443";// success
            }else{
                echo "5444";// false
            }

        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/

/********************************DEPT VIEW: ADMIN******************************************/

if($_POST['dept_stud__administrator']){

    $my_register=json_decode($_POST["dept_stud__administrator"]);

    $id = $my_register->id;
    $password = $my_register->password;

     $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe
               $sql = "select * from student";
                $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);


        }//else wrong credetional details
     }//else database problem

}
/**************************************************************/

/********************************DEPT VIEW: ADMIN******************************************/

if($_POST['master_examinition__administrator']){

    $my_register=json_decode($_POST["master_examinition__administrator"]);

    $id = $my_register->id;
    $password = $my_register->password;

     $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe
               $sql = "select * from master_examinition";
                $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);


        }//else wrong credetional details
     }//else database problem

}
/**************************************************************/
/********************************DEPT VIEW: ADMIN******************************************/

if($_POST['db_table_status__administrator']){

    $my_register=json_decode($_POST["db_table_status__administrator"]);

    $id = $my_register->id;
    $password = $my_register->password;

     $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe
               $sql = "SHOW TABLE STATUS";
                $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);


        }//else wrong credetional details
     }//else database problem

}
/**************************************************************/
/********************************	LOGOUT	*************************************/
if($_POST['logout']){

	$logout=json_decode($_POST["logout"]);

	$id = $logout->id;
	$password = $logout->password;

    $log_category=strlen($id);

    if ($log_category==8) {//admin

                $machine_id_query="UPDATE administrator SET active='0' WHERE id='$id'";
                    
                if($conn->query($machine_id_query)){
                    
                     $logout_confirm_check = "SELECT active FROM administrator WHERE id='$id' && password='$password'";
                     if($res = mysqli_query($conn, $logout_confirm_check)){ 
                if(mysqli_num_rows($res) > 0){
                    while($row = mysqli_fetch_array($res)){
                       $currSt= $row['active'];
                    }
                }
                     }//sql else stop.
                     
                     if($currSt=="1"){
                         echo "7";
                     }else{
                         echo "970";//redirecting to login page.
                     }
                    //check confirm.
                    
                }else{
                    echo "7";//system database problem
                }

    }else if($log_category==6){//student

                $machine_id_query="UPDATE student SET active='0' WHERE id='$id'";
                    
                if($conn->query($machine_id_query)){
                    
                     $logout_confirm_check = "SELECT active FROM student WHERE id='$id' && password='$password'";
                     if($res = mysqli_query($conn, $logout_confirm_check)){ 
                if(mysqli_num_rows($res) > 0){
                    while($row = mysqli_fetch_array($res)){
                       $currSt= $row['active'];
                    }
                }
                     }//sql else stop.
                     
                     if($currSt=="1"){
                         echo "7";
                     }else{
                         echo "970";//redirecting to login page.
                     }
                    //check confirm.
                    
                }else{
                    echo "7";//system database problem
                }

    }else if($log_category==5){//hod

                        $machine_id_query="UPDATE hod SET active='0' WHERE id='$id'";
                    
                if($conn->query($machine_id_query)){
                    
                     $logout_confirm_check = "SELECT active FROM hod WHERE id='$id' && password='$password'";
                     if($res = mysqli_query($conn, $logout_confirm_check)){ 
                if(mysqli_num_rows($res) > 0){
                    while($row = mysqli_fetch_array($res)){
                       $currSt= $row['active'];
                    }
                }
                     }//sql else stop.
                     
                     if($currSt=="1"){
                         echo "7";
                     }else{
                         echo "970";//redirecting to login page.
                     }
                    //check confirm.
                    
                }else{
                    echo "7";//system database problem
                }

    }else if($log_category==4){//teacher

                $machine_id_query="UPDATE teacher SET active='0' WHERE id='$id'";
                    
                if($conn->query($machine_id_query)){
                    
                     $logout_confirm_check = "SELECT active FROM teacher WHERE id='$id' && password='$password'";
                     if($res = mysqli_query($conn, $logout_confirm_check)){ 
                if(mysqli_num_rows($res) > 0){
                    while($row = mysqli_fetch_array($res)){
                       $currSt= $row['active'];
                    }
                }
                     }//sql else stop.
                     
                     if($currSt=="1"){
                         echo "7";
                     }else{
                         echo "970";//redirecting to login page.
                     }
                    //check confirm.
                    
                }else{
                    echo "7";//system database problem
                }
    }


}
/*****************************************************************************/

/********************************mng_common__administrator: ADMIN******************************************/

if($_POST['mng_common__administrator']){

    $my_register=json_decode($_POST["mng_common__administrator"]);

    $id = $my_register->id;
    $password = $my_register->password;

    $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
               $sql = "select * from common";
                $result = mysqli_query($conn, $sql);

                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);
        }//else wrong credetional details
     }//else database problem

}
/**************************************************************/
/********************************* edit_comm_ optional dept *************************************/
if($_POST['edit_comm_op_']){

    $edit_comm_op_=json_decode($_POST["edit_comm_op_"]);

    $id = $edit_comm_op_->id;
    $password = $edit_comm_op_->password;
    $deptnm_edit_commn = $edit_comm_op_->deptnm_edit_commn;

    $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // verify person.

                $sql = "select * from common where dept_name='$deptnm_edit_commn'";
                $result = mysqli_query($conn, $sql);

                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);
        }//else wrong credetional details
     }//else database problem

}

/********************************************************************************************/
/*********************************** mng_common_op_edit_admin ************************************************/

if($_POST['mng_common_op_edit_admin']){

    $mncn=json_decode($_POST["mng_common_op_edit_admin"]);
///////////////////////////////////////
    $id = $mncn->id;
    $password = $mncn->password;
    $dept_name = $mncn->dept_name;



    $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // verify person.
            $sql_chk="UPDATE common SET ";

                foreach($mncn as $x => $val) {
                    if ($x!="id" && $x!="password" && $x!="dept_name") {
                        $sql_chk=$sql_chk."$x=$val, ";
                    }
                }
                $sql_chk_2=rtrim($sql_chk,", ");
                $sql_chk_3=$sql_chk_2." WHERE dept_name='$dept_name'";
                
                if ($conn->query($sql_chk_3)) {
                    echo "6547";// success
                }else{
                    echo "6548";
                }

        }//else wrong credetional details
     }//else database problem

}

/************************************** hod_sem_count : HOD *********************************************/


if($_POST['hod_sem_count']){

    $mncn=json_decode($_POST["hod_sem_count"]);
///////////////////////////////////////
    $id = $mncn->id;
    $password = $mncn->password;
    $dept_name = $mncn->dept_name;



    $verify_p = "SELECT id,password FROM hod WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // verify person.
            $sql_smcnt="SELECT semester_count from hod WHERE id=$id";

                if($res = mysqli_query($conn, $sql_smcnt)){
                    if(mysqli_num_rows($res) > 0){
                        while($row = mysqli_fetch_array($res)){
                            echo $row['semester_count'];
                            }
                        }
                    }
        }//else wrong credetional details
     }//else database problem

}
/**********************************************************************************************/
/********************************STUDENT VIEW : HOD******************************************/
if($_POST['dept_stud__hod']){

    $my_register=json_decode($_POST["dept_stud__hod"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $department54 = $my_register->department;

     $verify_p = "SELECT id,password FROM hod WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe
               $sql_sthod = "select * from student WHERE department='$department54'";
                $result = mysqli_query($conn, $sql_sthod);
                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);


        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/
/********************************dept_stud_marks_hod : HOD******************************************/
if($_POST['dept_stud_marks_hod']){

    $my_register=json_decode($_POST["dept_stud_marks_hod"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $department54 = $my_register->department;

     $verify_p = "SELECT id,password FROM hod WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe
               $sql_sthod = "select * from $department54"."_marks";
                $result = mysqli_query($conn, $sql_sthod);
                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);


        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/



/********************************department_examinition_record : HOD******************************************/
if($_POST['department_examinition_record']){

    $my_register=json_decode($_POST["department_examinition_record"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $department54 = $my_register->department;

     $verify_p = "SELECT id,password FROM hod WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe





        $sub_get_id_="SELECT * FROM master_examinition WHERE subject_id IN (";

        $x1;
        $sbj_id_for_exams;

        $get_exam_id="SELECT id FROM master_semester WHERE department='$department54'";
        $result66 = mysqli_query($conn, $get_exam_id);
        while($row66 =mysqli_fetch_assoc($result66))
           {
            $sbj_id_for_exams = $row66['id'];

            $x1=$x1." $sbj_id_for_exams,";

           }

           $x1=rtrim($x1,",");

             
        $sub_get_id_=$sub_get_id_.$x1.")";




                $result = mysqli_query($conn, $sub_get_id_);
                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);


        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/

/********************************Subject VIEW : HOD******************************************/
if($_POST['dept_sub_view__hod']){

    $my_register=json_decode($_POST["dept_sub_view__hod"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $department54 = $my_register->department;
     $verify_p = "SELECT id,password FROM hod WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe
               $sql_sthod = "select * from master_semester WHERE department='$department54'";
                $result = mysqli_query($conn, $sql_sthod);
                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);


        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/
/********************************Subject VIEW : HOD******************************************/
if($_POST['dept_sub_view_ss_hod']){

    $my_register=json_decode($_POST["dept_sub_view_ss_hod"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $department54 = $my_register->department;
    $semester = $my_register->semester;
    
     $verify_p = "SELECT id,password FROM hod WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe
               $sql_sthod = "select * from master_semester WHERE department='$department54' AND semester=$semester";
                $result = mysqli_query($conn, $sql_sthod);
                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);


        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/
/********************************add_sbj_tech_ls_hod: HOD******************************************/
if($_POST['add_sbj_tech_ls_hod']){

    $my_register=json_decode($_POST["add_sbj_tech_ls_hod"]);

    $id = $my_register->id;
    $password = $my_register->password;

     $verify_p = "SELECT id,password FROM hod WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe
               $sql_sthod = "select name from teacher";
                $result = mysqli_query($conn, $sql_sthod);
                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);


        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/
/********************************add_sub__hod: HOD******************************************/
if($_POST['add_sub__hod']){

    $my_register=json_decode($_POST["add_sub__hod"]);

    $id = $my_register->id;
    $password = $my_register->password;

    $semester = $my_register->semester;
    $subject_name = $my_register->subject_name;
    $subject_desc = $my_register->subject_desc;
    $subject_code = $my_register->subject_code;
    $teacher = $my_register->teacher;
    $department = $my_register->department;

     $verify_p = "SELECT id,password FROM hod WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){



            // do anything safe

             $add_subsql="INSERT INTO master_semester (department,semester,subject_name,subject_desc,subject_code,teacher) VALUES ('$department',$semester,'$subject_name','$subject_desc','$subject_code','$teacher')";

            if($conn->query($add_subsql)){
                echo "4567";// added subject

                $sql_get_id="SELECT id FROM master_semester WHERE department='$department' ORDER BY id desc LIMIT 1";
                $sb_get_id;
                $result33 = mysqli_query($conn, $sql_get_id);

                while($row33 =mysqli_fetch_assoc($result33))
                {
                    $sb_get_id = $row33['id'];
                }



                $path_for_exam_paper="generated/exam/".$sb_get_id;
                @mkdir($path_for_exam_paper);
                $path_for_notice="generated/notice/subject/".$sb_get_id;
                @mkdir($path_for_notice);
                $path_for_pdf="generated/pdf/".$sb_get_id;
                @mkdir($path_for_pdf);

                $f=fopen($path_for_notice."/notice.txt","w");
                fclose($f);


            }else{
                echo "4568";//failed
            }




        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/
/********************************del_sub_hod: HOD******************************************/
if($_POST['del_sub_hod']){

    $my_register=json_decode($_POST["del_sub_hod"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $sub_id = $my_register->sub_id;


     $verify_p = "SELECT id,password FROM hod WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe

            $add_subsql="DELETE FROM master_semester WHERE id=$sub_id";

            if($conn->query($add_subsql)){
                echo "4567";// added subject

                $delete_exam_folder="generated/exam/".$sub_id;
                removeDir($delete_exam_folder);

                $delete_notice_folder="generated/notice/subject/".$sub_id;
                removeDir($delete_notice_folder);

                $delete_pdf_folder="generated/pdf/".$sub_id;
                removeDir($delete_pdf_folder);
                
            }else{
                echo "4568";//failed
            }
        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/
/********************************del_stud__hod: HOD******************************************/
if($_POST['del_stud__hod']){

    $my_register=json_decode($_POST["del_stud__hod"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $stud_id = $my_register->stud_id;


     $verify_p = "SELECT id,password FROM hod WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe




            // GETTING STUDENT DEPARTMENT AND SEMESTER
            $stud_id_dept_sem="SELECT department, semester FROM student WHERE id=$stud_id LIMIT 1";
            $result32 = mysqli_query($conn, $stud_id_dept_sem);
            $stud_dept_for_del;
            $stud_sem_for_del;

                while($row32 =mysqli_fetch_assoc($result32))
                {
                    $stud_dept_for_del = $row32['department'];
                    $stud_sem_for_del = $row32['semester'];
                }


                // DELETE DEPT MARKS INSIDE RECORD.
            $sql_del_record_individual_marks="DELETE FROM $stud_dept_for_del"."_marks WHERE id=$stud_id LIMIT 1";
           $conn->query($sql_del_record_individual_marks);




// DELETE COMMON TMATKS TABLE
            $common_sb="SELECT * FROM student_options WHERE id=$stud_id LIMIT 1";

            $result2 = mysqli_query($conn, $common_sb);
                //create an array
                $emparray2 = array();
                while($row2 =mysqli_fetch_assoc($result2))
                {
                    $emparray2[] = $row2;
                }
                


                $a=$emparray2[0];


                foreach ($a as $key => $value) {
                    if ($value==1) {

                         $subNm54 = substr($key, 0, strpos($key, "_"));

                        $del_comm_dep_stud_rec="DELETE FROM $subNm54"."_marks WHERE id=$stud_id LIMIT 1";
                        $conn->query($del_comm_dep_stud_rec);


                    }
                }




//  DELETE STUDENT TABLE DATA
            $add_subsql="DELETE FROM student WHERE id=$stud_id";

            if($conn->query($add_subsql)){
                echo "4567";// deleted
                $del_stud_opt_="DELETE FROM student_options WHERE id=$stud_id";
                $conn->query($del_stud_opt_);
            }else{
                echo "4568";//failed
            }


            
        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/
/********************************approve_stud__hod: HOD******************************************/
if($_POST['approve_stud__hod']){

    $my_register=json_decode($_POST["approve_stud__hod"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $stud_id = $my_register->stud_id;


     $verify_p = "SELECT id,password FROM hod WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe

            $approve_sql="UPDATE student SET approve=1 WHERE id=$stud_id";

            if($conn->query($approve_sql)){
                echo "4567";// deleted
            }else{
                echo "4568";//failed
            }
        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/

/********************************force_logout: HOD******************************************/
if($_POST['force_logout']){

    $my_register=json_decode($_POST["force_logout"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $stud_id = $my_register->stud_id;


     $verify_p = "SELECT id,password FROM hod WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe
            $password=substr(md5(time()), 0, 16);

            $approve_sql="UPDATE student SET password='$password',force_logout=1,active=0 WHERE id=$stud_id";
            //when student loing 1) unexpectly uninistall 2) force_fully logout => home in verify pass.
            if($conn->query($approve_sql)){
                echo $password;
            }else{
                echo "4568";//failed
            }
        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/
/********************************my_sub__teacher: TEACHER ******************************************/
if($_POST['my_sub__teacher']){

    $my_register=json_decode($_POST["my_sub__teacher"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $name = $my_register->name;

     $verify_p = "SELECT id,password FROM teacher WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything safe
                $sql_sthod = "select * from master_semester where teacher='$name'";
                $result = mysqli_query($conn, $sql_sthod);
                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);


        }//else wrong credetional details
     }//else database problem

}
/****************************************************************************/
/********************************dept_lst_for_register: TEACHER ******************************************/
if($_POST['dept_lst_for_register']){
    $sql_sthod = "select department,semester_count from hod where type='individual'";
    $result = mysqli_query($conn, $sql_sthod);
                //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    echo json_encode($emparray);
}
/********************************get_common_optional_sub__register: REGISTER ***************************/
if($_POST['get_common_optional_sub__register']){
    $my_register=json_decode($_POST["get_common_optional_sub__register"]);

    $semester = $my_register->semester;
    $department = $my_register->department;
    $semCon=$department."_".$semester;

    $sql_sthod = "SELECT dept_name FROM common WHERE $semCon=1";
    
    $result = mysqli_query($conn, $sql_sthod);
                //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    echo json_encode($emparray);
}

/********************************optional_sub__register: REGISTER ***************************/
if($_POST['optional_sub__register']){
    

     $sql_sthod = "SELECT department,alternative_code FROM hod";
    
    $result = mysqli_query($conn, $sql_sthod);
                //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    echo json_encode($emparray);
}
/******************************************************************/


/******************** subjects_subjectlist_stud : student********************************/
if($_POST['subjects_subjectlist_stud']){

    $sd1=json_decode($_POST["subjects_subjectlist_stud"]);

    $id = $sd1->id;
    $password = $sd1->password;
    $department = $sd1->department;
    $semester = $sd1->semester;

     $verify_p = "SELECT id,password FROM student WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything

            //echo "I will provide you your subject list as soon as possible";

            $sind_sub = "SELECT * FROM master_semester WHERE department='$department' && semester='$semester'";
                
            $result1 = mysqli_query($conn, $sind_sub);
                //create an array
                $emparray1 = array();
                while($row1 =mysqli_fetch_assoc($result1))
                {
                    $emparray1[] = $row1;
                }
                //echo json_encode($emparray1);


            $common_sb="SELECT * FROM student_options WHERE id=$id";

            $result2 = mysqli_query($conn, $common_sb);
                //create an array
                $emparray2 = array();
                while($row2 =mysqli_fetch_assoc($result2))
                {
                    $emparray2[] = $row2;
                }
                
                //json_encode($emparray2);


                $a=$emparray2[0];

                //echo "\n\n\n";

                foreach ($a as $key => $value) {
                    if ($value==1) {

                         $subNm54 = substr($key, 0, strpos($key, "_"));

                        $sql_cmn_sb="SELECT * FROM master_semester WHERE department='$subNm54' && semester=$semester LIMIT 1";
                        $result51 = mysqli_query($conn, $sql_cmn_sb);

                        $emparray51 = array();

                        while($row51 =mysqli_fetch_assoc($result51))
                        {
                            $emparray1[] = $row51;
                        }
                    
                    



                    }
                }

                echo json_encode($emparray1);


        }//else wrong credetional details
     }//else database problem




}

/****************************************************/








/******************** subjects_examlist_stud : student********************************/
if($_POST['subjects_examlist_stud']){

    $sd1=json_decode($_POST["subjects_examlist_stud"]);

    $id = $sd1->id;
    $password = $sd1->password;
    $department = $sd1->department;
    $semester = $sd1->semester;

     $verify_p = "SELECT id,password FROM student WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything
            //echo "I will provide you your subject list as soon as possible";



            $sind_sub = "SELECT id FROM master_semester WHERE department='$department' && semester='$semester'";
                
            $result1 = mysqli_query($conn, $sind_sub);
                //create an array
                $emparray1 = array();
                while($row1 =mysqli_fetch_assoc($result1))
                {
                    $emparray1[] = $row1;
                }
                //echo json_encode($emparray1);


            $common_sb="SELECT * FROM student_options WHERE id=$id";

            $result2 = mysqli_query($conn, $common_sb);
                //create an array
                $emparray2 = array();
                while($row2 =mysqli_fetch_assoc($result2))
                {
                    $emparray2[] = $row2;
                }
                
                //json_encode($emparray2);


                $a=$emparray2[0];

                //echo "\n\n\n";

                foreach ($a as $key => $value) {
                    if ($value==1) {

                         $subNm54 = substr($key, 0, strpos($key, "_"));

                        $sql_cmn_sb="SELECT id FROM master_semester WHERE department='$subNm54' && semester=$semester LIMIT 1";
                        $result51 = mysqli_query($conn, $sql_cmn_sb);

                        $emparray51 = array();

                        while($row51 =mysqli_fetch_assoc($result51))
                        {
                            $emparray1[] = $row51;
                        }
                    
                    



                    }
                }

                //echo json_encode($emparray1);

               
                $cnt=0;
                $arry_exam = array();// output echo
                foreach ($emparray1 as $ke78 => $value78) {

                     $sbidarr1=$emparray1[$cnt];
                       foreach ($sbidarr1 as $ke8 => $value8) {
                   // echo "value = $value8 key= $ke8 ";
                               $sql_cmn_sb="SELECT * FROM master_examinition WHERE subject_id=$value8";
                                $result56 = mysqli_query($conn, $sql_cmn_sb);

                                while($row56 =mysqli_fetch_assoc($result56))
                                {
                                    $arry_exam[] = $row56;
                                }

                    }


                    $cnt++;
                }

                echo  json_encode($arry_exam);


        }//else wrong credetional details
     }//else database problem




}

/****************************************************/









/********************************DEPT VIEW: ADMIN******************************************/

if($_POST['view_stud_sub_tech']){

    $my_register=json_decode($_POST["view_stud_sub_tech"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $sbj_id = $my_register->sbj_id;

     $verify_p = "SELECT id,password FROM teacher WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){

            // subject department && semester
            $sbj_dept_n_sem="SELECT department,semester FROM master_semester WHERE id=$sbj_id LIMIT 1";

            $result51 = mysqli_query($conn, $sbj_dept_n_sem);
                //create an array
                $sub_dpt_for_type;
                $sub_sem_for_type;
                while($row51 =mysqli_fetch_assoc($result51))
                {
                    $sub_dpt_for_type = $row51['department'];
                    $sub_sem_for_type = $row51['semester'];
                }

            /*****************************************************/

            $get_dept_type="SELECT type FROM hod WHERE department='$sub_dpt_for_type' LIMIT 1 ";

            $result53 = mysqli_query($conn, $get_dept_type);
                //create an array
                $sub_dpt_type;
                while($row53 =mysqli_fetch_assoc($result53))
                {
                    $sub_dpt_type = $row53['type'];
                }

            /***********************************************************/

            if ($sub_dpt_type=="common") {//

                $sql_stud_select_sub="SELECT id FROM student_options WHERE $sub_dpt_for_type"."_"."$sub_sem_for_type = 1";

                $result67 = mysqli_query($conn, $sql_stud_select_sub);
                $emparray = array();
                $stud_id_for_sub_sel;
                    while($row67 =mysqli_fetch_assoc($result67))
                    {
                        $stud_id_for_sub_sel = $row67['id'];

                        $stud_gt_record="SELECT * FROM student WHERE id=$stud_id_for_sub_sel LIMIT 1";

                            $result68 = mysqli_query($conn, $stud_gt_record);

                            while($row =mysqli_fetch_assoc($result68))
                            {
                                $emparray[] = $row;
                            }



                    }

                    echo json_encode($emparray);



                
            }elseif($sub_dpt_type=="individual"){

                    $sql = "select * from student WHERE department='$sub_dpt_for_type' && semester=$sub_sem_for_type";
                    $result = mysqli_query($conn, $sql);
                    //create an array
                    $emparray = array();
                    while($row =mysqli_fetch_assoc($result))
                    {
                        $emparray[] = $row;
                    }
                    echo json_encode($emparray);

            }



            // do anything safe
              


        }//else wrong credetional details
     }//else database problem

}
/********************************************************************************************/


/********************************manage_sub_exam : teacher******************************************/

if($_POST['manage_sub_exam']){

    $dept_view_=json_decode($_POST["manage_sub_exam"]);

    $id = $dept_view_->id;
    $password = $dept_view_->password;
    $subject_id = $dept_view_->sbj_id;
    
    $verify_p = "SELECT id,password FROM teacher WHERE id='$id' && password='$password'";
    if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
                //fetch table rows from mysql db
                $sql = "select * from master_examinition WHERE subject_id=$subject_id";
                $result = mysqli_query($conn, $sql);

                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);
        }//else wrong credetional details
     }//else database problem

}
/**************************************************************/
/***********************************    STOP EXAM    ********************************************/

if ($_POST['199_stop_exam']) {

    $dept_view_=json_decode($_POST["199_stop_exam"]);
    $id = $dept_view_->id;
    $password = $dept_view_->password;
    $exam_id = $dept_view_->exam_id;
    $subject_id = $dept_view_->subject_id;
    

     $verify_p = "SELECT id,password FROM teacher WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
           

           $pathTest="generated/exam/$subject_id/199_live_test.txt";
           $pathTime="generated/exam/$subject_id/199_live_test_time.txt";

                if (unlink($pathTest)) {
                    unlink($pathTime);

                    $update_mast_ex="UPDATE master_examinition SET stop_exam='1' WHERE id=$exam_id";
                    $conn->query($update_mast_ex);

                    echo "4567";
                }else{
                    echo "there not any given exam";
                }

            }//else wrong credetional details
     }//else database problem
}
/******************************************************************************/
/***********************************    SHOW EXAM    ********************************************/

if ($_POST['199_show_exam']) {

    $dept_view_=json_decode($_POST["199_show_exam"]);
    $id = $dept_view_->id;
    $password = $dept_view_->password;
    $exam_id = $dept_view_->exam_id;
    $subject_id = $dept_view_->subject_id;
    

     $verify_p = "SELECT id,password FROM teacher WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
           

                    $update_mast_ex="UPDATE master_examinition SET answer_release='1' WHERE id=$exam_id";
                    $conn->query($update_mast_ex);

                    echo "4569";// show exam
                    
            }//else wrong credetional details
     }//else database problem
}
/***********************************    HIDE EXAM    ********************************************/

if ($_POST['199_hide_exam']) {

    $dept_view_=json_decode($_POST["199_hide_exam"]);
    $id = $dept_view_->id;
    $password = $dept_view_->password;
    $exam_id = $dept_view_->exam_id;
    $subject_id = $dept_view_->subject_id;
    

     $verify_p = "SELECT id,password FROM teacher WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
           

                    $update_mast_ex="UPDATE master_examinition SET answer_release='0' WHERE id=$exam_id";
                    $conn->query($update_mast_ex);

                    echo "4568";// hide exam

            }//else wrong credetional details
     }//else database problem
}
/******************************************************************************/
/***********************************    delete_selection_table    ********************************************/

if ($_POST['delete_selection_table']) {

    $dept_view_=json_decode($_POST["delete_selection_table"]);
    $id = $dept_view_->id;
    $password = $dept_view_->password;
    $exam_id = $dept_view_->exam_id;
    $subject_id = $dept_view_->subject_id;
    

     $verify_p = "SELECT id,password FROM teacher WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
           

                    $update_mast_ex="DROP TABLE live_exam_$subject_id";
                    $conn->query($update_mast_ex);

                    $update_mast_ex3="UPDATE master_examinition SET delete_selection_table='1' WHERE id=$exam_id";
                    $conn->query($update_mast_ex3);

                    echo "4571";// hide exam

            }//else wrong credetional details
     }//else database problem
}
/******************************************************************************/

/***********************************    delete_exam_everything    ********************************************/

if ($_POST['delete_exam_everything']) {

    $dept_view_=json_decode($_POST["delete_exam_everything"]);
    $id = $dept_view_->id;
    $password = $dept_view_->password;
    $exam_id = $dept_view_->exam_id;
    $subject_id = $dept_view_->subject_id;
    

     $verify_p = "SELECT id,password FROM teacher WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
           
           // delete exam files.

           $pathTest="generated/exam/$subject_id/199_live_test.txt";
           $pathTime="generated/exam/$subject_id/199_live_test_time.txt";
           unlink($pathTime);
           unlink($pathTest);

           // delete live exam table
           $update_mast_ex="DROP TABLE live_exam_$subject_id";
            $conn->query($update_mast_ex);


        $department_name;
        $sql_getNm="SELECT department FROM master_semester WHERE id=$subject_id LIMIT 1";
        $result61 = mysqli_query($conn, $sql_getNm);
        while($row61 =mysqli_fetch_assoc($result61))
           {
            $department_name = $row61['department'];
           }
// delete department marks column
            $sql_delete_marks_column="ALTER TABLE $department_name"."_marks DROP $subject_id"."_"."$exam_id";
            $conn->query($sql_delete_marks_column);

// delete master_examinition column
                    $update_mast_ex3="DELETE FROM master_examinition WHERE id=$exam_id";
                    $conn->query($update_mast_ex3);

                    echo "4571";// hide exam

            }//else wrong credetional details
     }//else database problem
}
/******************************************************************************/
/***********************************    delete_exam_everything_administrator    ********************************************/

if ($_POST['delete_exam_everything_administrator']) {

    $dept_view_=json_decode($_POST["delete_exam_everything_administrator"]);
    $id = $dept_view_->id;
    $password = $dept_view_->password;
    $exam_id = $dept_view_->exam_id;
//    $subject_id = $dept_view_->subject_id;
    

     $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){

            //get subject id
            $subject_id;
             $sql_getsubjetid="SELECT subject_id FROM master_examinition WHERE id=$exam_id LIMIT 1";
        $result6190 = mysqli_query($conn, $sql_getsubjetid);
        while($row6190 =mysqli_fetch_assoc($result6190))
           {
        $subject_id = $row6190['subject_id'];
           }
           
           // delete exam files.

           $pathTest="generated/exam/$subject_id/199_live_test.txt";
           $pathTime="generated/exam/$subject_id/199_live_test_time.txt";
           unlink($pathTime);
           unlink($pathTest);

           // delete live exam table
           $update_mast_ex="DROP TABLE live_exam_$subject_id";
            $conn->query($update_mast_ex);


$update_mast_ex3="DELETE FROM master_examinition WHERE id=$exam_id";
                    $conn->query($update_mast_ex3);

                    echo "4571";// hide exam




        $department_name;
        $sql_getNm="SELECT department FROM master_semester WHERE id=$subject_id LIMIT 1";
        $result61 = mysqli_query($conn, $sql_getNm);
        while($row61 =mysqli_fetch_assoc($result61))
           {
            $department_name = $row61['department'];
           }
// delete department marks column
            $sql_delete_marks_column="ALTER TABLE $department_name"."_marks DROP $subject_id"."_"."$exam_id";
            $conn->query($sql_delete_marks_column);

// delete master_examinition column
                    

            }//else wrong credetional details
     }//else database problem
}
/******************************************************************************/

if($_POST['view_stud_selections_tech']){

    $my_register=json_decode($_POST["view_stud_selections_tech"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $sbj_id = $my_register->sbj_id;

     $verify_p = "SELECT id,password FROM teacher WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){


             $sql = "select * from live_exam_$sbj_id";
                $result = mysqli_query($conn, $sql);

                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);



        }
    }
}

/******************************************************************************//******************************************************************************/

if($_POST['view_stud_selections_administrator']){

    $my_register=json_decode($_POST["view_stud_selections_administrator"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $sbj_id = $my_register->sbj_id;

     $verify_p = "SELECT id,password FROM administrator WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){


             $sql = "select * from student_options";
                $result = mysqli_query($conn, $sql);

                //create an array
                $emparray = array();
                while($row =mysqli_fetch_assoc($result))
                {
                    $emparray[] = $row;
                }
                echo json_encode($emparray);



        }
    }
}

/******************************************************************************/

if($_POST['view_stud_subject_marks']){

    $my_register=json_decode($_POST["view_stud_subject_marks"]);

    $id = $my_register->id;
    $password = $my_register->password;
    $sbj_id = $my_register->sbj_id;

     $verify_p = "SELECT id,password FROM teacher WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){




        $department_name;
        $semester;
        $sql_getNm="SELECT department, semester FROM master_semester WHERE id=$sbj_id LIMIT 1";
        $result61 = mysqli_query($conn, $sql_getNm);
        while($row61 =mysqli_fetch_assoc($result61))
           {
            $department_name = $row61['department'];
            $semester = $row61['semester'];
           }


/*****************************************************/

            $get_dept_type="SELECT type FROM hod WHERE department='$department_name' LIMIT 1 ";

            $sub_dpt_type;

            $result53 = mysqli_query($conn, $get_dept_type);
                //create an array
                $sub_dpt_type;
                while($row53 =mysqli_fetch_assoc($result53))
                {
                    $sub_dpt_type = $row53['type'];
                }

/***********************************************************/



            $emparray = array();

            if ($sub_dpt_type=="common") {

                $sql_stud_select_sub="SELECT id FROM student_options WHERE $department_name"."_"."$semester = 1";

                $result67 = mysqli_query($conn, $sql_stud_select_sub);
                
                $stud_id_for_sub_sel;
                    while($row67 =mysqli_fetch_assoc($result67))
                    {
                        $stud_id_for_sub_sel = $row67['id'];

                        $stud_gt_record="SELECT id FROM student WHERE id=$stud_id_for_sub_sel LIMIT 1";

                            $result68 = mysqli_query($conn, $stud_gt_record);

                            while($row =mysqli_fetch_assoc($result68))
                            {
                                $emparray[] = $row['id'];
                            }



                    }

                    // json_encode($emparray);



                
            }elseif($sub_dpt_type=="individual"){

                    $sql = "SELECT id from student WHERE department='$department_name' && semester=$semester";

                    $result = mysqli_query($conn, $sql);
                    //create an array
                    while($row =mysqli_fetch_assoc($result))
                    {
                        $emparray[] = $row['id'];
                    }
                    // json_encode($emparray);

            }




$stud_id_list="(";
foreach ($emparray as $key => $value) {
    //echo $value;
    $stud_id_list=$stud_id_list." $value,";
}


 $stud_id_list=rtrim($stud_id_list,",");

    $stud_id_list=$stud_id_list.")";





























        $sql_getcolumn_marks="SELECT id,";

        $x1;
        $exam_id;

         $get_exam_id="SELECT id FROM master_examinition WHERE subject_id='$sbj_id'";
        $result66 = mysqli_query($conn, $get_exam_id);
        while($row66 =mysqli_fetch_assoc($result66))
           {
            $exam_id = $row66['id'];
            $x1=$x1." $sbj_id"."_"."$exam_id,";
           }

           $x1=rtrim($x1,",");

             
        $sql_getcolumn_marks=$sql_getcolumn_marks.$x1." FROM $department_name"."_marks WHERE id IN $stud_id_list";



                $result23 = mysqli_query($conn, $sql_getcolumn_marks);
 
                $emparray23 = array();
                while($row23 =mysqli_fetch_assoc($result23))
                {   
                    $emparray23[] = $row23;
                }
                
           echo json_encode($emparray23);



        }
    }
}

/*******************************************************************************/



/***********************************    REQUEST EXAM    ********************************************/


if ($_POST['private_live_test']) {


 $sd1=json_decode($_POST["private_live_test"]);

    $id = $sd1->id;
    $password = $sd1->password;
    $department = $sd1->department;
    $semester = $sd1->semester;



     $verify_p = "SELECT id,password FROM student WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything





            //echo "I will provide you your subject list as soon as possible";

            $sind_sub = "SELECT id FROM master_semester WHERE department='$department' && semester='$semester'";
                
            $result1 = mysqli_query($conn, $sind_sub);
                //create an array
                $emparray1 = array();
                while($row1 =mysqli_fetch_assoc($result1))
                {
                    $emparray1[] = $row1;
                }
                //echo json_encode($emparray1);


            $common_sb="SELECT * FROM student_options WHERE id=$id";

            $result2 = mysqli_query($conn, $common_sb);
                //create an array
                $emparray2 = array();
                while($row2 =mysqli_fetch_assoc($result2))
                {
                    $emparray2[] = $row2;
                }
                
                //json_encode($emparray2);


                $a=$emparray2[0];

                //echo "\n\n\n";

                foreach ($a as $key => $value) {
                    if ($value==1) {

                         $subNm54 = substr($key, 0, strpos($key, "_"));

                        $sql_cmn_sb="SELECT id FROM master_semester WHERE department='$subNm54' && semester=$semester LIMIT 1";
                        $result51 = mysqli_query($conn, $sql_cmn_sb);

                        $emparray51 = array();

                        while($row51 =mysqli_fetch_assoc($result51))
                        {
                            $emparray1[] = $row51;
                        }
                    
                    



                    }
                }

                 json_encode($emparray1);// only subject id



/********** FINAL ALL SUBJECT ID RECIEVED*/
foreach ($emparray1 as $key => $value) {
        $dep=$emparray1[$key];
        //$value2 is subject code 
        foreach ($dep as $key2 => $value2) {
        //echo "id=$key2 and subject_id= $value2 \n";


            // CHECKING IF STUDENT EXAM IS GIVEN OR NOT
            // GETTING EXAM ID
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx/

            $find_last_exam_id="SELECT id FROM master_examinition WHERE subject_id=$value2 ORDER BY id DESC LIMIT 1";

            $result62 = mysqli_query($conn, $find_last_exam_id);
                $exam_id_for_check;
                while($row62 =mysqli_fetch_assoc($result62))
                {
                    $exam_id_for_check = $row62['id'];
                }

                if (is_null($exam_id_for_check)) {
                    break;//
                }
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx/

                $sql_get_deptnm="SELECT department FROM master_semester WHERE id=$value2 LIMIT 1";

                $result44 = mysqli_query($conn, $sql_get_deptnm);
                $sub_deptnm;
                while($row44 =mysqli_fetch_assoc($result44))
                {
                    $sub_deptnm = $row44['department'];
                }
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx/

            // CHECKING student is filled or not exam
                $subExid=$value2."_".$exam_id_for_check;

                $dept_marks_null_or_not="SELECT $subExid FROM $sub_deptnm"."_marks WHERE id=$id";

                $result34 = mysqli_query($conn, $dept_marks_null_or_not);
                //create an array
                $marks_filled;
                while($row34 =mysqli_fetch_assoc($result34))
                {
                    $marks_filled = $row34[$subExid];
                }
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx/
                $pathTest="generated/exam/$value2/199_live_test.txt";

                if (is_null($marks_filled)) {
                  // echo "$value2 is null";
                    if (readfile($pathTest)) { 
                        //htmlspecialchars(readfile($pathTest))//also override json

                         //echo "\n this is current exam $value2 \n";
                        break 2;
                    }

                }else{
                    //echo "$value2 is not null";
                    if (file_exists($pathTest)) {
                        echo "7656";//" you already submitted $subExid";
                        break 2;// AT A TIME STUDENT GIVE ONLY ONE EXAM..
                    }
                }


        $exam_id_for_check=null;
        $marks_filled=null;
    }
}



        }//else wrong credetional details
     }//else database problem


    //echo "1532";//no exam DO NOT USE THIS CODE
}
/***************************************************************************************************/

if ($_POST['private_live_test_time']) {






 $sd1=json_decode($_POST["private_live_test_time"]);

    $id = $sd1->id;
    $password = $sd1->password;
    $department = $sd1->department;
    $semester = $sd1->semester;



     $verify_p = "SELECT id,password FROM student WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            // do anything





            //echo "I will provide you your subject list as soon as possible";

            $sind_sub = "SELECT id FROM master_semester WHERE department='$department' && semester='$semester'";
                
            $result1 = mysqli_query($conn, $sind_sub);
                //create an array
                $emparray1 = array();
                while($row1 =mysqli_fetch_assoc($result1))
                {
                    $emparray1[] = $row1;
                }
                //echo json_encode($emparray1);


            $common_sb="SELECT * FROM student_options WHERE id=$id";

            $result2 = mysqli_query($conn, $common_sb);
                //create an array
                $emparray2 = array();
                while($row2 =mysqli_fetch_assoc($result2))
                {
                    $emparray2[] = $row2;
                }
                
                //json_encode($emparray2);


                $a=$emparray2[0];

                //echo "\n\n\n";

                foreach ($a as $key => $value) {
                    if ($value==1) {

                         $subNm54 = substr($key, 0, strpos($key, "_"));

                        $sql_cmn_sb="SELECT id FROM master_semester WHERE department='$subNm54' && semester=$semester LIMIT 1";
                        $result51 = mysqli_query($conn, $sql_cmn_sb);

                        $emparray51 = array();

                        while($row51 =mysqli_fetch_assoc($result51))
                        {
                            $emparray1[] = $row51;
                        }
                    
                    



                    }
                }

                 json_encode($emparray1);// only subject id



/********** FINAL ALL SUBJECT ID RECIEVED*/
foreach ($emparray1 as $key => $value) {
        $dep=$emparray1[$key];
        foreach ($dep as $key2 => $value2) {
        //echo "id=$key2 and subject_id= $value2 \n";


         $pathTest="generated/exam/$value2/199_live_test_time.txt";

        if (readfile($pathTest)) {
            //echo "\n this is current exam $value2 \n";
            break 2;
        }

    }
}



        }//else wrong credetional details
     }//else database problem


    //echo "1532";//no exam DO NOT USE THIS CODE








}

/*****************************************************************************************************/

/*********************************   SUBMIT EXAM   ********************************************/

if ($_POST['exam_submit']) {
    //echo "OOOOOOO";
     $exam_submit=json_decode($_POST['exam_submit']);

     $id=$exam_submit->id;
     $password=$exam_submit->password;
     $marks=$exam_submit->marks;
     $subject_code=$exam_submit->subject_code;
     $exam_id=$exam_submit->exam_id;

   


     $verify_p = "SELECT id,password FROM student WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){


           // GETTING DEPT NAME
            $sql_gt_dept="SELECT department FROM master_semester WHERE id=$subject_code";
            $result871 = mysqli_query($conn, $sql_gt_dept);
                $sub_dept;
                while($row871 =mysqli_fetch_assoc($result871))
                {
                    $sub_dept = $row871['department'];
                }


            

                $put_marks="UPDATE $sub_dept"."_marks SET $subject_code"."_"."$exam_id ='$marks' WHERE id=$id";

               if ($conn->query($put_marks)) {
                    echo "Successfully submit";
               }else{
                    echo "Failled submit";
               }





        }//else wrong credetional details
     }//else database problem


}
/*************************************************************************************************/


/*********************************   LIVE EXAM MARKS   ********************************************/


if ($_POST['live_exam_selections']) {
    
     $live_marks_obj=json_decode($_POST['live_exam_selections']);
     $live_marks_id="s_".$live_marks_obj->id;  
     $live_marks_subject_code=$live_marks_obj->subject_code;  
     $live_marks_exam_id=$live_marks_obj->exam_id;    
     $live_marks_q_length=$live_marks_obj->q_length;


     //must be add columnname
     echo  $query_add_column = "ALTER TABLE live_exam_"."$live_marks_subject_code ADD $live_marks_id varchar(10)";



     if($conn->query($query_add_column)){
            echo "query success";
        

        

     for ($dee=1; $dee <=$live_marks_q_length ; $dee++) {
        try {

             $qn="q".$dee;//concate string+int.

            $l_m=$live_marks_obj->$qn;
            if ($l_m===null) {
                 $l_m="Skip";//for skip detect
             }

            // echo $l_m;

            echo $query_insert_marks="UPDATE live_exam_"."$live_marks_subject_code SET $live_marks_id='$l_m' WHERE sr_no='$dee'";

            if ($conn->query($query_insert_marks)) {
                        echo "Successfully submit";
                }else{
                     echo "Failled submit";
                }



         } catch (Exception $e) {
             echo $e;
         } 
         echo "--";
            
        }
     










     }else{
        echo "column failled";
     }
  


}

/***************************************************************************/
if ($_POST['stud_marks_stud']) {
    
     $live_marks_obj=json_decode($_POST['stud_marks_stud']);
     $id=$live_marks_obj->id;
     $password=$live_marks_obj->password;

     $verify_p = "SELECT id,password FROM student WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
            


$marksArr = array();


    foreach($live_marks_obj as $key => $value) {

       if ( $id!=$value &&  $password!=$value ) {
            //echo "\n$key is at $value\n";//$sql_get_marks_stud=rtrim($sql_get_marks_stud,",");

            $subID50 = substr($key, 0, strpos($key, "_"));

                $sql_deptNM50 = "SELECT department from master_semester WHERE id=$subID50";
                $result50 = mysqli_query($conn, $sql_deptNM50);
                $deptNM50;//dept name
                while($row =mysqli_fetch_assoc($result50))
                {
                    $deptNM50 = $row['department'];
                }
                
             $sql_getMarks="SELECT $value FROM $deptNM50"."_marks WHERE id=$id";

                $result534 = mysqli_query($conn, $sql_getMarks);

                while($row534 =mysqli_fetch_assoc($result534))
                {
                    $marksArr[$value] = $row534[$value];
                }

        }
}


echo json_encode($marksArr);


//echo $sql_get_marks_stud." FROM ";
            
        }//else wrong credetional details
     }//else database problem


 }

/*****************************************************************************************/
/***********************************    notice_teacher :    **********************************/
if($_POST['notice_teacher']){

    $notice_teacher=json_decode($_POST["notice_teacher"]);

    $subject_id = $notice_teacher->subject_id;

    $path_notice_red="generated/notice/subject/".$subject_id."/notice.txt";

    readfile($path_notice_red);
}
/**************************************************************************************/

/*****************************************  writeNotice    *************************************/

if($_POST['writeNotice_teacher']){

    $writeNotice_teacher=json_decode($_POST["writeNotice_teacher"]);
    $subject_id = $writeNotice_teacher->subject_id;
    $t=$writeNotice_teacher->notice;
   
try{
        $path_notice_write="generated/notice/subject/".$subject_id."/notice.txt";

        $filet = fopen($path_notice_write,"w");

         if($t=="DeepEmpty23"){
            // serever not respond empty value so used here DeepEmpty23
             $t="";
         }

        fwrite($filet,$t);
        fclose($filet);

        readfile($path_notice_write);
      
}catch(Exception $e){
    echo "error";
}
    
}

/*************************************************************/

/***********************************    sub_notice_stud :    **********************************/
if($_POST['sub_notice_stud']){

    $sub_notice_stud=json_decode($_POST["sub_notice_stud"]);

    $id = $sub_notice_stud->id;
    $password = $sub_notice_stud->password;



$arr12=array();
    foreach($sub_notice_stud as $key => $value) {

       if ( $id!=$value &&  $password!=$value ) {

       $path_notice_red="generated/notice/subject/".$value."/notice.txt";

           $arr12[$value]=file_get_contents($path_notice_red);
        }
    }


    echo json_encode($arr12);

}

/**********************************************************************************/
/***********************************    verify_password :    **********************************/
if($_POST['verify_password']){

    $sub_notice_stud=json_decode($_POST["verify_password"]);

    $id = $sub_notice_stud->id;
    $password = $sub_notice_stud->password;

     $verify_p = "SELECT id,password FROM student WHERE id='$id' && password='$password'";
     if($res = mysqli_query($conn, $verify_p)){
        if(mysqli_num_rows($res) > 0){
           echo "1";
        }else{
            echo "0";
        }
     }//else database problem


}










































































































































/**************************     subject_code_submitted_exam_show   **************************/

if($_POST['subject_code_submitted_exam_show']){
    
    $subject_code_12311=$_POST['subject_code_submitted_exam_show'];//I get Subject code.
    
    $submitted_disp_qry="UPDATE exam_complete SET disp='1' WHERE subject_code='$subject_code_12311'";
        if($conn->query($submitted_disp_qry)){
    	echo "sucessfully display submitted exam";//sucessfully display
    }else{
    	echo "system database problem";//system database problem
    }
}


/**************************     recent_test_disp   **************************/

if($_POST['recent_test_disp']){
    
    $subject_code_1271=$_POST['recent_test_disp'];//I get Subject code.
    
    $submitted_disp_qry="SELECT disp FROM exam_complete WHERE subject_code='$subject_code_1271'";
           
           if($res = mysqli_query($conn, $submitted_disp_qry)){ 
    if(mysqli_num_rows($res) > 0){
    /* Value Found */  
        while($row = mysqli_fetch_array($res)){
            echo $row['disp'];
        }//while close
    }//if close else no data found
           }//top if close else query failed
           
}

/********************************	MY REGISTER	**************************************/





if($_POST['my_register']){
	//$login= $_POST["login"];
	

	$my_register=json_decode($_POST["my_register"]);

	//$id = $my_register->id;
	//$password = $my_register->password;


    //fetch table rows from mysql db
    $sql = "select * from register order by id desc";
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

    //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    echo json_encode($emparray);

}









/********************************   EXAMINATON MARK **************************************/





if($_POST['examination_mark']){
    //$login= $_POST["login"];
    

    $examination_mark=json_decode($_POST["examination_mark"]);

    $id = $examination_mark->id;
    $password = $examination_mark->password;


    //fetch table rows from mysql db
    $sql = "select * from exam_marks where id='$id'";
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

    //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray = $row;
    }
    echo json_encode($emparray);

}



/********************************   EXAMINATON EXAM COMPLETE **************************************/





if($_POST['examination_exam_complete']){
    //$login= $_POST["login"];//examination_exam_complete
    

    //$examination_mark=json_decode($_POST["examination_mark"]);

    //$id = $examination_mark->id;
    //$password = $examination_mark->password;


    //fetch table rows from mysql db
    $sql67 = "select status from exam_complete";
    $result67 = mysqli_query($conn, $sql67) or die("Error in Selecting " . mysqli_error($conn));

    //create an array
    $emparray67 = array();
    while($row =mysqli_fetch_assoc($result67))
    {
      $emparray67[]   = $row['status'];
    }
    echo json_encode($emparray67);

}







/********************************   MY MARKS **************************************/





if($_POST['my_marks']){
    //$login= $_POST["login"];
    

    $my_register=json_decode($_POST["my_marks"]);

    //$id = $my_register->id;
    //$password = $my_register->password;


    //fetch table rows from mysql db
    $sql = "select * from exam_marks order by id desc";
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

    //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    echo json_encode($emparray);

}



/********************************   MY LIVE TEST **************************************/





if($_POST['my_live_test']){
    //$login= $_POST["login"];
    

    $my_register=json_decode($_POST["my_live_test"]);

    //$id = $my_register->id;
    //$password = $my_register->password;


    //fetch table rows from mysql db
    $sql = "select * from live_exam";
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

    //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    echo json_encode($emparray);

}



/******************************		SCREENSHOT_VIEW_IMG	*****************************/


if ($_POST['screenshot_img_view']) {
	
	$e="data:image/jpg;base64,";
	$path_rc=$_POST['screenshot_img_view'];
    $fld="64_screen/".$path_rc;
	 $im1=file_get_contents($fld);
		echo $e.$img2=base64_encode($im1);
}
/******************************		profile_img_view	*****************************/


if ($_POST['profile_img_view']) {
	
	$e="data:image/jpg;base64,";
	$path_r34=$_POST['profile_img_view'];
	
	$cn435="avatar/".$path_r34;
    $fld=$cn435.".jpg";
	 $im1=file_get_contents($fld);
		
	
	if($im1==null){
	    $imxx=file_get_contents("avatar/avatarx.png");
		echo $e.$imxxx=base64_encode($imxx);
	}else{
	    echo $e.$img2=base64_encode($im1);
	}
}

/******************************		PROFILE IMAGE getting_avatar	*****************************/


if ($_POST['getting_avatar']) {
    
	$pathd=$_POST['getting_avatar'];
	$e="data:image/jpg;base64,";
    
    $patht345="avatar/".$pathd;
    $patht346=$patht345.".jpg";
     $fld=$patht346;
	 $im1=file_get_contents($fld);
	
		
		if($im1==null){
	    $imxx=file_get_contents("avatar/avatarx.png");
		echo $e.$imxxx=base64_encode($imxx);
	}else{
	    echo $e.$img2=base64_encode($im1);
	}
}






/*****************************************  register_status_change    *************************************/

if($_POST['register_status_change']){
   
    $cr_status= file_get_contents("register_status.txt");
    if($cr_status=="1"){
        //echo "0";
        $filet = fopen("register_status.txt","w");
         $t="0";
        fwrite($filet,$t);
        fclose($filet);
        readfile("register_status.txt");

    }else{
       //echo $cr_status;
        $filet = fopen("register_status.txt","w");
         $t="1";
        fwrite($filet,$t);
        fclose($filet);
        readfile("register_status.txt");
    }
    
    //echo "0";
}

/*****************************************  screenshot_status_change    *************************************/

if($_POST['screenshot_status_change']){
   
    $cr_status= file_get_contents("screenshot_status.txt");
    if($cr_status=="1"){
        //echo "0";
        $filet = fopen("screenshot_status.txt","w");
         $t="0";
        fwrite($filet,$t);
        fclose($filet);
        readfile("screenshot_status.txt");

    }else{
       //echo $cr_status;
        $filet = fopen("screenshot_status.txt","w");
         $t="1";
        fwrite($filet,$t);
        fclose($filet);
        readfile("screenshot_status.txt");
    }
    
    //echo "0";
}

/***********************************    register_status    **********************************/
if($_POST['register_status']){
    readfile("register_status.txt");
} 

/***********************************    screenshot_status    **********************************/
if($_POST['screenshot_status']){
    readfile("screenshot_status.txt");
} 


/*****************************************  writeNotice :ADMIN   *************************************/

if($_POST['writeNotice_admin']){
   
try{
        $file_path="generated/notice/administrator/";
        $filet = fopen($file_path."administrator.txt","w");
         $t=$_POST['writeNotice_admin'];
         if($t=="DeepEmpty23"){
            // serever not respond empty value so used here DeepEmpty23
             $t="";
         }

        fwrite($filet,$t);
        fclose($filet);
        readfile($file_path."administrator.txt");
      
}catch(Exception $e){
    echo "error";
}
    
}


/*****************************************  writeNotice    *************************************/

if($_POST['writeNotice_hod']){

    $writeNotice_hod=json_decode($_POST["writeNotice_hod"]);
    $department = $writeNotice_hod->department;
    $t=$writeNotice_hod->notice;
   
try{
        $path_notice_write="generated/notice/hod/".$department."/notice.txt";

        $filet = fopen($path_notice_write,"w");

         if($t=="DeepEmpty23"){
            // serever not respond empty value so used here DeepEmpty23
             $t="";
         }

        fwrite($filet,$t);
        fclose($filet);

        readfile($path_notice_write);
      
}catch(Exception $e){
    echo "error";
}
    
}


/***********************************    notice_admin :    **********************************/
if($_POST['notice_admin']){
    $file_path="generated/notice/administrator/";
    readfile($file_path."administrator.txt");
}
/***********************************    notice_hod :    **********************************/
if($_POST['notice_hod']){

    $notice_hod=json_decode($_POST["notice_hod"]);

    $department = $notice_hod->department;

    $path_notice_red="generated/notice/hod/".$department."/notice.txt";

    readfile($path_notice_red);
}


/********************************   pdf_listing  **************************************/





if($_POST['pdf_listing']){
    

    $pdf_listing=json_decode($_POST["pdf_listing"]);

    $id = $pdf_listing->id;
    $password = $pdf_listing->password;
    $subject_id = $pdf_listing->subject_id;


    //fetch table rows from mysql db
    $sql = "SELECT * from file_share_manager WHERE subject_id=$subject_id order by time_stamp desc";
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

    //create an array
    $emparray34 = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray34[] = $row;
        //json_encode($emparray);
    }
    echo json_encode($emparray34);

}



/********************************   pdf_listing  COMPLETE **************************************/





































































































































































/****************   THE END    ***************/

?>