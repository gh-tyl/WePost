<?php
    include "../common/header.php";
?>
<div class="container-fluid">
    <div class="row justify-content-center align-items-center g-2">
        <div class="col-4">
            <div class="text-center mb-2">
                <h2 class="text-light">
                    Login Page
                </h2>
            </div>
            <br>
            <form method="post" action="<?php $_SERVER['PHP_SELF'];?>">
                    <div class="form-floating mb-3">
                        <input
                            type="email"
                            class="form-control" name="email" placeholder="email" required>
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input
                            type="password"
                            class="form-control" name="pass" placeholder="pass" required>
                        <label for="pass">Password</label>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-light">Login</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    if($dbCon = $db->dbConnect()){
        $userInfo = $db->select('user_table',array('*'),"email='$email'"); //Get the user login info in db
        if($userInfo){
            $userInfo = $userInfo->fetch_assoc(); //transform sql query result in associative array
            if($userInfo['password']==$pass){ //Check form pass with password from db
                $_SESSION['logUser'] = $userInfo;
                // echo "Password not hashed yet";
                header("Location: ./chpass.php");
                exit();
            }else{
                $hashPass = password_verify($pass, $userInfo['password']); //verify password. If returns true means that password is correct
                if($hashPass){ //On correct password
                    $_SESSION['logUser'] = $userInfo;
                    // echo "Pass already hashed";
                    header("Location: ../articles/feed.php");
                    exit();
                }
            }
        }
        echo "Wrong email/password"; //Will run on password wrong or email that is not on db
    }else{
        echo "Not connected to database";
    }
}
?>

<?php include "../common/footer.php"; ?>