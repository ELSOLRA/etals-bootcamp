<?php

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
/* use Inertia\Testing\AssertableInertia as Assert; */

/** @var \Illuminate\Foundation\Testing\TestCase $this */


uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('able to create chirp', function () {

    $chirpData = Chirp::factory()
        ->for($this->user)
        ->make()
        ->toArray();

    $response = $this->actingAs($this->user)->post(route('chirps.store'), $chirpData);

    expect(Chirp::where([
        'message' => $chirpData['message'],
        'user_id' => $this->user->id
    ])->exists())->toBeTrue();

    $response->assertRedirect(route('chirps.index'));
});

test('user cannot create chirp with empty message', function () {

    $chirpData = Chirp::factory()
        ->for($this->user)
        ->make(['message' => ''])
        ->toArray();

    $response = $this->actingAs($this->user)->post(route('chirps.store'), $chirpData);

    $response->assertInvalid(['message']);
});

test('user can update own chirp', function () {
    $chirp = Chirp::factory()
        ->for($this->user)
        ->create();

    $newMessage = 'Updated message';

    $response = $this->actingAs($this->user)->put(route('chirps.update', $chirp), [
        'message' => $newMessage
    ]);

    expect(Chirp::find($chirp->id)->message)->toBe($newMessage);
    $response->assertRedirect(route('chirps.index'));
});

test('user cannot update other users chirps', function () {

    $chirp = Chirp::factory()
        ->for(User::factory())
        ->create();

    $response = $this->actingAs($this->user)->put(route('chirps.update', $chirp), [
        'message' => 'Trying to update...'
    ]);

    $response->assertForbidden();
});

test('a chirp can be delete by owner', function () {
    $chirp = Chirp::factory()
        ->for($this->user)
        ->create();

    $response = $this->actingAs($this->user)->delete(route('chirps.destroy', $chirp));

    expect(Chirp::find($chirp->id))->toBeNull();
    $response->assertRedirect(route('chirps.index'));
});

test('a chirp owned by other user cannot be deleted', function () {
    $chirp = Chirp::factory()
        ->for(User::factory())
        ->create();

    $response = $this->actingAs($this->user)->delete(route('chirps.destroy', $chirp));

    /* expect($response->status())->toBe(403); */
    $response->assertForbidden();
    expect(Chirp::find($chirp->id))->not->toBeNull();
});

/* test('signin user can see all chirps in index page', function () {

    Chirp::factory()
        ->count(3)
        ->for($this->user)
        ->create();


    $response = $this->actingAs($this->user)
        ->get('/chirps')
        ->assertOk();

    expect(Chirp::count())->toBe(3);
});
 */