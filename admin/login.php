<?php if (!defined('CRM_AI_CONSULTANT')) exit; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід — CRM AI Consultant</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-950 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-zinc-900 rounded-3xl p-10">
        <div class="text-center mb-10">
            <div class="mx-auto w-20 h-20 bg-gradient-to-br from-sky-500 to-blue-600 rounded-3xl flex items-center justify-center text-6xl mb-6">🤖</div>
            <h1 class="text-3xl font-bold">CRM AI Consultant</h1>
        </div>

        <?php if (isset($login_error)): ?>
            <div class="bg-red-900/60 border border-red-700 text-red-200 p-4 rounded-2xl mb-6 text-center">
                <?= htmlspecialchars($login_error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="password" name="password" placeholder="Введіть пароль" required
                   class="w-full bg-zinc-800 border border-zinc-700 focus:border-sky-500 rounded-2xl px-6 py-5 text-lg outline-none mb-6">
            <button type="submit" class="w-full py-5 bg-sky-600 hover:bg-sky-500 rounded-2xl font-semibold text-lg">
                Увійти
            </button>
        </form>
    </div>
</body>
</html>