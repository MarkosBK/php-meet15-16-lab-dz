<?php
$good = Good::getById($_GET['good']);
$img = Image::getImageByGoodId($good->id);
$category = Category::getById($good->categoryId);
?>

<div class="d-flex align-items-center justify-content-center catalog" style="height: 100%;">
    <div class='catalog__item' style="height: 70vh; width: 60%">
        <div class="catalog__item-image divImage" style="background-image: url(<?php echo $img->imagepath ?>); flex: 6">
            <div class="divBack">
                <div class="catalog__item-buttons">
                    <a onclick="moveToCart(<?php echo $good->id ?>, this)" class="itemLink mt-2">BUY</a>
                </div>
            </div>
        </div>
        <div class="catalog__item-info flex-row row m-0" style="flex:4; max-height: 40%">
            <div class="d-flex flex-column p-4 col-lg-7 col-12" style="color: #eee; max-height:100%">
                <div class="d-flex">
                    <b>Product Name:</b>
                    <p class="ml-2"><?php echo $good->good ?></p>
                </div>
                <div class="d-flex">
                    <b>Category:</b>
                    <p class="ml-2"><?php echo $category->category ?></p>
                </div>
                <div class="d-flex">
                    <b>Price:</b>
                    <p class="ml-2"><?php echo $good->priceSale ?></p>
                </div>
                <div class="d-flex">
                    <b>Rate:</b>
                    <p class="ml-2"><?php echo $good->rate ?></p>
                </div>
            </div>
            <div class="info col-lg-5 col-12" style="max-height: 100%;">
                <h3 align='center'>INFO</h3>
                <?php echo $good->info ?>
            </div>
            <!-- тут под мобилку уже не делал :) -->
        </div>
    </div>
</div>

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