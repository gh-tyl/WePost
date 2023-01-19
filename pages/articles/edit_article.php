<?php

include("../../services/db.php");
include("./post_articles.php");

header("Access-Control-Allow-Origin: http://localhost:3000");
header('Access-Control-Allow-Methods:GET, POST');
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $newContent = $_POST['newContent'];
    $conPath = $_POST['path'];
    $filename = "../../data/contents/" . $conPath;
    writeInFile($filename, $newContent);
    echo"all good";
    
}
?>

