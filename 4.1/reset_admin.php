<?php
/**
 * CRM AI Consultant — Скидання адміністратора
 * Version: 5.3 — Пряме підключення до бази (без $pdo з config.php)
 */

define('CRM_AI_CONSULTANT', true);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '/crm-ai-error.log');

echo '<div style="font-family: system-ui; max-width: 900px; margin: 50px auto; padding: 40px; background: #1f2937; color: #e0f2fe; border-radius: 16px; line-height: 1.7;">';
echo '<h1 style="color: #22d3ee;">🔄 Скидання адміністратора</h1><br>';

// === ПРЯМЕ ПІДКЛЮЧЕННЯ ДО БАЗИ ===
try {
    // Зміни ці дані на свої, якщо config.php не працює
    $host = 'localhost';                    // або IP сервера
    $dbname = 'u762384583_bilohash_aicrm';  // назва твоєї бази
    $username = 'u762384583_bilohash_aicrm';      // твій логін до бази (зазвичай той самий що і в хостингу)
    $password = 'Odifar78@';                         // ←←←← ВСТАВ СЮДИ СВІЙ ПАРОЛЬ ДО БАЗИ ДАНИХ

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo '<div style="background:#166534; padding:15px; border-radius:8px; margin-bottom:20px;">Підключення до бази успішне</div>';

    // Видаляємо старого admin
    $pdo->exec("DELETE FROM admins WHERE username = 'admin'");

    // Новий пароль
    $new_password = '12345';
    $hash = password_hash($new_password, PASSWORD_ARGON2ID);

    $stmt = $pdo->prepare("
        INSERT INTO admins (username, password_hash, full_name, created_at) 
        VALUES (?, ?, ?, NOW())
    ");

    $stmt->execute(['admin', $hash, 'Ruslan Bilohash']);

    echo '<div style="background:#166534; padding:30px; border-radius:12px; margin:30px 0; font-size:1.15em;">';
    echo '✅ Адміністратор успішно скинутий!<br><br>';
    echo '<strong>Логін:</strong> admin<br>';
    echo '<strong>Пароль:</strong> <span style="color:#4ade80; font-size:1.5em;">12345</span><br><br>';
    echo 'Тепер ти можеш увійти.';
    echo '</div>';

    echo '<p style="margin-top:30px;">';
    echo '<a href="login.php" style="display:inline-block; padding:16px 32px; background:#22d3ee; color:#0f172a; font-weight:bold; border-radius:9999px; text-decoration:none;">';
    echo 'Перейти до сторінки входу →';
    echo '</a>';
    echo '</p>';

} catch (PDOException $e) {
    echo '<div style="background:#7f1d1d; color:white; padding:25px; border-radius:12px;">';
    echo '<strong>Помилка підключення до бази:</strong><br>';
    echo htmlspecialchars($e->getMessage());
    echo '<br><br><small>Перевір логін, пароль і назву бази в коді вище.</small>';
    echo '</div>';
}

echo '<br><small style="color:#64748b;">Після входу обов’язково зміни пароль!</small>';
echo '</div>';
?>