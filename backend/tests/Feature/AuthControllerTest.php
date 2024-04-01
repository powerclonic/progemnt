<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testValidationFailsOnEmptyRequestForStoreMethod(): void
    {
        $response = $this->postJson('/api/auth', []);

        $response->assertStatus(422);
    }


    public function testValidationFailsWhenRememberFieldIsNotBoolean(): void
    {
        $response = $this->postJson('/api/auth', [
            'identifier' => 'test',
            'password' => 'test',
            'remember' => 'test'
        ]);

        $response->assertStatus(422);
    }

    public function testReturnsUnathourizedWhenIdentifierDoesNotExistInDatabase(): void
    {
        $response = $this->postJson('/api/auth', [
            'identifier' => 'test',
            'password' => 'test',
            'remember' => 0
        ]);

        $response->assertStatus(401);
    }

    public function testReturnsUnathourizedWhenCredentialsAreIncorrect(): void
    {
        User::create([
            'name' => 'Tester',
            'email' => 'test@test.com',
            'username' => 'test',
            'password' => $this->faker()->password(8)
        ]);

        $response = $this->postJson('/api/auth', [
            'identifier' => 'test@test.com',
            'password' => 'test',
            'remember' => 0
        ]);

        $response->assertStatus(401);
    }

    public function testReturnsOkWithAccessTokenAndNameWhenCredentialsAreCorrectUsingEmailAsIdentifier(): void
    {
        $name = $this->faker()->name();
        $password =  $this->faker()->password(8);

        User::create([
            'name' => $name,
            'email' => 'test@test.com',
            'username' => 'test',
            'password' => $password
        ]);

        $response = $this->postJson('/api/auth', [
            'identifier' => 'test@test.com',
            'password' => $password,
            'remember' => 0
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'access_token',
            'name'
        ]);

        $response->assertJsonFragment(['name' => $name]);
    }

    public function testReturnsOkWithAccessTokenAndNameWhenCredentialsAreCorrectUsingUsernameAsIdentifier(): void
    {
        $name = $this->faker()->name();
        $password =  $this->faker()->password(8);

        User::create([
            'name' => $name,
            'email' => 'test@test.com',
            'username' => 'test',
            'password' => $password
        ]);

        $response = $this->postJson('/api/auth', [
            'identifier' => 'test',
            'password' => $password,
            'remember' => 0
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'access_token',
            'name'
        ]);

        $response->assertJsonFragment(['name' => $name]);
    }

    public function testReturnsUnauthorizedWhenAttemptingLogoutWhileNotLoggedIn(): void
    {
        $response = $this->deleteJson('/api/auth');

        $response->assertStatus(401);
    }

    public function testDeletesTokenFromDatabaseAndReturnsOkWhenLoggingOutWhileLoggedIn(): void
    {
        User::create([
            'name' => 'Tester',
            'email' => 'test@test.com',
            'username' => 'test',
            'password' => 'testtest'
        ]);

        $auth = $this->postJson('/api/auth', [
            'identifier' => 'test',
            'password' => 'testtest',
            'remember' => 0
        ]);

        $token = $auth->json('access_token');

        $response = $this->withCredentials()->withToken($token)->deleteJson('/api/auth');

        $response->assertStatus(200);

        $this->assertDatabaseEmpty('personal_access_tokens');
    }
}
