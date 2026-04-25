<?php
/**
 * CRM AI Consultant — Privacy Policy + Cookies Policy
 * Version: 2.4 — Повна юридична версія з cookies та disclaimer
 */

// Визначення мови
$lang = $_GET['lang'] ?? 'en';

if (!isset($_GET['lang'])) {
    $page = basename($_SERVER['PHP_SELF']);
    if (preg_match('/(ua|uk|index)/i', $page)) $lang = 'uk';
    elseif (strpos($page, 'ru') !== false) $lang = 'ru';
    elseif (strpos($page, 'no') !== false) $lang = 'no';
    elseif (strpos($page, 'sv') !== false) $lang = 'sv';
    elseif (strpos($page, 'lt') !== false) $lang = 'lt';
    elseif (strpos($page, 'pl') !== false) $lang = 'pl';
    elseif (strpos($page, 'de') !== false) $lang = 'de';
}
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= match($lang) {
        'uk' => 'Політика конфіденційності',
        'ru' => 'Политика конфиденциальности',
        'no' => 'Personvernpolicy',
        default => 'Privacy Policy'
    } ?> — CRM AI Consultant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-zinc-950 text-zinc-100">

<div class="max-w-4xl mx-auto p-6 lg:p-12">

    <!-- Мовне меню -->
    <div class="flex justify-end mb-10">
        <div class="relative">
            <button onclick="toggleLangMenu()" 
                    class="flex items-center gap-3 bg-zinc-900 hover:bg-zinc-800 px-6 py-3 rounded-3xl border border-zinc-700 text-sm font-medium">
                <span id="current-flag" class="text-3xl">
                    <?= $lang === 'uk' ? '🇺🇦' : ($lang === 'ru' ? '🇷🇺' : ($lang === 'no' ? '🇳🇴' : '🇬🇧')) ?>
                </span>
                <span id="current-lang">
                    <?= match($lang) {
                        'uk' => 'Українська',
                        'ru' => 'Русский',
                        'no' => 'Norsk',
                        default => 'English'
                    } ?>
                </span>
                <i class="fas fa-chevron-down text-xs"></i>
            </button>

            <div id="lang-menu" class="hidden absolute right-0 mt-2 w-64 bg-zinc-900 rounded-3xl shadow-2xl py-2 border border-zinc-700 z-50">
                <a href="?lang=uk" class="flex items-center gap-3 px-6 py-3 hover:bg-zinc-800 <?= $lang==='uk'?'bg-zinc-800':'' ?>">🇺🇦 Українська</a>
                <a href="?lang=ru" class="flex items-center gap-3 px-6 py-3 hover:bg-zinc-800 <?= $lang==='ru'?'bg-zinc-800':'' ?>">🇷🇺 Русский</a>
                <a href="?lang=en" class="flex items-center gap-3 px-6 py-3 hover:bg-zinc-800 <?= $lang==='en'?'bg-zinc-800':'' ?>">🇬🇧 English</a>
                <a href="?lang=no" class="flex items-center gap-3 px-6 py-3 hover:bg-zinc-800 <?= $lang==='no'?'bg-zinc-800':'' ?>">🇳🇴 Norsk</a>
            </div>
        </div>
    </div>

    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold">
            <?= match($lang) {
                'uk' => 'Політика конфіденційності',
                'ru' => 'Политика конфиденциальности',
                'no' => 'Personvernpolicy',
                default => 'Privacy Policy'
            } ?>
        </h1>
        <p class="text-zinc-400 mt-3">CRM AI Consultant</p>
        <p class="text-sm text-zinc-500 mt-4">Останнє оновлення: 25 квітня 2026</p>
    </div>

    <div class="prose prose-invert max-w-none leading-relaxed">

        <?php if ($lang === 'uk'): ?>
            <h2>1. Загальна інформація</h2>
            <p>Ми поважаємо вашу конфіденційність. Ця Політика конфіденційності пояснює, як ми збираємо, використовуємо та захищаємо ваші персональні дані при використанні нашого сайту та AI-чату.</p>

            <h2>2. Cookies та подібні технології</h2>
            <p>Ми використовуємо cookies для:</p>
            <ul>
                <li>Забезпечення коректної роботи сайту та чату</li>
                <li>Запам'ятовування ваших налаштувань (мова, тема тощо)</li>
                <li>Аналізу анонімної статистики відвідувань</li>
                <li>Покращення користувацького досвіду</li>
            </ul>

            <h2>3. Які дані ми збираємо</h2>
            <ul>
                <li>Історію ваших чатів з AI-консультантом</li>
                <li>Технічні дані (IP-адреса, тип браузера, пристрій, час відвідування)</li>
                <li>Cookies (технічні, функціональні, аналітичні)</li>
                <li>Дані, які ви добровільно вказуєте в чаті</li>
            </ul>

            <h2>4. Мета обробки даних</h2>
            <ul>
                <li>Надання послуг AI-чату</li>
                <li>Покращення якості сервісу</li>
                <li>Аналітика використання (анонімна)</li>
                <li>Забезпечення безпеки</li>
            </ul>

            <h2>5. Ваші права (GDPR)</h2>
            <p>Ви маєте право на доступ, виправлення, видалення даних, відкликання згоди тощо.</p>

            <h2 class="text-amber-400 mt-12">⚠️ Відмова від відповідальності</h2>
            <p>Скрипт надається «як є». Автор (Ruslan Bilohash) не несе жодної відповідальності за те, як користувач самостійно встановлює, налаштовує або використовує цей скрипт. Вся відповідальність за встановлення, використання та наслідки лежить виключно на користувачеві.</p>

        <?php elseif ($lang === 'ru'): ?>
            <h2>1. Общая информация</h2>
            <p>Мы уважаем вашу конфиденциальность. Эта Политика конфиденциальности объясняет, как мы собираем, используем и защищаем ваши данные.</p>

            <h2>2. Cookies</h2>
            <p>Мы используем cookies для корректной работы сайта, запоминания настроек и анонимной аналитики.</p>

            <h2 class="text-amber-400 mt-12">⚠️ Отказ от ответственности</h2>
            <p>Скрипт предоставляется «как есть». Автор не несёт никакой ответственности за то, как пользователь самостоятельно устанавливает, настраивает или использует данный скрипт.</p>

        <?php elseif ($lang === 'no'): ?>
    <h2>1. Generell informasjon</h2>
    <p>Vi, Ruslan Bilohash (heretter kalt «Operatøren»), respekterer ditt personvern og er forpliktet til å beskytte dine personopplysninger i henhold til GDPR og norsk personopplysningslov.</p>

    <h2>2. Informasjonskapsler (Cookies) og lignende teknologier</h2>
    <p>Vi bruker cookies for å:</p>
    <ul>
        <li>Sikre at nettstedet og AI-chatten fungerer korrekt</li>
        <li>Huske dine innstillinger (språk, tema osv.)</li>
        <li>Utføre anonym analyse av besøk og brukeratferd</li>
        <li>Forbedre brukeropplevelsen din</li>
    </ul>

    <h2>3. Hvilke opplysninger vi samler inn</h2>
    <ul>
        <li>Chatthistorikk med vår AI-konsulent</li>
        <li>Tekniske data (IP-adresse, nettlesertype, enhetstype, besøkstid)</li>
        <li>Cookies (tekniske, funksjonelle og analytiske)</li>
        <li>Opplysninger du frivillig oppgir i chatten</li>
    </ul>

    <h2>4. Formål med behandlingen av opplysninger</h2>
    <ul>
        <li>Å tilby og levere AI-chat-tjenester</li>
        <li>Å forbedre kvaliteten på tjenesten</li>
        <li>Anonym statistikk og analyse</li>
        <li>Sikkerhet og forebygging av misbruk</li>
    </ul>

    <h2>5. Dine rettigheter</h2>
    <p>Du har rett til å:</p>
    <ul>
        <li>Få innsyn i dine personopplysninger</li>
        <li>Få rettet uriktige opplysninger</li>
        <li>Få slettet dine opplysninger («rett til å bli glemt»)</li>
        <li>Be om begrensning i behandlingen</li>
        <li>Trekke tilbake samtykke når som helst</li>
    </ul>

    <h2 class="text-amber-400 mt-12">⚠️ Ansvarsfraskrivelse</h2>
    <p>Skriptet leveres «som det er» (as is). Forfatteren (Ruslan Bilohash) påtar seg intet ansvar for:</p>
    <ul>
        <li>Problemer som oppstår ved brukerens egen installasjon eller konfigurasjon</li>
        <li>Skader, tap av data eller andre konsekvenser som følge av bruk av skriptet</li>
        <li>Uautorisert bruk av tredjeparter</li>
    </ul>
    <p>Ved bruk av dette skriptet godtar du at all risiko og ansvar for installasjon, konfigurasjon og bruk ligger utelukkende hos deg.</p>


        <?php else: // English ?>
            <h2>1. General Information</h2>
            <p>We respect your privacy and are committed to protecting your personal data in accordance with the General Data Protection Regulation (GDPR) and applicable laws.</p>

            <h2>2. Cookies and Similar Technologies</h2>
            <p>We use cookies to:</p>
            <ul>
                <li>Ensure the proper functioning of the website and chat</li>
                <li>Remember your preferences (language, theme, etc.)</li>
                <li>Analyze anonymous usage statistics</li>
                <li>Improve user experience</li>
            </ul>

            <h2>3. What Data We Collect</h2>
            <ul>
                <li>Chat history with our AI consultant</li>
                <li>Technical data (IP address, browser type, device, visit time)</li>
                <li>Cookies and similar tracking technologies</li>
                <li>Information you voluntarily provide</li>
            </ul>

            <h2>4. Purposes of Processing</h2>
            <ul>
                <li>Providing AI chat services</li>
                <li>Improving our services</li>
                <li>Anonymous analytics</li>
                <li>Security and fraud prevention</li>
            </ul>

            <h2 class="text-amber-400 mt-12">⚠️ Disclaimer of Liability</h2>
            <p>The script is provided "as is". The author (Ruslan Bilohash) assumes no responsibility or liability for:</p>
            <ul>
                <li>Any issues arising from the user's self-installation or configuration</li>
                <li>Any damages, data loss, or other consequences resulting from the use of this script</li>
                <li>Unauthorized use by third parties</li>
            </ul>
            <p>By using this script, you agree that all risk and responsibility for installation, configuration, and usage lies solely with you.</p>
        <?php endif; ?>

    </div>

    <div class="mt-20 text-center text-zinc-500 text-sm border-t border-zinc-800 pt-8">
        © 2026 Ruslan Bilohash • All Rights Reserved
    </div>
</div>

<script>
// Випадаюче меню мов
function toggleLangMenu() {
    document.getElementById('lang-menu').classList.toggle('hidden');
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('button')) {
        document.getElementById('lang-menu').classList.add('hidden');
    }
});
</script>

</body>
</html>