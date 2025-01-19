

<?php

use App\Models\User;
use App\Notifications\NewChirp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;


uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create(['name' => 'John']);
});

// tests follows Arrange/Act/Assert pattern

test('email notification contains correct content/data', function () {
    Notification::fake();

    $otherUser = User::factory()->create(['name' => 'Jane']);

    $this->actingAs($this->user)
        ->post(route('chirps.store'), [
            'message' => 'Testing...'
        ]);

    Notification::assertSentTo(
        $otherUser,
        NewChirp::class,
        function (NewChirp $notification) {
            return $notification->toMail($this->user)->subject === "New Chirp from {$this->user->name}"
                && $notification->toMail($this->user)->greeting === "New Chirp from {$this->user->name}";
        }
    );
});

/* test('a log is created for notification', function () {
    //doen't work, no fake method on Log class
    Log::fake();

    $this->actingAs($this->user)
        ->post(route('chirps.store'), [
            'message' => 'What about new chirp?'
        ]);

    Log::assertLogged(
        'info',
        fn($message) =>
        str_contains($message, 'New Chirp from John')
    );
}); */
