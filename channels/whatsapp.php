<?php
/**
 * CRM AI Consultant — Канал WhatsApp
 * Version: 2.6.6 — Повна робоча версія
 * 
 * Бот пропонує користувачу писати безпосередньо в WhatsApp
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}

/**
 * Обробка повідомлення через WhatsApp
 */
function crm_ai_send_to_whatsapp($site_id, $session, $user_message) {
    
    // Завантажуємо налаштування сайту
    $site_file = dirname(__DIR__) . '/sites/' . $site_id . '.json';
    if (!file_exists($site_file)) {
        return ['success' => false, 'message' => 'Налаштування сайту не знайдено'];
    }

    $settings = json_decode(file_get_contents($site_file), true);

    $whatsapp_number = trim($settings['whatsapp_number'] ?? '');
    $welcome_text    = trim($settings['whatsapp_welcome_text'] ?? '');

    // Зберігаємо повідомлення користувача
    crm_ai_save_message($site_id, $session, $user_message, 'client');

    if (!empty($whatsapp_number)) {
        // Створюємо пряме посилання на чат у WhatsApp
        $whatsapp_link = "https://wa.me/" . preg_replace('/[^0-9]/', '', $whatsapp_number);

        $reply = ($welcome_text ?: "Я отримав ваше повідомлення!") . "\n\n"
               . "Найшвидше я відповідаю в **WhatsApp**.\n\n"
               . "👉 [Написати мені в WhatsApp](" . $whatsapp_link . ")";

        crm_ai_save_message($site_id, $session, $reply, 'bot');

        return [
            'success' => true,
            'message' => $reply
        ];
    } 
    else {
        // Якщо номер не вказаний
        $reply = "WhatsApp канал ще налаштовується.\n\n"
               . "Напишіть мені в **Telegram** — я відповім швидко.";

        crm_ai_save_message($site_id, $session, $reply, 'bot');

        return [
            'success' => true,
            'message' => $reply
        ];
    }
}
