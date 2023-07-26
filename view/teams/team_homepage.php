<?php
    $title = "Team Homepage";
    ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Team Homepage</h2>

<table class="table table-bordered border-secondary table-hover border-striped">
    <tr>
        <td class="fw-bold w-25">Team Code</td>
        <td><?= $team_date["team_code"] ?></td>
    </tr>
    <tr>
        <td class="fw-bold">Member 1</td>
        <td><?= $team_date["trainee_1"] ?></td>
    </tr>
    <tr>
        <td class="fw-bold">Member 2</td>
        <td><?= empty($team_date["trainee_2"]) ? "----" : $team_date["trainee_2"]?></td>
    </tr>
    <tr>
        <td class="fw-bold">Member 3</td>
        <td><?= empty($team_date["trainee_3"]) ? "----" : $team_date["trainee_3"]?></td>
    </tr>
    <tr>
        <td class="fw-bold">Presentation Date</td>
        <td class="text-danger fw-bold"><?= $team_date["presentation_date"] == "0000-00-00"? "Unknown": implode("-", array_reverse(explode("-", $team_date["presentation_date"])))?></td>
    </tr>
    <tr>
        <td class="fw-bold">Presentation Time</td>
        <td class="text-danger fw-bold"><?= $team_date["presentation_time"] == "00:00:00"? "Unknown": substr($team_date["presentation_time"], 0, 5)?></td>
    </tr>
</table>

    <hr class="my-4" />

    <h2 class="border-bottom pb-2 border-2 border-primary mb-4">Files</h2>

    <table class="table table-bordered border-secondary table-hover border-striped">
    <tr>
        <td class="fw-bold">Application</td>
        <td>Not Available</td>
    </tr>
    <tr>
        <td class="fw-bold">Report</td>
        <td>Not Available</td>
    </tr>
    <tr>
        <td class="fw-bold">Presentation</td>
        <td>Not Available</td>
    </tr>
    </table>

    <a href="index.php?action=upload" class="btn btn-primary me-3 mb-3">Upload Files</a>

    <aside id="msg_content"></aside>
    

    <!-- Button trigger modal -->
    <button id="btn_modal" type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Launch static backdrop modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Presentation Update</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
            <?= $msg_content ?>
        </div>
            <div class="modal-footer">
                <button id="btn_confirm" type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script src="scripts/team_homepage.js"></script>
<?php
    $content = ob_get_contents();
    ob_get_clean();
    require "view/master.php";
?>