<?php
    $title = "Team Homepage";
    ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Welcome <span class="text-success"><?= $active_user ?></span></h2>

<table class="table table-bordered border-secondary table-hover border-striped">
    <tr>
        <td class="fw-bold w-25">Team Code</td>
        <td>
            <?= $team_data["team_code"] ?>
        </td>
    </tr>
    <tr>
        <td class="fw-bold">Member 1</td>
        <td>
            <?= isset($team_members[0]) ? $team_members[0]["fullname"] : "------" ?>
        </td>
    </tr>
    <tr>
        <td class="fw-bold">Member 2</td>
        <td>
            <?= isset($team_members[1]) ? $team_members[1]["fullname"] : "------" ?>
        </td>
    </tr>
    <tr>
        <td class="fw-bold">Member 3</td>
        <td>
            <?= isset($team_members[2]) ? $team_members[2]["fullname"] : "------" ?>
        </td>
    </tr>
    <tr>
        <td class="fw-bold">Presentation Date</td>
        <td class="text-danger fw-bold"><?= $team_data["presentation_date"] == "0000-00-00"? "Unknown": implode("-", array_reverse(explode("-", $team_data["presentation_date"])))?></td>
    </tr>
    <tr>
        <td class="fw-bold">Presentation Time</td>
        <td class="text-danger fw-bold"><?= $team_data["presentation_time"] == "00:00:00"? "Unknown": substr($team_data["presentation_time"], 0, 5)?></td>
    </tr>
</table>

    <hr class="my-4" />

    <h2 class="border-bottom pb-2 border-2 border-primary mb-4">Files</h2>

    <table class="table table-bordered border-secondary table-hover border-striped">
    <tr>
        <td class="fw-bold">Application</td>
            <?php if (empty($app_info)): ?>
                <td class="fw-bold text-danger">NOT AVAILABLE</td>
            <?php else: ?> 
                <td class="fw-bold">
                    <a class="text-success text-decoration-none" href="<?= $app_info['file_path'] ?>"  target="_blank">
                        AVAILABLE <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </td>
            <?php endif;?> 
    </tr>
    <tr>
        <td class="fw-bold">Report</td>
            <?php if (empty($report_info)): ?>
                <td class="fw-bold text-danger">NOT AVAILABLE</td>
            <?php else: ?> 
                <td class="fw-bold">
                    <a class="text-success text-decoration-none" href="<?= $report_info['file_path'] ?>">
                        <i class="bi bi-cloud-arrow-down-fill"></i> AVAILABLE
                    </a>
                </td>
            <?php endif;?> 
    </tr>
    <tr>
        <td class="fw-bold">Presentation</td>
            <?php if (empty($presentation_info)): ?>
                <td class="fw-bold text-danger">NOT AVAILABLE</td>
            <?php else: ?> 
                <td class="fw-bold">
                    <a class="text-success text-decoration-none" href="<?= $presentation_info['file_path'] ?>">
                        <i class="bi bi-cloud-arrow-down-fill"></i> AVAILABLE
                    </a>
                </td>
            <?php endif;?> 
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