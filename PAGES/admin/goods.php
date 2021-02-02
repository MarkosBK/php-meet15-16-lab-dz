<?php
if (isset($_POST['addGood'])) {
    $newGood = new Good($_POST['good'], intval($_POST['category']), doubleval($_POST['priceIn']), doubleval($_POST['priceSale']), $_POST['info']);
    if ($newGood->push_to_db($_FILES['input__file'])) {
        echo "<script>";
        echo "window.location = document.URL";
        echo "</script>";
    } else echo "<h3 align='center' style='color: red'>При добавлении возникла ошибка!</h3>";
} else if (isset($_POST['deleteGood'])) {
    if (Good::delete($_POST['goodCheckboxes'])) {
        echo "<script>";
        echo "window.location = document.URL";
        echo "</script>";
    } else echo "<h3 align='center' style='color: red'>При удалении возникла ошибка!</h3>";
} else {
?>

<form action="index.php?page=3" method="POST" class="admin__section-form" enctype="multipart/form-data">
    <h2 align='center' class="admin__title">GOODS</h2>
    <div class="admin__overflow">
        <table class="table">
            <thead>
                <tr class='row'>
                    <th class="col-1">#</th>
                    <th class="col-3">GOOD</th>
                    <th class="col-3">CATEGORY</th>
                    <th class="col-2">IN/SALE</th>
                    <th class="col-2">RATE</th>
                    <th class="col-1"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $goods = Good::getAll();
                    for ($i = 0; $i < count($goods); $i++) {
                        echo "<tr class='row'><td class='col-1'>" . ($i + 1) . ".</td>";
                        echo "<td class='col-3'>" . $goods[$i]->good . "</td>";
                        echo "<td class='col-3'>" . Category::getById($goods[$i]->categoryId)->category . "</td>";
                        echo "<td class='col-2'>" . $goods[$i]->priceIn . "/" . $goods[$i]->priceSale . "</td>";
                        echo "<td class='col-2'>" . $goods[$i]->rate . "</td>";
                        echo "<td class='col-1'>";
                        echo "<input type='checkbox' value='" . $goods[$i]->id . "' class='checkbox checkboxGood' id='" . $i . "good' name='goodCheckboxes[]' />";
                        echo "<label for='" . $i . "good'></label>";
                        echo "</td>";
                    }
                    ?>
            </tbody>
        </table>
    </div>
    <div class="admin__panel row">
        <div class="col-8">
            <div class="d-flex flex-column container-fluid px-0 mt-2">
                <div class="container-fluid d-flex px-0">
                    <div class="mr-1" style="width: 50%;">
                        <input type="text" class="form-control text-center" placeholder="Good" name="good">
                    </div>
                    <div class="ml-1" style="width: 50%;">
                        <select id="selectCategory" class="form-control text-center" name="category">
                            <option disabled selected>Category</option>
                            <?php
                                $categories = Category::getAll();
                                for ($i = 0; $i < count($categories); $i++) {
                                    echo "<option value='" . $categories[$i]->id . "'>" . $categories[$i]->category . "</option>";
                                }
                                ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column container-fluid px-0 mt-2">
                <div class="container-fluid d-flex px-0">
                    <div class="mr-1" style="width: 50%;">
                        <input type="text" class="form-control text-center inputTextToNumber" placeholder="Price in"
                            name="priceIn">
                    </div>
                    <div class="ml-1" style="width: 50%;">
                        <input type="text" class="form-control text-center inputTextToNumber" placeholder="Price sale"
                            name="priceSale">
                    </div>
                </div>
            </div>
            <div class="container-fluid d-flex px-0">
                <textarea class="container-fluid px-0 mt-2 mr-1 mb-1" placeholder="Info" name="info"
                    style="width: 50%;"></textarea>
                <div class="input__wrapper form-group mb-1 ml-1 mt-2" style="width: 50%;">
                    <input type="file" id="input__file" name="input__file[]" class="input input__file" accept="image/*">
                    <label for="input__file" class="btn input__file-button m-0 ">
                        <span class="input__file-button-text">Выберите фото</span>
                    </label>
                </div>
            </div>


            <div class="container-fluid px-0">
                <input type="submit" class="btn container-fluid" name="addGood" value="Add">
            </div>
        </div>
        <div class="col-4 d-flex flex-column justify-content-end" style="height: 100%;">
            <div>

            </div>
            <input type="text" id="deleteGoodInfo" class="form-control" value="Select Goods" style="color: #ffd369;"
                disabled>
            <input type="submit" class="btn container-fluid" name="deleteGood" value="Delete" id="deleteGood" disabled>
        </div>
    </div>
</form>
<?php } ?>