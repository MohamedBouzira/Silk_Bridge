<?php  

$serverIp = $_SERVER['SERVER_ADDR'];
$clientIp = $_SERVER['REMOTE_ADDR'];
$user_agent = 'PuppeteerBot/1.0 (SecureConsole)';


$server_parts = explode('.', $serverIp);
$client_parts = explode('.', $clientIp);


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    
    if ($server_parts[0] !== $client_parts[0] || $server_parts[1] !== $client_parts[1]) {
        http_response_code(403);
        echo 'access only from localnetwork!';
    } else {
        if (
            !isset($_SERVER['HTTP_USER_AGENT']) || $_SERVER['HTTP_USER_AGENT'] !== $user_agent
          
        ) {
            echo 'we secure it against ssrf';
        }  else {
            echo 'nexus{ssrf_2_xss_bzr_should_not_code}';
        }
    }
}
