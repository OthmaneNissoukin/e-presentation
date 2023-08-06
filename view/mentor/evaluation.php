<?php
    $title = "Evaluation";

    ob_start();
?>

<h2 class="border-bottom border-danger border-3 pb-3 mb-4">Evaluation</h2>

<section class="d-flex justify-content-between">
    <table class="w-25 table table-bordered border-3">
        <thead>
            <th class="w-25">Evaluation</th>
            <th class="w-25">Team</th>
            <th>Group</th>
            <th>Season</th>
        </thead>
        <tr>
            <td>E-945</td>
            <td>5412</td>
            <td>DEV108</td>
            <td>2022/2023</td>
        </tr>
    </table>

    <div class="d-flex w-75 h-25">
        <div class="d-flex justify-content-between">
            <button class="btn w-50 rounded-0 btn-success"><i class="bi bi-caret-right-fill"></i>Start</button>
            <button class="btn w-50 rounded-0 btn-warning"><i class="bi bi-pause-fill"></i>Pause</button>
            <button class="btn w-50 rounded-0 btn-danger"><i class="bi bi-stop-fill"></i>Stop</button>
        </div>
        <div class="bg-secondary w-50 bg-opacity-25 d-flex px-2 align-items-center justify-content-center fs-4">
            <i class="bi bi-circle-fill fs-4 mx-2 text-danger"></i> 15:30
        </div>
    </div>
</section>

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
                                <span class="input-group-text" id="basic-addon1">/ <?= $question["question_scale"] ?></span>
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

<script src="scripts/evaluation.js"></script>

<?php
    $content = ob_get_contents();
    ob_get_clean();

    require "view/master.php";
?>
