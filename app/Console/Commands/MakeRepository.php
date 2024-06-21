<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path('Repositories');
        if(!File::exists($path)){
            File::makeDirectory($path);
            $this->info('Repositories folder created');
        }
        $file = $path.'/'."{$name}Repository.php";
        if(File::exists($file)){
            $this->warn("\n{$name}Repository already exist!");
            return false;
        }
        File::put($file,"<?php\n\nnamespace App\Repositories;\n\nclass {$name}Repository\n{\n    // Your repository logic here\n}\n");
        $this->info("\n{$name}Repository has been created successfully");
    }
}
