<?php
include("../common/header.php");
include("./post_articles.php");
if(!isset($_SESSION['logUser'])){
    header("Location: " . $baseName . "pages/auth/login.php");
    exit();
}
if(isset($_GET['id'])){
    $pID = intval($_GET['id']);
    $dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    if ($dbConnected = $dbSrv->dbConnect()) {
        $result = $dbConnected->query("SELECT a.id,a.content_path,a.genre_id_01,a.genre_id_02,a.genre_id_03,a.likes,a.stores,a.datetime,u.first_name,u.last_name,u.email,g.genre FROM article_table a INNER JOIN user_table u ON u.id = a.user_id INNER JOIN genre_table g ON g.id = a.genre_id_01 WHERE a.id=$pID");
        if ($result) {
            $postInfo = $result->fetch_assoc();
            $contentText = readThisFile("../../data/contents/" . $postInfo['content_path']);
            $date = new DateTimeImmutable($postInfo['datetime']);
            $date = $date->format('l jS \o\f F Y h:i A');
            $fullname = $postInfo['first_name'] . " " . $postInfo['last_name'];
        }
        $dbSrv->closeDb();
    } else {
        echo "problem";
    }
}

if($_SERVER['REQUEST_METHOD']=="POST"){
    $newContent = $_POST['newContent'];
    $filename = "../../data/contents/".$postInfo['content_path'];
    writeInFile($filename, $newContent);
    $_SESSION['newContent'] = $newContent;
    $_SESSION['edited'] = 1;
}
?>
<main>
    
    <div class="row justify-content-center align-items-center g-2">
        <div class="alert alert-success alert-dismissible fade show col-10" role="alert" 
            style="display:<?php if(isset($_SESSION['edited'])){
                    echo "block";
                }else{
                    echo "none";
                } ?>;">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Post Edited!</strong> The content of post has been edited with success!
        </div>

        <div class="col-10">
            <div class='p-3 mb-4 bg-light rounded-3'>
            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                <div class='container-fluid py-5'>
                    <div class='row justify-content-between align-items-center g-2'>
                        <div class='col'>
                            <span>Post ID: <?php if(isset($postInfo)) echo $postInfo['id'] ?></span>
                        </div>            
                        <div class='col text-end'>            
                            <span>Posted by: <?php if(isset($postInfo)) echo $fullname ?></span>
                        </div>
                    </div>
                    <article class='row'>             
                        <h1 class='display-5 fw-bold'>
                            <?php if (isset($postInfo))
                                echo ucfirst($postInfo['genre']); ?>
                        </h1>

                        <div class="mb-3">
                          <textarea class="form-control resize-ta" name="newContent" height='fit-content' rows="30"><?php 
                            if(isset($postInfo) && !isset($_SESSION['newContent'])){
                                echo $contentText;
                            }else{
                                echo $_SESSION['newContent'];
                                unset($_SESSION['newContent']);
                            }?></textarea>
                        </div>
                        
                    </article> 
                    <div class='row justify-content-between g-2'>
                        <div class='col'>
                            <span class='fs-4'>
                                <i class='fa-regular fa-thumbs-up'></i>
                                <?php if(isset($postInfo)) echo $postInfo['likes'] ?>
                            </span>
                        </div>
                        <div class='col text-end'>
                            <button class='btn btn-outline-primary btn-lg' type='submit'>Save</button>
                        </div>
                    </div>
                    <div class='row text-end mt-4'>
                        <span>Date posted: <?php if (isset($postInfo))
                        echo $date; ?></span>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="row justify-content-center align-items-center g-2">
        <div class="col">
            
        </div>
    </div>
</main>







<?php
include("../common/footer.php");
?>

<script>
    // Dealing with Input width
    let widthMachine = document.querySelector(".width-machine");

    // Dealing with Textarea Height
    function calcHeight(value) {
    let numberOfLineBreaks = (value.match(/\n/g) || []).length;
    // min-height + lines x line-height + padding + border
    let newHeight = 20 + numberOfLineBreaks * 20 + 12 + 2;
    return newHeight;
    }

    let textarea = document.querySelector(".resize-ta");
    textarea.addEventListener("keyup", () => {
    textarea.style.height = calcHeight(textarea.value) + "px";
    });
</script>

<script>
  var alertList = document.querySelectorAll('.alert');
  alertList.forEach(function (alert) {
    new bootstrap.Alert(alert)
  })
</script>