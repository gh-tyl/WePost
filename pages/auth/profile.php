<?php
include_once '../common/header.php';
	if(!isset($_SESSION['logUser'])){ //If user is not logged in, can't acess page.
		header("Location: " . $baseName);
		exit();
  	}
?>
<style>
  body{
    color: red;
  }
</style>


<?php 
$dbSrv = new dbServices($mysql_host,$mysql_username,$mysql_password,$mysql_database);
if ($dbcon = $dbSrv->dbConnect()) {
  $uID = intval($_SESSION['logUser']['id']);
  //Still have to change select, do group by probably. Its repeating bc of multiple articles
  $result = $dbcon->query("SELECT u.id,u.first_name,u.last_name,u.email,u.gender,u.country,u.age,u.image_path FROM user_table u WHERE u.id=$uID");
  $uStats = $dbcon->query("SELECT a.user_id,COUNT(a.id) AS postQty, SUM(a.likes) as rc_likes,SUM(a.stores) AS rc_saves FROM article_table a WHERE a.user_id=$uID GROUP BY a.user_id;");
  $followers = $dbcon->query("SELECT f.user_id, COUNT(f.follow_user_id) AS followersQty FROM follow_table f WHERE f.user_id=$uID GROUP BY f.user_id;");
  $posts = $dbcon->query("SELECT a.id AS postID, a.user_id, a.content_path, g.genre, a.datetime FROM article_table a INNER JOIN genre_table g ON g.id=a.genre_id_01 WHERE a.user_id=$uID;");
  $lastLog = $dbcon->query("SELECT t.user_id, MIN(t.datetime) AS time FROM login_table t WHERE t.user_id=$uID;");
  if ($result && $uStats && $followers && $posts && $lastLog) {
    $userInfo = $result->fetch_assoc();
    $uStats = $uStats->fetch_assoc();
    $followers = $followers->fetch_assoc();
    $posts = $posts->fetch_all(MYSQLI_ASSOC);
    $lastLog = $lastLog->fetch_assoc();
    $lDate = new DateTimeImmutable($lastLog['time']);
    $lDate = $lDate->format('jS \o\f F Y');
    // print_r($lastLog);
  }else{
    echo "Errors in query </br>";
    print_r(mysqli_error($dbcon));
    exit();
  }
}
$dbcon->close();
?>

<section class="h-100 gradient-custom-2">
  <div class="container py-2 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-lg-9 col-xl-7">
        <div class="card">
          <div class="rounded-top text-white d-flex flex-row align-items-center" style="background-color: #000; height:200px;">
            <div class="ms-4 mt-1 d-flex flex-column align-items-center" style="width: 150px;">
              <img src="<?php echo $baseName."data/images/profiles/".$userInfo['image_path'] ?>"
                alt="Profile pic" class="img-fluid img-thumbnail text-danger text-center mb-2"
                style="width: 100px; z-index: 1; height: 100px; border-radius:50%;">
              <a href="<?php echo "./edit_profile.php" ?>" class="btn btn-outline-light" data-mdb-ripple-color="dark"
                style="z-index: 1;">
                Edit profile
              </a>
            </div>
            <div class="ms-3" style="margin-top: 0px;">
              <h5>
                <?php echo $userInfo['first_name']." ".$userInfo['last_name'] ?>
              </h5>
              <p>
                <?php echo $userInfo['country'] ?>
              </p>
              <p>
                <?php if($userInfo['age']) echo $userInfo['age'] . " years"; ?>
              </p>
            </div>
          </div>
          <div class="p-4 text-black" style="background-color: #f8f9fa;">
            <div class="d-flex justify-content-end text-center py-1">
              <div class="px-2">
                <p class="mb-1 h5"><?php echo $uStats['postQty']; ?></p>
                <p class="small text-muted mb-0">Posts published</p>
              </div>
              <div class="px-2">
                <p class="mb-1 h5"><?php echo $followers['followersQty'] ?></p>
                <p class="small text-muted mb-0">Followers</p>
              </div>
              <div class="px-2">
                <p class="mb-1 h5"><?php echo $uStats['rc_likes']; ?></p>
                <p class="small text-muted mb-0">Received Likes</p>
              </div>
              <div class="px-2">
                <p class="mb-1 h5"><?php echo $uStats['rc_saves']; ?></p>
                <p class="small text-muted mb-0">Received posts saves</p>
              </div>
            </div>
          </div>
          <div class="card-body p-4 text-black">
            <div class="mb-5">
              <p class="lead fw-normal mb-1">About</p>
              <div class="p-4" style="background-color: #f8f9fa;">
                <p class="font-italic mb-1">
                  <?php if($lastLog['time']) echo "User since ".$lDate; ?>
                </p>
                <p class="font-italic mb-1">From 
                  <?php echo $userInfo['country'] ?>
                </p>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
              <p class="lead fw-normal mb-0">Recent posts</p>
            </div>
            <div class="d-flex flex-wrap g-2">
              <?php 
                if(isset($posts)){
                  foreach($posts as $p){
                    echo "
                      <div class='p-2' >
                        <a href='../articles/feed.php#post_".$p['postID']."' class='link-dark'>Post ID: ".$p['postID']." - ".$p['genre']."</a>
                      </div>
                    ";
                  }
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include "../common/footer.php" ?>