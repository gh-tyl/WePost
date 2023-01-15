<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
// INPUT: token
// OUTPUT: statusCode, status, message, data
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    $dbConnect = $db->connect();
    if ($dbConnect) {
        $userInfo = $_SESSION[$_POST['token']];
        $uID = $userInfo['id'];
        // $uID = intval(1000);
        //Still have to change select, do group by probably. Its repeating bc of multiple articles
        $result = $dbConnect->query("SELECT u.id,u.first_name,u.last_name,u.email,u.gender,u.country,u.age,u.image_path FROM user_table u WHERE u.id=$uID");
        $uStats = $dbConnect->query("SELECT a.user_id,COUNT(a.id) AS postQty, SUM(a.likes) as rc_likes,SUM(a.stores) AS rc_saves FROM article_table a WHERE a.user_id=$uID GROUP BY a.user_id;");
        $followers = $dbConnect->query("SELECT f.user_id, COUNT(f.follow_user_id) AS followersQty FROM follow_table f WHERE f.user_id=$uID GROUP BY f.user_id;");
        $posts = $dbConnect->query("SELECT a.id AS postID, a.user_id, a.content_path, g.genre, a.datetime FROM article_table a INNER JOIN genre_table g ON g.id=a.genre_id_01 WHERE a.user_id=$uID;");
        $lastLog = $dbConnect->query("SELECT t.user_id, MIN(t.datetime) AS time FROM login_table t WHERE t.user_id=$uID;");
        if ($result && $uStats && $followers && $posts && $lastLog) {
            $userInfo = $result->fetch_assoc();
            $uStats = $uStats->fetch_assoc();
            $followers = $followers->fetch_assoc();
            $posts = $posts->fetch_all(MYSQLI_ASSOC);
            $lastLog = $lastLog->fetch_assoc();
            $lDate = new DateTimeImmutable($lastLog['time']);
            $lDate = $lDate->format('jS \o\f F Y');
            // echo inside $userInfo and $uStats to see what they contain
            // foreach ($userInfo as $key => $value) {
            //   echo "$key: $value </br>";
            // }
            // foreach ($uStats as $key => $value) {
            //   echo "$key: $value </br>";
            // }
            echo "
            {
                \"statusCode\": 200,
                \"status\": \"success\",
                \"message\": \"Profile data\",
                \"data\": {
                    \"user\": 
                    {
                        \"id\": $userInfo[id],
                        \"first_name\": \"$userInfo[first_name]\",
                        \"last_name\": \"$userInfo[last_name]\",
                        \"email\": \"$userInfo[email]\",
                        \"gender\": \"$userInfo[gender]\",
                        \"country\": \"$userInfo[country]\",
                        \"image_path\": \"$userInfo[image_path]\",
                    },
                    \"stats\": 
                    {
                        \"postQty\": $uStats[postQty],
                        \"postQty\": $uStats[postQty],
                        \"followers\": $followers[followersQty],
                        \"likes\": $uStats[rc_likes],
                        \"saves\": $uStats[rc_saves],
                        \"last_login\": \"$lDate\"
                    }
                }
            }";
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