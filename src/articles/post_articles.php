<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
function generatePost($postInfoArray, $commentsArray = null)
{
    include_once("../../config/config.php");

    $contentText = readThisFile("../../data/contents/" . $postInfoArray['content_path']);
    $date = new DateTimeImmutable($postInfoArray['datetime']);
    $date = $date->format('l jS \o\f F Y h:i A');
    echo "
        <div class='p-3 mb-4 bg-light rounded-3' id='post_" . $postInfoArray['id'] . "''>
        <form action='" . $_SERVER['PHP_SELF'] . "?e=1&id=" . $postInfoArray['id'] . "' method='post'>
            <div class='container-fluid py-5'>
                <div class='row justify-content-between align-items-center g-2'>
                    <div class='col'>
                        <span>Post ID: " . $postInfoArray['id'] . "</span>
                    </div>            
                    <div class='col text-end'>            
                        <span>Posted by: " . $postInfoArray['first_name'] . " " . $postInfoArray['last_name'] . "</span>
                    </div>
                </div>
                <article class='row'>             
                    <h1 class='display-5 fw-bold'>" . ucfirst($postInfoArray['genre']) . "</h1>
                    <p class='fs-5'>" . $contentText . "</p>
                </article> 
                <div class='row justify-content-between g-2'>
                    <div class='col'>
                        <span class='fs-4'><i class='fa-regular fa-thumbs-up'></i> " . $postInfoArray['likes'] . "</span>
                    </div>
                    <div class='col text-end'>
                        <button class='btn btn-outline-primary btn-lg' type='submit'>Edit</button>
                    </div>
                </div>
                <div class='row text-end mt-4'>
                    <span>Date posted: " . $date . "</span>
                </div>
            </form>
                <h3 class='mt-5'>Comments</h3>";
    foreach ($commentsArray as $comment) {
        if ($comment['article_id'] != $postInfoArray['id']) {
            continue;
        } else {
            generateComment($comment);
        }
    }
    echo "
            </div>
        </div>
    ";
}

function readThisFile($fileName)
{ //return back an associate array
    if (file_exists($fileName)) {
        $file = fopen($fileName, 'r');
        $dataArray = fread($file, filesize($fileName));
        fclose($file);
        return $dataArray;
    }
    return false;
}
function writeInFile($fileName, $newData)
{ //write in file new data
    $file = fopen($fileName, 'w');
    fwrite($file, $newData);
    fclose($file);
}
?>