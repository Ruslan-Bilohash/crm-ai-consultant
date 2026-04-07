<?php
/**
 * CRM AI Consultant — Основні допоміжні функції
 * Version: 2.6.5 — Виправлено вибір каналу за замовчуванням
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}

// Підключаємо всі канали явно
require_once dirname(__DIR__) . '/channels/telegram.php';
require_once dirname(__DIR__) . '/channels/openai.php';
require_once dirname(__DIR__) . '/channels/grok.php';
require_once dirname(__DIR__) . '/channels/whatsapp.php';
require_once dirname(__DIR__) . '/channels/viber.php';

function crm_ai_init_conversations_dir() {
    $conv_dir = dirname(__DIR__) . '/conversations';
    if (!is_dir($conv_dir)) {
        mkdir($conv_dir, 0755, true);
    }
    return $conv_dir;
}

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

    if (count($history) > 100) {
        $history = array_slice($history, -100);
    }

    file_put_contents($conv_file, json_encode($history, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function crm_ai_get_conversation($site_id, $session) {
    $conv_dir = crm_ai_init_conversations_dir();
    $safe_session = preg_replace('/[^a-z0-9_]/', '', $session);
    $conv_file = $conv_dir . '/' . $site_id . '_' . $safe_session . '.json';

    if (!file_exists($conv_file)) return [];

    $history = json_decode(file_get_contents($conv_file), true);
    return is_array($history) ? $history : [];
}

/**
 * Головний роутер — ВИПРАВЛЕНО вибір каналу
 */
function crm_ai_process_message($site_id, $session, $message) {
    $site_file = dirname(__DIR__) . '/sites/' . $site_id . '.json';
    if (!file_exists($site_file)) {
        return ['success' => false, 'message' => 'Сайт не знайдено'];
    }

    $settings = json_decode(file_get_contents($site_file), true);
    
    // Беремо канал за замовчуванням з налаштувань сайту
    $channel = strtolower(trim($settings['default_channel'] ?? 'telegram'));

    try {
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
    } catch (Throwable $e) {
        error_log("CRM AI ERROR in process_message(): " . $e->getMessage() . 
                  " | Channel: " . $channel . 
                  " | File: " . $e->getFile() . " | Line: " . $e->getLine());
        
        return ['success' => false, 'message' => 'Внутрішня помилка сервера'];
    }
}
