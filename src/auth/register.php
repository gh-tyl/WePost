<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
// INPUT: fname, lname, email, password, image, role
// OUTPUT: statusCode, status, message
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $role = "User";

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

    // TODO: It's better to do this on the frontend
    // // Password Check Logic
    // if (strlen($pass) < 8) {
    //     echo "
    //         {
    //             \"statusCode\": 500,
    //             \"status\": \"error\",
    //             \"message\": \"Password is too short\"
    //         }";
    // }

    // TODO: It's better to do this on the frontend
    // // Password Char and Number Combination Check Logic
    // $charArray = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    // $numArray = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

    // $passleng = strlen($pass);
    // $charchk = 0;
    // $numchk = 0;

    // for ($cnt = 0; $passleng > $cnt; $cnt++) {
    //     // echo $cnt . "]";
    //     // Character check part(convert to lowercase)
    //     foreach ($charArray as $val) {
    //         if (strtolower($pass[$cnt]) == $val) {
    //             // echo "Matched Char[" . $val . "]<br/>";
    //             $charchk++;
    //         }
    //     }
    //     // Number check part
    //     foreach ($numArray as $val) {
    //         if ($pass[$cnt] == $val) {
    //             // echo "Matched Num[" . $val . "]<br/>";
    //             $numchk++;
    //         }
    //     }
    // }

    // // echo "<br/>PassChk:" . $charchk . "," . $numchk;
    // if ($charchk == 0 || $numchk == 0) {
    //     echo "
    //         {
    //             \"statusCode\": 500,
    //             \"status\": \"error\",
    //             \"message\": \"Password must contain at least one character and one number\"
    //         }";
    // }

    // // Uploaded Image Check Logic
    // if ($image['size'] == 0) {
    //     $imgurl = null;
    // } else {
    //     $targetDir = "../../data/images/profiles/";
    //     if ($image['size'] < 1000000) {
    //         // jpg or png
    //         if ($image['type'] == "image/jpeg" || $image['type'] == "image/jpg" || $image['type'] == "image/png") {
    //             if (getimagesize($image['tmp_name']) !== false) {
    //                 $targetDir = $targetDir . $fname . $lname . rand(1, 10) . ".jpg";
    //                 if (move_uploaded_file($image['tmp_name'], $targetDir)) {
    //                     $imgurl = $targetDir;
    //                 } else
    //                     $res = array(
    //                         "statusCode" => 500,
    //                         "status" => "error",
    //                         "message" => "Image is not uploaded"
    //                     );
    //                 echo json_encode($res);
    //                 exit();
    //             } else
    //                 $res = array(
    //                     "statusCode" => 500,
    //                     "status" => "error",
    //                     "message" => "Please upload JPG/JPEG image file."
    //                 );
    //             echo json_encode($res);
    //             exit();
    //         } else
    //             $res = array(
    //                 "statusCode" => 500,
    //                 "status" => "error",
    //                 "message" => "Please upload JPG/JPEG image file."
    //             );
    //         echo json_encode($res);
    //         exit();
    //     } else
    //         $res = array(
    //             "statusCode" => 500,
    //             "status" => "error",
    //             "message" => "Image is too big"
    //         );
    //     echo json_encode($res);
    //     exit();
    // }
    // Image path is null
    $imgurl = null;

    // Password Hash Logic
    $pass = password_hash($pass, PASSWORD_DEFAULT);

    //DB Connection and Insert Data
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    $dbcon = $db->connect();

    //insert Data into user_table
    if ($dbcon) {
        $tbName = 'user_table';
        $valuesArray = array(
            "'$fname'",
            "'$lname'",
            "'$email'",
            "'$pass'",
            "'$gender'",
            "'$age'",
            "'$country'",
            "'$imgurl'",
            "'$role'"
        );
        $fieldArray = array('first_name', 'last_name', "email", 'password', 'gender', 'age', 'country', 'image_path', 'role');
        $result = $db->insert($tbName, $valuesArray, $fieldArray);
        $db->close();
        $res = array(
            "statusCode" => 200,
            "status" => "success",
            "message" => "User Registered Successfully"
        );
        echo json_encode($res);
        exit();
    } else {
        $res = array(
            "statusCode" => 500,
            "status" => "error",
            "message" => "Database Connection Error"
        );
        echo json_encode($res);
        exit();
    }
}
?>