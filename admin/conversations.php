<?php
/**
 * CRM AI Consultant — Історія розмов
 * Version: 2.6.9
 */

define('CRM_AI_CONSULTANT', true);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '/crm-ai-error.log');

// Правильні шляхи
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/../includes/functions.php';

$conversations_dir = dirname(__DIR__) . '/../conversations';

if (!is_dir($conversations_dir)) {
    mkdir($conversations_dir, 0755, true);
}

// Завантаження розмов
$conversations = [];
$files = glob($conversations_dir . '/*.json');

foreach ($files as $file) {
    $data = json_decode(file_get_contents($file), true);
    if (is_array($data) && !empty($data)) {
        $filename = basename($file);
        if (preg_match('/^(.+?)_s_/', $filename, $matches)) {
            $site_id = $matches[1];
            $last_message = end($data);

            $conversations[] = [
                'file'          => $filename,
                'site_id'       => $site_id,
                'session'       => $filename,
                'message_count' => count($data),
                'last_time'     => $last_message['time'] ?? filemtime($file),
                'last_message'  => $last_message['text'] ?? '',
            ];
        }
    }
}

// Сортування за часом (нові зверху)
usort($conversations, function($a, $b) {
    return $b['last_time'] <=> $a['last_time'];
});
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Історія розмов — CRM AI Consultant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-zinc-950 text-zinc-100">

<?php include 'navigation.php'; ?>

<div class="max-w-7xl mx-auto p-8">
    <h1 class="text-4xl font-bold mb-2">Історія розмов</h1>
    <p class="text-zinc-400 mb-8">Всі чати з відвідувачами</p>

    <?php if (empty($conversations)): ?>
        <div class="bg-zinc-900 rounded-3xl p-20 text-center">
            <div class="text-7xl mb-6">📭</div>
            <h3 class="text-2xl font-medium">Поки немає розмов</h3>
            <p class="text-zinc-400 mt-4">Коли клієнти напишуть у чат — історія з’явиться тут.</p>
        </div>
    <?php else: ?>
        <div class="bg-zinc-900 rounded-3xl overflow-hidden">
            <table class="w-full">
                <thead class="bg-zinc-950">
                    <tr>
                        <th class="px-8 py-5 text-left">Сайт</th>
                        <th class="px-8 py-5 text-left">Повідомлень</th>
                        <th class="px-8 py-5 text-left">Останнє повідомлення</th>
                        <th class="px-8 py-5 text-left">Час</th>
                        <th class="w-40"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($conversations as $conv): ?>
                    <tr class="border-t border-zinc-800 hover:bg-zinc-800">
                        <td class="px-8 py-6 font-medium"><?= htmlspecialchars($conv['site_id']) ?></td>
                        <td class="px-8 py-6"><?= $conv['message_count'] ?></td>
                        <td class="px-8 py-6 text-sm text-zinc-300 truncate max-w-md">
                            <?= htmlspecialchars(mb_substr($conv['last_message'], 0, 80)) ?>...
                        </td>
                        <td class="px-8 py-6 text-sm text-zinc-500">
                            <?= date('d.m.Y H:i', $conv['last_time']) ?>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="view-conversation.php?file=<?= urlencode($conv['file']) ?>" 
                               class="bg-sky-600 hover:bg-sky-500 px-6 py-3 rounded-2xl text-sm inline-block">
                                Переглянути
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

</body>
</html>