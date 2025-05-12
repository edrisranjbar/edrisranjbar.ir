<?php

namespace Tests\Unit;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test unread scope.
     */
    public function test_unread_scope(): void
    {
        // Create some contacts with different read statuses
        Contact::factory()->count(3)->create(['is_read' => true]);
        Contact::factory()->count(5)->create(['is_read' => false]);
        
        // Test unread scope
        $unreadContacts = Contact::unread()->get();
        $this->assertCount(5, $unreadContacts);
        $this->assertTrue($unreadContacts->every(fn ($contact) => $contact->is_read === false));
    }

    /**
     * Test markAsRead method.
     */
    public function test_mark_as_read_method(): void
    {
        // Create an unread contact
        $contact = Contact::factory()->create(['is_read' => false]);
        
        // Mark as read
        $result = $contact->markAsRead();
        
        // Assertions
        $this->assertTrue($result);
        $this->assertTrue($contact->is_read);
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'is_read' => true
        ]);
    }

    /**
     * Test fillable attributes.
     */
    public function test_fillable_attributes(): void
    {
        $data = [
            'name' => 'Test Name',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test Message',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Test User Agent',
            'is_read' => false
        ];
        
        $contact = Contact::create($data);
        
        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@example.com', $contact->email);
        $this->assertEquals('Test Subject', $contact->subject);
        $this->assertEquals('Test Message', $contact->message);
        $this->assertEquals('127.0.0.1', $contact->ip_address);
        $this->assertEquals('Test User Agent', $contact->user_agent);
        $this->assertFalse($contact->is_read);
    }

    /**
     * Test datetime casting.
     */
    public function test_datetime_casting(): void
    {
        $contact = Contact::factory()->create();
        
        $this->assertIsObject($contact->created_at);
        $this->assertIsObject($contact->updated_at);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $contact->created_at);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $contact->updated_at);
    }
    
    /**
     * Test boolean casting for is_read.
     */
    public function test_boolean_casting(): void
    {
        // Create with string value
        $contact = Contact::factory()->create(['is_read' => '1']);
        
        // Should be cast to boolean
        $this->assertIsBool($contact->is_read);
        $this->assertTrue($contact->is_read);
        
        // Create with integer
        $contact = Contact::factory()->create(['is_read' => 0]);
        
        // Should be cast to boolean
        $this->assertIsBool($contact->is_read);
        $this->assertFalse($contact->is_read);
    }
} 