<?php
    $title = "Consult Teams";

    ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Consult Teams</h2>

<div class="table-responsive">
    <table class="table table-bordered border-secondary table-striped table-hover">
        <thead>
            <th>N°</th>
            <th>Team Code</th>
            <th>Group</th>
            <th>Trainee 1</th>
            <th>Trainee 2</th>
            <th>Trainee 3</th>
            <th>Status</th>
            <th>Action</th>
        </thead>

        <?php 
            $counter = 0;
            foreach($teams_data as $team):
                ++$counter;
                $members = explode(",", $team["members"]);
        ?>

            <tr>
                <td><?= $counter ?></td>
                <td><?= $team["team_code"] ?></td>
                <td><?= $team["group_code"] ?></td>
                <td><?= isset($members[0]) ? $members[0] : "------" ?></td>
                <td><?= isset($members[1]) ? $members[1] : "------" ?></td>
                <td><?= isset($members[2]) ? $members[2] : "------" ?></td>
                <td><?= $team["status"] ?></td>

                <td>
                    <a href="index.php?action=team_info&team_code=<?= $team["team_code"] ?>" class="btn btn-sm btn-primary rounded-0" target="_blank">Team Info</a>
                    <a href="index.php?action=update&team_code=<?= $team["team_code"] ?>" class="btn btn-sm btn-warning rounded-0" target="_blank">Update</a>
                    <a href="index.php?action=contact&team_code=<?= $team['team_code'] ?>" class="btn btn-sm btn-success rounded-0">Contact</a>
                    <button class="btn btn-sm btn-danger rounded-0">Delete</button>
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
