$('img.img-svg-small').each(imgToSvg);
$('img.img-svg-avg').each(imgToSvg);

// конвертация img в svg для изменения цвета
function imgToSvg() {
    var $img = $(this);
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');
    $.get(imgURL, function (data) {
        var $svg = $(data).find('svg');
        if (typeof imgClass !== 'undefined') {
            $svg = $svg.attr('class', imgClass + ' replaced-svg');
        }
        $svg = $svg.removeAttr('xmlns:a');
        if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
            $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
        }
        $img.replaceWith($svg);
    }, 'xml');
}

// Кнопка загрузки изображений
var input = document.getElementById("input__file");
$(input).change(function (e) {
    let label = input.nextElementSibling,
        labelVal = label.querySelector('.input__file-button-text').innerText;
    let countFiles = '';
    if (this.files && this.files.length > 1) {
        countFiles = this.files.length;
    } else {
        console.log(this.files)
        labelVal = this.files[0].name;
    }


    if (countFiles)
        label.querySelector('.input__file-button-text').innerText = 'Выбрано файлов: ' + countFiles;
    else
        label.querySelector('.input__file-button-text').innerText = labelVal;
});


// ввод только цифр в input[type='text']
$(".inputTextToNumber").keydown((e) => {
    if (/[.\d]/g.test(e.key) === false && e.key !== "Backspace") return false;
})


// проверка, выбраны ли чекбоксы для удаления категорий из базы
$(".checkboxCategory").click(function () {
    if ($('#adminCategories input:checkbox:checked').length > 0) {
        $("#deleteCategoryInfo").css("color", "#0cb30c");
        $("#deleteCategoryInfo").val("Сlick to delete");
        $("#deleteCategory").prop("disabled", false);
    } else {
        $("#deleteCategoryInfo").css("color", "#ffd369");
        $("#deleteCategoryInfo").val("Select categories");
        $("#deleteCategory").prop("disabled", true);
    }
});

// проверка, выбраны ли чекбоксы для удаления товаров из базы
$(".checkboxGood").click(function () {
    if ($('#adminGoods input:checkbox:checked').length > 0) {
        $("#deleteGoodInfo").css("color", "#0cb30c");
        $("#deleteGoodInfo").val("Сlick to delete");
        $("#deleteGood").prop("disabled", false);
    } else {
        $("#deleteGoodInfo").css("color", "#ffd369");
        $("#deleteGoodInfo").val("Select categories");
        $("#deleteGood").prop("disabled", true);
    }
});


function deleteFromCart(cookieName, elem) {
    deleteCookie(cookieName);
    let row = document.getElementById(elem);
    row.remove();
}