<?php
if (!defined('CRM_AI_CONSULTANT')) die('Access denied');
?>

<div id="settings_viber" class="channel-settings <?= ($edit_site['default_channel'] ?? '') === 'viber' ? '' : 'hidden' ?>">

    <h3 class="text-xl font-medium mb-6 flex items-center gap-3 border-b border-zinc-700 pb-4">
        <i class="fab fa-viber text-purple-500 text-2xl"></i>
        Налаштування Viber
    </h3>

    <div>
        <label class="block text-sm text-zinc-400 mb-2">Viber Number (Business API)</label>
        <input type="text" name="viber_number" 
               value="<?= htmlspecialchars($edit_site['viber_number'] ?? '') ?>" 
               class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4" 
               placeholder="+380XXXXXXXXX">
    </div>

</div>