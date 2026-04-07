# 🤖 CRM AI Consultant

**Universal AI chat system** with individual settings for each site.
Supports multiple communication channels, full communication history and a modern admin panel.

---

## ✨ Main features

- Connecting the widget to **any site** with one line of code
- Completely independent settings for each site (design, channel, API keys)
- Channel support: **Telegram, OpenAI (GPT), Grok (xAI), WhatsApp, Viber**
- Individual chat design (colors, icon, position, greeting, auto-opening)
- Full history of all conversations in the admin panel
- Automatic generation of `site_id` from the site domain
- Checking the availability of the widget on the site
- Responsive and modern interface

---

## 📸 Screenshots

### Admin panel — List of sites
![Admin panel — List of sites](screen/admin.jpg)

### Site settings
![Site settings](screen/admin-site-settings.jpg)

### Chat widget on the site
![Chat widget on the site](screen/wigets.jpg)

---
### 3. Conversation history
![Conversation history](screen/conversations.jpg)

### 4. Viewing a separate conversation
![Viewing a conversation](screen/conversations_screen.jpg)

### 5. Chat widget on the site (example of a message in Telegram)
![Chat widget on the site](screen/telegram_message.jpg)
## 🚀 Installation

1. Upload all files to the `/ai/crm/` folder on your server
2. Create the `sites/` and `conversations/` folders
3. Set access rights:
- Folders: `755`
- Files: `644`
4. Go to the admin panel: `https://your-site.com/ai/crm/admin/`
5. Log in with the password `12345` (required change it!)

---

## How to use

1. Add a new site in the admin panel
2. Fill in the settings (channel, API keys, chat design)
3. Copy the generated code
4. Paste it on your site before the `</body>` tag:

API keys

Telegram: Bot Token + Chat ID
OpenAI: platform.openai.com/api-keys
Grok (xAI): x.ai/api

Channel,Status,Note
Telegram,✅ Fully working,Fastest channel

Grok (xAI),✅ Fully working,Auto replies

OpenAI,✅ Fully working,Auto replies

WhatsApp,⚙️ In development,Manual mode for now

Viber,⚙️ In development,Manual mode for now

```html
<script src="https://bilohash.com/ai/crm/index.php?site=your_site_id"></script>

crm-ai-consultant/
├── index.php # Main widget file
├── config.php
├── admin/
│ ├── index.php # List of sites
│ ├── sites.php # Site settings
│ ├── conversations.php # Chat history
│ ├── navigation.php
│ └── footer.php
├── sites/ # Site settings JSON files
├── conversations/ # All conversation histories
├── channels/
│ ├── telegram.php
│ ├── openai.php
│ ├── grok.php
│ ├── whatsapp.php
│ └── viber.php
├── assets/
│ ├── chat.js
│ └── style.css
└── includes/
├── functions.php
└── get-messages.php
