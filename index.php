<?php
    require "helpers/helper.php";
    require "helpers/files_helpers.php";
    require "model/team_model.php";
    require "model/file_model.php";
    require "model/notification_model.php";
    require "controller/layouts_rendering.php";
    require "controller/mentor.php";
    require "controller/team_controller.php";
    require "controller/files_controller.php";

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

            case "error_forbidden":
                LayoutRendering::forbidden();
                break;

            default:
                LayoutRendering::error_not_found();
                break;

        endswitch;
    } else {
        LayoutRendering::main();
    }

?>
