<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\TestCase;

class TransactionControllerTest extends TestCase
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

    public function testShopkeeperCannotTransfer()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create(['role_id' => 'e0cb0a70-dbfb-11eb-8d19-0242ac130003']);
        $user2 = User::factory()->create();
        $transfer = [
            'value' => 10.00,
            'payer_id' => $user->id,
            'payee_id' => $user2->id
        ];
        $request = $this->actingAs($user, 'api')
            ->post(route('transaction'), $transfer);
        $request->assertResponseStatus(403);
        $request->seeJson(["Errors" => 'shopkeeper cannot transfer']);
    }

    public function testUserCannotTransferWithoutBalance()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create(['role_id' => 'b39b20da-dbfb-11eb-8d19-0242ac130003']);
        $user2 = User::factory()->create();
        $transfer = [
            'value' => 10.00,
            'payer_id' => $user->id,
            'payee_id' => $user2->id
        ];
        $request = $this->actingAs($user, 'api')
            ->post(route('transaction'), $transfer);
        $request->assertResponseStatus(422);
        $request->seeJson(['Insuficient Balance']);
    }

    public function testUserCannotTransferZero()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create(['role_id' => 'b39b20da-dbfb-11eb-8d19-0242ac130003']);
        $user2 = User::factory()->create();
        $transfer = [
            'value' => 0.00,
            'payer_id' => $user->id,
            'payee_id' => $user2->id,
        ];
        $request = $this->actingAs($user, 'api')
            ->post(route('transaction'), $transfer);
        $request->assertResponseStatus(403);
        $request->seeJson(['cannot transfer 0']);
    }

    public function testUserCannotTransferToSelf()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create(['role_id' => 'b39b20da-dbfb-11eb-8d19-0242ac130003']);
        $wallet = $user->wallet;
        $wallet->balance = $wallet->balance + 100.00;
        $wallet->save();
        $transfer = [
            'value' => 10.00,
            'payer_id' => $user->id,
            'payee_id' => $user->id
        ];
        $request = $this->actingAs($user, 'api')
            ->post(route('transaction'), $transfer);
        $request->assertResponseStatus(403);
        $request->seeJson(['errors' => 'forbidden to transfer to yourself']);
    }

    public function testUserCanTransfer()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create(['role_id' => 'b39b20da-dbfb-11eb-8d19-0242ac130003']);
        $user2 = User::factory()->create(['role_id' => 'b39b20da-dbfb-11eb-8d19-0242ac130003']);
        $wallet = $user->wallet;
        $wallet->balance = $wallet->balance + 100.00;
        $wallet->save();
        $transfer = [
            'value' => 10.00,
            'payer_id' => $user->id,
            'payee_id' => $user2->id
        ];
        $request = $this->actingAs($user, 'api')
            ->post(route('transaction'), $transfer);
        $request->assertResponseStatus(201);
    }
}
