<?php

    class LayoutRendering {

        static function team_login() {
            require "view/teams/team_login.php";
        }

        static function login_admin_layout() {
            require "view/mentor/mentor_login.php";
        }
        
        static function team_homepage_layout() {
            session_start();

            Helpers::redirect_if_not_authenticated("team_code", "team_login");

            $team_code = $_SESSION["team_code"];

            $team_data = PresentationModel::retrieve_teams_data($team_code);
            $team_members = TraineeModel::get_team_members($team_code);
            $active_user = TraineeModel::get_trainee($_SESSION["user"])["fullname"];

            $notification_data = NotificationModel::latest_presentation_update($team_code);

            $app_info = FileModel::retrieve_path($team_code, "application");
            $report_info = FileModel::retrieve_path($team_code, "report");
            $presentation_info = FileModel::retrieve_path($team_code, "presentation");

            // FIXME: Add the message to be shown as pop up modal notification

            if ($notification_data) $msg_content = $notification_data["msg_content"];
            

            require "view/teams/team_homepage.php";
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

            require "view/mentor/mentor_homepage.php";
        }

        static function register_layout() {
            session_start();

            Helpers::redirect_if_not_authenticated("admin", "login_admin");
            $groups = PresentationModel::retrieve_groups();
            require "view/mentor/register.php";
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

            require "view/mentor/update_team.php";
        }
            
        static function activate_account_layout() {
            session_start();

            Helpers::redirect_if_not_authenticated("team_code", "team_login");
            require "view/teams/activate_account.php";
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

            require "view/mentor/team_info.php";
        }
        
        static function all_presentations() {
            session_start();

            Helpers::redirect_if_not_authenticated("admin", "login_admin");
            $team_data = PresentationModel::retrieve_all_teams();

            require "view/mentor/all_presentations.php";
        }
        
        static function all_teams() {
            session_start();

            
            Helpers::redirect_if_not_authenticated("admin", "login_admin");
            $teams_data = PresentationModel::fetch_teams_full_info();
            
            if (isset($teams_data[0])) {
                $teams_data = is_null($teams_data[0]["team_code"]) ? [] : $teams_data;
            }
            

            require "view/mentor/all_teams.php";
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

            require "view/mentor/contact.php";
        }

        static function team_messages_box() {
            session_start();
            Helpers::redirect_if_not_authenticated("team_code", "team_login");

            $team_code = $_SESSION["team_code"];

            $team_messages = PresentationModel::retrieve_team_messages($team_code);

            $counter = 0;

            foreach($team_messages as $message):
                if (strtolower($message["status"]) == "unread") ++$counter;
            endforeach;

            require "view/teams/messages.php";
        }

        static function upload_layout() {
            session_start();
            Helpers::redirect_if_not_authenticated("team_code", "team_login");

            $team_code = $_SESSION["team_code"];

            $app_info = FileModel::retrieve_path($team_code, "application");
            $report_info = FileModel::retrieve_path($team_code, "report");
            $presentation_info = FileModel::retrieve_path($team_code, "presentation");

            require "view/teams/upload.php";
        }

        static function error_not_found() {
            require "view/errors/404.php";
        }

        static function forbidden() {
            require "view/errors/403.php";
        }
        
        static function main() {
            $title = "Main page";
            $content = file_get_contents("view/main_page.html");
            require "view/master.php";
        }

        static function new_evaluation() {
            Helpers::redirect_if_not_authenticated("admin", "login_admin_layout");
            $title = "Create evaluation";
            $content = file_get_contents("view/mentor/new_evaluation.html");
            require "view/master.php";
        }
        
        static function evaluation() {
            Helpers::redirect_if_not_authenticated("admin", "login_admin_layout");

            $questions = EvaluationModel::get_evaluation();

            $report_questions = array_filter($questions, fn($item) => $item["question_topic"] == "report");
            $presentation_questions = array_filter($questions, fn($item) => $item["question_topic"] == "presentation");

            // $team_members = TraineeModel::get_team_members("9765"); // 3 Members
            $team_members = TraineeModel::get_team_members("0616"); // 2 Members
            // $team_members = TraineeModel::get_team_members("5522"); // 1 Member

            $team_group = PresentationModel::retrieve_teams_data("0616");

            require "view/mentor/evaluation.php";
        }
    }