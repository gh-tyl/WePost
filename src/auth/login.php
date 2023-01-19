<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
// INPUT: email, password
// OUTPUT: statusCode, status, message, isHashed, data(token)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    if ($db->connect()) {
        $userInfo = $db->select('user_table', array('*'), "email='$email'"); //Get the user login info in db
        if ($userInfo) {
            // create a token
            // $token = bin2hex(random_bytes(64));
            session_start();
            $token = session_id();
            $userInfo = $userInfo->fetch_assoc(); //transform sql query result in associative array
            $db->close();
            if ($userInfo['password'] == $pass) { //Check form pass with password from db
                $res = array(
                    'statusCode' => 200,
                    'status' => 'success',
                    'message' => 'Login successful',
                    'isHashed' => false,
                    'data' => array(
                        'token' => $token,
                        'role' => $userInfo["role"]
                    )
                );
                $_SESSION['logUser'] = $userInfo;
                // $_SESSION[$token] = $userInfo;
                // print_r($_SESSION);
                // print_r($_SESSION);
                echo json_encode($res);
                exit();
            } else {
                $hashPass = password_verify($pass, $userInfo['password']); //verify password. If returns true means that password is correct
                if ($hashPass) { //On correct password
                    $_SESSION['logUser'] = $userInfo;
                    echo "
                        {
                            \"statusCode\": 200,
                            \"status\": \"success\",
                            \"message\": \"Login successful\",
                            \"isHashed\": true,
                            \"data\": {
                                \"token\": \"$token\"
                            }
                        }
                        ";
                    $_SESSION[$token] = $userInfo;
                    exit();
                }
            }
        }
        echo "
            {
                \"statusCode\": 401,
                \"status\": \"error\",
                \"message\": \"Invalid credentials\",
                \"isHashed\": false,
                \"data\": {}
            }
            ";
        exit();
    } else {
        echo "
            {
                \"statusCode\": 500,
                \"status\": \"error\",
                \"message\": \"Internal server error\",
                \"isHashed\": false,
                \"data\": {}
            }
            ";
        exit();
    }
}
?>