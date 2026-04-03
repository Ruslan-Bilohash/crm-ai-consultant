<?php
/**
 * CRM AI Consultant — Налаштування OpenAI (ChatGPT)
 * Повна версія з API ключем, вибором моделі, привітанням та системним промптом
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}
?>

<div id="settings_openai" class="channel-settings <?= ($edit_site['default_channel'] ?? '') === 'openai' ? '' : 'hidden' ?>">

    <h3 class="text-xl font-medium mb-6 flex items-center gap-3 border-b border-zinc-700 pb-4">
        <i class="fas fa-brain text-purple-400 text-2xl"></i>
        Налаштування OpenAI (ChatGPT)
    </h3>

    <div class="space-y-10">

        <!-- API Key -->
        <div>
            <label class="block text-sm text-zinc-400 mb-2">OpenAI API Key</label>
            <input type="text" name="openai_api_key"
                   value="<?= htmlspecialchars($edit_site['openai_api_key'] ?? '') ?>"
                   class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 font-mono text-sm"
                   placeholder="sk-proj-................................">
            <p class="text-xs text-zinc-500 mt-2">
                Отримати ключ: <a href="https://platform.openai.com/api-keys" target="_blank" class="text-sky-400 hover:underline">platform.openai.com/api-keys</a>
            </p>
        </div>

        <!-- Привітальне повідомлення -->
        <div>
            <label class="block text-sm text-zinc-400 mb-3">👋 Привітальне повідомлення</label>
            <textarea name="welcome_text" rows="4" 
                      class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4"><?= htmlspecialchars($edit_site['welcome_text'] ?? 'Добрий день! Як я можу допомогти вам сьогодні?') ?></textarea>
            <p class="text-xs text-zinc-500 mt-2">Перше повідомлення, яке побачить клієнт при відкритті чату.</p>
        </div>

        <!-- Системний промпт -->
        <div>
            <label class="block text-sm text-zinc-400 mb-3">🧠 Системний промпт (Інструкція для бота)</label>
            <textarea name="openai_system_prompt" rows="16" 
                      class="w-full bg-zinc-900 border border-zinc-700 rounded-2xl px-6 py-5 font-mono text-sm leading-relaxed"><?= htmlspecialchars($edit_site['openai_system_prompt'] ?? 'Ти — професійний та дружній AI-консультант. Відповідай українською мовою, чітко, по суті та максимально корисно. Намагайся швидко зрозуміти потреби клієнта.') ?></textarea>
            <p class="text-xs text-amber-400 mt-3">
                <strong>Найважливіше поле!</strong><br>
                Опиши роль бота, послуги, стиль спілкування, правила та цілі.
            </p>
        </div>

        <!-- Модель + Температура -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-zinc-700">
            <div>
                <label class="block text-sm text-zinc-400 mb-2">Модель OpenAI</label>
                <select name="ai_model" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    <option value="gpt-4o" <?= ($edit_site['ai_model'] ?? '') === 'gpt-4o' ? 'selected' : '' ?>>gpt-4o — Найкраща універсальна (рекомендовано)</option>
                    <option value="gpt-4o-mini" <?= ($edit_site['ai_model'] ?? '') === 'gpt-4o-mini' ? 'selected' : '' ?>>gpt-4o-mini — Швидка та економна</option>
                    <option value="o1-preview" <?= ($edit_site['ai_model'] ?? '') === 'o1-preview' ? 'selected' : '' ?>>o1-preview — Найрозумніша з міркуванням</option>
                    <option value="gpt-4.5-turbo" <?= ($edit_site['ai_model'] ?? '') === 'gpt-4.5-turbo' ? 'selected' : '' ?>>gpt-4.5-turbo</option>
                    <option value="gpt-4-turbo" <?= ($edit_site['ai_model'] ?? '') === 'gpt-4-turbo' ? 'selected' : '' ?>>gpt-4-turbo</option>
                </select>
            </div>

            <div>
                <label class="block text-sm text-zinc-400 mb-2">Температура (креативність)</label>
                <select name="openai_temperature" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    <option value="0.3" <?= ($edit_site['openai_temperature'] ?? '0.7') === '0.3' ? 'selected' : '' ?>>0.3 — Точна</option>
                    <option value="0.7" <?= ($edit_site['openai_temperature'] ?? '0.7') === '0.7' ? 'selected' : '' ?>>0.7 — Збалансована (рекомендовано)</option>
                    <option value="1.0" <?= ($edit_site['openai_temperature'] ?? '0.7') === '1.0' ? 'selected' : '' ?>>1.0 — Креативна</option>
                    <option value="1.3" <?= ($edit_site['openai_temperature'] ?? '0.7') === '1.3' ? 'selected' : '' ?>>1.3 — Дуже креативна</option>
                </select>
            </div>
        </div>

    </div>
</div>