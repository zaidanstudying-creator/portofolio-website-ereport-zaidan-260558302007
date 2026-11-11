<?php

use App\Models\User;

test('custom registration screen can be rendered', function () {
    $this->get(route('register'))->assertOk();
});

test('new users register as warga without email verification', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'Test@Example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'admin',
    ]);

    $response->assertSessionHasNoErrors()->assertRedirect(route('dashboard'));

    $user = User::where('email', 'test@example.com')->firstOrFail();
    expect($user->role)->toBe('warga')
        ->and($user->email_verified_at)->toBeNull();
    $this->assertAuthenticatedAs($user);
});

test('duplicate email addresses are rejected', function () {
    User::factory()->create(['email' => 'test@example.com']);

    $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('email');
});
