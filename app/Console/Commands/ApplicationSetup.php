<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ApplicationSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup {--use-dummy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the application by creating key, running migrations and seeding';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up the application...');

        // Generate key
        Artisan::call('key:generate');
        $this->info('Application key set successfully.');

        // Run migrations
        Artisan::call('migrate');
        $this->info('Migrations run successfully.');

        // Seed database
        Artisan::call('db:seed');
        $this->info('Database seeding completed successfully.');

        // Check if --use-dummy option is set
        if ($this->option('use-dummy')) {
            // Populate DB
            Artisan::call('db:seed', ['--class' => 'DummyDataSeeder']);
            $this->info('Dummy data generated successfully.');
        }

        $this->info('Application setup completed.');

        return 0;
    }
}
