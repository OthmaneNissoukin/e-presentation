<?php
    $title = "Team Info";

    $styles = []; ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Team Info</h2>

<table class="table table-bordered border-secondary table-hover border-striped">
    <tr>
        <td class="fw-bold">Team Code</td>
        <td><?= $team_info["team_code"] ?></td>
    </tr>
    <tr>
        <td class="fw-bold">Group</td>
        <td><?= $team_info["group_code"] ?></td>
    </tr>
    <tr>
        <td class="fw-bold">Trainee 1</td>
        <td><?= isset($team_members[0]) ? $team_members[0]["fullname"] : "------" ?></td>
    </tr>
    <tr>
        <td class="fw-bold">Trainee 2</td>
        <td><?= isset($team_members[1]) ? $team_members[1]["fullname"] : "------" ?></td>
    </tr>
    <tr>
        <td class="fw-bold">Trainee 3</td>
        <td><?= isset($team_members[2]) ? $team_members[2]["fullname"] : "------" ?></td>
    </tr>
    <tr>
        <td class="fw-bold">Date Presentation</td>
        <td class="text-danger fw-bold"><?= $team_info["presentation_date"] == "0000-00-00"? "Unknown": implode("-", array_reverse(explode("-", $team_info["presentation_date"])))?></td>

    </tr>
    <tr>
        <td class="fw-bold">Date Presentation</td>
        <td class="text-danger fw-bold"><?= $team_info["presentation_time"] == "00:00:00"? "Unknown": substr($team_info["presentation_time"], 0, 5)?></td>
    </tr>
    <tr>
        <td class="fw-bold">Status</td>
        <td><?= $team_info["status"] ?></td>
    </tr>
</table>

    <hr class="my-4" />

    <h2 class="border-bottom pb-2 border-3">Files</h2>

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

    <hr class="my-4" />

    <a href="index.php?action=select_evaluation&team_code=<?= $team_info["team_code"] ?>" class="btn btn-primary me-3 mb-3 rounded-0">Start Presentation</a>
    <a href="index.php?action=update&team_code=<?= $team_info["team_code"] ?>" class="btn btn-info me-3 mb-3 rounded-0">Update Team</a>
    <a href="index.php?action=contact&team_code=<?= $team_info["team_code"] ?>"" class="btn btn-success me-3 mb-3 rounded-0">Send Message</a>
    <a href="#" class="btn btn-danger me-3 mb-3 rounded-0">Delete Team</a>


<?php
    $content = ob_get_contents();
    ob_get_clean();

    require "app/view/master.php";
?>
