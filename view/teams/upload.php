<?php
    $title = "Upload Files";

    ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Upload Files</h2>

<noscript class="alert alert-danger w-100 my-4"> This page requires Javascript enabled! </noscript>

<form id="application_form" action="index.php?action=upload_application" method="post" enctype="multipart/form-data">
    <fieldset class="border p-3">

        <div class="mb-3">
            <h6>Application
                <?php if (empty($app_info)): ?>
                    <span class="badge text-bg-danger">NOT AVAILABLE</span>
                <?php else: ?> 
                    <span class="badge text-bg-success">SAVED</span>
                <?php endif;?> 
            </h6>
            <div id="app_alert" class="alert alert-warning d-none"></div>
            <div class="my-3">
                <label for="token" class="form-label">Github Token</label>
                <input id="token" name="token" type="text" class="form-control" />
                <span id="token_validation_err" class="fw-light fs-6 text-danger"></span>
            </div>
            
            <div class="my-2">
                <label for="repository_link" class="form-label">HTTPS Github Repository</label>
                <input id="repository_link" name="repository_link" type="text" class="form-control" />
                <span id="repo_validation_err" class="fw-light fs-6 text-danger"></span>
            </div>
        </div>

        <input type="submit" name="upload" value="Submit" class="btn btn-primary">
    </fieldset>

</form>

<form id="report_form" action="index.php?action=upload_report" method="post" enctype="multipart/form-data">
    <fieldset class="border p-3">
        <div id="report_warning" class="alert alert-warning d-none"></div>

        <div class="mb-3">
            <label for="report" class="form-label">
                Report
                <?php if (empty($report_info)): ?>
                    <span class="badge text-bg-danger">NOT AVAILABLE</span>
                <?php else: ?> 
                    <span class="badge text-bg-success">UPLOADED</span>
                <?php endif;?> 
            </label>
            <input id="report" name="report" type="file" class="form-control" />
            <div class="progress mt-2" style="height: 10px">
                <div id="report_bar"  class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%; height: 10px"></div>
            </div>
        </div>
        <input type="submit" name="upload" value="Upload" class="btn btn-primary">
    </fieldset>
</form>

<form id="presentation_form" action="index.php?action=upload_presentation" method="post" enctype="multipart/form-data">
    <fieldset class="border p-3">
        <div id="presentation_warning" class="alert alert-warning d-none"></div>

        <div class="mb-3">
            <label for="presentation" class="form-label">
                Presentation
                <?php if (empty($presentation_info)): ?>
                    <span class="badge text-bg-danger">NOT AVAILABLE</span>
                <?php else: ?> 
                    <span class="badge text-bg-success">UPLOADED</span>
                <?php endif;?> 
            </label>
            <input id="presentation" name="presentation" type="file" class="form-control" />
            <div class="progress mt-2" style="height: 10px">
                <div id="presentation_bar" class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
            </div>
        </div>
        <input type="submit" value="Upload" class="btn btn-primary" />
    </fieldset>

</form>
</fieldset>

<script src="scripts/upload/files_utils.js" type="module"></script>
<script src="scripts/upload/upload_application.js" type="module"></script>
<script src="scripts/upload/upload_report.js" type="module"></script>
<script src="scripts/upload/upload_presentation.js" type="module"></script>


<?php
    $content = ob_get_contents();
    ob_get_clean();

    require "view/master.php";
?>
