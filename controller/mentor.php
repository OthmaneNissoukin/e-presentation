<?php

    class MentorController {

        static function authenticate_admin() {

            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                header("location: index.php?action=error_forbidden");
                exit;
            };

            if (Helpers::is_missing("login", "password")) die(json_encode(["status" => "error", "msg" => "not allowed"]));

            $login = trim($_POST["login"]);
            $password = trim($_POST["password"]);

            if (Helpers::is_empty($login, $password)) die(json_encode(["status" => "required", "msg" => "All fields are required"]));

            if (!PresentationModel::mentor_login($login, $password)) die(json_encode(["status" => "invalid", "msg" => "Wrong login or password"]));

            session_start();
            $_SESSION["admin"] = "logged";

            if (isset($_POST["ajax"])) {
                echo json_encode(["status" => "success", "msg" => "Login in"]);
                exit;
            }
            header("Location: index.php?action=mentor_homepage");
            exit;
        }

        static function create_team() {
            $validation_errors = [];

            if ($_SERVER["REQUEST_METHOD"] != "POST") die("Forbidden");

            if (Helpers::is_missing("trainee_1", "trainee_2", "trainee_3", "group", "presentation_date", "presentation_time")) die("Something is missing");

            $trainee_1 = ucwords(trim($_POST["trainee_1"]));
            $trainee_2 = ucwords(trim($_POST["trainee_2"]));
            $trainee_3 = ucwords(trim($_POST["trainee_3"]));
            $group = strtoupper(trim($_POST["group"]));
            $presentation_date = $_POST["presentation_date"];
            $presentation_time = $_POST["presentation_time"];

            // Date and Time are not checked here as the mentor may create the team before specify in the date and time
            if (Helpers::is_empty($trainee_1, $group)) die("Trainee 1 and group fields are required!");

            if (Helpers::invalid_fullname($trainee_1) == 1) {
                $validation_errors["trainee_1_err"] = "Invalid characters!";
            } elseif (Helpers::invalid_fullname($trainee_1) == 2) {
                $validation_errors["trainee_1_err"] = "Invalid! Fullname must contains at least 6 characters";
            }

            if (Helpers::invalid_group($group) == 1) {
                $validation_errors["group_err"] = "Invalid characters!";
            } elseif (Helpers::invalid_group($group) == 2) {
                $validation_errors["group_err"] = "Invalid! Group code must contains at least 6 characters";
            }

            // Validation When Inserting Multiple Trainees
            if (!empty($trainee_2)):
                if (Helpers::invalid_fullname($trainee_2) == 1) {
                    $validation_errors["trainee_2_err"] = "Invalid characters!";
                } elseif (Helpers::invalid_fullname($trainee_2) == 2) {
                    $validation_errors["trainee_2_err"] = "Invalid! Fullname must contains at least 6 characters";
                }
            endif;
            
            if (!empty($trainee_3)):
                if (Helpers::invalid_fullname($trainee_3) == 1) {
                    $validation_errors["trainee_3_err"] = "Invalid characters!";
                } elseif (Helpers::invalid_fullname($trainee_3) == 2) {
                    $validation_errors["trainee_3_err"] = "Invalid! Fullname must contains at least 6 characters";
                }
            endif;

            // Sending notification to the team when date or time is inserted or updated


            if ($validation_errors) {
                die(json_encode($validation_errors));
            }

            // echo "Good";

            // Affecting NULL to empty fields
            $trainee_2 = empty($trainee_2)? NULL : $trainee_2;
            $trainee_3 = empty($trainee_3)? NULL : $trainee_3;
            $presentation_date = empty($presentation_date)? NULL : $presentation_date;
            $presentation_time = empty($presentation_time)? NULL : $presentation_time;

            PresentationModel::save_team($group, $trainee_1, $trainee_2, $trainee_3, $presentation_date, $presentation_time);

            header("Location: index.php?action=register_layout");
            exit;
            
        }

        
        
        static function save_team_update() {
            $validation_errors = [];

            if ($_SERVER["REQUEST_METHOD"] != "POST") die("Forbidden");

            if (Helpers::is_missing("trainee_1", "trainee_2", "trainee_3", "group", "presentation_date", "presentation_time")) die("Something is missing");

            $trainee_1 = trim($_POST["trainee_1"]);
            $trainee_2 = trim($_POST["trainee_2"]);
            $trainee_3 = trim($_POST["trainee_3"]);
            $group = trim($_POST["group"]);
            $presentation_date = $_POST["presentation_date"];
            $presentation_time = $_POST["presentation_time"];
            $team_code = $_POST["team_code"];

            // Date and Time are not checked here as the mentor may create the team before specify in the date and time
            if (Helpers::is_empty($trainee_1, $group)) die("Trainee 1 and group fields are required!");

            if (Helpers::invalid_fullname($trainee_1) == 1) {
                $validation_errors["trainee_1_err"] = "Invalid characters!";
            } elseif (Helpers::invalid_fullname($trainee_1) == 2) {
                $validation_errors["trainee_1_err"] = "Invalid! Fullname must contains at least 6 characters";
            }

            if (Helpers::invalid_group($group) == 1) {
                $validation_errors["group_err"] = "Invalid characters!";
            } elseif (Helpers::invalid_group($group) == 2) {
                $validation_errors["group_err"] = "Invalid! Group code must contains at least 6 characters";
            }

            // Validation When Inserting Multiple Trainees
            if (!empty($trainee_2)):
                if (Helpers::invalid_fullname($trainee_2) == 1) {
                    $validation_errors["trainee_2_err"] = "Invalid characters!";
                } elseif (Helpers::invalid_fullname($trainee_2) == 2) {
                    $validation_errors["trainee_2_err"] = "Invalid! Fullname must contains at least 6 characters";
                }
            endif;
            
            if (!empty($trainee_3)):
                if (Helpers::invalid_fullname($trainee_3) == 1) {
                    $validation_errors["trainee_3_err"] = "Invalid characters!";
                } elseif (Helpers::invalid_fullname($trainee_3) == 2) {
                    $validation_errors["trainee_3_err"] = "Invalid! Fullname must contains at least 6 characters";
                }
            endif;

            // Sending notification to the team when date or time is inserted or updated


            if ($validation_errors) {
                die(json_encode($validation_errors));
            }

            // echo "Good";

            // Affecting NULL to empty fields
            $trainee_2 = empty($trainee_2)? NULL : $trainee_2;
            $trainee_3 = empty($trainee_3)? NULL : $trainee_3;
            $presentation_date = empty($presentation_date)? NULL : $presentation_date;
            $presentation_time = empty($presentation_time)? NULL : $presentation_time;

            echo $presentation_date;
            echo $presentation_time;

            PresentationModel::save_team_changes($team_code, $group, $trainee_1, $trainee_2, $trainee_3, $presentation_date, $presentation_time);

            header("Location: index.php?action=mentor_homepage");
            exit;
            
        }

        static function send_message(){

            if ($_SERVER["REQUEST_METHOD"] != "POST") die("forbidden");

            if (Helpers::is_missing("team_code", "msg_content")) die("forbidden");

            $team_code = $_POST["team_code"];
            $msg_content = trim($_POST["msg_content"]);

            if (Helpers::is_empty($team_code, $msg_content)) die("All fields are required!");

            PresentationModel::send_custom_message($team_code, $msg_content);

            header("Location: index.php?action=mentor_homepage");
            exit;

        }

        static function mentor_sign_out() {
            session_start();

            Helpers::redirect_if_not_authenticated("admin", "error_forbidden");
            unset($_SESSION["admin"]);

            header("location: index.php?action=login_admin_layout");
            exit;

        }
        
    }

?>