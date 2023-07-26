import { FilesUtils } from "./files_utils.js";

let presentation_file = document.getElementById("presentation"),
    presentation_bar = document.getElementById("presentation_bar"),
    presentation_warning_alert = document.getElementById("presentation_warning");

let presentation_form = document.getElementById("presentation_form");

//! ####################################################

presentation_form.addEventListener("submit", function (e) {
    e.preventDefault();
    let formdata = new FormData();
    let selected_file = presentation_file.files[0];
    const allowed_types = [
        "application/vnd.openxmlformats-officedocument.presentationml.presentation",
        "application/vnd.ms-powerpoint",
    ];

    formdata.append("presentation", selected_file);

    // console.log(selected_file);

    if (!FilesUtils.is_valid_file_type(selected_file, ...allowed_types)) {
        presentation_warning_alert.innerHTML = `Presentation must be of type PPT or PPTX`;
        presentation_warning_alert.classList.remove("d-none", "alert-warning");
        presentation_warning_alert.classList.add("alert-danger");
        return;
    }

    let ajax = new XMLHttpRequest();

    // add progress event to find the progress of file upload
    ajax.upload.addEventListener("progress", function (e) {
        FilesUtils.filling_progress_bar(presentation_bar, e.loaded, e.total);
        // console.log(e);
    });

    ajax.upload.addEventListener("loadstart", function (e) {
        presentation_warning_alert.innerHTML = `${FilesUtils.spinner} A file is uploading. Please don't close this page.`;
        presentation_warning_alert.classList.remove("d-none", "alert-danger");
        presentation_warning_alert.classList.add("alert-warning");
    });

    ajax.upload.addEventListener("load", function (e) {
        FilesUtils.finshed_bar_status(presentation_bar);
        presentation_warning_alert.innerHTML = `${FilesUtils.spinner} Presentation is being saved. This may take a while....`;
        presentation_warning_alert.classList.remove("d-none");

        // console.log("Done");
    });

    ajax.onreadystatechange = function () {
        if (this.status == 200 && this.readyState == 4) {
            presentation_warning_alert.textContent = JSON.parse(this.responseText).message;
            presentation_warning_alert.classList.remove("d-none", "alert-warning");
            presentation_warning_alert.classList.add("alert-info");
            console.log(JSON.parse(this.responseText).message);
        }
    };

    ajax.open("POST", "index.php?action=upload_presentation");
    ajax.send(formdata);
});
