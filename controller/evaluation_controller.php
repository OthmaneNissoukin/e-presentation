<?php
class EvaluationController {
    static function create_evaluation() {
        Helpers::redirect_if_not_authenticated("admin", "login_admin_layout");

        if ($_SERVER["REQUEST_METHOD"] != "POST"):
            if (isset($_POST["ajax"])) {
                die(json_encode(["status" => "error", "message" => "forbidden"]));
            } else {
                header('location: index.php?action=error_forbidden');
                exit;
            }
        endif;

        if (Helpers::is_missing("presentation_question", "report_question")) die(json_encode(["status" => "error", "message" => "method not allowed"]));

        $report_questions_info = $_POST["report_question"]; // Array
        $presentation_questions_info = $_POST["presentation_question"]; // Array

        if (isset($_POST["ajax"])) {
            $report_questions_info = json_decode($report_questions_info, true);
            $presentation_questions_info = json_decode($presentation_questions_info, true);
        }

        if (!(isset($report_questions_info["description"]) && 
                isset($report_questions_info["scale"]) &&
                isset($presentation_questions_info["description"]) &&
                isset($presentation_questions_info["scale"]))
            ) die(json_encode(["status" => "error", "message" => "method not allowed"]));
        
        // Securing submitted data if the user removed one of the inputs from the DOM
        if (count($report_questions_info["description"]) !== count($report_questions_info["scale"])) die("Bad request");
        if (count($presentation_questions_info["description"]) !== count($presentation_questions_info["scale"])) die("Bad request");

        if (Helpers::is_empty_field($report_questions_info, "description")) die(json_encode(["status" => "invalid", "message" => "empty report question!"]));
        if (Helpers::is_empty_field($report_questions_info, "scale")) die(json_encode(["status" => "invalid", "message" => "empty report scale!"]));

        if (Helpers::is_empty_field($presentation_questions_info, "description")) die(json_encode(["status" => "invalid", "message" => "empty presentation question!"]));
        if (Helpers::is_empty_field($presentation_questions_info, "scale")) die(json_encode(["status" => "invalid", "message" => "empty presentation scale!"]));


        if (Helpers::is_not_nums(array_merge($report_questions_info["scale"], $presentation_questions_info["scale"]))) {
                die(json_encode(["status" => "invalid", "message" => "scale must be a number!"]));
            };

        // Generate evaluation code
        $evaluation_code =  rand(0, 999);
        settype($evaluation_code, "string");
        $evaluation_code = str_pad($evaluation_code, 3, "0", STR_PAD_LEFT);
        $evaluation_code = "E-" . $evaluation_code;

        EvaluationModel::create_evaluation($evaluation_code, $report_questions_info["description"], $report_questions_info["scale"], "report");
        EvaluationModel::create_evaluation($evaluation_code, $presentation_questions_info["description"], $presentation_questions_info["scale"], "presentation");
        
        if (isset($_POST["ajax"])) {
            die(json_encode(["status" => "success", "message" => "evaluation has been created successfully!"]));
        } else {
            header("location: index.php?action=mentor_homepage");
            exit;
        }

    }

    static function submit_evaluation() {
        Helpers::redirect_if_not_authenticated("admin", "login_admin_layout");

        if (isset($_POST["ajax"])) :
            $traines_id = array_keys(json_decode($_POST["answer"], true));
            $scales = json_decode($_POST["question_scale"]);

            $_POST["answer"] = json_decode($_POST["answer"], true);
            $_POST["question_scale"] = json_decode($_POST["question_scale"], true);
        else: 
            $traines_id = array_keys($_POST["answer"]);
            $scales = $_POST["question_scale"];
        endif;


        if (isset(json_encode($_POST["answer"], true)[$traines_id[0]])) {
            $trainee_1_scores = $_POST["answer"][$traines_id[0]];
            if (Helpers::is_not_nums($trainee_1_scores)) die(json_encode(["status" => "invalid", "message" => "Score must be a number!"]));
            if (Helpers::score_not_in_range($trainee_1_scores, $scales)) die(json_encode(["status" => "invalid", "message" => "Score is out of range!"]));
        } else die(json_encode(["status" => "error", "message" => "forbidden"]));

        
        if (isset($traines_id[1])) {
            $trainee_2_scores = $_POST["answer"][$traines_id[1]];

            if (Helpers::is_not_nums($trainee_2_scores)) die(json_encode(["status" => "invalid", "message" => "Score must be a number!"]));
            if (Helpers::score_not_in_range($trainee_2_scores, $scales)) die(json_encode(["status" => "invalid", "message" => "Score is out of range!"]));

        }
        
        if (isset($traines_id[2])) {
            $trainee_3_scores = $_POST["answer"][$traines_id[2]];
            if (Helpers::is_not_nums($trainee_3_scores)) die(json_encode(["status" => "invalid", "message" => "Score must be a number!"]));
            if (Helpers::score_not_in_range($trainee_3_scores, $scales)) die(json_encode(["status" => "invalid", "message" => "Score is out of range!"]));
        }

        // Inserting results
        if (isset($traines_id[0])) {
            $trainee_1 = $traines_id[0];
            EvaluationModel::submit_result($trainee_1, $trainee_1_scores);
        }

        if (isset($traines_id[1])) {
            $trainee_2 = $traines_id[1];
            EvaluationModel::submit_result($trainee_2, $trainee_2_scores);
        }

        if (isset($traines_id[2])) {
            $trainee_3 = $traines_id[2];
            EvaluationModel::submit_result($trainee_3, $trainee_3_scores);
        }

        echo json_encode(["status" => "success", "message" => "Evaluation has been submitted successfully!"]);

        if (!isset($_POST["ajax"])) {
            header("location: index.php?action=mentor_hompage");
            exit;
        }
    }
}
