<?php
    $title = "Evaluation result";

    ob_start();
?>

<h2 class="border-bottom pb-2 border-2 border-primary mb-4">Evaluation result</h2>

<table class="table table-bordered border-secondary mt-5">
        <thead class="table-dark">
            <th class="w-50">Question</th>
            <th>Grade</th>
        </thead>

        <tbody id="report_table">

            <tr class="table-secondary border-secondary">
                <td colspan="2" class="fw-bold">Report evaluation</td>
            </tr>

            <?php 
                $total = 0;
                foreach($result as $question):
                    $total += $question["grade"];
                    if ($question["question_topic"] == "presentation"):
            ?>
                <tr data-categorty="presentation" >
                    <td>
                        <p><?= $question['question_content'] ?></p>
                    </td>
                    
                    <td class="text-danger fw-bold">
                        <p><?= $question['grade'] ?> / <?= $question["question_scale"] ?></p>
                    </td>
                        
                </tr>

            <?php
                    endif;
                endforeach;
            ?>

            <tr class="table-secondary border-secondary">
                <td colspan="2" class="fw-bold">Presentation evaluation</td>
            </tr>

            <?php 
                foreach($result as $question):
                    $total += $question["grade"];
                    if ($question["question_topic"] == "report"):
            ?>
                <tr>
                    <td>
                        <p><?= $question['question_content'] ?></p>
                    </td>

                        <td class="text-danger fw-bold">
                            <p><?= $question['grade'] ?> / <?= $question["question_scale"] ?></p>
                        </td>
                </tr>
            <?php
                    endif;
                endforeach; 
            ?>

            <tfoot class="table-danger border-secondary">
                <td class="fw-bold">Total</td>
                <td class="fw-bold text-danger"><?= $total ?> / 40</td>
            </tfoot>
        </tbody>
    </table>

<?php
    $content = ob_get_contents();
    ob_get_clean();

    require "view/master.php";
?>
