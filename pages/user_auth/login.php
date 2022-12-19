<?php
    include "../common/header.php"
?>

<div class="container-fluid">
    <div class="row justify-content-center align-items-center g-2">
        <div class="col-4">
            <br>
            <form method="post" action="">
                <div class="form-floating mb-3">
                    <input
                        type="text"
                        class="form-control" name="fname" placeholder="name">
                    <label for="formId1">First Name</label>
                    </div>
                    <div class="form-floating mb-3">
                    <input
                        type="text"
                        class="form-control" name="lname" placeholder="name">
                    <label for="formId1">Last Name</label>
                    </div>
                    <div class="form-floating mb-3">
                    <input
                        type="email"
                        class="form-control" name="email" placeholder="name">
                    <label for="formId1">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                    <input
                        type="password"
                        class="form-control" name="pass" placeholder="name">
                    <label for="formId1">Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>

<?php
    include "../common/footer.php"
?>