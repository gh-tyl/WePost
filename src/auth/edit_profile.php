<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
$db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
$dbConnect = $db->connect();
if ($dbConnect) {
  $uID = intval($_SESSION['logUser']['id']);
  $result = $dbConnect->query("SELECT u.id,u.first_name,u.last_name,u.email,u.gender,u.country,u.age,u.image_path FROM user_table u WHERE u.id=$uID");
  if ($result) {
    $userInfo = $result->fetch_assoc();
    echo "
      {
        \"statusCode\": 200,
        \"status\": \"success\",
        \"data\": {
          \"userInfo\": {
            \"id\": " . $userInfo['id'] . ",
            \"first_name\": \"" . $userInfo['first_name'] . "\",
            \"last_name\": \"" . $userInfo['last_name'] . "\",
            \"email\": \"" . $userInfo['email'] . "\",
            \"gender\": \"" . $userInfo['gender'] . "\",
            \"country\": \"" . $userInfo['country'] . "\",
            \"image_path\": \"" . $userInfo['image_path'] . "\",
          }
        }
      }";
  } else {
    echo "
    {
      \"statusCode\": 500,
      \"status\": \"error\",
      \"message\": \"Internal Server Error\"
    }";
  }
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $age = $_POST['age'];
  $country = $_POST['country'];
  $pic = $_FILES['pic'];

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
        } else
          echo "
                    {
                        \"statusCode\": 500,
                        \"status\": \"error\",
                        \"message\": \"Please upload JPG/JPEG image file.\"
                    }";
      } else
        echo "
        {
            \"statusCode\": 500,
            \"status\": \"error\",
            \"message\": \"Please upload JPG/JPEG image file.\"
        }";
    } else
      echo "
        {
            \"statusCode\": 500,
            \"status\": \"error\",
            \"message\": \"Image is too big\"
        }";
  }

  $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
  if ($dbConnect = $db->connect()) {
    $updateCmd = "UPDATE user_table u SET first_name='" . $fname . "',last_name='" . $lname . "',email='" . $email . "',age=" . $age . ",country='" . $country . "',image_path='" . $uID . "_profile.jpg" . "' WHERE u.id=" . $uID . ";";
    if ($uptRes = $dbConnect->query($updateCmd)) {
      echo "
      {
        \"statusCode\": 200,
        \"status\": \"success\",
        \"message\": \"Profile updated successfully\"
      }";
    } else {
      echo "
      {
        \"statusCode\": 500,
        \"status\": \"error\",
        \"message\": \"Internal Server Error\"
      }
    }";
    }
    $dbConnect->close();
  }
}
?>