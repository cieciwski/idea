<?php

use App\Models\User;
use App\Notifications\EmailChanged;
use Illuminate\Support\Facades\Notification;

it('requires authentication', function () {
    $this->get('/profile/edit')->assertRedirect('/login');
});

it('edits a profile', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/profile/edit')
        ->assertSee($user->name);

    $this->actingAs($user)
        ->patch('/profile', [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'password' => null,
        ])
        ->assertSessionHas('success', 'Profile updated!');

    expect($user->fresh())
        ->name->toBe('New Name')
        ->email->toBe('new@example.com');
});

it('notifies the original email if changed', function () {
    Notification::fake();

    $user = User::factory()->create(['email' => 'old@example.com']);

    $this->actingAs($user)
        ->patch('/profile', [
            'name' => $user->name,
            'email' => 'new@example.com',
            'password' => null,
        ]);

    Notification::assertSentOnDemand(
        EmailChanged::class,
        function ($notification, $channels, $notifiable) {
            return $notifiable->routes['mail'] === 'old@example.com';
        }
    );
});
