<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFactoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the Contact factory works correctly.
     */
    public function test_contact_factory_creates_valid_contact(): void
    {
        $contact = Contact::factory()->create();
        
        $this->assertNotNull($contact->id);
        $this->assertNotEmpty($contact->name);
        $this->assertNotEmpty($contact->email);
        $this->assertNotEmpty($contact->subject);
        $this->assertNotEmpty($contact->message);
        $this->assertNotNull($contact->ip_address);
        $this->assertNotNull($contact->user_agent);
        $this->assertIsBool($contact->is_read);
    }

    /**
     * Test that the Contact factory read state works.
     */
    public function test_contact_factory_read_state(): void
    {
        $readContact = Contact::factory()->read()->create();
        $this->assertTrue($readContact->is_read);
        
        $unreadContact = Contact::factory()->unread()->create();
        $this->assertFalse($unreadContact->is_read);
    }
    
    /**
     * Test Contact seeder.
     */
    public function test_contact_seeder_creates_expected_records(): void
    {
        // Call the seeder
        $this->seed(\Database\Seeders\ContactSeeder::class);
        
        // Check that test contact exists
        $testContact = Contact::where('email', 'test@example.com')->first();
        $this->assertNotNull($testContact);
        $this->assertEquals('Test User', $testContact->name);
        $this->assertEquals('Test Subject', $testContact->subject);
        $this->assertFalse($testContact->is_read);
        
        // Check unread contact count - just verify it's greater than or equal to expected minimum
        $this->assertGreaterThanOrEqual(6, Contact::unread()->count());
    }
} 