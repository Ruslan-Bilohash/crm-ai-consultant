<?php
/**
 * CRM AI Consultant — Основні допоміжні функції
 * Version: 2.5.2
 * Повна версія з ініціалізацією папки conversations
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}

/**
 * Ініціалізація папки conversations
 */
function crm_ai_init_conversations_dir() {
    $conv_dir = dirname(__DIR__) . '/conversations';
    if (!is_dir($conv_dir)) {
        mkdir($conv_dir, 0755, true);
    }
    return $conv_dir;
}

/**
 * Збереження повідомлення в історію розмови
 */
function crm_ai_save_message($site_id, $session, $content, $sender = 'bot') {
    $conv_dir = crm_ai_init_conversations_dir();
    
    $safe_session = preg_replace('/[^a-z0-9_]/', '', $session);
    $conv_file = $conv_dir . '/' . $site_id . '_' . $safe_session . '.json';

    $history = [];
    if (file_exists($conv_file)) {
        $history = json_decode(file_get_contents($conv_file), true) ?: [];
    }

    $history[] = [
        'sender'  => $sender,
        'content' => $content,
        'time'    => date('Y-m-d H:i:s')
    ];

    // Обмежуємо історію останніми 50 повідомленнями
    if (count($history) > 50) {
        $history = array_slice($history, -50);
    }

    file_put_contents($conv_file, json_encode($history, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * Отримання всієї історії розмови
 */
function crm_ai_get_conversation($site_id, $session) {
    $conv_dir = crm_ai_init_conversations_dir();
    $safe_session = preg_replace('/[^a-z0-9_]/', '', $session);
    $conv_file = $conv_dir . '/' . $site_id . '_' . $safe_session . '.json';

    if (!file_exists($conv_file)) {
        return [];
    }

    $history = json_decode(file_get_contents($conv_file), true);
    return is_array($history) ? $history : [];
}

/**
 * Головний роутер для відправки повідомлення в обраний канал
 */
function crm_ai_process_message($site_id, $session, $message) {
   
    $site_file = dirname(__DIR__) . '/sites/' . $site_id . '.json';
    if (!file_exists($site_file)) {
        return ['success' => false, 'message' => 'Сайт не знайдено'];
    }

    $settings = json_decode(file_get_contents($site_file), true);
    $channel = $settings['default_channel'] ?? 'telegram';

    switch ($channel) {
        case 'openai':
            return crm_ai_send_to_openai($site_id, $session, $message);
           
        case 'grok':
            return crm_ai_send_to_grok($site_id, $session, $message);
           
        case 'whatsapp':
            return crm_ai_send_to_whatsapp($site_id, $session, $message);
           
        case 'viber':
            return crm_ai_send_to_viber($site_id, $session, $message);
           
        case 'telegram':
        default:
            return crm_ai_send_to_telegram($site_id, $session, $message);
    }
}