<?php
/**
 * CRM AI Consultant — Версія системи
 * Version: 4.1
 * 
 * Цей файл використовується тільки для відображення версії в адмін-панелі.
 * Основна версія тепер зберігається в config.php
 */

// Якщо константа вже визначена в config.php — не перевизначаємо
if (!defined('CRM_AI_VERSION')) {
    define('CRM_AI_VERSION', '4.1');
}

if (!defined('CRM_AI_VERSION_DATE')) {
    define('CRM_AI_VERSION_DATE', '2026-04-21');
}
?>