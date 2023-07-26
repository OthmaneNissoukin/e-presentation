<?php
    $title = "Update";

    ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Update team</h2>

<form action="index.php?action=save_team_updates" method="post">
    <fieldset class="border p-3">

        <div class="alert alert-danger d-none" id="alert_box"></div>

        <div class="mb-3">
            <label for="team_code" class="form-label">Team code</label>
            <input value="<?= $data['team_code'] ?>" id="team_code" name="team_code" type="text" class="form-control" readonly/>
            <span class="text-danger fw-lighter" id="team_code"></span>
        </div>

        <div class="mb-3">
            <label for="trainee_1" class="form-label">Stagiaire 1</label>
            <input value="<?= $data['trainee_1'] ?>" id="trainee_1" name="trainee_1" type="text" class="form-control" placeholder="NOM & Prenom" />
            <span class="text-danger fw-lighter" id="trainee_1_err"></span>
        </div>
            <div class="mb-3">
            <label for="trainee_2" class="form-label">Stagiaire 2</label>
            <input value="<?= $data['trainee_2'] ?>" id="trainee_2" name="trainee_2" type="text" class="form-control" placeholder="NOM & Prenom" />
            <span class="text-danger fw-lighter" id="trainee_2_err"></span>

        </div>
            <div class="mb-3">
            <label for="trainee_3" class="form-label">Stagiaire 3</label>
            <input value="<?= $data['trainee_3'] ?>" id="trainee_3" name="trainee_3" type="text" class="form-control" placeholder="NOM & Prenom" />
            <span class="text-danger fw-lighter" id="trainee_3_err"></span>

        </div>
        <div class="mb-3">
            <label for="groups_options" class="form-label">Group</label>
            <input value="<?= $data['group_code'] ?>" class="form-control"  name="group" type="text" id="groups_options" placeholder="EX: DEV108"/>
            <span class="text-danger fw-lighter" id="group_err"></span>

        </div>

        <div class="mb-3">
            <label for="presentation_date" class="form-label">Presentation Date</label>
            <input value="<?= $data['presentation_date'] ?>" id="presentation_date" name="presentation_date" type="date" class="form-control"/>
        </div>

        <div class="mb-3">
            <label for="presentation_time" class="form-label">Presentation Time</label>
            <input value="<?= $data['presentation_time'] ?>" id="presentation_time" name="presentation_time" type="time" class="form-control"/>
        </div>

        <input type="submit" value="Save changes" class="btn btn-primary btn-lg rounded-0" />
    </fieldset>
</form>

<script src="scripts/register.js" type="module"></script>
<script src="scripts/utils.js" type="module"></script>
<script src="scripts/register_update/ajax_code.js" type="module"></script>


<?php
    $content = ob_get_contents();
    ob_get_clean();

    require "view/master.php";
?>
