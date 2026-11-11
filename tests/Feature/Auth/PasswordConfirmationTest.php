<?php

use Illuminate\Support\Facades\Route;

test('standalone password confirmation route is not registered', function () {
    expect(Route::has('password.confirm'))->toBeFalse();
});
