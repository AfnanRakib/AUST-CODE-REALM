<div class="row">
    <div class="col problem-description overflow-auto">
        <?php
            if ($problem) {
                echo "<h2 style='text-align: center;color:#00A859;'>{$problem['Name']}</h2>";
                echo "<h3>Problem description</h3>";
                echo "<pre>{$problem['PlmDescription']}</pre>";
                echo "<h3>Input</h3>";
                echo "<pre>{$problem['InputSpecification']}</pre>";
                echo "<h3>Output</h3>";
                echo "<pre>{$problem['OutputSpecification']}</pre>";
                echo "<h3>Constraints</h3>";
                echo "<pre></pre>";
            } else {
                echo "<p>Problem not found.</p>";
            }
        ?>
        <h3>Sample Testcase</h3>
        <table class="table table-bordered table-hover" style="background-color: rgba(0, 168, 89, 0.1); border-color:grey;">
            <thead class="thead-dark">
                <tr>
                    <th>Input <button class="btn btn-secondary btn-sm"style="margin-left:10px;" onclick="copyToClipboard('sample-input')">Copy</button></th>
                    <th>Output <button class="btn btn-secondary btn-sm"style="margin-left:10px;" onclick="copyToClipboard('sample-output')">Copy</button></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="sample-input">
                        <?php echo nl2br('5
                        10 4
                        2 3  4 5'); ?>
                    </td>
                    <td id="sample-output">
                        <?php echo nl2br('4
                        5
                        6 5 6'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php if (!empty($problem['Explanation'])): ?>
            <h3>Explanation</h3>
            <pre><?php echo $problem['Explanation']; ?></pre>;
        <?php endif; ?>
        <?php if (!empty($problem['Note'])): ?>
            <h3>Note</h3>
            <pre><?php echo $problem['Note']; ?></pre>
        <?php endif; ?>
        <div class="accordion" id="additionalInfo">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingMoreInfo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMoreInfo" aria-expanded="false" aria-controls="collapseMoreInfo">
                        More info
                    </button>
                </h2>
                <div id="collapseMoreInfo" class="accordion-collapse collapse" aria-labelledby="headingMoreInfo" data-bs-parent="#additionalInfo">
                    <div class="accordion-body">
                        <p><strong>Time Limit: </strong> <?php echo $problem['TimeLimit']; ?></p>
                        <p><strong>Memory Limit: </strong> <?php echo $problem['MemoryLimit']; ?></p>
                        <p><strong>Problem Rating: </strong> <?php echo $problem['RatedFor']; ?></p>
                    </div>
                </div>
            </div>
        </div>             
    </div>
</div>