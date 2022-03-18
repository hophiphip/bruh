<?php

namespace Tests\Feature;

/* Tests that do not need mock data */

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Str;

it('has index page accessible to unauthenticated user')->get(RouteServiceProvider::HOME)->assertStatus(200);
it('has offers page accessible to unauthenticated user')->get(RouteServiceProvider::OFFERS)->assertStatus(200);
it('has getting started page accessible to unauthenticated user')->get(RouteServiceProvider::GETTING_STARTED)->assertStatus(200);
it('has login page accessible to unauthenticated user')->get(RouteServiceProvider::LOGIN)->assertStatus(200);
it('has no access to empty login verification to unauthenticated user')->get(RouteServiceProvider::VERIFY_LOGIN)->assertStatus(404);
it('has no access to random login verification to unauthenticated user')->get(RouteServiceProvider::VERIFY_LOGIN . hash('sha256', Str::random(32)))->assertStatus(404);
it('has sign up page accessible to unauthenticated user')->get(RouteServiceProvider::SIGN_UP)->assertStatus(200);
it('has refresh captcha image access to unauthenticated user')->get(RouteServiceProvider::REFRESH_CAPTCHA)->assertStatus(200);
it('has logout page redirect to login page to unauthenticated user')->get(RouteServiceProvider::LOGOUT)->assertRedirect(RouteServiceProvider::LOGIN);
it('has insurer page redirect to getting-started page to unauthenticated user')->get(RouteServiceProvider::INSURER)->assertRedirect(RouteServiceProvider::GETTING_STARTED);
it('has no access to admin page to unauthenticated user')->get(RouteServiceProvider::ADMIN)->assertStatus(403);
it('has no access to offer request publication page without offer specified')->get(RouteServiceProvider::OFFER)->assertStatus(404);
