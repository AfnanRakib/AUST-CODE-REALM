document.getElementById('runButton').addEventListener('click', function(event) {
    const selectElement = document.getElementById('selectLanguageMode'); // selected lang object
    const languageName = selectElement.options[selectElement.selectedIndex].text; // selected lang name
    const languageId = languageModeIds[languageName]; // selected language id
    const code = editor.getValue(); // user written code

    const data = {
        languageId: languageId,
        languageName: languageName,
        code: code
    };
    fetch('../helpers/submit_code.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text(); // Get the raw text response
    }).then(text => {
        console.log('Raw response:', text); // Log the raw response
        try {
            return JSON.parse(text); // Try to parse the JSON
        } catch (error) {
            console.error('JSON parse error:', error);
            throw new Error('Invalid JSON response');
        }
    })
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
        if (submissionData.status) {
            displayContent += `<p><strong>Status:</strong> ${submissionData.status}</p>`;
        }
        if (submissionData.time) {
            displayContent += `<p><strong>time:</strong> ${submissionData.time}</p>`;
        }
        if (submissionData.memory) {
            displayContent += `<p><strong>memory:</strong> ${submissionData.memory}</p>`;
        }
        if (submissionData.created_at) {
            displayContent += `<p><strong>created_at:</strong> ${submissionData.created_at}</p>`;
        }
        if (submissionData.finished_at) {
            displayContent += `<p><strong>finished_at:</strong> ${submissionData.finished_at}</p>`;
        }
        if (submissionData.token) {
            displayContent += `<p><strong>token:</strong> ${submissionData.token}</p>`;
        }

        if (!submissionData.stdout && !submissionData.stderr && !submissionData.compile_output && !submissionData.status && !submissionData.time && !submissionData.memory && !submissionData.created_at && !submissionData.finished_at) {
            displayContent = `<p>No output available.</p>`;
        }

        resultDisplay.innerHTML = displayContent;
    }).catch(error => {
        console.error('Error:', error);
        const resultDisplay = document.getElementById('resultDisplay');
        resultDisplay.innerHTML = `<p>Error occurred while processing the submission: ${error.message} </p>`;
    });
});