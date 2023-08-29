const password = document.getElementById("password"),
    confirm_password = document.getElementById("confirm_password"),
    password_err_box = document.getElementById("password_err"),
    confirm_password_err_box = document.getElementById("confirm_password_err"),
    alert_box = document.getElementById("alert"),
    form = document.querySelector("form");

password.addEventListener("blur", function () {
    password_validation(this, password_err_box);
});

confirm_password.addEventListener("blur", function () {
    password_validation(this, confirm_password_err_box);
});

form.addEventListener("submit", function (e) {
    e.preventDefault();

    pwd_value = password.value.trim();
    confirm_pwd_value = confirm_password.value.trim();

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

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php?action=save_new_password");

    xhr.onreadystatechange = function () {
        if (this.status == 200 && this.readyState == 4) {
            const server_response = JSON.parse(this.response);
            alert_box.classList.add("d-none");
            if (server_response.status == "success") {
                window.location.replace("index.php?action=team_login");
                console.log("passed");
            } else if (server_response.status == "invalid") {
                alert_box.classList.remove("d-none");
                alert_box.innerText = server_response.msg;
            } else if (server_response.status == "forbidden") {
                window.location.replace("index.php?action=error_forbidden");
            } else if (server_response.status == "not_authorized") {
                window.location.replace("index.php?action=error_unauthorized");
            }
        }
    };

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`password=${pwd_value}&confirm_password=${confirm_pwd_value}&ajax=yes`);
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
