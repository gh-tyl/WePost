<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
$dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
if ($dbSrv->connect()) {
    $connected = $dbSrv->connect();
    $genreSelect = $dbSrv->select('genre_table', array('*'));
    $lastPostID = $dbSrv->select('article_table', ['id']); //Have to change the user number to variable
    $lastPostID = max($lastPostID->fetch_all(MYSQLI_ASSOC))['id'] + 1; //Find the last postID of user and sum +1 to generate fileName
    if ($genreSelect->num_rows > 0) {
        $genres = $genreSelect->fetch_all(MYSQLI_ASSOC);
    }
    $connected->close();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = intval($_POST['title']);
    $contentText = $_POST['contentText'];
    writeInFile("../../data/contents/post_$lastPostID.txt", $contentText);
    $dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    if ($dbSrv->connect()) {
        $connected = $dbSrv->connect();
        date_default_timezone_set('America/Vancouver');
        $date = date('Y-m-d H:i:s');
        $logID = $_SESSION['logUser']['id'];
        $insertCmd = "INSERT INTO article_table (user_id, content_path, genre_id_01, likes, stores, datetime) VALUES ($logID,'post_$lastPostID.txt',$title,0,0,'$date')";
        if ($connected->query($insertCmd) === TRUE) {
            $created = 1;
            // echo "New record created successfully!";
        } else {
            print_r($connected->error);
            echo "<br>";
            echo "<h3 class='text-danger'Record was not added.</h3>";
        }
        $connected->close();
    } else {
        echo "<h3 class='text-danger'>Not Connected to DataBase</h3>";
    }
}
?>

<main class="container-fluid">
    <div class="row justify-content-center align-items-center g-2">
        <div class="col-8">
            <div class="alert alert-success alert-dismissible fade show col-10" role="alert" style="display:<?php if (isset($created)) {
                echo "block";
                unset($created);
            } else {
                echo "none";
            } ?>;">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Post Created!</strong> Your post was created with success!
            </div>

            <div class="text-center text-light mb-4">
                <h2>Create new post</h2>
            </div>
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

<script>
    var alertList = document.querySelectorAll('.alert');
    alertList.forEach(function (alert) {
        new bootstrap.Alert(alert)
    })
</script>