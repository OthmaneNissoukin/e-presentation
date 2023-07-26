<?php
    class NotificationModel {

        static function latest_presentation_update($team_code) {
            $connection = PresentationModel::connection();

            $query = $connection->prepare("SELECT * FROM notification 
                    WHERE team_code = :team_code
                    AND msg_object = 'Update'
                    ");
            $query->execute([":team_code" => $team_code]);

            return $query->fetch(PDO::FETCH_ASSOC);
        }

    }