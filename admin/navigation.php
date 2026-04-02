<?php
/**
 * admin/navigation.php — Сучасна шапка адмін-панелі
 */
?>

<nav class="bg-zinc-900 border-b border-zinc-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-5">
        <div class="flex items-center justify-between">
            
            <!-- Логотип + назва -->
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-gradient-to-br from-sky-500 via-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center text-3xl shadow-xl shadow-sky-500/30">
                    🤖
                </div>
                <div>
                    <h1 class="text-2xl font-semibold text-white tracking-tight">CRM AI Consultant</h1>
                    <p class="text-[10px] text-zinc-500 font-mono -mt-1">Universal AI Chat Platform</p>
                </div>
            </div>

            <!-- Меню -->
            <div class="flex items-center gap-10 text-sm">
                <a href="index.php" 
                   class="flex items-center gap-2 text-zinc-300 hover:text-white transition-colors <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'text-white font-medium' : '' ?>">
                    <i class="fas fa-home"></i>
                    <span>Сайти</span>
                </a>
                
                <a href="../documentation.html" 
                   target="_blank"
                   class="flex items-center gap-2 text-zinc-300 hover:text-white transition-colors">
                    <i class="fas fa-book"></i>
                    <span>Документація</span>
                </a>
            </div>

            <!-- Правий блок: версія + вихід -->
            <div class="flex items-center gap-6">
                <div class="hidden sm:flex items-center gap-2 text-xs font-mono text-zinc-500 bg-zinc-950 px-3 py-1.5 rounded-xl border border-zinc-700">
                    v2.5.4
                </div>
                
                <a href="?logout=1" 
                   class="flex items-center gap-2 px-5 py-2.5 text-sm text-red-400 hover:text-red-300 hover:bg-red-950/50 rounded-2xl transition-all">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="hidden sm:inline">Вийти</span>
                </a>
            </div>
        </div>
    </div>
</nav>