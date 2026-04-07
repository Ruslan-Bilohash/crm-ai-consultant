<?php
/**
 * CRM AI Consultant — Головний файл віджету (CSP + MIME fix)
 * Version: 2.6.6 — Фінальна стабільна версія
 */

define('CRM_AI_CONSULTANT', true);

// Очищаємо буфер, якщо він є
if (ob_get_level()) ob_clean();

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';

// ====================== AJAX ======================
if (isset($_GET['action']) || isset($_POST['action'])) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');

    $action  = $_GET['action'] ?? $_POST['action'] ?? '';
    $site_id = $_GET['site_id'] ?? $_POST['site_id'] ?? '';
    $session = $_GET['session'] ?? $_POST['session'] ?? '';
    $message = $_POST['message'] ?? '';

    if ($action === 'crm_ai_send') {
        $result = crm_ai_process_message($site_id, $session, $message);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($action === 'crm_ai_get_messages') {
        $messages = crm_ai_get_conversation($site_id, $session);
        echo json_encode($messages, JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Невідома дія']);
    exit;
}

// ====================== ВІДЖЕТ ======================
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

// === ПРИМУСОВИЙ MIME-TYPE ===
header('Content-Type: application/javascript; charset=utf-8');
header('X-Content-Type-Options: nosniff');

// Очищаємо буфер ще раз
if (ob_get_level()) ob_clean();

$config = json_encode([
    'ajax_url'     => 'https://bilohash.com/ai/crm/index.php',
    'site_id'      => $site_id,
    'chat_title'   => $settings['chat_title'] ?? 'AI Consultant',
    'bot_icon'     => $settings['bot_icon'] ?? '🤖',
    'position'     => $settings['position'] ?? 'right',
    'widget_color' => $settings['widget_color'] ?? '#22d3ee'
], JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT);

echo "window.crmAI = " . $config . ";\n\n";

echo "var script = document.createElement('script');\n";
echo "script.src = 'https://bilohash.com/ai/crm/assets/chat.js?v=' + Date.now();\n";
echo "document.head.appendChild(script);\n";

exit; // Важливо! Нічого більше не виводимо
