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
// INPUTS: title, contentText
// OUTPUTS: message
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = intval($_POST['title']);
    $contentText = $_POST['contentText'];
    $lastPostID = $db->select('article_table', ['id']); //Have to change the user number to variable
    $lastPostID = max($lastPostID->fetch_all(MYSQLI_ASSOC))['id'] + 1; //Find the last postID of user and sum +1 to generate fileName
    writeInFile("../../data/contents/post_$lastPostID.txt", $contentText);
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    $connected = $db->connect();
    if ($connected) {
        date_default_timezone_set('America/Vancouver');
        $date = date('Y-m-d H:i:s');
        $logID = $_SESSION['logUser']['id'];
        $insertCmd = "INSERT INTO article_table (user_id, content_path, genre_id_01, likes, stores, datetime) VALUES ($logID,'post_$lastPostID.txt',$title,0,0,'$date')";
        if ($connected->query($insertCmd) === TRUE) {
            $created = 1;
            echo "
            {
                \"statusCode\": 200,
                \"status\": \"success\",
                \"message\": \"New record created successfully!\"
            }
            ";
        } else {
            echo "
            {
                \"statusCode\": 500,
                \"status\": \"error\",
                \"message\": \"Internal Server Error\"
            }";
        }
        $connected->close();
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