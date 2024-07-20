document.getElementById('submitButton').addEventListener('click', function(event) {
    const selectElement = document.getElementById('selectLanguageMode'); // selected lang object
    const languageName = selectElement.options[selectElement.selectedIndex].text; // selected lang name
    const languageId = languageModeIds[languageName]; // selected language id
    const code = editor.getValue(); // user written code
    const isRun = false;
    const data = {
        languageId: languageId,
        languageName: languageName,
        code: code,
        testcases: testcases,
        problem: problem,
        problemId: problemId, // Include problemId here
        isRun: isRun
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
        displayContent += `<p><strong>Status:</strong> ${submissionData.status}</p>`;

        resultDisplay.innerHTML = displayContent;
    })
    .catch(error => {
        console.error('Error:', error);
        const resultDisplay = document.getElementById('resultDisplay');
        resultDisplay.innerHTML = `<p>Error occurred while processing the submission: ${error.message}</p>`;
    });
});

document.getElementById('runButton').addEventListener('click', function(event) {
    const selectElement = document.getElementById('selectLanguageMode'); // selected lang object
    const languageName = selectElement.options[selectElement.selectedIndex].text; // selected lang name
    const languageId = languageModeIds[languageName]; // selected language id
    const code = editor.getValue(); // user written code
    const isRun= true;
    const data = {
        languageId: languageId,
        languageName: languageName,
        code: code,
        testcases: [testcases[0]], // Use only the first test case for the run action
        problemId: problemId, // Include problemId here
        isRun: isRun
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
        let displayContent = `<h4>Run Result</h4>`;

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
            displayContent += `<p><strong>Time:</strong> ${submissionData.time}</p>`;
        }
        if (submissionData.memory) {
            displayContent += `<p><strong>Memory:</strong> ${submissionData.memory}</p>`;
        }

        if (!submissionData.stdout && !submissionData.stderr && !submissionData.compile_output && !submissionData.status && !submissionData.time && !submissionData.memory ) {
            displayContent = `<p>No output available.</p>`;
        }

        resultDisplay.innerHTML = displayContent;
    }).catch(error => {
        console.error('Error:', error);
        const resultDisplay = document.getElementById('resultDisplay');
        resultDisplay.innerHTML = `<p>Error occurred while processing the run: ${error.message}</p>`;
    });
});
