<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    if ($db->connect()) {
        $userInfo = $db->select('user_table', array('*'), "email='$email'"); //Get the user login info in db
        if ($userInfo) {
            $userInfo = $userInfo->fetch_assoc(); //transform sql query result in associative array
            if ($userInfo['password'] == $pass) { //Check form pass with password from db
                $_SESSION['logUser'] = $userInfo;
                echo "
                    {
                        \"statusCode\": 200,
                        \"status\": \"success\",
                        \"message\": \"Login successful\",
                        \"isHashed\": false
                    }
                ";
            } else {
                $hashPass = password_verify($pass, $userInfo['password']); //verify password. If returns true means that password is correct
                if ($hashPass) { //On correct password
                    $_SESSION['logUser'] = $userInfo;
                    echo "
                        {
                            \"statusCode\": 200,
                            \"status\": \"success\",
                            \"message\": \"Login successful\",
                            \"isHashed\": true
                        }
                    ";
                }
            }
        }
        $db->close();
        echo "
            {
                \"statusCode\": 401,
                \"status\": \"error\",
                \"message\": \"Invalid credentials\"
            }
        ";
    } else {
        echo "
            {
                \"statusCode\": 500,
                \"status\": \"error\",
                \"message\": \"Internal server error\"
            }
        ";
    }
}
?>