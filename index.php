<?php
include_once("helpers/classes.php");
session_start();

if (isset($_POST['logoutBtn'])) {
    unset($_SESSION['login']);
    unset($_SESSION['admin']);
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Oxygen&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/BOOTSTRAP/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/SELECTS/cs-select.css">
    <link rel="stylesheet" href="CSS/SELECTS/cs-skin-border.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <header>
        <div class="row container-fluid">
            <div class="col-lg-5"></div>
            <div class="col-lg-4 col-12 d-flex justify-content-lg-end">
                <a href="mailto:markosbasilio17@gmail.com">markosbasilio17@gmail.com</a>
            </div>
            <div class="col-lg-3 col-12">
                <a href="tel:+380960288929">+38(096)-02-88-929</a>
            </div>
        </div>
        <div class="d-flex mx-3">
            <a href="#">
                <img class="img-svg-small mx-1" src="FILES/staticImages/vk.svg" alt="alt">
            </a>
            <a href="#">
                <img class="img-svg-small mx-1" src="FILES/staticImages/twitter.svg" alt="alt">
            </a>
            <a href="#">
                <img class="img-svg-small mx-1" src="FILES/staticImages/telegram.svg" alt="alt">
            </a>
            <a href="#">
                <img class="img-svg-small mx-1" src="FILES/staticImages/instagram.svg" alt="alt">
            </a>

        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark p-0 position-sticky px-5">
        <a class="navbar-brand" href="index.php?page=1">
            Exploit Market
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex justify-content-between" style="width: 100%;">
                <ul class="navbar-nav mr-auto">
                    <?php
                    include_once("pages/menu.php");
                    ?>
                </ul>
            </div>
            <div class="d-flex" style="font-size: 20px;">
                <div class="d-flex">
                    <?php
                    if (Tools::checkAuthorization()) {
                    ?>
                    <form action="index.php?page=1" method="POST" class=" mx-1 d-flex align-items-end"
                        style="height: 100%;">
                        <input class="m-0 login" type="button" value="<?php echo $_SESSION['login']; ?>">
                        <input type="submit" class="logoutSubmit" name="logoutBtn" value="LOGOUT">
                    </form>
                    <?php
                    } else {
                    ?>
                    <div class="d-flex align-items-center mr-3 mt-2">
                        <a class="<?php if ($page == 6) echo 'signActive' ?> signIn"
                            href="index.php?page=6">Sign&nbsp;In</a>
                        <a class="<?php if ($page == 5) echo 'signActive' ?> signUp"
                            href="index.php?page=5">Sign&nbsp;Up</a>
                    </div>
                    <?php
                    }
                    ?>

                    <a class="<?php if ($page == 2) echo 'navButtonActive' ?> navButton d-flex align-items-center mx-3"
                        href="index.php?page=2">
                        <img class="img-svg-avg" src="FILES/staticImages/cart.svg">
                        <div class="mx-1 d-flex align-items-end" style="height: 100%;">
                            <p class="m-0">CART</p>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </nav>

    <main>

        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page == 1) include_once("PAGES/catalog.php");
            if ($page == 2) include_once("PAGES/cart.php");
            if ($page == 3) include_once("PAGES/admin.php");
            if ($page == 4) include_once("PAGES/reports.php");
            if ($page == 5) include_once("PAGES/registration.php");
            if ($page == 6) include_once("PAGES/login.php");
        } else if (isset($_GET['good'])) {
            $goodId = $_GET['good'];
            include_once("PAGES/goodInfo.php");
        } else {
            include_once("PAGES/catalog.php");
        }
        ?>
    </main>

    <footer>
        <div class="d-flex mx-3">
            <a href="#">
                <img class="img-svg-avg mx-1" src="FILES/staticImages/vk.svg" alt="alt">
            </a>
            <a href="#">
                <img class="img-svg-avg mx-1" src="FILES/staticImages/twitter.svg" alt="alt">
            </a>
            <a href="#">
                <img class="img-svg-avg mx-1" src="FILES/staticImages/telegram.svg" alt="alt">
            </a>
            <a href="#">
                <img class="img-svg-avg mx-1" src="FILES/staticImages/instagram.svg" alt="alt">
            </a>
        </div>
        <p class="mt-2">MarkosBK Corporation &copy;</p>

    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="JS/BOOTSTRAP/bootstrap.min.js"></script>
    <script src="JS/script.js"></script>
    <script src="JS/scriptAjax.js"></script>
    <script src="JS/classie.js"></script>
    <script src="JS/selectFx.js"></script>
    <script src="JS/cookie.js"></script>
    <script>
    (function() {
        [].slice.call(document.querySelectorAll('select.cs-select')).forEach(function(el) {
            new SelectFx(el);
        });
    })();
    </script>
</body>

</html>