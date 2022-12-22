<?php
include("../common/header.php");
include("./post_articles.php");
?>

<?php
$dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
if ($dbSrv->dbConnect()) {
    $dbConnected = $dbSrv->dbConnect();
    $genreSelect = $dbSrv->select('genre_table', array('*'));
    $lastPostID = $dbSrv->select('article_table', ['id']); //Have to change the user number to variable
    $lastPostID = max($lastPostID->fetch_all(MYSQLI_ASSOC))['id'] + 1; //Find the last postID of user and sum +1 to generate fileName
    if ($genreSelect->num_rows > 0) {
        $genres = $genreSelect->fetch_all(MYSQLI_ASSOC);
    }
    $dbConnected->close();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = intval($_POST['title']);
    $contentText = $_POST['contentText'];
    writeInFile("../../data/contents/post_$lastPostID.txt", $contentText);
    $dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    if ($dbSrv->dbConnect()) {
        $dbConnected = $dbSrv->dbConnect();
        date_default_timezone_set('America/Vancouver');
        $date = date('Y-m-d H:i:s');
        // NOW IT'S FIXED TO USER ID 1000. AFTER LOGIN STORE USER INFO IN SESSION TO MAKE DYNAMIC...
        $insertCmd = "INSERT INTO article_table (user_id, content_path, genre_id_01, likes, stores, datetime) VALUES (1000,'post_$lastPostID.txt',$title,0,0,'$date')";
        if ($dbConnected->query($insertCmd) === TRUE) {
            echo "New record created successfully!";
        } else {
            print_r($dbConnected->error);
            echo "<br>";
            echo "Record was not added.";
        }
        $dbConnected->close();
    } else {
        echo "Not Connected to DataBase";
    }
}
?>

<main class="container-fluid">
    <div class="row justify-content-center align-items-center g-2">
        <div class="col-8">
            <div class='p-1 mb-4 bg-light rounded-3'>
                <div class='container-fluid py-2'>
                    <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                        <article class='row'>
                            <div class="mb-3">
                                <select class="form-select form-select-lg" name="title">
                                    <option selected disabled>Select the topic of your post!</option>
                                    <?php
                                    foreach ($genres as $genre) {
                                        echo "<option value='" . $genre['id'] . "'>" . $genre['genre'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </article>
                        <div class='row'>
                            <div class="mb-3">
                                <textarea class="form-control" name="contentText" rows="3"
                                    placeholder="Post your ideia with us!"></textarea>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-outline-dark">Publish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>


<?php include("../common/footer.php") ?>