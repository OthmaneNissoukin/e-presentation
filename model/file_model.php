<?php

    class FileModel {

        static function retrieve_path($team_code, $file_type) {

            $connection = PresentationModel::connection();

            $query = $connection->prepare("SELECT * FROM files WHERE team_code = :team_code AND file_type = :file_type");
            $query->execute([":team_code" => $team_code, ":file_type" => $file_type]);

            return $query->fetch(PDO::FETCH_ASSOC);
        }


        static function insertPath($team_code, $path, $type, $uploader) {
            $connection = PresentationModel::connection();

            $delete = $connection->prepare("DELETE FROM files WHERE team_code = :team_code AND file_type = :file_type");
            $delete->execute([":team_code" => $team_code, ":file_type" => $type]);

            $insert = $connection->prepare("
                INSERT INTO files(team_code, file_path, file_type, uploader)
                VALUES(:team_code, :file_path, :file_type, :uploader)
            ");

            $insert->execute([
                ":team_code" => htmlspecialchars($team_code),
                ":file_path" => htmlspecialchars($path),
                ":file_type" => htmlspecialchars($type),
                ":uploader" => htmlspecialchars($uploader)
            ]);
        }

    }

?>