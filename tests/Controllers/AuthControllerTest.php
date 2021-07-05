<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\TestCase;

class AuthControllerTest extends TestCase
{
    // use DatabaseMigrations;

    public function createApplication()
    {
        return require './bootstrap/app.php';
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testUserCanLoginWithCorrectCredentials()
    {
        $this->artisan('passport:install');
        $create = User::factory()->create();
        $user = [
            'email' => $create->email,
            'password' => 'midias123'
        ];

        $request = $this->post(route('login'), $user);
        $request->assertResponseStatus(200);
        $request->seeJsonStructure(['access_token', 'expires_at', 'user']);
    }

    public function testUserCannotLoginWithWrongPassword()
    {

        $user = User::factory()->create();
        $normal = [
            'email' => $user->email,
            'password' => 'senhaerrada'
        ];

        $request = $this->post(route('login'), $normal);
        $request->assertResponseStatus(401);
        $request->seeJson(['errors' => 'Invalid credentials']);
    }

    public function testUserCannotLoginWithEmailThatDoesNotExist()
    {
        $created = User::factory()->create();
        $user = [
            'email' => 'abc@mail.com',
            'password' => $created->password,
        ];

        $request = $this->post(route('login'), $user);
        $request->assertResponseStatus(401);
        $request->seeJson(['errors' => 'Invalid credentials']);
    }
}
