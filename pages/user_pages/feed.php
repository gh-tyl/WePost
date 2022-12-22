<?php include("../common/header.php") ?>

<?php
$dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
if ($dbSrv->dbConnect()) {
    $dbConnected = $dbSrv->dbConnect();
    $fieldArray = array('*');
    $joinUsers = $dbConnected->query("SELECT a.id,a.content_path,a.genre_id_01,a.genre_id_02,a.genre_id_03,a.likes,a.stores,a.datetime,u.first_name,u.last_name,u.email,g.genre FROM article_table a INNER JOIN user_table u ON u.id = a.user_id INNER JOIN genre_table g ON g.id = a.genre_id_01 ORDER BY `id` ASC");
    if ($joinUsers) {
        $posts = $joinUsers->fetch_all(MYSQLI_ASSOC);
    }
    $dbConnected->close();
} else {
    echo "Could not connect to database!";
}
?>

<main class="container-fluid">
    <div class="row justify-content-center align-items-center g-2">
        <div class="col-8">
            <?php
            if (!empty($posts)) {
                foreach ($posts as $post) {
                    generatePost($post);
                }
            }
            ?>
        </div>
    </div>
</main>
<?php include("../common/footer.php") ?>