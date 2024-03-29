<?php

    class LayoutRendering {

        static function team_login() {
            if (!isset($_SESSION)) session_start();

            if (isset($_SESSION["user"]) && isset($_SESSION["team_code"])) {
                header("location: index.php?action=team_homepage");
                exit;
            }
            require "app/view/teams/team_login.php";
        }

        static function login_admin_layout() {
            if (!isset($_SESSION)) session_start();

            if (isset($_SESSION["admin"])) {
                header("location: index.php?action=mentor_homepage");
                exit;
            }

            require "app/view/mentor/mentor_login.php";
        }
        
        static function team_homepage_layout() {
            session_start();

            Helpers::redirect_if_not_authenticated("team_code", "team_login");

            $team_code = $_SESSION["team_code"];
            $current_user = $_SESSION["user"];

            if(!TeamController::is_active_trainee($current_user)) {
                header("location: index.php?action=activate_account_layout");
                exit();
            }

            $team_data = PresentationModel::retrieve_teams_data($team_code);
            $team_members = TraineeModel::get_team_members($team_code);
            $active_user = TraineeModel::get_trainee($current_user)["fullname"];

            $notification_data = NotificationModel::latest_presentation_update($team_code);

            $app_info = FileModel::retrieve_path($team_code, "application");
            $report_info = FileModel::retrieve_path($team_code, "report");
            $presentation_info = FileModel::retrieve_path($team_code, "presentation");

            // FIXME: Add the message to be shown as pop up modal notification

            if ($notification_data) $msg_content = $notification_data["msg_content"];
            

            require "app/view/teams/team_homepage.php";
        }
        
        static function mentor_homepage_layout() {
            session_start();

            Helpers::redirect_if_not_authenticated("admin", "login_admin");

            $presentations = PresentationModel::retrieve_all_teams();

            $inactive_accounts = 0;
            $presentations_done = 0;
            $presentations_left = 0;

            foreach($presentations as $presentation):
                if (strtolower($presentation["status"]) == "inactivated"):
                    ++$inactive_accounts;
                    ++$presentations_left;
                elseif (strtolower($presentation["status"]) == "done"):
                    ++$presentations_done;
                else:
                    ++$presentations_left;
                endif;
            endforeach;

            require "app/view/mentor/mentor_homepage.php";
        }

        static function register_layout() {
            session_start();

            Helpers::redirect_if_not_authenticated("admin", "login_admin");
            $groups = PresentationModel::retrieve_groups();
            require "app/view/mentor/register.php";
        }
        
        static function update() {
            session_start();

            Helpers::redirect_if_not_authenticated("admin", "login_admin");
            if (Helpers::is_missing("team_code"));

            $team_code = $_REQUEST["team_code"];
            $_SESSION["team_to_update"] = $team_code;
            $data = PresentationModel::retrieve_teams_data($team_code);
            $team_members = TraineeModel::get_team_members($team_code);

            $_SESSION["trainee_1"] = isset($team_members[0]) ? $team_members[0]["fullname"] : null;
            $_SESSION["trainee_2"] = isset($team_members[1]) ? $team_members[1]["fullname"] : null;
            $_SESSION["trainee_3"] = isset($team_members[2]) ? $team_members[2]["fullname"] : null;

            require "app/view/mentor/update_team.php";
        }
            
        static function activate_account_layout() {
            session_start();

            if (!$_SESSION["user"]) {
                header("location: index.php?action=team_login");
                exit;
            }
            $trainee_id = $_SESSION["user"];

            if (TeamController::is_active_trainee($trainee_id)) {
                header("location: index.php?action=team_homepage");
                exit;
            }

            Helpers::redirect_if_not_authenticated("team_code", "team_login");
            require "app/view/teams/activate_account.php";
        }
        
        
        static function team_info() {
            // TODO: Add query string validations
            session_start();

            Helpers::redirect_if_not_authenticated("admin", "login_admin");

            $team_code = $_GET["team_code"];

            $team_info = PresentationModel::retrieve_teams_data($team_code);
            $team_members = TraineeModel::get_team_members($team_code);

            $app_info = FileModel::retrieve_path($team_code, "application");
            $report_info = FileModel::retrieve_path($team_code, "report");
            $presentation_info = FileModel::retrieve_path($team_code, "presentation");

            require "app/view/mentor/team_info.php";
        }
        
        static function all_presentations() {
            session_start();

            Helpers::redirect_if_not_authenticated("admin", "login_admin");
            $team_data = PresentationModel::retrieve_all_teams();

            require "app/view/mentor/all_presentations.php";
        }
        
        static function all_teams() {
            session_start();

            
            Helpers::redirect_if_not_authenticated("admin", "login_admin");
            $teams_data = PresentationModel::fetch_teams_full_info();
            
            if (isset($teams_data[0])) {
                $teams_data = is_null($teams_data[0]["team_code"]) ? [] : $teams_data;
            }
            

            require "app/view/mentor/all_teams.php";
        }

        static function contact() {
            session_start();

            Helpers::redirect_if_not_authenticated("admin", "login_admin");

            $team_code = null;
            if (isset($_GET["team_code"])):
                if (!empty($_GET["team_code"])) {
                    $team_code = $_GET["team_code"];
                }
            endif;

            $teams_data = PresentationModel::retrieve_all_teams();

            require "app/view/mentor/contact.php";
        }

        static function team_messages_box() {
            session_start();
            Helpers::redirect_if_not_authenticated("team_code", "team_login");

            $team_code = $_SESSION["team_code"];
            $current_user = $_SESSION["user"];

            if(!TeamController::is_active_trainee($current_user)) {
                header("location: index.php?action=activate_account_layout");
                exit();
            }

            $team_messages = NotificationModel::retrieve_team_messages($team_code);

            $counter = 0;

            // echo "<pre>";
            // var_dump($team_code);
            // echo "<pre>";

            foreach($team_messages as $message):
                if (strtolower($message["status"]) == "unread") ++$counter;
            endforeach;

            require "app/view/teams/messages.php";
        }

        static function upload_layout() {
            session_start();
            Helpers::redirect_if_not_authenticated("team_code", "team_login");

            $team_code = $_SESSION["team_code"];
            $current_user = $_SESSION["user"];

            if(!TeamController::is_active_trainee($current_user)) {
                header("location: index.php?action=activate_account_layout");
                exit();
            }

            $app_info = FileModel::retrieve_path($team_code, "application");
            $report_info = FileModel::retrieve_path($team_code, "report");
            $presentation_info = FileModel::retrieve_path($team_code, "presentation");

            require "app/view/teams/upload.php";
        }

        
        
        static function main() {
            if (!isset($_SESSION)) session_start();

            if (isset($_SESSION["admin"])) {
                header("location: index.php?action=mentor_homepage");
                exit;
            } elseif(isset($_SESSION["user"]) && isset($_SESSION["team_code"])) {
                header("location: index.php?action=team_homepage");
                exit;
            }

            $title = "Main page";
            $styles = [];
            $content = file_get_contents("app/view/main_page.html");
            require "app/view/master.php";
        }

        static function new_evaluation() {
            Helpers::redirect_if_not_authenticated("admin", "login_admin_layout");
            $title = "Create evaluation";
            $styles = [];
            $content = file_get_contents("app/view/mentor/new_evaluation.html");
            require "app/view/master.php";
        }
        
        static function evaluation() {
            Helpers::redirect_if_not_authenticated("admin", "login_admin_layout");

            if (!isset($_POST["team_code"]) or !isset($_POST["evaluation_code"])) {
                header("location: index.php?action=error_forbidden");
                exit;
            }

            $team_code = $_POST["team_code"];
            $evaluation_code = $_POST["evaluation_code"];
            $team_group = PresentationModel::retrieve_teams_data($team_code);

            if (!trim($team_code) or !$team_group) {
                header("location: index.php?action=error_unauthorized");
                exit;
            }


            $questions = EvaluationModel::get_evaluation($evaluation_code);

            $report_questions = array_filter($questions, fn($item) => $item["question_topic"] == "report");
            $presentation_questions = array_filter($questions, fn($item) => $item["question_topic"] == "presentation");

            $team_members = TraineeModel::get_team_members($team_code);


            require "app/view/mentor/evaluation.php";
        }

        static function select_evaluation() {
            $all_evaluations = EvaluationModel::get_all_evaluations();

            $team_code = $_GET["team_code"];

            $team_data = PresentationModel::retrieve_teams_data($team_code);
            $team_has_passed = false;
            if ($team_data) {
                if (strtolower($team_data['status']) == "done") $team_has_passed = true;
            }

            require "app/view/mentor/select_evaluation.php";
        }

        static function evaluation_result() {
            Helpers::redirect_if_not_authenticated("user", "team_login");

            if (!isset($_SESSION)) session_start();
            $trainee_id = $_SESSION["user"];

            if(!TeamController::is_active_trainee($trainee_id)) {
                header("location: index.php?action=activate_account_layout");
                exit();
            }
            $result = EvaluationModel::get_result($trainee_id);
            require "app/view/teams/result.php";
        }

        static function request_reset_layout() {
            $title = "Request password reset";
            $styles = ["css/login_page.css"];
            $content = file_get_contents("app/view/teams/reset_form.html");
            require "app/view/master.php";
        }
        
        static function reset_pwd_layout() {
            $title = "Reset password";
            $styles = ["css/login_page.css"];
            $content = file_get_contents("app/view/teams/new_password_form.html");
            require "app/view/master.php";
        }

        static function error_not_found() {
            require "app/view/errors/404.php";
        }

        static function forbidden() {
            require "app/view/errors/403.php";
        }
        
        static function bad_request() {
            require "app/view/errors/400.php";
        }
        
        static function unauthorized() {
            require "app/view/errors/401.php";
        }

    }