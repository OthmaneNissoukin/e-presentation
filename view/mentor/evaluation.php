<?php
    $title = "Evaluation";

    ob_start();
?>

<h2 class="border-bottom border-danger border-3 pb-3 mb-4">Evaluation</h2>

<section class="d-flex flex-column flex-md-row justify-content-md-between">
    <table class="table table-bordered border-3">
        <thead>
            <th >Evaluation</th>
            <th >Team</th>
            <th>Group</th>
            <th>Season</th>
        </thead>
        <tr>
            <td><?= $questions[0]['evaluation_code'] ?></td>
            <td><?= $team_members[0]['team_code'] ?></td>
            <td><?= $team_group['group_code'] ?></td>
            <td><?= date("Y") ?></td>
        </tr>
    </table>
    
    
    <div class="d-flex flex-column flex-md-row justify-content-between w-100">
        <aside aria-hidden="true"></aside>
        <div id="timer_container" class="bg-primary bg-opacity-25 d-flex align-items-center justify-content-center fs-4 fw-bold px-5 py-4">
            <i id="indicator" class="bi bi-circle-fill fs-6 mx-2 text-danger"></i> <span id="timer">00:00</span>
        </div>
        <div class="d-flex flex-md-column">
            <button id="start" class="btn rounded-0 px-5 btn-success"><i class="bi bi-caret-right-fill me-2"></i>Start</button>
            <button id="pause" class="btn rounded-0 px-5 btn-warning"><i class="bi bi-pause-fill me-2"></i>Pause</button>
            <button id="stop" class="btn rounded-0 px-5 btn-danger"><i class="bi bi-stop-fill me-2"></i>Stop</button>
        </div>
    </div>
</section>

<div class="alert alert-danger d-none mt-5" id="alert_box"></div>

<form action="index.php?action=submit_evaluation" method="post" class="mt-4">
    <input type="hidden" name="team_code" value="<?= $team_members[0]['team_code'] ?>">
    <div class="table-responsive">

    <table class="table table-bordered border-secondary">
        <thead class="table-dark">
            <th class="w-50">Question</th>

            <?php foreach($team_members as $member): ?>
                <th><?= $member['fullname'] ?></th>
            <?php endforeach; ?>
        </thead>

        <tbody id="report_table">

            <tr class="table-secondary border-secondary">
                <td colspan="<?= count($team_members) + 1 ?>" class="fw-bold">Report evaluation</td>
            </tr>

            <?php 
                foreach($report_questions as $question):
            ?>
                <tr data-categorty="presentation" >
                    <td>
                        <input type="hidden" data-report="question" name="question_scale[]" value="<?= $question["question_scale"] ?>"/>
                        <p><?= $question['question_content'] ?></p>
                    </td>
                    
                    <?php foreach($team_members as $member):?>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control" name="answer[<?= $member['trainee_id'] ?>][<?= $question['question_code'] ?>]" data-max-value="<?= $question['question_scale']?>" />
                                <span class="input-group-text" id="basic-addon1">/ <?= $question["question_scale"] ?></span>
                            </div>
                        </td>
                        
                    <?php endforeach; ?>
                </tr>

            <?php
                endforeach;
            ?>

            <tr class="table-secondary border-secondary">
                <td colspan="<?= count($team_members) + 1 ?>" class="fw-bold">Presentation evaluation</td>
            </tr>

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
    </div>
        

    <input type="submit" value="Finish" class="btn btn-primary btn-lg d-block m-auto w-25 rounded-0" />
</form>

<button type="button" class="btn btn-primary d-none" id="liveToastBtn">Show live toast</button>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">Time alert</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body" id="toast_message">
      5 mins left.
    </div>
  </div>
</div>

<script src="scripts/evaluation.js"></script>

<?php
    $content = ob_get_contents();
    ob_get_clean();

    require "view/master.php";
?>
