<?php
/**
 * CRM AI Consultant — Головний файл (CSP + MIME fix)
 * Version: 2.5.9
 */

define('CRM_AI_CONSULTANT', true);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';

// AJAX обробка
if (isset($_GET['action']) || isset($_POST['action'])) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

    $action  = $_GET['action'] ?? $_POST['action'] ?? '';
    $site_id = $_GET['site_id'] ?? $_POST['site_id'] ?? '';
    $session = $_GET['session'] ?? $_POST['session'] ?? '';
    $message = $_POST['message'] ?? '';

    if ($action === 'crm_ai_send') {
        $result = crm_ai_process_message($site_id, $session, $message);
        echo json_encode($result);
        exit;
    }

    if ($action === 'crm_ai_get_messages') {
        $messages = crm_ai_get_conversation($site_id, $session);
        echo json_encode($messages);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Невідома дія']);
    exit;
}

// === ВІДЖЕТ — повертаємо чистий JavaScript ===
$site_id = $_GET['site'] ?? '';

if (empty($site_id)) {
    header('Content-Type: text/plain');
    die('Використовуйте ?site=ВАШ_SITE_ID');
}

$site_file = __DIR__ . '/sites/' . $site_id . '.json';

if (!file_exists($site_file)) {
    header('Content-Type: text/plain');
    die("Налаштування для site_id '{$site_id}' не знайдено");
}

$settings = json_decode(file_get_contents($site_file), true);

if (empty($settings['enable_chat'])) {
    header('Content-Type: text/plain');
    die("Чат вимкнено для цього сайту");
}

// Встановлюємо правильний MIME-type для JavaScript
header('Content-Type: application/javascript; charset=utf-8');

// Генеруємо конфіг
$config = json_encode([
    'ajax_url'     => 'https://bilohash.com/ai/crm/index.php',
    'site_id'      => $site_id,
    'chat_title'   => $settings['chat_title'] ?? 'AI Consultant',
    'bot_icon'     => $settings['bot_icon'] ?? '🤖',
    'position'     => $settings['position'] ?? 'right',
    'widget_color' => $settings['widget_color'] ?? '#22d3ee'
], JSON_UNESCAPED_UNICODE);

echo "window.crmAI = {$config};\n\n";

// Підключаємо chat.js
echo "(function() {\n";
echo "    const script = document.createElement('script');\n";
echo "    script.src = 'https://bilohash.com/ai/crm/assets/chat.js?v=' + Date.now();\n";
echo "    document.head.appendChild(script);\n";
echo "})();";