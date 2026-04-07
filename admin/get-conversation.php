<?php
/**
 * CRM AI Consultant — AJAX завантаження розмови
 * Version: 2.7.0
 */

define('CRM_AI_CONSULTANT', true);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_GET['file'])) {
    echo '<p class="text-red-400">Файл не вказано</p>';
    exit;
}

$filename = basename($_GET['file']); // захист від шляху
$conversations_dir = __DIR__ . '/../conversations';
$file_path = $conversations_dir . '/' . $filename;

if (!file_exists($file_path)) {
    echo '<p class="text-red-400">Файл не знайдено</p>';
    exit;
}

$messages = json_decode(file_get_contents($file_path), true);

if (!is_array($messages)) {
    echo '<p class="text-red-400">Невірний формат файлу</p>';
    exit;
}
?>

<div class="space-y-4">
    <?php foreach ($messages as $msg): 
        $isClient = ($msg['sender'] ?? $msg['from'] ?? '') === 'client';
    ?>
        <div class="flex <?= $isClient ? 'justify-end' : 'justify-start' ?>">
            <div class="<?= $isClient 
                ? 'bg-cyan-400 text-black' 
                : 'bg-zinc-700 text-white' ?> 
                max-w-[85%] px-5 py-3 rounded-3xl rounded-<?= $isClient ? 'tr' : 'tl' ?>-none">
                <p class="whitespace-pre-wrap"><?= nl2br(htmlspecialchars($msg['content'] ?? $msg['text'] ?? '')) ?></p>
                <p class="text-[10px] opacity-60 mt-1 text-right">
                    <?= date('H:i', strtotime($msg['time'])) ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if (empty($messages)): ?>
    <p class="text-center text-zinc-500 py-10">Розмова порожня</p>
<?php endif; ?>