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

    // Uploaded Image Check Logic
    if ($image['size'] == 0) {
        $imgurl = null;
    } else {
        $targetDir = "../../data/images/profiles/";
        if ($image['size'] < 1000000) {
            // jpg or png
            if ($image['type'] == "image/jpeg" || $image['type'] == "image/jpg" || $image['type'] == "image/png") {
                if (getimagesize($image['tmp_name']) !== false) {
                    $targetDir = $targetDir . $fname . $lname . rand(1, 10) . ".jpg";
                    if (move_uploaded_file($image['tmp_name'], $targetDir)) {
                        $imgurl = $targetDir;
                    } else
                        echo "
                        {
                            \"statusCode\": 500,
                            \"status\": \"error\",
                            \"message\": \"Image is not uploaded\"
                        }";
                    exit();
                } else
                    echo "
                    {
                        \"statusCode\": 500,
                        \"status\": \"error\",
                        \"message\": \"Please upload JPG/JPEG image file.\"
                    }";
                exit();
            } else
                echo "
                {
                    \"statusCode\": 500,
                    \"status\": \"error\",
                    \"message\": \"Please upload JPG/JPEG image file.\"
                }";
            exit();
        } else
            echo "
            {
                \"statusCode\": 500,
                \"status\": \"error\",
                \"message\": \"Image is too big\"
            }";
        exit();
    }

    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    if ($dbConnected = $db->connect()) {
        $updateCmd = "UPDATE user_table u SET first_name='" . $fname . "',last_name='" . $lname . "',email='" . $email . "',age=" . $age . ",country='" . $country . "',image_path='" . $uID . "_profile.jpg" . "' WHERE u.id=" . $uID . ";";
        $uptRes = $dbConnected->query($updateCmd);
        $dbConnected->close();
        if ($uptRes) {
            echo "
            {
                \"statusCode\": 200,
                \"status\": \"success\",
                \"message\": \"Profile updated successfully\"
            }";
            exit();
        } else {
            echo "
            {
                \"statusCode\": 500,
                \"status\": \"error\",
                \"message\": \"Internal Server Error\"
            }";
            exit();
        }
    }
}
?>