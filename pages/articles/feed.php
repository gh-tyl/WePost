<?php
include("../common/header.php");
include("./post_articles.php");
?>

<?php
if(isset($_GET['e']) && $_GET['e']==1){
    $pID = intval($_GET['id']);
    header("Location:" . $baseName . "pages/articles/edit_post.php?id=$pID");
    exit();
}
$dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
if ($dbConnected = $dbSrv->dbConnect()) {
    $joinUsers = $dbConnected->query("SELECT a.id,a.content_path,a.genre_id_01,a.genre_id_02,a.genre_id_03,a.likes,a.stores,a.datetime,u.first_name,u.last_name,u.email,g.genre FROM article_table a INNER JOIN user_table u ON u.id = a.user_id INNER JOIN genre_table g ON g.id = a.genre_id_01 ORDER BY `id` ASC");
    $commentsArray = $dbSrv->dbConnect()->query("SELECT `article_id`, `comment`, `datetime` FROM `comment_table`");
    if ($joinUsers) {
        $posts = $joinUsers->fetch_all(MYSQLI_ASSOC);
        $commentsArray = $commentsArray->fetch_all(MYSQLI_ASSOC);
    }
    $dbSrv->closeDb();
} else {
    echo "problem";
}
?>

<main class="container-fluid mt-2">
    <div class="row justify-content-center align-items-center g-2">
        <div class="col-6">
            <?php
            if (!empty($posts)) {
                foreach ($posts as $post) {
                    generatePost($post, $commentsArray);
                }
            }
            ?>
        </div>
    </div>
</main>
<?php include("../common/footer.php") ?>