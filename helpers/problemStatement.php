<div class="row">
    <div class="col problem-description" style="font-size:larger;">
        <?php if ($problem): ?>
            <h2 style='text-align: center;color:#00A859;'><?php echo $problem['Name']; ?></h2>
            <h3>Problem description</h3>
            <?php echo $problem['PlmDescription']; ?>
            <h3>Input</h3>
            <?php echo $problem['InputSpecification']; ?>
            <h3>Output</h3>
            <?php echo $problem['OutputSpecification']; ?>
            <?php
                $limit = $problem['sampleTestNo'];
                $i = 0;
                foreach ($testcases as $index => $testcase) {
                    if ($limit == 1) {
                        echo '<h3>Sample Testcase</h3>';
                    } else {
                        echo '<h3>Sample Testcase ' . ($i + 1) . '</h3>';
                    }
                    echo '<table class="table table-bordered table-hover" style="background-color: rgba(0, 168, 89, 0.1); border-color:grey;">';
                    echo '<thead class="thead-dark"><tr><th>Input <button class="btn btn-secondary btn-sm copy-button" data-copy-target="sample-input-' . $i . '" style="margin-left:10px;">Copy</button></th>';
                    echo '<th>Output <button class="btn btn-secondary btn-sm copy-button" data-copy-target="sample-output-' . $i . '" style="margin-left:10px;">Copy</button></th></tr>';
                    echo '</thead><tbody><tr><td id="sample-input-' . $i . '">';
                    echo nl2br(htmlspecialchars($testcases[$i]['Input']));
                    echo '</td><td id="sample-output-' . $i . '">';
                    echo nl2br(htmlspecialchars($testcases[$i]['Output']));
                    echo '</td></tr></tbody></table>';
                    $i++;
                    if ($i == $limit) break;
                }
            ?>
            <?php if (!empty($problem['Note'])): ?>
                <h3>Note</h3>
                <?php echo $problem['Note']; ?>
            <?php endif; ?>
            <div class="accordion" id="additionalInfo">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingMoreInfo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMoreInfo" aria-expanded="false" aria-controls="collapseMoreInfo">
                            More info
                        </button>
                    </h2>
                    <div id="collapseMoreInfo" class="accordion-collapse collapse" aria-labelledby="headingMoreInfo" data-bs-parent="#additionalInfo">
                        <div class="accordion-body" style="font-size:medium;">
                            <p><strong>Time Limit: </strong> <?php echo $problem['TimeLimit']; ?></p>
                            <p><strong>Memory Limit: </strong> <?php echo $problem['MemoryLimit']; ?></p>
                            <p><strong>Problem Rating: </strong> <?php echo $problem['RatedFor']; ?></p>
                        </div>
                    </div>
                </div>
            </div> 
        <?php endif; ?>            
    </div>
</div>