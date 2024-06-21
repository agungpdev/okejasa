<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service ${name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $path = app_path('Services');
        if(!File::exists($path)){
            File::makeDirectory($path);
            $this->info('Services folder created');
        }
        $file = $path.'/'."{$name}Service.php";
        if(File::exists($file)){
            $this->warn("\n{$name}Service already exist!");
            return false;
        }
        File::put($file,"<?php\n\nnamespace App\Services;\n\nclass {$name}Service\n{\n    // Your service logic here\n}\n");
        $this->info("{$name}Service has been created successfully");
    }
}
