<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
function writeInFile($fileName, $newData)
{ //write in file new data
    $file = fopen($fileName, 'w');
    fwrite($file, $newData);
    fclose($file);
}
// INPUTS: token, title, contents, (genre_id_01, genre_id_02, genre_id_03)
// OUTPUTS: statusCode, status, message
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $token = $_POST['token'];
    session_id($token);
    session_start();
    if (!$_SESSION['logUser']) {
        $res = array(
            'statusCode' => 401,
            'status' => 'error',
            'message' => 'Invalid token'
        );
        echo json_encode($res);
        exit();
    }
    $user_id = $_SESSION['logUser']['id'];
    $title = $_POST['title'];
    $contents = $_POST['content'];
    $genre1 = $_POST['genre_id_01'];
    if (isset($_POST['genre_id_02'])) {
        $genre2 = $_POST['genre_id_02'];
    } else {
        $genre2 = 0;
    }
    if (isset($_POST['genre_id_03'])) {
        $genre3 = $_POST['genre_id_03'];
    } else {
        $genre3 = 0;
    }

    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    $dbConnected = $db->connect();
    $lastPostID = $db->select('article_table', ['id']); //Have to change the user number to variable
    $lastPostID = max($lastPostID->fetch_all(MYSQLI_ASSOC))['id'] + 1; //Find the last postID of user and sum +1 to generate fileName
    writeInFile("../../data/contents/post_$lastPostID.txt", $contents);
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    if ($dbConnected) {
        date_default_timezone_set('America/Vancouver');
        $date = date('Y-m-d H:i:s');
        // $user_id = $_SESSION[$_POST['token']['id']];
        // $user_id = 1;
        $insertCmd = "INSERT INTO article_table (user_id, title, content_path, genre_id_01, likes, stores, is_deleted, datetime) VALUES ($user_id,'$title','post_$lastPostID.txt',$genre1,0,0,false,'$date')";
        $isInserted = $dbConnected->query($insertCmd);
        $dbConnected->close();
        if ($isInserted === TRUE) {
            $created = 1;
            $res = array(
                "statusCode" => 200,
                "status" => "success",
                "message" => "New record created successfully!"
            );
            echo json_encode($res);
            exit();
        } else {
            $res = array(
                "statusCode" => 500,
                "status" => "error",
                "message" => "New record created failed!",
                "error" => $insertCmd
            );
            echo json_encode($res);
            exit();
        }
    } else {
        $res = array(
            "statusCode" => 500,
            "status" => "error",
            "message" => "No database connection"
        );
        echo json_encode($res);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    $dbConnected = $db->connect();
    if ($dbConnected) {
        $genres = $dbConnected->query("SELECT * FROM genre_table");
        $genres = $genres->fetch_all(MYSQLI_ASSOC);
        $data = array();
        foreach ($genres as $genre) {
            $data[] = array(
                "id" => $genre['id'],
                "name" => $genre['genre']
            );
        }
        $res = array(
            "statusCode" => 200,
            "status" => "success",
            "message" => "Genres fetched successfully!",
            "data" => $data
        );
        echo json_encode($res);
        exit();
    } else {
        $res = array(
            "statusCode" => 500,
            "status" => "error",
            "message" => "Internal Server Error"
        );
        echo json_encode($res);
        exit();
    }
}
?>