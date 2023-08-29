<?php

    class TraineeModel {
        static function login_trainee($trainee_login, $password) {
            $connection = PresentationModel::connection();

            $query = $connection->prepare("
                SELECT * FROM trainee 
                WHERE trainee_login = :trainee_login AND trainee_password = :trainee_password");

            $query->execute([":trainee_login" => $trainee_login, ":trainee_password" => $password]);

            return $query->fetch(PDO::FETCH_ASSOC);
        }

        static function get_team_members($team_code) {
            $connection = PresentationModel::connection();

            $query = $connection->prepare("
                SELECT * FROM trainee 
                WHERE team_code = :team_code");

            $query->execute([":team_code" => $team_code]);

            return $query->fetchALL(PDO::FETCH_ASSOC);
        }

        static function delete_trainee($team_code, $fullname) {
            $connection = PresentationModel::connection();

            $query = $connection->prepare("
                DELETE FROM trainee WHERE fullname = :fullname AND team_code = :team_code
            ");

            $query->execute([":fullname" => $fullname, ":team_code" => $team_code]);
        }

        static function update_trainee($team_code, $new_value, $old_value) {
            $connection = PresentationModel::connection();

            $query = $connection->prepare("
                UPDATE trainee SET fullname = :new_fullname WHERE fullname = :old_fullname AND team_code = :team_code
            ");

            $query->execute([
                ":new_fullname" => htmlspecialchars($new_value),
                ":old_fullname" => htmlspecialchars($old_value),
                ":team_code" => htmlspecialchars($team_code)
                ]);
        }

        static function create_trainee($team_code, $fullname) {
            $connection = PresentationModel::connection();

            $random_login = array_merge(range("a","z"), range("A","Z"), range(0,9));
            shuffle($random_login);
            $random_login = implode("", array_slice($random_login, 0, 6));

            $query = $connection->prepare("
                INSERT INTO trainee VALUES(NULL, :team_code, :fullname, :login, 'azerty123', DEFAULT)
            ");

            $query->execute([
                ":fullname" => htmlspecialchars($fullname), 
                ":team_code" => htmlspecialchars($team_code), 
                ":login" => htmlspecialchars($random_login)
            ]);
        }

        static function get_trainee($trainee_id) {
            $connection = PresentationModel::connection();

            $query = $connection->prepare("SELECT * FROM trainee WHERE trainee_id = :trainee_id");

            $query->execute([":trainee_id" => $trainee_id]);

            return $query->fetch(PDO::FETCH_ASSOC);
        }

        static function get_activating_info($trainee_id) {
            $connection = PresentationModel::connection();

            $query = $connection->prepare("SELECT * FROM accounts_to_activate WHERE trainee_id = :trainee_id");

            $query->execute([":trainee_id" => $trainee_id]);

            return $query->fetch(PDO::FETCH_ASSOC);
        }

        static function activate_trainee($trainee_id, $email) {
            $connection = PresentationModel::connection();

            $query = $connection->prepare("
                UPDATE trainee SET email = :email, status = 'active' WHERE trainee_id = :trainee_id
            ");

            $query->execute([
                ":trainee_id" => $trainee_id,
                ":email" => $email,
                ]);
        }

        static function delete_trainee_token($trainee_id) {
            $connection = PresentationModel::connection();

            $delete_query = $connection->prepare("DELETE FROM accounts_to_activate WHERE trainee_id = :trainee_id");
            $delete_query->execute([":trainee_id" => $trainee_id]);
        }

        static function get_trainee_by_email($email) {
            $connection = PresentationModel::connection();

            $query = $connection->prepare("SELECT * FROM trainee WHERE email = :email AND status='active'");

            $query->execute([":email" => $email]);

            return $query->fetch(PDO::FETCH_ASSOC);
        }

    }