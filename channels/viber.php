<?php
/**
 * CRM AI Consultant — Канал Viber
 * Version: 2.6.6 — Робоча версія
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}

function crm_ai_send_to_viber($site_id, $session, $user_message) {
    
    $site_file = dirname(__DIR__) . '/sites/' . $site_id . '.json';
    if (!file_exists($site_file)) {
        return ['success' => false, 'message' => 'Налаштування сайту не знайдено'];
    }

    $settings = json_decode(file_get_contents($site_file), true);

    $viber_number = trim($settings['viber_number'] ?? '');
    $welcome_text = trim($settings['viber_welcome_text'] ?? '');

    crm_ai_save_message($site_id, $session, $user_message, 'client');

    if (!empty($viber_number)) {
        $viber_link = "viber://chat?number=" . urlencode($viber_number);
        
        $reply = ($welcome_text ?: "Я отримав ваше повідомлення!") . "\n\n"
               . "Найшвидше я відповідаю у **Viber**.\n\n"
               . "👉 <a href='{$viber_link}'>Написати мені в Viber</a>";

        crm_ai_save_message($site_id, $session, $reply, 'bot');

        return ['success' => true, 'message' => $reply];
    } else {
        $reply = "Viber канал ще налаштовується.\n\n"
               . "Напишіть мені в **Telegram** — я відповім швидко.";

        crm_ai_save_message($site_id, $session, $reply, 'bot');

        return ['success' => true, 'message' => $reply];
    }
}
