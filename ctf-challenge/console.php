<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Web Console</title>
    <link rel="stylesheet" href="css/console.css">
</head>
<body>
    <div class="console-container">
        <h1 class="console-title">Admin Console</h1>
        <div class="console-output" id="output"></div>
        <div class="console-input">
            <span class="console-prompt">></span>
            <input type="text" id="command" placeholder="Enter command..." autofocus>
            <button onclick="executeCommand()">Execute</button>
        </div>
    </div>

    <script>
        const output = document.getElementById('output');
        const commandInput = document.getElementById('command');

        // Get command from URL if it exists
        const urlParams = new URLSearchParams(window.location.search);
        const cmdFromUrl = urlParams.get('cmd');
        if (cmdFromUrl) {
            commandInput.value = decodeURIComponent(cmdFromUrl);
            executeCommand();
        }

        function executeCommand() {
            const command = commandInput.value.trim();
            if (!command) return;

            // Update URL with the command
            const newUrl = new URL(window.location.href);
            newUrl.searchParams.set('cmd', encodeURIComponent(command));
            window.history.pushState({}, '', newUrl);

            // Add command to output
            output.innerHTML += `<span class="console-prompt">></span> ${command}\n`;

            try {
                // Execute command using eval
                const result = eval(command);
                
                // Display result
                if (result !== undefined) {
                    output.innerHTML += `${result}\n`;
                }
            } catch (error) {
                // Display error in red
                output.innerHTML += `<span class="error">Error: ${error.message}</span>\n`;
            }

            // Clear input
            commandInput.value = '';
            
            // Scroll to bottom
            output.scrollTop = output.scrollHeight;
        }

        // Execute command on Enter key
        commandInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                executeCommand();
            }
        });

        // Initial message
        output.innerHTML = 'Welcome to Admin Console\nType your JavaScript commands below:\n\n';
    </script>
</body>
</html>
