<?php
    $title = "Evaluation";

    ob_start();
?>

<h2 class="border-bottom border-danger border-3 pb-3 mb-4">Evaluation</h2>

<div class="alert alert-danger d-none" id="alert_box"></div>

<form action="index.php?action=submit_evaluation" method="post">
    <h4 class="border-bottom border-primary border-3 pb-3">Report questions</h4>
    <table class="table table-bordered border-secondary">
        <thead>
            <th class="w-50">Question</th>

            <?php foreach($team_members as $member): ?>
                <th><?= $member['fullname'] ?></th>
            <?php endforeach; ?>
        </thead>

        <tbody id="report_table">

            <?php 
                foreach($report_questions as $question):
            ?>
                <tr>
                    <td>
                        <input type="hidden" data-report="question" name="question_scale[]" value="<?= $question["question_scale"] ?>"/>
                        <p><?= $question['question_content'] ?></p>
                    </td>
                    
                    <?php foreach($team_members as $member):?>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control" name="answer[<?= $member['trainee_id'] ?>][<?= $question['question_code'] ?>]" data-max-value="<?= $question['question_scale'] ?>" />
                                <span class="input-group-text" id="basic-addon2">/ <?= $question["question_scale"] ?></span>
                            </div>
                        </td>
                        
                    <?php endforeach; ?>
                </tr>

            <?php
                endforeach;
            ?>

        </tbody>
    </table>

    <h4 class="border-bottom border-primary border-3 pb-3">Presentation questions</h4>
    <table class="table table-bordered border-secondary">
        <thead>
            <th class="w-50">Question</th>
            <?php foreach($team_members as $member): ?>
                <th><?= $member['fullname'] ?></th>
            <?php endforeach; ?>
            
        </thead>

        <tbody id="presentation_table">

            <?php 
                foreach($presentation_questions as $question):
            ?>
                <tr>
                    <td>
                        <input type="hidden" data-report="question" name="question_scale[]" value="<?= $question["question_scale"] ?>"/>
                        <p><?= $question['question_content'] ?></p>
                    </td>

                    <?php foreach($team_members as $member):?>
                        <td>
                            <div class="input-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="answer[<?= $member['trainee_id'] ?>][<?= $question['question_code'] ?>]"
                                    data-max-value="<?= $question['question_scale'] ?>"
                                />
                                <span class="input-group-text" id="basic-addon2">/ <?= $question["question_scale"] ?></span>
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <input type="submit" value="Save" class="btn btn-primary btn-lg d-block m-auto w-25 rounded-0" />
</form>

<?php
    $content = ob_get_contents();
    ob_get_clean();

    require "view/master.php";
?>
