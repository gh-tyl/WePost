<?php
    include '../../services/db.php';

    if($_SERVER['REQUEST_METHOD']=="POST"){

        $fname   = $_POST['fname'];
        $lname   = $_POST['lname'];
        $email   = $_POST['email'];
        $pass    = $_POST['pass'];
        $image   = $_FILES['image'];
        $role    = $_POST['role'];

        // Optional Data Null check Logic
        if(isset($_POST['gender'])) $gender = $_POST['gender'];
        else $gender = "";

        if(isset($_POST['age'])) $age = $_POST['age'];
        else $age = 0;

        if(isset($_POST['country'])) $country = $_POST['country'];
        else $country = "";

        // Password Check Logic
        if(strlen($pass) < 8){
            header("Location: ".$baseName.'pages/user_auth/register.php?msg=passlong');
            exit();
         }

        // Uploaded Image Check Logic
        if($image['size']==0) {
            $imgurl = null;
        }
        else {
            $targetDir = "../../pages/user_auth/images/";
            if($image['size']<1000000){
                if($image['type']=="image/jpeg" || $image['type']=="image/jpg"){
                    if(getimagesize($image['tmp_name'])!== false){
                        $targetDir = $targetDir.$fname.$lname.rand(1,10).".jpg";
                        if(move_uploaded_file($image['tmp_name'],$targetDir)){
                            $imgurl = $targetDir;
                        } 
                        else echo "Image is not uploaded";
                    }
                    else echo "Please upload JPG/JPEG image tyle file.";
                }
                else echo $image['type'];
            }
            else echo "Image is big!!!!!";
        } 

        // Input Data Check Log
        // echo $fname.",".$lname.",".$email.",".$pass.",".$gender.",".
        //       $age.",".$country.",".$imgurl.",".$role;
        // echo "<br/><br/>";

        //DB Connection and Insert Data
        $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
        $dbcon = $db->dbConnect();

        // insert Data into user_table
        if ($dbcon) {
            $tbName = 'user_table';
            $valuesArray = array(
                "'$fname'",
                "'$lname'",
                "'$email'",
                "'$pass'",
                "'$gender'",
                "$age",
                "'$country'",
                "'$imgurl'",
                "'$role'"
            );
            $fieldArray = array('first_name', 'last_name', "email", 'password','gender','age','country','image_path','role');
            $result = $db->insert($tbName, $valuesArray, $fieldArray);
            print_r($valuesArray);
        }        
        $db->closeDb();

        header("Location: ".$baseName.'pages/user_auth/register.php?msg=ok');
        exit();
    }
?>