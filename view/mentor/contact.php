<?php
    $title = "Contact Team";

    ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Contact Team</h2>

<form action="index.php?action=send_message" method="post">
    <fieldset class="border p-3">
        <div class="mb-3">
        <label for="team_code" class="form-label">Select Team</label>
        <select class="form-select" name="team_code" id="team_code">
            <?php 
                foreach($teams_data as $team): 
                    if ($team_code == $team["team_code"]):
            ?>
                <option value="<?= $team["team_code"] ?>" selected><?= $team["group_code"] . " => " . $team["team_code"] ?></option>
            <?php 
                    else:
            ?>
                <option value="<?= $team["team_code"] ?>"><?= $team["group_code"] . " => " . $team["team_code"] ?></option>
            <?php
                    endif;
                endforeach; 
            ?>
        </select>
        </div>
        <div class="mb-3">
        <label for="msg_content" class="form-label">Message Body</label>
        <textarea class="form-control" name="msg_content" id="msg_content" cols="30" rows="10"></textarea>
        </div>

        <input type="submit" value="Send Message" class="btn btn-primary btn-lg rounded-0" />
    </fieldset>
    </form>
    
<?php
    $content = ob_get_contents();
    ob_get_clean();

    require "view/master.php";
?>
