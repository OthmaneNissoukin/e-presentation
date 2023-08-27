export function ajax_operation(
    trainee_1_name,
    trainee_2_name,
    trainee_3_name,
    group_code,
    presentation_date_value,
    presentation_time_value
) {
    let alert_box = document.getElementById("alert_box");
    let xhr = new XMLHttpRequest();

    xhr.open("POST", "index.php?action=check");

    xhr.onreadystatechange = function () {
        if (this.status == 200 && this.readyState == 4) {
            let server_response = JSON.parse(this.responseText);
            if (server_response.status == "error") {
                location.replace("index.php?action=forbidden");
            } else if (server_response == "invalid") {
                alert_box.innerText = server_response;
                alert_box.classList.remove("d-none");
            } else if (server_response.status == "success") {
                location.replace("index.php?action=register_layout");
            }
        }
    };

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(
        `ajax=true&trainee_1=${trainee_1_name}&trainee_2=${trainee_2_name}&trainee_3=${trainee_3_name}&group=${group_code}&presentation_date=${presentation_date_value}&presentation_time=${presentation_time_value}`
    );
}
