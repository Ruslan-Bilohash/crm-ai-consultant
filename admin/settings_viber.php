<?php
/**
 * CRM AI Consultant — Налаштування Viber
 * Version: 2.6.6 — Повноцінний блок налаштувань
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}
?>

<div id="settings_viber" class="channel-settings <?= ($edit_site['default_channel'] ?? '') === 'viber' ? '' : 'hidden' ?>">

    <h3 class="text-xl font-medium mb-6 flex items-center gap-3 border-b border-zinc-700 pb-4">
        <i class="fab fa-viber text-purple-500 text-2xl"></i>
        Налаштування Viber
    </h3>

    <div class="space-y-8">

        <div>
            <label class="block text-sm text-zinc-400 mb-2">Viber Номер (на який приходять повідомлення)</label>
            <input type="text" name="viber_number" 
                   value="<?= htmlspecialchars($edit_site['viber_number'] ?? '') ?>" 
                   class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 font-mono"
                   placeholder="+380671234567">
            <p class="text-xs text-zinc-500 mt-2">Введи свій Viber номер у міжнародному форматі</p>
        </div>

        <div>
            <label class="block text-sm text-zinc-400 mb-3">Повідомлення, яке покаже бот користувачу</label>
            <textarea name="viber_welcome_text" rows="5" 
                      class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4"><?= htmlspecialchars($edit_site['viber_welcome_text'] ?? "Я отримав ваше повідомлення!\n\nНайшвидше я відповідаю в Viber.\nНапишіть мені туди:") ?></textarea>
        </div>

        <div class="p-6 bg-zinc-950 border border-purple-900/30 rounded-2xl">
            <p class="text-sm text-purple-300">
                <strong>Важливо:</strong> Viber не дозволяє автоматично надсилати перше повідомлення користувачу (на відміну від Telegram). 
                Тому бот буде пропонувати клієнту написати вам безпосередньо в Viber.
            </p>
        </div>

    </div>
</div>
