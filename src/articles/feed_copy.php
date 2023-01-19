<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    $dbConnected = $db->connect();
    if ($dbConnected) {
        $articles = $dbConnected->query("SELECT a.id,a.title,a.content_path,a.genre_id_01,a.genre_id_02,a.genre_id_03,a.likes,a.stores,a.datetime,u.first_name,u.last_name,u.email,g.genre FROM article_table a INNER JOIN user_table u ON u.id = a.user_id INNER JOIN genre_table g ON g.id = a.genre_id_01 ORDER BY `id` ASC");
        $articles = $articles->fetch_all(MYSQLI_ASSOC);
        $db->close();
        if ($articles) {
            $response = array(
                "statusCode"=>200,
                "status"=>"success",
                "data"=> $article
            );
            echo(json_encode($response));
            // echo "
            // {
            //     \"statusCode\": 200,
            //     \"status\": \"success\",
            //     \"data\": {
            //         \"articles\":" . json_encode($articles) . ",
            //     }
            // }";
            exit();
        } else {
            echo "
            {
                \"statusCode\": 204,
                \"status\": \"No Content\",
                \"data\": {
                    \"articles\": []
                },
            }";
            exit();
        }
    } else {
        echo "
        {
            \"statusCode\": 500,
            \"status\": \"Internal Server Error\",
            \"data\": {
                \"articles\": []
            },
        }";
        exit();
    }
}
?>