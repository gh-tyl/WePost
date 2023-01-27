<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
// OUTPUT: statusCode, status, message, data
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    $dbConnect = $db->connect();
    if ($dbConnect) {
        // $userInfo = $_SESSION[$_POST['token']];
        $result = $dbConnect->query("SELECT u.id,u.first_name,u.last_name,u.email,u.gender,u.country,u.age FROM user_table u WHERE u.role='User'");
        if ($result->num_rows > 0) {
            $userInfo = $result->fetch_all(MYSQLI_ASSOC);
            $response = array(
                "statusCode"=>200,
                "status"=>"success",
                "data"=> $userInfo
            );
            echo(json_encode($response));
            exit();
        } else {
            echo "
            {
                \"statusCode\": 500,
                \"status\": \"error\",
                \"message\": \"Error while fetching data\",
                \"data\": null
            }";
            exit();
        }
    }
    $db->close();
}
?>