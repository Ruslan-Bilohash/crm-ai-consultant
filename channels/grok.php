<?php
/**
 * CRM AI Consultant — Канал Grok (xAI)
 * Version: 2.6.5
 * 
 * Цей файл відповідає за відправку повідомлень через Grok API
 */

if (!defined('CRM_AI_CONSULTANT')) {
    die('Access denied');
}

/**
 * Головна функція відправки повідомлення в Grok
 */
function crm_ai_send_to_grok($site_id, $session, $user_message) {
    
    // 1. Завантажуємо налаштування конкретного сайту
    $site_file = dirname(__DIR__) . '/sites/' . $site_id . '.json';
    if (!file_exists($site_file)) {
        return ['success' => false, 'message' => 'Налаштування сайту не знайдено'];
    }

    $settings = json_decode(file_get_contents($site_file), true);

    $api_key = trim($settings['grok_api_key'] ?? '');
    $model   = trim($settings['ai_model'] ?? 'grok-4-1');
    $system_prompt = trim($settings['grok_system_prompt'] ?? '');

    // 2. Перевіряємо, чи є API ключ
    if (empty($api_key)) {
        // Якщо ключа немає — зберігаємо в історію і повертаємо повідомлення користувачу
        crm_ai_save_message($site_id, $session, $user_message, 'client');
        crm_ai_save_message($site_id, $session, "❌ Grok API ключ не налаштовано", 'bot');
        return ['success' => false, 'message' => 'Grok API ключ не налаштовано'];
    }

    // 3. Формуємо запит до Grok API
    $url = "https://api.x.ai/v1/chat/completions";

    $payload = [
        "model" => $model,
        "messages" => [
            [
                "role" => "system",
                "content" => $system_prompt ?: "Ти — корисний AI-помічник. Відповідай українською мовою, чітко і по суті."
            ],
            [
                "role" => "user",
                "content" => $user_message
            ]
        ],
        "temperature" => (float)($settings['grok_temperature'] ?? 0.8),
        "max_tokens" => 1500
    ];

    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer " . $api_key
    ];

    // 4. Відправляємо запит через cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    // 5. Обробка помилок запиту
    if ($curl_error) {
        error_log("Grok cURL error: " . $curl_error);
        $reply = "Помилка з'єднання з Grok API";
    } 
    elseif ($http_code !== 200) {
        error_log("Grok API HTTP error: " . $http_code . " | Response: " . $response);
        $reply = "Помилка Grok API (код: $http_code)";
    } 
    else {
        $result = json_decode($response, true);
        $reply = $result['choices'][0]['message']['content'] ?? "Вибач, я не зміг сформувати відповідь.";
    }

    // 6. Зберігаємо повідомлення в історію
    crm_ai_save_message($site_id, $session, $user_message, 'client');
    crm_ai_save_message($site_id, $session, $reply, 'bot');

    return [
        'success' => true,
        'message' => $reply
    ];
}
