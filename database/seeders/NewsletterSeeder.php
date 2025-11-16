<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewsLetter;
use Faker\Factory as Faker;

class NewsletterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        $sources = ['website', 'lead_form', 'campaign', 'admin', 'manual', 'social_media', 'referral'];
        $firstNames = [
            'John', 'Jane', 'Michael', 'Sarah', 'David', 'Emily', 'Robert', 'Jessica', 'William', 'Ashley',
            'James', 'Amanda', 'Christopher', 'Jennifer', 'Daniel', 'Lisa', 'Matthew', 'Nancy', 'Anthony', 'Karen',
            'Mark', 'Betty', 'Donald', 'Helen', 'Steven', 'Sandra', 'Paul', 'Donna', 'Andrew', 'Carol',
            'Joshua', 'Ruth', 'Kenneth', 'Sharon', 'Kevin', 'Michelle', 'Brian', 'Laura', 'George', 'Sarah',
            'Edward', 'Kimberly', 'Ronald', 'Deborah', 'Timothy', 'Dorothy', 'Jason', 'Lisa', 'Jeffrey', 'Nancy',
            'Ryan', 'Karen', 'Jacob', 'Betty', 'Gary', 'Helen', 'Nicholas', 'Sandra', 'Eric', 'Donna',
            'Jonathan', 'Carol', 'Stephen', 'Ruth', 'Larry', 'Sharon', 'Justin', 'Michelle', 'Scott', 'Laura',
            'Brandon', 'Sarah', 'Benjamin', 'Kimberly', 'Samuel', 'Deborah', 'Gregory', 'Dorothy', 'Alexander', 'Lisa',
            'Patrick', 'Nancy', 'Jack', 'Karen', 'Dennis', 'Betty', 'Jerry', 'Helen', 'Tyler', 'Sandra',
            'Aaron', 'Donna', 'Jose', 'Carol', 'Henry', 'Ruth', 'Adam', 'Sharon', 'Douglas', 'Michelle'
        ];
        
        $lastNames = [
            'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez',
            'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin',
            'Lee', 'Perez', 'Thompson', 'White', 'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson',
            'Walker', 'Young', 'Allen', 'King', 'Wright', 'Scott', 'Torres', 'Nguyen', 'Hill', 'Flores',
            'Green', 'Adams', 'Nelson', 'Baker', 'Hall', 'Rivera', 'Campbell', 'Mitchell', 'Carter', 'Roberts',
            'Gomez', 'Phillips', 'Evans', 'Turner', 'Diaz', 'Parker', 'Cruz', 'Edwards', 'Collins', 'Reyes',
            'Stewart', 'Morris', 'Morales', 'Murphy', 'Cook', 'Rogers', 'Gutierrez', 'Ortiz', 'Morgan', 'Cooper',
            'Peterson', 'Bailey', 'Reed', 'Kelly', 'Howard', 'Ramos', 'Kim', 'Cox', 'Ward', 'Richardson',
            'Watson', 'Brooks', 'Chavez', 'Wood', 'James', 'Bennett', 'Gray', 'Mendoza', 'Ruiz', 'Hughes',
            'Price', 'Alvarez', 'Castillo', 'Sanders', 'Patel', 'Myers', 'Long', 'Ross', 'Foster', 'Jimenez'
        ];
        
        $newsletters = [];
        $usedEmails = [];
        
        for ($i = 0; $i < 100; $i++) {
            $firstName = $faker->randomElement($firstNames);
            $lastName = $faker->randomElement($lastNames);
            $domain = $faker->randomElement(['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'example.com']);
            $email = strtolower($firstName . '.' . $lastName . '@' . $domain);
            
            // Ensure unique emails within the batch
            $counter = 1;
            $originalEmail = $email;
            while (in_array($email, $usedEmails)) {
                $email = str_replace('@', $counter . '@', $originalEmail);
                $counter++;
            }
            
            $usedEmails[] = $email;
            
            $isSubscribed = $faker->boolean(85); // 85% chance of being subscribed
            $createdAt = $faker->dateTimeBetween('-6 months', 'now');
            
            $newsletters[] = [
                'email' => $email,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'is_subscribed' => $isSubscribed,
                'source' => $faker->randomElement($sources),
                'unsubscribe_token' => $faker->uuid(),
                'unsubscribed_at' => $isSubscribed ? null : $faker->dateTimeBetween($createdAt, 'now'),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }
        
        // Insert all newsletters at once for better performance
        NewsLetter::insert($newsletters);
        
        $this->command->info('Created 100 dummy newsletter subscribers successfully!');
    }
}