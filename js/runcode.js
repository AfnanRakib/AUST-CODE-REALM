document.getElementById('submitButton').addEventListener('click', function(event) {
    displayRunningMessage(); // Show "Running..." message
    submitCode(false);
});

document.getElementById('runButton').addEventListener('click', function(event) {
    displayRunningMessage(); // Show "Running..." message
    submitCode(true);
});

function submitCode(isRun) {
    const selectElement = document.getElementById('selectLanguageMode'); // selected lang object
    const languageName = selectElement.options[selectElement.selectedIndex].text; // selected lang name
    const languageId = languageModeIds[languageName]; // selected language id
    const code = editor.getValue(); // user written code
    const data = {
        languageId: languageId,
        languageName: languageName,
        code: code,
        testcases: isRun ? [testcases[0]] : testcases, // Use only the first test case for the run action
        problemId: problemId,
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
    })
    .then(text => {
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
        displayResult(submissionData, isRun);
    })
    .catch(error => {
        console.error('Error:', error);
        displayError(error);
    });
}

function displayRunningMessage() {
    const resultDisplay = document.getElementById('resultDisplay');
    resultDisplay.innerHTML = '<h4>Processing...</h4>';
}

function displayResult(data, isRun) {
    const resultDisplay = document.getElementById('resultDisplay');
    let displayContent = `<h4>${isRun ? 'Run' : 'Submission'} Result</h4>`;
    let statusColor = data.status === 'Accepted' ? 'green' : 'red';
    
    displayContent += `<p><strong>Status:</strong> <span style="color: ${statusColor};">${data.status}</span></p>`;
    
    if (data.stdout) {
        displayContent += `<p><strong>Stdout:</strong> ${data.stdout}</p>`;
    }
    if (data.stderr) {
        displayContent += `<p><strong>Stderr:</strong> ${data.stderr}</p>`;
    }
    if (data.compile_output) {
        displayContent += `<p><strong>Compile Output:</strong> ${data.compile_output}</p>`;
    }
    if (data.time) {
        displayContent += `<p><strong>Time:</strong> ${data.time}</p>`;
    }
    if (data.memory) {
        displayContent += `<p><strong>Memory:</strong> ${data.memory}</p>`;
    }

    resultDisplay.innerHTML = displayContent;
}

function displayError(error) {
    const resultDisplay = document.getElementById('resultDisplay');
    resultDisplay.innerHTML = `<p>Error occurred while processing: ${error.message}</p>`;
}
