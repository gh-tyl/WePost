<?php include("./pages/common/header.php") ?>

<?php
  $dbSrv = new dbServices($mysql_host,$mysql_username,$mysql_password,$mysql_database);
  if($dbSrv->dbConnect()){
    $fieldArray = array('*');
    $searchPost = $dbSrv->select('article_table', $fieldArray);
    // $joinUsers = $dbSrv->dbConnect()->query("SELECT user_table.first_name, user_table.last_name FROM user_table INNER JOIN article_table ON user_table.id = article_table.user_id;");
    $joinUsers = $dbSrv->dbConnect()->query("SELECT * FROM user_table INNER JOIN article_table ON user_table.id = article_table.user_id INNER JOIN genre_table ON genre_table.id = article_table.genre_id_01;");
  if ($joinUsers) {
    $posts = $joinUsers->fetch_all(MYSQLI_ASSOC);
    // print_r($posts[0]);
    // echo "<hr>";
    // print_r($genres);
  }
    $dbSrv->closeDb();
  }else{
    echo "problem";
  }
?>

<main class="container-fluid mt-2">
  <div class="row justify-content-center align-items-center g-2">
    <div class="col-6">
      <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
          <h1 class="display-5 fw-bold">Custom jumbotron</h1>
          <p class="col-md-8 fs-4">Using a series of utilities, you can create this jumbotron, just like the one in previous versions of Bootstrap. Check out the examples below for how you can remix and restyle it to your liking.</p>
          <button class="btn btn-primary btn-lg" type="button">Example button</button>
        </div>
      </div>

      <?php
        if(!empty($posts)){
          foreach($posts as $post){
            generatePost($post);
          }
        }
      ?>
    </div>
  </div>


</main>
<?php include("./pages/common/footer.php") ?>