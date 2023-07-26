import { FilesUtils } from "./files_utils.js";

let report_file = document.getElementById("report"),
    report_bar = document.getElementById("report_bar"),
    report_warning_alert = document.getElementById("report_warning");

let report_form = document.getElementById("report_form");

//! ####################################################

report_form.addEventListener("submit", function (e) {
    e.preventDefault();
    let formdata = new FormData();

    let selected_file = report_file.files[0],
        allowed_types = "application/pdf";

    formdata.append("report", selected_file);

    // console.log(allowed_types);
    // console.log(formdata);

    if (!FilesUtils.is_valid_file_type(selected_file, allowed_types)) {
        report_warning_alert.innerHTML = `Report must be of type PDF.`;
        report_warning_alert.classList.remove("d-none", "alert-warning", "alert-info");
        report_warning_alert.classList.add("alert-danger");
        return;
    }

    let ajax = new XMLHttpRequest();

    // add progress event to find the progress of file upload
    ajax.upload.addEventListener("progress", function (e) {
        FilesUtils.filling_progress_bar(report_bar, e.loaded, e.total);
        // console.log(e);
    });

    ajax.upload.addEventListener("loadstart", function (e) {
        report_warning_alert.innerHTML = `${FilesUtils.spinner} A file is uploading. Please don't close this page.`;
        report_warning_alert.classList.remove("d-none", "alert-danger", "alert-info");
        report_warning_alert.classList.add("alert-warning");
    });

    ajax.upload.addEventListener("load", function (e) {
        FilesUtils.finshed_bar_status(report_bar);
        report_warning_alert.innerHTML = `${FilesUtils.spinner} Report is being saved. This may take a while....`;
        report_warning_alert.classList.remove("d-none");

        // console.log("Done");
    });

    ajax.onreadystatechange = function () {
        if (this.status == 200 && this.readyState == 4) {
            report_warning_alert.textContent = JSON.parse(this.responseText).message;
            report_warning_alert.classList.remove("d-none", "alert-warning");
            report_warning_alert.classList.add("alert-info");
            console.log(JSON.parse(this.responseText).message);
        }
    };

    ajax.open("POST", "index.php?action=upload_report");
    ajax.send(formdata);
});
