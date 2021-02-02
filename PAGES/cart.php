<script src="../JS/cookie.js"></script>
<script>
<?php
    if (isset($_POST['checkout'])) {
        foreach ($_COOKIE as $key => $id) {
            $customer = explode('_', $key)[0];
            if (Tools::checkAuthorization()) {
                if ($customer == $_SESSION['login']) {
                    $good = Good::getById($id);
                    $good->buy();
    ?> deleteCookie('<?php echo $key ?>');
<?php
                }
            } else if ($customer == 'guest') {
                $good = Good::getById($id);
                $good->buy();
                ?> deleteCookie('<?php echo $key ?>');
<?php
            }
        }
        unset($_POST);
        echo "window.location = document.URL";
    }
    ?>
</script>

<div class="admin">
    <div class="container admin__section">
        <form method="POST" class="cart admin__section-form">
            <h2 align='center'>CART</h2>
            <div class="admin__overflow">
                <table class="table">
                    <thead>
                        <tr class='row'>
                            <th class="col-1">#</th>
                            <th class="col-6">GOOD</th>
                            <th class="col-2">PRICE</th>
                            <th class="col-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;

                        foreach ($_COOKIE as $key => $id) {
                            if (isset($_SESSION['login'])) {
                                $customer = explode('_', $key)[0];
                                if ($customer == $_SESSION['login']) {
                                    $i++;
                                    $good = Good::getById($id);

                        ?>
                        <tr class='row' id="<?php echo $i ?>">
                            <td class="col-1"><?php echo $i ?></td>
                            <td class="col-6"><?php echo $good->good ?></td>
                            <td class="col-2"><?php echo $good->priceSale ?></td>
                            <td class="col-3">
                                <div class='btn btn-dark'
                                    onclick='deleteFromCart("<?php echo $key ?>",<?php echo strval($i) ?> )'>
                                    Delete
                                </div>
                            </td>
                        </tr>
                        <?php
                                }
                            } else {
                                if (explode('_', $key)[0] == 'guest') {
                                    $i++;
                                    $good = Good::getById($id);
                                ?>
                        <tr class='row' id="<?php echo $i ?>">
                            <td class="col-1"><?php echo $i ?></td>
                            <td class="col-6"><?php echo $good->good ?></td>
                            <td class="col-2"><?php echo $good->priceSale ?>$</td>
                            <td class="col-3">
                                <div class='btn btn-dark'
                                    onclick='deleteFromCart("<?php echo $key ?>",<?php echo strval($i) ?>)'>
                                    Delete
                                </div>
                            </td>
                        </tr>
                        <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex pt-3 justify-content-end">
                <input type="submit" class="btn" name="checkout" value="Checkout" id="checkout" style="width: 200px">
            </div>
        </form>
    </div>
</div>