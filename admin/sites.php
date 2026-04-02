<?php
/**
 * CRM AI Consultant — Налаштування сайту
 * Version: 2.5.3
 * site_id = спрощена назва домену (mapsme_no, bilohash_com тощо)
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '/crm-ai-error.log');

define('CRM_AI_CONSULTANT', true);

require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';

// Папка для індивідуальних налаштувань
$sites_dir = dirname(__DIR__) . '/sites';
if (!is_dir($sites_dir)) {
    mkdir($sites_dir, 0755, true);
}

$index_file = dirname(__DIR__) . '/admin/sites.json';
$index = file_exists($index_file) ? json_decode(file_get_contents($index_file), true) ?: [] : [];

// ====================== ЗБЕРЕЖЕННЯ ======================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_site_settings'])) {
    $domain = trim($_POST['domain'] ?? '');
    
    // Генеруємо site_id з домену
    $site_id = strtolower(preg_replace('/[^a-z0-9]/', '_', $domain));
    $site_id = trim($site_id, '_');
    if (empty($site_id)) {
        $site_id = 'site_' . time();
    }

    $settings = [
        'id'                => $site_id,
        'name'              => trim($_POST['name'] ?? ''),
        'domain'            => $domain,
        'description'       => trim($_POST['description'] ?? ''),
        'enable_chat'       => !empty($_POST['enable_chat']),
        'default_channel'   => $_POST['default_channel'] ?? 'telegram',

        'telegram_token'    => trim($_POST['telegram_token'] ?? ''),
        'telegram_chat_id'  => (int)($_POST['telegram_chat_id'] ?? 0),
        'openai_api_key'    => trim($_POST['openai_api_key'] ?? ''),
        'grok_api_key'      => trim($_POST['grok_api_key'] ?? ''),
        'whatsapp_number'   => trim($_POST['whatsapp_number'] ?? ''),
        'viber_number'      => trim($_POST['viber_number'] ?? ''),

        'ai_model'          => in_array($_POST['default_channel'], ['openai', 'grok']) 
                                ? ($_POST['ai_model'] ?? '') : null,

        'chat_title'        => trim($_POST['chat_title'] ?? 'AI Consultant'),
        'chat_subtitle'     => trim($_POST['chat_subtitle'] ?? 'Швидка допомога'),
        'bot_icon'          => trim($_POST['bot_icon'] ?? '🤖'),
        'position'          => $_POST['position'] ?? 'right',
        'widget_color'      => $_POST['widget_color'] ?? '#22d3ee',
        'primary_color'     => $_POST['primary_color'] ?? '#22d3ee',
        'accent_color'      => $_POST['accent_color'] ?? '#06b6d4',
        'chat_bg_color'     => $_POST['chat_bg_color'] ?? '#1e2937',
        'welcome_text'      => trim($_POST['welcome_text'] ?? 'Добрий день! Як я можу допомогти?'),

        'auto_open'         => !empty($_POST['auto_open']),
        'auto_open_delay'   => (int)($_POST['auto_open_delay'] ?? 7000),
        'updated_at'        => date('Y-m-d H:i:s')
    ];

    // Зберігаємо в окремий файл
    $site_file = $sites_dir . '/' . $site_id . '.json';
    file_put_contents($site_file, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // Оновлюємо індекс
    $found = false;
    foreach ($index as &$item) {
        if ($item['id'] === $site_id) {
            $item = [
                'id' => $site_id,
                'name' => $settings['name'],
                'domain' => $settings['domain'],
                'enable_chat' => $settings['enable_chat']
            ];
            $found = true;
            break;
        }
    }
    if (!$found) {
        $index[] = [
            'id' => $site_id,
            'name' => $settings['name'],
            'domain' => $settings['domain'],
            'enable_chat' => $settings['enable_chat']
        ];
    }

    file_put_contents($index_file, json_encode($index, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    $success = "✅ Налаштування збережено!<br><strong>site_id:</strong> " . htmlspecialchars($site_id);
}

// Завантаження для редагування
$edit_site = null;
if (isset($_GET['edit'])) {
    $site_id = $_GET['edit'];
    $site_file = $sites_dir . '/' . $site_id . '.json';
    if (file_exists($site_file)) {
        $edit_site = json_decode(file_get_contents($site_file), true);
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Налаштування сайту — CRM AI Consultant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-zinc-950 text-zinc-100">

<?php include 'navigation.php'; ?>

<div class="max-w-5xl mx-auto p-8">

    <h1 class="text-4xl font-bold mb-2">Налаштування сайту</h1>
    <p class="text-zinc-400 mb-10">site_id генерується автоматично з домену</p>

    <?php if (isset($success)): ?>
        <div class="bg-emerald-900 border border-emerald-700 p-4 rounded-2xl mb-8"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" class="bg-zinc-900 rounded-3xl p-10">
        <input type="hidden" name="save_site_settings" value="1">
        <input type="hidden" name="site_id" value="<?= htmlspecialchars($edit_site['id'] ?? '') ?>">

        <!-- Перемикач Увімкнено / Вимкнено -->
        <div class="flex items-center justify-between bg-zinc-800 p-6 rounded-2xl mb-10">
            <span class="text-lg font-medium">Статус чату</span>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="enable_chat" value="1" 
                       <?= !empty($edit_site['enable_chat']) ? 'checked' : '' ?> 
                       class="sr-only peer">
                <div class="w-14 h-7 bg-zinc-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-500 rounded-full peer peer-checked:bg-emerald-500"></div>
                <span class="ml-4 text-lg font-medium peer-checked:text-emerald-400">
                    <?= !empty($edit_site['enable_chat']) ? 'Увімкнено' : 'Вимкнено' ?>
                </span>
            </label>
        </div>

        <!-- Основна інформація -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label class="block text-sm text-zinc-400 mb-2">Назва сайту</label>
                <input type="text" name="name" value="<?= htmlspecialchars($edit_site['name'] ?? '') ?>" required class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
            </div>
            <div>
                <label class="block text-sm text-zinc-400 mb-2">Домен (example.com)</label>
                <input type="text" name="domain" value="<?= htmlspecialchars($edit_site['domain'] ?? '') ?>" required class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
            </div>
        </div>

        <div class="mt-8">
            <label class="block text-sm text-zinc-400 mb-2">Опис сайту</label>
            <textarea name="description" rows="3" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4"><?= htmlspecialchars($edit_site['description'] ?? '') ?></textarea>
        </div>

        <!-- Канали -->
        <div class="mt-12">
            <label class="block text-sm text-zinc-400 mb-4">Канал за замовчуванням</label>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4" id="channel-options">
                <label class="channel-option flex flex-col items-center gap-3 p-6 bg-zinc-800 hover:bg-zinc-700 rounded-3xl cursor-pointer border-2 transition-all" data-channel="telegram">
                    <i class="fab fa-telegram text-5xl text-blue-400"></i>
                    <span class="font-medium">Telegram</span>
                    <input type="radio" name="default_channel" value="telegram" class="hidden" <?= ($edit_site['default_channel'] ?? 'telegram') === 'telegram' ? 'checked' : '' ?>>
                </label>
                <label class="channel-option flex flex-col items-center gap-3 p-6 bg-zinc-800 hover:bg-zinc-700 rounded-3xl cursor-pointer border-2 transition-all" data-channel="openai">
                    <i class="fas fa-brain text-5xl text-purple-400"></i>
                    <span class="font-medium">OpenAI</span>
                    <input type="radio" name="default_channel" value="openai" class="hidden" <?= ($edit_site['default_channel'] ?? '') === 'openai' ? 'checked' : '' ?>>
                </label>
                <label class="channel-option flex flex-col items-center gap-3 p-6 bg-zinc-800 hover:bg-zinc-700 rounded-3xl cursor-pointer border-2 transition-all" data-channel="grok">
                    <i class="fas fa-robot text-5xl text-orange-400"></i>
                    <span class="font-medium">Grok</span>
                    <input type="radio" name="default_channel" value="grok" class="hidden" <?= ($edit_site['default_channel'] ?? '') === 'grok' ? 'checked' : '' ?>>
                </label>
                <label class="channel-option flex flex-col items-center gap-3 p-6 bg-zinc-800 hover:bg-zinc-700 rounded-3xl cursor-pointer border-2 transition-all" data-channel="whatsapp">
                    <i class="fab fa-whatsapp text-5xl text-green-400"></i>
                    <span class="font-medium">WhatsApp</span>
                    <input type="radio" name="default_channel" value="whatsapp" class="hidden" <?= ($edit_site['default_channel'] ?? '') === 'whatsapp' ? 'checked' : '' ?>>
                </label>
                <label class="channel-option flex flex-col items-center gap-3 p-6 bg-zinc-800 hover:bg-zinc-700 rounded-3xl cursor-pointer border-2 transition-all" data-channel="viber">
                    <i class="fab fa-viber text-5xl text-purple-500"></i>
                    <span class="font-medium">Viber</span>
                    <input type="radio" name="default_channel" value="viber" class="hidden" <?= ($edit_site['default_channel'] ?? '') === 'viber' ? 'checked' : '' ?>>
                </label>
            </div>
        </div>

        <!-- Динамічні API поля -->
        <div class="mt-12 space-y-10" id="api-fields">
            <div id="telegram_fields" class="channel-fields <?= ($edit_site['default_channel'] ?? 'telegram') === 'telegram' ? 'block' : 'hidden' ?>">
                <h3 class="text-lg font-medium mb-4 flex items-center gap-2"><i class="fab fa-telegram"></i> Telegram</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Telegram Bot Token 
                            <a href="https://core.telegram.org/bots#how-do-i-create-a-bot" target="_blank" class="text-sky-400 text-xs ml-2">(отримати)</a>
                        </label>
                        <input type="text" name="telegram_token" value="<?= htmlspecialchars($edit_site['telegram_token'] ?? '') ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 font-mono">
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Telegram Chat ID 
                            <a href="https://t.me/userinfobot" target="_blank" class="text-sky-400 text-xs ml-2">(отримати)</a>
                        </label>
                        <input type="text" name="telegram_chat_id" value="<?= htmlspecialchars($edit_site['telegram_chat_id'] ?? '') ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    </div>
                </div>
            </div>

            <div id="openai_fields" class="channel-fields <?= ($edit_site['default_channel'] ?? '') === 'openai' ? 'block' : 'hidden' ?>">
                <h3 class="text-lg font-medium mb-4 flex items-center gap-2"><i class="fas fa-brain"></i> OpenAI</h3>
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">OpenAI API Key 
                        <a href="https://platform.openai.com/api-keys" target="_blank" class="text-sky-400 text-xs ml-2">(отримати)</a>
                    </label>
                    <input type="text" name="openai_api_key" value="<?= htmlspecialchars($edit_site['openai_api_key'] ?? '') ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 font-mono">
                </div>
            </div>

            <div id="grok_fields" class="channel-fields <?= ($edit_site['default_channel'] ?? '') === 'grok' ? 'block' : 'hidden' ?>">
                <h3 class="text-lg font-medium mb-4 flex items-center gap-2"><i class="fas fa-robot"></i> Grok (xAI)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Grok API Key 
                            <a href="https://x.ai/api" target="_blank" class="text-sky-400 text-xs ml-2">(отримати)</a>
                        </label>
                        <input type="text" name="grok_api_key" value="<?= htmlspecialchars($edit_site['grok_api_key'] ?? '') ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 font-mono">
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Модель Grok</label>
                        <select name="ai_model" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                            <option value="grok-4.20-0309-reasoning" <?= ($edit_site['ai_model'] ?? '') === 'grok-4.20-0309-reasoning' ? 'selected' : '' ?>>grok-4.20-0309-reasoning</option>
                            <option value="grok-4.20-0309-non-reasoning" <?= ($edit_site['ai_model'] ?? '') === 'grok-4.20-0309-non-reasoning' ? 'selected' : '' ?>>grok-4.20-0309-non-reasoning</option>
                            <option value="grok-4.20-multi-agent-0309" <?= ($edit_site['ai_model'] ?? '') === 'grok-4.20-multi-agent-0309' ? 'selected' : '' ?>>grok-4.20-multi-agent-0309</option>
                            <option value="grok-4-1-fast-reasoning" <?= ($edit_site['ai_model'] ?? '') === 'grok-4-1-fast-reasoning' ? 'selected' : '' ?>>grok-4-1-fast-reasoning</option>
                            <option value="grok-4-1-fast-non-reasoning" <?= ($edit_site['ai_model'] ?? '') === 'grok-4-1-fast-non-reasoning' ? 'selected' : '' ?>>grok-4-1-fast-non-reasoning</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="whatsapp_fields" class="channel-fields <?= ($edit_site['default_channel'] ?? '') === 'whatsapp' ? 'block' : 'hidden' ?>">
                <h3 class="text-lg font-medium mb-4 flex items-center gap-2"><i class="fab fa-whatsapp"></i> WhatsApp</h3>
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">WhatsApp Number (Chat API)</label>
                    <input type="text" name="whatsapp_number" value="<?= htmlspecialchars($edit_site['whatsapp_number'] ?? '') ?>" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4" placeholder="+380XXXXXXXXX">
                </div>
            </div>

            <div id="viber_fields" class="channel-fields <?= ($edit_site['default_channel'] ?? '') === 'viber' ? 'block' : 'hidden' ?>">
                <h3 class="text-lg font-medium mb-4 flex items-center gap-2"><i class="fab fa-viber"></i> Viber</h3>
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Viber Number (Chat API)</label>
                    <input type="text" name="viber_number" value="<?= htmlspecialchars($edit_site['viber_number'] ?? '') ?>" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4" placeholder="+380XXXXXXXXX">
                </div>
            </div>
        </div>

        <!-- Дизайн чату -->
        <div class="mt-14 border-t border-zinc-700 pt-10">
            <h3 class="text-xl font-medium mb-6">Зовнішній вигляд чату</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Заголовок чату</label>
                    <input type="text" name="chat_title" value="<?= htmlspecialchars($edit_site['chat_title'] ?? 'AI Consultant') ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Іконка бота</label>
                    <input type="text" name="bot_icon" value="<?= htmlspecialchars($edit_site['bot_icon'] ?? '🤖') ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 text-3xl text-center">
                </div>
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Позиція віджету</label>
                    <select name="position" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                        <option value="right" <?= ($edit_site['position'] ?? 'right') === 'right' ? 'selected' : '' ?>>Права</option>
                        <option value="left" <?= ($edit_site['position'] ?? 'left') === 'left' ? 'selected' : '' ?>>Ліва</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-14 flex gap-6">
            <button type="submit" class="flex-1 py-5 bg-sky-600 hover:bg-sky-500 rounded-2xl font-bold text-lg">
                💾 Зберегти налаштування сайту
            </button>
            <a href="index.php" class="flex-1 py-5 text-center bg-zinc-800 hover:bg-zinc-700 rounded-2xl">Скасувати</a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>

<script>
// Динамічне показування полів залежно від каналу
document.querySelectorAll('input[name="default_channel"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.channel-fields').forEach(field => field.classList.add('hidden'));
        const channel = this.value;
        if (channel === 'telegram') document.getElementById('telegram_fields').classList.remove('hidden');
        if (channel === 'openai') document.getElementById('openai_fields').classList.remove('hidden');
        if (channel === 'grok') document.getElementById('grok_fields').classList.remove('hidden');
        if (channel === 'whatsapp') document.getElementById('whatsapp_fields').classList.remove('hidden');
        if (channel === 'viber') document.getElementById('viber_fields').classList.remove('hidden');
    });
});
</script>

</body>
</html>