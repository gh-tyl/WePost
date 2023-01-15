<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $pass_orginal = $_POST['pass_orginal'];
  $pass_confirm = $_POST['pass_confirm'];
  if ($pass_orginal !== $pass_confirm) { //Check if both passwords are not matching
    echo "
    {
      \"statusCode\": 400,
      \"status\": \"error\",
      \"message\": \"Passwords doesn't match. Try again\"
    }";
  } else {
    $dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    if ($dbcon = $dbSrv->connect()) {
      $pass_confirm = password_hash($pass_confirm, PASSWORD_DEFAULT); //Hash password
      $uid = $_SESSION['logUser']['id'];
      $result = $dbcon->query("UPDATE user_table SET password='$pass_confirm' WHERE id=$uid;");
      if ($result) { //Command to update password in db
        echo "
        {
          \"statusCode\": 200,
          \"status\": \"success\",
          \"message\": \"Password updated\"
        }";
        exit;
      } else {
        // print_r(mysqli_error($dbcon)); //printing error if there's one
        echo "
        {
          \"statusCode\": 500,
          \"status\": \"error\",
          \"message\": \"Internal server error\"
        }";
      }
      $dbcon->close();
    }
  }
}
?>