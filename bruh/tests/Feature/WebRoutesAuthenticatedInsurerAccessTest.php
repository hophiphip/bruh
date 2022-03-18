<?php

namespace Tests\Feature;

use App\Models\Insurer;
use App\Models\User;
use App\Providers\RouteServiceProvider;

// TODO: Need to find a better way to test log-in/sign-in mb.use Cypres

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->user->insurer()->save(Insurer::factory()->create());
});

afterEach(function () {
    $this->user->insurer()->firstOrFail()->delete();
    $this->user->delete();
});

it('has access to home page for authenticated insurer', function () {
    actingAs($this->user)->get(RouteServiceProvider::HOME)->assertStatus(200)->assertSee('bruh!');
});

/* All the logging in must be done via link in email so this test will fail */
it('has no access to insurer page for authenticated user without email link', function () {
   actingAs($this->user)->get(RouteServiceProvider::INSURER)->assertStatus(403);
});
