<?php
    $title = "Forbidden";

    ob_start();
?>

  <div class="d-flex align-items-center justify-content-center vh-75">
    <div class="text-center">
      <h1 class="display-1 fw-bold">412</h1>
      <p class="fs-3"><span class="text-danger">Opps!</span> Prediction failed.</p>
      <p class="lead">Team doesnt exists!</p>
      <a href="index.php" class="btn btn-primary">Go Home</a>
    </div>
  </div>

<?php
  $content = ob_get_contents();
  ob_get_clean();

  require "view/master.php";
?>