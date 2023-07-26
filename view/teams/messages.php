<?php
    $title = "Message Box";

    ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Notifications Box</h2>
<button type="button" class="btn btn-primary d-block ms-auto mb-4">
    Mark as read <span class="badge text-bg-danger"><?= $counter ?></span>
</button>

    <?php
        foreach($team_messages as $message):
    ?>
    
        <article class="mb-3 border border-2 rounded-3 p-2 bg-success bg-opacity-10">
            <aside class="d-flex justify-content-between">
                <h5>From Mentor Name</h5>
                <p class="text-danger fs-6 fw-bold">
                    <?= $message["sent_time"] ?>
                    <?php if (strtolower($message["status"]) == "unread"): ?>
                        <span class="badge text-bg-danger bg-opacity-100">Unread</span>
                    <?php else:?>
                        <span class="badge text-bg-success bg-opacity-100">Read</span>
                    <?php endif;?>
                </p>
            </aside>
            <hr class="mt-0">
            <p style="white-space: pre-line">
                <?= trim($message["msg_content"]) ?>
            </p>
        </article>

    <?php endforeach;?>

    
<?php
    $content = ob_get_contents();
    ob_get_clean();

    require "view/master.php";
?>
