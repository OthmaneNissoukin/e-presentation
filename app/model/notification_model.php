<?php
    class NotificationModel {

        static function send_custom_message($team_code, $msg_content, $msg_object="From admin") {

            $connection = PresentationModel::connection();

            $request = $connection->prepare("
                INSERT INTO notification(team_code, msg_content, msg_object) VALUES
                (:team_code, :msg_content, :msg_object)");

            $request->execute([
                ":team_code" => htmlspecialchars($team_code),
                ":msg_content" => htmlspecialchars($msg_content),
                ":msg_object" => htmlspecialchars($msg_object)
            ]);
        }

        static function retrieve_team_messages($team_code) {
            $connection = PresentationModel::connection();
            $query = $connection->prepare("SELECT * FROM notification
                WHERE team_code = :team_code
                ORDER BY sent_time DESC");

            $query->execute([":team_code" => $team_code]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }


        static function change_message_status($team_code) {
            $connection = PresentationModel::connection();

            $request = $connection->prepare("
                UPDATE notification SET status = 'Read'
                WHERE team_code = :team_code");

            $request->execute([":team_code" => htmlspecialchars($team_code)]);
        }

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