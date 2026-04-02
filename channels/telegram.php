<?php
/**
 * CRM AI Consultant — Канал Telegram
 * Version: 2.5.0
 * Надсилає повідомлення в Telegram з підтримкою site_id
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}

function crm_ai_send_to_telegram($site_id, $session, $message, $user_name = 'Користувач') {
    
    // Завантажуємо налаштування конкретного сайту
    $site_file = dirname(__DIR__) . '/sites/' . $site_id . '.json';
    if (!file_exists($site_file)) {
        return ['success' => false, 'message' => 'Налаштування сайту не знайдено'];
    }

    $settings = json_decode(file_get_contents($site_file), true);
    
    if (empty($settings['telegram_token']) || empty($settings['telegram_chat_id'])) {
        return ['success' => false, 'message' => 'Telegram не налаштовано для цього сайту'];
    }

    $token = $settings['telegram_token'];
    $chat_id = $settings['telegram_chat_id'];

    $text = "🔔 *Нове повідомлення з сайту*\n\n";
    $text .= "🌐 *Сайт:* " . ($settings['name'] ?? $site_id) . "\n";
    $text .= "👤 *Користувач:* " . $user_name . "\n";
    $text .= "💬 *Повідомлення:*\n" . $message . "\n\n";
    $text .= "🕒 " . date('d.m.Y H:i:s');

    $url = "https://api.telegram.org/bot{$token}/sendMessage";

    $postData = [
        'chat_id'    => $chat_id,
        'text'       => $text,
        'parse_mode' => 'Markdown'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 200) {
        // Зберігаємо повідомлення в історію
        crm_ai_save_message($site_id, $session, $message, 'client');
        crm_ai_save_message($site_id, $session, "Повідомлення надіслано в Telegram", 'bot');
        
        return ['success' => true, 'message' => 'Повідомлення надіслано в Telegram'];
    } else {
        return ['success' => false, 'message' => 'Помилка Telegram API'];
    }
}