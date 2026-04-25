<?php
/**
 * CRM AI Consultant — Головний файл віджету (MySQL)
 * Version: 4.1
 */

define('CRM_AI_CONSULTANT', true);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';

// ====================== AJAX ОБРОБКА ======================
if (isset($_GET['action']) || isset($_POST['action'])) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    $action   = $_GET['action'] ?? $_POST['action'] ?? '';
    $site_id  = $_GET['site_id'] ?? $_POST['site_id'] ?? '';
    $session  = $_GET['session'] ?? $_POST['session'] ?? '';
    $message  = $_POST['message'] ?? '';

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
$site_id = trim($_GET['site'] ?? '');

if (empty($site_id)) {
    header('Content-Type: text/plain; charset=utf-8');
    die('Використовуйте ?site=ВАШ_SITE_ID');
}

$settings = crm_ai_get_site_settings($site_id);

if (!$settings || empty($settings['enable_chat'])) {
    header('Content-Type: text/plain; charset=utf-8');
    die("Чат вимкнено для цього сайту");
}

// Повний конфіг для чату
$config = [
    'ajax_url'          => 'https://bilohash.com/ai/crm/index.php',
    'site_id'           => $site_id,
    'chat_title'        => $settings['chat_title']        ?? 'AI Consultant',
    'chat_subtitle'     => $settings['chat_subtitle']     ?? 'Швидка допомога',
    'bot_icon'          => $settings['bot_icon']          ?? '🤖',
    'position'          => $settings['position']          ?? 'right',
    'widget_color'      => $settings['widget_color']      ?? '#22d3ee',
    'chat_bg_color'     => $settings['chat_bg_color']     ?? '#0f172a',
    'header_bg_color'   => $settings['header_bg_color']   ?? '#1e2937',
    'user_bubble_color' => $settings['user_bubble_color'] ?? '#22d3ee',
    'bot_bubble_color'  => $settings['bot_bubble_color']  ?? '#334155',
    'welcome_text'      => $settings['welcome_text']      ?? 'Добрий день! Як я можу допомогти вам сьогодні?',
    'auto_open'         => !empty($settings['auto_open']),
    'auto_open_delay'   => (int)($settings['auto_open_delay'] ?? 7000),
];

header('Content-Type: application/javascript; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-cache');

if (ob_get_level()) ob_clean();

echo "window.crmAI = " . json_encode($config, JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT) . ";\n\n";
echo "var script = document.createElement('script');\n";
echo "script.src = 'https://bilohash.com/ai/crm/assets/chat.js?v=4.0';\n";
echo "document.head.appendChild(script);\n";

exit;
?>