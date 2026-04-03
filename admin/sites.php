<?php
/**
 * CRM AI Consultant — Головна сторінка налаштувань сайту
 * Version: 2.6.1
 * Розділені налаштування по каналах
 */

define('CRM_AI_CONSULTANT', true);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '/crm-ai-error.log');

require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';

$sites_dir = dirname(__DIR__) . '/sites';
if (!is_dir($sites_dir)) {
    mkdir($sites_dir, 0755, true);
}

$index_file = dirname(__DIR__) . '/admin/sites.json';
$index = file_exists($index_file) ? json_decode(file_get_contents($index_file), true) ?: [] : [];

// ====================== ЗБЕРЕЖЕННЯ ======================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_site_settings'])) {

    $domain = trim($_POST['domain'] ?? '');
    $site_id = strtolower(preg_replace('/[^a-z0-9]/', '_', $domain));
    $site_id = trim($site_id, '_');
    if (empty($site_id)) $site_id = 'site_' . time();

    $settings = [
        'id'                => $site_id,
        'name'              => trim($_POST['name'] ?? ''),
        'domain'            => $domain,
        'description'       => trim($_POST['description'] ?? ''),
        'enable_chat'       => !empty($_POST['enable_chat']),
        'default_channel'   => $_POST['default_channel'] ?? 'telegram',

        // Загальні налаштування дизайну
        'chat_title'        => trim($_POST['chat_title'] ?? 'AI Consultant'),
        'chat_subtitle'     => trim($_POST['chat_subtitle'] ?? 'Швидка допомога'),
        'bot_icon'          => trim($_POST['bot_icon'] ?? '🤖'),
        'position'          => $_POST['position'] ?? 'right',
        'widget_color'      => $_POST['widget_color'] ?? '#22d3ee',
        'welcome_text'      => trim($_POST['welcome_text'] ?? 'Добрий день! Як я можу допомогти?'),
        'auto_open'         => !empty($_POST['auto_open']),
        'auto_open_delay'   => (int)($_POST['auto_open_delay'] ?? 7000),

        'updated_at'        => date('Y-m-d H:i:s')
    ];

    // Зберігаємо базові налаштування
    $site_file = $sites_dir . '/' . $site_id . '.json';
    file_put_contents($site_file, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // Оновлюємо індекс
    $found = false;
    foreach ($index as &$item) {
        if ($item['id'] === $site_id) {
            $item = ['id' => $site_id, 'name' => $settings['name'], 'domain' => $settings['domain'], 'enable_chat' => $settings['enable_chat']];
            $found = true;
            break;
        }
    }
    if (!$found) {
        $index[] = ['id' => $site_id, 'name' => $settings['name'], 'domain' => $settings['domain'], 'enable_chat' => $settings['enable_chat']];
    }
    file_put_contents($index_file, json_encode($index, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    $success = "✅ Базові налаштування збережено! site_id: " . htmlspecialchars($site_id);
}

// Завантаження даних для редагування
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
    <style>
        .tab-active { background-color: #0ea5e9; color: white; }
    </style>
</head>
<body class="bg-zinc-950 text-zinc-100">

<?php include 'navigation.php'; ?>

<div class="max-w-6xl mx-auto p-8">

    <h1 class="text-4xl font-bold mb-2">Налаштування сайту</h1>
    <p class="text-zinc-400 mb-8">site_id: <strong><?= htmlspecialchars($edit_site['id'] ?? 'Новий сайт') ?></strong></p>

    <?php if (isset($success)): ?>
        <div class="bg-emerald-900 border border-emerald-700 p-4 rounded-2xl mb-8"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" class="bg-zinc-900 rounded-3xl p-10">

        <input type="hidden" name="save_site_settings" value="1">
        <input type="hidden" name="site_id" value="<?= htmlspecialchars($edit_site['id'] ?? '') ?>">

        <!-- Основні налаштування -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div>
                <label class="block text-sm text-zinc-400 mb-2">Назва сайту</label>
                <input type="text" name="name" value="<?= htmlspecialchars($edit_site['name'] ?? '') ?>" required class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
            </div>
            <div>
                <label class="block text-sm text-zinc-400 mb-2">Домен</label>
                <input type="text" name="domain" value="<?= htmlspecialchars($edit_site['domain'] ?? '') ?>" required class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
            </div>
        </div>

        <div class="mb-12">
            <label class="block text-sm text-zinc-400 mb-2">Опис сайту</label>
            <textarea name="description" rows="3" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4"><?= htmlspecialchars($edit_site['description'] ?? '') ?></textarea>
        </div>

        <!-- Вибір каналу -->
        <div class="mb-12">
            <label class="block text-sm text-zinc-400 mb-4">Канал за замовчуванням</label>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4" id="channel-options">
                <!-- Тут будуть радіо-кнопки для каналів -->
                <?php
                $channels = ['telegram', 'openai', 'grok', 'whatsapp', 'viber'];
                foreach ($channels as $ch) {
                    $checked = ($edit_site['default_channel'] ?? 'telegram') === $ch ? 'checked' : '';
                    $icon = $ch === 'telegram' ? 'fab fa-telegram text-blue-400' : 
                           ($ch === 'openai' ? 'fas fa-brain text-purple-400' : 
                           ($ch === 'grok' ? 'fas fa-robot text-orange-400' : 
                           ($ch === 'whatsapp' ? 'fab fa-whatsapp text-green-400' : 'fab fa-viber text-purple-500')));
                    echo "
                    <label class='channel-option flex flex-col items-center gap-3 p-6 bg-zinc-800 hover:bg-zinc-700 rounded-3xl cursor-pointer border-2 transition-all' data-channel='{$ch}'>
                        <i class='{$icon} text-5xl'></i>
                        <span class='font-medium capitalize'>{$ch}</span>
                        <input type='radio' name='default_channel' value='{$ch}' class='hidden' {$checked}>
                    </label>";
                }
                ?>
            </div>
        </div>

        <!-- Табуляція налаштувань каналів -->
        <div class="mb-12">
            <h3 class="text-xl font-medium mb-6">Налаштування каналу</h3>
            
            <?php
            include 'settings_telegram.php';
            include 'settings_openai.php';
            include 'settings_grok.php';
            include 'settings_whatsapp.php';
            include 'settings_viber.php';
            ?>
        </div>

        <!-- Дизайн чату -->
        <div class="border-t border-zinc-700 pt-10">
            <h3 class="text-xl font-medium mb-6">Дизайн чату</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Заголовок</label>
                    <input type="text" name="chat_title" value="<?= htmlspecialchars($edit_site['chat_title'] ?? 'AI Consultant') ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Іконка бота</label>
                    <input type="text" name="bot_icon" value="<?= htmlspecialchars($edit_site['bot_icon'] ?? '🤖') ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 text-3xl text-center">
                </div>
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Позиція</label>
                    <select name="position" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                        <option value="right" <?= ($edit_site['position'] ?? 'right') === 'right' ? 'selected' : '' ?>>Права</option>
                        <option value="left" <?= ($edit_site['position'] ?? 'left') === 'left' ? 'selected' : '' ?>>Ліва</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-12 flex gap-6">
            <button type="submit" class="flex-1 py-5 bg-sky-600 hover:bg-sky-500 rounded-2xl font-bold text-lg">
                💾 Зберегти всі налаштування
            </button>
            <a href="index.php" class="flex-1 py-5 text-center bg-zinc-800 hover:bg-zinc-700 rounded-2xl">Скасувати</a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>

<script>
// Перемикання видимості блоків каналів
document.querySelectorAll('input[name="default_channel"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.channel-settings').forEach(block => block.classList.add('hidden'));
        const channel = this.value;
        const block = document.getElementById('settings_' + channel);
        if (block) block.classList.remove('hidden');
    });
});
</script>

</body>
</html>
