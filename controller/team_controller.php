<?php

    class TeamController{

        static function activate_account() {

            Helpers::redirect_if_not_authenticated("user", "error_forbidden");

            if ($_SERVER["REQUEST_METHOD"] != "POST") die("forbidden");

            if (Helpers::is_missing("password", "confirm_password")) die("Method not allowed");

            $password = trim($_POST["password"]);
            $confirm_password = trim($_POST["confirm_password"]);

            if (Helpers::is_empty($password, $confirm_password)) die("All fields are required!");
            
            if(!(strlen($password) >= 6 and strlen($confirm_password) >= 6)) die("Password must contain at least 6 characters");
            
            if ($password != $confirm_password) die("Password doesnt match the confirmation!");
            // Fields are setted
            session_start();
            $trainee_id = $_SESSION["user"];

            PresentationModel::update_password($trainee_id, $password);

            // Creating files rows in the database for this activating team account
            //! This will be deleted => FileModel::team_files_intialization($team_code);

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

            $user_data = TraineeModel::login_trainee($login, $password);

            // TODO: Adjust the query to take login and password at the same time
            if (!$user_data) die(json_encode(["status" => "invalid", "msg" => "Wrong login or password"]));

            // if ($team_data["password"] != $password) die(json_encode(["status" => "invalid", "msg" => "Wrong login or password"]));

            session_start();
            $_SESSION["team_code"] = $user_data["team_code"];
            $_SESSION["user"] = $user_data["trainee_id"];

            // TODO: Require account activation for every memeber of a team
            //Check if the account is inactivated
            if ($user_data["status"] == "inactive"):
                if (isset($_POST["ajax"])) die(json_encode(["status" => "inactivated", "msg" => "Activate account required"]));

                // This below lines wont execute if we are using ajax
                header("Location: index.php?action=activate_account_layout");
                exit;
            endif;

            if (isset($_POST["ajax"])) die(json_encode(["status" => "success", "msg" => "Log in"]));
            header("Location: index.php?action=team_homepage");
            exit;
        }

        static function change_team_status() {

            if (!isset($_SESSION)) {
                session_start();
            }
            $team_code = $_SESSION["team_code"];

            $application = FileModel::retrieve_path($team_code, "application");
            $report = FileModel::retrieve_path($team_code, "report");
            $presentation = FileModel::retrieve_path($team_code, "presentation");

            if (!empty($application) && !empty($report) && !empty($presentation)) {
                PresentationModel::update_team_status($team_code, "Ready");
            } else {
                PresentationModel::update_team_status($team_code, "Not Ready");
            }
        }

        static function team_sign_out() {
            session_start();

            Helpers::redirect_if_not_authenticated("user", "error_forbidden");
            unset($_SESSION["team_code"]);
            unset($_SESSION["user"]);

            header("location: index.php?action=team_login");
            exit;

        }

    }


?>