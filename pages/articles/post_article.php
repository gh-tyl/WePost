<?php
include("../../config/config.php");
include("../../services/db.php");
include("./post_articles.php");

header("Access-Control-Allow-Origin: http://localhost:3000");
header('Access-Control-Allow-Methods:GET, POST');

$postID = $_POST['post_id'];
// $postID = 3;


$dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
if ($connected = $dbSrv->connect()) {
    $joinUsers = $connected->query("SELECT a.id,a.title,a.content_path,a.genre_id_01,a.genre_id_02,a.genre_id_03,a.likes,a.stores,a.datetime,u.first_name,u.last_name,u.email,g.genre FROM article_table a INNER JOIN user_table u ON u.id = a.user_id INNER JOIN genre_table g ON g.id = a.genre_id_01 ORDER BY `id` ASC ");
    $commentsArray = $dbSrv->connect()->query("SELECT `article_id`, `comment`, `datetime` FROM `comment_table`");
    if ($joinUsers) {
        $posts = $joinUsers->fetch_all(MYSQLI_ASSOC);
        $commentsArray = $commentsArray->fetch_all(MYSQLI_ASSOC);
        
        $resAr = ["post" => "", "comments" => ""];
        $comments = [];
        foreach ($posts as $key=>$post) {
            if($post['id']== $postID){
                $resAr["post"] = $post;
            }
        }
        foreach ($commentsArray as  $key=>$comment) {
            if($comment['article_id']== $postID){
                // $comments .= $comment;
                array_push($comments, $comment);
            }
        }
        $resAr["comments"] = $comments;
        echo json_encode($resAr);
    }
    $dbSrv->close();
} else {
    echo "problem";
}