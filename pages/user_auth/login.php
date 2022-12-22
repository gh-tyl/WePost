<?php
    include "../common/header.php";
?>

<div class="container-fluid">
    <div class="row justify-content-center align-items-center g-2">
        <div class="col-4">
            <br>
            <form method="post" action="">
                <div class="form-floating mb-3">
                    <!-- <input
                        type="text"
                        class="form-control" name="fname" placeholder="name">
                    <label for="formId1">First Name</label>
                    </div>
                    <div class="form-floating mb-3">
                    <input
                        type="text"
                        class="form-control" name="lname" placeholder="name">
                    <label for="formId1">Last Name</label>
                    </div> -->
                    <div class="form-floating mb-3">
                    <input
                        type="email"
                        class="form-control" name="email" placeholder="email">
                    <label for="formId1">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                    <input
                        type="password"
                        class="form-control" name="pass" placeholder="pass">
                    <label for="formId1">Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>

<?php
$db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
$db->dbConnect(); 

if($_SERVER["REQUEST_METHOD"]!="POST"){
    $userData =  $db->select('user_table',['*']);
   
    $userData = $userData->fetch_all(MYSQLI_ASSOC);
    print_r($userData);
    // $usertb = "SELECT * FROM user_table";
    // $email = "SELECT * FROM user_table where email = value form input";
    // $pass = "SELECT * FROM user_table where pass = value form input";
        
    // $role = "SELECT * FROM user_table where role";

    if($_POST['pass'] == $pass){
        if($role == "Admin"){
            header('Location:./login.php');
            
        } elseif($role == "User") {
            header('Location:./admin_pages/analytics_board.php');
        }
    }
}

    include "../common/footer.php"
?>