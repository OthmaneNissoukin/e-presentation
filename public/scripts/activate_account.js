let form = document.querySelector("form");
let email = document.getElementById("email");
let password = document.getElementById("password");
let confirm_password = document.getElementById("confirm_password");
let email_err_box = document.getElementById("email_err");
let password_err_box = document.getElementById("password_err");
let confirm_password_err_box = document.getElementById("confirm_password_err");
let alert_box = document.getElementById("alert");

email.addEventListener("keypress", function (e) {
    if (e.code == "Space") e.preventDefault();
});

email.addEventListener("blur", function () {
    email_value = email.value.replace(" ", "");
    email.value = email_value;
    email_pattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (email_value.trim() === "") {
        this.value = "";
        email_err_box.classList.remove("d-none");
        email_err_box.innerText = "Invalid! Email is required";
    } else if (!email_value.match(email_pattern)) {
        email_err_box.classList.remove("d-none");
        email_err_box.innerText = "Invalid email pattern!";
    } else {
        email_err_box.classList.add("d-none");
        email_err_box.innerText = "";
    }
});

password.addEventListener("blur", function () {
    password_validation(this, password_err_box);
});

confirm_password.addEventListener("blur", function () {
    password_validation(this, confirm_password_err_box);
});

form.addEventListener("submit", function (e) {
    e.preventDefault();

    email_value = email.value.trim();
    pwd_value = password.value.trim();
    confirm_pwd_value = confirm_password.value.trim();

    email.dispatchEvent(new Event("blur"));
    password.dispatchEvent(new Event("blur"));
    confirm_password.dispatchEvent(new Event("blur"));

    if (pwd_value != confirm_pwd_value) {
        alert_box.textContent = "Password doesn't match confirmation!";
        alert_box.classList.remove("d-none");
        return;
    } else {
        alert_box.textContent = "";
        alert_box.classList.add("d-none");
    }

    if (!email_value.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) return;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php?action=activate_account");

    xhr.onreadystatechange = function () {
        if (this.status == 200 && this.readyState == 4) {
            server_response = this.response;
            if (server_response.includes("passed")) {
                window.location.replace("index.php?action=team_login");
                console.log("passed");
            } else if (server_response == "forbidden") {
                window.location.replace("index.php?action=team_login");
            }
        }
    };

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`email=${email_value}&password=${pwd_value}&confirm_password=${confirm_pwd_value}&ajax=yes`);
});

function password_validation(password_field, error_box) {
    let password_value = password_field.value.trim();

    if (password_value.length == 0) {
        error_box.innerText = "Invalid! Password is required.";
    } else if (!(password_value.length >= 6)) {
        error_box.innerText = "Password must contain at least 6 characters!";
    } else if (
        !(
            password_value.match(/[A-Z]+/) &&
            password_value.match(/[0-9]+/) &&
            password_value.match(/[a-z]+/) &&
            password_value.match(/[^A-Za-z0-9]+/)
        )
    ) {
        error_box.innerText = "Weak password! Must contain upper and lowercase letters, digits and special characters!";
    } else {
        error_box.innerText = "";
    }
}
