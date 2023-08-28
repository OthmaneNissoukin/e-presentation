<?php
    $title = "Activate account";

    $styles = ["css/login_page.css"];
    ob_start();
?>


<form action="index.php?action=activate_account" method="POST">
    <fieldset class="border p-3">
        <h4 class="text-secondary text-center">Activate account</h4>
        <div class="alert alert-danger d-none" id="alert"></div>
        <div class="mb-3">
            <label for="email" class="form-label">Email adresse</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="trainee@e-mail.com">
            <span class="text-danger fw-lighter" id="email_err"></span>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="********">
            <span class="text-danger fw-lighter" id="password_err"></span>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="********">
            <span class="text-danger fw-lighter" id="confirm_password_err"></span>
        </div>

        <input type="submit" value="Save changes" class="btn btn-primary rounded-0 w-100">
    </fieldset>
</form>

<script src="public/scripts/activate_account.js"></script>

<?php
    $content = ob_get_contents();
    ob_get_clean();
    require "app/view/master.php";
?>