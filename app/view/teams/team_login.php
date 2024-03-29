<?php
    $title = "Sign in";
    $styles = ["css/login_page.css"]; 
    ob_start();
?>

<form action="index.php?action=authenticate_team" method="POST" >
    
    <fieldset class="border p-3">
        <h4 class="text-center text-secondary mb-3">TEAM LOGIN</h4>
        <!-- TODO: Temporary announce -->

        <?php 
            if (!isset($_SESSION)) session_start();
            if (isset($_SESSION["confirm_password"])):
        ?>
                <div class="alert alert-info">
                    <?= $_SESSION["confirm_password"] ?>
                </div>
        <?php 
            elseif (isset($_SESSION["activate_msg"])):
        ?>
            <div class="alert alert-success">
                <?= $_SESSION["activate_msg"] ?>
            </div>
        <?php 
            if (isset($_SESSION["confirm_password"])) unset($_SESSION["confirm_password"]);
            if (isset($_SESSION["activate_msg"])) unset($_SESSION["activate_msg"]);
            endif;
        ?>

        <div class="alert alert-info">
            <strong>Login (active): </strong> loggin <br>
            <strong>Password: </strong>loggin
            <hr>
            <strong>Login (inactive): </strong> 8Ha6RI <br>
            <strong>Password: </strong>azerty123
        </div>

        <aside id="flash_alert" class="alert alert-danger d-none"></aside>
        <input type="hidden" id="user" name="user" value="team">
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

        <a href="index.php?action=request_reset_layout">Forget password?</a>

        <input type="submit" value="Login" class="btn btn-primary px-5 rounded-0 w-100 my-2" />
        <a href="index.php?action=login_admin_layout" class="btn btn-secondary px-4 rounded-0 w-100">Admin space</a>
    </fieldset>
</form>

<script src="public/scripts/sign_in.js"></script>

<?php
    $content = ob_get_contents();
    ob_get_clean();
    require "app/view/master.php";
?>