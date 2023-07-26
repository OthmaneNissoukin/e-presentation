import { FormValidation } from "./utils.js";
let { ajax_operation } = await import(`./ajax_${document.title.toLowerCase()}/ajax_code.js`);

const form = document.querySelector("form"),
    trainee_1 = document.getElementById("trainee_1"),
    trainee_2 = document.getElementById("trainee_2"),
    trainee_3 = document.getElementById("trainee_3"),
    group = document.getElementById("groups_options"),
    presentation_date = document.getElementById("presentation_date"),
    presentation_time = document.getElementById("presentation_time");

const trainee_1_error_box = document.getElementById("trainee_1_err"),
    trainee_2_error_box = document.getElementById("trainee_2_err"),
    trainee_3_error_box = document.getElementById("trainee_3_err"),
    group_error_box = document.getElementById("group_err"),
    alert_box = document.getElementById("alert_box");

let trainees_fields = [trainee_1, trainee_2, trainee_3];
let trainees_errors = [trainee_1_error_box, trainee_2_error_box, trainee_3_error_box];

trainees_fields.forEach(function (item, index) {
    item.addEventListener("blur", function () {
        FormValidation.print_error_fullname(item, trainees_errors[index]);
    });
});

group.addEventListener("blur", function () {
    FormValidation.print_error_group(this, group_error_box);
});

form.addEventListener("submit", function (e) {
    let trainee_1_name = trainee_1.value.trim(),
        trainee_2_name = trainee_2.value.trim(),
        trainee_3_name = trainee_3.value.trim(),
        group_code = group.value.trim(),
        // TODO: Allow Inserting Date And Time
        presentation_date_value = presentation_date.value,
        presentation_time_value = presentation_time.value;

    let errors = false;

    if (!(trainee_1_name && group_code)) {
        alert_box.classList.remove("d-none");
        alert_box.textContent = "Trainee 1 and group code fields are required!";
    } else {
        alert_box.classList.add("d-none");
        alert_box.textContent = "";
    }

    if (FormValidation.invalid_fullname(trainee_1_name) >= 1) errors = true;
    if (FormValidation.invalid_group(group_code) >= 1) errors = true;

    // Optional Fields
    if (trainee_2_name) {
        if (FormValidation.invalid_fullname(trainee_2_name) >= 1) errors = true;
    }

    if (trainee_3_name) {
        if (FormValidation.invalid_fullname(trainee_3_name) >= 1) errors = true;
    }

    // Ajax
    ajax_operation();

    if (errors) e.preventDefault();
});
