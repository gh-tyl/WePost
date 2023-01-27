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
        $topics = $dbConnected->query("SELECT g.genre, COUNT(a.genre_id_01) AS qtd FROM article_table a INNER JOIN genre_table g ON g.id = a.genre_id_01 GROUP BY g.genre ORDER BY qtd DESC LIMIT 5;");
        $topics = $topics->fetch_all(MYSQLI_ASSOC);
        $db->close();
        if ($topics) {
            $response = array(
                "statusCode"=>200,
                "status"=>"success",
                "data"=> array("topics"=>$topics)
            );
            echo(json_encode($response));
            // echo "
            // {
            //     \"statusCode\": 200,
            //     \"status\": \"success\",
            //     \"data\": {
            //         \"topics\":" . json_encode($topics) . ",
            //     }
            // }";
            exit();
        } else {
            $response = array(
                "statusCode"=>204,
                "status"=>"No Content",
                "data"=> array("topics"=>$topics)
            );
            echo(json_encode($response));
            // echo "
            // {
            //     \"statusCode\": 204,
            //     \"status\": \"No Content\",
            //     \"data\": {
            //         \"articles\": []
            //     },
            // }";
            exit();
        }
    } else {
        $response = array(
            "statusCode"=>500,
            "status"=>"Internal Server Error",
            "data"=> array("topics"=>$topics)
        );
        echo(json_encode($response));
        // echo "
        // {
        //     \"statusCode\": 500,
        //     \"status\": \"Internal Server Error\",
        //     \"data\": {
        //         \"articles\": []
        //     },
        // }";
        exit();
    }
}
?>