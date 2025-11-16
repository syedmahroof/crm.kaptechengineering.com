<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\HomePageDataSeeder;

class SeedHomePageData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:homepage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with sample data for the home page (destinations and testimonials)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Seeding home page data...');
        
        $seeder = new HomePageDataSeeder();
        $seeder->run();
        
        $this->info('Home page data seeded successfully!');
        $this->info('You can now visit the home page to see the data from the database.');
    }
}