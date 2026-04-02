<?php
/**
 * CRM AI Consultant — Головна адмін-панель
 * Version: 2.5.5
 * Красивий список сайтів + копіювання коду + статус
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '/crm-ai-error.log');

define('CRM_AI_CONSULTANT', true);

require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';

session_start();

$admin_password = '12345'; // Зміни на сильніший пароль!

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION['crm_ai_admin_logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        if ($_POST['password'] === $admin_password) {
            $_SESSION['crm_ai_admin_logged_in'] = true;
        } else {
            $login_error = "Невірний пароль!";
        }
    }
    if (!isset($_SESSION['crm_ai_admin_logged_in'])) {
        include 'login.php';
        exit;
    }
}

// Завантаження індексу сайтів
$index_file = dirname(__DIR__) . '/admin/sites.json';
$index = file_exists($index_file) ? json_decode(file_get_contents($index_file), true) ?: [] : [];

// Видалення сайту
if (isset($_GET['delete'])) {
    $site_id = $_GET['delete'];
    $index = array_filter($index, fn($s) => $s['id'] !== $site_id);
    file_put_contents($index_file, json_encode(array_values($index), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    $site_file = dirname(__DIR__) . '/sites/' . $site_id . '.json';
    if (file_exists($site_file)) unlink($site_file);
    
    header("Location: index.php");
    exit;
}

// Перевірка підключення коду
if (isset($_GET['check'])) {
    $site_id = $_GET['check'];
    $site_file = dirname(__DIR__) . '/sites/' . $site_id . '.json';
    
    if (file_exists($site_file)) {
        $site = json_decode(file_get_contents($site_file), true);
        $domain = $site['domain'] ?? '';
        
        $is_connected = checkWidgetInstalled($domain, $site_id);
        
        $site['is_connected'] = $is_connected;
        $site['last_check'] = date('Y-m-d H:i:s');
        file_put_contents($site_file, json_encode($site, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
    
    header("Location: index.php");
    exit;
}

/**
 * Реальна перевірка наявності скрипту на сайті
 */
function checkWidgetInstalled($domain, $site_id) {
    if (empty($domain)) return false;
    
    $url = (strpos($domain, 'http') === 0 ? '' : 'https://') . $domain;
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 12);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'CRM-AI-Checker/2.5');
    
    $html = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200 || empty($html)) return false;

    $script = 'https://bilohash.com/ai/crm/index.php?site=' . $site_id;
    return stripos($html, $script) !== false;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM AI Consultant — Адмін-панель</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .site-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .site-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        }
        .copy-btn {
            transition: all 0.3s ease;
        }
        .copy-btn.copied {
            background-color: #10b981 !important;
            color: white !important;
        }
    </style>
</head>
<body class="bg-zinc-950 text-zinc-100 min-h-screen">

<?php include 'navigation.php'; ?>

