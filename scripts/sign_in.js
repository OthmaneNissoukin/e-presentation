let login_input = document.getElementById("login"),
    password_input = document.getElementById("password"),
    form = document.querySelector("form"),
    btn_submit = document.querySelector("input[type=submit]"),
    login_error_box = document.getElementById("login_error_box"),
    pwd_error_box = document.getElementById("pwd_error_box"),
    flash_box = document.getElementById("flash_alert"),
    user = document.getElementById("user").value,
    login_location,
    authentication_page = null,
    invalid_login = (invalid_password = false);

/*
    user variable is used to indicate which party wants to login since this script is used
    by team and admin with small differences
*/

if (user == "admin") {
    login_location = "index.php?action=mentor_homepage";
    authentication_page = "index.php?action=login_admin";
} else if (user == "team") {
    login_location = "index.php?action=team_homepage";
    authentication_page = "index.php?action=authenticate_team";
}

login_input.addEventListener("blur", function () {
    let password = login_input.value.trim();

    if (password.length == 0) {
        login_error_box.innerText = "Invalid! Login is required.";
        invalid_login = true;
    } else {
        login_error_box.innerText = "";
        invalid_login = false;
    }
});

password_input.addEventListener("blur", function () {
    let password = password_input.value.trim();

    if (password.length == 0) {
        pwd_error_box.innerText = "Invalid! Password is required.";
        invalid_password = true;
    } else {
        pwd_error_box.innerText = "";
        invalid_password = false;
    }
});

form.addEventListener("submit", function (e) {
    e.preventDefault();

    login = login_input.value.trim();
    password = password_input.value.trim();

    login_input.dispatchEvent(new Event("blur"));
    password_input.dispatchEvent(new Event("blur"));

    if (invalid_login || invalid_password) return;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", authentication_page);

    xhr.onreadystatechange = function () {
        if (this.status == 200 && this.readyState == 4) {
            // console.log(this.responseText);
            let server_response = JSON.parse(this.responseText);

            if (server_response.status == "success") {
                location.replace(login_location);
            } else if (server_response.status == "inactivated") {
                location.replace("index.php?action=activate_account_layout");
            } else if (server_response.status == "invalid") {
                flash_box.innerText = server_response.msg;
                flash_box.classList.remove("d-none");
            } else {
                location.replace("index.php?action=forbidden");
            }
        }
    };

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`login=${login}&password=${password}&ajax=true`);
});
