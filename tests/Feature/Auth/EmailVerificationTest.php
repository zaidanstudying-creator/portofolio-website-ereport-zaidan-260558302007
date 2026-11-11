<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

test('email verification is not part of registration or protected routes', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)->get(route('dashboard'))->assertOk();
    $this->actingAs($user)->get(route('profile.edit'))->assertOk();

    expect(Route::has('verification.notice'))->toBeFalse()
        ->and(Route::has('verification.verify'))->toBeFalse();
});
