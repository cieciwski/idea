<?php

use App\Models\User;

it('logs in a user', function () {
    $user = User::factory()->create(['password' => 'password123!#']);

    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', 'password123!#')
        ->click('@login-button')
        ->assertPathIs('/ideas');

    $this->assertAuthenticated();
});

it('registers a user', function () {
    visit('/register')
        ->fill('name', 'Jane Doe')
        ->fill('email', 'jane@example.com')
        ->fill('password', 'password123!@#')
        ->click('@register-button')
        ->assertPathIs('/ideas');

    expect(User::count())->toBe(1);

    $this->assertAuthenticated();
});
