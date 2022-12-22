<?php
include "../../services/db.php";
include "../../config/config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $image = $_FILES['image'];
    $role = $_POST['role'];

    // Optional Data Null check Logic
    if (isset($_POST['gender']))
        $gender = $_POST['gender'];
    else
        $gender = "";

    if (isset($_POST['age']))
        $age = $_POST['age'];
    else
        $age = 0;

    if (isset($_POST['country']))
        $country = $_POST['country'];
    else
        $country = "";

    // Password Check Logic
    if (strlen($pass) < 8) {
        // header("Location: " . $baseName . 'pages/user_auth/register.php?msg=passlong');
        header("Location: ./register.php?msg=passlong");
        exit();
    }

    // Password Char and Number Combination Check Logic
    $charArray = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    $numArray = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

    $passleng = strlen($pass);
    $charchk = 0;
    $numchk = 0;

    for ($cnt = 0; $passleng > $cnt; $cnt++) {
        // echo $cnt . "]";
        // Character check part(convert to lowercase)
        foreach ($charArray as $val) {
            if (strtolower($pass[$cnt]) == $val) {
                // echo "Matched Char[" . $val . "]<br/>";
                $charchk++;
            }
        }
        // Number check part
        foreach ($numArray as $val) {
            if ($pass[$cnt] == $val) {
                // echo "Matched Num[" . $val . "]<br/>";
                $numchk++;
            }
        }
    }

    // echo "<br/>PassChk:" . $charchk . "," . $numchk;
    if ($charchk == 0 || $numchk == 0) {
        header("Location: ./register.php?msg=passchk");
        exit();
    }

    // Password Hash Logic
    $pass = password_hash($pass, PASSWORD_DEFAULT);

    // Uploaded Image Check Logic
    if ($image['size'] == 0) {
        $imgurl = null;
    } else {
        $targetDir = "../../pages/user_auth/images/";
        if ($image['size'] < 1000000) {
            if ($image['type'] == "image/jpeg" || $image['type'] == "image/jpg") {
                if (getimagesize($image['tmp_name']) !== false) {
                    $targetDir = $targetDir . $fname . $lname . rand(1, 10) . ".jpg";
                    if (move_uploaded_file($image['tmp_name'], $targetDir)) {
                        $imgurl = $targetDir;
                    } else
                        echo "Image is not uploaded";
                } else
                    echo "Please upload JPG/JPEG image tyle file.";
            } else
                echo $image['type'];
        } else
            echo "Image is big!!!!!";
    }

    // // Input Data Check Log
    // echo $fname . "," . $lname . "," . $email . "," . $pass . "," . $gender . "," .
    //     $age . "," . $country . "," . $imgurl . "," . $role;
    // echo "<br/><br/>";

    //DB Connection and Insert Data
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    $dbcon = $db->dbConnect();

    //insert Data into user_table
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
        $fieldArray = array('first_name', 'last_name', "email", 'password', 'gender', 'age', 'country', 'image_path', 'role');
        $result = $db->insert($tbName, $valuesArray, $fieldArray);
        // print_r($valuesArray);
    }
    $db->closeDb();

    header("Location: ./register.php?msg=ok");
    exit();
}
?>