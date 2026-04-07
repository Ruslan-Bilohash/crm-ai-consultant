<?php
/**
 * admin/footer.php
 * Сучасний футер адмін-панелі
 * Version: 2.7.0
 */
require_once dirname(__DIR__) . '/version.php';
?>

<footer class="bg-zinc-950 border-t border-zinc-800 mt-auto">
    <div class="max-w-7xl mx-auto px-6 py-16">
        
        <div class="flex flex-col lg:flex-row justify-between items-center gap-12">
          
            <!-- Логотип + опис -->
            <div class="max-w-sm">
                <div class="flex items-center gap-5 mb-6">
                    <div class="w-11 h-11 bg-gradient-to-br from-sky-500 via-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center text-3xl shadow-2xl shadow-sky-500/30">
                        🤖
                    </div>
                    <div>
                        <span class="font-bold text-2xl text-white tracking-tight">CRM AI Consultant</span>
                        <span class="text-emerald-400 text-sm ml-3 font-mono">v<?= CRM_AI_VERSION ?></span>
                    </div>
                </div>
                <p class="text-zinc-400 leading-relaxed">
                    Універсальна система AI-чату з підтримкою Telegram, Grok, OpenAI, 
                    WhatsApp та Viber. Повний контроль над кожним сайтом.
                </p>
            </div>

            <!-- Посилання -->
            <div class="flex flex-wrap justify-center gap-x-10 gap-y-6 text-sm">
                <a href="../documentation.html" 
                   class="flex items-center gap-2 text-zinc-400 hover:text-white transition-all hover:translate-x-1">
                    <i class="fas fa-book"></i>
                    <span>Документація</span>
                </a>
                
                <a href="https://github.com/Ruslan-Bilohash/crm-ai-consultant" 
                   target="_blank"
                   class="flex items-center gap-2 text-zinc-400 hover:text-white transition-all hover:translate-x-1">
                    <i class="fab fa-github"></i>
                    <span>GitHub</span>
                </a>
                
                <a href="https://bilohash.com/" 
                   target="_blank"
                   class="flex items-center gap-2 text-zinc-400 hover:text-white transition-all hover:translate-x-1">
                    <i class="fas fa-globe"></i>
                    <span>bilohash.com</span>
                </a>
            </div>

            <!-- Правий блок -->
            <div class="text-right">
                <p class="text-zinc-400 text-sm">
                    © <?= date('Y') ?> Ruslan Bilohash
                </p>
                <p class="text-zinc-500 text-xs mt-2 font-mono">
                    Universal AI Chat Platform
                </p>
                <div class="mt-6 text-[10px] text-zinc-600">
                    Made with ❤️ for fast and smart customer support
                </div>
            </div>
        </div>

        <!-- Нижній рядок -->
        <div class="mt-16 pt-8 border-t border-zinc-800 text-center">
            <p class="text-zinc-500 text-xs leading-relaxed max-w-2xl mx-auto">
                Потужна система для підключення інтелектуального AI-чату на будь-який сайт 
                з повним контролем, детальною історією спілкування та підтримкою кількох каналів.
            </p>
        </div>

    </div>
</footer>
