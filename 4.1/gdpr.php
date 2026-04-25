<?php
/**
 * CRM AI Consultant — GDPR Cookie Consent Banner
 * Version: 2.1 — Правильне визначення мови для index.html
 */

// === ВИЗНАЧЕННЯ МОВИ ===
$current_file = basename($_SERVER['PHP_SELF']);

$lang = 'en'; // default English

// Головна сторінка index.html = Українська
if ($current_file === 'index.html' || $current_file === 'index.php') {
    $lang = 'uk';
}
elseif (preg_match('/(ua|uk)/i', $current_file)) $lang = 'uk';
elseif (strpos($current_file, 'ru') !== false) $lang = 'ru';
elseif (strpos($current_file, 'no') !== false) $lang = 'no';
elseif (strpos($current_file, 'lt') !== false) $lang = 'lt';
elseif (strpos($current_file, 'sv') !== false) $lang = 'sv';
elseif (strpos($current_file, 'pl') !== false) $lang = 'pl';
elseif (strpos($current_file, 'de') !== false) $lang = 'de';
?>

<div id="gdpr-banner" class="fixed bottom-0 left-0 right-0 bg-zinc-900 border-t border-zinc-700 z-[9999] hidden">
    <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col md:flex-row items-center justify-between gap-4 text-sm">

        <div class="flex-1 text-zinc-300 leading-relaxed">
            <?php if ($lang === 'uk'): ?>
                Ми використовуємо cookies для покращення роботи сайту. Продовжуючи користування, ви погоджуєтесь з нашою 
                <a href="privacy-policy.php" class="text-sky-400 hover:underline">Політикою конфіденційності</a>.

            <?php elseif ($lang === 'ru'): ?>
                Мы используем cookies для улучшения работы сайта. Продолжая использовать сайт, вы соглашаетесь с нашей 
                <a href="privacy-policy.php" class="text-sky-400 hover:underline">Политикой конфиденциальности</a>.

            <?php elseif ($lang === 'no'): ?>
                Vi bruker cookies for å forbedre opplevelsen din. Ved å fortsette å bruke nettstedet, samtykker du til vår 
                <a href="privacy-policy.php" class="text-sky-400 hover:underline">Personvernpolicy</a>.

            <?php else: // English ?>
                We use cookies to improve your experience on this site. By continuing to use the site, you agree to our 
                <a href="privacy-policy.php" class="text-sky-400 hover:underline">Privacy Policy</a>.
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="acceptAllCookies()" 
                    class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-3 rounded-3xl font-medium transition">
                <?= $lang === 'uk' ? 'Прийняти всі' : 
                    ($lang === 'ru' ? 'Принять все' : 
                    ($lang === 'no' ? 'Godta alle' : 'Accept All')) ?>
            </button>
        </div>
    </div>
</div>

<script>
function acceptAllCookies() {
    localStorage.setItem('cookies_accepted', 'true');
    document.getElementById('gdpr-banner').classList.add('hidden');
}

// Показуємо банер, якщо користувач ще не дав згоду
window.addEventListener('load', () => {
    if (!localStorage.getItem('cookies_accepted')) {
        document.getElementById('gdpr-banner').classList.remove('hidden');
    }
});
</script>