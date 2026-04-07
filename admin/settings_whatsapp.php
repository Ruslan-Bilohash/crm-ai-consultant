<?php
/**
 * CRM AI Consultant — Налаштування WhatsApp
 * Version: 2.6.6
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}
?>

<div id="settings_whatsapp" class="channel-settings <?= ($edit_site['default_channel'] ?? '') === 'whatsapp' ? '' : 'hidden' ?>">

    <h3 class="text-xl font-medium mb-6 flex items-center gap-3 border-b border-zinc-700 pb-4">
        <i class="fab fa-whatsapp text-green-400 text-2xl"></i>
        Налаштування WhatsApp
    </h3>

    <div class="space-y-8">

        <!-- WhatsApp номер -->
        <div>
            <label class="block text-sm text-zinc-400 mb-2">WhatsApp Номер (міжнародний формат)</label>
            <input type="text" name="whatsapp_number" 
                   value="<?= htmlspecialchars($edit_site['whatsapp_number'] ?? '') ?>" 
                   class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 font-mono"
                   placeholder="+380671234567">
            <p class="text-xs text-zinc-500 mt-2">
                Введіть номер WhatsApp, на який ви хочете отримувати повідомлення від клієнтів.
            </p>
        </div>

        <!-- Повідомлення, яке показує бот -->
        <div>
            <label class="block text-sm text-zinc-400 mb-3">Повідомлення користувачу при виборі WhatsApp</label>
            <textarea name="whatsapp_welcome_text" rows="5" 
                      class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4"><?= htmlspecialchars($edit_site['whatsapp_welcome_text'] ?? "Я отримав ваше повідомлення!\n\nНайшвидше я відповідаю в WhatsApp.") ?></textarea>
        </div>

        <!-- Автовідповідь -->
        <div>
            <label class="block text-sm text-zinc-400 mb-3">Автовідповідь (перше повідомлення)</label>
            <textarea name="whatsapp_auto_reply" rows="3" 
                      class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4"><?= htmlspecialchars($edit_site['whatsapp_auto_reply'] ?? "Дякую за ваше повідомлення! Я зв'яжуся з вами якнайшвидше.") ?></textarea>
        </div>

        <!-- Статус каналу -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label class="block text-sm text-zinc-400 mb-2">Статус WhatsApp каналу</label>
                <select name="whatsapp_status" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    <option value="active" <?= ($edit_site['whatsapp_status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Активний</option>
                    <option value="coming_soon" <?= ($edit_site['whatsapp_status'] ?? '') === 'coming_soon' ? 'selected' : '' ?>>Скоро буде доступний</option>
                    <option value="disabled" <?= ($edit_site['whatsapp_status'] ?? '') === 'disabled' ? 'selected' : '' ?>>Вимкнено</option>
                </select>
            </div>

            <div>
                <label class="block text-sm text-zinc-400 mb-2">Тип WhatsApp</label>
                <select name="whatsapp_type" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    <option value="personal" <?= ($edit_site['whatsapp_type'] ?? 'personal') === 'personal' ? 'selected' : '' ?>>Особистий номер</option>
                    <option value="business" <?= ($edit_site['whatsapp_type'] ?? '') === 'business' ? 'selected' : '' ?>>WhatsApp Business</option>
                    <option value="api" <?= ($edit_site['whatsapp_type'] ?? '') === 'api' ? 'selected' : '' ?>>WhatsApp Business API</option>
                </select>
            </div>
        </div>

        <div class="p-6 bg-zinc-950 border border-green-900/30 rounded-2xl text-sm">
            <strong>Примітка:</strong> Наразі WhatsApp не дозволяє легко надсилати автоматичні відповіді без Business API. 
            Тому бот буде пропонувати клієнту писати вам безпосередньо в WhatsApp.
        </div>

    </div>
</div>
