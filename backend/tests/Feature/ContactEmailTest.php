<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactEmailTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test form submission without actually sending emails.
     * This is a simplified test that doesn't check email sending.
     */
    public function test_can_submit_contact_form(): void
    {
        $contactData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Test Email Subject',
            'message' => 'This is a test message to verify email sending.'
        ];

        $response = $this->postJson('/api/contact', $contactData);
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'پیام با موفقیت ارسال شد'
        ]);
    }

    /**
     * Test that validation errors occur with invalid data
     */
    public function test_validation_fails_with_missing_email(): void
    {
        // Submit an invalid contact form request (missing email)
        $response = $this->postJson('/api/contact', [
            'name' => 'Jane Doe',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    /**
     * Test that data is saved to database correctly
     */
    public function test_contact_data_is_saved_correctly(): void
    {
        $contactData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Test Database Save',
            'message' => 'This message should be saved to the database.'
        ];

        $response = $this->postJson('/api/contact', $contactData);
        $response->assertStatus(200);

        // Check that the data was saved to the database
        $this->assertDatabaseHas('contacts', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Test Database Save',
            'message' => 'This message should be saved to the database.'
        ]);
    }
} 