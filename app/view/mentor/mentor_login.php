<?php
    $title = "Sign in";
    $styles = ["css/login_page.css"]; 
    ob_start();
?>


<form action="index.php?action=login_admin" method="POST">
    <fieldset class="border p-3">
        <h4 class="text-center text-secondary mb-3">ADMIN LOGIN</h4>

        <!-- TODO: Temporary announce -->
        <div class="alert alert-info">
            <strong>Login: </strong> admin1 <br>
            <strong>Password: </strong>admin1
        </div>
    
        <aside id="flash_alert" class="alert alert-danger d-none"></aside>

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

        <input type="submit" value="Login" class="btn btn-primary px-5 rounded-0 w-100 mb-2"/>
        <a href="index.php?action=team_login" class="btn btn-secondary px-4 rounded-0 w-100">Team space</a>
    </fieldset>
</form>

<script src="public/scripts/sign_in.js"></script>

<?php
    $content = ob_get_contents();
    ob_get_clean();
    require "app/view/master.php";
?>