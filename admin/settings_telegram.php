<?php
/**
 * CRM AI Consultant — Налаштування Telegram
 * Окремий файл для всіх параметрів Telegram
 */
if (!defined('CRM_AI_CONSULTANT')) die('Access denied');
?>

<div id="settings_telegram" class="channel-settings <?= ($edit_site['default_channel'] ?? 'telegram') === 'telegram' ? '' : 'hidden' ?>">

    <h3 class="text-xl font-medium mb-6 flex items-center gap-3 border-b border-zinc-700 pb-4">
        <i class="fab fa-telegram text-blue-400 text-2xl"></i>
        Налаштування Telegram
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <label class="block text-sm text-zinc-400 mb-2">Telegram Bot Token</label>
            <input type="text" name="telegram_token" 
                   value="<?= htmlspecialchars($edit_site['telegram_token'] ?? '') ?>" 
                   class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 font-mono text-sm">
            <p class="text-xs text-zinc-500 mt-1">Отримати у @BotFather</p>
        </div>

        <div>
            <label class="block text-sm text-zinc-400 mb-2">Telegram Chat ID</label>
            <input type="text" name="telegram_chat_id" 
                   value="<?= htmlspecialchars($edit_site['telegram_chat_id'] ?? '') ?>" 
                   class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
            <p class="text-xs text-zinc-500 mt-1">Отримати у @userinfobot</p>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <label class="block text-sm text-zinc-400 mb-2">Parse Mode</label>
            <select name="telegram_parse_mode" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                <option value="MarkdownV2" <?= ($edit_site['telegram_parse_mode'] ?? 'MarkdownV2') === 'MarkdownV2' ? 'selected' : '' ?>>MarkdownV2 — рекомендовано</option>
                <option value="Markdown" <?= ($edit_site['telegram_parse_mode'] ?? '') === 'Markdown' ? 'selected' : '' ?>>Markdown</option>
                <option value="HTML" <?= ($edit_site['telegram_parse_mode'] ?? '') === 'HTML' ? 'selected' : '' ?>>HTML</option>
                <option value="" <?= empty($edit_site['telegram_parse_mode']) ? 'selected' : '' ?>>Без форматування</option>
            </select>
        </div>

        <div>
            <label class="block text-sm text-zinc-400 mb-2">Thread ID (для тем у супергрупі)</label>
            <input type="text" name="telegram_thread_id" 
                   value="<?= htmlspecialchars($edit_site['telegram_thread_id'] ?? '') ?>" 
                   class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4" placeholder="0">
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="telegram_disable_notification" value="1" 
                       <?= !empty($edit_site['telegram_disable_notification']) ? 'checked' : '' ?>>
                <span class="text-sm">Тихе повідомлення (без звуку)</span>
            </label>
        </div>
        <div>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="telegram_protect_content" value="1" 
                       <?= !empty($edit_site['telegram_protect_content']) ? 'checked' : '' ?>>
                <span class="text-sm">Захистити від копіювання та пересилання</span>
            </label>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <label class="block text-sm text-zinc-400 mb-2">Кількість спроб відправки</label>
            <input type="number" name="telegram_retry_attempts" min="1" max="10" 
                   value="<?= (int)($edit_site['telegram_retry_attempts'] ?? 3) ?>" 
                   class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
        </div>
        <div>
            <label class="block text-sm text-zinc-400 mb-2">Затримка між спробами (секунди)</label>
            <input type="number" name="telegram_retry_delay" min="1" max="10" 
                   value="<?= (int)($edit_site['telegram_retry_delay'] ?? 2) ?>" 
                   class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
        </div>
    </div>

</div>