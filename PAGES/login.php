<?php
if (isset($_POST['logBtn'])) {
    if (Tools::authorization($_POST['loginLog'], $_POST['passLog'])) {
        echo "<script>";
        echo "window.location = 'index.php?page=1'";
        echo "</script>";
    }
} else {
?>
<div class="registration">
    <form action="index.php?page=6" method="POST" class="registration__form" enctype="multipart/form-data">
        <h2 align='center'>Login</h2>
        <div class="form-group">
            <label for="loginLog">Login</label>
            <input type="text" id="loginLog" name="loginLog" class="form-control" placeholder="Enter login">
        </div>
        <div class="form-group">
            <label for="passLog">Password</label>
            <input type="password" id="passLog" name="passLog" class="form-control" placeholder="Enter password">
        </div>
        <input type="submit" class="btn container-fluid" name="logBtn" value="Login">
    </form>
</div>
<?php } ?>