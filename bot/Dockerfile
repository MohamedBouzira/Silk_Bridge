FROM node:20-slim

WORKDIR /usr/src/app

# Install Chromium manually
RUN apt-get update && \
    apt-get install -y chromium && \
    rm -rf /var/lib/apt/lists/*


# Copy package.json and install puppeteer (without Chromium)
RUN PUPPETEER_SKIP_DOWNLOAD=true npm install puppeteer 

COPY . .

CMD ["node", "bot.js"]

