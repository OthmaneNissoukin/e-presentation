const report_table = document.getElementById("report_table"),
    new_report = document.getElementById("new_report"),
    presentation_table = document.getElementById("presentation_table"),
    new_presentation = document.getElementById("new_presentation"),
    question_description = document.querySelectorAll("td:first-of-type input"),
    question_scale = document.querySelectorAll("td:last-of-type input"),
    form = document.querySelector("form"),
    alert_box = document.getElementById("alert_box");

// console.log(report_descriptions_inputs);

function createRow(input_name_attr, field_type) {
    let row = document.createElement("tr"),
        td_description = document.createElement("td"),
        td_scale = document.createElement("td"),
        input_description = document.createElement("input"),
        input_scale = document.createElement("input");

    input_description.classList.add("form-control", "w-100");
    input_scale.classList.add("form-control", "w-100");

    input_description.setAttribute("type", "text");
    input_description.setAttribute("name", `${input_name_attr}[description][]`);

    input_scale.setAttribute("type", "text");
    input_scale.setAttribute("name", `${input_name_attr}[description][]`);

    if (field_type == "report") {
        input_description.dataset.report = "description";
        input_scale.dataset.report = "scale";
    } else if (field_type == "presentation") {
        input_description.dataset.presentation = "description";
        input_scale.dataset.presentation = "scale";
    }

    td_description.append(input_description);
    td_scale.append(input_scale);

    row.append(td_description, td_scale);

    return row;
}

function is_valid_questions(array_questions_input) {
    let valid = true;
    array_questions_input.forEach((item) => {
        if (item.value === "") {
            valid = false;
            return;
        }
    });
    return valid;
}

function is_valid_scales(array_scales_input) {
    let error = "";
    array_scales_input.forEach((item) => {
        if (item.value === "" || item.value == 0) {
            error = "empty_error";
            return;
        } else if (!item.value.match(/^[0-9\.]+$/)) {
            error = "pattern_error";
        }
    });
    return error;
}

new_report.addEventListener("click", function () {
    let row = createRow("report_question", "report");

    report_table.appendChild(row);
});

new_presentation.addEventListener("click", function () {
    let row = createRow("presentation_question", "presentation");

    presentation_table.appendChild(row);
});

question_description.forEach((item) => {
    item.addEventListener("blur", function () {
        if (item.value === "") item.style.borderColor = "red";
        else item.style.borderColor = "#ddd";
    });
});

question_scale.forEach((item) => {
    item.addEventListener("blur", function () {
        if (item.value === "") {
            item.style.borderColor = "red";
        } else if (!item.value.match(/^[0-9\.]+$/)) {
            item.style.borderColor = "red";
        } else {
            item.style.borderColor = "#ddd";
        }
    });
});

form.addEventListener("submit", function (e) {
    e.preventDefault();

    const report_descriptions_inputs = Array.from(document.querySelectorAll("table [data-report='description']")),
        report_scales_inputs = Array.from(document.querySelectorAll("table [data-report='scale']")),
        presentation_descriptions_inputs = Array.from(
            document.querySelectorAll("table [data-presentation='description']")
        ),
        presentation_scales_inputs = Array.from(document.querySelectorAll("table [data-presentation='scale']"));

    document.querySelectorAll("input[type='text']").forEach((item) => item.dispatchEvent(new Event("blur")));

    // Checking the validation of both presentation and report questions by combining two arrays to pass to the function
    if (!is_valid_questions(report_descriptions_inputs.concat(presentation_descriptions_inputs))) {
        alert_box.innerText = "Questions cannot be empty!";
        alert_box.classList.remove("alert-primary");
        alert_box.classList.add("alert-danger");
        alert_box.classList.remove("d-none");
        return;
    } else {
        alert_box.innerText = "";
        alert_box.classList.remove("alert-primary");
        alert_box.classList.add("alert-danger");
        alert_box.classList.remove("d-none");
    }

    switch (is_valid_scales(report_scales_inputs.concat(presentation_scales_inputs))) {
        case "empty_error":
            alert_box.innerText = "Scale is required and cannot be 0!";
            alert_box.classList.remove("alert-primary");
            alert_box.classList.add("alert-danger");
            alert_box.classList.remove("d-none");
            return;

        case "pattern_error":
            alert_box.innerText = "Scale must be a number!";
            alert_box.classList.remove("alert-primary");
            alert_box.classList.add("alert-danger");
            alert_box.classList.remove("d-none");
            return;

        default:
            alert_box.innerText = "";
            alert_box.classList.add("d-none");
    }

    let report_descriptions = report_descriptions_inputs.map((item) => item.value);
    let report_scales = report_scales_inputs.map((item) => item.value);

    let presentation_descriptions = presentation_descriptions_inputs.map((item) => item.value);
    let presentation_scales = presentation_scales_inputs.map((item) => item.value);

    const report_question = {
        description: report_descriptions,
        scale: report_scales,
    };

    const presentation_question = {
        description: presentation_descriptions,
        scale: presentation_scales,
    };

    console.table(JSON.stringify());

    const xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (this.status == 200 && this.readyState == 4) {
            if (JSON.parse(this.responseText).status != "success") {
                alert_box.classList.remove("alert-primary");
                alert_box.classList.add("alert-danger");
                alert_box.classList.remove("d-none");
                alert_box.innerText = JSON.parse(this.responseText).message;
            } else {
                alert_box.innerText = "Evaluation has been created successfully!";
                alert_box.classList.add("alert-success");
                alert_box.classList.remove("alert-danger");
                alert_box.classList.remove("d-none");
                form.reset();
            }
        }
    };

    xhr.open("POST", "index.php?action=create_evaluation");
    xhr.setRequestHeader("Content-type", "Application/x-www-form-urlencoded");
    xhr.send(
        `ajax=true&report_question=${JSON.stringify(report_question)}&presentation_question=${JSON.stringify(
            presentation_question
        )}`
    );
});
