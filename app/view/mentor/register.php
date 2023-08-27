<?php
    $title = "Register";

    $styles = []; ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Create new team</h2>

<form action="index.php?action=check" method="post">
    <fieldset class="border p-3">

        <div class="alert alert-danger d-none" id="alert_box"></div>

        <div class="mb-3">
            <label for="trainee_1" class="form-label">Stagiaire 1</label>
            <input id="trainee_1" name="trainee_1" type="text" class="form-control" placeholder="NOM & Prenom" />
            <span class="text-danger fw-lighter" id="trainee_1_err"></span>
        </div>
            <div class="mb-3">
            <label for="trainee_2" class="form-label">Stagiaire 2</label>
            <input id="trainee_2" name="trainee_2" type="text" class="form-control" placeholder="NOM & Prenom" />
            <span class="text-danger fw-lighter" id="trainee_2_err"></span>

        </div>
            <div class="mb-3">
            <label for="trainee_3" class="form-label">Stagiaire 3</label>
            <input id="trainee_3" name="trainee_3" type="text" class="form-control" placeholder="NOM & Prenom" />
            <span class="text-danger fw-lighter" id="trainee_3_err"></span>

        </div>
        <div class="mb-3">
            <label for="groups_options" class="form-label">Group</label>
            <input class="form-control"  name="group" list="groups" id="groups_options" placeholder="Select or insert group"/>
            <datalist id="groups">
                <?php foreach($groups as $group):?>
                    <option value="<?= $group['group_code'] ?>">
                <?php endforeach;?>
            </datalist>
            <span class="text-danger fw-lighter" id="group_err"></span>

        </div>

        <div class="mb-3">
            <label for="presentation_date" class="form-label">Presentation Date</label>
            <input id="presentation_date" name="presentation_date" type="date" class="form-control" placeholder="Team" />
        </div>

        <div class="mb-3">
            <label for="presentation_time" class="form-label">Presentation Time</label>
            <input id="presentation_time" name="presentation_time" type="time" class="form-control" placeholder="Team" />
        </div>

        <input type="submit" value="Register" class="btn btn-primary btn-lg rounded-0" />
    </fieldset>
</form>

<script src="public/scripts/register.js" type="module"></script>
<script src="public/scripts/utils.js" type="module"></script>
<script src="public/scripts/ajax_register/ajax_code.js" type="module"></script>

<?php
    $content = ob_get_contents();
    ob_get_clean();

    require "app/view/master.php";
?>
