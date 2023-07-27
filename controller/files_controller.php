<?php

    class FilesController {

        static function upload_files_intialization() {
            session_start();
            $team_code = $_SESSION["team_code"];
            $group_code = PresentationModel::retrieve_teams_data($team_code)["group_code"];

            FilesHelper::create_file_if_not_exist("uploads");
            FilesHelper::create_file_if_not_exist("uploads/$group_code" . "_" . $team_code);
            FilesHelper::create_file_if_not_exist("uploads/$group_code" . "_" . "$team_code");

            return ["team_code" => $team_code, "group_code" => $group_code];
        }

        
        static function upload_application() {
            // Uploading Application
            session_start();

            if ($_SERVER["REQUEST_METHOD"] != "POST") die(json_encode(["status" => "error", "message" => "Forbidden."]));

            if (Helpers::is_missing("repository_link", "ajax")) die(json_encode(["status" => "error", "message" => "Forbidden."]));


            $uploader_fullname = TraineeModel::get_trainee($_SESSION["user"])["fullname"];
            $repository_link = $_POST["repository_link"];

            FileModel::insertPath($_SESSION["team_code"], $repository_link, "application", $uploader_fullname);
            echo json_encode(["status" => "success", "message" => "Saved Successfully."]);
            TeamController::change_team_status();
            exit;
        }

        static function upload_report() {
            // Upload Report
            if ($_SERVER["REQUEST_METHOD"] != "POST") die(json_encode(["status" => "error", "message" => "Forbidden."]));

            if (!isset($_FILES["report"])) die(json_encode(["status" => "error", "message" => "Not Authorized."]));

            $folders_initialization = self::upload_files_intialization();

            $team_code = $folders_initialization["team_code"];
            $group_code = $folders_initialization["group_code"];

            $report_file = $_FILES["report"];

            if (empty(trim($report_file["name"]))) die("No file has been uploaded!");

            $presentation_mime = strtolower($report_file["type"]);

            if (!in_array($presentation_mime, ["application/pdf"])) {
                die(json_encode(["status" => "error", "message" => "Report extension be type of: PDF"]));
            }

            $report_target = "uploads/$group_code" . "_" . "$team_code/";

            $report_extension = pathinfo($report_file["name"])["extension"];

            // Deleting Files If Exists, In Case Of Update
            if (file_exists($report_target . "/Report.pdf")):
                FilesHelper::remove_file_if_exists($report_target . "Report.zip");
            endif;

            $ending_path = $report_target . "Report." . $report_extension;

            // Inserting New File
            if (move_uploaded_file($report_file["tmp_name"], $ending_path) ) {
                if (!isset($_SESSION)) {
                    session_start();
                }

                $uploader_fullname = TraineeModel::get_trainee($_SESSION["user"])["fullname"];

                FileModel::insertPath($team_code, $ending_path, "report", $uploader_fullname);
                echo json_encode(["status" => "success", "message" => "Report has been successfully saved!"]);
                TeamController::change_team_status();
                exit;
            } else {
                echo json_encode(["failed" => "success", "message" => "Report couldn't be saved! Please try again."]);
                die("File couldnt be saved! please try again.");
            }
        }
        
        static function upload_presentation() {
            // Upload Presentation
            
            if ($_SERVER["REQUEST_METHOD"] != "POST") die(json_encode(["status" => "error", "message" => "Forbidden"]));
            if (!isset($_FILES["presentation"])) die(json_encode(["status" => "error", "message" => "Not Authorized."]));
    
            $folders_initialization = self::upload_files_intialization();

            $team_code = $folders_initialization["team_code"];
            $group_code = $folders_initialization["group_code"];

            $presentation_file = $_FILES["presentation"];
            if (empty(trim($presentation_file["name"]))) die("No file has been uploaded!");

            $presentation_mime = strtolower($presentation_file["type"]);

            if (!in_array($presentation_mime, ["application/vnd.ms-powerpoint", 
                "application/vnd.openxmlformats-officedocument.presentationml.presentation"])): 
                die(json_encode(["status" => "error", "message" => "Presentation extension be type of: ppt / pptx"]));
            endif;

            $presentation_target = "uploads/$group_code" . "_" . "$team_code/";

            $presentation_extension = pathinfo($presentation_file["name"])["extension"];

            // Deleting Files If Exists, In Case Of Update
            if (file_exists($presentation_target . "/Presentation.pdf")):
                FilesHelper::remove_file_if_exists($presentation_target . "Presentation.zip");
            endif;

            $ending_path = $presentation_target . "Presentation." . $presentation_extension;

            // Inserting New File
            if (move_uploaded_file($presentation_file["tmp_name"], $ending_path) ) {
                if (!isset($_SESSION)) {
                    session_start();
                }
                $uploader_fullname = TraineeModel::get_trainee($_SESSION["user"])["fullname"];
                FileModel::insertPath($team_code, $ending_path, "presentation", $uploader_fullname);
                echo json_encode(["status" => "success", "message" => "Presentation has been successfully saved!"]);
                exit;
            } else {
                echo json_encode(["failed" => "success", "message" => "Presentation couldn't be saved! Please try again."]);
                TeamController::change_team_status();
                die("File couldnt be saved! please try again.");
            }

            
        }
    }

?>