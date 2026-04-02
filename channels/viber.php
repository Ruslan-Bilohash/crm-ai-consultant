<?php
/**
 * CRM AI Consultant — Канал Viber
 * Version: 2.5.0
 * Заглушка (реальна інтеграція в розробці)
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}

function crm_ai_send_to_viber($site_id, $session, $user_message) {
    
    $site_file = dirname(__DIR__) . '/sites/' . $site_id . '.json';
    if (!file_exists($site_file)) {
        return ['success' => false, 'message' => 'Налаштування сайту не знайдено'];
    }

    $settings = json_decode(file_get_contents($site_file), true);

    $reply = "Viber канал наразі в розробці.\n\nВикористовуйте Telegram для отримання відповідей.";

    // Зберігаємо в історію
    crm_ai_save_message($site_id, $session, $user_message, 'client');
    crm_ai_save_message($site_id, $session, $reply, 'bot');

    return [
        'success' => true,
        'message' => $reply
    ];
}