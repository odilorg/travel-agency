<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramNotifier
{
    public function enabled(): bool
    {
        return (bool) (config('services.telegram.bot_token') && config('services.telegram.chat_id'));
    }

    public function send(string $text): void
    {
        if (!$this->enabled()) {
            return;
        }
        $token = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');
        try {
            Http::asForm()->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ]);
        } catch (\Throwable $e) {
            \Log::error('Telegram notify failed: '.$e->getMessage());
        }
    }
}


