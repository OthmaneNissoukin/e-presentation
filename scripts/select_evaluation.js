const evaluation_code = document.getElementById("evaluation_code"),
    team_code = document.getElementById("team_code"),
    btn_check = document.getElementById("btn_check"),
    btn_save = document.getElementById("btn_save"),
    presentation_row = document.getElementById("presentation_row"),
    alert_box = document.getElementById("alert_box");

btn_check.addEventListener("click", () => {
    let evaluation_code_value = evaluation_code.value.trim();

    if (!evaluation_code_value.match(/^E-[0-9]{3}$/)) {
        alert_box.innerText = "Invalid evaluation code pattern!";
        alert_box.classList.remove("d-none");
    } else {
        alert_box.classList.add("d-none");
    }

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.status == 200 && this.readyState == 4) {
            const response = JSON.parse(this.responseText);
            if (response.status == "invalid") {
                alert_box.innerText = response.message;
                alert_box.classList.remove("d-none");
            } else if (response.status == "success") {
                create_table(JSON.parse(response.message));
                alert_box.classList.add("d-none");
            } else {
                alert_box.classList.add("d-none");
            }
        }
    };

    xhr.open("POST", "index.php?action=check_evaluation");
    xhr.setRequestHeader("Content-type", "Application/x-www-form-urlencoded");
    xhr.send(`evaluation_code=${evaluation_code_value}&ajax=true`);
});

btn_save.addEventListener("click", () => {
    let evaluation_code_value = evaluation_code.value.trim(),
        team_code_value = team_code.value.trim();

    if (!evaluation_code_value.match(/^E-[0-9]{3}$/)) {
        alert_box.innerText = "Invalid evaluation code pattern!";
        alert_box.classList.remove("d-none");
        return;
    } else {
        alert_box.classList.add("d-none");
    }

    if (!team_code_value.match(/^[0-9]{4}$/)) {
        alert_box.innerText = "Invalid team code pattern!";
        alert_box.classList.remove("d-none");
        return;
    } else {
        alert_box.classList.add("d-none");
    }
});

function create_table(evaluations_array) {
    const tr = document.createElement("tr"),
        td = document.createElement("td");

    tr.dataset.created = "true";

    // Remove previous results
    document.querySelectorAll("table tr[data-created='true']").forEach((item) => item.remove());

    evaluations_array.forEach((row) => {
        const td_1 = td.cloneNode(),
            td_2 = td.cloneNode(),
            tr_clone = tr.cloneNode(true);

        td_1.innerText = row["question_content"];
        td_2.innerText = row["question_scale"];

        td_1.style.paddingLeft = "32px";
        tr_clone.append(td_1, td_2);

        if (row["question_topic"] == "report") presentation_row.after(tr_clone);
        else presentation_row.before(tr_clone);
    });
}
