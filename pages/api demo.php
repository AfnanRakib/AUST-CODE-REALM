<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/problemPage.css">
    <script src="../js/jquery-3.1.1.min.js"></script>
    <title>AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>

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
    </div>
    <script>
        document.getElementById('submitButton').addEventListener('click', function(event) {
            const selectElement = document.getElementById('selectLanguageMode');//seleceted lang object
            const languageName = selectElement.options[selectElement.selectedIndex].text;//selected lang name
            const languageId = languageModeIds[languageName];//selected language id
            const code = editor.getValue();//user written code

            const userData = {
                languageId: languageId,
                languageName: languageName,
                code: code
            };
            console.log(userData);
            var baseUrl = 'http://localhost:2358/submissions';
            $.ajax({
            url: baseUrl,
            type: "POST",
            data: {
                "source_code": code,
                "language_id": languageId,
                "number_of_runs": null,
                "stdin": "Judge0",
                "expected_output": "hello, Judge0\n",
                "cpu_time_limit": null,
                "cpu_extra_time": null,
                "wall_time_limit": null,
                "memory_limit": null,
                "stack_limit": null,
                "max_processes_and_or_threads": null,
                "enable_per_process_and_thread_time_limit": null,
                "enable_per_process_and_thread_memory_limit": null,
                "max_file_size": null,
                "enable_network": null
            },
            success: function(result) {
                console.log(result);
                var newUrl = baseUrl + '/' + result.token;
                console.log(newUrl);
                $('#result').html('code is running <div class="dot-collision inline-block ml-6"></div>');

                setTimeout(function() {
                getResult();
                }, 5000);

                function getResult() {
                $.ajax({
                    type: "GET",
                    url: newUrl,
                    success: function(response) {
                    var Compiled = response.stdout;
                    $('#result').html(Compiled);
                    checkIfNull(Compiled);
                    },
                    error: function(response) {
                    console.log(response.responseJSON.errors);
                    $('#result').html(response.responseJSON.errors);
                    }
                });
                }
            }
            });
        });
        //same code for run button if needed
    </script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>