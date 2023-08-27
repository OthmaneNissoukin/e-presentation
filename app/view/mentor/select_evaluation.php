<?php
    $title = "Select evaluation";

    $styles = []; ob_start();
?>

    <h2 class="border-bottom pb-2 border-2 border-primary mb-4">Select evaluation</h2>
    
    <?php if ($team_has_passed):?>
        <div class="alert alert-warning">This team has already passed an evaluation, re-passing will delete their previous result!</div>
    <?php endif;?>

    <div id="alert_box" class="alert alert-danger d-none"></div>

    <form action="index.php?action=evaluation" method="post" class="mt-3 p-4 border">
        <div class="mb-3">
            <label class="form-label">Team</label>
            <input type="text" value="<?= $team_code ?>" id="team_code" name="team_code" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Select evaluation</label>
            <select name="evaluation_code" id="evaluation_code" class="form-select">
                <?php foreach($all_evaluations as $evaluation): ?>
                    <option value="<?= $evaluation['evaluation_code'] ?>"><?= $evaluation['evaluation_code'] . " (" . $evaluation['season'] .  ")"?></option>
                <?php endforeach; ?>
            </select>
        </div>


        <button id="btn_check" type="button" class="btn btn-primary rounded-0 px-5">Check</button>
        <button id="btn_save" type="submit" class="btn btn-primary rounded-0 px-5">Start</button>
    </form>

    <table class="table table-bordered border-secondary my-3">
        <thead class="table-dark">
            <th>Question</th>
            <th>Scale</th>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" class="bg-secondary bg-opacity-25 fw-bold">Report evaluation</td>
            </tr>
            <tr id="presentation_row">
                <td colspan="2" class="bg-secondary bg-opacity-25 fw-bold">Presentation evaluation</td>
            </tr>
        </tbody>
    </table>

    <script src="public/scripts/select_evaluation.js"></script>

<?php
    $content = ob_get_contents();
    ob_get_clean();

    require "app/view/master.php";
?>
