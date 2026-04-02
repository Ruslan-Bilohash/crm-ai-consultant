<?php
/**
 * CRM AI Consultant — Канал OpenAI (ChatGPT)
 * Version: 2.5.1
 * Наразі заглушка (як і Grok)
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}

function crm_ai_send_to_openai($site_id, $session, $user_message) {
    
    // Завантажуємо налаштування сайту
    $site_file = dirname(__DIR__) . '/sites/' . $site_id . '.json';
    if (!file_exists($site_file)) {
        return ['success' => false, 'message' => 'Налаштування сайту не знайдено'];
    }

    $settings = json_decode(file_get_contents($site_file), true);

    // Заглушка на продакшені
    $reply = "OpenAI API наразі в тестовому режимі.\n\nВикористовуйте Telegram для отримання швидких відповідей.";

    // Зберігаємо в історію розмови
    crm_ai_save_message($site_id, $session, $user_message, 'client');
    crm_ai_save_message($site_id, $session, $reply, 'bot');

    return [
        'success' => true,
        'message' => $reply
    ];
}