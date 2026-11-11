<?php

use Illuminate\Support\Facades\Route;

test('two factor authentication routes are not registered', function () {
    expect(Route::has('two-factor.login'))->toBeFalse()
        ->and(Route::has('passkey.login'))->toBeFalse();
});
