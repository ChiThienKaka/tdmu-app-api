<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModule extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Create clean architecture module';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $folders = [
            "app/Features/Domain/$name/Controllers",
            "app/Features/Domain/$name/Requests",
            "app/Features/Domain/$name/Resources",
            "app/Features/Domain/$name/Services",
            "app/Features/Domain/$name/Models",
            "app/Features/Domain/$name/DTOs",
            "app/Features/Domain/$name/Repositories",
        ];

        foreach ($folders as $folder) {
            File::makeDirectory(
                base_path($folder),
                0755,
                true,
                true
            );
        }

        $this->info("✅ Module {$name} created successfully");
    }
}
