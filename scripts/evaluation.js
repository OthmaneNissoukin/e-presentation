// TD will decide how many trainees we are evaluating

let form = document.querySelector("form"),
    scale_inputs = document.querySelectorAll("[type='text']"),
    alert_box = document.getElementById("alert_box");

scale_inputs.forEach((item) => {
    item.addEventListener("blur", function () {
        if (!this.value.match(/^[0-9\.]+$/) || Number(this.value) > Number(this.dataset.maxValue)) {
            this.style.borderColor = "Red";
        } else {
            this.style.borderColor = "#ddd";
        }
    });
});

/*
    trainees = {
        "member_1" : [
            {"code": "value"}
            {"code": "value"}
            {"code": "value"}
        ]
    }
*/

form.addEventListener("submit", (e) => {
    e.preventDefault();

    let trainees = {},
        question_code = "",
        answer = "",
        result = {},
        scales = [],
        questions_codes = [],
        error = "";

    scale_inputs.forEach((item) => {
        item.dispatchEvent(new Event("blur"));
        let member = item.name.slice(item.name.indexOf("[") + 1, item.name.lastIndexOf("[") - 1);

        if (!(member in trainees)) trainees[member] = {};
        question_code = item.name.slice(item.name.lastIndexOf("[") + 1, item.name.lastIndexOf("]"));
        answer = item.value;

        if (questions_codes.indexOf(question_code) === -1) {
            // Prevent question codes repitition
            scales.push(item.dataset.maxValue);
            questions_codes.push(question_code);
        }

        if (!answer.match(/^[0-9\.]+$/)) {
            error = "pattern_error";
            return;
        } else if (Number(answer) > Number(item.dataset.maxValue)) {
            error = "invalid_error";
            return;
        }

        if (error == "pattern_error") {
            alert_box.classList.remove("d-none");
            alert_box.innerText = "Score must be a positive number!";
            return;
        } else if (error == "invalid_error") {
            alert_box.classList.remove("d-none");
            alert_box.innerText = "Score is out of range!";
            return;
        }

        result[question_code] = answer;

        // if (trainees[member].length == 0)
        trainees[member][question_code] = answer;
    });

    if (error) return;

    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (JSON.parse(this.responseText).status == "success") {
                document.querySelectorAll("input").forEach((item) => (item.disabled = true));
            }
        }
    };

    xhr.open("POST", "index.php?action=submit_evaluation");
    xhr.setRequestHeader("Content-type", "Application/x-www-form-urlencoded");
    xhr.send(`ajax=true&answer=${JSON.stringify(trainees)}&question_scale=${JSON.stringify(scales)}`);
});
