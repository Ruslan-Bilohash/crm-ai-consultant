# 🤖 CRM AI-konsulent

**Universelt AI-chatsystem** med individuelle innstillinger for hvert nettsted. Støtter flere kommunikasjonskanaler, full kommunikasjonshistorikk og et moderne administrasjonspanel.

---

## ✨ Hovedfunksjoner

- Koble widgeten til **hvilket som helst nettsted** med én linje med kode
- Helt uavhengige innstillinger for hvert nettsted (design, kanal, API-nøkler)
- Kanalstøtte: **Telegram, OpenAI (GPT), Grok (xAI), WhatsApp, Viber**
- Individuelt chatdesign (farger, ikon, posisjon, hilsen, automatisk åpning)
- Fullstendig historikk over alle samtaler i administrasjonspanelet
- Automatisk generering av `site_id` fra nettstedsdomenet
- Sjekk av tilgjengeligheten til widgeten på nettstedet
- Responsivt og moderne grensesnitt

---

## 📸 Skjermbilder

### Adminpanel — Liste over nettsteder
![Adminpanel — Liste over nettsteder](screen/admin.jpg)

### Nettstedinnstillinger
![Nettstedinnstillinger](screen/admin-site-settings.jpg)

### Chat-widget på nettstedet
![Chat-widget på nettstedet](screen/wigets.jpg)

---
### 3. Samtale historikk
![Samtalehistorikk](screen/conversations.jpg)

### 4. Vise en separat samtale
![Vise en samtale](screen/conversations_screen.jpg)

### 5. Chat-widget på nettstedet (eksempel på en melding i Telegram)
![Chat-widget på nettstedet](screen/telegram_message.jpg)
## 🚀 Installasjon

1. Last opp alle filene til `/ai/crm/`-mappen på serveren din
2. Opprett mappene `sites/` og `conversations/`
3. Angi tilgangsrettigheter:
- Mapper: `755`
- Filer: `644`
4. Gå til administrasjonspanelet: `https://your-site.com/ai/crm/admin/`
5. Logg inn med passordet `12345` (påkrevd, endre det!)

---

## Slik bruker du

1. Legg til et nytt nettsted i administrasjonspanelet
2. Fyll ut innstillingene (kanal, API nøkler, chatdesign)
3. Kopier den genererte koden
4. Lim den inn på nettstedet ditt før `</body>`-taggen:

API-nøkler

Telegram: Bot-token + Chat-ID
OpenAI: platform.openai.com/api-keys
Grok (xAI): x.ai/api

Kanal, Status, Merknad
Telegram, ✅ Fungerer fullt, Raskeste kanal

Grok (xAI), ✅ Fungerer fullt, Autosvar

OpenAI, ✅ Fungerer fullt, Autosvar

WhatsApp, ⚙️ Under utvikling, Manuell modus for nå

Viber, ⚙️ Under utvikling, Manuell modus for nå

```html
<script src="https://bilohash.com/ai/crm/index.php?site=your_site_id"></script>

crm-ai-consultant/
├── index.php # Hovedwidgetfil
├── config.php
├── admin/
│ ├── index.php # Liste over nettsteder
│ ├── sites.php # Nettstedinnstillinger
│ ├── conversations.php # Chattelogg
│ ├── navigation.php
│ └── footer.php
├── sites/ # Nettstedinnstillinger JSON-filer
├── conversations/ # Alle samtalelogger
├── channels/
│ ├── telegram.php
│ ├── openai.php
│ ├── grok.php
│ ├── whatsapp.php
│ └── viber.php
├── ressurser/
│ ├── chat.js
│ └── stil.css
└── inkluderer/
├── funksjoner.php
└── get-messages.php
