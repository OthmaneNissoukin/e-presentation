import { Octokit } from "https://esm.sh/@octokit/core";
let form = document.getElementById("application_form"),
    api_token = document.getElementById("token"),
    repository_link = document.getElementById("repository_link"),
    app_alert = document.getElementById("app_alert"),
    token_validation_err = document.getElementById("token_validation_err"),
    repo_validation_err = document.getElementById("repo_validation_err"),
    collaborator_response_code = null,
    fetch_response_code = null,
    invalid_repo = false,
    invalid_token = false;

//! ####################################################

api_token.addEventListener("blur", function () {
    let token_value = this.value.trim();
    if (!token_value) {
        token_validation_err.textContent = "Invalid! Repository token is required!";
        invalid_token = true;
    } else if (!token_value.match(/^ghp_[a-zA-Z0-9]{36}$/)) {
        token_validation_err.textContent = "Invalid token pattern!";
        invalid_token = true;
    } else {
        token_validation_err.textContent = "";
        invalid_token = false;
    }
});

repository_link.addEventListener("blur", function () {
    let link_value = this.value.trim();
    if (!link_value) {
        repo_validation_err.textContent = "Invalid! Repository link is required!";
        invalid_repo = true;
    } else if (!link_value.match(/^https:\/\/github\.com\/[a-zA-Z0-9_-]+\/[a-zA-Z0-9_-]+(?:\.git)?$/)) {
        repo_validation_err.textContent = "Invalid link pattern!";
        invalid_repo = true;
    } else {
        repo_validation_err.textContent = "";
        invalid_repo = false;
    }
});

form.addEventListener("submit", async function (e) {
    e.preventDefault();

    api_token.dispatchEvent(new Event("blur"));
    repository_link.dispatchEvent(new Event("blur"));

    // Prevent submitting when data is invalid
    if (invalid_repo || invalid_token) {
        console.log("invalid");
        return;
    }

    let repository = repository_link.value.trim();
    let token = api_token.value.trim();

    // Extracting repository name and the owner
    let owner_name = repository.split("/").at(-2);
    let repo_name = repository.split("/").at(-1);

    // Gernerating github api link to be fetched
    let repo_api = `https://api.github.com/repos/${owner_name}/${repo_name}`;

    // Wait until the promise is fulfilled
    await checkCollaborator(repo_api, token);

    // These variables are global
    if (fetch_response_code === 200 && collaborator_response_code === 204) {
        // Reset HTTP codes in case of another failure
        fetch_response_code = null;
        collaborator_response_code = null;

        // POST data with AJAX
        let xhr = new XMLHttpRequest();

        xhr.open("POST", "index.php?action=upload_application");
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`repository_link=${repository}&ajax=true`);
    }
});

async function checkCollaborator(repository, token) {
    let repo;
    try {
        repo = await fetch(repository);
    } catch (error) {
        show_app_feedback("warning", "Repository doesn't exist!");
        return;
    }

    // HTTP response code
    fetch_response_code = repo.status;

    if (fetch_response_code !== 200) {
        show_app_feedback("warning", "Repository doesn't exist!");
        return;
    }

    // Extracting repository name and the owner
    let owner_name = repository.split("/").at(-2);
    let repo_name = repository.split("/").at(-1);

    const octokit = new Octokit({ auth: token });

    try {
        const response = await octokit.request("GET /repos/{owner}/{repo}/collaborators/{username}", {
            owner: owner_name,
            repo: repo_name,
            username: "anouar-derdouri-development", // TODO: Make this to be dynamic
            // username: "NeroKetchup", // TODO: Make this to be dynamic
            headers: {
                "X-GitHub-Api-Version": "2022-11-28",
            },
        });

        collaborator_response_code = response.status;
        console.log("Status => " + collaborator_response_code);
    } catch (error) {
        const err_msg = error.message.toLowerCase();

        if (err_msg == "bad credentials") {
            show_app_feedback("warning", "Invalid Token!");
        } else if (err_msg == "not found") {
            show_app_feedback("warning", "anouar-derdouri-development is not a collaborator!");
            // show_app_feedback("warning", "NeroKetchup is not a collaborator!");
        } else if (err_msg.endsWith("is not a user")) {
            show_app_feedback("warning", "Given user is not a collaborator!");
        } else if (err_msg == "requires authentication") {
            show_app_feedback("warning", "Token is required");
        } else {
            show_app_feedback("warning", "Ops! Something went wrong!");
            // console.log("Ops! Something went wrong!");
        }

        // TODO: Create ENUM() Class To Handle These Errors Messages
    }

    if (fetch_response_code === 200 && collaborator_response_code === 204) {
        show_app_feedback("info", "Application repository link has been saved successfully!");
    }
}

function show_app_feedback(status, content, display = true) {
    app_alert.classList.remove("alert-warning", "alert-danger", "alert-info");
    app_alert.innerText = content;
    app_alert.classList.add(`alert-${status}`);

    if (!display) {
        app_alert.classList.remove("alert-warning", "alert-danger", "alert-info");
        app_alert.innerText = "";
        app_alert.classList.add(`d-none`);
    } else {
        app_alert.classList.remove(`d-none`);
    }
}
