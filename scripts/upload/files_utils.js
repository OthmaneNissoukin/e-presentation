export class FilesUtils {
    static spinner = "<div class='spinner-border text-danger'><span class='visually-hidden'></span></div>";

    static filling_progress_bar(progress_bar_element, loaded_amount, total_size) {
        let percentage = (loaded_amount / total_size) * 100;
        progress_bar_element.style.width = percentage + "%";
    }

    static finshed_bar_status(progress_bar_element) {
        progress_bar_element.classList.remove("bg-danger", "progress-bar-striped");
        progress_bar_element.classList.add("bg-success");
    }

    static is_valid_file_type(file, ...mime_type) {
        return Boolean(mime_type.includes(file.type.toLowerCase()));
    }
}
