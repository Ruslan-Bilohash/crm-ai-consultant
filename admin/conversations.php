<?php
/**
 * CRM AI Consultant — Читалка історії чату
 * Version: 2.5.5
 * Максимально прямий шлях
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/home/u762384583/domains/bilohash.com/public_html/ai/crm-ai-error.log');

define('CRM_AI_CONSULTANT', true);

// Прямий абсолютний шлях до functions.php
require_once '/home/u762384583/domains/bilohash.com/public_html/ai/includes/functions.php';
require_once '/home/u762384583/domains/bilohash.com/public_html/ai/config.php';

session_start();
if (!isset($_SESSION['crm_ai_admin_logged_in'])) {
    header("Location: index.php");
    exit;
}

$site_id = $_GET['site'] ?? '';
if (empty($site_id)) {
    die("Не вказано site_id");
}

// Папка з історіями
$conv_dir = '/home/u762384583/domains/bilohash.com/public_html/ai/conversations';
$files = glob($conv_dir . '/' . $site_id . '_*.json');

$all_conversations = [];
foreach ($files as $file) {
    $content = json_decode(file_get_contents($file), true) ?: [];
    if (!empty($content)) {
        $session_name = basename($file, '.json');
        $all_conversations[$session_name] = $content;
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Історія чату — <?= htmlspecialchars($site_id) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-zinc-950 text-zinc-100">

<?php include 'navigation.php'; ?>

<div class="max-w-6xl mx-auto p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold">Історія чату</h1>
            <p class="text-zinc-400">Сайт: <strong class="font-mono"><?= htmlspecialchars($site_id) ?></strong></p>
        </div>
        <a href="index.php" class="px-6 py-3 bg-zinc-800 hover:bg-zinc-700 rounded-2xl text-sm">← Назад до сайтів</a>
    </div>

    <?php if (empty($all_conversations)): ?>
        <div class="bg-zinc-900 rounded-3xl p-20 text-center">
            <div class="text-6xl mb-6">📭</div>
            <p class="text-2xl text-zinc-400">Історія повідомлень поки що порожня</p>
            <p class="text-zinc-500 mt-4">Надішліть повідомлення в чаті на сайті, щоб з'явилася історія</p>
        </div>
    <?php else: ?>
        <?php foreach ($all_conversations as $session => $messages): ?>
            <div class="mb-12 bg-zinc-900 rounded-3xl p-8">
                <h3 class="text-xl font-medium mb-6 flex items-center gap-3 border-b border-zinc-700 pb-4">
                    <i class="fas fa-clock text-sky-400"></i> 
                    Сесія: <span class="font-mono text-sky-400"><?= htmlspecialchars($session) ?></span>
                </h3>
                
                <div class="space-y-6 max-h-[620px] overflow-y-auto pr-6 custom-scroll">
                    <?php foreach ($messages as $msg): ?>
                        <div class="flex <?= $msg['sender'] === 'client' ? 'justify-end' : 'justify-start' ?>">
                            <div class="<?= $msg['sender'] === 'client' 
                                ? 'bg-sky-600 text-white' 
                                : 'bg-zinc-700 text-zinc-100' ?> 
                                px-6 py-4 rounded-3xl max-w-[78%]">
                                <p class="whitespace-pre-wrap"><?= nl2br(htmlspecialchars($msg['content'])) ?></p>
                                <p class="text-xs opacity-60 mt-3 text-right"><?= htmlspecialchars($msg['time'] ?? '') ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

<style>
.custom-scroll::-webkit-scrollbar { width: 6px; }
.custom-scroll::-webkit-scrollbar-thumb { background: #64748b; border-radius: 3px; }
</style>

</body>
</html>