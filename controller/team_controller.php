<?php

    class TeamController{

        static function activate_account() {

            if ($_SERVER["REQUEST_METHOD"] != "POST") die("forbidden");

            if (Helpers::is_missing("password", "confirm_password")) die("Method not allowed");

            $password = trim($_POST["password"]);
            $confirm_password = trim($_POST["confirm_password"]);

            if (Helpers::is_empty($password, $confirm_password)) die("All fields are required!");
            
            if(!(strlen($password) >= 6 and strlen($confirm_password) >= 6)) die("Password must contain at least 6 characters");
            
            if ($password != $confirm_password) die("Password doesnt match the confirmation!");
            // Fields are setted
            session_start();
            $team_code = $_SESSION["team_code"];

            PresentationModel::update_password($team_code, $password, $confirm_password);

            // Creating files rows in the database for this activating team account
            FileModel::team_files_intialization($team_code);

            if (isset($_POST["ajax"])) {
                // Redirect with javascript when sending data using ajax
                echo "passed";
                exit;
            }

            header("Location: index.php?action=team_homepage");
            exit;

        }


        static function authenticate_team() {

            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                header("location: index.php?action=error_forbidden");
                exit;
            };

            if (Helpers::is_missing("login", "password")) die(json_encode(["status" => "error", "msg" => "not allowed"]));

            $login = trim($_POST["login"]);
            $password = trim($_POST["password"]);

            if (Helpers::is_empty($login, $password))  die(json_encode(["status" => "required", "msg" => "All fields are required"]));

            $team_data = PresentationModel::retrieve_teams_data($login);

            // TODO: Adjust the query to take login and password at the same time
            if (!$team_data) die(json_encode(["status" => "invalid", "msg" => "Wrong login or password"]));

            if ($team_data["password"] != $password) die(json_encode(["status" => "invalid", "msg" => "Wrong login or password"]));

            session_start();
            $_SESSION["team_code"] = $login;

            // Check if the account is inactivated
            if ($team_data["status"] == "Inactivated"):
                if (isset($_POST["ajax"])) die(json_encode(["status" => "inactivated", "msg" => "Activate account required"]));

                // This below lines wont execute if we are using ajax
                header("Location: index.php?action=activate_account_layout");
                exit;
            endif;

            if (isset($_POST["ajax"])) die(json_encode(["status" => "success", "msg" => "Log in"]));
            header("Location: index.php?action=team_homepage");
            exit;
        }

        static function team_sign_out() {
            session_start();

            Helpers::redirect_if_not_authenticated("team_code", "error_forbidden");
            unset($_SESSION["team_code"]);

            header("location: index.php?action=team_login");
            exit;

        }

    }


?>