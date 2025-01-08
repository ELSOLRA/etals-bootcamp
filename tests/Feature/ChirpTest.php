<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

/** @var \Illuminate\Foundation\Testing\TestCase $this */


uses(RefreshDatabase::class);

test('able to create chirp', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/chirps', [
            'message' => 'Test Chirp'
        ]);


    $response->assertRedirect();


    $this->assertDatabaseHas('chirps', [
        'message' => 'Test Chirp',
        'user_id' => $user->id
    ]);
});

test('cannot create chirp when unauthenticated', function () {
    $response = $this->post('/chirps', [
        'message' => 'Test Chirp'
    ]);

    $response->assertRedirect('/login');
});
