<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['api'])) {
    $api_url = $_POST['api'];

    // Extract hitman ID from the URL
    if (preg_match('/\/\$(\w+)$/', $api_url, $matches)) {
        $hitman_id = $matches[1];
        
        // Hitman availability data 
        $hitmen = [
            '47' => ['available' => true, 'status' => 'Ready for work'],
            'musk' => ['available' => false, 'status' => 'On Mars'],
            'week' => ['available' => true, 'status' => 'Taking a week off'],
            'dexter' => ['available' => false, 'status' => 'In witness protection'],
            'jihadi' => ['available' => true, 'status' => 'Ready for work'],
            'jack' => ['available' => true, 'status' => 'Ready for work']
        ];

        if (isset($hitmen[$hitman_id])) {
            $hitman = $hitmen[$hitman_id];
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Hitman Availability Check</title>
                <link rel="stylesheet" href="css/check.css">
            </head>
            <body>
                <div class="title">
                    <h1>Hitman Status</h1>
                </div>
                <div class="welcome-card">
                    <h2><?php echo ucfirst($hitman_id); ?></h2>
                    <p class="status <?php echo $hitman['available'] ? 'available' : 'unavailable'; ?>">
                        <?php echo $hitman['available'] ? 'Available!' : 'Unavailable'; ?>
                    </p>
                    <p class="details"><?php echo $hitman['status']; ?></p>
                    <div class="button-container">
                        <a href="#" class="button">Contact</a>
                    </div>
                </div>
                <footer class="footer">
                    <p>&copy; 2023 Hitman Availability Check. All rights reserved.</p>
                </footer>
            </body>
            </html>
            <?php
        } else {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Error - Hitman Not Found</title>
                <link rel="stylesheet" href="style.css">
            </head>
            <body>
                <div class="title">
                    <h1>Error</h1>
                </div>
                <div class="welcome-card">
                    <p class="error">Hitman not found</p>
                </div>

            </body>
            </html>
            <?php
        }
    } 

   
    #if any internal fetch happen , let the bot visite it 
    if (strpos($api_url, 'console.php?cmd=fetch') !== false) {
        $api_url_decoded = urldecode($api_url);
        file_put_contents('/var/bot/queue.txt', $api_url_decoded . PHP_EOL, FILE_APPEND);
    }
    
    if (strpos($api_url, '/api.php') !== false) {
        return;
    }


    try {
        
       // Remove LFI by only allowing http/https URLs
        if (strpos($api_url, 'http://')) {
            return '';
        }
        
        #SSRF vulnerability
         $response = @file_get_contents($api_url);
    
         if ($response === false) {
              throw new Exception("Failed to fetch URL: " . $api_url);
         }
    
         echo $response;

      } catch (Exception $e) {
          echo "Error: " . $e->getMessage();
      }    
  

} else {
    header("Location: home.php");
    exit;
}
?>
