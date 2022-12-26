<?php
include("../common/header.php");
	if($_SESSION['logUser']['role']!=="Admin" || !isset($_SESSION['logUser'])){ //If user is not logged in, can't acess page.
		header("Location: " . $baseName);
		exit();
  	}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$selTopic = $_POST['selTopic'];
	$dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
	if ($dbSrv->dbConnect()) {
		$dbConnected = $dbSrv->dbConnect();
		switch ($selTopic) {
			case 'posts':
				# code...
				break;

			case 'users':
				$usersCount = $dbSrv->select('user_table', ['id'], "user_table.role='user'");
				$articleInfo = $dbSrv->select('article_table', ['id', 'user_id', 'likes', 'stores', 'datetime']);
				$likesSel = $dbSrv->select('article_table', ['id', 'user_id', 'likes']);
				$likesSearch = $dbConnected->query("SELECT a.id,a.likes,a.stores,a.datetime,u.first_name,u.last_name FROM article_table a INNER JOIN user_table u ON u.id = a.user_id");
				$likesSearch = $likesSearch->fetch_all(MYSQLI_ASSOC);
				$maxLikes = 0;
				$likesSel = $likesSel->fetch_all(MYSQLI_ASSOC);
				foreach ($likesSearch as $post) {
					if ($post['likes'] > $maxLikes) {
						$maxLikes = $post['likes'];
						$popPost = $post;
						$popPost['fullname'] = $post['first_name'] . " " . $post['last_name'];
					}
				}


				echo $dbConnected->error;
				if ($usersCount) {
					$usersCount = count($usersCount->fetch_all(MYSQLI_ASSOC));
					$articleInfo = $articleInfo->fetch_all(MYSQLI_ASSOC);
					$postsCount = count($articleInfo);
					$totalLikes = array_sum(array_column($articleInfo, 'likes'));
				}
				break;
			case 'comments':
		}
		$dbConnected->close();

	} else {
		echo "Could not connect to database!";
	}
}
?>


<style>
	body {
		color: white;
	}
</style>

<main class="container-fluid">
	<div class="row justify-content-center align-items-center g-2">
		<div class="col-4">
			<form method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div class="mb-3 col-6">
					<label for="" class="form-label">Select topic</label>
					<select class="form-select form-select-md" name="selTopic" id="">
						<option selected disabled>Select one</option>
						<option value="posts">Posts</option>
						<option value="users">Users</option>
						<option value="comments">Comments</option>
					</select>
					<button type="submit" class="btn btn-outline-light mt-4">Select</button>
				</div>
			</form>
		</div>
		<div class="col-8">
			<section class="row d-flex flex-wrap justify-content-around align-items-center g-2">
				<h3 class="text-center">
					<?php
                    if (isset($_POST['selTopic']))
	                    echo ucfirst($_POST['selTopic'] . " data");
                    ?>
				</h3>
				<div class="col">
					<p class="fs-1">
						<?php
                        if (isset($usersCount)) {
	                        echo $usersCount . " USERS";
                        }
                        ?>
					</p>
				</div>
				<div class="col">
					<p class="fs-1">
						<?php
                        if (isset($postsCount)) {
	                        echo $postsCount . " POSTS";
                        }
                        ?>
					</p>
				</div>
				<div class="col">
					<p class="fs-1">
						<?php
                        if (isset($totalLikes)) {
	                        echo $totalLikes . " LIKES IN ALL POSTS";
                        }
                        ?>
					</p>
				</div>
				<div class="col">
					<p class="fs-1">
						<?php
                        if (isset($popPost)) {
	                        echo "POST WITH MOST LIKES IS POST " . $popPost['id'] . " FROM " . $popPost['fullname'] . " WITH " . $popPost['likes'] . " LIKES";
                        }
                        ?>
					</p>
				</div>
			</section>
		</div>


	</div>

</main>
<?php include("../common/footer.php") ?>