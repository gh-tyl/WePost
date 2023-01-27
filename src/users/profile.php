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
        $token = $_POST['token'];
        session_id($token);
        session_start();
        $userInfo = $_SESSION['logUser'];
        $uID = $userInfo['id'];
        // $uID = intval(1002);
        //Still have to change select, do group by probably. Its repeating bc of multiple articles
        $result = $dbConnect->query("SELECT u.id,u.first_name,u.last_name,u.email,u.gender,u.country,u.age,u.image_path FROM user_table u WHERE u.id=$uID");
        $uStats = $dbConnect->query("SELECT a.user_id,COUNT(a.id) AS postQty, SUM(a.likes) as rc_likes,SUM(a.stores) AS rc_saves FROM article_table a WHERE a.user_id=$uID GROUP BY a.user_id;");
        $followers = $dbConnect->query("SELECT f.user_id, COUNT(f.follow_user_id) AS followersQty FROM follow_table f WHERE f.user_id=$uID GROUP BY f.user_id;");
        $posts = $dbConnect->query("SELECT a.id AS postID, a.user_id, a.title, a.content_path, g.genre, a.datetime FROM article_table a INNER JOIN genre_table g ON g.id=a.genre_id_01 WHERE a.user_id=$uID;");
        $lastLog = $dbConnect->query("SELECT t.user_id, MIN(t.datetime) AS time FROM login_table t WHERE t.user_id=$uID;");
        if ($result && $uStats && $followers && $posts && $lastLog) {
            $userInfo = $result->fetch_assoc();
            $uStats = $uStats->fetch_assoc();
            $followers = $followers->fetch_assoc();
            $posts = $posts->fetch_all(MYSQLI_ASSOC);
            $lastLog = $lastLog->fetch_assoc();
            $lDate = new DateTimeImmutable($lastLog['time']);
            $lDate = $lDate->format('jS \o\f F Y');

            $data = [];
            $data['user'] = $userInfo;
            $data['stats'] = $uStats;
            $data['stats']['followers'] = $followers['followersQty'];
            $data['stats']['last_login'] = $lDate;
            $data['posts'] = $posts;
            $res = [];
            $res['statusCode'] = 200;
            $res['status'] = "Success";
            $res['message'] = "User profile fetched";
            $res['data'] = $data;
            $res = json_encode($res);
            echo $res;
            exit();
        } else {
            $data = [];
            $data['user'] = [];
            $data['stats'] = [];
            $data['stats']['followers'] = 0;
            $data['stats']['last_login'] = "";
            $data['posts'] = [];
            $res = [];
            $res['statusCode'] = 204;
            $res['status'] = "No Content";
            $res['message'] = "User profile not found";
            $res['data'] = $data;
            $res = json_encode($res);
            echo $res;
            exit();
        }
    }
    $db->close();
}
?>