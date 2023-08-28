<?php

    class TeamController{

        static function activate_account() {

            Helpers::redirect_if_not_authenticated("user", "error_forbidden");

            if ($_SERVER["REQUEST_METHOD"] != "POST") die("forbidden");

            if (Helpers::is_missing("password", "confirm_password", "email")) die("Method not allowed");

            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);
            $confirm_password = trim($_POST["confirm_password"]);

            
            if (Helpers::is_empty($password, $confirm_password, $email)) die("All fields are required!");
            
            $email_pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}?$/";
            if (!preg_match($email_pattern, $email)) die("Email is not valid!");
            
            if(!(strlen($password) >= 6 and strlen($confirm_password) >= 6)) die("Password must contain at least 6 characters");
            
            if ($password != $confirm_password) die("Password doesnt match the confirmation!");
            // Fields are setted
            if (!isset($_SESSION)) session_start();
            $trainee_id = $_SESSION["user"];

            PresentationModel::update_password($trainee_id, $password);

            // Send push up email notification
            $_SESSION["confirm_password"] = "A confirmation email has been sent to your inbox at: <strong>$email</strong>";

            // Generate token for email confirmation
            $random_token = array_merge(range("a","z"), range("A","Z"), range(0,9));
            shuffle($random_token);
            $random_token = implode("", array_slice($random_token, 0, 30));

            $hashed_token = password_hash($random_token, PASSWORD_DEFAULT);

            $email_subject = "Confirming e-presentation email";
            $message_to_send = "<div>
                <h2>Confirm your email adresse to start using e-presentation platform</h2>
                <p>Since its the first time you are login to the e-presentation platform, 
                we need you to confirm your email adresse to get started with app.</p>
                <a href=\"index.php?action=confirm_email&trainee=$trainee_id&tkn=$hashed_token\"
                    style='color: #fff; background-color: #00acee; border:none; outline:none; 
                    padding:8px 16px; margin:12px 0px; text-decoration:none'>
                    Activate Account
                </a>
                <p style='color: #333'>If this email was forworded to you by mistake you can simply ignored.</p>
            </div>";

            $_SESSION["targets"] = TraineeModel::get_trainee($trainee_id)["email"];
            $_SESSION["email_message"] = $message_to_send;
            $_SESSION["email_subject"] = $email_subject;

            PresentationModel::store_token($trainee_id, $email, $random_token);
            require "app/mail_index.php";

            unset($_SESSION["user"]);
            unset($_SESSION["team"]);

            if (isset($_POST["ajax"])) {
                // Redirect with javascript when sending data using ajax
                echo "passed";
                exit;
            }

            header("Location: index.php?action=team_login");
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

        static function is_active_trainee($trainee_id) {
            return TraineeModel::get_trainee($trainee_id)["status"] == "active";
        }

        static function activate_email() {
            if (Helpers::is_missing("trainee", "tkn")){
                header("location: index.php?action=error_forbidden");
                exit;
            }

            $trainee_id = $_GET["trainee"];
            $hashed_token = $_GET["tkn"];
            
            if (Helpers::is_empty($trainee_id, $hashed_token)){
                header("location: index.php?action=bad_request");
                exit;
            }

            $activating_data = TraineeModel::get_activating_info($trainee_id);

            
            $token = $activating_data["query_token"];
            $email = $activating_data["temp_email"];
            
            if (password_verify($token, $hashed_token)) {
                TraineeModel::activate_trainee($trainee_id, $email);
            }
            
            if (!isset($_SESSION)) session_start();
            $_SESSION["activate_msg"] = "Your account has been activated successfully!";
            TraineeModel::delete_trainee_token($trainee_id);
            header("location: index.php?action=team_login");
            exit;
        }

    }


?>