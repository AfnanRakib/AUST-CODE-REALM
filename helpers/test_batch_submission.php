
<script>
fetch('batched_submission.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        batch_submissions: [
            {
                languageId: 71,
                code: "print('Hello, World!')",
                stdin: "",
                expected_output: "Hello, World!",
                cpu_time_limit: 5,
                memory_limit: 128000
            },
            {
                languageId: 71,
                code: "print('Another Test')",
                stdin: "",
                expected_output: "Another Test",
                cpu_time_limit: 5,
                memory_limit: 128000
            }
        ]
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:',error));
</script>