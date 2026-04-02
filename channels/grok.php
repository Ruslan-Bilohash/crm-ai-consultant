<?php
/**
 * CRM AI Consultant — Канал Grok (xAI)
 * Version: 2.5.0
 * Поки що заглушка (як ти просив раніше)
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}

function crm_ai_send_to_grok($site_id, $session, $user_message) {
    
    // Завантажуємо налаштування сайту
    $site_file = dirname(__DIR__) . '/sites/' . $site_id . '.json';
    if (!file_exists($site_file)) {
        return ['success' => false, 'message' => 'Налаштування сайту не знайдено'];
    }

    $settings = json_decode(file_get_contents($site_file), true);

    // Заглушка на продакшені
    $reply = "Grok API ще в розробці.\n\nВикористовуйте OpenAI або Telegram для отримання відповідей.";

    // Зберігаємо в історію
    crm_ai_save_message($site_id, $session, $user_message, 'client');
    crm_ai_save_message($site_id, $session, $reply, 'bot');

    return [
        'success' => true,
        'message' => $reply
    ];
}