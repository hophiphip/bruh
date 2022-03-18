<?php

namespace Tests\Feature;

/* Tests that need mock data */

use App\Models\Insurer;
use App\Models\Offer;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Routing\Route;

/* Setup mock user,insurer,offer for testing */
beforeEach(function () {
    $this->offer = Offer::factory()->create();
    $this->insurer = Insurer::factory()->create();
    $this->user = User::factory()->create();

    $this->insurer->offers()->save($this->offer);
    $this->user->insurer()->save($this->insurer);
    $this->user->roles()->sync([ Role::insurerRoleId() ]);
});

/* Cleanup */
afterEach(function () {
    $this->offer->delete();
    $this->insurer->delete();
    $this->user->delete();
});

/* GET */
it('has offer request publication page with specified offer access to unauthenticated user', function() {
    $this->get(RouteServiceProvider::OFFER . '/' . $this->offer->id)->assertStatus(200);
});

/* POST */
it('has captcha protection for login page', function () {
    $this->post(RouteServiceProvider::LOGIN, [
        '_token' => csrf_token(),
        'email' => $this->user->email,
    ])->assertStatus(302);
});

it('has no access to posting a new offer for unauthenticated user', function () {
    $this->post(RouteServiceProvider::INSURER, [
        '_token' => csrf_token(),
        'case_id'     => 1,
        'description' => 'Test',
    ])->assertStatus(302);
});
