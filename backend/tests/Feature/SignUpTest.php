<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testReturnsOkWhenRegistrationIsSuccessful(): void
    {
        $response = $this->postJson('/api/user', [
            'name' => 'Tester',
            'username' => 'tester',
            'email' => 'tester@test.com',
            'password' => 'testtest'
        ]);

        $response->assertStatus(200);
    }

    public function testValidationFailsWhenRequestIsEmpty(): void
    {
        $response = $this->postJson('/api/user', []);

        $response->assertStatus(422);
    }

    public function testValidationFailsWhenEmailAlreadyRegistered(): void
    {
        $this->postJson('/api/user', [
            'name' => $this->faker()->name(),
            'username' => $this->faker()->userName(),
            'email' => 'tester@test.com',
            'password' => $this->faker()->password(8)
        ]);

        $response = $this->postJson('/api/user', [
            'name' => $this->faker()->name(),
            'username' => $this->faker()->userName(),
            'email' => 'tester@test.com',
            'password' => $this->faker()->password(8)
        ]);

        $response->assertStatus(422);
    }
}
