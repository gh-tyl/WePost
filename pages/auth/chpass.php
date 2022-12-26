<?php include "../common/header.php"; 
  if(!isset($_SESSION['logUser'])){ //If user is not logged in, can't acess page.
    header("Location: " . $baseName);
    exit();
  }
?>

<style>
  body{
    color: gray;
  }
</style>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $pass1 = $_POST['pass1'];
  $pass2 = $_POST['pass2'];
  if ($pass1 !== $pass2) { //Check if both passwords are not matching
    echo "Passwords doesn't match. Try again";
  }else{
    $dbSrv = new dbServices($mysql_host,$mysql_username,$mysql_password,$mysql_database);
    if ($dbcon = $dbSrv->dbConnect()) {
      $pass2 = password_hash($pass2, PASSWORD_DEFAULT); //Hash password
      $uid = $_SESSION['logUser']['id'];
      $result = $dbcon->query("UPDATE user_table SET password='$pass2' WHERE id=$uid;");
      print_r($result);
      if ($result) { //Command to update password in db
        echo "Password updated";
        header("Location: " . $baseName."pages/articles/feed.php");
        exit;
      } else {
        print_r(mysqli_error($dbcon)); //printing error if there's one
        echo "Password not updated";
      }
    }
  }
  $dbcon->close();
}
?>

<div class="row justify-content-center align-items-start g-2">
  <div class="col-6">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <h2 class="text-light text-center mb-3">Change Password</h2>
      <div class="form-floating mb-3">
        <input type="password" class="form-control" name="pass1" placeholder="sd">
        <label for="pass1">New Password</label>
      </div>
      <div class="form-floating mb-3">
        <input type="password" class="form-control" name="pass2" placeholder="sd">
        <label for="pass2">Confirm Password</label>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-outline-light">Submit</button>
      </div>
    </form>
  </div>

</div>

<?php include "../common/footer.php"; ?>