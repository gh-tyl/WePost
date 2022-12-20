<?php include '../common/header.php' ?>
<?php include '../../services/db.php' ?>
<main>

<div class="row justify-content-center align-items-center g-2">
    <div class="col-5">
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: <?php 
            if(isset($_GET['msg'])) echo "block";
            else echo "none";
            ?> ;">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php if($_GET['msg']=="ok"){
                    echo "<strong>Success</strong> Student Added";        
                }elseif($_GET['msg']=="passlong"){
                    echo "<strong>Warning</strong> Password should be longer than 8 characters!";
                }elseif($_GET['msg']=="null"){
                    echo "<strong>Warning</strong> Please input values!";
                }
                ?>
        </div>
        
        <script>
          var alertList = document.querySelectorAll('.alert');
          alertList.forEach(function (alert) {
            new bootstrap.Alert(alert)
          })
        </script>
        <h3>WEPOST User Registration</h3><br/>
        <form method="POST" enctype="multipart/form-data" action="<?php echo $baseName.'pages/user_auth/reg.php'; ?>">
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control" name="fname" placeholder="xc" required>
              <label for="formId1">First Name</label>
            </div>
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control" name="lname" placeholder="xc" required>
              <label for="formId1">Last Name</label>
            </div>
            <div class="form-floating mb-3">
              <input
                type="email"
                class="form-control" name="email" placeholder="xc" required>
              <label for="formId1">Email</label>
            </div>
            <div class="form-floating mb-3">
              <input
                type="password"
                class="form-control" name="pass" placeholder="xc" required>
              <label for="formId1">Password</label>
            </div>
            <div class="mb-3">
              <select class="form-select form-select-lg" name="gender">
                <option selected disabled>Select the gender</option>  
                <option value="female">Female</option>
                <option value="male">Male</option>
                <option value="ohter">Other</option>
              </select>
            </div>
            <div class="mb-3">
              <select class="form-select form-select-lg" name="age">
                <option selected disabled>Select the age</option>
                <?php for($cnt=15;$cnt<=80;$cnt++){
                    echo "<option value='$cnt'>$cnt years of age</option>";
                } ?>
              </select>
            </div>
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control" name="country" placeholder="xc">
              <label for="formId1">Country</label>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Select the image</label>
                <input type="file" class="form-control" name="image" placeholder="Select your image" aria-describedby="fileHelpId">
            </div>
            <div class="mb-3">
              <select class="form-select form-select-lg" name="role">
                <option value="User" selected>User</option>
                <option value="Admin">Admin</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
    </form>
    </div>
</div>

</main>
<?php include '../common/footer.php' ?>