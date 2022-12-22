<?php
function generatePost($postInfoArray, $commentsArray)
{
    // $header = "Temporary header. Have to get the info from another table!";
    //             <h1 class='display-5 fw-bold'>".$postInfoArray['genre_id_01']."</h1>
    $date = new DateTimeImmutable($postInfoArray['datetime']);
    $date = $date->format('l jS \o\f F Y h:i A');
    echo "
        <div class='p-3 mb-4 bg-light rounded-3'>
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
                    <span class='fs-4 text-end'><i class='fa-regular fa-thumbs-up'></i> " . $postInfoArray['likes'] . "</span>
                </article> 
                <div class='row'>
                    <div class='col text-center'>
                        <button class='btn btn-primary btn-lg' type='button'>Can be an edit button</button>
                    </div>
                </div>
                <div class='row text-end mt-4'>
                    <span>Date posted: " . $date . "</span>
                </div>
                <h3>Comments</h3>";
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