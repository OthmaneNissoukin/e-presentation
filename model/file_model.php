<?php

    class FileModel {

        static function team_files_intialization($team_code) {

            $connection = PresentationModel::connection();

            $query = $connection->prepare("INSERT INTO files(team_code) VALUES(:team_code)");
            $query->execute([":team_code" => $team_code]);
        }

        static function retrieve_files_info($team_code) {

            $connection = PresentationModel::connection();

            $query = $connection->prepare("SELECT * FROM files WHERE team_code = :team_code");
            $query->execute([":team_code" => $team_code]);

            return $query->fetch(PDO::FETCH_ASSOC);
        }


        static function insert_application($team_code, $application_path) {

            $connection = PresentationModel::connection();

            $query = $connection->prepare("
                UPDATE files
                SET application_path = :application_path
                WHERE team_code = :team_code
            ");

            $query->execute([
                ":team_code" => $team_code,
                ":application_path" => $application_path
            ]);
        }

        static function insert_report($team_code, $report_path) {

            $connection = PresentationModel::connection();

            $query = $connection->prepare("
                UPDATE files
                SET report_path = :report_path
                WHERE team_code = :team_code
            ");

            $query->execute([
                ":team_code" => $team_code,
                ":report_path" => $report_path
            ]);
        }

        static function insert_presentation($team_code, $presentation_path) {

            $connection = PresentationModel::connection();

            $query = $connection->prepare("
                UPDATE files
                SET presentation_path = :presentation_path
                WHERE team_code = :team_code
            ");

            $query->execute([
                ":team_code" => $team_code,
                ":presentation_path" => $presentation_path
            ]);
        }

    }

?>