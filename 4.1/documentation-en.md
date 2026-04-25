# CRM AI Consultant — Documentation (English)

**Version 4.1** — Universal Multi-Channel AI Chat System

A powerful self-hosted PHP + MySQL AI chat widget with support for **Grok (xAI), OpenAI, Telegram, WhatsApp, and Viber**.

---

## 1. Introduction

**CRM AI Consultant** is a universal two-way AI chat system that allows you to connect a smart widget to any website (WordPress, Tilda, pure HTML, Laravel, Shopify, etc.).

Each website has **completely individual settings**:
- Custom chat design and colors
- Own system prompt
- Preferred communication channel
- Separate conversation history
- API keys

---

## 2. What's New in Version 4.1 (April 25, 2026)

- **⚡ Major speed improvement** — System prompt is now saved to a file (`sites/{site_id}_prompt.txt`)
- **Caching system** — Site settings are cached for faster performance
- **Send to Telegram option** — Duplicate messages to Telegram even when using Grok or OpenAI
- **Optimized Grok and OpenAI handlers**
- **Improved stability and error handling**

---

## 3. Project Structure

```bash
crm-ai-consultant/
├── index.php                 ← Main widget file (serves JS config + handles AJAX)
├── config.php                ← Database and system configuration
├── version.php               ← Current version
├── documentation.html        ← HTML documentation
├── changelog.html            ← Version history
├── crm-ai-error.log          ← Error log (auto-created)
│
├── admin/
│   ├── index.php             ← Dashboard (list of sites)
│   ├── sites.php             ← Edit site settings
│   ├── conversations.php     ← View all conversations
│   ├── login.php             ← Admin login
│   └── ...                   ← Other admin files
│
├── sites/                    ← Site configurations + prompt files
│   └── cache/                ← Cached settings (performance)
│
├── conversations/            ← Chat history (stored in MySQL)
│
├── channels/
│   ├── telegram.php
│   ├── grok.php
│   ├── openai.php
│   ├── whatsapp.php
│   └── viber.php
│
├── assets/
│   ├── chat.js               ← Frontend chat widget
│   └── style.css
│
└── includes/
    ├── functions.php         ← Core functions
    ├── get-messages.php
    └── get-conversation.php
