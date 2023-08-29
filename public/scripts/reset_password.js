const email_input = document.getElementById("email"),
    email_err_box = document.getElementById("email_err"),
    form = document.querySelector("form"),
    alert_box = document.getElementById("alert");

email_input.addEventListener("keypress", (e) => (e.code == "Space" ? e.preventDefault() : ""));

email_input.addEventListener("blur", () => {
    const email = email_input.value.trim();
    email.replace(" ", "");

    email_pattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (email.trim() === "") {
        email.value = "";
        email_err_box.classList.remove("d-none");
        email_err_box.innerText = "Invalid! Email is required";
    } else if (!email.match(email_pattern)) {
        email_err_box.classList.remove("d-none");
        email_err_box.innerText = "Invalid email pattern!";
    } else {
        email_err_box.classList.add("d-none");
        email_err_box.innerText = "";
    }
});

form.addEventListener("submit", (e) => {
    e.preventDefault();

    const email = email_input.value.trim();

    if (email.trim() === "") {
        email.value = "";
        email_err_box.classList.remove("d-none");
        email_err_box.innerText = "Invalid! Email is required";
        return;
    } else if (!email.match(email_pattern)) {
        email_err_box.classList.remove("d-none");
        email_err_box.innerText = "Invalid email pattern!";
        return;
    } else {
        email_err_box.classList.remove("d-none");
        email_err_box.innerText = "";
    }

    alert_box.classList.remove("d-none");
    alert_box.innerText = "Reset email is being forwarded, please wait a moment...";

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php?action=request_pwd_reset");

    xhr.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            const res = JSON.parse(this.response);
            if (res.status == "forbidden") {
                location.replace("index.php?action=error_forbidden");
            } else if (res.status == "not_authorized") {
                email_err_box.classList.remove("d-none");
                alert_box.innerText = "Reset token has been expired, get a new one!";
            } else if (res.status == "invalid") {
                email_err_box.classList.remove("d-none");
                alert_box.innerText = res.msg;
            } else if (res.status == "success") {
                alert_box.classList.add("d-none");
                alert_box.innerText = "";
                location.replace("index.php?action=team_login");
            }
        }
    };

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`email=${email}&ajax=true`);
});
