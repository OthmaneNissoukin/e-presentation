<?php

    class PresentationModel {
        static function connection() {
            $username = "root";
            $password = "";
            $host = "localhost";
            $dbname = "e-presentations";
            $dsn = "mysql:host=$host;dbname=$dbname";

            try {
                return new PDO($dsn, $username, $password);
            } catch (PDOException $err) {
                echo "<div class='alert alert-danger'>Database connection couldn't be established</div>";
                $err->getMessage();
            }
        }

        static function mentor_login($login, $password) {
            $connection = self::connection();

            $query = $connection->prepare("SELECT login, password FROM mentor WHERE login = :login AND password = :password");
            $query->execute([":login" => $login, ":password" => $password]);
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        static function save_team($team_code, $group, $presentation_date, $presentation_time) {
            $connection = self::connection();

            $request = $connection->prepare("INSERT INTO team VALUES(:team_code, :group_code, :presentation_date, :presentation_time, DEFAULT)");

            $request->execute([
                ":team_code" => htmlspecialchars($team_code),
                ":group_code" => htmlspecialchars($group),
                ":presentation_date" => htmlspecialchars($presentation_date),
                ":presentation_time" => htmlspecialchars($presentation_time),
            ]);
        }

        static function retrieve_teams_data($team_code) {
            // Used for filling update layout
            // Used for teams authentication
            $connection = self::connection();
            $query = $connection->prepare("SELECT * FROM team  WHERE team_code = :team_code");
            $query->execute([":team_code" => $team_code]);
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        static function retrieve_groups() {
            // This is for filling groups datalist options
            $connection = self::connection();
            $query = $connection->query("SELECT DISTINCT group_code FROM team");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        static function retrieve_all_teams() {
            $connection = self::connection();
            $query = $connection->query("SELECT * FROM team ORDER BY presentation_date, presentation_time");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        static function save_team_changes($team_code, $group, $presentation_date, $presentation_time) {

            $connection = self::connection();
            $request = $connection->prepare("
                UPDATE team SET group_code = :group_code, presentation_date = :presentation_date, presentation_time = :presentation_time 
                WHERE team_code = :team_code
                ");

            $request->execute([
                ":team_code" => htmlspecialchars($team_code),
                ":group_code" => htmlspecialchars($group),
                ":presentation_date" => htmlspecialchars($presentation_date),
                ":presentation_time" => htmlspecialchars($presentation_time)
            ]);
        }

        static function update_password($trainee_id, $trainee_password) {
            $connection = self::connection();

            $request = $connection->prepare("
                UPDATE trainee SET trainee_password = :trainee_password, status = 'active'
                WHERE trainee_id = :trainee_id");

            $request->execute([
                ":trainee_id" => htmlspecialchars($trainee_id),
                ":trainee_password" => $trainee_password,
            ]);
        }

        static function send_custom_message($team_code, $msg_content) {

            $connection = self::connection();

            $request = $connection->prepare("
                INSERT INTO notification(team_code, msg_content) VALUES
                (:team_code, :msg_content)");

            $request->execute([
                ":team_code" => htmlspecialchars($team_code),
                ":msg_content" => htmlspecialchars($msg_content),
            ]);

        }

        static function retrieve_team_messages($team_code) {
            $connection = self::connection();
            $query = $connection->prepare("SELECT * FROM notification
                WHERE team_code = :team_code
                ORDER BY sent_time DESC");

            $query->execute([":team_code" => $team_code]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }


        static function change_message_status($team_code) {
            $connection = self::connection();

            $request = $connection->prepare("
                UPDATE notification SET status = 'Read'
                WHERE team_code = :team_code");

            $request->execute([":team_code" => htmlspecialchars($team_code)]);
        }

        static function update_team_status($team_code, $status) {
            $connection = self::connection();

            $request = $connection->prepare("
                UPDATE team SET status = :Ready
                WHERE team_code = :team_code");

            $request->execute(
                [
                    ":Ready" => htmlspecialchars($status),
                    ":team_code" =>htmlspecialchars($team_code)
                ]);
        }

        static function fetch_teams_full_info() {
            $connection = self::connection();

            $request = $connection->prepare("
                SELECT team.team_code, GROUP_CONCAT(trainee.fullname) AS members, team.group_code, team.status 
                FROM team 
                INNER JOIN trainee 
                ON team.team_code = trainee.team_code 
                GROUP BY team.team_code;");

            $request->execute();
            return $request->fetchAll(PDO::FETCH_ASSOC);
        }

    }

?>