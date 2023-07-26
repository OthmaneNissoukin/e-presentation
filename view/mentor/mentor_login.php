<?php
    $title = "Sign in";
    ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Sign In : <span class="text-danger">Admin</span></h2>

<form action="index.php?action=login_admin" method="POST">

    <aside id="flash_alert" class="alert alert-danger d-none">

    </aside>

    <fieldset class="border p-3">
        <input type="hidden" id="user" name="user" value="admin">
        <div class="mb-3">
            <label for="login" class="form-label">Login</label>
            <input name="login" id="login" type="text" class="form-control" placeholder="Login" />
            <span id="login_error_box" class="text-danger fw-light fs-6"></span>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input name="password" id="password" type="password" class="form-control" placeholder="********" />
            <span id="pwd_error_box" class="text-danger fw-light fs-6"></span>
        </div>

        <input type="submit" value="Login" class="btn btn-primary btn-lg" />
    </fieldset>
</form>

<script src="scripts/sign_in.js"></script>

<?php
    $content = ob_get_contents();
    ob_get_clean();
    require "view/master.php";
?>