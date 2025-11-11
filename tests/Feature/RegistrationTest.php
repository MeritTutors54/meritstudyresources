<?php

namespace Tests\Feature;

use App\Enums\SubscriptionDuration;
use App\Enums\SubscriptionType;
use App\Enums\UserType;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_register_as_student_with_valid_data(): void
    {
        // To check email uniqueness
        $registrationResponse = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'SecurePassword123!',
            'confirm_password' => 'SecurePassword123!',
        ]);



        if ($registrationResponse->status() === 200) {
            $encrypted = Crypt::encrypt([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'SecurePassword123!',
                'confirm_password' => 'SecurePassword123!',
            ]);

            // User registered as 'student' role
            $response = $this->post('/organize', [
                'data' => $encrypted,
                'type' => UserType::STUDENT->value
            ]);

            // Assert the user was created
            $this->assertDatabaseHas('users', [
                'email' => 'john@example.com',
            ]);

            // Assert a redirect after registration (e.g., to /dashboard)
            $response->assertRedirect('/login');

            $token = UserToken::query()->where('email', 'john@example.com')->first();

            $verification = $this->get('/verification?token=' . $token->token);
            $verification->assertRedirect('/login');
        } else {
            $registrationResponse->assertStatus(302);
            $registrationResponse->assertSessionHasErrors('email');
            $errorMessage = session('errors')->first('email');
            $this->assertEquals('The email has already been taken.', $errorMessage);
        }

    }

    public function test_user_login_as_student_with_valid_data(): void
    {
        $user = User::query()->where('email', 'john@example.com')->first();

        $loginResponse = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'SecurePassword123!',
        ]);

        $loginResponse->assertStatus(302);
        $loginResponse->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }
}
