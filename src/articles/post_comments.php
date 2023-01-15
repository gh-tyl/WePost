<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
function generateComment($comment)
{
  $date = new DateTimeImmutable($comment['datetime']);
  $date = $date->format('l jS \o\f F Y h:i A');
  // echo "
  //     <div class='card text-white bg-secondary'>
  //       <div class='card-body'>
  //         <p class='card-text'>" . $comment['comment'] . "</p>
  //         <p class='card-text'>Posted on: " . $date . "</p>
  //       </div>
  //     </div>
  //       <br>
  //   ";
}
?>