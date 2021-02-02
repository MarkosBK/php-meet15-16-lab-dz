<?php
if (isset($_POST['addCategory'])) {
    $newCategory = new Category($_POST['category']);
    if ($newCategory->push_to_db()) {
        echo "<script>";
        echo "window.location = document.URL";
        echo "</script>";
    } else echo "<h3 align='center' style='color: red'>При добавлении возникла ошибка!</h3>";
} else if (isset($_POST['deleteCategory'])) {
    if (Category::delete($_POST['categoryCheckboxes'])) {
        echo "<script>";
        echo "window.location = document.URL";
        echo "</script>";
    } else echo "<h3 align='center' style='color: red'>При удалении возникла ошибка!</h3>";
} else {
?>

<form action="index.php?page=3" method="POST" class="admin__section-form">
    <h2 align='center' class="admin__title">CATEGORIES</h2>
    <div class="admin__overflow">
        <table class="table">
            <thead>
                <tr class='row'>
                    <th class="col-1">#</th>
                    <th class="col-10">CATEGORY</th>
                    <th class="col-1"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $categories = Category::getAll();
                    for ($i = 0; $i < count($categories); $i++) {
                        echo "<tr class='row'><td class='col-1'>" . ($i + 1) . ".</td>";
                        echo "<td class='col-10'>" . $categories[$i]->category . "</td>";
                        echo "<td class='col-1'>";
                        echo "<input type='checkbox' value='" . $categories[$i]->id . "' class='checkbox checkboxCategory' id='" . $i . "category' name='categoryCheckboxes[]' />";
                        echo "<label for='" . $i . "category'></label>";
                        echo "</td>";
                    }
                    ?>
            </tbody>
        </table>
    </div>
    <div class="admin__panel row">
        <div class="col-6">
            <input type="text" name="category" class="form-control text-center" placeholder="Enter category">
            <input type="submit" class="btn container-fluid" name="addCategory" value="Add">
        </div>
        <div class="col-6">
            <input type="text" id="deleteCategoryInfo" class="form-control" value="Select categories"
                style="color: #ffd369;" disabled>
            <input type="submit" class="btn container-fluid" name="deleteCategory" value="Delete" id="deleteCategory"
                disabled>
        </div>
    </div>
</form>

<?php } ?>