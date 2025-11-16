<?php  

$serverIp = $_SERVER['SERVER_ADDR'];
$clientIp = $_SERVER['REMOTE_ADDR'];

$server_parts = explode('.', $serverIp);
$client_parts = explode('.', $clientIp);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($server_parts[0] !== $client_parts[0] || $server_parts[1] !== $client_parts[1]) {
        http_response_code(403);
        echo 'access only from localnetwork!';
    } else {
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dev Chat - Security Discussion</title>
            <link rel="stylesheet" href="css/dev_chat.css">
        </head>
        <body>
            <div class="title">
                <h1>Development Team Chat</h1>
            </div>

            <div class="chat-container">

                <div class="chat-message">
                    <span class="username">BZR:</span>
                    <p>Hey, I just pushed the new security updates. The SSRF protection is now bulletproof.</p>
                </div>

                <div class="chat-message">
                    <span class="username">BZR:</span>
                    <p>I've implemented multiple layers of protection. No way anyone can bypass it, The hackers will just waste their times there :)</p>
                </div>

                <div class="chat-message">
                    <span class="username">ADMIN:</span>
                    <p>I don't know why but I have a bad feeling about this, you spent weeks only on securing the SSRF, it is not the only vulnerability in the world</p>
                </div>

                <div class="chat-message">
                    <span class="username">ADMIN:</span>
                    <p>And when I told you to build a CONSOLE, I didn’t mean a JS console. I already have F12 on my keyboard.</p>
                </div>

                <div class="chat-message">
                    <span class="username">BZR:</span>
                    <p>I thought you meant like... a frontend console. You said "make it interactive"</p>
                </div>

                <div class="chat-message">
                    <span class="username">ADMIN:</span>
                    <p>And what’s that bot is even about?</p>
                </div>

                <div class="chat-message">
                    <span class="username">BZR:</span>
                    <p>I set it up to check any internal fetchs for security reason you know , and it working on different container so ...</p>
                </div>

                <div class="chat-message">
                    <span class="username">ADMIN:</span>
                    <p>Okay, about that contact button in check.php, don't forget to make it work. Last time I checked, it was doing nothing. And send the TCP connection via Tor network proxies.</p>
                </div>

                <div class="chat-message">
                    <span class="username">BZR:</span>
                    <p>RIGLE ...</p>
                </div>

            </div>

            <footer class="footer">
                <div class="footer-content">
                    <p class="warning">⚠️ INTERNAL DEVELOPMENT CHAT - CONFIDENTIAL ⚠️</p>
                    <p>This chat is for development team only.</p>
                    <p>Unauthorized access will be logged and reported.</p>
                </div>
            </footer>
        </body>
        </html>
        HTML;
    }
}
?>
