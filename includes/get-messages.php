<?php
/**
 * CRM AI Consultant — Отримання повідомлень (Polling)
 * Version: 2.5.0
 * Працює з простими site_id
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Direct access not allowed');
}

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '/crm-ai-error.log');

require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';

header('Content-Type: application/json; charset=utf-8');

// Перевірка параметрів
$site_id = $_GET['site_id'] ?? '';
$session = $_GET['session'] ?? '';

if (empty($site_id) || empty($session)) {
    echo json_encode([]);
    exit;
}

// Шлях до файлу розмов
$conv_dir = dirname(__DIR__) . '/conversations';
if (!is_dir($conv_dir)) {
    mkdir($conv_dir, 0755, true);
}

$conv_file = $conv_dir . '/' . $site_id . '_' . preg_replace('/[^a-z0-9_]/', '', $session) . '.json';

// Якщо файл не існує — повертаємо порожній масив
if (!file_exists($conv_file)) {
    echo json_encode([]);
    exit;
}

// Завантажуємо повідомлення
$messages = json_decode(file_get_contents($conv_file), true) ?: [];

// Повертаємо тільки масив повідомлень
echo json_encode($messages);
