
// Registration validation begin

let loginReg = document.getElementById("loginReg");
let passReg = document.getElementById("passReg");
let passConfReg = document.getElementById("passConfReg");
let emailReg = document.getElementById("emailReg");


let loginError = document.getElementById("loginError");
let passError = document.getElementById("passError");
let passConfError = document.getElementById("passConfError");
let emailError = document.getElementById("emailError");

loginReg.addEventListener("input", validationLogin);
passReg.addEventListener("input", validationLogin);
passConfReg.addEventListener("input", validationLogin);
emailReg.addEventListener("input", validationLogin);

async function validationLogin() {
    let login = loginReg.value;
    let pass = passReg.value;
    let passConf = passConfReg.value;
    let email = emailReg.value;
    let formData = new FormData();
    formData.append("login", login);
    formData.append("pass", pass);
    formData.append("passConf", passConf);
    formData.append("email", email);
    let resp = await fetch("../AJAX-FUNCTIONS/registerValidation.php", {
        method: 'POST',
        body: formData
    });
    if (resp.ok == true) {
        let content = await resp.json();
        loginError.textContent = '';
        passError.textContent = '';
        passConfError.textContent = '';
        emailError.textContent = '';
        if (content['login'].length > 0) {
            loginError.textContent = content['login'];
        }
        else if (content['pass'].length > 0) {
            passError.textContent = content['pass'];
        }
        else if (content['passConf'].length > 0) {
            passConfError.textContent = content['passConf'];
        }
        else if (content['email'].length > 0) {
            emailError.textContent = content['email'];
        }
        console.log(content)
    }
}

// Registration validation end


// get goods by category 'CATALOG' begin

async function getGoodsByCategory(categoryId) {
    // selectFx.js 281 строчка
    let formData = new FormData();
    let category = $("#CatalogSelect>option:selected").text();
    formData.append('categoryId', categoryId);
    let response = await fetch("../AJAX-FUNCTIONS/getGoodsByCategory.php", {
        method: "POST",
        body: formData
    });
    if (response.ok === true) {
        let goods = await response.json();
        $("#catalog").html('');
        catalogHtml = '';
        goods.forEach(good => {
            let formData = new FormData();
            formData.append('goodId', good.id);
            fetch("../AJAX-FUNCTIONS/getImageByGood.php", {
                method: "POST",
                body: formData
            }).then((response) => {
                return response.json();
            }).then((data) => {
                let img = data.imagepath;
                catalogHtml += `
                <div class="p-3 col-lg-4 col-md-6 col-sm-6 col-12 p-0">
                <div class='catalog__item'>
            <div class="catalog__item-title">
                <div class="d-flex align-items-center" style="flex: 1">
                    <b>${good.good}</b>
                </div>
                <div class="d-flex align-items-center catalog__item-rate" style="flex: 0 1 30px">
                    <b class="">${good.rate}</b>
                </div>
            </div>
            <div class="catalog__item-image divImage"
                style="background-image: url(${img});">
                <div class="divBack">
                    <div class="catalog__item-buttons">
                        <a href="../index.php?good=${good.id}" class="itemLink mb-2">MORE</a>
                        <a onclick="moveToCart(${good.id}, this)" class="itemLink mt-2">BUY</a>
                    </div>
                </div>
            </div>
            <div class="catalog__item-info">
                <div class="categoryAndPrice">
                    <div style="flex: 1">
                        <b class="m-0">${category}</b>
                    </div>
                    <div style="flex: 0 1 40px; color: #eee">
                        <b class="m-0">${good.priceSale}$</b>
                    </div>
                </div>
                <div class="info">
                ${good.info}
                </div>
            </div>
            </div>
        </div>
                `;
                $("#catalog").html(catalogHtml)
            });

        });
    }
}

// get goods by category 'CATALOG' end