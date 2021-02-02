<?php
if ($_POST['regBtn']) {
    if (Tools::registration($_POST['loginReg'], $_POST['passReg'], $_POST['emailReg'], $_FILES)) {
        echo "<script>";
        echo "window.location = document.URL";
        echo "</script>";
        echo "<h1 align='center' style='color: #eee'>Customer added!</h1>";
    }
    unset($_POST['regBtn']);
} else {
?>
<div class="registration">
    <form action="index.php?page=5" method="POST" class="registration__form" enctype="multipart/form-data">
        <h2 align='center'>Registration</h2>
        <div class="form-group">
            <label for="loginReg">Login</label>
            <div id="loginError" class="registration__error"></div>
            <input type="text" id="loginReg" name="loginReg" class="form-control" placeholder="Enter login">
        </div>
        <div class="form-group">
            <label for="passReg">Password</label>
            <div id="passError" class="registration__error"></div>
            <input type="password" id="passReg" name="passReg" class="form-control" placeholder="Enter password">
        </div>
        <div class="form-group">
            <label for="passConfReg">Confirm password</label>
            <div id="passConfError" class="registration__error"></div>
            <input type="password" id="passConfReg" name="passConfReg" class="form-control"
                placeholder="Enter password again">
        </div>
        <div class="form-group">
            <label for="emailReg">Email</label>
            <div id="emailError" class="registration__error"></div>
            <input type="email" id="emailReg" name="emailReg" class="form-control" placeholder="Enter your email">
        </div>
        <div class="input__wrapper form-group">
            <input type="file" id="input__file" name="input__file[]" class="input input__file" accept="image/*">
            <label for="input__file" class="btn input__file-button m-0">
                <span class="input__file-button-text">Выберите фото</span>
            </label>
        </div>

        <input type="submit" class="btn container-fluid" name="regBtn" value="Register">
    </form>
</div>
<?php } ?>