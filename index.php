<?php
    require "app/controller/helpers/helper.php";
    require "app/controller/helpers/files_helpers.php";
    require "app/model/team_model.php";
    require "app/model/trainee_model.php";
    require "app/model/file_model.php";
    require "app/model/notification_model.php";
    require "app/model/evaluation_model.php";
    require "app/controller/layouts_rendering.php";
    require "app/controller/mentor.php";
    require "app/controller/team_controller.php";
    require "app/controller/files_controller.php";
    require "app/controller/evaluation_controller.php";
    require "app/controller/notification_controller.php";

    require 'app/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
    $dotenv->load();

    if (isset($_GET["action"])) {

        switch ($_GET["action"]):
            case "team_login":
                LayoutRendering::team_login();
                break;

            case "team_homepage":
                LayoutRendering::team_homepage_layout();
                break;

            case "mentor_homepage":
                LayoutRendering::mentor_homepage_layout();
                break;

            case "team_info":
                LayoutRendering::team_info();
                break;
            
            case "all_presentations":
                LayoutRendering::all_presentations();
                break;
            
            case "all_teams":
                LayoutRendering::all_teams();
                break;

            case "register_layout":
                LayoutRendering::register_layout();
                break;

            case "update":
                LayoutRendering::update();
                break;

            case "activate_account_layout":
                LayoutRendering::activate_account_layout();
                break;
            
            case "contact":
                LayoutRendering::contact();
                break;

            case "messages":
                LayoutRendering::team_messages_box();
                break;
            
            case "upload":
                LayoutRendering::upload_layout();
                break;

            case "login_admin_layout":
                LayoutRendering::login_admin_layout();
                break;

            case "new_evaluation":
                LayoutRendering::new_evaluation();
                break;
            
            case "evaluation":
                LayoutRendering::evaluation();
                break;
            
            
            case "select_evaluation":
                LayoutRendering::select_evaluation();
                break;

            case "evaluation_result":
                LayoutRendering::evaluation_result();
                break;

            case "login_admin":
                MentorController::authenticate_admin();
                break;

            case "check":
                MentorController::create_team();
                break;
            
            case "save_team_updates":
                MentorController::save_team_update();
                break;
            
            case "send_message":
                MentorController::send_message();
                break;
            
            

            case "activate_account":
                TeamController::activate_account();
                break;
            
            
            case "authenticate_team":
                TeamController::authenticate_team();
                break;

            case "confirm_email":
                TeamController::activate_email();
                break;
            
            case "upload_application":
                FilesController::upload_application();
                break;

            case "upload_report":
                FilesController::upload_report();
                break;

            case "upload_presentation":
                FilesController::upload_presentation();
                break;
            
            
            case "team_sign_out":
                TeamController::team_sign_out();
                break;
            
            case "mentor_sign_out":
                MentorController::mentor_sign_out();
                break;

            case "create_evaluation":
                EvaluationController::create_evaluation();
                break;
            
            case "submit_evaluation":
                EvaluationController::submit_evaluation();
                break;

            case "check_evaluation":
                EvaluationController::check_evaluation();
                break;

            case "send_email":
                NotificationController::send_email();
                break;

            case "error_forbidden":
                LayoutRendering::forbidden();
                break;
            
            case "error_bad_request":
                LayoutRendering::bad_request();
                break;
            
            case "error_prediction_failed":
                LayoutRendering::prediction_failed();
                break;

            default:
                LayoutRendering::error_not_found();
                break;

        endswitch;
    } else {
        LayoutRendering::main();
    }

?>
