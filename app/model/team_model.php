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
                UPDATE trainee SET trainee_password = :trainee_password
                WHERE trainee_id = :trainee_id");

            $request->execute([
                ":trainee_id" => htmlspecialchars($trainee_id),
                ":trainee_password" => $trainee_password,
            ]);
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

        static function store_token($trainee_id, $email, $random_token) {
            $connection = self::connection();

            $delete_query = $connection->prepare("DELETE FROM accounts_to_activate WHERE trainee_id = :trainee_id");
            $delete_query->execute([":trainee_id" => $trainee_id]);

            $request = $connection->prepare("INSERT INTO accounts_to_activate VALUES(NULL, :trainee_id, :email, :random_token)");

            $request->execute([
                ":trainee_id" => $trainee_id,
                ":email" => $email,
                ":random_token" => $random_token
            ]);
        }

        static function save_pwd_reset_request($trainee_id, $email, $hashed_token) {
            $connection = self::connection();

            $delete_query = $connection->prepare("DELETE FROM reset_pwd_requests WHERE email = :email");
            $delete_query->execute([":email" => $email]);

            $request = $connection->prepare("INSERT INTO reset_pwd_requests VALUES(NULL, :trainee_id, :email, :hashed_token)");

            $request->execute([
                ":trainee_id" => $trainee_id,
                ":email" => $email,
                ":hashed_token" => $hashed_token
            ]);
        }

        static function get_reseting_info($trainee_id) {
            $connection = PresentationModel::connection();

            $query = $connection->prepare("SELECT * FROM reset_pwd_requests WHERE trainee_id = :trainee_id");

            $query->execute([":trainee_id" => $trainee_id]);

            return $query->fetch(PDO::FETCH_ASSOC);
        }

        static function update_trainee_password($trainee_id, $new_password) {
            $connection = self::connection();

            $request = $connection->prepare("
                UPDATE trainee SET trainee_password = :new_password
                WHERE trainee_id = :trainee_id");

            $request->execute(
                [
                    ":trainee_id" => $trainee_id,
                    ":new_password" => $new_password
                ]);
        }

        static function delete_reset_token($trainee_id) {
            $connection = self::connection();

            $delete_query = $connection->prepare("DELETE FROM reset_pwd_requests WHERE trainee_id = :trainee_id");
            $delete_query->execute([":trainee_id" => $trainee_id]);

        }

    }

?>