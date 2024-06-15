<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/problemPage.css">
    <title>AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>
    
    <?php include '../helpers/judge0.php'; ?>
    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col problem-description overflow-auto">
                <h2 style="text-align: center;color:#00A859;">Problem Name</h2>
                <h3>Problem description</h3>
                <pre>Problem description</pre>
                <h3>Input</h3>
                <pre>Input</pre>
                <h3>Output</h3>
                <pre>Output</pre>
                <h3>Constraints</h3>
                <pre>Constraints</pre>
                <h3>Sample Testcase</h3>
                <pre>Sample Testcase</pre>
                <h3>More info</h3>
                <pre>More info</pre>              
            </div>
        </div>
        <div class="row">
            <h2 style="text-align: center;color:#00A859;">Submit Code</h2>
            <div class="col editor-container">
                <?php include '../helpers/ide.php'; ?>
            </div>
            <div class="container">
                <div class="row md-2">
                <div class="col-12 col-md-4 mb-2 mb-md-0">
                    <button class="btn btn-primary"id="submitButton">Submit</button>
                </div>
                <div class="col-12 col-md-4 mb-2 mb-md-0">
                    <button class="btn btn-primary"id="runButton">Run</button>
                </div>
            </div>
        </div>
        <div id="resultDisplay" class="mt-4 p-3 border rounded" style="background-color: #f8f9fa;"></div>

    </div>
    <script>
        document.getElementById('submitButton').addEventListener('click', function(event) {
            const selectElement = document.getElementById('selectLanguageMode');//seleceted lang object
            const languageName = selectElement.options[selectElement.selectedIndex].text;//selected lang name
            const languageId = languageModeIds[languageName];//selected language id
            const code = editor.getValue();//user written code

            const data = {
                languageId: languageId,
                languageName: languageName,
                code: code
            };
            fetch('submit_code.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(submissionData => {
                console.log('Success:', submissionData);

                // Display the result in the resultDisplay div
                const resultDisplay = document.getElementById('resultDisplay');
                let displayContent = `<h4>Submission Result</h4>`;

                if (submissionData.stdout) {
                    displayContent += `<p><strong>Stdout:</strong> ${submissionData.stdout}</p>`;
                }
                if (submissionData.stderr) {
                    displayContent += `<p><strong>Stderr:</strong> ${submissionData.stderr}</p>`;
                }
                if (submissionData.compile_output) {
                    displayContent += `<p><strong>Compile Output:</strong> ${submissionData.compile_output}</p>`;
                }

                if (!submissionData.stdout && !submissionData.stderr && !submissionData.compile_output) {
                    displayContent = `<p>No output available.</p>`;
                }

                resultDisplay.innerHTML = displayContent;
            })
            .catch(error => {
                console.error('Error:', error);
                const resultDisplay = document.getElementById('resultDisplay');
                resultDisplay.innerHTML = `<p>Error occurred while processing the submission.</p>`;
            });
        });


        //same code for run button if needed
    </script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
