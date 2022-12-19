<?php
  function generatePost($postInfoArray){
    $header = "Temporary header. Have to get the info from another table!";
    //             <h1 class='display-5 fw-bold'>".$postInfoArray['genre_id_01']."</h1>
    echo "
        <div class='p-5 mb-4 bg-light rounded-3'>
          <div class='container-fluid py-5'>
            <span>Post ID: ".$postInfoArray['id']."</span>
            <span>Posted by: ".$postInfoArray['user_id']."</span>
            <span>Date posted: ".$postInfoArray['datetime']."</span>
            <h1 class='display-5 fw-bold'>".$header."</h1>
            <p class='col-md-8 fs-4'>Temporary content text! Have to get text from this path: ".$postInfoArray['content_path']."</p>
            <span>Likes: ".$postInfoArray['likes']."</span>
            <button class='btn btn-primary btn-lg' type='button'>Can be an edit button</button>
          </div>
        </div>
    ";
  }


?>