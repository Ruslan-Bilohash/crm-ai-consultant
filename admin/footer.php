<?php
/**
 * admin/footer.php
 * Сучасний футер з описом скрипту
 */
?>

<footer class="bg-zinc-900 border-t border-zinc-800 mt-auto">
    <div class="max-w-7xl mx-auto px-6 py-12">
        
        <div class="flex flex-col md:flex-row justify-between items-center gap-10">
            
            <!-- Логотип + опис -->
            <div class="max-w-xs">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-sky-500 to-blue-600 rounded-2xl flex items-center justify-center text-2xl shadow-lg">
                        🤖
                    </div>
                    <div>
                        <span class="font-bold text-xl text-white">CRM AI Consultant</span>
                        <span class="text-zinc-500 text-sm ml-2">v2.5.4</span>
                    </div>
                </div>
                <p class="text-zinc-400 text-sm leading-relaxed">
                    Універсальна система AI-чату з підтримкою кількох каналів 
                    та індивідуальними налаштуваннями для кожного сайту.
                </p>
            </div>

            <!-- Посилання -->
            <div class="flex flex-wrap justify-center gap-x-8 gap-y-4 text-sm">
                <a href="../documentation.html" 
                   class="text-zinc-400 hover:text-white transition-colors flex items-center gap-2">
                    <i class="fas fa-book"></i>
                    Документація
                </a>
                <a href="https://github.com/Ruslan-Bilohash/crm-ai-consultant" 
                   target="_blank"
                   class="text-zinc-400 hover:text-white transition-colors flex items-center gap-2">
                    <i class="fab fa-github"></i>
                    GitHub
                </a>
                <a href="https://bilohash.com/" 
                   target="_blank"
                   class="text-zinc-400 hover:text-white transition-colors flex items-center gap-2">
                    <i class="fas fa-globe"></i>
                    bilohash.com
                </a>
            </div>

            <!-- Правий блок -->
            <div class="text-right text-sm">
                <p class="text-zinc-500">
                    © <?= date('Y') ?> Ruslan Bilohash
                </p>
                <p class="text-zinc-600 text-xs mt-1">
                    Universal AI Chat Platform
                </p>
            </div>
        </div>

        <!-- Нижній рядок -->
        <div class="mt-12 pt-8 border-t border-zinc-800 text-center">
            <p class="text-zinc-500 text-xs">
                Система для підключення розумного AI-чату на будь-який сайт з повним контролем та історією спілкування.
            </p>
        </div>

    </div>
</footer>