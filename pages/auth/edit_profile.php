<?php
include_once '../common/header.php';
if (!isset($_SESSION['logUser'])) { //If user is not logged in, can't acess page.
  header("Location: " . $baseName);
  exit();
}
?>
<style>
  body {
    color: cornflowerblue;
  }
</style>


<?php
$dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
if ($dbcon = $dbSrv->dbConnect()) {
  $uID = intval($_SESSION['logUser']['id']);
  $result = $dbcon->query("SELECT u.id,u.first_name,u.last_name,u.email,u.gender,u.country,u.age,u.image_path FROM user_table u WHERE u.id=$uID");
  if ($result) {
    $userInfo = $result->fetch_assoc();
    // print_r($userInfo);
  } else {
    echo "Errors in query </br>";
    print_r(mysqli_error($dbcon));
    exit();
  }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $age = $_POST['age'];
  $country = $_POST['country'];
  $pic = $_FILES['pic'];

  // Uploaded Image Check Logic
  if ($pic['size'] == 0) {
    $imgurl = null;
  } else {
    $targetDir = "../../data/images/profiles/";
    if ($pic['size'] < 1000000) {
      // jpg or png
      if ($pic['type'] == "image/jpeg" || $pic['type'] == "image/jpg" || $pic['type'] == "image/png") {
        if (getimagesize($pic['tmp_name']) !== false) {
          $targetDir = $targetDir . $uID . "_profile.jpg";
          if (move_uploaded_file($pic['tmp_name'], $targetDir)) {
            $imgurl = $targetDir;
          } else
            echo "Image is not uploaded";
        } else
          echo "Please upload JPG/JPEG image tyle file.";
      } else
        echo $pic['type'];
    } else
      echo "Image is big!!!!!";
  }

  $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
  if ($dbCon = $db->dbConnect()) {
    $updateCmd = "UPDATE user_table u SET first_name='" . $fname . "',last_name='" . $lname . "',email='" . $email . "',age=" . $age . ",country='" . $country . "',image_path='" . $uID . "_profile.jpg" . "' WHERE u.id=" . $uID . ";";
    // print_r($updateCmd);
    if ($uptRes = $dbCon->query($updateCmd)) {
      echo "Informations updated!";
      header("Location: ./profile.php");
      exit();
    } else {
      echo "An error occured when updating info... Changes were not saved.";
    }
  }
}

$dbcon->close();
?>

<main>
  <div class="container-fluid pb-3">
    <div class="row justify-content-center align-items-center g-2">
      <div class="col-6">
        <div class="rounded-top text-black" style="background-color: #f8f9fa;">
          <form class="p-3" method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="row justify-content-center align-items-center g-2">
              <div class="col-8">
                <p class="h4 mb-4 text-center">Edit Profile</p>

                <div class="text-center">
                  <img src="<?php echo $baseName . "data/images/profiles/" . $userInfo['image_path']; ?>"
                    alt="Profile pic" class="img-fluid img-thumbnail text-danger text-center mb-2"
                    style="width: 100px; height: 100px; border-radius:50%;">
                </div>

                <div class="mb-3">
                  <label for="" class="form-label">Upload profile picture</label>
                  <input type="file" class="form-control" name="pic" aria-describedby="fileHelpId">
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="fname" placeholder="f"
                    value="<?php echo $userInfo['first_name']; ?>">
                  <label for="fname">First Name</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="lname" placeholder="l"
                    value="<?php echo $userInfo['last_name']; ?>">
                  <label for="lname">Last Name</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="email" class="form-control" name="email" placeholder="e"
                    value="<?php echo $userInfo['email']; ?>">
                  <label for="email">Email</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="number" class="form-control" name="age" placeholder="e" min="1" max="100"
                    value="<?php echo $userInfo['age']; ?>">
                  <label for="age">Age</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="country" placeholder="e"
                    value="<?php echo $userInfo['country']; ?>">
                  <label for="country">Country</label>
                </div>

                <div class="text-center">
                  <button class="btn btn-outline-dark my-4 btn-block" type="submit">Save changes</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</main>

<?php include "../common/footer.php" ?>