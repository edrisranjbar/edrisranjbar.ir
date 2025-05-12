<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test successful contact form submission.
     */
    public function test_can_submit_contact_form(): void
    {
        $contactData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.'
        ];

        $response = $this->postJson('/api/contact', $contactData);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'پیام با موفقیت ارسال شد'
            ]);

        // Verify data was saved to database
        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.',
            'is_read' => false
        ]);
    }

    /**
     * Test form validation failure.
     */
    public function test_validation_fails_with_missing_fields(): void
    {
        // Test with missing email
        $response = $this->postJson('/api/contact', [
            'name' => 'John Doe',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.'
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false
            ])
            ->assertJsonValidationErrors(['email']);

        // Test with missing name
        $response = $this->postJson('/api/contact', [
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.'
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * Test email validation.
     */
    public function test_validation_fails_with_invalid_email(): void
    {
        $response = $this->postJson('/api/contact', [
            'name' => 'John Doe',
            'email' => 'not-an-email',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.'
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Test max length validation.
     */
    public function test_validation_fails_with_too_long_fields(): void
    {
        $response = $this->postJson('/api/contact', [
            'name' => str_repeat('a', 300), // Very long name
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.'
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * Test metadata is saved correctly.
     */
    public function test_metadata_is_saved_correctly(): void
    {
        $this->withServerVariables([
            'REMOTE_ADDR' => '192.168.1.1',
            'HTTP_USER_AGENT' => 'Test User Agent',
        ]);

        $response = $this->postJson('/api/contact', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.'
        ]);

        $response->assertStatus(200);

        $contact = Contact::first();
        $this->assertEquals('192.168.1.1', $contact->ip_address);
        $this->assertEquals('Test User Agent', $contact->user_agent);
    }
    
    /**
     * Test health check endpoint.
     */
    public function test_health_check_endpoint(): void
    {
        $response = $this->getJson('/api/health');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'UP'
            ]);
    }
} 