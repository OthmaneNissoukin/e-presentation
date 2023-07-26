<?php
    $title = "Activate account";

    ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Activate account</h2>

<form action="index.php?action=activate_account" method="POST">
    
    <div class="alert alert-danger d-none" id="alert"></div>

    <fieldset class="border p-3">
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

        <input type="submit" value="Save changes" class="btn btn-primary">
    </fieldset>
</form>

<script src="scripts/activate_account.js"></script>

<?php
    $content = ob_get_contents();
    ob_get_clean();
    require "view/master.php";
?>