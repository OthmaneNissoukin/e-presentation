<?php
    $title = "Consult Presentations";

    ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Consult Presentations</h2>

<div class="table-responsive">
    <table class="table table-bordered border-secondary table-striped table-hover">
        <thead>
            <th>N°</th>
            <th>Team Code</th>
            <th>Group</th>
            <th>Presentation Date</th>
            <th>Presentation Time</th>
            <th>Status</th>
            <th>Action</th>
        </thead>

        <?php 
            $counter = 0;
            foreach($team_data as $presentation):
                ++$counter;
        ?>

            <tr>
                <td><?= $counter ?></td>
                <td><?= $presentation["team_code"] ?></td>
                <td><?= $presentation["group_code"] ?></td>
                <td class="text-danger fw-bold"><?= $presentation["presentation_date"] == "0000-00-00"? "Unknown": implode("-", array_reverse(explode("-", $presentation["presentation_date"])))?></td>
                <td class="text-danger fw-bold"><?= $presentation["presentation_time"] == "00:00:00"? "Unknown": substr($presentation["presentation_time"], 0, 5)?></td>
                <td><?= $presentation["status"] ?></td>

                <td>
                    <a href="index.php?action=team_info&team_code=<?= $presentation["team_code"] ?>" class="btn btn-sm btn-primary" target="_blank">Team Info</a>
                    <a href="index.php?action=update&team_code=<?= $presentation["team_code"] ?>" class="btn btn-sm btn-warning" target="_blank">Update</a>
                    <button class="btn btn-sm btn-danger">Start</button>
                </td>
            </tr>
        
        <?php
            endforeach;
        ?>
    </table>
    </div>


<?php
    $content = ob_get_contents();
    ob_get_clean();

    require "view/master.php";
?>
