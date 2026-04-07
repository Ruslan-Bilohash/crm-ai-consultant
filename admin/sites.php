<?php
/**
 * CRM AI Consultant — Налаштування сайту
 * Version: 2.7.0 — Додано welcome_text, auto_open, max_history_messages + покращена адаптивність
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
    $site_id = trim($site_id, '_') ?: 'site_' . time();

    $settings = [
        'id'                  => $site_id,
        'name'                => trim($_POST['name'] ?? ''),
        'domain'              => $domain,
        'description'         => trim($_POST['description'] ?? ''),
        'enable_chat'         => !empty($_POST['enable_chat']),
        'default_channel'     => $_POST['default_channel'] ?? 'telegram',

        // Основні налаштування чату
        'chat_title'          => trim($_POST['chat_title'] ?? 'AI Consultant'),
        'chat_subtitle'       => trim($_POST['chat_subtitle'] ?? 'Швидка допомога'),
        'bot_icon'            => trim($_POST['bot_icon'] ?? '🤖'),
        'position'            => $_POST['position'] ?? 'right',

        // Налаштування кольорів (залишено)
        'widget_color'        => $_POST['widget_color'] ?? '#22d3ee',
        'chat_bg_color'       => $_POST['chat_bg_color'] ?? '#0f172a',
        'header_bg_color'     => $_POST['header_bg_color'] ?? '#1e2937',
        'user_bubble_color'   => $_POST['user_bubble_color'] ?? '#22d3ee',
        'bot_bubble_color'    => $_POST['bot_bubble_color'] ?? '#334155',

        // Нові налаштування
        'welcome_text'        => trim($_POST['welcome_text'] ?? 'Добрий день! Як я можу допомогти вам сьогодні?'),
        'auto_open'           => !empty($_POST['auto_open']),
        'auto_open_delay'     => (int)($_POST['auto_open_delay'] ?? 7000),
        'max_history_messages'=> (int)($_POST['max_history_messages'] ?? 50),

        // Канали
        'telegram_token'      => trim($_POST['telegram_token'] ?? ''),
        'telegram_chat_id'    => trim($_POST['telegram_chat_id'] ?? ''),
        'openai_api_key'      => trim($_POST['openai_api_key'] ?? ''),
        'grok_api_key'        => trim($_POST['grok_api_key'] ?? ''),
        'whatsapp_number'     => trim($_POST['whatsapp_number'] ?? ''),
        'viber_number'        => trim($_POST['viber_number'] ?? ''),

        'updated_at'          => date('Y-m-d H:i:s')
    ];

    $site_file = $sites_dir . '/' . $site_id . '.json';
    file_put_contents($site_file, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // Оновлення індексу
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

    $success = "✅ Налаштування успішно збережено!<br><strong>site_id:</strong> " . htmlspecialchars($site_id);
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
    <p class="text-zinc-400 mb-10">site_id: <strong><?= htmlspecialchars($edit_site['id'] ?? 'Новий сайт') ?></strong></p>

    <?php if (isset($success)): ?>
        <div class="bg-emerald-900 border border-emerald-700 p-4 rounded-2xl mb-8"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" class="bg-zinc-900 rounded-3xl p-10">
        <input type="hidden" name="save_site_settings" value="1">

        <!-- Статус чату -->
        <div class="flex items-center justify-between bg-zinc-800 p-6 rounded-2xl mb-10">
            <span class="text-lg font-medium">Статус чату</span>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="enable_chat" value="1"
                       <?= !empty($edit_site['enable_chat']) ? 'checked' : '' ?>
                       class="sr-only peer">
                <div class="w-14 h-7 bg-zinc-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-500 rounded-full peer peer-checked:bg-emerald-500"></div>
                <span class="ml-4 text-lg font-medium peer-checked:text-emerald-400">
                    <?= !empty($edit_site['enable_chat']) ? '● Увімкнено' : '○ Вимкнено' ?>
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
                <label class="block text-sm text-zinc-400 mb-2">Домен</label>
                <input type="text" name="domain" value="<?= htmlspecialchars($edit_site['domain'] ?? '') ?>" required class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
            </div>
        </div>

        <div class="mt-8">
            <label class="block text-sm text-zinc-400 mb-2">Опис сайту</label>
            <textarea name="description" rows="3" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4"><?= htmlspecialchars($edit_site['description'] ?? '') ?></textarea>
        </div>

        <!-- Канал за замовчуванням -->
        <div class="mt-12">
            <label class="block text-sm text-zinc-400 mb-4">Канал за замовчуванням</label>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <?php
                $channels = ['telegram', 'openai', 'grok', 'whatsapp', 'viber'];
                foreach ($channels as $ch) {
                    $checked = ($edit_site['default_channel'] ?? 'telegram') === $ch ? 'checked' : '';
                    $icon = match($ch) {
                        'telegram' => 'fab fa-telegram text-blue-400',
                        'openai'   => 'fas fa-brain text-purple-400',
                        'grok'     => 'fas fa-robot text-orange-400',
                        'whatsapp' => 'fab fa-whatsapp text-green-400',
                        'viber'    => 'fab fa-viber text-purple-500',
                        default => ''
                    };
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

        <?php
        include 'settings_telegram.php';
        include 'settings_openai.php';
        include 'settings_grok.php';
        include 'settings_whatsapp.php';
        include 'settings_viber.php';
        ?>

        <!-- === НАЛАШТУВАННЯ ЧАТУ === -->
        <div class="mt-14 border-t border-zinc-700 pt-10">
            <h3 class="text-2xl font-semibold mb-8 text-white">Налаштування чату</h3>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                <!-- Привітання -->
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Привітання користувача (перше повідомлення)</label>
                    <textarea name="welcome_text" rows="3"
                              class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4"><?= htmlspecialchars($edit_site['welcome_text'] ?? 'Добрий день! Як я можу допомогти вам сьогодні?') ?></textarea>
                    <p class="text-xs text-zinc-500 mt-2">З’являється автоматично при відкритті чату</p>
                </div>

                <!-- Автовідкриття -->
                <div class="space-y-6">
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="auto_open" value="1"
                                   <?= !empty($edit_site['auto_open']) ? 'checked' : '' ?> class="w-5 h-5">
                            <span class="text-sm font-medium">Автоматично відкривати чат</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Через скільки секунд відкривати чат</label>
                        <div class="flex items-center gap-4">
                            <input type="number" name="auto_open_delay" min="1000" max="30000" step="500"
                                   value="<?= (int)($edit_site['auto_open_delay'] ?? 7000) ?>"
                                   class="w-36 bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 text-center">
                            <span class="text-zinc-400">мілісекунд</span>
                        </div>
                        <p class="text-xs text-zinc-500 mt-1">Рекомендовано: 5000–10000 мс</p>
                    </div>
                </div>

                <!-- Максимальна кількість повідомлень -->
                <div class="lg:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">Максимальна кількість повідомлень в історії</label>
                    <input type="number" name="max_history_messages" min="10" max="200"
                           value="<?= (int)($edit_site['max_history_messages'] ?? 50) ?>"
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>
            </div>

            <!-- Розширений дизайн чату (кольори) -->
            <div class="mt-16 pt-10 border-t border-zinc-700">
                <h3 class="text-xl font-medium mb-6">Зовнішній вигляд чату (кольори)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Заголовок чату</label>
                        <input type="text" name="chat_title" value="<?= htmlspecialchars($edit_site['chat_title'] ?? 'AI Consultant') ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Підзаголовок</label>
                        <input type="text" name="chat_subtitle" value="<?= htmlspecialchars($edit_site['chat_subtitle'] ?? 'Швидка допомога') ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Іконка бота</label>
                        <input type="text" name="bot_icon" value="<?= htmlspecialchars($edit_site['bot_icon'] ?? '🤖') ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 text-3xl text-center">
                    </div>

                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Колір віджету (кнопка)</label>
                        <input type="color" name="widget_color" value="<?= htmlspecialchars($edit_site['widget_color'] ?? '#22d3ee') ?>" class="w-full h-12 bg-zinc-800 border border-zinc-700 rounded-2xl cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Колір фону чату</label>
                        <input type="color" name="chat_bg_color" value="<?= htmlspecialchars($edit_site['chat_bg_color'] ?? '#0f172a') ?>" class="w-full h-12 bg-zinc-800 border border-zinc-700 rounded-2xl cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Колір хедера чату</label>
                        <input type="color" name="header_bg_color" value="<?= htmlspecialchars($edit_site['header_bg_color'] ?? '#1e2937') ?>" class="w-full h-12 bg-zinc-800 border border-zinc-700 rounded-2xl cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Колір бульбашки користувача</label>
                        <input type="color" name="user_bubble_color" value="<?= htmlspecialchars($edit_site['user_bubble_color'] ?? '#22d3ee') ?>" class="w-full h-12 bg-zinc-800 border border-zinc-700 rounded-2xl cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Колір бульбашки бота</label>
                        <input type="color" name="bot_bubble_color" value="<?= htmlspecialchars($edit_site['bot_bubble_color'] ?? '#334155') ?>" class="w-full h-12 bg-zinc-800 border border-zinc-700 rounded-2xl cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Позиція віджету</label>
                        <select name="position" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                            <option value="right" <?= ($edit_site['position'] ?? 'right') === 'right' ? 'selected' : '' ?>>Права сторона</option>
                            <option value="left" <?= ($edit_site['position'] ?? 'left') === 'left' ? 'selected' : '' ?>>Ліва сторона</option>
                        </select>
                    </div>
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
// Перемикання каналів
document.querySelectorAll('input[name="default_channel"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.channel-settings').forEach(block => block.classList.add('hidden'));
        const block = document.getElementById('settings_' + this.value);
        if (block) block.classList.remove('hidden');
    });
});
</script>

</body>
</html>
