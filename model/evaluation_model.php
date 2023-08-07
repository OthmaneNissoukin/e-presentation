<?php

    class EvaluationModel {
        static function create_evaluation($evaluation_code, $questions, $scales, $topic) {
            $connection = PresentationModel::connection();
            
            for($i = 0; $i < count($questions); $i++) {

                // Generate question code
                while (true) {
                    $question_code =  rand(0, 999);
                    settype($question_code, "string");
                    $question_code = str_pad($question_code, 3, "0", STR_PAD_LEFT);
                    $question_code = "Q-" . $question_code;
                    
                    // Checking if the generated question code is available to use primary key
                    $is_question_code_exists = self::get_question($question_code);

                    if (!$is_question_code_exists) break;
                }

                $insert = $connection->prepare("INSERT INTO evaluation VALUES(
                    :evaluation_code,
                    :question_code,
                    :question_content,
                    :question_scale,
                    :question_topic,
                    YEAR(CURRENT_DATE)
                )");

                $insert->execute(
                    [
                        ":evaluation_code" => $evaluation_code,
                        ":question_code" => $question_code,
                        ":question_content" => htmlspecialchars($questions[$i]),
                        ":question_scale" => filter_var($scales[$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                        ":question_topic" => htmlspecialchars($topic)
                    ]
                    );
            }
        }

        static function get_evaluation($evaluation_code) {
            $connection = PresentationModel::connection();
            
            $select = $connection->prepare("SELECT * FROM evaluation WHERE evaluation_code = :evaluation_code");
            $select->execute([":evaluation_code" => $evaluation_code]);

            return $select->fetchAll(PDO::FETCH_ASSOC);
        }

        static function get_all_evaluations() {
            $connection = PresentationModel::connection();
            
            $select = $connection->query("SELECT * FROM evaluation GROUP BY evaluation_code");

            return $select->fetchAll(PDO::FETCH_ASSOC);
        }

        static function submit_result($trainee_id, $array_scores) {
            $connection = PresentationModel::connection();

            // Delete previous results when repassing exam for this member
            $delete = $connection->prepare("DELETE FROM result WHERE trainee_id = :trainee_id");
            $delete->execute([":trainee_id" => $trainee_id]);

            foreach($array_scores as $question_code => $score):

                $insert = $connection->prepare("INSERT INTO result VALUES(
                    NULL,
                    :trainee_id,
                    :grade,
                    :question_code
                )");

                $insert->execute([
                    ":trainee_id" => htmlspecialchars($trainee_id),
                    ":grade" => filter_var($score, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    ":question_code" => htmlspecialchars($question_code),
                ]);

            endforeach;

        }

        static function get_result($trainee_code) {
            $connection = PresentationModel::connection();

            $select = $connection->prepare("
                SELECT * FROM result JOIN evaluation ON result.question_code = evaluation.question_code
                WHERE trainee_id = :trainee_id
            ");

            $select->execute(["trainee_id" => $trainee_code]);
            return $select->fetchAll(PDO::FETCH_ASSOC);
        }

        static function get_question($question_code) {
            $connection = PresentationModel::connection();

            $select = $connection->prepare("
                SELECT * FROM evaluation WHERE question_code = :question_code
            ");

            $select->execute(["question_code" => $question_code]);
            return $select->fetch(PDO::FETCH_ASSOC);
        }
    }