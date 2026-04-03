<?php
/**
 * CRM AI Consultant — Налаштування Grok (xAI)
 * Повна версія з API ключем, вибором моделі, привітанням та системним промптом
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}
?>

<div id="settings_grok" class="channel-settings <?= ($edit_site['default_channel'] ?? '') === 'grok' ? '' : 'hidden' ?>">

    <h3 class="text-xl font-medium mb-6 flex items-center gap-3 border-b border-zinc-700 pb-4">
        <i class="fas fa-robot text-orange-400 text-2xl"></i>
        Налаштування Grok (xAI)
    </h3>

    <div class="space-y-10">

        <!-- API Key -->
        <div>
            <label class="block text-sm text-zinc-400 mb-2">Grok API Key (xAI)</label>
            <input type="text" name="grok_api_key"
                   value="<?= htmlspecialchars($edit_site['grok_api_key'] ?? '') ?>"
                   class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 font-mono text-sm"
                   placeholder="gsk_................................">
            <p class="text-xs text-zinc-500 mt-2">
                Отримати ключ: <a href="https://x.ai/api" target="_blank" class="text-sky-400 hover:underline">x.ai/api</a>
            </p>
        </div>

        <!-- Привітальне повідомлення -->
        <div>
            <label class="block text-sm text-zinc-400 mb-3">👋 Привітальне повідомлення</label>
            <textarea name="welcome_text" rows="4" 
                      class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4"><?= htmlspecialchars($edit_site['welcome_text'] ?? 'Добрий день! Як я можу допомогти вам сьогодні?') ?></textarea>
        </div>

        <!-- Системний промпт -->
        <div>
            <label class="block text-sm text-zinc-400 mb-3">🧠 Системний промпт (Інструкція для Grok)</label>
            <textarea name="grok_system_prompt" rows="16" 
                      class="w-full bg-zinc-900 border border-zinc-700 rounded-2xl px-6 py-5 font-mono text-sm leading-relaxed"><?= htmlspecialchars($edit_site['grok_system_prompt'] ?? 'Ти — Grok, створений xAI. Будь корисним, чесним, з почуттям гумору. Відповідай українською мовою, допомагай клієнту швидко та ефективно.') ?></textarea>
            <p class="text-xs text-amber-400 mt-3">
                <strong>Найважливіше поле!</strong><br>
                Опиши тут роль бота, стиль спілкування, послуги та правила поведінки.
            </p>
        </div>

        <!-- Модель + Температура -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-zinc-700">
            <div>
                <label class="block text-sm text-zinc-400 mb-2">Модель Grok</label>
                <select name="ai_model" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    <option value="grok-4-1" <?= ($edit_site['ai_model'] ?? '') === 'grok-4-1' ? 'selected' : '' ?>>grok-4-1 — Флагманська</option>
                    <option value="grok-4-1-fast" <?= ($edit_site['ai_model'] ?? '') === 'grok-4-1-fast' ? 'selected' : '' ?>>grok-4-1-fast — Швидка</option>
                    <option value="grok-4-1-reasoning" <?= ($edit_site['ai_model'] ?? '') === 'grok-4-1-reasoning' ? 'selected' : '' ?>>grok-4-1-reasoning — З сильним міркуванням</option>
                    <option value="grok-4-1-mini" <?= ($edit_site['ai_model'] ?? '') === 'grok-4-1-mini' ? 'selected' : '' ?>>grok-4-1-mini — Легка</option>
                </select>
            </div>

            <div>
                <label class="block text-sm text-zinc-400 mb-2">Температура (креативність + гумор)</label>
                <select name="grok_temperature" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    <option value="0.5" <?= ($edit_site['grok_temperature'] ?? '0.8') === '0.5' ? 'selected' : '' ?>>0.5 — Точна</option>
                    <option value="0.8" <?= ($edit_site['grok_temperature'] ?? '0.8') === '0.8' ? 'selected' : '' ?>>0.8 — Збалансована (рекомендовано)</option>
                    <option value="1.2" <?= ($edit_site['grok_temperature'] ?? '0.8') === '1.2' ? 'selected' : '' ?>>1.2 — Креативна з гумором</option>
                    <option value="1.5" <?= ($edit_site['grok_temperature'] ?? '0.8') === '1.5' ? 'selected' : '' ?>>1.5 — Максимально креативна</option>
                </select>
            </div>
        </div>

    </div>
</div>