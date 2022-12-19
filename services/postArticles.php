<?php
  function generatePost($postInfoArray){
    $header = "Temporary header. Have to get the info from another table!";
    //             <h1 class='display-5 fw-bold'>".$postInfoArray['genre_id_01']."</h1>
    $date = new DateTimeImmutable($postInfoArray['datetime']);
    $date = $date->format('l jS \o\f F Y h:i A');
    echo "
        <div class='p-5 mb-4 bg-light rounded-3'>
          <div class='container-fluid py-5'>
            <div class='row justify-content-between align-items-center g-2'>
              <div class='col'>
                <span>Post ID: ".$postInfoArray['id']."</span>
              </div>            
              <div class='col'>            
                <span>Posted by: ".$postInfoArray['first_name']." ".$postInfoArray['last_name']."</span>
              </div>
             </div>
             <article class='row'>             
              <h1 class='display-5 fw-bold'>".ucfirst($postInfoArray['genre'])."</h1>
              <p class='col-md-8 fs-4'>Temporary content text! Have to get text from this path: ".$postInfoArray['content_path']."</p>
              <span><i class='fa-regular fa-thumbs-up'></i> ".$postInfoArray['likes']."</span>
              </article> 
              <div class='row'>
                <div class='col text-center'>
                  <button class='btn btn-primary btn-lg' type='button'>Can be an edit button</button>
                </div>
              </div>
              <div class='row'>
                <span>Date posted: ".$date."</span>
              </div>
          </div>
        </div>
    ";
  }
?>