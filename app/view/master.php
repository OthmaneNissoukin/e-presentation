<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <?php foreach($styles as $style): ?>
        <link rel="stylesheet" href="public/<?=$style?>" />
    <?php endforeach?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php 
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION["admin"])) {
            require "app/view/mentor/includes/nav_bar.html";
        } elseif (isset($_SESSION["team_code"]) && isset($_SESSION["user"])) {
            if (TeamController::is_active_trainee($_SESSION["user"])) require "app/view/teams/includes/nav_bar.html";
        }
    ?>
    
    <main class="container py-3">

    <?= $content ?>

    </main>
</body>
</html>