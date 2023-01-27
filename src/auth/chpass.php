<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
// INPUT: token, pass_orginal, pass_confirm
// OUTPUT: statusCode, status, message
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $pass_orginal = $_POST['pass_orginal'];
    $pass_confirm = $_POST['pass_confirm'];
    if ($pass_orginal !== $pass_confirm) { //Check if both passwords are not matching
        $res = array(
            "statusCode" => 400,
            "status" => "error",
            "message" => "Passwords doesn't match. Try again"
        );
        echo json_encode($res);
        exit();
    } else {
        $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
        $dbConnected = $db->connect();
        if ($dbConnected) {
            $pass_confirm = password_hash($pass_confirm, PASSWORD_DEFAULT); //Hash password
            // $uid = $_SESSION[$_POST['token']]['id']; // Get user id from session, production
            $uid = $_POST['id']; // Just for testing
            $result = $dbConnected->query("UPDATE user_table SET password='$pass_confirm' WHERE id=$uid;");
            $dbConnected->close();
            if ($result) { //Command to update password in db
                $res = array(
                    "statusCode" => 200,
                    "status" => "success",
                    "message" => "Password updated"
                );
                echo json_encode($res);
                exit();
            } else {
                $res = array(
                    "statusCode" => 500,
                    "status" => "error",
                    "message" => "Internal server error"
                );
                echo json_encode($res);
                exit();
            }
        }
    }
}
?>