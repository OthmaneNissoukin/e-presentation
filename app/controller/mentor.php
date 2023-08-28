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

            Helpers::redirect_if_not_authenticated("admin", "error_forbidden");

            if ($_SERVER["REQUEST_METHOD"] != "POST") die(json_encode(["status" => "error", "msg" => "Forbidden"]));

            if (Helpers::is_missing("trainee_1", "trainee_2", "trainee_3", "group", "presentation_date", "presentation_time")) die(json_encode(["status" => "error", "msg" => "Forbidden"]));

            $trainee_1 = ucwords(trim($_POST["trainee_1"]));
            $trainee_2 = ucwords(trim($_POST["trainee_2"]));
            $trainee_3 = ucwords(trim($_POST["trainee_3"]));
            $group = strtoupper(trim($_POST["group"]));
            $presentation_date = $_POST["presentation_date"];
            $presentation_time = $_POST["presentation_time"];

            // Date and Time are not checked here as the mentor may create the team before specify in the date and time
            if (Helpers::is_empty($trainee_1, $group)) die(json_encode(["status" => "invalid", "msg" => "Invalid! Trainee 1 and group are required."]));

            if (Helpers::invalid_fullname($trainee_1) == 1) {
                die(json_encode(["status" => "invalid", "msg" => "Invalid characters!"]));
            } elseif (Helpers::invalid_fullname($trainee_1) == 2) {
                die(json_encode(["status" => "invalid", "msg" => "Invalid! Fullname code must contains at least 6 characters."]));
            }

            if (Helpers::invalid_group($group) == 1) {
                die(json_encode(["status" => "invalid", "msg" => "Invalid characters!"]));
            } elseif (Helpers::invalid_group($group) == 2) {
                die(json_encode(["status" => "invalid", "msg" => "Invalid! Group code must contains at least 5 characters."]));
            }

            // Validation When Inserting Multiple Trainees
            if (!empty($trainee_2)):
                if (Helpers::invalid_fullname($trainee_2) == 1) {
                    die(json_encode(["status" => "invalid", "msg" => "Invalid characters!"]));
                } elseif (Helpers::invalid_fullname($trainee_2) == 2) {
                    die(json_encode(["status" => "invalid", "msg" => "Invalid! Fullname must contains at least 6 characters."]));
                }
            endif;
            
            if (!empty($trainee_3)):
                if (Helpers::invalid_fullname($trainee_3) == 1) {
                    die(json_encode(["status" => "invalid", "msg" => "Invalid characters!"]));
                } elseif (Helpers::invalid_fullname($trainee_3) == 2) {
                    die(json_encode(["status" => "invalid", "msg" => "Invalid! Fullname must contains at least 6 characters."]));
                }
            endif;


            // Affecting NULL to empty fields
            $trainee_2 = empty($trainee_2)? NULL : $trainee_2; // Instead of null, we will delete this trainee
            $trainee_3 = empty($trainee_3)? NULL : $trainee_3;
            $presentation_date = empty($presentation_date)? NULL : $presentation_date;
            $presentation_time = empty($presentation_time)? NULL : $presentation_time;

            // Generate 4 Digits number as a team identifier
            $team_code = null;
            while (true) {
                $team_code = random_int(0, 9999);
                settype($team_code, "string");
                if (strlen($team_code) < 4) {
                    $team_code = str_pad($team_code, 4, "0", STR_PAD_LEFT);
                }
            
                // Checking if this generated code is available to use as new team identifier
                $team_exists = PresentationModel::retrieve_teams_data($team_code);

                if (!$team_exists) break;
            }
            
            PresentationModel::save_team($team_code, $group, $presentation_date, $presentation_time);
            
            !empty($trainee_1) ? TraineeModel::create_trainee($team_code, $trainee_1) : "";
            !empty($trainee_2) ? TraineeModel::create_trainee($team_code, $trainee_2) : "";
            !empty($trainee_3) ? TraineeModel::create_trainee($team_code, $trainee_3) : "";

            // Send notification if date or time is setted.
            if ($presentation_date or $presentation_time) {
                $formated_date = implode("-", array_reverse(explode("-", $presentation_date)));

                if (is_null($presentation_time)) $formated_time = "(Time still unknown)";
                else $formated_time = substr($presentation_time, 0, 5);

                $msg_content = "Your prensentation date has been scheduled on $formated_date at $formated_time";
                $msg_object = "Presentation time update.";
                NotificationModel::send_custom_message($team_code, $msg_content, $msg_object);
            }
            
            if (isset($_POST["ajax"])) {
                echo json_encode(["status" => "success", "msg" => "passed"]);
                exit;
            }

            header("Location: index.php?action=register_layout");
            exit;
            
        }

        
        
        static function save_team_update() {
            Helpers::redirect_if_not_authenticated("admin", "error_forbidden");

            if ($_SERVER["REQUEST_METHOD"] != "POST") die(json_encode(["status" => "error", "msg" => "Forbidden"]));

            if (Helpers::is_missing("trainee_1", "trainee_2", "trainee_3", "group", "presentation_date", "presentation_time")) die(json_encode(["status" => "error", "msg" => "Forbidden"]));

            $trainee_1 = trim($_POST["trainee_1"]);
            $trainee_2 = trim($_POST["trainee_2"]);
            $trainee_3 = trim($_POST["trainee_3"]);
            $group = trim($_POST["group"]);
            $presentation_date = $_POST["presentation_date"];
            $presentation_time = $_POST["presentation_time"];

            // TODO: Bring it from session for more security
            if (!isset($_SESSION)) {
                session_start();
            }
            $team_code = $_SESSION["team_to_update"];

            // Date and Time are not checked here as the mentor may create the team before specify in the date and time
            if (Helpers::is_empty($trainee_1, $group)) die(json_encode(["status" => "invalid", "msg" => "Trainee 1 and group fields are required!"]));

            if (Helpers::invalid_fullname($trainee_1) == 1) {
                die(json_encode(["status" => "invalid", "msg" => "Invalid characters!"]));
            } elseif (Helpers::invalid_fullname($trainee_1) == 2) {
                die(json_encode(["status" => "invalid", "msg" => "Invalid! Fullname must contains at least 6 characters"]));
            }

            if (Helpers::invalid_group($group) == 1) {
                die(json_encode(["status" => "invalid", "msg" => "Invalid characters!"]));
            } elseif (Helpers::invalid_group($group) == 2) {
                die(json_encode(["status" => "invalid", "msg" => "Invalid! Group code must contains at least 6 characters"]));
            }

            // Validation When Inserting Multiple Trainees
            if (!empty($trainee_2)):
                if (Helpers::invalid_fullname($trainee_2) == 1) {
                    die(json_encode(["status" => "invalid", "msg" => "Invalid characters!"]));
                } elseif (Helpers::invalid_fullname($trainee_2) == 2) {
                    die(json_encode(["status" => "invalid", "msg" => "Invalid! Group code must contains at least 6 characters"]));
                }
            endif;
            
            if (!empty($trainee_3)):
                if (Helpers::invalid_fullname($trainee_3) == 1) {
                    die(json_encode(["status" => "invalid", "msg" => "Invalid characters!"]));
                } elseif (Helpers::invalid_fullname($trainee_3) == 2) {
                    die(json_encode(["status" => "invalid", "msg" => "Invalid! Group code must contains at least 6 characters"]));
                }
            endif;

            // Affecting NULL to empty fields
            $trainee_2 = empty($trainee_2)? NULL : $trainee_2;
            $trainee_3 = empty($trainee_3)? NULL : $trainee_3;
            $presentation_date = empty($presentation_date)? NULL : $presentation_date;
            $presentation_time = empty($presentation_time)? NULL : $presentation_time;

            $old_trainee_1 = $_SESSION["trainee_1"];
            $old_trainee_2 = $_SESSION["trainee_2"];
            $old_trainee_3 = $_SESSION["trainee_3"];

            // Update and delete trainees if changes occured when updating
            if ($trainee_1 != $old_trainee_1) {
                TraineeModel::update_trainee($team_code, $trainee_1, $old_trainee_1);
            };
            
            if (empty($trainee_2) && !empty($old_trainee_2)) {
                TraineeModel::delete_trainee($team_code, $old_trainee_2);
            } else if (!empty($trainee_2) && empty($old_trainee_2)) {
                TraineeModel::create_trainee($team_code, $trainee_2);
            } else if ($trainee_2 != $old_trainee_2) {
                TraineeModel::update_trainee($team_code, $trainee_2, $old_trainee_2);
            }

            if (empty($trainee_3) && !empty($old_trainee_3)) {
                // Delete trainee 3
                TraineeModel::delete_trainee($team_code, $old_trainee_3);
            } else if (!empty($trainee_3) && empty($old_trainee_3)) {
                // Insert trainee 3
                TraineeModel::create_trainee($team_code, $trainee_3);
            } else if ($trainee_3 != $old_trainee_3) {
                // Update trainee 3
                TraineeModel::update_trainee($team_code, $trainee_2, $old_trainee_3);
            }

            // Detect changes for date and time to notify team members.
            $team_data = PresentationModel::retrieve_teams_data($team_code);

            $older_date = $team_data["presentation_date"];
            $older_time = $team_data["presentation_time"];

            PresentationModel::save_team_changes($team_code, $group, $presentation_date, $presentation_time);

            // Send notification if date or time is setted.
            if ($presentation_date or $presentation_time) {
                $changes = false;

                if ($presentation_date != $older_date) {
                    $presentation_date = implode("-", array_reverse(explode("-", $presentation_date)));
                    $changes =  true;
                }

                if ($presentation_time != $older_time) {
                    if (is_null($presentation_time)) $time = "(Time still unknown)";
                    else $presentation_time = substr($presentation_time, 0, 5);
                    $changes =  true;
                }


                if ($changes) {
                    $msg_content = "Your prensentation date has been updated to: $presentation_date at $presentation_time";
                    $msg_object = "Presentation time update.";
                    NotificationModel::send_custom_message($team_code, $msg_content, $msg_object);

                    // Send push up email notification
                    $team_members = TraineeModel::get_team_members($team_code);
                    $target_emails = array_map(fn($member) => $member["email"], $team_members);

                    $_SESSION["targets"] = $target_emails;

                    $_SESSION["email_message"] = "<div><h2>Hi There,</h2>
                        <p>Your soutenance schedule has been updated to: 
                        <span style='color:red; font-weight:bold'>$presentation_date</span> at <span style='color:red; font-weight:bold'>$presentation_time</span>. 
                        Check out your account for more informations.</p>
                        <a 
                            href='www.google.com' 
                            style='color: #fff; background-color: #00acee; border:none; outline:none; 
                            padding:8px 16px; margin:12px 0px; text-decoration:none'>Visit account
                        </a>
                    </div>"; 

                    $_SESSION["email_subject"] = 'Soutenance updates';

                    require "app/mail_index.php";

                    unset($_SESSION["targets"], $_SESSION["email_message"]);

                    if (isset($_POST["ajax"])) {
                        die(json_encode(["status" => "success", "msg" => "Team data has been updated successfully"]));
                    }

                    header("location: index.php?action=mentor_homepage");
                    exit;

                }

            }

            unset($_SESSION["team_to_update"]);

            if (isset($_POST["ajax"])) {
                echo json_encode(["status" => "success", "msg" => "pass"]);
                exit;
            }
            header("Location: index.php?action=mentor_homepage");
            exit;
            
        }

        static function send_message(){

            Helpers::redirect_if_not_authenticated("admin", "error_forbidden");

            if ($_SERVER["REQUEST_METHOD"] != "POST") die("forbidden");

            if (Helpers::is_missing("team_code", "msg_content")) die("forbidden");

            $team_code = $_POST["team_code"];
            $msg_content = trim($_POST["msg_content"]);

            if (Helpers::is_empty($team_code, $msg_content)) die("All fields are required!");

            NotificationModel::send_custom_message($team_code, $msg_content);

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