<div class="max-w-7xl mx-auto p-6 lg:p-10">

    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 mb-12">
        <div>
            <h1 class="text-5xl font-bold tracking-tight">Мої сайти</h1>
            <p class="text-zinc-400 mt-3">Управління та перевірка підключення</p>
        </div>
        <a href="sites.php" 
           class="bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-500 px-8 py-4 rounded-3xl flex items-center gap-3 font-semibold shadow-xl">
            <i class="fas fa-plus"></i> Додати новий сайт
        </a>
    </div>

    <?php if (empty($index)): ?>
        <div class="bg-zinc-900 rounded-3xl p-24 text-center">
            <div class="text-7xl mb-8">📭</div>
            <h3 class="text-3xl font-medium mb-4">Ще немає сайтів</h3>
            <p class="text-zinc-400">Додайте перший сайт, щоб почати роботу</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            <?php foreach ($index as $item): 
                $site_file = dirname(__DIR__) . '/sites/' . $item['id'] . '.json';
                $site = file_exists($site_file) ? json_decode(file_get_contents($site_file), true) : $item;
                
                $is_enabled   = !empty($site['enable_chat']);
                $is_connected = $site['is_connected'] ?? false;
                $last_check   = $site['last_check'] ?? null;
                $channel      = strtoupper($site['default_channel'] ?? 'TELEGRAM');
            ?>
                <div class="site-card bg-zinc-900 border <?= $is_enabled ? 'border-emerald-500' : 'border-red-700' ?> rounded-3xl overflow-hidden">
                    
                    <!-- Header з градієнтом -->
                    <div class="h-2 bg-gradient-to-r from-sky-500 to-blue-500"></div>
                    
                    <div class="p-7">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-bold"><?= htmlspecialchars($site['name']) ?></h3>
                                <p class="text-sky-400 font-mono text-sm"><?= htmlspecialchars($site['domain']) ?></p>
                            </div>
                            <span class="px-4 py-1 text-xs font-medium rounded-full <?= $is_enabled ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white' ?>">
                                <?= $is_enabled ? '● Увімкнено' : '○ Вимкнено' ?>
                            </span>
                        </div>

                        <?php if (!empty($site['description'])): ?>
                            <p class="text-zinc-400 text-sm mt-6 line-clamp-3"><?= htmlspecialchars($site['description']) ?></p>
                        <?php endif; ?>

                        <!-- Код для вставки -->
                        <div class="mt-8 bg-black rounded-2xl p-5 text-xs font-mono text-emerald-300 border border-zinc-800 overflow-x-auto">
                            &lt;script src="https://bilohash.com/ai/crm/index.php?site=<?= htmlspecialchars($site['id']) ?>"&gt;&lt;/script&gt;
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button onclick="copyCode(this, '<?= htmlspecialchars($site['id']) ?>')" 
                                    class="copy-btn flex items-center gap-2 px-6 py-3 bg-zinc-800 hover:bg-zinc-700 rounded-2xl text-sm transition">
                                <i class="fas fa-copy"></i> Скопіювати код
                            </button>
                        </div>

                        <!-- Статус перевірки -->
                        <div class="mt-8 flex items-center justify-between text-sm">
                            <div class="text-zinc-500">
                                <?= $last_check ? 'Перевірено: ' . date('d.m H:i', strtotime($last_check)) : '<span class="text-amber-400">Не перевірялось</span>' ?>
                            </div>
                            <button onclick="window.location.href='?check=<?= urlencode($site['id']) ?>'" 
                                    class="px-6 py-2.5 text-xs rounded-2xl <?= $is_connected ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white' ?>">
                                <?= $is_connected ? '✓ Код присутній' : '✕ Код відсутній' ?>
                            </button>
                        </div>
                    </div>

                    <!-- Нижні кнопки -->
                    <div class="border-t border-zinc-800 grid grid-cols-2">
                        <a href="sites.php?edit=<?= urlencode($site['id']) ?>" 
                           class="py-5 text-center hover:bg-zinc-800 transition font-medium flex items-center justify-center gap-2">
                            <i class="fas fa-edit"></i> Редагувати
                        </a>
						<a href="conversations.php?site=<?= urlencode($site['id']) ?>" 
                               class="py-4 text-center bg-violet-600 hover:bg-violet-500 rounded-2xl text-sm font-medium">
                                📜 Історія
                            </a>
                        <a href="?delete=<?= urlencode($site['id']) ?>" 
                           onclick="return confirm('Видалити сайт повністю?')"
                           class="py-5 text-center hover:bg-red-900/70 transition font-medium flex items-center justify-center gap-2 text-red-400">
                            <i class="fas fa-trash"></i> Видалити
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>

<script>
function copyCode(btn, siteId) {
    const code = `<script src="https://bilohash.com/ai/crm/index.php?site=${siteId}"><\/script>`;
    
    navigator.clipboard.writeText(code).then(() => {
        const original = btn.innerHTML;
        btn.innerHTML = `<i class="fas fa-check"></i> Скопійовано!`;
        btn.classList.add('!bg-emerald-500', '!text-white');
        
        setTimeout(() => {
            btn.innerHTML = original;
            btn.classList.remove('!bg-emerald-500', '!text-white');
        }, 2500);
    });
}
</script>

</body>
</html>