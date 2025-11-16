const puppeteer = require('puppeteer');
const fs = require('fs');

const queuePath = '/usr/src/app/queue.txt';

(async () => {
  console.log("[*] Launching browser...");
  const browser = await puppeteer.launch({
    headless: 'new',
    executablePath: '/usr/bin/chromium',
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });

  console.log("[*] Browser launched.");
  const page = await browser.newPage();
  await page.setUserAgent('PuppeteerBot/1.0 (SecureConsole)');

  await page.setExtraHTTPHeaders({
    'X-API-Key': 'aw2@128LmbIqar%f8A'
  });

  while (true) {
    console.log("[*] Checking queue...");
    if (fs.existsSync(queuePath)) {
      const lines = fs.readFileSync(queuePath, 'utf-8').split('\n').filter(Boolean);
      console.log(`[+] Queue has ${lines.length} link(s)`);

      if (lines.length > 0) {
        for (const url of lines) {
          try {
            console.log(`[+] Visiting: ${url}`);
            await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 15000 });
            await new Promise(resolve => setTimeout(resolve, 3000));
            console.log(`[+] Done visiting: ${url}`);
          } catch (e) {
            console.error(`[-] Failed to visit ${url}: ${e.message}`);
          }
        }

        // Clear the queue after all links processed
        fs.writeFileSync(queuePath, '');
        console.log("[*] Queue cleared.");
      }
    } else {
      console.log("[-] queue.txt not found!");
    }

    await new Promise(resolve => setTimeout(resolve, 5000)); // Wait 5s before next check
  }

  // Unreachable:
  // await browser.close();
})();

