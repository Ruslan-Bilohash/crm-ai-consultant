<?php
if (!defined('CRM_AI_CONSULTANT')) die('Access denied');
?>

<div id="settings_whatsapp" class="channel-settings <?= ($edit_site['default_channel'] ?? '') === 'whatsapp' ? '' : 'hidden' ?>">

    <h3 class="text-xl font-medium mb-6 flex items-center gap-3 border-b border-zinc-700 pb-4">
        <i class="fab fa-whatsapp text-green-400 text-2xl"></i>
        Налаштування WhatsApp
    </h3>

    <div>
        <label class="block text-sm text-zinc-400 mb-2">WhatsApp Number (Business API)</label>
        <input type="text" name="whatsapp_number" 
               value="<?= htmlspecialchars($edit_site['whatsapp_number'] ?? '') ?>" 
               class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4" 
               placeholder="+380XXXXXXXXX">
    </div>

</div>