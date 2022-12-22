<?php
function generateComment($comment)
{
  $date = new DateTimeImmutable($comment['datetime']);
  $date = $date->format('l jS \o\f F Y h:i A');
  echo "
      <div class='card text-white bg-secondary'>
        <div class='card-body'>
          <p class='card-text'>" . $comment['comment'] . "</p>
          <p class='card-text'>Posted on: " . $date . "</p>
        </div>
      </div>
        <br>
    ";
}
?>