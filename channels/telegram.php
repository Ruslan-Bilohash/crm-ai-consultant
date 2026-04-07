<?php
/**
 * CRM AI Consultant — Канал Telegram (спрощена стабільна версія)
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}

function crm_ai_send_to_telegram($site_id, $session, $message, $user_name = 'Користувач') {
    
    $site_file = dirname(__DIR__) . '/sites/' . $site_id . '.json';
    if (!file_exists($site_file)) {
        error_log("Telegram: Site file not found - " . $site_id);
        return ['success' => false, 'message' => 'Налаштування сайту не знайдено'];
    }

    $settings = json_decode(file_get_contents($site_file), true);
    
    $token   = trim($settings['telegram_token'] ?? '');
    $chat_id = trim($settings['telegram_chat_id'] ?? '');

    if (empty($token) || empty($chat_id)) {
        error_log("Telegram: Token or Chat ID empty for site " . $site_id);
        return ['success' => false, 'message' => 'Telegram не налаштовано'];
    }

    $text = "🔔 Нове повідомлення з сайту\n\n";
    $text .= "🌐 Сайт: " . ($settings['name'] ?? $site_id) . "\n";
    $text .= "👤 Користувач: " . $user_name . "\n";
    $text .= "💬 Повідомлення:\n" . $message . "\n\n";
    $text .= "🕒 " . date('d.m.Y H:i:s');

    $url = "https://api.telegram.org/bot{$token}/sendMessage";

    $postData = [
        'chat_id' => $chat_id,
        'text'    => $text,
        'parse_mode' => 'Markdown'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($curl_error) {
        error_log("Telegram cURL error: " . $curl_error);
        return ['success' => false, 'message' => 'Помилка з\'єднання'];
    }

    $result = json_decode($response, true);

    if ($http_code === 200 && !empty($result['ok'])) {
        crm_ai_save_message($site_id, $session, $message, 'client');
        crm_ai_save_message($site_id, $session, "✅ Повідомлення надіслано в Telegram", 'bot');
        return ['success' => true, 'message' => 'Надіслано в Telegram'];
    } else {
        $error = $result['description'] ?? 'Unknown error';
        error_log("Telegram API Error: " . $error . " | Site: " . $site_id);
        return ['success' => false, 'message' => 'Помилка Telegram API'];
    }
}
