<?php
if (!isset($_SESSION['admin'])) {
    echo "<h1 align='center' style='color: orangered; text-shadow: 2px 2px 5px #000; margin-top: 3%'>Only ADMINS</h1>";
} else {
?>

<div class="admin row m-0">
    <div class="admin__section col-lg-6 col-12" id="adminCategories">
        <?php include_once("admin/categories.php") ?>
    </div>
    <div class="admin__section col-lg-6 col-12" id="adminGoods">
        <?php include_once("admin/goods.php") ?>
    </div>
</div>

<?php } ?>