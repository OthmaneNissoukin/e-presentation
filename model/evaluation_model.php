<?php

    class EvaluationModel {
        static function create_evaluation($evaluation_code, $questions, $scales, $topic) {
            $connection = PresentationModel::connection();
            
            for($i = 0; $i < count($questions); $i++) {
                $insert = $connection->prepare("INSERT INTO evaluation VALUES(
                    :evaluation_code,
                    NULL,
                    :question_content,
                    :question_scale,
                    :question_topic,
                    YEAR(CURRENT_DATE)
                )");

                $insert->execute(
                    [
                        ":evaluation_code" => $evaluation_code,
                        ":question_content" => $questions[$i],
                        ":question_scale" => $scales[$i],
                        ":question_topic" => $topic
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

            foreach($array_scores as $question_code => $score):

                $insert = $connection->prepare("INSERT INTO result VALUES(
                    NULL,
                    :question_code,
                    :trainee_id,
                    :grade
                )");

                $insert->execute([
                    ":question_code" => $question_code,
                    ":trainee_id" => $trainee_id,
                    ":grade" => $score
                ]);

            endforeach;

            // $insert = $connection
        }
    }