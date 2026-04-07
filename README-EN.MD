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

crm-ai-consultant/
├── index.php # Main widget file (downloaded from the site)
├── config.php # Basic project settings
├── version.php # Current system version (v2.7.0)
├── admin/
│ ├── index.php # List of all sites
│ ├── sites.php # Settings for one site (main file)
│ ├── conversations.php # List of all conversations
│ ├── get-conversation.php # AJAX loading of a conversation into a modal window
│ ├── navigation.php # Admin panel header
│ └── footer.php # Admin panel footer
├── sites/ # JSON files with settings for each site
├── conversations/ # JSON files with the history of all chats
├── channels/ # Logic of each channel
│ ├── telegram.php # Sending messages to Telegram
│ ├── openai.php # Working with OpenAI (ChatGPT)
│ ├── grok.php # Working with Grok (xAI)
│ ├── whatsapp.php # WhatsApp logic
│ └── viber.php # Viber logic
├── assets/
│ ├── chat.js # Main widget JavaScript (button, window, message)
│ └── style.css # Additional widget styles
└── includes/
├── functions.php # General functions (saving, processing messages, etc.)
└── get-messages.php # Auxiliary file for receiving messages
