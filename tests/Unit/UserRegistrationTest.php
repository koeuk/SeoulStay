<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a default UserType for testing
        UserType::create([
            'uuid' => $this->faker->uuid,
            'name' => 'Traveler'
        ]);
    }

    /**
     * Test successful user registration.
     *
     * @return void
     */
    public function test_user_can_register_successfully()
    {
        $userData = [
            'username' => 'testuser123',
            'full_name' => 'Test User',
            'gender' => 'Male',
            'family_count' => 2,
            'birth_date' => '1990-01-01',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => true,
        ];

        $response = $this->post('/register', $userData);

        // Assert user was created
        $this->assertDatabaseHas('users', [
            'username' => 'testuser123',
            'full_name' => 'Test User',
            'gender' => 'Male',
            'family_count' => 2,
        ]);

        // Assert user was redirected to dashboard
        $response->assertRedirect('/dashboard');
        
        // Assert user is authenticated
        $this->assertAuthenticated();
        
        // Clean up - remove the created user
        User::where('username', 'testuser123')->delete();
    }

    /**
     * Test registration fails with invalid data.
     *
     * @return void
     */
    public function test_registration_fails_with_invalid_data()
    {
        $userData = [
            'username' => '', // Empty username
            'full_name' => '',
            'gender' => 'InvalidGender',
            'family_count' => -1, // Invalid family count
            'birth_date' => '2030-01-01', // Future date
            'password' => '123', // Too short password
            'password_confirmation' => '456', // Mismatched password
            'terms' => false, // Terms not accepted
        ];

        $response = $this->post('/register', $userData);

        // Assert validation errors
        $response->assertSessionHasErrors([
            'username',
            'full_name', 
            'gender',
            'family_count',
            'birth_date',
            'password',
            'terms'
        ]);
        
        // Assert user was not created
        $this->assertDatabaseMissing('users', [
            'username' => ''
        ]);
    }

    /**
     * Test registration fails with duplicate username.
     *
     * @return void
     */
    public function test_registration_fails_with_duplicate_username()
    {
        // Create existing user
        $existingUser = User::create([
            'uuid' => $this->faker->uuid,
            'user_type_id' => UserType::first()->id,
            'username' => 'existinguser',
            'email' => 'existing@seoulstay.com',
            'password' => Hash::make('password123'),
            'full_name' => 'Existing User',
            'name' => 'Existing User',
            'gender' => 'Female',
            'birth_date' => '1985-06-15',
            'family_count' => 1,
            'email_verified_at' => now(),
        ]);

        $userData = [
            'username' => 'existinguser', // Duplicate username
            'full_name' => 'New User',
            'gender' => 'Male',
            'family_count' => 3,
            'birth_date' => '1992-03-20',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => true,
        ];

        $response = $this->post('/register', $userData);

        // Assert validation error for username
        $response->assertSessionHasErrors(['username']);
        
        // Assert only one user with this username exists
        $this->assertEquals(1, User::where('username', 'existinguser')->count());
        
        // Clean up
        $existingUser->delete();
    }

    /**
     * Test password must be at least 5 characters.
     *
     * @return void
     */
    public function test_password_must_be_at_least_five_characters()
    {
        $userData = [
            'username' => 'testuser456',
            'full_name' => 'Test User',
            'gender' => 'Female',
            'family_count' => 1,
            'birth_date' => '1988-12-10',
            'password' => '1234', // Too short (4 characters)
            'password_confirmation' => '1234',
            'terms' => true,
        ];

        $response = $this->post('/register', $userData);

        // Assert validation error for password length
        $response->assertSessionHasErrors(['password']);
        
        // Assert user was not created
        $this->assertDatabaseMissing('users', [
            'username' => 'testuser456'
        ]);
    }

    /**
     * Test user registration method creates proper user record.
     *
     * @return void
     */
    public function test_user_registration_method_functionality()
    {
        $userType = UserType::first();
        
        $userData = [
            'username' => 'methodtest',
            'full_name' => 'Method Test User',
            'gender' => 'Male',
            'family_count' => 4,
            'birth_date' => '1995-07-22',
            'password' => 'methodtest123',
        ];

        // Test the User creation functionality directly
        $user = User::create([
            'uuid' => $this->faker->uuid,
            'user_type_id' => $userType->id,
            'username' => $userData['username'],
            'email' => $userData['username'] . '@seoulstay.com',
            'password' => Hash::make($userData['password']),
            'full_name' => $userData['full_name'],
            'name' => $userData['full_name'],
            'gender' => $userData['gender'],
            'birth_date' => $userData['birth_date'],
            'family_count' => $userData['family_count'],
            'email_verified_at' => now(),
        ]);

        // Verify user was created with correct data
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userData['username'], $user->username);
        $this->assertEquals($userData['full_name'], $user->full_name);
        $this->assertEquals($userData['gender'], $user->gender);
        $this->assertEquals($userData['family_count'], $user->family_count);
        $this->assertEquals($userData['birth_date'], $user->birth_date->format('Y-m-d'));
        $this->assertTrue(Hash::check($userData['password'], $user->password));
        
        // Clean up - remove the created user immediately
        $user->delete();
        
        // Verify user was deleted
        $this->assertDatabaseMissing('users', [
            'username' => $userData['username']
        ]);
    }

    /**
     * Test that terms must be accepted for registration.
     *
     * @return void
     */
    public function test_terms_must_be_accepted()
    {
        $userData = [
            'username' => 'termstest',
            'full_name' => 'Terms Test User',
            'gender' => 'Female',
            'family_count' => 2,
            'birth_date' => '1993-04-15',
            'password' => 'termstest123',
            'password_confirmation' => 'termstest123',
            'terms' => false, // Terms not accepted
        ];

        $response = $this->post('/register', $userData);

        // Assert validation error for terms
        $response->assertSessionHasErrors(['terms']);
        
        // Assert user was not created
        $this->assertDatabaseMissing('users', [
            'username' => 'termstest'
        ]);
    }
}