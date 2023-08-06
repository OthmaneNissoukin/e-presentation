// TD will decide how many trainees we are evaluating

let form = document.querySelector("form"),
    scale_inputs = document.querySelectorAll("[type='text']"),
    presentation_rows = document.querySelectorAll("[data-categorty='presentation']"),
    alert_box = document.getElementById("alert_box"),
    timer_box = document.getElementById("timer"),
    btn_start = document.getElementById("start"),
    btn_pause = document.getElementById("pause"),
    btn_stop = document.getElementById("stop"),
    timer_indicator = document.getElementById("indicator"),
    timer_container = document.getElementById("timer_container"),
    counter = null,
    counter_started = false;
(seconds = 0), (minutes = 0);

scale_inputs.forEach((item) => {
    item.addEventListener("change", function () {
        if (!this.value.match(/^[0-9\.]+$/) || Number(this.value) > Number(this.dataset.maxValue)) {
            this.style.borderColor = "Red";
        } else {
            this.style.borderColor = "#ddd";
        }
    });
});

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
        item.dispatchEvent(new Event("change"));
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

// Timer

btn_start.addEventListener("click", function () {
    // Prevent timer acceleration when multiple click on start
    if (counter_started) return;
    counter_started = true;
    counter = setInterval(() => {
        if (seconds >= 59) {
            seconds = 0;
            minutes += 1;
        }

        timer_box.innerText = `${minutes >= 10 ? minutes : "0" + String(minutes)}:${
            seconds >= 10 ? seconds : "0" + String(seconds)
        }`;

        timer_indicator.classList.toggle("invisible");

        if (minutes == 2 && seconds == 0) {
            timer_indicator.classList.remove("invisible");

            clearInterval(counter);
            return;
        }

        if (minutes >= 1) {
            timer_container.classList.remove("bg-primary");
            timer_container.classList.add("bg-danger");
        }

        seconds += 1;
    }, 250);
});

btn_pause.addEventListener("click", () => {
    counter_started = false;
    timer_indicator.classList.remove("invisible");
    clearInterval(counter);
});

btn_stop.addEventListener("click", () => {
    counter_started = false;
    clearInterval(counter);
    timer_indicator.classList.remove("invisible");
    seconds = 0;
    minutes = 0;

    timer_container.classList.add("bg-primary");
    timer_container.classList.remove("bg-danger");
});

// Reflecting 1st presentation column scores to the other trainees

presentation_rows.forEach((row) => {
    let scores_inputs = row.querySelectorAll("input[type='text']");

    scores_inputs[0].addEventListener("change", () => {
        scores_inputs.forEach((score_field) => {
            score_field.value = scores_inputs[0].value;

            // FIXME: Using dispatch event here lead to exceed call stack max size
            if (
                !score_field.value.match(/^[0-9\.]+$/) ||
                Number(score_field.value) > Number(score_field.dataset.maxValue)
            ) {
                score_field.style.borderColor = "Red";
            } else {
                score_field.style.borderColor = "#ddd";
            }
        });
    });
});
