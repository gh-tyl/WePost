<?php
include("../common/header.php");
if (!isset($_SESSION['logUser'])) { //If user is not logged in, can't acess page.
	header("Location: ../auth/login.php");
	exit();
}
?>
<?php
// get the data from the database
$db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
if ($db->dbConnect()) {
	$dbConnected = $db->dbConnect();
	$usersCount = $db->select('user_table', ['id'], "user_table.role='user'");
	$articleInfo = $db->select('article_table', ['id', 'user_id', 'likes', 'stores', 'datetime']);
	$likesSel = $db->select('article_table', ['id', 'user_id', 'likes']);
	$likesSearch = $dbConnected->query("SELECT a.id,a.likes,a.stores,a.datetime,u.first_name,u.last_name FROM article_table a INNER JOIN user_table u ON u.id = a.user_id");
	$likesSearch = $likesSearch->fetch_all(MYSQLI_ASSOC);
	$likesSel = $likesSel->fetch_all(MYSQLI_ASSOC);
	$ranking_articles = [];
	foreach ($likesSel as $post) {
		$ranking_articles[$post['id']] = 0;
	}
	foreach ($likesSel as $post) {
		$ranking_articles[$post['id']] += $post['likes'];
	}
	// echo ("<pre>");
	// print_r($ranking_articles);
	// echo ("</pre>");
	arsort($ranking_articles);
	$ranking_articles = array_slice($ranking_articles, 0, 5, true);

	$ranking_users = [];
	foreach ($likesSel as $post) {
		$ranking_users[$post['user_id']] = 0;
	}
	foreach ($likesSel as $post) {
		$ranking_users[$post['user_id']] += $post['likes'];
	}
	// echo ("<pre>");
	// print_r($ranking_users);
	// echo ("</pre>");
	arsort($ranking_users);
	$ranking_users = array_slice($ranking_users, 0, 5, true);
} else {
	echo "Error connecting to database";
}
?>


<style>
	body {
		/* color: white; */
		color: gray;
	}
</style>

<main class="container-fluid">
	<div class="row justify-content-center align-items-center g-2">
		<form action="./analytics_board.php" method="post">
			<select name="Media" onchange="this.form.submit()">
				<option value="none" selected disable>Select</option>
				<option value="posts">Posts</option>
				<option value="users">Users</option>
			</select>
		</form>
		<!-- showw post ranking articles -->
		<?php if (isset($_POST['Media']) && $_POST['Media'] == 'posts') { ?>
		<div class="col-12">
			<h2>Top 5 posts</h2>
			<?php foreach ($ranking_articles as $post_id => $post) {
		        $post = $db->select('article_table', ['id', 'user_id', 'likes', 'stores', 'datetime'], "id = $post_id");
		        $post = $post->fetch_assoc();
		        $user = $db->select('user_table', ['id', 'first_name', 'last_name'], "id = $post[user_id]");
		        $user = $user->fetch_assoc();
		        $user['fullname'] = $user['first_name'] . " " . $user['last_name'];
		        // <h5 class='card-title text-center'>$post[title]</h5>
        		echo "
				<div class='card'>
					<div class='card-body'>
						<p class='card-text text-center'>$post[datetime]</p>
						<p class='card-text text-center'>$user[fullname]</p>
						<p class='card-text text-center'>$post[likes] likes</p>
						<p class='card-text text-center'>$post[stores] stores</p>
					</div>
				</div>
				"
            	?>
		</div>
		<?php } ?>
		<?php } ?>
		<!-- show ranking_users -->
		<?php if (isset($_POST['Media']) && $_POST['Media'] == 'users') { ?>
		<div class="col-12">
			<h2>Top 5 users</h2>
			<?php foreach ($ranking_users as $user_id => $user) {
		        $user = $db->select('user_table', ['id', 'first_name', 'last_name'], "id = $user_id");
		        $user = $user->fetch_assoc();
		        $user['fullname'] = $user['first_name'] . " " . $user['last_name'];
            ?>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title"><?php echo $user['fullname'] ?></h5>
					<p class="card-text"><?php echo $ranking_users[$user['id']] ?> likes</p>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php } else if (isset($_POST['Media']) && $_POST['Media'] == 'users') { ?>
		<div class="col-12">
			<h2>Top 5 users</h2>
			<?php foreach ($ranking_users as $user) {
		        echo ($user);
		        $user = $db->select('user_table', ['id', 'first_name', 'last_name'], "id = $user");
		        echo ($user);
		        $user = $user->fetch_assoc();
		        $user['fullname'] = $user['first_name'] . " " . $user['last_name'];
            ?>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title
						<?php if ($ranking_users[$user['id']] == 0) {
			        echo "text-danger";
		        } else {
			        echo "text-success";
		        } ?>
						"><?php echo $user['fullname'] ?></h5>
					<p class="card-text"><?php echo $ranking_users[$user['id']] ?> posts</p>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
</main>
<?php include("../common/footer.php") ?>