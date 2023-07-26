export class FormValidation {
    static print_error_fullname(fullname, error_box) {
        let fullname_value = fullname.value.trim().replaceAll("  ", " ");
        if (this.invalid_fullname(fullname_value) == 1) {
            error_box.textContent = "Fullname must contain at least 6 characters!";
        } else if (this.invalid_fullname(fullname_value) == 2) {
            error_box.textContent = "Invalid fullname!";
        } else {
            error_box.textContent = "";
        }
    }

    static print_error_group(group_name, error_box) {
        let group_value = group_name.value.trim().replaceAll("  ", " ");
        if (this.invalid_group(group_value) == 1) {
            error_box.textContent = "Group name must contain at least 5 characters!";
        } else if (this.invalid_group(group_value) == 2) {
            error_box.textContent = "Invalid! Group name can only contain letters and digits.";
        } else {
            error_box.textContent = "";
        }
    }

    static invalid_fullname(fullname) {
        if (!(fullname.length >= 6)) {
            return 1;
        }

        if (!fullname.match(/^[A-Za-z ']+$/)) {
            return 2;
        }

        return 0;
    }

    static invalid_group(group_name) {
        if (!(group_name.length >= 5)) {
            return 1;
        }

        if (!group_name.match(/^[A-Za-z0-9']+$/)) {
            return 2;
        }

        return 0;
    }
}
