<div class="d-flex justify-content-center">
    <select class="cs-select cs-skin-border" id="CatalogSelect" onchange="getGoodsByCategory(this)">
        <option value="" disabled selected>Categories</option>
        <?php
        $categories = Category::getAll();
        foreach ($categories as  $category) {
            echo "<option value='" . $category->id . "'>" . $category->category . "</option>";
        }
        ?>
    </select>
</div>

<div class="catalog row m-0" id="catalog">
    <?php
    $goods = Good::getAll();
    foreach ($goods as $good) {
        $img = Image::getImageByGoodId($good->id);
        $category = Category::getById($good->categoryId);
    ?>
    <div class="p-3 col-lg-4 col-md-6 col-sm-6 col-12 p-0">
        <div class='catalog__item'>
            <div class="catalog__item-title">
                <div class="d-flex align-items-center" style="flex: 1">
                    <b><?php echo $good->good ?></b>
                </div>
                <div class="d-flex align-items-center catalog__item-rate" style="flex: 0 1 30px">
                    <b class=""><?php echo $good->rate ?></b>
                </div>
            </div>
            <div class="catalog__item-image divImage" style="background-image: url(<?php echo $img->imagepath ?>);">
                <div class="divBack">
                    <div class="catalog__item-buttons">
                        <a href="../index.php?good=<?php echo $good->id ?>" class="itemLink mb-2">MORE</a>
                        <a onclick="moveToCart(<?php echo $good->id ?>, this)" class="itemLink mt-2">BUY</a>
                    </div>
                </div>
            </div>
            <div class="catalog__item-info">
                <div class="categoryAndPrice">
                    <div style="flex: 1">
                        <b class="m-0"><?php echo $category->category ?></b>
                    </div>
                    <div style="flex: 0 1 40px; color: #eee">
                        <b class="m-0"><?php echo $good->priceSale ?>$</b>
                    </div>
                </div>
                <div class="info">
                    <?php echo $good->info ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<script src="JS/cookie.js"></script>

<!-- move good to cart -->
<script>
function moveToCart(goodId, e) {
    <?php
        if (Tools::checkAuthorization()) {

        ?>
    setCookie(`<?php echo $_SESSION['login'] ?>_${goodId}`, goodId, 365);
    <?php } else {
        ?>
    setCookie(`guest_${goodId}`, goodId, 1);
    <?php
        }
        ?>
    e.style = 'font-size:0px; transition: 0.15s';
    setTimeout(() => {
        e.textContent = 'BUYED!'
        e.style = 'transition: 0.15s';
    }, 100);
}
</script>