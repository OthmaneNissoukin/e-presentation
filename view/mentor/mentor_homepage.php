<?php
    $title = "Mentor Homepage";
    ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Mentor Homepage</h2>

    <div class="alert alert-danger">
        A presentation is ongoing and it will be finihed after <span class="fw-bold">15:23</span>
    </div>

    <h4>Status</h4>

    <section class="row text-light">
    <div class="col-6 g-2">
        <article class="bg-success p-2">
        <h5>Total Presentations</h5>
        <p><?= count($presentations) ?></p>
        </article>
    </div>
    <div class="col-6 g-2">
        <article class="bg-success p-2">
        <h5>Inactive Accounts</h5>
        <p><?= $inactive_accounts ?></p>
        </article>
    </div>
    <div class="col-6 g-2">
        <article class="bg-success p-2">
        <h5>Presentations Left</h5>
        <p><?= $presentations_left ?></p>
        </article>
    </div>
    <div class="col-6 g-2">
        <article class="bg-success p-2">
        <h5>Presentations Done</h5>
        <p><?= $presentations_done ?></p>
        </article>
    </div>
    </section>

    <hr class="my-4" />

    <h4 class="border-bottom pb-2 border-2 border-danger mb-3">Next 5 Presentations</h4>

    <table class="table table-bordered table-hover border-secondary border-striped border">
    <thead>
        <th>Team Code</th>
        <th>Group</th>
        <th>Date Presentation</th>
        <th>Time Presentation</th>
        <th>Status</th>
        <th>Action</th>
    </thead>

    <!-- Second -->

    <?php 
        $counter = 0;
        foreach($presentations as $presentation):
            if ($counter >= 5) break;
            $counter++;
    ?>
    <tr>
        <td><?= $presentation["team_code"] ?></td>
        <td><?= $presentation["group_code"] ?></td>
        <td><?= implode("-", array_reverse(explode("-", $presentation["presentation_date"]))) ?></td>
        <td><?= substr($presentation["presentation_time"], 0, 5) ?></td>
        <td><?= $presentation["status"] ?></td>
        <td>
            <a href="index.php?action=team_info&team_code=<?= $presentation["team_code"] ?>" class="btn btn-sm btn-info">Team Details</a>
            <a href="index.php?action=update&team_code=<?= $presentation["team_code"] ?>" class="btn btn-warning btn-sm">Update</a>
            <a href="index.php?action=contact&team_code=<?= $presentation["team_code"] ?>" class="btn btn-success btn-sm">Contact Team</a>
            <button class="btn btn-danger btn-sm">Delete</button>
        </td>
        </td>
    </tr>

    <?php endforeach;?>
    </table>

    <a href="index.php?action=all_presentations" class="btn btn-lg rounded-0 btn-primary my-4 d-block m-auto w-25">All Presentations</a>

<?php
    $content = ob_get_contents();
    ob_get_clean();
    require "view/master.php";
?>