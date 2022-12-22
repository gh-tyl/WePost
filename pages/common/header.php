<?php
include("../../config/config.php");
include("../../services/db.php");
?>

<!doctype html>
<html lang="en">

<head>
	<title>Title</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS v5.2.1 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<!-- FontAwesome link v6.2.1 -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
		integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<style>
	body {
		background-color: #082032;
	}
</style>

<body>
	<header>
		<nav class="navbar navbar-expand-sm navbar-dark px-2 mb-2" style="background-color: #2C394B;">
			<a class="navbar-brand" href="<?php echo $baseName . "/pages/auth/login.php" ?>">WePost</a>
			<div class="collapse navbar-collapse" id="collapsibleNavId">
				<ul class="navbar-nav me-auto mt-2 mt-lg-0">
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="<?php echo $baseName . "/pages/auth/login.php" ?>">Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo $baseName . "/pages/auth/register.php" ?>">Register</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo $baseName . "/pages/articles/feed.php" ?>"
							aria-current="page">Feed</a>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo $baseName . "/pages/articles/new_post.php" ?>">New Post</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo $baseName . "/pages/admin/analytics_board.php" ?>">Analytics
							Board</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo $baseName . "/pages/auth/logout.php" ?>">Logout</a>
					</li>
				</ul>
			</div>
		</nav>
	</header>