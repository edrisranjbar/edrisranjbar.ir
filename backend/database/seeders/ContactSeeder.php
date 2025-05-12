<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 25 sample contacts
        Contact::factory(25)->create();
        
        // Create 5 unread contacts for testing
        Contact::factory(5)
            ->unread()
            ->create();
            
        // Create a specific test contact
        Contact::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message for the contact form system.',
            'is_read' => false,
        ]);
    }
} 