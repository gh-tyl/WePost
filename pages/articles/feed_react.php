<?php
include("../../config/config.php");
include("../../services/db.php");
?>

<?php
    header('Access-Control-Allow-Origin: http://localhost:3000');    

    $dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    if ($connected = $dbSrv->connect()) {
        $joinUsers = $connected->query("SELECT a.id,a.title,a.content_path,a.genre_id_01,g.genre,a.likes,a.stores,a.datetime,u.first_name,u.last_name FROM article_table a INNER JOIN user_table u ON u.id = a.user_id INNER JOIN genre_table g ON g.id = a.genre_id_01 ORDER BY `id` DESC");
    if ($joinUsers) {
        $posts = $joinUsers->fetch_all(MYSQLI_ASSOC);
        echo json_encode($posts);
    }
    } else {
        echo "DB connect problem";
    }
    $dbSrv->close();
?>
